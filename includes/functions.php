<?php
include 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

if (isset($_SESSION['firstname']))
$session_firstname = $_SESSION['firstname'];
else $session_firstname = '';

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");
$updated_on = date("Y-m-d G:i:s");

function SignIn() {

	global $mysqli;
	global $userid;

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

//RegisterUser function
function RegisterUser() {

	global $mysqli;
	global $created_on;

	$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
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

	$stmt3 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
	$stmt3->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
	$stmt3->execute();
	$stmt3->close();

	$stmt4 = $mysqli->prepare("INSERT INTO user_details (gender, firstname, surname, created_on) VALUES (?, ?, ?, ?)");
	$stmt4->bind_param('sisss', $gender, $firstname, $surname, $created_on);
	$stmt4->execute();
	$stmt4->close();

	$token = null;

	$stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
	$stmt5->bind_param('s', $token);
	$stmt5->execute();
	$stmt5->close();

	$fee_amount = '9000.00';

	$stmt6 = $mysqli->prepare("INSERT INTO user_fees (fee_amount, created_on) VALUES (?, ?)");
	$stmt6->bind_param('is', $fee_amount, $created_on);
	$stmt6->execute();
	$stmt6->close();

	}
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////


//SendPasswordToken function
function SendPasswordToken() {

	global $mysqli;
	global $userid;
	global $created_on;

	$email = filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

	// Getting user login details
	$stmt = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userid);
	$stmt->fetch();

	$stmt1 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($firstname, $surname);
	$stmt1->fetch();
	$stmt1->close();

	if ($stmt->num_rows == 1) {

		$uniqueid = uniqid(true);
		$token = password_hash($uniqueid, PASSWORD_BCRYPT);

		$stmt2 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
		$stmt2->bind_param('ssi', $token, $created_on, $userid);
		$stmt2->execute();
		$stmt2->close();

		$passwordlink = "<a href=http://test.student-portal.co.uk/password-reset/?token=". $token .">here</a>";

		// subject
		$subject = 'Request to change your password';

		// message
		$message = '<html>';
		$message .= '<head>';
		$message .= '<title>Student Portal | Password Reset</title>';
		$message .= '</head>';
		$message .= '<body>';
		$message .= '<p>Dear \".$firstname.\",</p>';
		$message .= '<p>We have received a request to reset the password for your account.</p>';
		$message .= "<p>To proceed please click \".$passwordlink.\".</p>";
		$message .= '<p>If you did not submit this request, please ignore this email.</p>';
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

		$stmt->close();
	}
	else
		header('HTTP/1.0 550 The email address you entered is incorrect.');
	exit();
}

function ResetPassword() {

	global $mysqli;
	global $userid;
	global $updated_on;

	$token = $_POST["token"];
	$email = filter_input(INPUT_POST, 'email3', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);

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

		$stmt2 = $mysqli->prepare("SELECT user_token.token, user_details.firstname FROM user_token LEFT JOIN user_details ON user_token.userid=user_detials.userid WHERE user_token.userid = ? LIMIT 1");
		$stmt2->bind_param('i', $userid);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($db_token, $firstname);
		$stmt2->fetch();

		if ($token == $db_token) {

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$stmt4 = $mysqli->prepare("UPDATE user_signin SET password = ?, updated_on = ? WHERE email = ? LIMIT 1");
		$stmt4->bind_param('sss', $password_hash, $updated_on, $email);
		$stmt4->execute();
		$stmt4->close();

		$empty_token = NULL;
		$empty_created_on = NULL;

		$stmt4 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
		$stmt4->bind_param('ssi', $empty_token, $empty_created_on, $userid);
		$stmt4->execute();
		$stmt4->close();

		// subject
		$subject = 'Password reset successfully';

		// message
		$message = '<html>';
		$message .= '<head>';
		$message .= '<title>Student Portal | Account</title>';
		$message .= '</head>';
		$message .= '<body>';
		$message .= "<p>Dear $firstname,</p>";
		$message .= '<p>Your password has been successfully reset.</p>';
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

	}
	else
		header('HTTP/1.0 550 The password reset key is invalid.');
	exit();
}

////////////////////////////////////////////////////////////////////////////////////////////

