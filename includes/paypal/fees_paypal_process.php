<?php
include '../session.php';
include '../functions.php';
require 'paypal_class.php';

define('EMAIL_ADD', 'admin@student-portal.co.uk'); // define any notification email
define('PAYPAL_EMAIL_ADD', 'admin-facilitator@student-portal.co.uk'); // facilitator email which will receive payments change this email to a live paypal account id when the site goes live

$p = new paypal_class(); // paypal class
$p->admin_mail = EMAIL_ADD; // set notification email

$payment = $_REQUEST["payment"];

$cmd = '_cart';
$currency_code = 'GBP';
$invoiceid = rand(1111111111,9999999999);
$transactionid = rand(1111111111,9999999999);

$productid = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_STRING);
$product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$product_quantity = filter_input(INPUT_POST, 'product_quantity', FILTER_SANITIZE_STRING);
$product_amount = filter_input(INPUT_POST, 'product_amount', FILTER_SANITIZE_STRING);
$payer_firstname = filter_input(INPUT_POST, 'payer_firstname', FILTER_SANITIZE_STRING);
$payer_surname = filter_input(INPUT_POST, 'payer_surname', FILTER_SANITIZE_STRING);
$payer_email = filter_input(INPUT_POST, 'payer_email', FILTER_SANITIZE_STRING);
$payer_phonenumber = filter_input(INPUT_POST, 'payer_phonenumber', FILTER_SANITIZE_STRING);
$payer_address1 = filter_input(INPUT_POST, 'payer_address1', FILTER_SANITIZE_STRING);
$payer_address2 = filter_input(INPUT_POST, 'payer_address2', FILTER_SANITIZE_STRING);
$payer_town = filter_input(INPUT_POST, 'payer_town', FILTER_SANITIZE_STRING);
$payer_city = filter_input(INPUT_POST, 'payer_city', FILTER_SANITIZE_STRING);
$payer_country = filter_input(INPUT_POST, 'payer_country', FILTER_SANITIZE_STRING);
$payer_postcode = filter_input(INPUT_POST, 'payer_postcode', FILTER_SANITIZE_STRING);

$payment_type = 'fee';
$payment_status = 'pending';

switch($payment){
	case "process": // case process insert the form data in DB and process to the paypal

		$stmt1 = $mysqli->prepare("UPDATE user_detail set address1=?, city=?, postcode=?, country=?, updated_on=? WHERE userid = ? LIMIT 1");
		$stmt1->bind_param('sssssi', $payer_address1, $payer_city, $payer_postcode, $payer_country, $updated_on, $session_userid);
		$stmt1->execute();
		$stmt1->close();

		$stmt2 = $mysqli->prepare("INSERT INTO paypal_log (userid, invoiceid, transactionid, productid, product_name, product_quantity, product_amount, payer_firstname, payer_surname, payer_email, payer_phonenumber, payer_address1, payer_address2, payer_town, payer_city, payer_country, payer_postcode, payment_type, payment_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt2->bind_param('iiiisiisssssssssssss', $session_userid, $invoiceid, $transactionid, $productid, $product_name, $product_quantity, $product_amount, $payer_firstname, $payer_surname, $payer_email, $payer_phonenumber, $payer_address1, $payer_address2, $payer_town, $payer_city, $payer_country, $payer_postcode, $payment_type, $payment_status, $created_on);
		$stmt2->execute();
		$stmt2->close();
		
		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		
		$p->add_field('business', PAYPAL_EMAIL_ADD); // Call the facilitator eaccount
		$p->add_field('cmd', $cmd); // cmd should be _cart for cart checkout
		$p->add_field('upload', '1');
		$p->add_field('return', $this_script.'?payment=success'); // return URL after the transaction got over
		$p->add_field('cancel_return', $this_script.'?payment=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
		$p->add_field('notify_url', $this_script.'?payment=ipn'); // Notify URL which received IPN (Instant Payment Notification)
		$p->add_field('currency_code', $currency_code);
		$p->add_field('invoice', $invoiceid);
		$p->add_field('item_name_1', $product_name);
		$p->add_field('item_number_1', $productid);
		$p->add_field('quantity_1', $product_quantity);
		$p->add_field('amount_1', $product_amount);
		$p->add_field('first_name', $payer_firstname);
		$p->add_field('last_name', $payer_surname);
		$p->add_field('email', $payer_email);
		$p->add_field('night_phone_b', $payer_phonenumber);
		$p->add_field('address1', $payer_address1);
		$p->add_field('city', $payer_city);
		$p->add_field('country', $payer_country);
		$p->add_field('zip', $payer_postcode);
		$p->submit_paypal_post(); // POST it to paypal
		//$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live
	break;
	
	case "success": // success case to show the user payment got success

		include_once 'paypal-success.php';

	break;
	
	case "cancel": // case cancel to show user the transaction was cancelled

		PaypalPaymentCancel();

		include_once 'paypal-cancel.php';
	
	break;
	
	case "ipn": // IPN case to receive payment information. this case will not displayed in browser. This is server to server communication. PayPal will send the transactions each and every details to this case in secured POST menthod by server to server.

	if ($p->validate_ipn()){ // validate the IPN, do the others stuffs here as per your app logic

		FeesPaypalPaymentSuccess();

		$subject = 'Instant Payment Notification - Received Payment';
		$p->send_report($subject); // Send the notification about the transaction
	} else {
		$subject = 'Instant Payment Notification - Payment Fail';
		$p->send_report($subject); // failed notification
	}
	break;
}

