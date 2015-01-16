<?php
include_once 'signin.php';
require_once("paypal_class.php");

date_default_timezone_set('Europe/London');

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

define('EMAIL_ADD', 'contact@sergiu-tripon.com'); // define any notification email
define('PAYPAL_EMAIL_ADD', 'triponsergiu-facilitator@hotmail.co.uk'); // facilitator email which will receive payments change this email to a live paypal account id when the site goes live

$p = new paypal_class(); // paypal class
$p->admin_mail = EMAIL_ADD; // set notification email

$payment = $_REQUEST["payment"];

$cmd = '_cart';
$currency_code = 'GBP';
$invoice_id = rand(1111111111,9999999999);

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_STRING);
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

$payment_status = 'pending';
$created_on = date("Y-m-d G:i:s");
$updated_on = date("Y-m-d G:i:s");

switch($payment){
	case "process": // case process insert the form data in DB and process to the paypal

		$stmt = $mysqli->prepare("UPDATE user_details set address1=?, city=?, postcode=?, country=?, updated_on=? WHERE userid = ? LIMIT 1");
		$stmt->bind_param('sssssi', $payer_address1, $payer_city, $payer_postcode, $payer_country, $updated_on, $userid);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("INSERT INTO paypal_log (userid, invoice_id, product_id, product_name, product_quantity, product_amount, payer_firstname, payer_surname, payer_email, payer_phonenumber, payer_address1, payer_address2, payer_town, payer_city, payer_country, payer_postcode, payment_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('iiisiissssssssssss', $userid, $invoice_id, $product_id, $product_name, $product_quantity, $product_amount, $payer_firstname, $payer_surname, $payer_email, $payer_phonenumber, $payer_address1, $payer_address2, $payer_town, $payer_city, $payer_country, $payer_postcode, $payment_status, $created_on);
		$stmt->execute();
		$stmt->close();
		
		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		
		$p->add_field('business', PAYPAL_EMAIL_ADD); // Call the facilitator eaccount
		$p->add_field('cmd', $cmd); // cmd should be _cart for cart checkout
		$p->add_field('upload', '1');
		$p->add_field('return', $this_script.'?payment=success'); // return URL after the transaction got over
		$p->add_field('cancel_return', $this_script.'?payment=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
		$p->add_field('notify_url', $this_script.'?payment=ipn'); // Notify URL which received IPN (Instant Payment Notification)
		$p->add_field('currency_code', $currency_code);
		$p->add_field('invoice', $invoice_id);
		$p->add_field('item_name_1', $_POST["product_name"]);
		$p->add_field('item_number_1', $_POST["product_id"]);
		$p->add_field('quantity_1', $_POST["product_quantity"]);
		$p->add_field('amount_1', $_POST["product_amount"]);
		$p->add_field('first_name', $_POST["payer_firstname"]);
		$p->add_field('last_name', $_POST["payer_surname"]);
		$p->add_field('email', $_POST["payer_email"]);
		$p->add_field('night_phone_b', $_POST["payer_phonenumber"]);
		$p->add_field('address1', $_POST["payer_address1"]);
		$p->add_field('city', $_POST["payer_city"]);
		$p->add_field('country', $_POST["payer_country"]);
		$p->add_field('zip', $_POST["payer_postcode"]);
		$p->submit_paypal_post(); // POST it to paypal
		//$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live
	break;
	
	case "success": // success case to show the user payment got success

		include_once '../includes/paypal/paypal_success.php';

	break;
	
	case "cancel": // case cancel to show user the transaction was cancelled
	
		$payment_status = 'cancelled';
		$cancelled_on = date("Y-m-d G:i:s");

		$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status = ?, cancelled_on=? WHERE userid = ? ORDER BY created_on DESC LIMIT 1");
		$stmt5->bind_param('ssi', $payment_status, $cancelled_on, $userid);
		$stmt5->execute();
		$stmt5->close();

		include_once '../includes/paypal/paypal_cancel.php';
	
	break;
	
	case "ipn": // IPN case to receive payment information. this case will not displayed in browser. This is server to server communication. PayPal will send the transactions each and every details to this case in secured POST menthod by server to server. 
		$transaction_id  = $_POST["txn_id"];
		$payment_status = strtolower($_POST["payment_status"]);
		$invoice_id = $_POST["invoice"];
		$product_amount = $_POST["mc_gross"];
		
		$completed_on = date("Y-m-d G:i:s");
		
	if ($p->validate_ipn()){ // validate the IPN, do the others stuffs here as per your app logic

		$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoice_id = ? LIMIT 1");
		$stmt1->bind_param('i', $invoice_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($userid);
		$stmt1->fetch();
		$stmt1->close();

		$stmt2 = $mysqli->prepare("SELECT isHalf FROM user_fees WHERE userid = ? LIMIT 1");
		$stmt2->bind_param('i', $userid);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($isHalf);
		$stmt2->fetch();
		$stmt2->close();

		if ($product_amount == '9000.00' AND $isHalf == '0' ) {

		$full_fees = 0.00;
		$updated_on = date("Y-m-d G:i:s");

		$stmt3 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid = ? LIMIT 1");
		$stmt3->bind_param('isi', $full_fees, $updated_on, $userid);
		$stmt3->execute();
		$stmt3->close();

		} else {

		if ($product_amount == '4500.00' AND $isHalf == '1') {

		$half_fees = 4500.00;
		$isHalf = 1;
		$updated_on = date("Y-m-d G:i:s");

		$stmt3 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, isHalf=?, updated_on=? WHERE userid=? LIMIT 1");
		$stmt3->bind_param('iisi', $half_fees, $isHalf, $updated_on, $userid);
		$stmt3->execute();
		$stmt3->close();

		} else {

		$full_fees = 0.00;
		$updated_on = date("Y-m-d G:i:s");

		$stmt4 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid = ? LIMIT 1");
		$stmt4->bind_param('isi', $full_fees, $updated_on, $userid);
		$stmt4->execute();
		$stmt4->close();

		}
		}

		$stmt8 = $mysqli->prepare("UPDATE paypal_log SET transaction_id=?, payment_status =?, completed_on=? WHERE invoice_id =?");
		$stmt8->bind_param('sssi', $transaction_id, $payment_status, $completed_on, $invoice_id);
		$stmt8->execute();
		$stmt8->close();

		$subject = 'Instant Payment Notification - Received Payment';
		$p->send_report($subject); // Send the notification about the transaction
	} else {
		$subject = 'Instant Payment Notification - Payment Fail';
		$p->send_report($subject); // failed notification
	}
	break;
}
?>
