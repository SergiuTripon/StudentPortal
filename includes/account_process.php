<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

if (isset($_SESSION['firstname']))
	$session_firstname = $_SESSION['firstname'];
else $session_firstname = '';

date_default_timezone_set('Europe/London');
$updated_on = date("Y-m-d G:i:s");

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

			$stmt2 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_on=?  WHERE userid = ?");
			$stmt2->bind_param('sssssssssssssi', $gender, $firstname, $surname, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_on, $userid);
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

				$stmt4 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_on=?  WHERE userid = ?");
				$stmt4->bind_param('ssssssssssssssi', $gender, $firstname, $surname, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_on, $userid);
				$stmt4->execute();
				$stmt4->close();

				$stmt5 = $mysqli->prepare("UPDATE user_signin SET email=?, updated_on=? WHERE userid = ?");
				$stmt5->bind_param('ssi', $email, $updated_on, $userid);
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

elseif (isset($_POST["password"], $_POST["confirmpwd"])) {

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
		$stmt1->close();

	} else {

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
		$stmt2->bind_param('ssi', $password_hash, $updated_on, $userid);
		$stmt2->execute();
		$stmt2->close();

		$stmt3 = $mysqli->prepare("SELECT email FROM user_signin WHERE userid = ?");
		$stmt3->bind_param('i', $userid);
		$stmt3->execute();
		$stmt3->store_result();
		$stmt3->bind_result($email);
		$stmt3->fetch();

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

	$stmt1->close();
	}
}

elseif (isset($_POST['deleteaccount_button'])) {

	$stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->close();

	session_destroy();
}

elseif (isset($_POST['account_type1'], $_POST['gender1'], $_POST['firstname1'], $_POST['surname1'], $_POST['studentno1'], $_POST['email1'], $_POST['password1'], $_POST['confirmpwd1'], $_POST['dateofbirth1'], $_POST['phonenumber1'], $_POST['degree1'], $_POST['address11'], $_POST['address21'], $_POST['town1'], $_POST['city1'], $_POST['country1'], $_POST['postcode1'])) {

	$account_type = filter_input(INPUT_POST, 'account_type', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
	$studentno = filter_input(INPUT_POST, 'studentno', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$confirmpwd = filter_input(INPUT_POST, 'confirmpwd', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING);
	$degree = filter_input(INPUT_POST, 'degree', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

	// Check existing studentno
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_details WHERE studentno = ? LIMIT 1");
	$stmt1->bind_param('i', $studentno);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();

	if ($stmt1->num_rows == 1) {
		header('HTTP/1.0 550 An account with the student number entered already exists.');
		exit();
		$stmt1->close();
	}

	// Check existing email
	$stmt2 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt2->bind_param('s', $email);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($userid);
	$stmt2->fetch();

	if ($stmt2->num_rows == 1) {
		header('HTTP/1.0 550 An account with the email address entered already exists.');
		exit();
		$stmt2->close();
	}

	$password_hash = password_hash($password, PASSWORD_BCRYPT);

	$stmt3 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password) VALUES (?, ?, ?)");
	$stmt3->bind_param('sss', $account_type, $email, $password_hash);
	$stmt3->execute();
	$stmt3->close();

	date_default_timezone_set('Europe/London');
	$created_date = date("Y-m-d G:i:s");

	$stmt4 = $mysqli->prepare("INSERT INTO user_details (gender, firstname, surname, studentno, dateofbirth, phonenumber, degree, address1, address2, town, city, country, postcode, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt4->bind_param('sssissssssssss', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $country, $postcode, $created_date);
	$stmt4->execute();
	$stmt4->close();

	$token = null;

	$stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
	$stmt5->bind_param('s', $token);
	$stmt5->execute();
	$stmt5->close();

	$fee_amount = '9000.00';

	$stmt6 = $mysqli->prepare("INSERT INTO user_fees (fee_amount) VALUES (?)");
	$stmt6->bind_param('i', $fee_amount);
	$stmt6->execute();
	$stmt6->close();
}

