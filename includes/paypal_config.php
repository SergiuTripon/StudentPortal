<?php
include 'signin.php';

$PayPalMode 			= 'sandbox'; // sandbox or live
$PayPalApiUsername 		= 'triponsergiu@hotmail.co.uk'; //PayPal API Username
$PayPalApiPassword 		= 'mexug0Aq'; //Paypal API password
$PayPalApiSignature 	= 'opupouopupo987kkkhkixlksjewNyJ2pEq.Gufar'; //Paypal API Signature
$PayPalCurrencyCode 	= 'GBP'; //Paypal Currency Code
$PayPalReturnURL 		= 'http://test.student-portal.co.uk/includes/paypal_process.php'; //Point to process.php page
$PayPalCancelURL 		= 'http://test.student-portal.co.uk/includes/paypal/paypal_cancel.php'; //Cancel URL if user clicks cancel
?>