//Account functions
//UpdateAccount function
function UpdateAccount() {

	global $mysqli;
	global $userid;
	global $updated_on;
	global $session_firstname;

	$firstname = filter_input(INPUT_POST, 'firstname1', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname1', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender1', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email4', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);

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

//ChangePassword function
function ChangePassword() {

	global $mysqli;
	global $userid;
	global $updated_on;
	global $session_firstname;

	$password = filter_input(INPUT_POST, 'password3', FILTER_SANITIZE_STRING);

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

//DeleteAccount function
function DeleteAccount() {

	global $mysqli;
	global $userid;

	$stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->close();

	session_destroy();
}

//////////////////////////////////////////////////////////////////////////

//Admin account functions
//CreateAnAccount function
function CreateAnAccount() {

    global $mysqli;
    global $userid;
    global $created_on;

    $account_type = filter_input(INPUT_POST, 'account_type1', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname2', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender2', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth1', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'studentno2', FILTER_SANITIZE_STRING);
	$degree = filter_input(INPUT_POST, 'degree1', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email5', FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber1', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password4', FILTER_SANITIZE_STRING);
    $address1 = filter_input(INPUT_POST, 'address11', FILTER_SANITIZE_STRING);
    $address2 = filter_input(INPUT_POST, 'address21', FILTER_SANITIZE_STRING);
    $town = filter_input(INPUT_POST, 'town1', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city1', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country1', FILTER_SANITIZE_STRING);
    $postcode = filter_input(INPUT_POST, 'postcode1', FILTER_SANITIZE_STRING);

    $account_type = strtolower($account_type);

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

    if (empty($dateofbirth)) {
        $dateofbirth = NULL;
    }

    $stmt5 = $mysqli->prepare("INSERT INTO user_details (gender, firstname, surname, studentno, dateofbirth, phonenumber, degree, address1, address2, town, city, country, postcode, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt5->bind_param('sssissssssssss', $gender, $firstname, $surname, $studentno, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $country, $postcode, $created_on);
    $stmt5->execute();
    $stmt5->close();

    $token = null;

    $stmt6 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
    $stmt6->bind_param('s', $token);
    $stmt6->execute();
    $stmt6->close();

    if ($account_type == 'student') {
    $fee_amount = '9000.00';
    }
    elseif ($account_type == 'lecturer') {
    $fee_amount = '0.00';
    }
    elseif ($account_type == 'admin') {
    $fee_amount = '0.00';
    }

    $stmt7 = $mysqli->prepare("INSERT INTO user_fees (fee_amount, created_on) VALUES (?, ?)");
    $stmt7->bind_param('is', $fee_amount, $created_on);
    $stmt7->execute();
    $stmt7->close();
}

//UpdateAnAccount function
function UpdateAnAccount() {

    global $mysqli;
    global $userid;
    global $updated_on;

    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname3', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname3', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender3', FILTER_SANITIZE_STRING);
    $dateofbirth = filter_input(INPUT_POST, 'dateofbirth2', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'studentno3', FILTER_SANITIZE_STRING);
    $degree = filter_input(INPUT_POST, 'degree2', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email6', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber2', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address12', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address22', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town2', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city2', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country2', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode2', FILTER_SANITIZE_STRING);

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

	$stmt2 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, dateofbirth=?, studentno=?, degree=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt2->bind_param('ssssisssssssssi', $firstname, $surname, $gender, $dateofbirth, $studentno, $degree, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
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

	$stmt4 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, dateofbirth=?, studentno=?, degree=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=? WHERE userid=?");
	$stmt4->bind_param('ssssisssssssssi', $firstname, $surname, $gender, $dateofbirth, $studentno, $degree, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
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

//ChangeAccountPassword function
function ChangeAccountPassword() {

    global $mysqli;
    global $userid;
    global $updated_on;

    $userid = filter_input(INPUT_POST, 'userid1', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password5', FILTER_SANITIZE_STRING);

	// Getting user login details
	$stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_password);
	$stmt1->fetch();

    if (password_verify($password, $db_password)) {

		header('HTTP/1.0 550 This is the account\'s current password. Please enter a new password.');
		exit();
		$stmt1->close();

	} else {

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
    $stmt2->bind_param('ssi', $password_hash, $updated_on, $userid);
    $stmt2->execute();
    $stmt2->close();

	$stmt1->close();
	}
}

//DeleteAnAccount function
function DeleteAnAccount() {

    global $mysqli;
    global $userid;

    $idToDelete = filter_input(INPUT_POST, 'recordToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToDelete);
    $stmt1->execute();
    $stmt1->close();
}

////////////////////////////////////////////////////////////////////////////////////////////////

//Calendar functions
//CreateTask function
function CreateTask () {

	global $mysqli;
	global $userid;
	global $created_on;

	$task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'task_notes', FILTER_SANITIZE_STRING);
    $task_url = filter_input(INPUT_POST, 'task_url', FILTER_SANITIZE_STRING);
    $task_startdate = filter_input(INPUT_POST, 'task_startdate', FILTER_SANITIZE_STRING);
    $task_duedate = filter_input(INPUT_POST, 'task_duedate', FILTER_SANITIZE_STRING);
    $task_category = filter_input(INPUT_POST, 'task_category', FILTER_SANITIZE_STRING);

    $task_category = strtolower($task_category);

    if ($task_category == 'university') { $task_class = 'event-important'; }
    if ($task_category == 'work') { $task_class = 'event-info'; }
    if ($task_category == 'personal') { $task_class = 'event-warning'; }
    if ($task_category == 'other') { $task_class = 'event-success'; }

    // Check if task exists
    $stmt1 = $mysqli->prepare("SELECT taskid FROM user_tasks WHERE task_name = ? AND userid = ? LIMIT 1");
    $stmt1->bind_param('si', $task_name, $userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_taskid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
	header('HTTP/1.0 550 A task with the task name entered already exists.');
	exit();
	$stmt1->close();

	} else {
	$task_status = 'active';

	$stmt2 = $mysqli->prepare("INSERT INTO user_tasks (userid, task_name, task_notes, task_url, task_class, task_startdate, task_duedate, task_category, task_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt2->bind_param('isssssssss', $userid, $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_category, $task_status, $created_on);
	$stmt2->execute();
	$stmt2->close();

	$stmt1->close();
    }
}

//UpdateTask function
function UpdateTask() {

	global $mysqli;

	$taskid = filter_input(INPUT_POST, 'taskid', FILTER_SANITIZE_NUMBER_INT);
	$task_name = filter_input(INPUT_POST, 'task_name1', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'task_notes1', FILTER_SANITIZE_STRING);
	$task_url = filter_input(INPUT_POST, 'task_url1', FILTER_SANITIZE_STRING);
	$task_startdate = filter_input(INPUT_POST, 'task_startdate1', FILTER_SANITIZE_STRING);
	$task_duedate = filter_input(INPUT_POST, 'task_duedate1', FILTER_SANITIZE_STRING);
	$task_category = filter_input(INPUT_POST, 'task_category1', FILTER_SANITIZE_STRING);

	$task_category = strtolower($task_category);

	if ($task_category == 'university') { $task_class = 'event-important'; }
	if ($task_category == 'work') { $task_class = 'event-info'; }
	if ($task_category == 'personal') { $task_class = 'event-warning'; }
	if ($task_category == 'other') { $task_class = 'event-success'; }

	$stmt1 = $mysqli->prepare("SELECT task_name from user_tasks where taskid = ?");
	$stmt1->bind_param('i', $taskid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_taskname);
	$stmt1->fetch();

	if ($db_taskname == $task_name) {

	$stmt2 = $mysqli->prepare("UPDATE user_tasks SET task_notes=?, task_url=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt2->bind_param('ssssssi', $task_notes, $task_url, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
	$stmt2->execute();
	$stmt2->close();

	}

	else {

	$stmt3 = $mysqli->prepare("SELECT taskid from user_tasks where task_name = ? AND userid = ? LIMIT 1");
	$stmt3->bind_param('si', $task_name, $userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($db_taskid);
	$stmt3->fetch();

	if ($stmt3->num_rows == 1) {
	header('HTTP/1.0 550 A task with the name entered already exists.');
	exit();
	$stmt3->close();
	}
	else {

	$stmt4 = $mysqli->prepare("UPDATE user_tasks SET task_name=?, task_notes=?, task_url=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt4->bind_param('sssssssi', $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
	$stmt4->execute();
	$stmt4->close();

	}
	}
}

//CompleteTask function
function CompleteTask() {

	global $mysqli;

	$idToComplete = filter_input(INPUT_POST, 'recordToComplete', FILTER_SANITIZE_NUMBER_INT);
	$task_status = 'completed';

	$stmt1 = $mysqli->prepare("UPDATE user_tasks SET task_status = ?, completed_on = ? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('ssi', $task_status, $completed_on, $idToComplete);
	$stmt1->execute();
	$stmt1->close();
}