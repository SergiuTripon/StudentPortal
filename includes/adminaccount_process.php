<?php
include_once 'signin.php';

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

    if ($dateofbirth = '') {
        $dateofbirth = 'NULL';
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

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt3 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("INSERT INTO user_details (gender, firstname, surname, studentno, dateofbirth, phonenumber, degree, address1, address2, town, city, country, postcode, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt4->bind_param('sssissssssssss', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $country, $postcode, $created_on);
    $stmt4->execute();
    $stmt4->close();

    $token = null;

    $stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
    $stmt5->bind_param('s', $token);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("INSERT INTO user_fees (fee_amount, created_on) VALUES (?, ?)");
    $stmt6->bind_param('is', $fee_amount, $created_on);
    $stmt6->execute();
    $stmt6->close();
}
