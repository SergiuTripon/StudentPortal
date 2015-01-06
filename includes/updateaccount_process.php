<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

if (isset($_SESSION['firstname']))
$session_firstname = $_SESSION['firstname'];
else $session_firstname = '';

if (isset($_POST['gender'], $_POST['firstname'], $_POST['surname'], $_POST['dateofbirth'], $_POST['email'], $_POST['phonenumber'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['city'], $_POST['country'], $_POST['postcode'], $_POST['degree'])) {

	$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);
	$degree = filter_input(INPUT_POST, 'degree', FILTER_SANITIZE_STRING);
	
	date_default_timezone_set('Europe/London');
	$updated_date = date("Y-m-d G:i:s");
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
    }
	else {
	
	$stmt1 = $mysqli->prepare("SELECT email from user_signin where userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_email);
	$stmt1->fetch();
	
	if ($db_email == $email) {
	
	$stmt2 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_date=?  WHERE userid = ?");
	$stmt2->bind_param('sssssssssssssi', $gender, $firstname, $surname, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_date, $userid);
	$stmt2->execute();
	$stmt2->close();
	
	$subject = 'Account updated successfully';
	$message = "
	<html>
	<head>
	<title>Student Portal | Account</title>
	</head>
	<body>
	<p>Dear ".$session_firstname.",</p>
	<p>Your account has been updated succesfully.</p>
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
	
	else {
	
	$stmt3 = $mysqli->prepare("SELECT userid from user_signin where email = ?");
	$stmt3->bind_param('s', $email);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($db_userid);
	$stmt3->fetch();
	
	if ($stmt3->num_rows == 1) {
	header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
	exit();
	$stmt3->close();
	}
	else {
	
	$stmt4 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_date=?  WHERE userid = ?");
	$stmt4->bind_param('ssssssssssssssi', $gender, $firstname, $surname, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_date, $userid);
	$stmt4->execute();
	$stmt4->close();
	
	$stmt5 = $mysqli->prepare("UPDATE user_signin SET email=? WHERE userid = ?");
	$stmt5->bind_param('si', $email, $userid);
	$stmt5->execute();
	$stmt5->close();
	
	$subject = 'Account updated successfully';
	$message = "
	<html>
	<head>
	<title>Student Portal | Account</title>
	</head>
	<body>
	<p>Dear ".$session_firstname.",</p>
	<p>Your account has been updated succesfully.</p>
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
	}
}


