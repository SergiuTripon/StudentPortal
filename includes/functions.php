<?php
include 'session.php';

//External functions
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

//////////////////////////////////////////////////////////////////////////////////////////

//SignIn function
function SignIn() {

	global $mysqli;
	global $session_userid;
    global $updated_on;

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

	$stmt3 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
	$stmt3->bind_param('isi', $isSignedIn, $updated_on, $userid);
	$stmt3->execute();
	$stmt3->close();

	// Setting a session variable
	$_SESSION['signedIn'] = true;

	$session_userid = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);

 	$_SESSION['session_userid'] = $session_userid;
	$_SESSION['account_type'] = $session_account_type;

	} else {
    $stmt1->close();
	header('HTTP/1.0 550 The password you entered is incorrect.');
    exit();
	}

	} else {
    $stmt1->close();
	header('HTTP/1.0 550 The email address you entered is incorrect.');
	exit();
	}

	}
}

//SignOut function
function SignOut() {

    global $mysqli;
    global $session_userid;
    global $updated_on;

    $isSignedIn = 0;

    $stmt1 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
    $stmt1->bind_param('isi', $isSignedIn, $updated_on, $session_userid);
    $stmt1->execute();
    $stmt1->close();

    session_unset();
    session_destroy();
    header('Location: /');
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
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_userid);
	$stmt1->fetch();

	if ($stmt1->num_rows == 1) {
        $stmt1->close();
	    header('HTTP/1.0 550 An account with the email address entered already exists.');
	    exit();
	}

	$account_type = 'student';
	$password_hash = password_hash($password, PASSWORD_BCRYPT);

    //Creating user
	$stmt2 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
	$stmt2->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
	$stmt2->execute();
	$stmt2->close();

    //Creating user details
	$stmt3 = $mysqli->prepare("INSERT INTO user_details (firstname, surname, gender, created_on) VALUES (?, ?, ?, ?)");
	$stmt3->bind_param('ssss', $firstname, $surname, $gender, $created_on);
	$stmt3->execute();
	$stmt3->close();

    //Creating user token
	$token = null;

	$stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
	$stmt5->bind_param('s', $token);
	$stmt5->execute();
	$stmt5->close();

    //Creating user fees
	$fee_amount = '9000.00';

	$stmt6 = $mysqli->prepare("INSERT INTO user_fees (fee_amount, created_on) VALUES (?, ?)");
	$stmt6->bind_param('is', $fee_amount, $created_on);
	$stmt6->execute();
	$stmt6->close();

	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

