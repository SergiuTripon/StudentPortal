<?php
include 'session.php';

//External pages functions
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
	$stmt1->bind_result($userid, $session_account_type, $db_password);
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

	$isSignedIn = 1;

	$stmt3 = $mysqli->prepare("UPDATE user_signin SET isSignedIn = ? WHERE userid = ? LIMIT 1");
	$stmt3->bind_param('ii', $isSignedIn, $userid);
	$stmt3->execute();
	$stmt3->close();

	// Setting a session variable
	$_SESSION['loggedin'] = true;

	$session_userid = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);

 	$_SESSION['userid'] = $session_userid;
	$_SESSION['account_type'] = $session_account_type;

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
/////////////////////////////////////////////////////////////////////////////////////////////////////

//RegisterUser function
function RegisterUser() {

	global $mysqli;
	global $created_on;

	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email1', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);

	$gender = strtolower($gender);

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

	$stmt4 = $mysqli->prepare("INSERT INTO user_details (firstname, surname, gender, created_on) VALUES (?, ?, ?, ?)");
	$stmt4->bind_param('ssss', $firstname, $surname, $gender, $created_on);
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

		$passwordlink = "<a href=https://student-portal.co.uk/password-reset/?token=$token>here</a>";

		// subject
		$subject = 'Request to change your password';

		// message
		$message = '<html>';
		$message .= '<head>';
		$message .= '<title>Student Portal | Password Reset</title>';
		$message .= '</head>';
		$message .= '<body>';
		$message .= "<p>Dear $firstname,</p>";
		$message .= '<p>We have received a request to reset the password for your account.</p>';
		$message .= "<p>To proceed please click $passwordlink.</p>";
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
/////////////////////////////////////////////////////////////////////////////////////////////////////

//ResetPassword function
function ResetPassword() {

	global $mysqli;
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

	$stmt2 = $mysqli->prepare("SELECT user_token.token, user_details.firstname FROM user_token LEFT JOIN user_details ON user_token.userid=user_details.userid WHERE user_token.userid = ? LIMIT 1");
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
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@sergiu-tripon.co.uk">here</a>.';
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

//ContactUs function
function ContactUs() {

	$firstname = filter_input(INPUT_POST, 'firstname4', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname4', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email7', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$message1 = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

	// subject
	$subject = 'New Message';

	$to = 'contact@student-portal.co.uk';

	// message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>The following person contacted Student Portal:</p>';
	$message .= '<table rules="all" align="center" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Message:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $message1</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: Student Portal '.$email.'' . "\r\n";
	$headers .= 'Reply-To: Student Portal '.$email.'' . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers);

}

//Overview functions
function GetDashboardData() {

	global $mysqli;
	global $userid;
	global $timetable_count;
	global $exams_count;
	global $library_count;
	global $calendar_count;
	global $events_count;
	global $messenger_count;

	$stmt1 = $mysqli->prepare("SELECT system_lectures.lectureid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($lectureid);
	$stmt1->fetch();

	$stmt2 = $mysqli->prepare("SELECT system_tutorials.tutorialid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($tutorialid);
	$stmt2->fetch();

	$stmt3 = $mysqli->prepare("SELECT system_exams.examid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_exams ON user_timetable.moduleid=system_exams.moduleid WHERE user_timetable.userid = ? LIMIT 1");
	$stmt3->bind_param('i', $userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($examid);
	$stmt3->fetch();

	$stmt4 = $mysqli->prepare("	SELECT reserved_books.bookid FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid  WHERE reserved_books.userid = ? AND system_books.book_status = 'reserved' AND isReturned = '0'");
	$stmt4->bind_param('i', $userid);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($bookid);
	$stmt4->fetch();

	$task_status = 'active';
	$stmt5 = $mysqli->prepare("SELECT taskid FROM user_tasks WHERE userid = ? AND task_status = ?");
	$stmt5->bind_param('is', $userid, $task_status);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($taskid);
	$stmt5->fetch();

	$event_status = 'active';
	$stmt6 = $mysqli->prepare("SELECT eventid FROM system_events WHERE event_status = ?");
	$stmt6->bind_param('i', $event_status);
	$stmt6->execute();
	$stmt6->store_result();
	$stmt6->bind_result($eventid);
	$stmt6->fetch();

	$isRead = '0';
	$stmt7 = $mysqli->prepare("	SELECT user_messages.userid FROM user_messages WHERE user_messages.message_to = ? AND isRead = ?");
	$stmt7->bind_param('ii', $userid, $isRead);
	$stmt7->execute();
	$stmt7->store_result();
	$stmt7->bind_result($messenger_userid);
	$stmt7->fetch();

	$lectures_count = $stmt1->num_rows;
	$tutorials_count = $stmt2->num_rows;
	$timetable_count = $lectures_count + $tutorials_count;

	$exams_count = $stmt3->num_rows;

	$library_count = $stmt4->num_rows;

	$calendar_count = $stmt5->num_rows;

	$events_count = $stmt6->num_rows;

	$messenger_count = $stmt7->num_rows;

	$stmt1->close();
	$stmt2->close();
	$stmt3->close();

}

//////////////////////////////////////////////////////////////////////////////////////////

//Timetable functions
//CreateTimetable function
function CreateTimetable() {

    global $mysqli;
    global $created_on;

    //Module
    $module_name = filter_input(INPUT_POST, 'module_name', FILTER_SANITIZE_STRING);
    $module_notes = filter_input(INPUT_POST, 'module_notes', FILTER_SANITIZE_STRING);
    $module_url = filter_input(INPUT_POST, 'module_url', FILTER_SANITIZE_STRING);

    //Lecture
    $lecture_name = filter_input(INPUT_POST, 'lecture_name', FILTER_SANITIZE_STRING);
    $lecture_lecturer = filter_input(INPUT_POST, 'lecture_lecturer', FILTER_SANITIZE_STRING);
    $lecture_notes = filter_input(INPUT_POST, 'lecture_notes', FILTER_SANITIZE_STRING);
    $lecture_day = filter_input(INPUT_POST, 'lecture_day', FILTER_SANITIZE_STRING);
    $lecture_from_time = filter_input(INPUT_POST, 'lecture_from_time', FILTER_SANITIZE_STRING);
    $lecture_to_time = filter_input(INPUT_POST, 'lecture_to_time', FILTER_SANITIZE_STRING);
    $lecture_from_date = filter_input(INPUT_POST, 'lecture_from_date', FILTER_SANITIZE_STRING);
    $lecture_to_date = filter_input(INPUT_POST, 'lecture_to_date', FILTER_SANITIZE_STRING);
    $lecture_location = filter_input(INPUT_POST, 'lecture_location', FILTER_SANITIZE_STRING);
    $lecture_capacity = filter_input(INPUT_POST, 'lecture_capacity', FILTER_SANITIZE_STRING);

    $module_status = 'active';

    $stmt1 = $mysqli->prepare("INSERT INTO system_modules (module_name, module_notes, module_url, module_status, created_on) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param('sssss', $module_name, $module_notes, $module_url, $module_status, $created_on);
    $stmt1->execute();
    $stmt1->close();

    $stmt4 = $mysqli->prepare("SELECT moduleid FROM system_modules ORDER BY moduleid DESC");
    $stmt4->bind_param('i', $moduleid);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($moduleid);
    $stmt4->fetch();
    $stmt4->close();

    $lecture_lecturer = '2';
    $lecture_status = 'active';

    $stmt2 = $mysqli->prepare("INSERT INTO system_lectures (moduleid, lecture_name, lecture_lecturer, lecture_notes, lecture_day, lecture_from_time, lecture_to_time, lecture_from_date, lecture_to_date, lecture_location, lecture_capacity, lecture_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param('isisssssssiss', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $lecture_status, $created_on);
    $stmt2->execute();
    $stmt2->close();

}

///////////////////////////////////////////////////////////////////////////////////////////

//Library functions
//ReserveBook function
function ReserveBook() {

	global $mysqli;
	global $userid;

	$bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_STRING);
	$book_name = filter_input(INPUT_POST, 'book_name', FILTER_SANITIZE_STRING);
	$book_author = filter_input(INPUT_POST, 'book_author', FILTER_SANITIZE_STRING);
	$bookreserved_from = filter_input(INPUT_POST, 'bookreserved_from', FILTER_SANITIZE_STRING);
	$bookreserved_to = filter_input(INPUT_POST, 'bookreserved_to', FILTER_SANITIZE_STRING);

	$book_class = 'event-info';
	$isReturned = 0;

	$stmt1 = $mysqli->prepare("INSERT INTO reserved_books (userid, bookid, book_class, reserved_on, toreturn_on, isReturned) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt1->bind_param('iisssi', $userid, $bookid, $book_class, $bookreserved_from, $bookreserved_to, $isReturned);
	$stmt1->execute();
	$stmt1->close();

	$book_status = 'reserved';

	$stmt3 = $mysqli->prepare("UPDATE system_books SET book_status=? WHERE bookid =?");
	$stmt3->bind_param('si', $book_status, $bookid);
	$stmt3->execute();
	$stmt3->close();

	$stmt4 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname, user_details.studentno FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt4->bind_param('i', $userid);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($email, $firstname, $surname, $studentno);
	$stmt4->fetch();
	$stmt4->close();

	$reservation_status = 'Completed';

	// subject
	$subject = 'Reservation confirmation';

	// message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent book reservation! Below, you can find the reservation summary:</p>';
	$message .= '<table rules="all" align="center" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $studentno</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $book_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $book_author</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $bookreserved_from</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $bookreserved_to</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Reservation status:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $reservation_status</td></tr>";
	$message .= '</table>';
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
//////////////////////////////////////////////////////////////////////////////////////////////////

//Transport functions

function GetTubeStatusNow() {

	global $now;
	global $bakerloo, $bakerloo1, $central, $central1, $circle, $circle1, $district, $district1, $hammersmith, $hammersmith1, $jubilee, $jubilee1, $metropolitan, $metropolitan1, $northern, $northern1, $picadilly, $picadilly1, $victoria, $victoria1, $waterloo, $waterloo1, $overground, $overground1, $dlr, $dlr1;

	$now = date('H:i');

	$url = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
	$result = file_get_contents($url);
	$xml = new SimpleXMLElement($result);

	$bakerloo = $xml->LineStatus[0]->Line->attributes()->Name;
	$bakerloo1 = $xml->LineStatus[0]->Status->attributes()->Description;

	$central = $xml->LineStatus[1]->Line->attributes()->Name;
	$central1 = $xml->LineStatus[1]->Status->attributes()->Description;

	$circle = $xml->LineStatus[2]->Line->attributes()->Name;
	$circle1 = $xml->LineStatus[2]->Status->attributes()->Description;

	$district = $xml->LineStatus[3]->Line->attributes()->Name;
	$district1 = $xml->LineStatus[3]->Status->attributes()->Description;

	$hammersmith = $xml->LineStatus[4]->Line->attributes()->Name;
	$hammersmith1 = $xml->LineStatus[4]->Status->attributes()->Description;

	$jubilee = $xml->LineStatus[5]->Line->attributes()->Name;
	$jubilee1 = $xml->LineStatus[5]->Status->attributes()->Description;

	$metropolitan = $xml->LineStatus[6]->Line->attributes()->Name;
	$metropolitan1 = $xml->LineStatus[6]->Status->attributes()->Description;

	$northern = $xml->LineStatus[7]->Line->attributes()->Name;
	$northern1 = $xml->LineStatus[7]->Status->attributes()->Description;

	$picadilly = $xml->LineStatus[8]->Line->attributes()->Name;
	$picadilly1 = $xml->LineStatus[8]->Status->attributes()->Description;

	$victoria = $xml->LineStatus[9]->Line->attributes()->Name;
	$victoria1 = $xml->LineStatus[9]->Status->attributes()->Description;

	$waterloo = $xml->LineStatus[10]->Line->attributes()->Name;
	$waterloo1 = $xml->LineStatus[10]->Status->attributes()->Description;

	$overground = $xml->LineStatus[11]->Line->attributes()->Name;
	$overground1 = $xml->LineStatus[11]->Status->attributes()->Description;

	$dlr = $xml->LineStatus[12]->Line->attributes()->Name;
	$dlr1 = $xml->LineStatus[12]->Status->attributes()->Description;
}

//GetLiveTubeStatus function
function GetLiveTubeStatus () {

	global $xml_line_status;
	global $xml_station_status;

	$url1 = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
	$result1 = file_get_contents($url1);
	$xml_line_status = new SimpleXMLElement($result1);

	$url2 = 'http://cloud.tfl.gov.uk/TrackerNet/StationStatus';
	$result2 = file_get_contents($url2);
	$xml_station_status = new SimpleXMLElement($result2);
}

//GetThisWeekendStatus function
function GetThisWeekendTubeStatus () {

	global $xml_this_weekend;

	$url = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
	$result = file_get_contents($url);
	$xml_this_weekend = new SimpleXMLElement($result);
}

//GetCycleHireStatus function
function GetCycleHireStatus () {

	global $cycle_hire;

	$url = 'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml';
	$result = file_get_contents($url);
	$cycle_hire = new SimpleXMLElement($result);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
	global $updated_on;

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

	$stmt2 = $mysqli->prepare("UPDATE user_tasks SET task_notes=?, task_url=?, task_class=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt2->bind_param('sssssssi', $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
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

	$stmt4 = $mysqli->prepare("UPDATE user_tasks SET task_name=?, task_notes=?, task_url=?, task_class=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt4->bind_param('ssssssssi', $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Events functions
//EventsPaypalPaymentSuccess function
function EventsPaypalPaymentSuccess() {

	global $mysqli;
	global $newquantity;
	global $updated_on;
	global $created_on;
	global $completed_on;

	$item_number1 = $_POST["item_number1"];
	$quantity1 = $_POST["quantity1"];
	$product_name = $_POST["item_name1"];
	$product_amount = $_POST["mc_gross"];

	$invoice_id = $_POST["invoice"];
	$transaction_id  = $_POST["txn_id"];

	$payment_status = strtolower($_POST["payment_status"]);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoice_id = ? LIMIT 1");
	$stmt1->bind_param('i', $invoice_id);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

	$stmt2 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($email, $firstname, $surname);
	$stmt2->fetch();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("INSERT INTO booked_events (userid, eventid, event_name, event_amount, tickets_quantity, booked_on) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt3->bind_param('iisiis', $userid, $item_number1, $product_name, $product_amount, $quantity1, $created_on);
	$stmt3->execute();
	$stmt3->close();

	$stmt4 = $mysqli->prepare("SELECT event_ticket_no from system_events where eventid = ?");
	$stmt4->bind_param('i', $item_number1);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($event_ticket_no);
	$stmt4->fetch();
	$stmt4->close();

	$newquantity = $event_ticket_no - $quantity1;

	$stmt5 = $mysqli->prepare("UPDATE system_events SET event_ticket_no=? WHERE eventid=?");
	$stmt5->bind_param('ii', $newquantity, $item_number1);
	$stmt5->execute();
	$stmt5->close();

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET transaction_id=?, payment_status =?, updated_on=?, completed_on=? WHERE invoice_id =?");
	$stmt5->bind_param('ssssi', $transaction_id, $payment_status, $updated_on, $completed_on, $invoice_id);
	$stmt5->execute();
	$stmt5->close();

	// subject
	$subject = 'Payment confirmation';

	// message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent payment! Below, you can find the payment summary:</p>';
	$message .= '<table rules="all" align="center" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Invoice ID:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $invoice_id</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Transaction ID:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $transaction_id</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $product_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Amount paid (&pound;):</strong> </td><td style=\"border: 1px solid #FFA500;\"> &pound;$product_amount</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment time and date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $payment_date</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment status:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $payment_status1</td></tr>";
	$message .= '</table>';
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

//EventsQuantityCheck function
function EventsQuantityCheck () {

	global $mysqli;

	$eventid = filter_input(INPUT_POST, 'eventid', FILTER_SANITIZE_STRING);
	$product_quantity = filter_input(INPUT_POST, 'product_quantity', FILTER_SANITIZE_STRING);

	$stmt1 = $mysqli->prepare("SELECT event_ticket_no FROM system_events WHERE eventid = ? LIMIT 1");
	$stmt1->bind_param('i', $eventid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($event_ticket_no);
	$stmt1->fetch();

	if ($product_quantity > $event_ticket_no) {
		echo 'error';
		$stmt1->close();
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//University map functions
//ImportLocations
function ImportLocations () {

	global $mysqli;
    global $category;
    global $category1;

	$stmt1 = $mysqli->prepare("DELETE FROM system_map_markers");
	$stmt1->execute();
	$stmt1->close();

    $url1 = 'https://student-portal.co.uk/includes/university-map/xml/locations.xml';
    $result1 = file_get_contents($url1);
    $universitymap_locations = new SimpleXMLElement($result1);

	$url2 = 'https://student-portal.co.uk/includes/university-map/xml/cycle_parking.xml';
	$result2 = file_get_contents($url2);
	$universitymap_cycle_parking = new SimpleXMLElement($result2);

    $url3 = 'https://student-portal.co.uk/includes/university-map/xml/atms.xml';
    $result3 = file_get_contents($url3);
    $universitymap_atms = new SimpleXMLElement($result3);

    //Locations
    foreach ($universitymap_locations->channel->item as $xml_var) {

    $title = $xml_var->title;
    $description = $xml_var->description;

    $namespaces = $xml_var->getNameSpaces(true);
    $latlong_selector = $xml_var->children($namespaces['geo']);

    $lat = $latlong_selector->lat;
    $long = $latlong_selector->long;

    $category = $xml_var->category;

    $stmt2 = $mysqli->prepare("INSERT INTO system_map_markers (marker_title, marker_description, marker_lat, marker_long, marker_category) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param('sssss', $title, $description, $lat, $long, $category);
    $stmt2->execute();
    $stmt2->close();
    }

    //Cycle Parking
	foreach ($universitymap_cycle_parking->Document->Placemark as $xml_var) {

	$title = $xml_var->name;
	$description = $xml_var->description;
    $latlong = $xml_var->Point->coordinates;

    list($lat, $long) = explode(',', $latlong);

	$category = 'cycle_parking';

	$stmt3 = $mysqli->prepare("INSERT INTO system_map_markers (marker_title, marker_description, marker_lat, marker_long, marker_category) VALUES (?, ?, ?, ?, ?)");
	$stmt3->bind_param('sssss', $title, $description, $long, $lat, $category);
	$stmt3->execute();
	$stmt3->close();
	}

    //Cycle Parking
	foreach ($universitymap_atms->Document->Folder->Placemark as $xml_var) {

	$title = $xml_var->name;
	$description = $xml_var->description;
    $latlong = $xml_var->Point->coordinates;

    list($lat, $long) = explode(',', $latlong);

	$category = 'ATM';

	$stmt3 = $mysqli->prepare("INSERT INTO system_map_markers (marker_title, marker_description, marker_lat, marker_long, marker_category) VALUES (?, ?, ?, ?, ?)");
	$stmt3->bind_param('sssss', $title, $description, $long, $lat, $category);
	$stmt3->execute();
	$stmt3->close();
	}

}

//Messenger functions
//MessageUser function
function MessageUser() {

	global $mysqli;
	global $userid;
	global $created_on;

	$message_to = filter_input(INPUT_POST, 'userid2', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname5', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname5', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email8', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$message_subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
	$message_body = filter_input(INPUT_POST, 'message1', FILTER_SANITIZE_STRING);

	$stmt1 = $mysqli->prepare("INSERT INTO user_messages (userid, message_subject, message_body, message_to, created_on) VALUES (?, ?, ?, ?, ?)");
	$stmt1->bind_param('issis', $userid, $message_subject, $message_body, $message_to, $created_on);
	$stmt1->execute();
	$stmt1->close();

	$stmt2 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($email1, $firstname1, $surname1);
	$stmt2->fetch();
	$stmt2->close();

	// subject
	$subject = "$firstname1 $surname1 - New message on Student Portal";

	// message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>The following person sent you a message:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$firstname1</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $surname1</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $email1</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Subject:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $message_subject</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Message:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $message_body</td></tr>";
	$message .= '</table><br>';
	$message .= '<a href="https://student-portal.co.uk/messenger">View message on Student Portal</a><br>';
	$message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
	$message .= '</body>';
	$message .= '</html>';
	$message .= '</body>';
	$message .= '</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= "From: $firstname1 $surname1 <$email1>" . "\r\n";
	$headers .= "Reply-To: $firstname1 $surname1 <$email1>" . "\r\n";

	// Mail it
	mail($email, $subject, $message, $headers);

}

function SetMessageRead () {

	global $mysqli;
	global $userid;

	$isRead = '1';
	$stmt1 = $mysqli->prepare("UPDATE user_messages SET isRead=? WHERE message_to=?");
	$stmt1->bind_param('ii', $isRead, $userid);
	$stmt1->execute();
	$stmt1->close();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//Account functions
//UpdateAccount function
function UpdateAccount() {

	global $mysqli;
	global $userid;
	global $updated_on;

	$firstname = filter_input(INPUT_POST, 'firstname1', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname1', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender1', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email4', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$nationality = filter_input(INPUT_POST, 'nationality', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);

	$gender = strtolower($gender);

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

	$stmt2 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt2->bind_param('sssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
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
	$message .= "<p>Dear $firstname,</p>";
	$message .= '<p>Your account has been updated succesfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@student-portal.co.uk">here</a>.';
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

	$stmt4 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt4->bind_param('ssssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
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
	$message .= "<p>Dear $firstname,</p>";
	$message .= '<p>Your account has been updated succesfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@student-portal.co.uk">here</a>.';
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

	$stmt3 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ?");
	$stmt3->bind_param('i', $userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($email, $firstname);
	$stmt3->fetch();

	// subject
	$subject = 'Password changed successfully';

	// message
	$message = '<html>';
	$message .= '<head>';
	$message .= '<title>Student Portal | Account</title>';
	$message .= '</head>';
	$message .= '<body>';
	$message .= "<p>Dear $firstname,</p>";
	$message .= '<p>Your password has been changed successfully.</p>';
	$message .= '<p>If this action wasn\'t performed by you, please contact Student Portal as soon as possible, by clicking <a href="mailto:contact@sergiu-tripon.co.uk">here</a>.';
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

//PaypalPaymentSuccess function
function FeesPaypalPaymentSuccess() {

	global $mysqli;
	global $updated_on;
	global $completed_on;

	$transaction_id  = $_POST["txn_id"];
	$payment_status = strtolower($_POST["payment_status"]);
	$payment_status1 = ($_POST["payment_status"]);
	$invoice_id = $_POST["invoice"];
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

	$product_name = $_POST["item_name1"];
	$product_amount = $_POST["mc_gross"];

	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoice_id = ? LIMIT 1");
	$stmt1->bind_param('i', $invoice_id);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

	$stmt2 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname, user_fees.isHalf FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid LEFT JOIN user_fees ON user_signin.userid=user_fees.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($email, $firstname, $surname, $isHalf);
	$stmt2->fetch();
	$stmt2->close();

	if ($product_amount == '9000.00' AND $isHalf == '0' ) {

	$full_fees = 0.00;
	$updated_on = date("Y-m-d G:i:s");

	$stmt3 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid = ? LIMIT 1");
	$stmt3->bind_param('isi', $full_fees, $updated_on, $userid);
	$stmt3->execute();
	$stmt3->close();

	} else {

	if ($product_amount == '4500.00' AND $isHalf == '0') {

	$half_fees = 4500.00;
	$isHalf = 1;

	$stmt3 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, isHalf=?, updated_on=? WHERE userid=? LIMIT 1");
	$stmt3->bind_param('iisi', $half_fees, $isHalf, $updated_on, $userid);
	$stmt3->execute();
	$stmt3->close();

	} else {

	$full_fees = 0.00;
	$updated_on = date("Y-m-d G:i:s");

	$stmt4 = $mysqli->prepare("UPDATE user_fees SET fee_amount=?, updated_on=? WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('isi', $full_fees, $updated_on, $userid);
	$stmt4->execute();
	$stmt4->close();

	}
	}

	$stmt8 = $mysqli->prepare("UPDATE paypal_log SET transaction_id=?, payment_status =?, updated_on=?, completed_on=? WHERE invoice_id =?");
	$stmt8->bind_param('ssssi', $transaction_id, $payment_status, $updated_on, $completed_on, $invoice_id);
	$stmt8->execute();
	$stmt8->close();

	// subject
	$subject = 'Payment confirmation';

	// message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent payment! Below, you can find the payment summary:</p>';
	$message .= '<table rules="all" align="center" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Invoice ID:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $invoice_id</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Transaction ID:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $transaction_id</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $product_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Amount paid (&pound;):</strong> </td><td style=\"border: 1px solid #FFA500;\"> &pound;$product_amount</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment time and date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $payment_date</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Payment status:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $payment_status1</td></tr>";
	$message .= '</table>';
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

//PaypalPaymentCancel function
function PaypalPaymentCancel() {

	global $mysqli;
	global $userid;
	global $updated_on;
	global $cancelled_on;

	$payment_status = 'cancelled';

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status = ?, updated_on=?, cancelled_on=? WHERE userid = ? ORDER BY payment_id DESC LIMIT 1");
	$stmt5->bind_param('sssi', $payment_status, $updated_on, $cancelled_on, $userid);
	$stmt5->execute();
	$stmt5->close();
}

//DeleteAccount function
function DeleteAccount() {

	global $mysqli;
	global $userid;

	$stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->close();

	session_unset();
	session_destroy();
}

//////////////////////////////////////////////////////////////////////////

//Admin account functions
//CreateAnAccount function
function CreateAnAccount() {

    global $mysqli;
    global $userid;
    global $created_on;

    $account_type = filter_input(INPUT_POST, 'account_type', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname2', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'gender2', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email5', FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password4', FILTER_SANITIZE_STRING);
	$nationality = filter_input(INPUT_POST, 'nationality1', FILTER_SANITIZE_STRING);
	$studentno = filter_input(INPUT_POST, 'studentno', FILTER_SANITIZE_STRING);
	$degree = filter_input(INPUT_POST, 'degree', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth1', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber1', FILTER_SANITIZE_STRING);
    $address1 = filter_input(INPUT_POST, 'address11', FILTER_SANITIZE_STRING);
    $address2 = filter_input(INPUT_POST, 'address21', FILTER_SANITIZE_STRING);
    $town = filter_input(INPUT_POST, 'town1', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city1', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country1', FILTER_SANITIZE_STRING);
    $postcode = filter_input(INPUT_POST, 'postcode1', FILTER_SANITIZE_STRING);

	$gender = strtolower($gender);

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

	$account_type = strtolower($account_type);

    $stmt4 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
    $stmt4->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
    $stmt4->execute();
    $stmt4->close();

    if (empty($dateofbirth)) {
        $dateofbirth = NULL;
    }

    $stmt5 = $mysqli->prepare("INSERT INTO user_details (firstname, surname, gender, studentno, degree, nationality, dateofbirth, phonenumber, address1, address2, town, city, country, postcode, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt5->bind_param('sssisssssssssss', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $created_on);
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
	$account_type = filter_input(INPUT_POST, 'account_type1', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'firstname3', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'surname3', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender3', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'studentno1', FILTER_SANITIZE_STRING);
    $degree = filter_input(INPUT_POST, 'degree1', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email6', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$nationality = filter_input(INPUT_POST, 'nationality2', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'dateofbirth2', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'phonenumber2', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'address12', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'address22', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'town2', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city2', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'country2', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'postcode2', FILTER_SANITIZE_STRING);

	$gender = strtolower($gender);

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

	$account_type = strtolower($account_type);

	$stmt2 = $mysqli->prepare("UPDATE user_signin SET account_type=?, updated_on=? WHERE userid = ?");
	$stmt2->bind_param('ssi', $account_type, $updated_on, $userid);
	$stmt2->execute();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt3->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
	$stmt3->execute();
	$stmt3->close();

	}

	else {

	$stmt4 = $mysqli->prepare("SELECT userid from user_signin where email = ?");
	$stmt4->bind_param('s', $email);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($db_userid);
	$stmt4->fetch();

	if ($stmt4->num_rows == 1) {
		header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
		exit();
		$stmt3->close();
	}
	else {

	$stmt5 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=? WHERE userid=?");
	$stmt5->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
	$stmt5->execute();
	$stmt5->close();

	$stmt6 = $mysqli->prepare("UPDATE user_signin SET account_type=?, email=?, updated_on=? WHERE userid = ?");
	$stmt6->bind_param('sssi', $account_type, $email, $updated_on, $userid);
	$stmt6->execute();
	$stmt6->close();

	}
	}
	}
}

//ChangeAccountPassword function
function ChangeAccountPassword() {

    global $mysqli;
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

/////////////////////////////////////////////////////////////////////////////////////////////
