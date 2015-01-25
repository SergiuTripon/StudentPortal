<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");


if (isset($_POST['account_type'], $_POST['gender'], $_POST['firstname'], $_POST['surname'], $_POST['studentno'], $_POST['email'], $_POST['password'], $_POST['confirmpwd'], $_POST['dateofbirth'], $_POST['phonenumber'], $_POST['degree'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['city'], $_POST['country'], $_POST['postcode'])) {

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

    if (empty($dateofbirth)) {
        $dateofbirth = NULL;
    }
    if ($account_type = 'student') {
    $fee_amount = '9000.00';
    }
    if ($account_type = 'lecturer') {
    $fee_amount = '0.00';
    }
    if ($account_type = 'admin') {
    $fee_amount = '0.00';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('HTTP/1.0 550 The email address you entered is invalid.');
    exit();
    }

    // Check existing studentno
    $stmt1 = $mysqli->prepare("SELECT userid FROM user_details WHERE studentno = ? AND NOT studentno = '0' LIMIT 1");
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

    $stmt3 = $mysqli->prepare("SELECT userid FROM user_signin ORDER BY userid DESC LIMIT 1");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($userid);
    $stmt3->fetch();

    if (empty($studentno)) {
        $studentno = $userid + 1;
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt4 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
    $stmt4->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("INSERT INTO user_details (gender, firstname, surname, studentno, dateofbirth, phonenumber, degree, address1, address2, town, city, country, postcode, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt5->bind_param('sssissssssssss', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $country, $postcode, $created_on);
    $stmt5->execute();
    $stmt5->close();

    $token = null;

    $stmt6 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
    $stmt6->bind_param('s', $token);
    $stmt6->execute();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("INSERT INTO user_fees (fee_amount, created_on) VALUES (?, ?)");
    $stmt7->bind_param('is', $fee_amount, $created_on);
    $stmt7->execute();
    $stmt7->close();
}

if (isset($_POST['gender1'], $_POST['firstname1'], $_POST['surname1'], $_POST['studentno1'], $_POST['email1'], $_POST['dateofbirth1'], $_POST['phonenumber1'], $_POST['degree1'], $_POST['address11'], $_POST['address21'], $_POST['town1'], $_POST['city1'], $_POST['country1'], $_POST['postcode1'])) {
    $gender = filter_input(INPUT_POST, 'gender1', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname1', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname1', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'studentno1', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email1', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth1', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber1', FILTER_SANITIZE_STRING);
    $degree = filter_input(INPUT_POST, 'degree1', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address11', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address21', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town1', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city1', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country1', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode1', FILTER_SANITIZE_STRING);

	if ($dateofbirth == '') {
		$dateofbirth = NULL;
	}

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

	$stmt2 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, studentno=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_on=?  WHERE userid = ?");
	$stmt2->bind_param('sssssssssssssi', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_on, $userid);
	$stmt2->execute();
	$stmt2->close();

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

	$stmt4 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, studentno=?,dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_on=?  WHERE userid = ?");
	$stmt4->bind_param('ssssssssssssssi', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_on, $userid);
	$stmt4->execute();
	$stmt4->close();

	$stmt5 = $mysqli->prepare("UPDATE user_signin SET email=?, updated_on=? WHERE userid = ?");
	$stmt5->bind_param('ssi', $email, $updated_on, $userid);
	$stmt5->execute();
	$stmt5->close();

	}
	}
	}
} else {
    header('HTTP/1.0 550 Variables not set properly.');
    exit();
}


if (isset($_POST["recordToDelete"])) {

    $idToDelete = filter_input(INPUT_POST, 'recordToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToDelete);
    $stmt1->execute();
    $stmt1->close();

}
