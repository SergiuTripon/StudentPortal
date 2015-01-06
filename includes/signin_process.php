<?php
include_once 'signin.php';
 
if (isset($_POST['email'], $_POST['password'])) {
	
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
    } else {
	
	// Getting user login details
	$stmt1 = $mysqli->prepare("SELECT userid, account_type, password FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid, $account_type, $db_password);
	$stmt1->fetch();
	
	if ($stmt1->num_rows == 1) {
	
	// Getting firstname and surname for the user
	$stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();	
	$stmt2->bind_result($firstname, $surname);
	$stmt2->fetch();
	$stmt2->close();
	
	if (password_verify($password, $db_password)) {

	// Setting a session variable
	$_SESSION['loggedin'] = true;
	
	$userid = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);
	$email = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $email);
	$firstname = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $firstname);											
	$surname = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $surname);
	
 	$_SESSION['userid'] = $userid;
	$_SESSION['account_type'] = $account_type;
	$_SESSION['email'] = $email;
	$_SESSION['firstname'] = $firstname;
	$_SESSION['surname'] = $surname;
	
	} else {
	header('HTTP/1.0 550 The password you entered is incorrect.');
	exit();
	$stmt1->close();
	}
	
	} else {
	header('HTTP/1.0 550 The email address you entered is incorrect.');
	exit();
	$stmt1->close();
	}
	
	}
}
