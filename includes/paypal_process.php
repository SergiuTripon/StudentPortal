<?php

/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4
 *  virtual pages depending on the "action" variable passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, as well as the actual class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
require_once('paypal_class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     	// paypal url

// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';

switch ($_GET['action']) {

	case 'process':      // Process and order...

	// There should be no output at this point.  To process the POST data,
	// the submit_paypal_post() function will output all the HTML tags which
	// contains a FORM which is submited instantaneously using the BODY onload
	// attribute.  In other words, don't echo or printf anything when you're
	// going to be calling the submit_paypal_post() function.

	// This is where you would have your form validation  and all that jazz.
	// You would take your POST vars and load them into the class like below,
	// only using the POST values instead of constant string expressions.

	// For example, after ensureing all the POST variables from your custom
	// order form are valid, you might have:
	//
	// $p->add_field('first_name', $_POST['first_name']);
	// $p->add_field('last_name', $_POST['last_name']);

	$stmt = $mysqli->prepare("INSERT INTO paypal_log (userid, isHalf, invoice_id, product_id, product_name, product_quantity, product_amount, payer_firstname, payer_surname, payer_email, payer_phonenumber, payer_address1, payer_address2, payer_town, payer_city, payer_postcode, payment_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('iiiisiisssssssssss', $userid, $isHalf, $invoice_id, $product_id, $product_name, $product_quantity, $product_amount, $payer_firstname, $payer_surname, $payer_email, $payer_phonenumber, $payer_address1, $payer_address2, $payer_town, $payer_city, $payer_postcode, $payment_status, $created_on);
	$stmt->execute();
	$stmt->close();

	$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	$p->add_field('business', PAYPAL_EMAIL_ADD);
	$p->add_field('cmd', $_POST["cmd"]);
	$p->add_field('upload', '1');
	$p->add_field('return', $this_script.'?payment=success');
	$p->add_field('cancel_return', $this_script.'?payment=cancel');
	$p->add_field('notify_url', $this_script.'?payment=ipn');
	$p->add_field('currency_code', $_POST["currency_code"]);
	$p->add_field('invoice', $_POST["invoice_id"]);
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

	$p->submit_paypal_post(); // submit the fields to paypal
	//$p->dump_fields();      // for debugging, output a table of all the fields
	break;

	case 'success':      // Order was successful...

	// This is where you would probably want to thank the user for their order
	// or what have you.  The order information at this point is in POST
	// variables.  However, you don't want to "process" the order until you
	// get validation from the IPN.  That's where you would have the code to
	// email an admin, update the database with payment status, activate a
	// membership, etc.

	$stmt1 = $mysqli->prepare("SELECT isHalf, product_amount FROM paypal_log WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($isHalf, $product_amount);
	$stmt1->fetch();
	$stmt1->close();

	if ($product_amount == '9000.00' ) {

	$full_fees = 0.00;
	$updated_on = date("Y-m-d G:i:s");

	$stmt2 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('isi', $full_fees, $updated_on, $userid);
	$stmt2->execute();
	$stmt2->close();

	include_once '../includes/paypal/paypal_success.php';

	} else {

	if ($product_amount == '4500.00' AND $isHalf == '0' ) {

	$half_fees = 4500.00;
	$isHalf = 1;
	$updated_on = date("Y-m-d G:i:s");

	$stmt3 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
	$stmt3->bind_param('isi', $half_fees, $updated_on, $userid);
	$stmt3->execute();
	$stmt3->close();

	$stmt4 = $mysqli->prepare("UPDATE paypal_log SET isHalf=?, updated_on=? WHERE userid=? LIMIT 1");
	$stmt4->bind_param('isi', $isHalf, $updated_on, $userid);
	$stmt4->execute();
	$stmt4->close();

	include_once '../includes/paypal/paypal_success.php';

	} else {

	$updated_on = date("Y-m-d G:i:s");

	$stmt5 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
	$stmt5->bind_param('isi', $full_fees, $updated_on, $userid);
	$stmt5->execute();
	$stmt5->close();

	include_once '../includes/paypal/paypal_success.php';
	}
	}

	// You could also simply re-direct them to another page, or your own
	// order status page which presents the user with the status of their
	// order based on a database (which can be modified with the IPN code
	// below).

	break;

	case 'cancel':       // Order was canceled...

	// The order was canceled before being completed.

	$payment_status = 'cancelled';
	$cancelled_on = date("Y-m-d G:i:s");

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status=?, cancelled_on=? WHERE userid = ? ORDER BY created_on DESC LIMIT 1");
	$stmt5->bind_param('ssi', $payment_status, $cancelled_on, $userid);
	$stmt5->execute();
	$stmt5->close();

	include_once '../includes/paypal/paypal_cancel.php';

	break;

	case 'ipn':          // Paypal is calling page for IPN validation...

	$transaction_id  = $_POST["txn_id"];
	$payment_status = strtolower($_POST["payment_status"]);
	$invoice_id = $_POST["invoice"];
	$completed_on = date("Y-m-d G:i:s");

	$stmt6 = $mysqli->prepare("UPDATE paypal_log SET transaction_id='$transaction_id', payment_status ='$payment_status', completed_on='$completed_on' WHERE invoice_id ='$invoice_id'");
	$stmt6->execute();
	$stmt6->close();

	// It's important to remember that paypal calling this script.  There
	// is no output here.  This is where you validate the IPN data and if it's
	// valid, update your database to signify that the user has payed.  If
	// you try and use an echo or printf function here it's not going to do you
	// a bit of good.  This is on the "backend".  That is why, by default, the
	// class logs all IPN data to a text file.

	if ($p->validate_ipn()) {

	// Payment has been recieved and IPN is verified.  This is where you
	// update your database to activate or process the order, or setup
	// the database with the user's order details, email an administrator,
	// etc.  You can access a slew of information via the ipn_data() array.

	// Check the paypal documentation for specifics on what information
	// is available in the IPN POST variables.  Basically, all the POST vars
	// which paypal sends, which we send back for validation, are now stored
	// in the ipn_data() array.

	// For this example, we'll just email ourselves ALL the data.
	$subject = 'Instant Payment Notification - Recieved Payment';
	$to = 'triponsergiu@hotmail.co.uk';    //  your email
	$body =  "An instant payment notification was successfully recieved\n";
	$body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
	$body .= " at ".date('g:i A')."\n\nDetails:\n";

	foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
	mail($to, $subject, $body);
	}
	break;
}

