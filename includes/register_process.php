<?php
include_once 'signin.php';

if(isset($_POST["gender"], $_POST["firstname"], $_POST["surname"], $_POST["studentno"], $_POST["email"], $_POST["password"], $_POST["confirmpwd"])) {
	
	$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
	$studentno = filter_input(INPUT_POST, 'studentno', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$confirmpwd = filter_input(INPUT_POST, 'confirmpwd', FILTER_SANITIZE_STRING);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
    } else {
	
	// Check existing student number
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_details WHERE studentno = ? LIMIT 1");
	$stmt1->bind_param('i', $studentno);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_userid);
	$stmt1->fetch();
	
	if ($stmt1->num_rows == 1) {
	$stmt1->close();
	header('HTTP/1.0 550 An account with the student number entered already exists.');
	exit();
	} else {
	
	// Check existing e-mail address
	$stmt2 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt2->bind_param('s', $email);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($db_userid);
	$stmt2->fetch();
	
	if ($stmt2->num_rows == 1) {
	$stmt2->close();
	header('HTTP/1.0 550 An account with the email address entered already exists.');
	exit();
	} else {
	
	$account_type = 'student';
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	
	$stmt3 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password) VALUES (?, ?, ?)");
	$stmt3->bind_param('sss', $account_type, $email, $password_hash);
	$stmt3->execute();
	$stmt3->close();
	
	date_default_timezone_set('Europe/London');
	$created_on = date("Y-m-d G:i:s");
	
	$stmt4 = $mysqli->prepare("INSERT INTO user_details (gender, studentno, firstname, surname, created_on) VALUES (?, ?, ?, ?, ?)");
	$stmt4->bind_param('sisss', $gender, $studentno, $firstname, $surname, $created_on);
	$stmt4->execute();
	$stmt4->close();
	
	$token = null;
	$token_created_on = null;
	
	$stmt5 = $mysqli->prepare("INSERT INTO user_token (token, created_on) VALUES (?, ?)");
	$stmt5->bind_param('ss', $token, $token_created_on);
	$stmt5->execute();
	$stmt5->close();
	
	$fee_amount = '9000.00';
	
	$stmt6 = $mysqli->prepare("INSERT INTO user_fees (fee_amount) VALUES (?)");
	$stmt6->bind_param('i', $fee_amount);
	$stmt6->execute();
	$stmt6->close();
	
	}
	}
	}
}
?>