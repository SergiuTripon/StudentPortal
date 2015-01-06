<?php
include 'signin.php';

if (isset($_POST["token"], $_POST["email"], $_POST["password"], $_POST["confirmpwd"])) {
	
	$token = $_POST["token"];
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$confirmpwd = filter_input(INPUT_POST, 'confirmpwd', FILTER_SANITIZE_STRING);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
    }
	
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	
	$stmt2 = $mysqli->prepare("SELECT token FROM user_token WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($db_token);
	$stmt2->fetch();
	
	$stmt3 = $mysqli->prepare("SELECT firstname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt3->bind_param('i', $userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($firstname);
	$stmt3->fetch();
	
	if ($token == $db_token) {
		
	$password_hash = password_hash($password, PASSWORD_BCRYPT);

	date_default_timezone_set('Europe/London');
	$updated_on = date("Y-m-d G:i:s");

	$stmt4 = $mysqli->prepare("UPDATE user_signin SET password = ?, updated_on = ? WHERE email = ? LIMIT 1");
	$stmt4->bind_param('sss', $password_hash, $updated_on, $email);
	$stmt4->execute();
	$stmt4->close();
	
	$subject = 'Password reset successfully';
	$message = "
	<html>
	<head>
	<title>Student Portal | Account</title>
	</head>
	<body>
	<p>Dear ".$firstname.",</p>
	<p>Your password has been successfully reset.</p>
	<p>If this action wasn't performed by you, please contact Student Portal as soon as possible, by clicking <a href=\"mailto:contact@sergiu-tripon.co.uk\">here.</a>
	<p>Kind Regards,<br>The Student Portal Team</p>
	</body>
	</html>";
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Student Portal <contact@sergiu-tripon.com>' . "\r\n";
	mail ($email, $subject, $message, $headers);
	
	$empty_token = NULL;
	$empty_created_on = '0000-00-00';

	$stmt4 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('ssi', $empty_token, $empty_created_on, $userid);
	$stmt4->execute();
	$stmt4->close();
	
	}
	else
	header('HTTP/1.0 550 The password reset key is invalid.');
	exit();
	}
	
?>


