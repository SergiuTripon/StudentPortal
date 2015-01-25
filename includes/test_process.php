<?php


if (isset($_POST['firstname1'], $_POST['surname1'], $_POST['gender1'], $_POST['dateofbirth1'], $_POST['studentno1'], $_POST['degree1'], $_POST['email1'], $_POST['phonenumber1'], $_POST['address11'], $_POST['address21'], $_POST['town1'], $_POST['city1'], $_POST['country1'], $_POST['postcode1'])) {
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
}
