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
		
	$stmt4 = $mysqli->prepare("UPDATE user_signin SET password = ? WHERE email = ? LIMIT 1");
	$stmt4->bind_param('ss', $password_hash, $email);
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
	$stmt4 = $mysqli->prepare("UPDATE user_token SET token = ? WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('si', $empty_token, $userid);
	$stmt4->execute();
	$stmt4->close();
	
	}
	else
	header('HTTP/1.0 550 The password reset key is invalid.');
	exit();
	}
	
?>


