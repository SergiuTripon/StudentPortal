<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

$stmt1 = $mysqli->prepare("SELECT email FROM user_signin WHERE userid = ?");
$stmt1->bind_param('i', $userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($email);
$stmt1->fetch();

if (isset($_SESSION['firstname']))
$session_firstname = $_SESSION['firstname'];
else $session_firstname = '';

if (isset($_POST["password"], $_POST["confirmpwd"])) {
	
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$confirmpwd = filter_input(INPUT_POST, 'confirmpwd', FILTER_SANITIZE_STRING);
	
	// Getting user login details
	$stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_password);
	$stmt1->fetch();
	
	if (password_verify($password, $db_password)) {
	
	header('HTTP/1.0 550 This is your current password. Please enter a new password.');
	exit();
	
	} else {
		
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	
	$stmt1 = $mysqli->prepare("UPDATE user_signin SET password=? WHERE userid = ?");
	$stmt1->bind_param('si', $password_hash, $userid);
	$stmt1->execute();
	$stmt1->close();
	
	date_default_timezone_set('Europe/London');
	$updated_date = date("Y-m-d G:i:s");
	
	$stmt2 = $mysqli->prepare("UPDATE user_details SET updated_date=? WHERE userid = ?");
	$stmt2->bind_param('si', $updated_date, $userid);
	$stmt2->execute();
	$stmt2->close();
	
	$subject = 'Password changed successfully';
	$message = "
	<html>
	<head>
	<title>Student Portal | Account</title>
	</head>
	<body>
	<p>Dear ".$session_firstname.",</p>
	<p>Your password has been changed successfully.</p>
	<p>If this action wasn't performed by you, please contact Student Portal as soon as possible, by clicking <a href=\"mailto:contact@sergiu-tripon.co.uk\">here.</a>
	<p>Kind Regards,<br>The Student Portal Team</p>
	</body>
	</html>";
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Student Portal <contact@sergiu-tripon.com>' . "\r\n";
	mail ($email, $subject, $message, $headers);
	
	}
}	
?>


