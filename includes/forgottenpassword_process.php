<?php
include_once 'signin.php';

if (isset($_POST["email"])) {
	
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
    }

	// Getting user login details
	$stmt = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userid);
	$stmt->fetch();
	
	$stmt1 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();	
	$stmt1->bind_result($firstname, $surname);
	$stmt1->fetch();
	$stmt1->close();

	if ($stmt->num_rows == 1) {

	$uniqueid = uniqid(true);
	$token = password_hash($uniqueid, PASSWORD_BCRYPT);

	date_default_timezone_set('Europe/London');
	$created_on = date("Y-m-d G:i:s");
	
	$stmt2 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('ssi', $token, $created_on, $userid);
	$stmt2->execute();
	$stmt2->close();
	
	$passwordlink = "<a href=http://test.student-portal.co.uk/password-reset/?token=". $token .">here</a>";
	
	$subject = 'Request to change your password';
	$message = "
	<html>
	<head>
	<title>Student Portal | Password Reset</title>
	</head>
	<body>
	<p>Dear ".$firstname.",</p>
	<p>We have received a request to reset the password for your account.</p>
	<p>To proceed please click ".$passwordlink.".</p>
	<p>If you did not submit this request, please ignore this email.</p> 
	<p>Kind Regards,<br>The Student Portal Team</p>
	</body>
	</html>";
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Student Portal <contact@sergiu-tripon.com>' . "\r\n";
	mail ($email, $subject, $message, $headers);
	
	$stmt->close();
	}
	else
	header('HTTP/1.0 550 An account with the email address entered already exists.');
	exit();
	}
?>
