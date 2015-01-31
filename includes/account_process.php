<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

if (isset($_SESSION['firstname']))
$session_firstname = $_SESSION['firstname'];
else $session_firstname = '';

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");
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

	$stmt2 = $mysqli->prepare("UPDATE user_details SET gender=?, firstname=?, surname=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, degree=?, updated_on=?  WHERE userid = ?");
	$stmt2->bind_param('sssssssssssssi', $gender, $firstname, $surname, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $degree, $updated_on, $userid);
	$stmt2->execute();
	$stmt2->close();

		// multiple recipients
	$to  = 'aidan@example.com' . ', '; // note the comma
	$to .= 'wez@example.com';

	// subject
	$subject = 'Account updated successfully';

	// message
	$message = '<html>';
	$message .= '<head>';
	$message .= '<title>Student Portal | Account</title>';
	$message .= '</head>';
	$message .= '<body>';
	$message .= "<p>Dear $session_firstname,</p>";
	$message .= '<p>Your account has been updated succesfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@student-portal.co.uk">here.</a>';
	$message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
	$message .= '</body>';
	$message .=	'</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	// Mail it
	mail($email, $subject, $message, $headers);
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

	// subject
	$subject = 'Account updated successfully';

	// message
	$message = '<html>';
	$message .= '<head>';
	$message .= '<title>Student Portal | Account</title>';
	$message .= '</head>';
	$message .= '<body>';
	$message .= "<p>Dear $session_firstname,</p>";
	$message .= '<p>Your account has been updated succesfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@student-portal.co.uk">here.</a>';
	$message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
	$message .= '</body>';
	$message .=	'</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	// Mail it
	mail($email, $subject, $message, $headers);

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

	// subject
	$subject = 'Password changed successfully';

	// message
	$message = '<html>';
	$message .= '<head>';
	$message .= '<title>Student Portal | Account</title>';
	$message .= '</head>';
	$message .= '<body>';
	$message .= "<p>Dear $session_firstname,</p>";
	$message .= '<p>Your password has been changed successfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href=\"mailto:contact@sergiu-tripon.co.uk\">here.</a>';
	$message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
	$message .= '</body>';
	$message .= '</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	// Mail it
	mail($email, $subject, $message, $headers);

	$stmt1->close();
	}
}

elseif (isset($_POST['deleteaccount_button'])) {
	DeleteAccount();
}

function DeleteAccount() {

	global $mysqli;
	global $userid;

	$stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->close();

	session_destroy();
}