//SendPasswordToken function
function SendPasswordToken() {

	global $mysqli;
	global $created_on;

	$email = filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

	// Getting userid using the email
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();

	if ($stmt1->num_rows == 1) {

		$uniqueid = uniqid(true);
		$token = password_hash($uniqueid, PASSWORD_BCRYPT);

		$stmt2 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
		$stmt2>bind_param('ssi', $token, $created_on, $userid);
		$stmt2->execute();
		$stmt2->close();

        //Creating link to be sent to the user
		$passwordlink = "<a href=https://student-portal.co.uk/password-reset/?token=$token>here</a>";

        //Getting firstname, surname using userid
        $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
        $stmt3->bind_param('i', $userid);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($firstname, $surname);
        $stmt3->fetch();
        $stmt3->close();

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

		$stmt1->close();
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

    //Getting userid using email
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();

    //Getting token from database
	$stmt2 = $mysqli->prepare("SELECT user_token.token, user_details.firstname FROM user_token LEFT JOIN user_details ON user_token.userid=user_details.userid WHERE user_token.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($db_token, $firstname);
	$stmt2->fetch();

    //Comparing client side token with database token
	if ($token == $db_token) {

    //Hashing the password
	$password_hash = password_hash($password, PASSWORD_BCRYPT);

    //Changing the password
	$stmt4 = $mysqli->prepare("UPDATE user_signin SET password = ?, updated_on = ? WHERE email = ? LIMIT 1");
	$stmt4->bind_param('sss', $password_hash, $updated_on, $email);
	$stmt4->execute();
	$stmt4->close();

    //Emptying token table
	$empty_token = NULL;
	$empty_created_on = NULL;

	$stmt4 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('ssi', $empty_token, $empty_created_on, $userid);
	$stmt4->execute();
	$stmt4->close();

    //Creating email
	$subject = 'Password reset successfully';

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

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	mail($email, $subject, $message, $headers);

	} else {
        header('HTTP/1.0 550 The password reset key is invalid.');
        exit();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////

//Overview functions
//GetDashboardData function
function GetDashboardData() {

	global $mysqli;
	global $session_userid;
	global $timetable_count;
	global $exams_count;
    global $results_count;
	global $library_count;
	global $calendar_count;
	global $events_count;
	global $messenger_count;
    global $feedback_count;
    global $feedback_admin_count;

    $lecture_status = 'active';

	$stmt1 = $mysqli->prepare("SELECT system_lectures.lectureid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid=? AND lecture_status=?");
	$stmt1->bind_param('is', $session_userid, $lecture_status);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($lectureid);
	$stmt1->fetch();

    $tutorial_status = 'active';

	$stmt2 = $mysqli->prepare("SELECT system_tutorials.tutorialid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid=? AND tutorial_status=?");
	$stmt2->bind_param('is', $session_userid, $tutorial_status);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($tutorialid);
	$stmt2->fetch();

    $exam_status = 'active';

	$stmt3 = $mysqli->prepare("SELECT system_exams.examid FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_exams ON user_timetable.moduleid=system_exams.moduleid WHERE user_timetable.userid=? AND exam_status=?");
	$stmt3->bind_param('is', $session_userid, $exam_status);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($examid);
	$stmt3->fetch();

    $stmt4 = $mysqli->prepare("SELECT resultid FROM user_results WHERE userid=?");
    $stmt4->bind_param('i', $session_userid);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($resultid);
    $stmt4->fetch();

    $book_reserved = 'reserved';

	$stmt5 = $mysqli->prepare("SELECT reserved_books.bookid FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid  WHERE reserved_books.userid = ? AND system_books.book_status = ? AND isReturned = '0'");
	$stmt5->bind_param('is', $session_userid, $book_reserved);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($bookid);
	$stmt5->fetch();

	$task_status = 'active';

	$stmt6 = $mysqli->prepare("SELECT taskid FROM user_tasks WHERE userid = ? AND task_status = ?");
	$stmt6->bind_param('is', $session_userid, $task_status);
	$stmt6->execute();
	$stmt6->store_result();
	$stmt6->bind_result($taskid);
	$stmt6->fetch();

	$stmt7 = $mysqli->prepare("SELECT eventid FROM booked_events WHERE userid = ?");
	$stmt7->bind_param('i', $session_userid);
	$stmt7->execute();
	$stmt7->store_result();
	$stmt7->bind_result($eventid);
	$stmt7->fetch();

	$isRead = '0';
	$stmt8 = $mysqli->prepare("SELECT message_from FROM user_messages_lookup WHERE message_to=? AND isRead=?");
	$stmt8->bind_param('ii', $session_userid, $isRead);
	$stmt8->execute();
	$stmt8->store_result();
	$stmt8->bind_result($message_from);
	$stmt8->fetch();

    $isRead = 0;
    $isApproved = 1;

    $stmt9 = $mysqli->prepare("SELECT user_feedback_lookup.feedbackid FROM user_feedback_lookup WHERE module_staff=? AND isRead=? AND isApproved=?");
    $stmt9->bind_param('iii', $session_userid, $isRead, $isApproved);
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->bind_result($feedbackid);
    $stmt9->fetch();

    $admin_isApproved = 0;

    $stmt10 = $mysqli->prepare("SELECT DISTINCT user_feedback_lookup.feedbackid FROM user_feedback_lookup WHERE isApproved=? AND isRead=?");
    $stmt10->bind_param('ii', $admin_isApproved, $isRead);
    $stmt10->execute();
    $stmt10->store_result();
    $stmt10->bind_result($feedbackid);
    $stmt10->fetch();

	$lectures_count = $stmt1->num_rows;
	$tutorials_count = $stmt2->num_rows;
	$timetable_count = $lectures_count + $tutorials_count;
	$exams_count = $stmt3->num_rows;
    $results_count = $stmt4->num_rows;
	$library_count = $stmt5->num_rows;
	$calendar_count = $stmt6->num_rows;
	$events_count = $stmt7->num_rows;
	$messenger_count = $stmt8->num_rows;
    $feedback_count = $stmt9->num_rows;
    $feedback_admin_count = $stmt10->num_rows;

	$stmt1->close();
	$stmt2->close();
	$stmt3->close();
    $stmt4->close();
    $stmt5->close();
    $stmt6->close();
    $stmt7->close();
    $stmt8->close();
    $stmt9->close();
    $stmt10->close();

}

//////////////////////////////////////////////////////////////////////////////////////////

//Timetable functions
//AssignTimetable function
function AllocateTimetable() {

    global $mysqli;

    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $timetableToAllocate = filter_input(INPUT_POST, 'timetableToAllocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("INSERT INTO user_timetable (userid, moduleid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $timetableToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateTimetable function
function DeallocateTimetable() {

    global $mysqli;

    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $timetableToDeallocate = filter_input(INPUT_POST, 'timetableToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_timetable WHERE userid=? AND moduleid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $timetableToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

//CreateTimetable function
function CreateTimetable() {

    global $mysqli;
    global $moduleid;
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

    //Tutorial
    $tutorial_name = filter_input(INPUT_POST, 'tutorial_name', FILTER_SANITIZE_STRING);
    $tutorial_assistant = filter_input(INPUT_POST, 'tutorial_assistant', FILTER_SANITIZE_STRING);
    $tutorial_notes = filter_input(INPUT_POST, 'tutorial_notes', FILTER_SANITIZE_STRING);
    $tutorial_day = filter_input(INPUT_POST, 'tutorial_day', FILTER_SANITIZE_STRING);
    $tutorial_from_time = filter_input(INPUT_POST, 'tutorial_from_time', FILTER_SANITIZE_STRING);
    $tutorial_to_time = filter_input(INPUT_POST, 'tutorial_to_time', FILTER_SANITIZE_STRING);
    $tutorial_from_date = filter_input(INPUT_POST, 'tutorial_from_date', FILTER_SANITIZE_STRING);
    $tutorial_to_date = filter_input(INPUT_POST, 'tutorial_to_date', FILTER_SANITIZE_STRING);
    $tutorial_location = filter_input(INPUT_POST, 'tutorial_location', FILTER_SANITIZE_STRING);
    $tutorial_capacity = filter_input(INPUT_POST, 'tutorial_capacity', FILTER_SANITIZE_STRING);

    //Exam
    $exam_name = filter_input(INPUT_POST, 'exam_name', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'exam_notes', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'exam_date', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'exam_time', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'exam_location', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'exam_capacity', FILTER_SANITIZE_STRING);

    // Check existing module name
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_modules WHERE module_name = ? LIMIT 1");
    $stmt1->bind_param('s', $module_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_moduleid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A module with the name entered already exists.');
        exit();
    }

    // Check existing lecture name
    $stmt2 = $mysqli->prepare("SELECT lectureid FROM system_lectures WHERE lecture_name = ? LIMIT 1");
    $stmt2->bind_param('s', $lecture_name);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_lectureid);
    $stmt2->fetch();

    if ($stmt2->num_rows == 1) {
        $stmt2->close();
        header('HTTP/1.0 550 A lecture with the name entered already exists.');
        exit();
    }

    // Check existing tutorial name
    $stmt3 = $mysqli->prepare("SELECT tutorialid FROM system_tutorials WHERE tutorial_name = ? LIMIT 1");
    $stmt3->bind_param('s', $tutorial_name);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($db_tutorialid);
    $stmt3->fetch();

    if ($stmt3->num_rows == 1) {
        $stmt3->close();
        header('HTTP/1.0 550 A tutorial with the name entered already exists.');
        exit();
    }

    // Check existing exam name
    $stmt4 = $mysqli->prepare("SELECT examid FROM system_exams WHERE exam_name = ? LIMIT 1");
    $stmt4->bind_param('s', $exam_name);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($db_examid);
    $stmt4->fetch();

    if ($stmt4->num_rows == 1) {
        $stmt4->close();
        header('HTTP/1.0 550 An exam with the name entered already exists.');
        exit();
    }

    $module_status = 'active';

    $stmt5 = $mysqli->prepare("INSERT INTO system_modules (module_name, module_notes, module_url, module_status, created_on) VALUES (?, ?, ?, ?, ?)");
    $stmt5->bind_param('sssss', $module_name, $module_notes, $module_url, $module_status, $created_on);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("SELECT moduleid FROM system_modules ORDER BY moduleid DESC LIMIT 1");
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($moduleid);
    $stmt6->fetch();
    $stmt6->close();

    $lecture_status = 'active';

    $stmt7 = $mysqli->prepare("INSERT INTO system_lectures (moduleid, lecture_name, lecture_lecturer, lecture_notes, lecture_day, lecture_from_time, lecture_to_time, lecture_from_date, lecture_to_date, lecture_location, lecture_capacity, lecture_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt7->bind_param('isisssssssiss', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $lecture_status, $created_on);
    $stmt7->execute();
    $stmt7->close();

    $tutorial_status = 'active';

    $stmt8 = $mysqli->prepare("INSERT INTO system_tutorials (moduleid, tutorial_name, tutorial_assistant, tutorial_notes, tutorial_day, tutorial_from_time, tutorial_to_time, tutorial_from_date, tutorial_to_date, tutorial_location, tutorial_capacity, tutorial_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt8->bind_param('isisssssssiss', $moduleid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $tutorial_status, $created_on);
    $stmt8->execute();
    $stmt8->close();

    $exam_status = 'active';

    $stmt9 = $mysqli->prepare("INSERT INTO system_exams (moduleid, exam_name, exam_notes, exam_date, exam_time, exam_location, exam_capacity, exam_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt9->bind_param('issssssss', $moduleid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $exam_status, $created_on);
    $stmt9->execute();
    $stmt9->close();
}

//UpdateTimetable function
function UpdateTimetable() {

    global $mysqli;
    global $updated_on;

    //Module
    $moduleid = filter_input(INPUT_POST, 'moduleid', FILTER_SANITIZE_STRING);
    $module_name = filter_input(INPUT_POST, 'module_name1', FILTER_SANITIZE_STRING);
    $module_notes = filter_input(INPUT_POST, 'module_notes1', FILTER_SANITIZE_STRING);
    $module_url = filter_input(INPUT_POST, 'module_url1', FILTER_SANITIZE_STRING);

    //Lecture
    $lectureid = filter_input(INPUT_POST, 'lectureid', FILTER_SANITIZE_STRING);
    $lecture_name = filter_input(INPUT_POST, 'lecture_name1', FILTER_SANITIZE_STRING);
    $lecture_lecturer = filter_input(INPUT_POST, 'lecture_lecturer1', FILTER_SANITIZE_STRING);
    $lecture_notes = filter_input(INPUT_POST, 'lecture_notes1', FILTER_SANITIZE_STRING);
    $lecture_day = filter_input(INPUT_POST, 'lecture_day1', FILTER_SANITIZE_STRING);
    $lecture_from_time = filter_input(INPUT_POST, 'lecture_from_time1', FILTER_SANITIZE_STRING);
    $lecture_to_time = filter_input(INPUT_POST, 'lecture_to_time1', FILTER_SANITIZE_STRING);
    $lecture_from_date = filter_input(INPUT_POST, 'lecture_from_date1', FILTER_SANITIZE_STRING);
    $lecture_to_date = filter_input(INPUT_POST, 'lecture_to_date1', FILTER_SANITIZE_STRING);
    $lecture_location = filter_input(INPUT_POST, 'lecture_location1', FILTER_SANITIZE_STRING);
    $lecture_capacity = filter_input(INPUT_POST, 'lecture_capacity1', FILTER_SANITIZE_STRING);

    //Tutorial
    $tutorialid = filter_input(INPUT_POST, 'tutorialid', FILTER_SANITIZE_STRING);
    $tutorial_name = filter_input(INPUT_POST, 'tutorial_name1', FILTER_SANITIZE_STRING);
    $tutorial_assistant = filter_input(INPUT_POST, 'tutorial_assistant1', FILTER_SANITIZE_STRING);
    $tutorial_notes = filter_input(INPUT_POST, 'tutorial_notes1', FILTER_SANITIZE_STRING);
    $tutorial_day = filter_input(INPUT_POST, 'tutorial_day1', FILTER_SANITIZE_STRING);
    $tutorial_from_time = filter_input(INPUT_POST, 'tutorial_from_time1', FILTER_SANITIZE_STRING);
    $tutorial_to_time = filter_input(INPUT_POST, 'tutorial_to_time1', FILTER_SANITIZE_STRING);
    $tutorial_from_date = filter_input(INPUT_POST, 'tutorial_from_date1', FILTER_SANITIZE_STRING);
    $tutorial_to_date = filter_input(INPUT_POST, 'tutorial_to_date1', FILTER_SANITIZE_STRING);
    $tutorial_location = filter_input(INPUT_POST, 'tutorial_location1', FILTER_SANITIZE_STRING);
    $tutorial_capacity = filter_input(INPUT_POST, 'tutorial_capacity1', FILTER_SANITIZE_STRING);

    //Exam
    $examid = filter_input(INPUT_POST, 'examid', FILTER_SANITIZE_STRING);
    $exam_name = filter_input(INPUT_POST, 'exam_name1', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'exam_notes1', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'exam_date1', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'exam_time1', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'exam_location1', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'exam_capacity1', FILTER_SANITIZE_STRING);

    //Module
    $stmt1 = $mysqli->prepare("SELECT module_name FROM system_modules WHERE moduleid = ?");
    $stmt1->bind_param('i', $moduleid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_module_name);
    $stmt1->fetch();

    if ($db_module_name === $module_name) {
        $stmt2 = $mysqli->prepare("UPDATE system_modules SET module_notes=?, module_url=?, updated_on=? WHERE moduleid=?");
        $stmt2->bind_param('sssi', $module_notes, $module_url, $updated_on, $moduleid);
        $stmt2->execute();
        $stmt2->close();
    } else {

        $stmt3 = $mysqli->prepare("SELECT moduleid FROM system_modules WHERE module_name = ?");
        $stmt3->bind_param('s', $module_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_moduleid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A module with the name entered already exists.');
            exit();
        } else {
            $stmt4 = $mysqli->prepare("UPDATE system_modules SET module_name=?, module_notes=?, module_url=?, updated_on=? WHERE moduleid=?");
            $stmt4->bind_param('ssssi', $module_name, $module_notes, $module_url, $updated_on, $moduleid);
            $stmt4->execute();
            $stmt4->close();
        }
    }

    //Lecture
    $stmt5 = $mysqli->prepare("SELECT lecture_name FROM system_lectures WHERE lectureid = ?");
    $stmt5->bind_param('i', $lectureid);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($db_lecture_name);
    $stmt5->fetch();

    if ($db_lecture_name === $lecture_name) {
        $stmt6 = $mysqli->prepare("UPDATE system_lectures SET lecture_lecturer=?, lecture_notes=?, lecture_day=?, lecture_from_time=?, lecture_to_time=?, lecture_from_date=?, lecture_to_date=?, lecture_location=?, lecture_capacity=?, updated_on=? WHERE lectureid=?");
        $stmt6->bind_param('isssssssisi', $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $updated_on, $lectureid);
        $stmt6->execute();
        $stmt6->close();
    } else {
        $stmt7 = $mysqli->prepare("SELECT lectureid FROM system_lectures WHERE lecture_name = ?");
        $stmt7->bind_param('s', $lecture_name);
        $stmt7->execute();
        $stmt7->store_result();
        $stmt7->bind_result($db_lectureid);
        $stmt7->fetch();

        if ($stmt7->num_rows == 1) {
            $stmt7->close();
            header('HTTP/1.0 550 A lecture with the name entered already exists.');
            exit();
        } else {
            $stmt8 = $mysqli->prepare("UPDATE system_lectures SET lecture_name=?, lecture_lecturer=?, lecture_notes=?, lecture_day=?, lecture_from_time=?, lecture_to_time=?, lecture_from_date=?, lecture_to_date=?, lecture_location=?, lecture_capacity=?, updated_on=? WHERE lectureid=?");
            $stmt8->bind_param('sisssssssisi', $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $updated_on, $lectureid);
            $stmt8->execute();
            $stmt8->close();
        }
    }

    //Tutorial
    $stmt9 = $mysqli->prepare("SELECT tutorial_name FROM system_tutorials WHERE tutorialid = ?");
    $stmt9->bind_param('i', $tutorialid);
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->bind_result($db_tutorial_name);
    $stmt9->fetch();

    if ($db_tutorial_name === $tutorial_name) {
        $stmt10 = $mysqli->prepare("UPDATE system_tutorials SET tutorial_assistant=?, tutorial_notes=?, tutorial_day=?, tutorial_from_time=?, tutorial_to_time=?, tutorial_from_date=?, tutorial_to_date=?, tutorial_location=?, tutorial_capacity=?, updated_on=? WHERE tutorialid=?");
        $stmt10->bind_param('isssssssisi', $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $updated_on, $tutorialid);
        $stmt10->execute();
        $stmt10->close();
    } else {
        $stmt11 = $mysqli->prepare("SELECT tutorialid FROM system_tutorials WHERE tutorial_name = ?");
        $stmt11->bind_param('s', $tutorial_name);
        $stmt11->execute();
        $stmt11->store_result();
        $stmt11->bind_result($db_tutorialid);
        $stmt11->fetch();

        if ($stmt11->num_rows == 1) {
            $stmt11->close();
            header('HTTP/1.0 550 A tutorial with the name entered already exists.');
            exit();
        } else {
            $stmt12 = $mysqli->prepare("UPDATE system_tutorials SET tutorial_name=?, tutorial_assistant=?, tutorial_notes=?, tutorial_day=?, tutorial_from_time=?, tutorial_to_time=?, tutorial_from_date=?, tutorial_to_date=?, tutorial_location=?, tutorial_capacity=?, updated_on=? WHERE tutorialid=?");
            $stmt12->bind_param('sisssssssisi', $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $updated_on, $tutorialid);
            $stmt12->execute();
            $stmt12->close();
        }
    }

    //Exam
    $stmt13 = $mysqli->prepare("SELECT exam_name FROM system_exams WHERE examid = ?");
    $stmt13->bind_param('i', $examid);
    $stmt13->execute();
    $stmt13->store_result();
    $stmt13->bind_result($db_exam_name);
    $stmt13->fetch();

    if ($db_tutorial_name === $tutorial_name) {
        $stmt14 = $mysqli->prepare("UPDATE system_exams SET exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
        $stmt14->bind_param('ssssssi', $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
        $stmt14->execute();
        $stmt14->close();
    } else {
        $stmt15 = $mysqli->prepare("SELECT examid FROM system_exams WHERE exam_name = ?");
        $stmt15->bind_param('s', $exam_name);
        $stmt15->execute();
        $stmt15->store_result();
        $stmt15->bind_result($db_examid);
        $stmt15->fetch();

        if ($stmt15->num_rows == 1) {
            $stmt15->close();
            header('HTTP/1.0 550 An exam with the name entered already exists.');
            exit();
        } else {
            $stmt16 = $mysqli->prepare("UPDATE system_exams SET exam_name=?, exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
            $stmt16->bind_param('sssssssi', $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
            $stmt16->execute();
            $stmt16->close();
        }
    }

}

//DeleteTimetable function
function DeleteTimetable() {

    global $mysqli;

    $timetableToDelete = filter_input(INPUT_POST, 'timetableToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_lookup WHERE moduleid=?");
    $stmt1->bind_param('i', $timetableToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_results WHERE moduleid=?");
    $stmt2->bind_param('i', $timetableToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM system_exams WHERE moduleid=?");
    $stmt3->bind_param('i', $timetableToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM system_tutorials WHERE moduleid=?");
    $stmt4->bind_param('i', $timetableToDelete);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM system_lectures WHERE moduleid=?");
    $stmt5->bind_param('i', $timetableToDelete);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("DELETE FROM user_timetable WHERE moduleid=?");
    $stmt6->bind_param('i', $timetableToDelete);
    $stmt6->execute();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("DELETE FROM system_modules WHERE moduleid=?");
    $stmt7->bind_param('i', $timetableToDelete);
    $stmt7->execute();
    $stmt7->close();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CreateResult function
function CreateResult() {

    global $mysqli;
    global $created_on;

    $result_userid = filter_input(INPUT_POST, 'result_userid', FILTER_SANITIZE_NUMBER_INT);
    $result_moduleid = filter_input(INPUT_POST, 'result_moduleid', FILTER_SANITIZE_NUMBER_INT);
    $result_coursework_mark = filter_input(INPUT_POST, 'result_coursework_mark', FILTER_SANITIZE_STRING);
    $result_exam_mark = filter_input(INPUT_POST, 'result_exam_mark', FILTER_SANITIZE_STRING);
    $result_overall_mark = filter_input(INPUT_POST, 'result_overall_mark', FILTER_SANITIZE_STRING);
    $result_notes = filter_input(INPUT_POST, 'result_notes', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("INSERT INTO user_results (userid, moduleid, result_coursework_mark, result_exam_mark, result_overall_mark, result_notes, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iisssss', $result_userid, $result_moduleid, $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $created_on);
    $stmt1->execute();
    $stmt1->close();
}

//UpdateResult function
function UpdateResult() {

    global $mysqli;
    global $updated_on;

    $result_resultid = filter_input(INPUT_POST, 'result_resultid', FILTER_SANITIZE_NUMBER_INT);
    $result_coursework_mark = filter_input(INPUT_POST, 'result_coursework_mark1', FILTER_SANITIZE_STRING);
    $result_exam_mark = filter_input(INPUT_POST, 'result_exam_mark1', FILTER_SANITIZE_STRING);
    $result_overall_mark = filter_input(INPUT_POST, 'result_overall_mark1', FILTER_SANITIZE_STRING);
    $result_notes = filter_input(INPUT_POST, 'result_notes1', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("UPDATE user_results SET result_coursework_mark=?, result_exam_mark=?, result_overall_mark=?, result_notes=?, updated_on=? WHERE resultid=?");
    $stmt1->bind_param('sssssi', $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $updated_on, $result_resultid);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteResult function
function DeleteResult() {

    global $mysqli;

    $result_resultid = filter_input(INPUT_POST, 'resultToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_results WHERE resultid=?");
    $stmt1->bind_param('i', $result_resultid);
    $stmt1->execute();
    $stmt1->close();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Library functions
//ReserveBook function
function ReserveBook() {

	global $mysqli;
	global $session_userid;

	$bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_STRING);
	$book_name = filter_input(INPUT_POST, 'book_name', FILTER_SANITIZE_STRING);
	$book_author = filter_input(INPUT_POST, 'book_author', FILTER_SANITIZE_STRING);
	$bookreserved_from = filter_input(INPUT_POST, 'bookreserved_from', FILTER_SANITIZE_STRING);
	$bookreserved_to = filter_input(INPUT_POST, 'bookreserved_to', FILTER_SANITIZE_STRING);

	$book_class = 'event-info';
	$isReturned = 0;

	$stmt1 = $mysqli->prepare("INSERT INTO reserved_books (userid, bookid, book_class, reserved_on, toreturn_on, isReturned) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt1->bind_param('iisssi', $session_userid, $bookid, $book_class, $bookreserved_from, $bookreserved_to, $isReturned);
	$stmt1->execute();
	$stmt1->close();

	$book_status = 'reserved';

	$stmt3 = $mysqli->prepare("UPDATE system_books SET book_status=? WHERE bookid =?");
	$stmt3->bind_param('si', $book_status, $bookid);
	$stmt3->execute();
	$stmt3->close();

	$stmt4 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname, user_details.studentno FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt4->bind_param('i', $session_userid);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($email, $firstname, $surname, $studentno);
	$stmt4->fetch();
	$stmt4->close();

	$reservation_status = 'Completed';

	//Creating email
	$subject = 'Reservation confirmation';

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

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	mail($email, $subject, $message, $headers);
}

//RequestBook function
function RequestBook() {

    global $mysqli;
    global $session_userid;

    //Book
    $bookToRequest = filter_input(INPUT_POST, 'bookToRequest', FILTER_SANITIZE_STRING);


    $stmt1 = $mysqli->prepare("SELECT reserved_books.userid, reserved_books.reserved_on, reserved_books.toreturn_on, system_books.book_name, system_books.book_author, system_books.book_status FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid WHERE reserved_books.bookid=?");
    $stmt1->bind_param('i', $bookToRequest);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($userid, $bookreserved_from, $bookreserved_to, $book_name, $book_author, $book_status);
    $stmt1->fetch();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname, user_details.studentno FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt2->bind_param('i', $userid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($reservee_email, $reservee_firstname, $reservee_surname, $reservee_studentno);
    $stmt2->fetch();
    $stmt2->close();

    $stmt2 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname, user_details.studentno FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt2->bind_param('i', $session_userid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($requester_email, $requester_firstname, $requester_surname, $requester_studentno);
    $stmt2->fetch();
    $stmt2->close();

    $book_status = ucfirst($book_status);

    //Creating email
    $subject = 'Request notice';

    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>Hi! Someone requested a book you reserved. Below, you can find the request summary:</p>';
    $message .= '<table rules="all" align="left" cellpadding="10" style="color: #FFA500; background-color: #333333; border: 1px solid #FFA500;">';
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #FFA500;\">$requester_firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $requester_surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $requester_email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $requester_studentno</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $book_name</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $book_author</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $bookreserved_from</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $bookreserved_to</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #FFA500;\"><strong>Book status:</strong> </td><td style=\"border: 1px solid #FFA500;\"> $book_status</td></tr>";
    $message .= '</table>';
    $message .= '</body>';
    $message .= '</html>';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
    $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

    mail("$reservee_email, admin@student-portal.co.uk", $subject, $message, $headers);

}

//ReturnBook function
function ReturnBook() {

    global $mysqli;
    global $updated_on;

    //Book
    $bookToReturn = filter_input(INPUT_POST, 'bookToReturn', FILTER_SANITIZE_STRING);

    $isReturned = 1;

    $stmt1 = $mysqli->prepare("UPDATE reserved_books SET returned_on=?, isReturned=? WHERE bookid=? ORDER BY DESC");
    $stmt1->bind_param('sii', $updated_on, $isReturned, $bookToReturn);
    $stmt1->execute();
    $stmt1->close();

    $book_status = 'active';

    $stmt2 = $mysqli->prepare("UPDATE system_books SET book_status=?, updated_on=? WHERE bookid=?");
    $stmt2->bind_param('ssi', $book_status, $updated_on, $bookToReturn);
    $stmt2->execute();
    $stmt2->close();


}

//CreateBook function
function CreateBook() {

    global $mysqli;
    global $created_on;

    //Book
    $book_name = filter_input(INPUT_POST, 'book_name', FILTER_SANITIZE_STRING);
    $book_author = filter_input(INPUT_POST, 'book_author', FILTER_SANITIZE_STRING);
    $book_notes = filter_input(INPUT_POST, 'book_notes', FILTER_SANITIZE_STRING);
    $book_copy_no = filter_input(INPUT_POST, 'book_copy_no', FILTER_SANITIZE_STRING);

    //If book exists, increase copy number
    $stmt1 = $mysqli->prepare("SELECT bookid, book_copy_no FROM system_books WHERE book_name=? AND book_author=? ORDER BY bookid DESC LIMIT 1");
    $stmt1->bind_param('ss', $book_name, $book_author);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_bookid, $db_book_copy_no);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {

        $book_status = 'active';
        $book_copy_no = $db_book_copy_no + 1;

        $stmt5 = $mysqli->prepare("INSERT INTO system_books (book_name, book_author, book_notes, book_copy_no, book_status, created_on) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssiss', $book_name, $book_author, $book_notes, $book_copy_no, $book_status, $created_on);
        $stmt5->execute();
        $stmt5->close();

    } else {

        $book_status = 'active';

        $stmt5 = $mysqli->prepare("INSERT INTO system_books (book_name, book_author, book_notes, book_copy_no, book_status, created_on) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssiss', $book_name, $book_author, $book_notes, $book_copy_no, $book_status, $created_on);
        $stmt5->execute();
        $stmt5->close();

    }
}

//UpdateBook function
function UpdateBook()
{

    global $mysqli;
    global $updated_on;

    //Book
    $bookid = filter_input(INPUT_POST, 'bookid1', FILTER_SANITIZE_STRING);
    $book_name = filter_input(INPUT_POST, 'book_name1', FILTER_SANITIZE_STRING);
    $book_author = filter_input(INPUT_POST, 'book_author1', FILTER_SANITIZE_STRING);
    $book_notes = filter_input(INPUT_POST, 'book_notes1', FILTER_SANITIZE_STRING);
    $book_copy_no = filter_input(INPUT_POST, 'book_copy_no1', FILTER_SANITIZE_STRING);

    $stmt5 = $mysqli->prepare("UPDATE system_books SET book_name=?, book_author=?, book_notes=?, book_copy_no=?, updated_on=? WHERE bookid=?");
    $stmt5->bind_param('sssisi', $book_name, $book_author, $book_notes, $book_copy_no, $updated_on, $bookid);
    $stmt5->execute();
    $stmt5->close();
}

//DeleteBook function
function DeleteBook() {

    global $mysqli;

    $bookToDelete = filter_input(INPUT_POST, 'bookToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM reserved_books WHERE bookid=?");
    $stmt1->bind_param('i', $bookToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM system_books WHERE bookid=?");
    $stmt2->bind_param('i', $bookToDelete);
    $stmt2->execute();
    $stmt2->close();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Transport functions
function GetTubeLineLiveStatus() {

	global $mysqli;
    global $bakerloo, $bakerloo1, $central, $central1, $circle, $circle1, $district, $district1, $hammersmith, $hammersmith1, $jubilee, $jubilee1, $metropolitan, $metropolitan1, $northern, $northern1, $piccadilly, $piccadilly1, $victoria, $victoria1, $waterloo, $waterloo1, $overground, $overground1, $dlr, $dlr1;

    $stmt1 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Bakerloo'");
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bakerloo, $bakerloo1);
    $stmt1->fetch();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Central'");
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($central, $central1);
    $stmt2->fetch();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Circle'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($circle, $circle1);
    $stmt3->fetch();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='District'");
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($district, $district1);
    $stmt4->fetch();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Hammersmith and City'");
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($hammersmith, $hammersmith1);
    $stmt5->fetch();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Jubilee'");
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($jubilee, $jubilee1);
    $stmt6->fetch();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Metropolitan'");
    $stmt7->execute();
    $stmt7->store_result();
    $stmt7->bind_result($metropolitan, $metropolitan1);
    $stmt7->fetch();
    $stmt7->close();

    $stmt8 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Northern'");
    $stmt8->execute();
    $stmt8->store_result();
    $stmt8->bind_result($northern, $northern1);
    $stmt8->fetch();
    $stmt8->close();

    $stmt9 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Piccadilly'");
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->bind_result($piccadilly, $piccadilly1);
    $stmt9->fetch();
    $stmt9->close();

    $stmt10 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Victoria'");
    $stmt10->execute();
    $stmt10->store_result();
    $stmt10->bind_result($victoria, $victoria1);
    $stmt10->fetch();
    $stmt10->close();

    $stmt11 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Waterloo and City'");
    $stmt11->execute();
    $stmt11->store_result();
    $stmt11->bind_result($waterloo, $waterloo1);
    $stmt11->fetch();
    $stmt11->close();

    $stmt12 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Overground'");
    $stmt12->execute();
    $stmt12->store_result();
    $stmt12->bind_result($overground, $overground1);
    $stmt12->fetch();
    $stmt12->close();

    $stmt13 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='DLR'");
    $stmt13->execute();
    $stmt13->store_result();
    $stmt13->bind_result($dlr, $dlr1);
    $stmt13->fetch();
    $stmt13->close();

}

function GetTubeThisWeekendStatus() {

    global $xml_this_weekend;

    $url = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
    $result = file_get_contents($url);
    $xml_this_weekend = new SimpleXMLElement($result);
}

function GetTransportStatusLastUpdated() {

    global $mysqli;
    global $transport_status_last_updated;

    $stmt1 = $mysqli->prepare("SELECT DISTINCT DATE_FORMAT(updated_on,'%H:%i') AS updated_on from tube_line_status_now LIMIT 1");
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($transport_status_last_updated);
    $stmt1->fetch();
    $stmt1->close();

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Calendar functions
//CreateTask function
function CreateTask () {

	global $mysqli;
	global $session_userid;
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
    $stmt1->bind_param('si', $task_name, $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_taskid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {

        $stmt1->close();
	    header('HTTP/1.0 550 A task with the task name entered already exists.');
	    exit();

    } else {

        $task_status = 'active';

	    $stmt2 = $mysqli->prepare("INSERT INTO user_tasks (userid, task_name, task_notes, task_url, task_class, task_startdate, task_duedate, task_category, task_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    $stmt2->bind_param('isssssssss', $session_userid, $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_category, $task_status, $created_on);
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

	} else {

        $stmt3 = $mysqli->prepare("SELECT taskid from user_tasks where task_name = ? AND userid = ? LIMIT 1");
        $stmt3->bind_param('si', $task_name, $userid);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_taskid);
        $stmt3->fetch();

	    if ($stmt3->num_rows == 1) {

        $stmt3->close();
        header('HTTP/1.0 550 A task with the name entered already exists.');
        exit();

        } else {

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
    global $updated_on;

	$taskToComplete = filter_input(INPUT_POST, 'taskToComplete', FILTER_SANITIZE_NUMBER_INT);
	$task_status = 'completed';

	$stmt1 = $mysqli->prepare("UPDATE user_tasks SET task_status = ?, updated_on = ? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('ssi', $task_status, $updated_on, $taskToComplete);
	$stmt1->execute();
	$stmt1->close();
}

//DeleteTask function
function DeleteTask() {

    global $mysqli;

    $taskToDelete = filter_input(INPUT_POST, 'taskToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_tasks WHERE taskid = ?");
    $stmt1->bind_param('i', $taskToDelete);
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

    //Get data from Paypal IPN
	$item_number1 = $_POST["item_number1"];
	$quantity1 = $_POST["quantity1"];
	$product_name = $_POST["item_name1"];
	$product_amount = $_POST["mc_gross"];

	$invoice_id = $_POST["invoice"];
	$transaction_id  = $_POST["txn_id"];

	$payment_status = strtolower($_POST["payment_status"]);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

    //Get userid by using invoice_id
	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoice_id = ? LIMIT 1");
	$stmt1->bind_param('i', $invoice_id);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

	$stmt2 = $mysqli->prepare("INSERT INTO booked_events (userid, eventid, event_amount_paid, ticket_quantity, booked_on) VALUES (?, ?, ?, ?, ?)");
	$stmt2->bind_param('iiiis', $userid, $item_number1, $product_amount, $quantity1, $created_on);
	$stmt2->execute();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("SELECT event_ticket_no from system_events where eventid = ?");
	$stmt3->bind_param('i', $item_number1);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($event_ticket_no);
	$stmt3->fetch();
	$stmt3->close();

	$newquantity = $event_ticket_no - $quantity1;

	$stmt4 = $mysqli->prepare("UPDATE system_events SET event_ticket_no=? WHERE eventid=?");
	$stmt4->bind_param('ii', $newquantity, $item_number1);
	$stmt4->execute();
	$stmt4->close();

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET transaction_id=?, payment_status =?, updated_on=?, completed_on=? WHERE invoice_id =?");
	$stmt5->bind_param('ssssi', $transaction_id, $payment_status, $updated_on, $completed_on, $invoice_id);
	$stmt5->execute();
	$stmt5->close();

    //Get name and email for sending email
    $stmt6 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($email, $firstname, $surname);
    $stmt6->fetch();
    $stmt6->close();

	//Creating email
	$subject = 'Payment confirmation';

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

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>' . "\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>' . "\r\n";

	mail($email, $subject, $message, $headers);
}

//EventTicketQuantityCheck function
function EventTicketQuantityCheck () {

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

//CreateEvent function
function CreateEvent() {

    global $mysqli;
    global $created_on;

    $event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'event_notes', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'event_url', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'event_from', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'event_to', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'event_amount', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'event_ticket_no', FILTER_SANITIZE_STRING);
    $event_category = filter_input(INPUT_POST, 'event_category', FILTER_SANITIZE_STRING);

    $event_category = strtolower($event_category);

    if ($event_category == 'careers') { $event_class = 'event-important'; }
    if ($event_category == 'social') { $event_class = 'event-warning'; }

    // Check existing event name
    $stmt1 = $mysqli->prepare("SELECT eventid FROM system_events WHERE event_name=? LIMIT 1");
    $stmt1->bind_param('s', $event_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_eventid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {

        $event_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_events (event_notes, event_url, event_class, event_from, event_to, event_amount, event_ticket_no, event_category, event_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('sssssiisss', $event_notes, $event_url, $event_class, $event_from, $event_to, $event_amount, $event_ticket_no, $event_category, $event_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    } else {

        $event_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO system_events (event_name, event_notes, event_url, event_class, event_from, event_to, event_amount, event_ticket_no, event_category, event_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('ssssssiisss', $event_name, $event_notes, $event_url, $event_class, $event_from, $event_to, $event_amount, $event_ticket_no, $event_category, $event_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

    }
}

//UpdateEvent function
function UpdateEvent() {

    global $mysqli;
    global $updated_on;

    $eventid = filter_input(INPUT_POST, 'eventid1', FILTER_SANITIZE_STRING);
    $event_name = filter_input(INPUT_POST, 'event_name1', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'event_notes1', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'event_url1', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'event_from1', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'event_to1', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'event_amount1', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'event_ticket_no1', FILTER_SANITIZE_STRING);
    $event_category = filter_input(INPUT_POST, 'event_category1', FILTER_SANITIZE_STRING);

    $event_category = strtolower($event_category);

    if ($event_category == 'careers') { $event_class = 'event-important'; }
    if ($event_category == 'social') { $event_class = 'event-warning'; }

    // Check if event name is different
    $stmt1 = $mysqli->prepare("SELECT event_name FROM system_events WHERE eventid = ?");
    $stmt1->bind_param('i', $eventid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_event_name);
    $stmt1->fetch();

    if ($db_event_name === $event_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_events SET event_notes=?, event_url=?, event_class=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, event_category=?, updated_on=? WHERE eventid=?");
        $stmt2->bind_param('sssssiissi', $event_notes, $event_url, $event_class, $event_from, $event_to, $event_amount, $event_ticket_no, $event_category, $updated_on, $eventid);
        $stmt2->execute();
        $stmt2->close();

    } else {

        // Check existing event name
        $stmt3 = $mysqli->prepare("SELECT eventid FROM system_events WHERE event_name = ?");
        $stmt3->bind_param('s', $event_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_eventid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 An event with the name entered already exists.');
            exit();
        } else {
            $stmt4 = $mysqli->prepare("UPDATE system_events SET event_name=?, event_notes=?, event_url=?, event_class=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, event_category=?, updated_on=? WHERE eventid=?");
            $stmt4->bind_param('ssssssiissi', $event_name, $event_notes, $event_url, $event_class, $event_from, $event_to, $event_amount, $event_ticket_no, $event_category, $updated_on, $eventid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeleteEvent function
function DeleteEvent()
{

    global $mysqli;

    $eventToDelete = filter_input(INPUT_POST, 'eventToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM reserved_events WHERE eventid=?");
    $stmt1->bind_param('i', $eventToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM system_events WHERE eventid=?");
    $stmt2->bind_param('i', $eventToDelete);
    $stmt2->execute();
    $stmt2->close();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Feedback functions
//SubmitFeedback function
function SubmitFeedback() {

    global $mysqli;
    global $session_userid;
    global $created_on;

    $feedback_moduleid = filter_input(INPUT_POST, 'feedback_moduleid', FILTER_SANITIZE_STRING);
    $feedback_lecturer = filter_input(INPUT_POST, 'feedback_lecturer', FILTER_SANITIZE_STRING);
    $feedback_tutorial_assistant = filter_input(INPUT_POST, 'feedback_tutorial_assistant', FILTER_SANITIZE_STRING);
    $feedback_from_firstname = filter_input(INPUT_POST, 'feedback_from_firstname', FILTER_SANITIZE_STRING);
    $feedback_from_surname = filter_input(INPUT_POST, 'feedback_from_surname', FILTER_SANITIZE_STRING);
    $feedback_from_email = filter_input(INPUT_POST, 'feedback_from_email', FILTER_SANITIZE_EMAIL);
    $lecturer_feedback_to_email = filter_input(INPUT_POST, 'lecturer_feedback_to_email', FILTER_SANITIZE_EMAIL);
    $lecturer_feedback_to_email = filter_var($lecturer_feedback_to_email, FILTER_VALIDATE_EMAIL);
    $tutorial_assistant_feedback_to_email = filter_input(INPUT_POST, 'tutorial_assistant_feedback_to_email', FILTER_SANITIZE_EMAIL);
    $tutorial_assistant_feedback_to_email = filter_var($tutorial_assistant_feedback_to_email, FILTER_VALIDATE_EMAIL);
    $feedback_subject = filter_input(INPUT_POST, 'feedback_subject', FILTER_SANITIZE_STRING);
    $feedback_body = filter_input(INPUT_POST, 'feedback_body', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("INSERT INTO user_feedback (feedback_subject, feedback_body, created_on) VALUES (?, ?, ?)");
    $stmt1->bind_param('sss', $feedback_subject, $feedback_body, $created_on);
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $mysqli->prepare("SELECT feedbackid FROM user_feedback ORDER BY feedbackid DESC LIMIT 1");
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($feedbackid);
    $stmt1->fetch();

    $isRead = 0;

    $stmt2 = $mysqli->prepare("INSERT INTO user_feedback_lookup (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_lecturer, $isRead);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("INSERT INTO user_feedback_lookup (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt3->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_tutorial_assistant, $isRead);
    $stmt3->execute();
    $stmt3->close();

    //Creating email
    $subject = "$feedback_from_firstname $feedback_from_surname - New feedback on Student Portal";

    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>The following student submitted some feedback for you:</p>';
    $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$feedback_from_firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $feedback_from_surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $feedback_from_email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Subject:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $feedback_subject</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Message:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $feedback_body</td></tr>";
    $message .= '</table><br>';
    $message .= '<a href="https://student-portal.co.uk/feedback">View feedback on Student Portal</a><br>';
    $message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
    $message .= '</body>';
    $message .= '</html>';
    $message .= '</body>';
    $message .= '</html>';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= "From: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";
    $headers .= "Reply-To: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";

    mail("$lecturer_feedback_to_email, $tutorial_assistant_feedback_to_email", $subject, $message, $headers);

}

//ApproveFeedback function
function ApproveFeedback () {

    global $mysqli;

    $feedbackToApprove = filter_input(INPUT_POST, 'feedbackToApprove', FILTER_SANITIZE_STRING);

    $isApproved = 1;

    $stmt1 = $mysqli->prepare("UPDATE user_feedback_lookup SET isApproved=? WHERE feedbackid=?");
    $stmt1->bind_param('ii', $isApproved, $feedbackToApprove);
    $stmt1->execute();
    $stmt1->close();
}

//SetMessageRed function
function SetFeedbackRead () {

    global $mysqli;
    global $session_userid;

    $isRead = 1;
    $isApproved = 1;

    $stmt1 = $mysqli->prepare("UPDATE user_feedback_lookup SET isRead=? WHERE module_staff=? AND isApproved=?");
    $stmt1->bind_param('iii', $isRead, $session_userid, $isApproved);
    $stmt1->execute();
    $stmt1->close();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//Messenger functions
//MessageUser function
function MessageUser() {

	global $mysqli;
	global $session_userid;
	global $created_on;

	$message_to_userid = filter_input(INPUT_POST, 'message_to_userid', FILTER_SANITIZE_STRING);
	$message_to_firstname = filter_input(INPUT_POST, 'message_to_firstname', FILTER_SANITIZE_STRING);
	$message_to_surname = filter_input(INPUT_POST, 'message_to_surname', FILTER_SANITIZE_STRING);
	$message_to_email = filter_input(INPUT_POST, 'message_to_email', FILTER_SANITIZE_EMAIL);
    $message_to_email = filter_var($message_to_email, FILTER_VALIDATE_EMAIL);
	$message_subject = filter_input(INPUT_POST, 'message_subject', FILTER_SANITIZE_STRING);
	$message_body = filter_input(INPUT_POST, 'message_body', FILTER_SANITIZE_STRING);

	$stmt1 = $mysqli->prepare("INSERT INTO user_messages (message_subject, message_body, created_on) VALUES (?, ?, ?)");
	$stmt1->bind_param('sss', $message_subject, $message_body, $created_on);
	$stmt1->execute();
	$stmt1->close();

    $isRead = 0;

    $stmt2 = $mysqli->prepare("INSERT INTO user_messages_lookup (message_from, message_to, isRead) VALUES (?, ?, ?)");
    $stmt2->bind_param('iii', $session_userid, $message_to_userid, $isRead);
    $stmt2->execute();
    $stmt2->close();

	//Creating email
	$subject = "$message_to_firstname $message_to_surname - New message on Student Portal";

	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>The following person sent you a message:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$message_to_firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $message_to_surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $message_to_email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Subject:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $message_subject</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Message:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $message_body</td></tr>";
	$message .= '</table><br>';
	$message .= '<a href="https://student-portal.co.uk/messenger">View message on Student Portal</a><br>';
	$message .= '<p>Kind Regards,<br>The Student Portal Team</p>';
	$message .= '</body>';
	$message .= '</html>';
	$message .= '</body>';
	$message .= '</html>';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= "From: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";
	$headers .= "Reply-To: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";

	mail($message_to_email, $subject, $message, $headers);

}

//SetMessageRed function
function SetMessageRead () {

	global $mysqli;
	global $session_userid;

	$isRead = 1;
	$stmt1 = $mysqli->prepare("UPDATE user_messages_lookup SET isRead=? WHERE message_to=?");
	$stmt1->bind_param('ii', $isRead, $session_userid);
	$stmt1->execute();
	$stmt1->close();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//Account functions
//UpdateAccount function
function UpdateAccount() {

	global $mysqli;
	global $session_userid;
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
	$stmt1->bind_param('i', $session_userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_email);
	$stmt1->fetch();

	if ($db_email == $email) {

	$stmt2 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt2->bind_param('sssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $session_userid);
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
        $stmt3->close();
        header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
		exit();
	}
	else {

	$stmt4 = $mysqli->prepare("UPDATE user_details SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
	$stmt4->bind_param('sssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $session_userid);
	$stmt4->execute();
	$stmt4->close();

	$stmt5 = $mysqli->prepare("UPDATE user_signin SET email=?, updated_on=? WHERE userid = ?");
	$stmt5->bind_param('ssi', $email, $updated_on, $session_userid);
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
	global $session_userid;
	global $updated_on;

	$password = filter_input(INPUT_POST, 'password3', FILTER_SANITIZE_STRING);

	// Getting user login details
	$stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $session_userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_password);
	$stmt1->fetch();

	if (password_verify($password, $db_password)) {
        $stmt1->close();
		header('HTTP/1.0 550 This is your current password. Please enter a new password.');
		exit();

	} else {

	$password_hash = password_hash($password, PASSWORD_BCRYPT);

	$stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
	$stmt2->bind_param('ssi', $password_hash, $updated_on, $session_userid);
	$stmt2->execute();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ?");
	$stmt3->bind_param('i', $session_userid);
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
	global $session_userid;
	global $updated_on;
	global $cancelled_on;

	$payment_status = 'cancelled';

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status = ?, updated_on=?, cancelled_on=? WHERE userid = ? ORDER BY payment_id DESC LIMIT 1");
	$stmt5->bind_param('sssi', $payment_status, $updated_on, $cancelled_on, $session_userid);
	$stmt5->execute();
	$stmt5->close();
}

//DeleteAccount function
function DeleteAccount() {

	global $mysqli;

    $accountToDelete = filter_input(INPUT_POST, 'accountToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_messages WHERE userid = ?");
    $stmt1->bind_param('i', $accountToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_messages WHERE message_to = ?");
    $stmt2->bind_param('i', $accountToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_timetable WHERE userid = ?");
    $stmt3->bind_param('i', $accountToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM reserved_books WHERE userid = ?");
    $stmt4->bind_param('i', $accountToDelete);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM booked_events WHERE userid = ?");
    $stmt5->bind_param('i', $accountToDelete);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
    $stmt6->bind_param('i', $accountToDelete);
    $stmt6->execute();
    $stmt6->close();

	session_unset();
	session_destroy();
}

//////////////////////////////////////////////////////////////////////////

//Admin account functions
//CreateAnAccount function
function CreateAnAccount() {

    global $mysqli;
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
    $stmt1->close();
    header('HTTP/1.0 550 An account with the student number entered already exists.');
    exit();
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
        $stmt1->close();
		header('HTTP/1.0 550 This is the account\'s current password. Please enter a new password.');
		exit();

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

    $userToDelete = filter_input(INPUT_POST, 'userToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $userToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_messages WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $userToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_messages WHERE message_to = ? LIMIT 1");
    $stmt3->bind_param('i', $userToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM user_timetable WHERE userid = ? LIMIT 1");
    $stmt4->bind_param('i', $userToDelete);
    $stmt4->execute();
    $stmt4->close();
}

/////////////////////////////////////////////////////////////////////////////////////////////
