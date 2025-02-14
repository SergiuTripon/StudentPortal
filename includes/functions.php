<?php
include 'session.php';

//External functions
//ContactUs function
function ContactUs() {

    //Gather posted data and assign variables
    $firstname = filter_input(INPUT_POST, 'contact_firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'contact_surname', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'contact_email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$message1 = filter_input(INPUT_POST, 'contact_message', FILTER_SANITIZE_STRING);

    //Check if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

    //Create email

	//email subject
	$subject = 'New Message';

    //email recipient
    $to = 'contact@student-portal.co.uk';

	//message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>The following person contacted Student Portal:</p>';
	$message .= '<table rules="all" align="center" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Message:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $message1</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

	//email headers
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: Student Portal '.$email.''."\r\n";
	$headers .= 'Reply-To: Student Portal '.$email.''."\r\n";

	//Send the email
	mail($to, $subject, $message, $headers);

}

//////////////////////////////////////////////////////////////////////////////////////////

//SignIn function
function SignIn() {

    //Global variables
	global $mysqli;
	global $session_userid;
    global $updated_on;

    //Gather posted data and assign variables
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    //Check if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    } else {

        //Check if email address exists in the system
        $stmt1 = $mysqli->prepare("SELECT s.userid, s.account_type, s.password, d.user_status FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid WHERE s.email=? LIMIT 1");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($userid, $session_account_type, $db_password, $user_status);
        $stmt1->fetch();

        //If the email address exists, do the following
        if ($stmt1->num_rows == 1) {

        //If the account is active, do the following
        if ($user_status === 'active') {

        //Check if password entered matches the password in the database
        if (password_verify($password, $db_password)) {

            $isSignedIn = 1;

            //Update database to set the signed in flag to 1
            $stmt3 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt3->bind_param('isi', $isSignedIn, $updated_on, $userid);
            $stmt3->execute();
            $stmt3->close();

            //Set sign in session variable to true
            $_SESSION['signedIn'] = true;

            //Escape the session variable
            $session_userid = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);

            //assign variables to session variables
            $_SESSION['session_userid'] = $session_userid;
            $_SESSION['account_type'] = $session_account_type;

        //Otherwise, if password entered doesn't match the password in the database, do the following:
	    } else {
            $stmt1->close();
            header('HTTP/1.0 550 The password you entered is incorrect.');
            exit();
	    }
            //Otherwise, if the account is not active, do the following
        } else {
            $stmt1->close();
            header('HTTP/1.0 550 This account is deactivated. Please contact your system administrator.');
            exit();
        }
        //Otherwise, if the email address doesn't exist, do the following
        } else {
            $stmt1->close();
            header('HTTP/1.0 550 The email address you entered is incorrect.');
            exit();
        }

	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

//SignOut function
function SignOut() {

    //Global variables
    global $mysqli;
    global $session_userid;
    global $updated_on;

    //Set sign in value to a variable
    $isSignedIn = 0;

    //Update database to set the signed in flag to 0
    $stmt1 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
    $stmt1->bind_param('isi', $isSignedIn, $updated_on, $session_userid);
    $stmt1->execute();
    $stmt1->close();

    //Unset the session
    session_unset();
    //Destroy the session
    session_destroy();
    //Redirect to the Sign In page
    header('Location: /');
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

//Register function
function Register() {

    //Global variables
	global $mysqli;
	global $created_on;

    //Gather posted data and assign variables
	$firstname = filter_input(INPUT_POST, 'register_firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'register_surname', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'register_gender', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'register_email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'register_password', FILTER_SANITIZE_STRING);

    //Check if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();
    } else {

        // Check if the e-mail address exists
        $stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_userid);
        $stmt1->fetch();

        //If e-mail address already exists, do the following
        if ($stmt1->num_rows == 1) {
            $stmt1->close();
            header('HTTP/1.0 550 An account with the email address entered already exists.');
            exit();
        }

        //Creating account
        $account_type = 'student';
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt2 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
        $stmt2->execute();
        $stmt2->close();

        //Creating account
        $gender = strtolower($gender);
        $user_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO user_detail (firstname, surname, gender, user_status, created_on) VALUES (?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssss', $firstname, $surname, $gender, $user_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

        //Creating token
        $token = null;

        $stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
        $stmt5->bind_param('s', $token);
        $stmt5->execute();
        $stmt5->close();

        //Creating fees
        $fee_amount = '';

        $stmt6 = $mysqli->prepare("INSERT INTO user_fee (fee_amount, created_on) VALUES (?, ?)");
        $stmt6->bind_param('is', $fee_amount, $created_on);
        $stmt6->execute();
        $stmt6->close();

	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

//SendPasswordToken function
function SendPasswordToken() {

    //Global variables
	global $mysqli;
	global $created_on;

    //Gather data and assign variables
    $email = filter_input(INPUT_POST, 'fp_email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

    //Check if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

	//Check if the user exists
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();

    //If the user exists, do the following
	if ($stmt1->num_rows == 1) {

        //Create token
		$uniqueid = uniqid(true);
		$token = password_hash($uniqueid, PASSWORD_BCRYPT);

		$stmt2 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
		$stmt2->bind_param('ssi', $token, $created_on, $userid);
		$stmt2->execute();
		$stmt2->close();

        //Creating link to be sent to the user
		$passwordlink = "<a href=https://student-portal.co.uk/password-reset/?token=$token>here</a>";

        //Get firstname, surname using userid
        $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
        $stmt3->bind_param('i', $userid);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($firstname, $surname);
        $stmt3->fetch();
        $stmt3->close();

        //Create email

		//email subject
		$subject = 'Request to change your password';

		//email message
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

        //email headers
		$headers  = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
		$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

		//Send mail
		mail($email, $subject, $message, $headers);

		$stmt1->close();
	}

    //If the user doesn't exist, do the following
	else {
		header('HTTP/1.0 550 The email address you entered is incorrect.');
        exit();
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

//ResetPassword function
function ResetPassword() {

    //Global variables
	global $mysqli;
	global $updated_on;

    //Gather data and assign variables
	$token = $_POST["rp_token"];
	$email = filter_input(INPUT_POST, 'rp_email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'rp_password', FILTER_SANITIZE_STRING);

    //Check if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}

    //Check if user exists
	$stmt1 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
	$stmt1->bind_param('s', $email);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();

    //If the user doesn't exist, do the following
    if ($stmt1->num_rows == 0) {
        $stmt1->close();
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    //If the user exists, do the following
    } else {

        //Get token from database
        $stmt2 = $mysqli->prepare("SELECT user_token.token, user_detail.firstname FROM user_token LEFT JOIN user_detail ON user_token.userid=user_detail.userid WHERE user_token.userid = ? LIMIT 1");
        $stmt2->bind_param('i', $userid);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($db_token, $firstname);
        $stmt2->fetch();

        //If the client side token and database token match, do the following
        if ($token === $db_token) {

        //Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

            //Change the password
            $stmt4 = $mysqli->prepare("UPDATE user_signin SET password = ?, updated_on = ? WHERE email = ? LIMIT 1");
            $stmt4->bind_param('sss', $password_hash, $updated_on, $email);
            $stmt4->execute();
            $stmt4->close();

            //Empty token record
            $empty_token = NULL;
            $empty_created_on = NULL;

            $stmt4 = $mysqli->prepare("UPDATE user_token SET token = ?, created_on = ? WHERE userid = ? LIMIT 1");
            $stmt4->bind_param('ssi', $empty_token, $empty_created_on, $userid);
            $stmt4->execute();
            $stmt4->close();

            //Create email

            //email subject
            $subject = 'Password reset successfully';

            //email message
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

            //email headers
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            //Send the email
            mail($email, $subject, $message, $headers);

        //If the client side token and database token do not match, do the following
        } else {
            header('HTTP/1.0 550 The password reset key is invalid.');
            exit();
        }
    }
}
////////////////////////////////////////////////////////////////////////////////////////////

//Internal functions
//Home functions
//GetDashboardData function
function GetDashboardData() {

	global $mysqli;
	global $session_userid;
    global $student_timetable_count;
	global $academic_staff_timetable_count;
	global $exams_count;
    global $results_count;
	global $library_count;
    global $library_admin_count;
	global $calendar_count;
	global $events_count;
	global $messenger_count;
    global $feedback_count;
    global $feedback_admin_count;

    //Get lectures allocated to the currently signed in user
    $lecture_status = 'active';

	$stmt1 = $mysqli->prepare("SELECT l.lectureid FROM user_lecture u LEFT JOIN system_lecture l ON u.lectureid=l.lectureid WHERE u.userid=? AND l.lecture_status=? AND DATE(l.lecture_to_date) > DATE(NOW())");
	$stmt1->bind_param('is', $session_userid, $lecture_status);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($lectureid);
	$stmt1->fetch();

    //Get lectures that the currently signed user has to teach
    $stmt2 = $mysqli->prepare("SELECT l.lectureid FROM system_lecture l WHERE l.lecture_lecturer=? AND l.lecture_status=? AND DATE(l.lecture_to_date) > DATE(NOW())");
    $stmt2->bind_param('is', $session_userid, $lecture_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($lectureid);
    $stmt2->fetch();

    //Get tutorials allocated to the currently signed in user
    $tutorial_status = 'active';

	$stmt3 = $mysqli->prepare("SELECT t.tutorialid FROM user_tutorial u LEFT JOIN system_tutorial t ON u.tutorialid=t.tutorialid WHERE u.userid=? AND t.tutorial_status=? AND DATE(t.tutorial_to_date) > DATE(NOW())");
	$stmt3->bind_param('is', $session_userid, $tutorial_status);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($tutorialid);
	$stmt3->fetch();

    //Get tutorials that the currently signed user has to teach
    $stmt4 = $mysqli->prepare("SELECT t.tutorialid FROM system_tutorial t WHERE t.tutorial_assistant=? AND t.tutorial_status=? AND DATE(t.tutorial_to_date) > DATE(NOW())");
    $stmt4->bind_param('is', $session_userid, $tutorial_status);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($tutorialid);
    $stmt4->fetch();

    //Get exams allocated to the currently signed in user
    $exam_status = 'active';

	$stmt5 = $mysqli->prepare("SELECT e.examid FROM user_exam u LEFT JOIN system_exam e ON u.examid=e.examid WHERE u.userid=? AND e.exam_status=?");
	$stmt5->bind_param('is', $session_userid, $exam_status);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($examid);
	$stmt5->fetch();

    //Get results awarded to the currently signed in user
    $stmt6 = $mysqli->prepare("SELECT resultid FROM user_result WHERE userid=?");
    $stmt6->bind_param('i', $session_userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($resultid);
    $stmt6->fetch();

    //Get books loaned out by the currently signed in user
    $isReturned = 0;
    $book_status = 'active';
    $loan_status = 'ongoing';

	$stmt7 = $mysqli->prepare("SELECT l.bookid FROM system_book_loaned l LEFT JOIN system_book b ON l.bookid=b.bookid WHERE l.userid=? AND l.isReturned=? AND b.book_status=? AND l.loan_status=?");
	$stmt7->bind_param('iiss', $session_userid, $isReturned, $book_status, $loan_status);
	$stmt7->execute();
	$stmt7->store_result();
	$stmt7->bind_result($bookid);
	$stmt7->fetch();

    //Get number of books to be marked as collected or returned by the administrator

    $book_status = 'active';
    $isCollected = 0;
    $reservation_status = 'pending';
    $isReturned = 0;
    $loan_status = 'ongoing';
    $isRead = 0;
    $isApproved = 0;
    $request_status = 'pending';

    $stmt8 = $mysqli->prepare("SELECT DISTINCT re.bookid FROM system_book b LEFT JOIN system_book_reserved re ON b.bookid=re.bookid LEFT JOIN system_book_loaned l ON b.bookid=l.bookid LEFT JOIN system_book_requested r ON b.bookid=r.bookid WHERE b.book_status='active' AND ((re.isCollected='0' AND re.reservation_status = 'pending') OR (l.isReturned = '0' AND l.loan_status = 'ongoing') OR (r.isRead = '0' AND r.isApproved = '0' AND r.request_status = 'pending'))");
	$stmt8->bind_param('sisisiis', $book_status, $isCollected, $reservation_status, $isReturned, $loan_status, $isRead, $isApproved, $request_status);
	$stmt8->execute();
	$stmt8->store_result();
	$stmt8->bind_result($bookid);
	$stmt8->fetch();

    //Get active tasks belonging to the currently signed in user
	$task_status = 'active';

	$stmt9 = $mysqli->prepare("SELECT taskid FROM user_task WHERE userid = ? AND task_status = ?");
	$stmt9->bind_param('is', $session_userid, $task_status);
	$stmt9->execute();
	$stmt9->store_result();
	$stmt9->bind_result($taskid);
	$stmt9->fetch();

    //Get events booked by the currently signed in user
    $event_status = 'active';

	$stmt10 = $mysqli->prepare("SELECT b.eventid FROM system_event_booked b LEFT JOIN system_event e ON b.eventid = e.eventid WHERE b.userid = ? AND e.event_status=? AND DATE(e.event_to) > DATE(NOW())");
	$stmt10->bind_param('is', $session_userid, $event_status);
	$stmt10->execute();
	$stmt10->store_result();
	$stmt10->bind_result($eventid);
	$stmt10->fetch();

    //Get messages received by the currently signed in user
	$isRead = '0';
	$stmt11 = $mysqli->prepare("SELECT r.messageid FROM user_message_received r WHERE r.message_to=? AND r.isRead=?");
	$stmt11->bind_param('ii', $session_userid, $isRead);
	$stmt11->execute();
	$stmt11->store_result();
	$stmt11->bind_result($messageid);
	$stmt11->fetch();

    //Get feedback received by the currently signed in user
    $isRead = 0;
    $isApproved = 1;

    $stmt12 = $mysqli->prepare("SELECT DISTINCT r.feedbackid FROM user_feedback_received r LEFT JOIN user_feedback f ON r.feedbackid=f.feedbackid WHERE r.module_staff=? AND r.isRead=? AND f.isApproved=?");
    $stmt12->bind_param('iii', $session_userid, $isRead, $isApproved);
    $stmt12->execute();
    $stmt12->store_result();
    $stmt12->bind_result($feedbackid);
    $stmt12->fetch();

    //Get feedback to be approved by the administrator
    $admin_isApproved = 0;

    $stmt13 = $mysqli->prepare("SELECT DISTINCT r.feedbackid FROM user_feedback_received r LEFT JOIN user_feedback f ON r.feedbackid=f.feedbackid WHERE f.isApproved=? AND r.isRead=?");
    $stmt13->bind_param('ii', $admin_isApproved, $isRead);
    $stmt13->execute();
    $stmt13->store_result();
    $stmt13->bind_result($feedbackid);
    $stmt13->fetch();

	$student_lecture_count          = $stmt1->num_rows;
    $academic_staff_lectures_count  = $stmt2->num_rows;
    $student_tutorial_count         = $stmt3->num_rows;
    $academic_staff_tutorials_count = $stmt4->num_rows;

    $student_timetable_count  = $student_lecture_count + $student_tutorial_count;
    $academic_staff_timetable_count = $academic_staff_lectures_count + $academic_staff_tutorials_count;

    $exams_count          = $stmt5->num_rows;
    $results_count        = $stmt6->num_rows;
	$library_count        = $stmt7->num_rows;
    $library_admin_count  = $stmt8->num_rows;
	$calendar_count       = $stmt9->num_rows;
	$events_count         = $stmt10->num_rows;
	$messenger_count      = $stmt11->num_rows;
    $feedback_count       = $stmt12->num_rows;
    $feedback_admin_count = $stmt13->num_rows;

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
    $stmt11->close();
    $stmt12->close();
    $stmt13->close();

}
//////////////////////////////////////////////////////////////////////////////////////////

//Timetable functions
//CreateModule function
function CreateModule() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Get the data posted and assign variables
    $module_name = filter_input(INPUT_POST, 'create_module_name', FILTER_SANITIZE_STRING);
    $module_notes = filter_input(INPUT_POST, 'create_module_notes', FILTER_SANITIZE_STRING);
    $module_url = filter_input(INPUT_POST, 'create_module_url', FILTER_SANITIZE_STRING);

    //Check if module name exists
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE module_name = ? LIMIT 1");
    $stmt1->bind_param('s', $module_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_moduleid);
    $stmt1->fetch();

    //If module name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A module with the name entered already exists.');
        exit();
        
    //If the module name does not exist, do the following
    } else {

        //Create the module record
        $module_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_module (module_name, module_notes, module_url, module_status, created_on) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param('sssss', $module_name, $module_notes, $module_url, $module_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }
}

//UpdateModule function
function UpdateModule() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Get the data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'update_moduleid', FILTER_SANITIZE_STRING);
    $module_name = filter_input(INPUT_POST, 'update_module_name', FILTER_SANITIZE_STRING);
    $module_notes = filter_input(INPUT_POST, 'update_module_notes', FILTER_SANITIZE_STRING);
    $module_url = filter_input(INPUT_POST, 'update_module_url', FILTER_SANITIZE_STRING);

    //Check if module name has been changed
    $stmt1 = $mysqli->prepare("SELECT module_name FROM system_module WHERE moduleid = ?");
    $stmt1->bind_param('i', $moduleid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_module_name);
    $stmt1->fetch();

    //If the module name hasn't changed, do the following
    if ($db_module_name === $module_name) {
        $stmt2 = $mysqli->prepare("UPDATE system_module SET module_notes=?, module_url=?, updated_on=? WHERE moduleid=?");
        $stmt2->bind_param('sssi', $module_notes, $module_url, $updated_on, $moduleid);
        $stmt2->execute();
        $stmt2->close();

    //If the module name has changed, do the following
    } else {

        //Check if module name exists
        $stmt3 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE module_name = ?");
        $stmt3->bind_param('s', $module_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_moduleid);
        $stmt3->fetch();

        //If module name exists, do the following
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A module with the name entered already exists.');
            exit();

        //If module name does not exist, do the following
        } else {

            //Update module
            $stmt4 = $mysqli->prepare("UPDATE system_module SET module_name=?, module_notes=?, module_url=?, updated_on=? WHERE moduleid=?");
            $stmt4->bind_param('ssssi', $module_name, $module_notes, $module_url, $updated_on, $moduleid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateModule function
function DeactivateModule() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Get the data posted and assign variables
    $moduleToDeactivate = filter_input(INPUT_POST, 'moduleToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate module
    $module_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_module SET module_status=?, updated_on=? WHERE moduleid=?");
    $stmt1->bind_param('ssi', $module_status, $updated_on, $moduleToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Deactivate lecture
    $lecture_status = 'inactive';

    $stmt2 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE moduleid=?");
    $stmt2->bind_param('ssi', $lecture_status, $updated_on, $moduleToDeactivate);
    $stmt2->execute();
    $stmt2->close();

    //Deactivate tutorial
    $tutorial_status = 'inactive';

    $stmt3 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE moduleid=?");
    $stmt3->bind_param('ssi', $tutorial_status, $updated_on, $moduleToDeactivate);
    $stmt3->execute();
    $stmt3->close();

    //Deactivate exam
    $exam_status = 'inactive';

    $stmt4 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE moduleid=?");
    $stmt4->bind_param('ssi', $exam_status, $updated_on, $moduleToDeactivate);
    $stmt4->execute();
    $stmt4->close();

    //Deactivate result
    $result_status = 'inactive';

    $stmt5 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE moduleid=?");
    $stmt5->bind_param('ssi', $result_status, $updated_on, $moduleToDeactivate);
    $stmt5->execute();
    $stmt5->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//ReactivateModule function
function ReactivateModule() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Get the data posted and assign variables
    $moduleToReactivate = filter_input(INPUT_POST, 'moduleToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Reactivate module
    $module_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_module SET module_status=?, updated_on=? WHERE moduleid=?");
    $stmt1->bind_param('ssi', $module_status, $updated_on, $moduleToReactivate);
    $stmt1->execute();
    $stmt1->close();

    //Reactivate lecture
    $lecture_status = 'active';

    $stmt2 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE moduleid=?");
    $stmt2->bind_param('ssi', $lecture_status, $updated_on, $moduleToReactivate);
    $stmt2->execute();
    $stmt2->close();

    //Reactivate tutorial
    $tutorial_status = 'active';

    $stmt3 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE moduleid=?");
    $stmt3->bind_param('ssi', $tutorial_status, $updated_on, $moduleToReactivate);
    $stmt3->execute();
    $stmt3->close();

    //Reactivate exam
    $exam_status = 'active';

    $stmt4 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE moduleid=?");
    $stmt4->bind_param('ssi', $exam_status, $updated_on, $moduleToReactivate);
    $stmt4->execute();
    $stmt4->close();

    //Reactivate result
    $result_status = 'active';

    $stmt5 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE moduleid=?");
    $stmt5->bind_param('ssi', $result_status, $updated_on, $moduleToReactivate);
    $stmt5->execute();
    $stmt5->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteModule function
function DeleteModule() {

    //Global variables
    global $mysqli;

    //Get the data posted and assign variables
    $moduleToDelete = filter_input(INPUT_POST, 'moduleToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete sent feedback
    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE moduleid=?");
    $stmt1->bind_param('i', $moduleToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete received feedback
    $stmt2 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE moduleid=?");
    $stmt2->bind_param('i', $moduleToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Delete feedback
    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback WHERE moduleid=?");
    $stmt3->bind_param('i', $moduleToDelete);
    $stmt3->execute();
    $stmt3->close();

    //Delete result
    $stmt4 = $mysqli->prepare("DELETE FROM user_result WHERE moduleid=?");
    $stmt4->bind_param('i', $moduleToDelete);
    $stmt4->execute();
    $stmt4->close();

    //Get examid linked to the moduleid
    $stmt5 = $mysqli->prepare("SELECT examid FROM system_exam WHERE moduleid = ?");
    $stmt5->bind_param('i', $moduleToDelete);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($db_examid);
    $stmt5->fetch();
    $stmt5->close();

    //Delete exam
    $stmt6 = $mysqli->prepare("DELETE FROM user_exam WHERE examid=?");
    $stmt6->bind_param('i', $db_examid);
    $stmt6->execute();
    $stmt6->close();

    //Delete exam
    $stmt7 = $mysqli->prepare("DELETE FROM system_exam WHERE moduleid=?");
    $stmt7->bind_param('i', $moduleToDelete);
    $stmt7->execute();
    $stmt7->close();

    //Get tutorialid linked to the moduleid
    $stmt8 = $mysqli->prepare("SELECT tutorialid FROM system_tutorial WHERE moduleid = ?");
    $stmt8->bind_param('i', $moduleid);
    $stmt8->execute();
    $stmt8->store_result();
    $stmt8->bind_result($db_tutorialid);
    $stmt8->fetch();
    $stmt8->close();

    //Delete tutorial
    $stmt9 = $mysqli->prepare("DELETE FROM user_tutorial WHERE tutorialid=?");
    $stmt9->bind_param('i', $db_tutorialid);
    $stmt9->execute();
    $stmt9->close();

    //Delete tutorial
    $stmt10 = $mysqli->prepare("DELETE FROM system_tutorial WHERE moduleid=?");
    $stmt10->bind_param('i', $moduleToDelete);
    $stmt10->execute();
    $stmt10->close();

    //Get lectureid linked to the moduleid
    $stmt11 = $mysqli->prepare("SELECT lectureid FROM system_lecture WHERE moduleid = ?");
    $stmt11->bind_param('i', $moduleid);
    $stmt11->execute();
    $stmt11->store_result();
    $stmt11->bind_result($db_lectureid);
    $stmt11->fetch();
    $stmt11->close();

    //Delete lecture
    $stmt12 = $mysqli->prepare("DELETE FROM user_lecture WHERE lectureid=?");
    $stmt12->bind_param('i', $db_lectureid);
    $stmt12->execute();
    $stmt12->close();

    //Delete lecture
    $stmt13 = $mysqli->prepare("DELETE FROM system_lecture WHERE moduleid=?");
    $stmt13->bind_param('i', $moduleToDelete);
    $stmt13->execute();
    $stmt13->close();

    //Delete module
    $stmt14 = $mysqli->prepare("DELETE FROM user_module WHERE moduleid=?");
    $stmt14->bind_param('i', $moduleToDelete);
    $stmt14->execute();
    $stmt14->close();

    //Delete module
    $stmt15 = $mysqli->prepare("DELETE FROM system_module WHERE moduleid=?");
    $stmt15->bind_param('i', $moduleToDelete);
    $stmt15->execute();
    $stmt15->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//AllocateModule function
function AllocateModule() {

    //Global variables
    global $mysqli;

    //Gather posted data and assign variables
    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $moduleToAllocate = filter_input(INPUT_POST, 'moduleToAllocate', FILTER_SANITIZE_NUMBER_INT);

    //Allocate module
    $stmt1 = $mysqli->prepare("INSERT INTO user_module (userid, moduleid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $moduleToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateModule function
function DeallocateModule() {

    //Global variables
    global $mysqli;

    //Gather posted data and assign variables
    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $moduleToDeallocate = filter_input(INPUT_POST, 'moduleToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    //Deallocate module
    $stmt1 = $mysqli->prepare("DELETE FROM user_module WHERE userid=? AND moduleid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $moduleToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

//CreateLecture function
function CreateLecture() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'create_lecture_moduleid', FILTER_SANITIZE_STRING);
    $lecture_name = filter_input(INPUT_POST, 'create_lecture_name', FILTER_SANITIZE_STRING);
    $lecture_lecturer = filter_input(INPUT_POST, 'create_lecture_lecturer', FILTER_SANITIZE_STRING);
    $lecture_notes = filter_input(INPUT_POST, 'create_lecture_notes', FILTER_SANITIZE_STRING);
    $lecture_day = filter_input(INPUT_POST, 'create_lecture_day', FILTER_SANITIZE_STRING);
    $lecture_from_time = filter_input(INPUT_POST, 'create_lecture_from_time', FILTER_SANITIZE_STRING);
    $lecture_to_time = filter_input(INPUT_POST, 'create_lecture_to_time', FILTER_SANITIZE_STRING);
    $lecture_from_date = filter_input(INPUT_POST, 'create_lecture_from_date', FILTER_SANITIZE_STRING);
    $lecture_to_date = filter_input(INPUT_POST, 'create_lecture_to_date', FILTER_SANITIZE_STRING);
    $lecture_location = filter_input(INPUT_POST, 'create_lecture_location', FILTER_SANITIZE_STRING);
    $lecture_capacity = filter_input(INPUT_POST, 'create_lecture_capacity', FILTER_SANITIZE_STRING);

    // Check if lecture name exists
    $stmt1 = $mysqli->prepare("SELECT lectureid FROM system_lecture WHERE lecture_name = ? LIMIT 1");
    $stmt1->bind_param('s', $lecture_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_lectureid);
    $stmt1->fetch();

    //If lecture name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A lecture with the name entered already exists.');
        exit();

    //If lecture name does not exist, do the following
    } else {

        //Converting dates to MySQL format
        $lecture_from_date = DateTime::createFromFormat('d/m/Y', $lecture_from_date);
        $lecture_from_date = $lecture_from_date->format('Y-m-d');
        $lecture_to_date = DateTime::createFromFormat('d/m/Y', $lecture_to_date);
        $lecture_to_date = $lecture_to_date->format('Y-m-d');

        //Create lecture
        $lecture_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_lecture (moduleid, lecture_name, lecture_lecturer, lecture_notes, lecture_day, lecture_from_time, lecture_to_time, lecture_from_date, lecture_to_date, lecture_location, lecture_capacity, lecture_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('isisssssssiss', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $lecture_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }
}

//UpdateLecture function
function UpdateLecture() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'update_lecture_moduleid', FILTER_SANITIZE_STRING);
    $lectureid = filter_input(INPUT_POST, 'update_lectureid', FILTER_SANITIZE_STRING);
    $lecture_name = filter_input(INPUT_POST, 'update_lecture_name', FILTER_SANITIZE_STRING);
    $lecture_lecturer = filter_input(INPUT_POST, 'update_lecture_lecturer', FILTER_SANITIZE_STRING);
    $lecture_notes = filter_input(INPUT_POST, 'update_lecture_notes', FILTER_SANITIZE_STRING);
    $lecture_day = filter_input(INPUT_POST, 'update_lecture_day', FILTER_SANITIZE_STRING);
    $lecture_from_time = filter_input(INPUT_POST, 'update_lecture_from_time', FILTER_SANITIZE_STRING);
    $lecture_to_time = filter_input(INPUT_POST, 'update_lecture_to_time', FILTER_SANITIZE_STRING);
    $lecture_from_date = filter_input(INPUT_POST, 'update_lecture_from_date', FILTER_SANITIZE_STRING);
    $lecture_to_date = filter_input(INPUT_POST, 'update_lecture_to_date', FILTER_SANITIZE_STRING);
    $lecture_location = filter_input(INPUT_POST, 'update_lecture_location', FILTER_SANITIZE_STRING);
    $lecture_capacity = filter_input(INPUT_POST, 'update_lecture_capacity', FILTER_SANITIZE_STRING);

    //Check if lecture name has been changed
    $stmt1 = $mysqli->prepare("SELECT lecture_name FROM system_lecture WHERE lectureid = ? LIMIT 1");
    $stmt1->bind_param('i', $lectureid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_lecture_name);
    $stmt1->fetch();

    //Convert dates to MySQL format
    $lecture_from_date = DateTime::createFromFormat('d/m/Y', $lecture_from_date);
    $lecture_from_date = $lecture_from_date->format('Y-m-d');
    $lecture_to_date = DateTime::createFromFormat('d/m/Y', $lecture_to_date);
    $lecture_to_date = $lecture_to_date->format('Y-m-d');

    //If the lecture name hasn't changed, do the following
    if ($db_lecture_name === $lecture_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_lecture SET moduleid=?, lecture_lecturer=?, lecture_notes=?, lecture_day=?, lecture_from_time=?, lecture_to_time=?, lecture_from_date=?, lecture_to_date=?, lecture_location=?, lecture_capacity=?, updated_on=? WHERE lectureid=?");
        $stmt2->bind_param('iisssssssisi', $moduleid, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $updated_on, $lectureid);
        $stmt2->execute();
        $stmt2->close();

    //If the lecture name has changed, do the following
    } else {

        //Check if lecture name exists
        $stmt3 = $mysqli->prepare("SELECT lectureid FROM system_lecture WHERE lecture_name = ?");
        $stmt3->bind_param('s', $lecture_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_lectureid);
        $stmt3->fetch();

        //If the lecture name exists, do the following
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A lecture with the name entered already exists.');
            exit();

        //If the lecture name does not exist, do the following
        } else {

            //Update lecture
            $stmt4 = $mysqli->prepare("UPDATE system_lecture SET moduleid=?, lecture_name=?, lecture_lecturer=?, lecture_notes=?, lecture_day=?, lecture_from_time=?, lecture_to_time=?, lecture_from_date=?, lecture_to_date=?, lecture_location=?, lecture_capacity=?, updated_on=? WHERE lectureid=?");
            $stmt4->bind_param('isisssssssisi', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $updated_on, $lectureid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateLecture function
function DeactivateLecture() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $lectureToDeactivate = filter_input(INPUT_POST, 'lectureToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate lecture
    $lecture_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE lectureid=?");
    $stmt1->bind_param('ssi', $lecture_status, $updated_on, $lectureToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//ReactivateLecture function
function ReactivateLecture() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $lectureToReactivate = filter_input(INPUT_POST, 'lectureToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Get moduleid
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_lecture WHERE lectureid = ?");
    $stmt1->bind_param('i', $lectureToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    //Check if the module related to the lecture is active
    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    //If the module related is active, do the following
    if ($stmt2->num_rows > 0) {

        //Reactivate lecture
        $lecture_status = 'active';

        $stmt3 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE lectureid=?");
        $stmt3->bind_param('ssi', $lecture_status, $updated_on, $lectureToReactivate);
        $stmt3->execute();
        $stmt3->close();

    //If the module related is inactive, do the following
    } else {

        $stmt2->close();

        //Create error message
        $error_msg = 'You cannot reactivate this lecture because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this lecture.';

        //Create array and bind error message to array
        $array = array(
            'error_msg'=>$error_msg
        );

        //send the array back to Ajax call
        echo json_encode($array);

        exit();
    }

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteLecture function
function DeleteLecture() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $lectureToDelete = filter_input(INPUT_POST, 'lectureToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete lecture
    $stmt1 = $mysqli->prepare("DELETE FROM system_lecture WHERE lectureid=?");
    $stmt1->bind_param('i', $lectureToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete lecture
    $stmt2 = $mysqli->prepare("DELETE FROM user_lecture WHERE lectureid=?");
    $stmt2->bind_param('i', $lectureToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//AllocateLecture function
function AllocateLecture() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $lectureToAllocate = filter_input(INPUT_POST, 'lectureToAllocate', FILTER_SANITIZE_NUMBER_INT);

    //Allocate lecture
    $stmt1 = $mysqli->prepare("INSERT INTO user_lecture (userid, lectureid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $lectureToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateLecture function
function DeallocateLecture() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $lectureToDeallocate = filter_input(INPUT_POST, 'lectureToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    //Deallocate lecture
    $stmt1 = $mysqli->prepare("DELETE FROM user_lecture WHERE userid=? AND lectureid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $lectureToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

//CreateTutorial function
function CreateTutorial() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'create_tutorial_moduleid', FILTER_SANITIZE_STRING);
    $tutorial_name = filter_input(INPUT_POST, 'create_tutorial_name', FILTER_SANITIZE_STRING);
    $tutorial_assistant = filter_input(INPUT_POST, 'create_tutorial_assistant', FILTER_SANITIZE_STRING);
    $tutorial_notes = filter_input(INPUT_POST, 'create_tutorial_notes', FILTER_SANITIZE_STRING);
    $tutorial_day = filter_input(INPUT_POST, 'create_tutorial_day', FILTER_SANITIZE_STRING);
    $tutorial_from_time = filter_input(INPUT_POST, 'create_tutorial_from_time', FILTER_SANITIZE_STRING);
    $tutorial_to_time = filter_input(INPUT_POST, 'create_tutorial_to_time', FILTER_SANITIZE_STRING);
    $tutorial_from_date = filter_input(INPUT_POST, 'create_tutorial_from_date', FILTER_SANITIZE_STRING);
    $tutorial_to_date = filter_input(INPUT_POST, 'create_tutorial_to_date', FILTER_SANITIZE_STRING);
    $tutorial_location = filter_input(INPUT_POST, 'create_tutorial_location', FILTER_SANITIZE_STRING);
    $tutorial_capacity = filter_input(INPUT_POST, 'create_tutorial_capacity', FILTER_SANITIZE_STRING);

    //Check if the tutorial name exists
    $stmt1 = $mysqli->prepare("SELECT tutorialid FROM system_tutorial WHERE tutorial_name = ? LIMIT 1");
    $stmt1->bind_param('s', $tutorial_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_tutorialid);
    $stmt1->fetch();

    //If the tutorial name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A tutorial with the name entered already exists.');
        exit();

    //If the tutorial name does not exist, do the following
    } else {

        //Convert dates to MySQL format
        $tutorial_from_date = DateTime::createFromFormat('d/m/Y', $tutorial_from_date);
        $tutorial_from_date = $tutorial_from_date->format('Y-m-d');
        $tutorial_to_date = DateTime::createFromFormat('d/m/Y', $tutorial_to_date);
        $tutorial_to_date = $tutorial_to_date->format('Y-m-d');

        //Create tutorial
        $tutorial_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_tutorial (moduleid, tutorial_name, tutorial_assistant, tutorial_notes, tutorial_day, tutorial_from_time, tutorial_to_time, tutorial_from_date, tutorial_to_date, tutorial_location, tutorial_capacity, tutorial_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('isisssssssiss', $moduleid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $tutorial_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }
}

//UpdateTutorial function
function UpdateTutorial() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather the data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'update_tutorial_moduleid', FILTER_SANITIZE_STRING);
    $tutorialid = filter_input(INPUT_POST, 'update_tutorialid', FILTER_SANITIZE_STRING);
    $tutorial_name = filter_input(INPUT_POST, 'update_tutorial_name', FILTER_SANITIZE_STRING);
    $tutorial_assistant = filter_input(INPUT_POST, 'update_tutorial_assistant', FILTER_SANITIZE_STRING);
    $tutorial_notes = filter_input(INPUT_POST, 'update_tutorial_notes', FILTER_SANITIZE_STRING);
    $tutorial_day = filter_input(INPUT_POST, 'update_tutorial_day', FILTER_SANITIZE_STRING);
    $tutorial_from_time = filter_input(INPUT_POST, 'update_tutorial_from_time', FILTER_SANITIZE_STRING);
    $tutorial_to_time = filter_input(INPUT_POST, 'update_tutorial_to_time', FILTER_SANITIZE_STRING);
    $tutorial_from_date = filter_input(INPUT_POST, 'update_tutorial_from_date', FILTER_SANITIZE_STRING);
    $tutorial_to_date = filter_input(INPUT_POST, 'update_tutorial_to_date', FILTER_SANITIZE_STRING);
    $tutorial_location = filter_input(INPUT_POST, 'update_tutorial_location', FILTER_SANITIZE_STRING);
    $tutorial_capacity = filter_input(INPUT_POST, 'update_tutorial_capacity', FILTER_SANITIZE_STRING);

    //Check if tutorial name has been changed
    $stmt1 = $mysqli->prepare("SELECT tutorial_name FROM system_tutorial WHERE tutorialid = ?");
    $stmt1->bind_param('i', $tutorialid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_tutorial_name);
    $stmt1->fetch();

    //Convert dates to MySQL format
    $tutorial_from_date = DateTime::createFromFormat('d/m/Y', $tutorial_from_date);
    $tutorial_from_date = $tutorial_from_date->format('Y-m-d');
    $tutorial_to_date = DateTime::createFromFormat('d/m/Y', $tutorial_to_date);
    $tutorial_to_date = $tutorial_to_date->format('Y-m-d');

    //If the tutorial name hasn't changed, do the following
    if ($db_tutorial_name === $tutorial_name) {
        $stmt2 = $mysqli->prepare("UPDATE system_tutorial SET moduleid=?, tutorial_assistant=?, tutorial_notes=?, tutorial_day=?, tutorial_from_time=?, tutorial_to_time=?, tutorial_from_date=?, tutorial_to_date=?, tutorial_location=?, tutorial_capacity=?, updated_on=? WHERE tutorialid=?");
        $stmt2->bind_param('iisssssssisi', $moduleid, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $updated_on, $tutorialid);
        $stmt2->execute();
        $stmt2->close();

    //If the tutorial name has changed, do the following
    } else {

        //Check if tutorial name exists
        $stmt3 = $mysqli->prepare("SELECT tutorialid FROM system_tutorial WHERE tutorial_name = ?");
        $stmt3->bind_param('s', $tutorial_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_tutorialid);
        $stmt3->fetch();

        //If tutorial name exists, do the following
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A tutorial with the name entered already exists.');
            exit();

        //If tutorial name does not exist, do the following
        } else {

            //Update tutorial
            $stmt4 = $mysqli->prepare("UPDATE system_tutorial SET moduleid=?, tutorial_name=?, tutorial_assistant=?, tutorial_notes=?, tutorial_day=?, tutorial_from_time=?, tutorial_to_time=?, tutorial_from_date=?, tutorial_to_date=?, tutorial_location=?, tutorial_capacity=?, updated_on=? WHERE tutorialid=?");
            $stmt4->bind_param('isisssssssisi', $moduleid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $updated_on, $tutorialid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateTutorial function
function DeactivateTutorial() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather the data posted and assign variables
    $tutorialToDeactivate = filter_input(INPUT_POST, 'tutorialToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate tutorial
    $tutorial_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE tutorialid=?");
    $stmt1->bind_param('ssi', $tutorial_status, $updated_on, $tutorialToDeactivate);
    $stmt1->execute();
    $stmt1->close();


}

//ReactivateTutorial function
function ReactivateTutorial() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $tutorialToReactivate = filter_input(INPUT_POST, 'tutorialToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Get moduleid
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_tutorial WHERE tutorialid = ?");
    $stmt1->bind_param('i', $tutorialToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    //Check if the module related to the tutorial is active
    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    //If the module related is active, do the following
    if ($stmt2->num_rows > 0) {

        $tutorial_status = 'active';

        $stmt1 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE tutorialid=?");
        $stmt1->bind_param('ssi', $tutorial_status, $updated_on, $tutorialToReactivate);
        $stmt1->execute();
        $stmt1->close();

        //If the module related is inactive, do the following
    } else {
        $stmt2->close();

        //Create error message
        $error_msg = 'You cannot reactivate this tutorial because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this tutorial.';

        //Create array and bind error message to array
        $array = array(
            'error_msg'=>$error_msg
        );

        //Send array back to Ajax call
        echo json_encode($array);

        exit();
    }

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteTutorial function
function DeleteTutorial() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $tutorialToDelete = filter_input(INPUT_POST, 'tutorialToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete tutorial
    $stmt1 = $mysqli->prepare("DELETE FROM system_tutorial WHERE tutorialid=?");
    $stmt1->bind_param('i', $tutorialToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete tutorial
    $stmt2 = $mysqli->prepare("DELETE FROM user_tutorial WHERE tutorialid=?");
    $stmt2->bind_param('i', $tutorialToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Update tables
    AdminTimetableUpdate($isUpdate = 1);

}

//AllocateTutorial function
function AllocateTutorial() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $tutorialToAllocate = filter_input(INPUT_POST, 'tutorialToAllocate', FILTER_SANITIZE_NUMBER_INT);

    //Allocate tutorial
    $stmt1 = $mysqli->prepare("INSERT INTO user_tutorial (userid, tutorialid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $tutorialToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateTutorial function
function DeallocateTutorial() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $tutorialToDeallocate = filter_input(INPUT_POST, 'tutorialToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    //Deallocate tutorial
    $stmt1 = $mysqli->prepare("DELETE FROM user_tutorial WHERE userid=? AND tutorialid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $tutorialToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

function AdminTimetableUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $active_module;
    global $active_lecture;
    global $active_tutorial;
    global $inactive_module;
    global $inactive_lecture;
    global $inactive_tutorial;

    //Get active modules
    $module_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_module m WHERE m.module_status=?");
    $stmt1->bind_param('s', $module_status);
    $stmt1->execute();
    $stmt1->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind result to the variable
            $active_module .=

           '<tr>
			<td data-title="Name"><a href="#view-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Notes">'.($module_notes === '' ? "-" : "$module_notes").'</td>
            <td data-title="Moodle link">'.($module_url === '' ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/allocate-module?id='.$moduleid.'">Allocate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/update-module?id='.$moduleid.'">Update</a></li>
            <li><a id="deactivate-'.$moduleid.'" class="btn-deactivate-module">Deactivate</a></li>
            <li><a href="#delete-module-'.$moduleid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-module-'.$moduleid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-module?id='.$moduleid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$moduleid.'" class="btn btn-primary btn-md btn-deactivate-module">Deactivate</a>
            <a href="#delete-module-'.$moduleid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-module-'.$moduleid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete module?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$module_name.'"?</p><br>
			<p>Warning: Please note that this module and all the lectures, tutorials, exams and results linked to it will be deleted.</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$moduleid.'" class="btn btn-primary btn-lg btn-delete-module btn-load">Delete</a>
            <a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

    $stmt1->close();

    //Get inactive modules
    $module_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_module m WHERE m.module_status=?");
    $stmt2->bind_param('s', $module_status);
    $stmt2->execute();
    $stmt2->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind result to the variable
            $inactive_module .=

           '<tr>
			<td data-title="Name"><a href="#view-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Notes">'.($module_notes === '' ? "No notes" : "$module_notes").'</td>
            <td data-title="Moodle link">'.($module_url === '' ? "No link" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a id="reactivate-'.$moduleid.'" class="btn btn-primary btn-reactivate-module">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-module-'.$moduleid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a id="reactivate-'.$moduleid.'" class="btn btn-primary btn-md btn-reactivate-module">Reactivate</a>
            <a href="#delete-module-'.$moduleid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-module-'.$moduleid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete module?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$module_name.'"?</p><br>
			<p>Warning: Please note that this module and all the lectures, tutorials, exams and results linked to it will be deleted.</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$moduleid.'" class="btn btn-primary btn-lg btn-delete-module btn-load">Delete</a>
			<a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

    $stmt2->close();

    //Get active lectures
    $lecture_status = 'active';

    $stmt3 = $mysqli->prepare("SELECT l.lectureid, l.lecture_name, l.lecture_lecturer, l.lecture_notes, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l WHERE l.lecture_status=?");
    $stmt3->bind_param('s', $lecture_status);
    $stmt3->execute();
    $stmt3->bind_result($lectureid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_location, $lecture_capacity);
    $stmt3->store_result();

    if ($stmt3->num_rows > 0) {

        while ($stmt3->fetch()) {

            $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
            $stmt3->bind_param('i', $lecture_lecturer);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($lecturer_fistname, $lecturer_surname);
            $stmt3->fetch();
            $stmt3->close();

            //Bind result to the variable
            $active_lecture .=

           '<tr>
			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
            <td data-title="Lecturer">'.$lecturer_fistname.' '.$lecturer_surname.'</td>
            <td data-title="From">'.$lecture_from_time.'</td>
            <td data-title="To">'.$lecture_to_time.'</td>
            <td data-title="Location">'.$lecture_location.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/allocate-lecture?id='.$lectureid.'">Allocate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/update-lecture?id='.$lectureid.'">Update</a></li>
            <li><a id="deactivate-'.$lectureid.'" class="btn-deactivate-lecture">Deactivate</a></li>
            <li><a href="#delete-lecture-'.$lectureid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "-" : "$lecture_notes").'</p>
			<p><b>Lecturer:</b> '.$lecturer_fistname.' '.$lecturer_surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-timetable?id='.$lectureid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$lectureid.'" class="btn btn-primary btn-md btn-deactivate-lecture">Deactivate</a>
            <a href="#delete-lecture-'.$lectureid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-lecture-'.$lectureid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete lecture?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$lecture_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$lectureid.'" class="btn btn-primary btn-lg btn-delete-lecture btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

    $stmt2->close();

    //Get inactive lectures
    $lecture_status = 'inactive';

    $stmt4 = $mysqli->prepare("SELECT l.lectureid, l.lecture_name, l.lecture_lecturer, l.lecture_notes, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l WHERE l.lecture_status=?");
    $stmt4->bind_param('s', $lecture_status);
    $stmt4->execute();
    $stmt4->bind_result($lectureid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_location, $lecture_capacity);
    $stmt4->store_result();

    if ($stmt4->num_rows > 0) {

        while ($stmt4->fetch()) {

            $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
            $stmt2->bind_param('i', $lecture_lecturer);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($lecturer_fistname, $lecturer_surname);
            $stmt2->fetch();
            $stmt2->close();

            //Bind result to the variable
            $inactive_lecture .=

           '<tr>
			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
            <td data-title="Lecturer">'.$lecturer_fistname.' '.$lecturer_surname.'</td>
            <td data-title="From">'.$lecture_from_time.'</td>
            <td data-title="To">'.$lecture_to_time.'</td>
            <td data-title="Location">'.$lecture_location.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a id="reactivate-'.$lectureid.'" class="btn btn-primary btn-reactivate-lecture">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-lecture-'.$lectureid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "-" : "$lecture_notes").'</p>
			<p><b>Lecturer:</b> '.$lecturer_fistname.' '.$lecturer_surname.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a id="reactivate-'.$lectureid.'" class="btn btn-primary btn-md btn-reactivate-lecture">Reactivate</a>
            <a href="#delete-lecture-'.$lectureid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-lecture-'.$lectureid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete lecture?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$lecture_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$lectureid.'" class="btn btn-primary btn-lg btn-delete-lecture btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

    $stmt4->close();

    //Get active tutorials
    $tutorial_status = 'active';

    $stmt5 = $mysqli->prepare("SELECT t.tutorialid, t.tutorial_name, t.tutorial_assistant, t.tutorial_notes, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t WHERE t.tutorial_status=?");
    $stmt5->bind_param('s', $tutorial_status);
    $stmt5->execute();
    $stmt5->bind_result($tutorialid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_location, $tutorial_capacity);
    $stmt5->store_result();

    if ($stmt5->num_rows > 0) {

        while ($stmt5->fetch()) {

            $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
            $stmt2->bind_param('i', $tutorial_assistant);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($tutorial_assistant_fistname, $tutorial_assistant_surname);
            $stmt2->fetch();
            $stmt2->close();

            //Bind result to the variable
            $active_tutorial .=

           '<tr>
			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
            <td data-title="Lecturer">'.$tutorial_assistant_fistname.' '.$tutorial_assistant_surname.'</td>
            <td data-title="From">'.$tutorial_from_time.'</td>
            <td data-title="To">'.$tutorial_to_time.'</td>
            <td data-title="Location">'.$tutorial_location.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/allocate-tutorial?id='.$tutorialid.'">Allocate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/update-tutorial?id='.$tutorialid.'">Update</a></li>
            <li><a id="deactivate-'.$tutorialid.'" class="btn-deactivate-tutorial">Deactivate</a></li>
            <li><a href="#delete-tutorial-'.$tutorialid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "-" : "$lecture_notes").'</p>
			<p><b>Lecturer:</b> '.$tutorial_assistant_fistname.' '.$tutorial_assistant_surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-timetable?id='.$tutorialid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$tutorialid.'" class="btn btn-primary btn-md btn-deactivate-tutorial">Deactivate</a>
            <a href="#delete-tutorial-'.$tutorialid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-tutorial-'.$tutorialid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete tutorial?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$tutorial_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$tutorialid.'" class="btn btn-primary btn-lg btn-delete-tutorial btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

    $stmt5->close();

    //Get inactive tutorials
    $tutorial_status = 'inactive';

    $stmt6 = $mysqli->prepare("SELECT t.tutorialid, t.tutorial_name, t.tutorial_assistant, t.tutorial_notes, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t WHERE t.tutorial_status=?");
    $stmt6->bind_param('s', $tutorial_status);
    $stmt6->execute();
    $stmt6->bind_result($tutorialid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_location, $tutorial_capacity);
    $stmt6->store_result();

    if ($stmt6->num_rows > 0) {

        while ($stmt6->fetch()) {

            $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
            $stmt2->bind_param('i', $tutorial_assistant);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($tutorial_assistant_fistname, $tutorial_assistant_surname);
            $stmt2->fetch();
            $stmt2->close();

            $inactive_tutorial .=

           '<tr>
			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
            <td data-title="Lecturer">'.$tutorial_assistant_fistname.' '.$tutorial_assistant_surname.'</td>
            <td data-title="From">'.$tutorial_from_time.'</td>
            <td data-title="To">'.$tutorial_to_time.'</td>
            <td data-title="Location">'.$tutorial_location.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a id="reactivate-'.$tutorialid.'" class="btn btn-primary btn-reactivate-tutorial">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-tutorial-'.$tutorialid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "-" : "$tutorial_notes").'</p>
			<p><b>Lecturer:</b> '.$tutorial_assistant_fistname.' '.$tutorial_assistant_surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a id="reactivate-'.$tutorialid.'" class="btn btn-primary btn-md btn-reactivate-tutorial">Reactivate</a>
            <a href="#delete-tutorial-'.$tutorialid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-tutorial-'.$tutorialid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete tutorial?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$tutorial_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$tutorialid.'" class="btn btn-primary btn-lg btn-delete-tutorial btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

    $stmt6->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'active_module'=>$active_module,
            'active_lecture'=>$active_lecture,
            'active_tutorial'=>$active_tutorial,
            'inactive_module'=>$inactive_module,
            'inactive_lecture'=>$inactive_lecture,
            'inactive_tutorial'=>$inactive_tutorial
        );

        //Send data back to Ajax call
        echo json_encode($array);
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Exams
//CreateExam function
function CreateExam() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'create_exam_moduleid', FILTER_SANITIZE_STRING);
    $exam_name = filter_input(INPUT_POST, 'create_exam_name', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'create_exam_notes', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'create_exam_date', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'create_exam_time', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'create_exam_location', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'create_exam_capacity', FILTER_SANITIZE_STRING);

    //Check if exam name exists
    $stmt1 = $mysqli->prepare("SELECT examid FROM system_exam WHERE exam_name = ? LIMIT 1");
    $stmt1->bind_param('s', $exam_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_examid);
    $stmt1->fetch();

    //If exam name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 An exam with the name entered already exists.');
        exit();
    }

    //Convert date to MySQL format
    $exam_date = DateTime::createFromFormat('d/m/Y', $exam_date);
    $exam_date = $exam_date->format('Y-m-d');

    //Create exam
    $exam_status = 'active';

    $stmt2 = $mysqli->prepare("INSERT INTO system_exam (moduleid, exam_name, exam_notes, exam_date, exam_time, exam_location, exam_capacity, exam_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param('issssssss', $moduleid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $exam_status, $created_on);
    $stmt2->execute();
    $stmt2->close();
}

//UpdateExam function
function UpdateExam() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $moduleid = filter_input(INPUT_POST, 'update_exam_moduleid', FILTER_SANITIZE_STRING);
    $examid = filter_input(INPUT_POST, 'update_examid', FILTER_SANITIZE_STRING);
    $exam_name = filter_input(INPUT_POST, 'update_exam_name', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'update_exam_notes', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'update_exam_date', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'update_exam_time', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'update_exam_location', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'update_exam_capacity', FILTER_SANITIZE_STRING);

    //Check if exam name changed
    $stmt1 = $mysqli->prepare("SELECT exam_name FROM system_exam WHERE examid = ?");
    $stmt1->bind_param('i', $examid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_exam_name);
    $stmt1->fetch();

    //Convert date to MySQL format
    $exam_date = DateTime::createFromFormat('d/m/Y', $exam_date);
    $exam_date = $exam_date->format('Y-m-d');

    //If exam name hasn't changed, do the following
    if ($db_exam_name === $exam_name) {
        $stmt3 = $mysqli->prepare("UPDATE system_exam SET moduleid=?, exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
        $stmt3->bind_param('issssssi', $moduleid, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
        $stmt3->execute();
        $stmt3->close();
    //If exam name has changed, do the following
    } else {

        //Check if exam name exists
        $stmt4 = $mysqli->prepare("SELECT examid FROM system_exam WHERE exam_name = ?");
        $stmt4->bind_param('s', $exam_name);
        $stmt4->execute();
        $stmt4->store_result();
        $stmt4->bind_result($db_examid);
        $stmt4->fetch();

        //If exam name exists, do the following
        if ($stmt4->num_rows == 1) {
            $stmt4->close();
            header('HTTP/1.0 550 An exam with the name entered already exists.');
            exit();

        //If exam name does not exist, do the following
        } else {

            //Update exam
            $stmt5 = $mysqli->prepare("UPDATE system_exam SET moduleid=?, exam_name=?, exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
            $stmt5->bind_param('isssssssi', $moduleid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
            $stmt5->execute();
            $stmt5->close();
        }
    }

}

//DeactivateExam function
function DeactivateExam() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $examToDeactivate = filter_input(INPUT_POST, 'examToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate exam
    $exam_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE examid=?");
    $stmt1->bind_param('ssi', $exam_status, $updated_on, $examToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminExamUpdate($isUpdate = 1);
}

//ReactivateExam function
function ReactivateExam() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $examToReactivate = filter_input(INPUT_POST, 'examToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Get moduleid
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_exam WHERE examid = ?");
    $stmt1->bind_param('i', $examToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    //Check if the module related to the tutorial is active
    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    //If the module related is active, do the following
    if ($stmt2->num_rows > 0) {

        $exam_status = 'active';

        $stmt3 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE examid=?");
        $stmt3->bind_param('ssi', $exam_status, $updated_on, $examToReactivate);
        $stmt3->execute();
        $stmt3->close();

    //If the module related is inactive, do the following
    } else {

        $stmt2->close();

        //Create error message
        $error_msg = 'You cannot reactivate this exam because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this exam.';

        //Create array and bind error message to array
        $array = array(
            'error_msg'=>$error_msg
        );

        //Send error message back to Ajax
        echo json_encode($array);

        exit();
    }

    //Update tables
    AdminExamUpdate($isUpdate = 1);
}

//DeleteTimetable function
function DeleteExam() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $examToDelete = filter_input(INPUT_POST, 'examToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete exam
    $stmt1 = $mysqli->prepare("DELETE FROM system_exam WHERE examid=?");
    $stmt1->bind_param('i', $examToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete exam
    $stmt2 = $mysqli->prepare("DELETE FROM user_exam WHERE examid=?");
    $stmt2->bind_param('ii', $examid, $examToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Update tables
    AdminExamUpdate($isUpdate = 1);
}

//AllocateExam function
function AllocateExam() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $examToAllocate = filter_input(INPUT_POST, 'examToAllocate', FILTER_SANITIZE_NUMBER_INT);

    //Allocate exam
    $stmt1 = $mysqli->prepare("INSERT INTO user_exam (userid, examid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $examToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateExam function
function DeallocateExam() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $examToDeallocate = filter_input(INPUT_POST, 'examToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    //Deallocate exam
    $stmt1 = $mysqli->prepare("DELETE FROM user_exam WHERE userid=? AND examid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $examToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

function AdminExamUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $active_exam;
    global $inactive_exam;

    //Get active exams
    $exam_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT e.examid, e.exam_name, e.exam_notes, DATE_FORMAT(e.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(e.exam_time,'%H:%i') as exam_time, e.exam_location, e.exam_capacity FROM system_exam e WHERE e.exam_status=?");
    $stmt1->bind_param('s', $exam_status);
    $stmt1->execute();
    $stmt1->bind_result($examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind result to variable
            $active_exam .=

           '<tr>
			<td data-title="Name"><a href="#view-exam-'.$examid.'" data-toggle="modal">'.$exam_name.'</a></td>
			<td data-title="Date">'.$exam_date.'</td>
			<td data-title="Time">'.$exam_time.'</td>
			<td data-title="Location">'.$exam_location.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/allocate-exam?id='.$examid.'">Allocate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/update-exam?id='.$examid.'">Update</a></li>
            <li><a id="deactivate-'.$examid.'" class="btn-deactivate-exam">Deactivate</a></li>
            <li><a href="#delete-exam-'.$examid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-exam-'.$examid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-pencil"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$exam_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($exam_notes) ? "No description" : "$exam_notes").'</p>
			<p><b>Date:</b> '.$exam_date.'</p>
			<p><b>Time:</b> '.$exam_time.'</p>
			<p><b>Location:</b> '.$exam_location.'</p>
			<p><b>Capacity:</b> '.$exam_capacity.'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
			<a id="reactivate-'.$examid.'" class="btn btn-primary btn-md btn-deactivate-exam">Deactivate</a>
            <a href="#delete-exam-'.$examid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
            </div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-exam-'.$examid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete exam?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$exam_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$examid.'" class="btn btn-primary btn-lg btn-delete-exam btn-load">Delete</a>
			<a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

	$stmt1->close();

    //Get inactive exams
    $exam_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT e.examid, e.exam_name, e.exam_notes, DATE_FORMAT(e.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(e.exam_time,'%H:%i') as exam_time, e.exam_location, e.exam_capacity FROM system_exam e WHERE e.exam_status=?");
    $stmt2->bind_param('s', $exam_status);
    $stmt2->execute();
    $stmt2->bind_result($examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind result to variable
            $inactive_exam .=

           '<tr>
			<td data-title="Name"><a href="#view-exam-'.$examid.'" data-toggle="modal">'.$exam_name.'</a></td>
			<td data-title="Date">'.$exam_date.'</td>
			<td data-title="Time">'.$exam_time.'</td>
			<td data-title="Location">'.$exam_location.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a id="#reactivate-'.$examid.'" class="btn btn-primary btn-reactivate-exam">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-exam-'.$examid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-exam-'.$examid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-pencil"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$exam_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($exam_notes) ? "No description" : "$exam_notes").'</p>
			<p><b>Date:</b> '.$exam_date.'</p>
			<p><b>Time:</b> '.$exam_time.'</p>
			<p><b>Location:</b> '.$exam_location.'</p>
			<p><b>Capacity:</b> '.$exam_capacity.'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
			<a id="reactivate-'.$examid.'" class="btn btn-primary btn-md btn-deactivate-exam">Deactivate</a>
            <a href="#delete-exam-'.$examid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
            </div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-exam-'.$examid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete exam?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$exam_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$examid.'" class="btn btn-primary btn-lg btn-delete-exam btn-load">Delete</a>
			<a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

	$stmt2->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to array
        $array = array(
            'active_exam'=>$active_exam,
            'inactive_exam'=>$inactive_exam
        );

        //Send data back to the Ajax call
        echo json_encode($array);
    }

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CreateResult function
function CreateResult() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $result_userid = filter_input(INPUT_POST, 'result_userid', FILTER_SANITIZE_NUMBER_INT);
    $result_moduleid = filter_input(INPUT_POST, 'result_moduleid', FILTER_SANITIZE_NUMBER_INT);
    $result_coursework_mark = filter_input(INPUT_POST, 'result_coursework_mark', FILTER_SANITIZE_STRING);
    $result_exam_mark = filter_input(INPUT_POST, 'result_exam_mark', FILTER_SANITIZE_STRING);
    $result_overall_mark = filter_input(INPUT_POST, 'result_overall_mark', FILTER_SANITIZE_STRING);
    $result_notes = filter_input(INPUT_POST, 'result_notes', FILTER_SANITIZE_STRING);

    //Create result
    $result_status = 'active';

    $stmt1 = $mysqli->prepare("INSERT INTO user_result (userid, moduleid, result_coursework_mark, result_exam_mark, result_overall_mark, result_notes, result_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iissssss', $result_userid, $result_moduleid, $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $result_status, $created_on);
    $stmt1->execute();
    $stmt1->close();
}

//UpdateResult function
function UpdateResult() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $result_resultid = filter_input(INPUT_POST, 'result_resultid', FILTER_SANITIZE_NUMBER_INT);
    $result_coursework_mark = filter_input(INPUT_POST, 'result_coursework_mark1', FILTER_SANITIZE_STRING);
    $result_exam_mark = filter_input(INPUT_POST, 'result_exam_mark1', FILTER_SANITIZE_STRING);
    $result_overall_mark = filter_input(INPUT_POST, 'result_overall_mark1', FILTER_SANITIZE_STRING);
    $result_notes = filter_input(INPUT_POST, 'result_notes1', FILTER_SANITIZE_STRING);

    //Update result
    $stmt1 = $mysqli->prepare("UPDATE user_result SET result_coursework_mark=?, result_exam_mark=?, result_overall_mark=?, result_notes=?, updated_on=? WHERE resultid=?");
    $stmt1->bind_param('sssssi', $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $updated_on, $result_resultid);
    $stmt1->execute();
    $stmt1->close();
}

//DeactivateResult function
function DeactivateResult() {

    //Global variable
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $resultToDeactivate = filter_input(INPUT_POST, 'resultToDeactivate', FILTER_SANITIZE_STRING);

    //Deactivate result
    $result_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE resultid=?");
    $stmt1->bind_param('ssi', $result_status, $updated_on, $resultToDeactivate);
    $stmt1->execute();
    $stmt1->close();

}

//ReactivateResult function
function ReactivateResult() {

    //Global variable
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $resultToReactivate = filter_input(INPUT_POST, 'resultToReactivate', FILTER_SANITIZE_STRING);

    //Get moduleid
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM user_result WHERE resultid = ?");
    $stmt1->bind_param('i', $resultToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    //Check if the module related to the exam is active
    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    //If the module related is active, do the following
    if ($stmt2->num_rows > 0) {

        $result_status = 'active';

        $stmt1 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE resultid=?");
        $stmt1->bind_param('ssi', $result_status, $updated_on, $resultToReactivate);
        $stmt1->execute();
        $stmt1->close();

    //If the module related is inactive, do the following
    } else {

        $stmt2->close();

        //Create error message
        $error_msg = 'You cannot reactivate this result because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this result.';

        //Create array and bind error message to array
        $array = array(
            'error_msg'=>$error_msg
        );

        //Send error message back to the Ajax call
        echo json_encode($array);

        exit();
    }
}

//DeleteResult function
function DeleteResult() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $resultToDelete = filter_input(INPUT_POST, 'resultToDelete', FILTER_SANITIZE_STRING);

    //Delete result
    $stmt1 = $mysqli->prepare("DELETE FROM user_result WHERE resultid=?");
    $stmt1->bind_param('i', $resultToDelete);
    $stmt1->execute();
    $stmt1->close();

}

function AdminResultUpdate($isUpdate = 0, $userid = '') {

    //Global variables
    global $mysqli;
    global $userid;
    global $active_result;
    global $inactive_result;

    //Get active results
    $result_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid=? AND user_result.result_status=?");
    $stmt1->bind_param('is', $userid, $result_status);
    $stmt1->execute();
    $stmt1->bind_result($resultid, $module_name, $result_coursework_mark, $result_exam_mark, $result_overall_mark);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind results to the variable
            $active_result .=

           '<tr>
			<td data-title="Module">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../update-result/?id='.$resultid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a id="deactivate-'.$resultid.'" class="btn-deactivate-result">Deactivate</a></li>
            <li><a href="#delete-'.$resultid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="delete-'.$resultid.'" class="modal fade modal-custom modal-warning" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete exam?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete this result for "'.$module_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$resultid.'" class="btn btn-primary btn-lg btn-delete-result btn-load">Delete</a>
			<a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

	$stmt1->close();

    //Get inactive results
    $result_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid=? AND user_result.result_status=?");
    $stmt2->bind_param('is', $userid, $result_status);
    $stmt2->execute();
    $stmt2->bind_result($resultid, $module_name, $result_coursework_mark, $result_exam_mark, $result_overall_mark);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind results to the variable
            $inactive_result .=

           '<tr>
			<td data-title="Module">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a id="reactivate-'.$resultid.'" class="btn btn-primary btn-reactivate-result">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$resultid.'" data-dismiss="modal" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div id="delete-'.$resultid.'" class="modal fade modal-custom modal-warning" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete exam?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete this result for "'.$module_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$resultid.'" class="btn btn-primary btn-lg btn-delete-result btn-load">Delete</a>
			<a type="button" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

	$stmt2->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'active_result'=>$active_result,
            'inactive_result'=>$inactive_result
        );

        //Send data back to the Ajax call
        echo json_encode($array);
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Library functions
//ReserveBook function
function ReserveBook() {

    //Global variables
	global $mysqli;
	global $session_userid;
    global $created_on;

    //Gather data posted and assign variables
	$bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_STRING);
	$book_name = filter_input(INPUT_POST, 'book_name', FILTER_SANITIZE_STRING);
	$book_author = filter_input(INPUT_POST, 'book_author', FILTER_SANITIZE_STRING);

    //Add 7 days to current date
    $add7days = new DateTime($created_on);
    $add7days->add(new DateInterval('P7D'));
    $tocollect_on = $add7days->format('Y-m-d');

    //Set value
    $collected_on = '';

    //Create reservation
    $isCollected = 0;
    $reservation_status = 'pending';

	$stmt1 = $mysqli->prepare("INSERT INTO system_book_reserved (userid, bookid, tocollect_on, collected_on, isCollected, reservation_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt1->bind_param('iississ', $session_userid, $bookid, $tocollect_on, $collected_on, $isCollected, $reservation_status, $created_on);
	$stmt1->execute();
	$stmt1->close();

    //Set isReserved flag to 1
	$isReserved = 1;

	$stmt2 = $mysqli->prepare("UPDATE system_book SET isReserved=? WHERE bookid =?");
	$stmt2->bind_param('ii', $isReserved, $bookid);
	$stmt2->execute();
	$stmt2->close();

    //Get user details
	$stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt3->bind_param('i', $session_userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($email, $firstname, $surname);
	$stmt3->fetch();
	$stmt3->close();

	$reservation_status = 'Pending';

	//Creating email

    //email subject
	$subject = 'Reservation confirmation';

    //email message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent book reservation! Below, you can find the reservation summary:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $created_on</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $tocollect_on</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $reservation_status</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

    //email headers
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    //Send the email
	mail($email, $subject, $message, $headers);
}

//CollectBook function
function CollectBook() {

    //Global variables
    global $mysqli;
    global $created_on;
    global $updated_on;

    //Gather data posted and assign variables
    $bookToCollect = filter_input(INPUT_POST, 'bookToCollect', FILTER_SANITIZE_STRING);

    //Complete reservation
    $isCollected = 1;
    $reservation_status = 'completed';

    $stmt1 = $mysqli->prepare("UPDATE system_book_reserved SET collected_on=?, isCollected=?, reservation_status=? WHERE bookid=? ORDER BY bookid DESC");
    $stmt1->bind_param('sisi', $updated_on, $isCollected, $reservation_status, $bookToCollect);
    $stmt1->execute();
    $stmt1->close();

    //Get book details
    $stmt3 = $mysqli->prepare("SELECT r.userid, b.book_name, b.book_author FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.bookid=? ORDER BY r.reservationid DESC LIMIT 1");
    $stmt3->bind_param('i', $bookToCollect);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($userid, $book_name, $book_author);
    $stmt3->fetch();

    $book_class = 'event-success';

    //Add 14 days to current date
    $add14days = new DateTime($created_on);
    $add14days->add(new DateInterval('P14D'));
    $toreturn_on = $add14days->format('Y-m-d');

    //Set value
    $returned_on = '';

    //Create loan
    $isReturned = 0;
    $isRequested = 0;
    $loan_status = 'ongoing';

    $stmt1 = $mysqli->prepare("INSERT INTO system_book_loaned (userid, bookid, book_class, toreturn_on, returned_on, isReturned, isRequested, loan_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iisssiiss', $userid, $bookToCollect, $book_class, $toreturn_on, $returned_on, $isReturned, $isRequested, $loan_status, $created_on);
    $stmt1->execute();
    $stmt1->close();

    //Set isLoaned to 1
    $isLoaned = 1;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isLoaned=?, updated_on=? WHERE bookid =?");
    $stmt2->bind_param('isi', $isLoaned, $updated_on, $bookToCollect);
    $stmt2->execute();
    $stmt2->close();

    //Get user details
    $stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt3->bind_param('i', $userid);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($email, $firstname, $surname);
    $stmt3->fetch();
    $stmt3->close();

    //Creating email

    $loan_status = 'Ongoing';

    //email subject
    $subject = 'Loan confirmation';

    //email message
    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>This is an email to let you know that your book loan has now started. Below, you can find the loan summary:</p>';
    $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Loan date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $created_on</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $toreturn_on</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Loan status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $loan_status</td></tr>";
    $message .= '</table>';
    $message .= '</body>';
    $message .= '</html>';

    //email headers
    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
    $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    //Send the email
    mail($email, $subject, $message, $headers);
}

//ReturnBook function
function ReturnBook() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $bookToReturn = filter_input(INPUT_POST, 'bookToReturn', FILTER_SANITIZE_STRING);

    //Complete loan
    $loan_status = 'completed';
    $isReturned = 1;

    $stmt1 = $mysqli->prepare("UPDATE system_book_loaned SET returned_on=?, isReturned=?, loan_status=? WHERE bookid=? ORDER BY bookid DESC");
    $stmt1->bind_param('sisi', $updated_on, $isReturned, $loan_status, $bookToReturn);
    $stmt1->execute();
    $stmt1->close();

    //Reset flags
    $isReserved = 0;
    $isLoaned = 0;
    $isRequested = 0;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isReserved=?, isLoaned=?, isRequested=?, updated_on=? WHERE bookid=?");
    $stmt2->bind_param('iiisi', $isReserved, $isLoaned, $isRequested, $updated_on, $bookToReturn);
    $stmt2->execute();
    $stmt2->close();

    //Check if there are requests pending on the book
    $isApproved = 0;
    $request_status = 'pending';

    $stmt3 = $mysqli->prepare("SELECT requestid FROM system_book_requested WHERE bookid=? AND isApproved=? AND request_status=?");
    $stmt3->bind_param('iis', $bookToReturn, $isApproved, $request_status);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($requestid);
    $stmt3->fetch();

    //If there are requests pending on the book, do the following
    if ($stmt3->num_rows > 0) {

        //Complete request
        $isApproved = 1;
        $request_status = 'completed';

        $stmt4 = $mysqli->prepare("UPDATE system_book_requested SET isApproved=?, request_status=? WHERE requestid=?");
        $stmt4->bind_param('isi', $isApproved, $request_status, $requestid);
        $stmt4->execute();
        $stmt4->close();

        //Get userid and bookid
        $stmt5 = $mysqli->prepare("SELECT userid, bookid FROM system_book_requested WHERE requestid=?");
        $stmt5->bind_param('i', $requestid);
        $stmt5->execute();
        $stmt5->store_result();
        $stmt5->bind_result($userid, $bookid);
        $stmt5->fetch();
        $stmt5->close();

        //Add 7 days to the current date
        $add7days = new DateTime($updated_on);
        $add7days->add(new DateInterval('P7D'));
        $tocollect_on = $add7days->format('Y-m-d');

        //Set value
        $collected_on = '';

        //Create reservation
        $isCollected = 0;
        $reservation_status = 'pending';

        $stmt6 = $mysqli->prepare("INSERT INTO system_book_reserved (userid, bookid, tocollect_on, collected_on, isCollected, reservation_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt6->bind_param('iississ', $userid, $bookid, $tocollect_on, $collected_on, $isCollected, $reservation_status, $updated_on);
        $stmt6->execute();
        $stmt6->close();

        //Update isReserved and isRequested flags
        $isReserved = 1;
        $isRequested = 0;

        $stmt7 = $mysqli->prepare("UPDATE system_book SET isReserved=?, isRequested=? WHERE bookid =?");
        $stmt7->bind_param('iii', $isReserved, $isRequested, $bookid);
        $stmt7->execute();
        $stmt7->close();

        //Get user details
        $stmt8 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
        $stmt8->bind_param('i', $userid);
        $stmt8->execute();
        $stmt8->store_result();
        $stmt8->bind_result($email, $firstname, $surname);
        $stmt8->fetch();
        $stmt8->close();

        //Get book details
        $stmt9 = $mysqli->prepare("SELECT b.book_name, b.book_author FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.bookid=? ORDER BY r.reservationid DESC LIMIT 1");
        $stmt9->bind_param('i', $bookToReturn);
        $stmt3->execute();
        $stmt9->store_result();
        $stmt9->bind_result($book_name, $book_author);
        $stmt9->fetch();

        //Creating email

        //message subject
        $subject = 'Reservation confirmation';

        //email message
        $message = '<html>';
        $message .= '<body>';
        $message .= '<p>Just wanted to let you know that the book you requested has now been reserved! Below, you can find the reservation summary:</p>';
        $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $updated_on</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Collect by:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $tocollect_on</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $reservation_status</td></tr>";
        $message .= '</table>';
        $message .= '</body>';
        $message .= '</html>';

        //email headers
        $headers  = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
        $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

        //Send the email
        mail($email, $subject, $message, $headers);

    //If there are no requests pending on the book, do the following
    } else {
        $stmt3->close();
        exit();
    }
}

//RenewBook function
function RenewBook($isCheck = 0) {

    //Global variables
    global $mysqli;
    global $updated_on;

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if($isCheck == 1) {

        //Gather data posted and assign variables
        $bookToRenewCheck = filter_input(INPUT_POST, 'bookToRenewCheck', FILTER_SANITIZE_STRING);

        //Check if there are any requests pending on the book
        $isApproved = 0;
        $request_status = 'pending';

        $stmt1 = $mysqli->prepare("SELECT bookid FROM system_book_requested WHERE bookid=? AND isApproved=? AND request_status=? ORDER BY requestid DESC LIMIT 1");
        $stmt1->bind_param('iis', $bookToRenewCheck, $isApproved, $request_status);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_bookid);
        $stmt1->fetch();

        //If there are requests pending on the book, do the following
        if ($stmt1->num_rows > 0) {
            $stmt1->close();
            echo 'You cannot renew this book at this time. Another user requested this book. Once the book is collected and loaned again, you will be able to request it.';
            exit();
        }

    //If the call to the function was made with parameter 'isUpdate' = 0, do the following
    } else {

        //Gather data posted and assign variables
        $bookToRenew = filter_input(INPUT_POST, 'bookToRenew', FILTER_SANITIZE_STRING);

        //Get loan details
        $stmt2 = $mysqli->prepare("SELECT bookid, loanid, toreturn_on FROM system_book_loaned WHERE bookid=? ORDER BY loanid DESC LIMIT 1");
        $stmt2->bind_param('i', $bookToRenew);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($db_bookid, $db_loanid, $toreturn_on);
        $stmt2->fetch();
        $stmt2->close();

        //Add 14 days to the previous toreturn_on date
        $add14days = new DateTime($toreturn_on);
        $add14days->add(new DateInterval('P14D'));
        $toreturn_on = $add14days->format('Y-m-d');

        //Renew loan
        $stmt3 = $mysqli->prepare("UPDATE system_book_loaned SET toreturn_on=?, updated_on=? WHERE loanid=?");
        $stmt3->bind_param('ssi', $toreturn_on, $updated_on, $db_loanid);
        $stmt3->execute();
        $stmt3->close();
    }
}

//RequestBook function
function RequestBook() {

    //Global variables
    global $mysqli;
    global $session_userid;
    global $created_on;

    //Gather data posted and assign variables
    $bookToRequest = filter_input(INPUT_POST, 'bookToRequest', FILTER_SANITIZE_STRING);

    //Create request
    $isRead = 0;
    $isApproved = 0;
    $request_status = 'pending';

    $stmt1 = $mysqli->prepare("INSERT INTO system_book_requested (userid, bookid, isRead, isApproved, request_status, created_on) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iiiiss', $session_userid, $bookToRequest, $isRead, $isApproved, $request_status, $created_on);
    $stmt1->execute();
    $stmt1->close();

    //Update isRequest flag to 1
    $isRequested = 1;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isRequested=? WHERE bookid =?");
    $stmt2->bind_param('ii', $isRequested, $bookToRequest);
    $stmt2->execute();
    $stmt2->close();

    //Update isRequest flag to 1
    $stmt3 = $mysqli->prepare("UPDATE system_book_loaned SET isRequested=? WHERE bookid =?");
    $stmt3->bind_param('ii', $isRequested, $bookToRequest);
    $stmt3->execute();
    $stmt3->close();

    //Get book and reservation details
    $stmt4 = $mysqli->prepare("SELECT system_book_reserved.userid, system_book_reserved.created_on, system_book_reserved.tocollect_on, system_book.book_name, system_book.book_author, system_book.book_status FROM system_book_reserved LEFT JOIN system_book ON system_book_reserved.bookid=system_book.bookid WHERE system_book_reserved.bookid=?");
    $stmt4->bind_param('i', $bookToRequest);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($userid, $bookreserved_from, $bookreserved_to, $book_name, $book_author, $book_status);
    $stmt4->fetch();
    $stmt4->close();

    //Get reservee user details
    $stmt5 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt5->bind_param('i', $userid);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($reservee_email, $reservee_firstname, $reservee_surname);
    $stmt5->fetch();
    $stmt5->close();

    //Get requester user details
    $stmt6 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $session_userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($requester_email, $requester_firstname, $requester_surname);
    $stmt6->fetch();
    $stmt6->close();

    //Creating email

    $book_status = ucfirst($book_status);

    //email subject
    $subject = 'Request notice';

    //email message
    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>Hi! Someone requested a book you reserved. Below, you can find the request summary:</p>';
    $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$requester_firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $requester_surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $requester_email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $bookreserved_from</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $bookreserved_to</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Book status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_status</td></tr>";
    $message .= '</table>';
    $message .= '</body>';
    $message .= '</html>';

    //email headers
    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
    $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    //Send the email
    mail("$reservee_email, admin@student-portal.co.uk", $subject, $message, $headers);

}

//SetRequestRead function
function SetRequestRead () {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $requestToRead = filter_input(INPUT_POST, 'requestToRead', FILTER_SANITIZE_STRING);

    //Set request read
    $isRead = 1;

    $stmt1 = $mysqli->prepare("UPDATE system_book_requested SET isRead=? WHERE requestid=?");
    $stmt1->bind_param('ii', $isRead, $requestToRead);
    $stmt1->execute();
    $stmt1->close();
}

//CreateBook function
function CreateBook() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $book_name = filter_input(INPUT_POST, 'create_book_name', FILTER_SANITIZE_STRING);
    $book_notes = filter_input(INPUT_POST, 'create_book_notes', FILTER_SANITIZE_STRING);
    $book_author = filter_input(INPUT_POST, 'create_book_author', FILTER_SANITIZE_STRING);
    $book_copy_no = filter_input(INPUT_POST, 'create_book_copy_no', FILTER_SANITIZE_STRING);
    $book_location = filter_input(INPUT_POST, 'create_book_location', FILTER_SANITIZE_STRING);
    $book_publisher = filter_input(INPUT_POST, 'create_book_publisher', FILTER_SANITIZE_STRING);
    $book_publish_date = filter_input(INPUT_POST, 'create_book_publish_date', FILTER_SANITIZE_STRING);
    $book_publish_place = filter_input(INPUT_POST, 'create_book_publish_place', FILTER_SANITIZE_STRING);
    $book_page_amount = filter_input(INPUT_POST, 'create_book_page_amount', FILTER_SANITIZE_STRING);
    $book_barcode = filter_input(INPUT_POST, 'create_book_barcode', FILTER_SANITIZE_STRING);
    $book_discipline = filter_input(INPUT_POST, 'create_book_discipline', FILTER_SANITIZE_STRING);
    $book_language = filter_input(INPUT_POST, 'create_book_language', FILTER_SANITIZE_STRING);

    //Check if book_name exists
    $stmt1 = $mysqli->prepare("SELECT bookid, book_copy_no FROM system_book WHERE book_name=? AND book_author=? ORDER BY bookid DESC LIMIT 1");
    $stmt1->bind_param('ss', $book_name, $book_author);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_bookid, $db_book_copy_no);
    $stmt1->fetch();

    //Convert date to MySQL format date
    $book_publish_date = DateTime::createFromFormat('d/m/Y', $book_publish_date);
    $book_publish_date = $book_publish_date->format('Y-m-d');

    //If book name exists, do the following
    if ($stmt1->num_rows > 0) {

        //Create book
        $book_status = 'active';
        $book_copy_no = $db_book_copy_no + 1;

        $isReserved = 0;
        $isLoaned = 0;

        $stmt5 = $mysqli->prepare("INSERT INTO system_book (book_name, book_notes, book_author, book_copy_no, book_location, book_publisher, book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language, book_status, isReserved, isLoaned, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssissssiisssiis', $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $book_status, $isReserved, $isLoaned, $created_on);
        $stmt5->execute();
        $stmt5->close();

    } else {

        //Create book
        $book_status = 'active';
        $isReserved = 0;
        $isLoaned = 0;

        $stmt5 = $mysqli->prepare("INSERT INTO system_book (book_name, book_notes, book_author, book_copy_no, book_location, book_publisher, book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language, book_status, isReserved, isLoaned, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssissssiisssiis', $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $book_status, $isReserved, $isLoaned, $created_on);
        $stmt5->execute();
        $stmt5->close();

    }
}

//UpdateBook function
function UpdateBook() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $bookid = filter_input(INPUT_POST, 'update_bookid', FILTER_SANITIZE_STRING);
    $book_name = filter_input(INPUT_POST, 'update_book_name', FILTER_SANITIZE_STRING);
    $book_notes = filter_input(INPUT_POST, 'update_book_notes', FILTER_SANITIZE_STRING);
    $book_author = filter_input(INPUT_POST, 'update_book_author', FILTER_SANITIZE_STRING);
    $book_copy_no = filter_input(INPUT_POST, 'update_book_copy_no', FILTER_SANITIZE_STRING);
    $book_location = filter_input(INPUT_POST, 'update_book_location', FILTER_SANITIZE_STRING);
    $book_publisher = filter_input(INPUT_POST, 'update_book_publisher', FILTER_SANITIZE_STRING);
    $book_publish_date = filter_input(INPUT_POST, 'update_book_publish_date', FILTER_SANITIZE_STRING);
    $book_publish_place = filter_input(INPUT_POST, 'update_book_publish_place', FILTER_SANITIZE_STRING);
    $book_page_amount = filter_input(INPUT_POST, 'update_book_page_amount', FILTER_SANITIZE_STRING);
    $book_barcode = filter_input(INPUT_POST, 'update_book_barcode', FILTER_SANITIZE_STRING);
    $book_discipline = filter_input(INPUT_POST, 'update_book_discipline', FILTER_SANITIZE_STRING);
    $book_language = filter_input(INPUT_POST, 'update_book_language', FILTER_SANITIZE_STRING);

    // Check if book name changed
    $stmt1 = $mysqli->prepare("SELECT book_name FROM system_book WHERE bookid = ?");
    $stmt1->bind_param('i', $bookid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_book_name);
    $stmt1->fetch();

    //Convert date to MySQL format date
    $book_publish_date = DateTime::createFromFormat('d/m/Y', $book_publish_date);
    $book_publish_date = $book_publish_date->format('Y-m-d');

    //If the book name hasn't changed, do the following
    if ($book_name === $db_book_name) {

        //Update book
        $stmt2 = $mysqli->prepare("UPDATE system_book SET book_notes=?, book_author=?, book_copy_no=?, book_location=?, book_publisher=?, book_publish_date=?, book_publish_place=?, book_page_amount=?, book_barcode=?, book_discipline=?, book_language=?, updated_on=? WHERE bookid=?");
        $stmt2->bind_param('ssissssiisssi', $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $updated_on, $bookid);
        $stmt2->execute();
        $stmt2->close();

    //If the book name has changed, do the following
    } else {

        //Check if book name exists
        $stmt3 = $mysqli->prepare("SELECT bookid FROM system_book WHERE book_name = ?");
        $stmt3->bind_param('s', $event_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_bookid);
        $stmt3->fetch();

        //If book name exists, do the following
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A book with the name entered already exists.');
            exit();

        //If book name does not exist, do the following
        } else {

            //Update book
            $stmt5 = $mysqli->prepare("UPDATE system_book SET book_name=?, book_notes=?, book_author=?, book_copy_no=?, book_location=?, book_publisher=?, book_publish_date=?, book_publish_place=?, book_page_amount=?, book_barcode=?, book_discipline=?, book_language=?, updated_on=? WHERE bookid=?");
            $stmt5->bind_param('sssissssiisssi', $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $updated_on, $bookid);
            $stmt5->execute();
            $stmt5->close();
        }
    }
}

//DeactivateBook function
function DeactivateBook() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $bookToDeactivate = filter_input(INPUT_POST, 'bookToDeactivate', FILTER_SANITIZE_STRING);

    //Deactivate book
    $book_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_book SET book_status=?, updated_on=? WHERE bookid=?");
    $stmt1->bind_param('ssi', $book_status, $updated_on, $bookToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminLibraryUpdate($isUpdate = 1);
}

//DeactivateBook function
function ReactivateBook() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $bookToReactivate = filter_input(INPUT_POST, 'bookToReactivate', FILTER_SANITIZE_STRING);

    //Reactivate book
    $book_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_book SET book_status=?, updated_on=? WHERE bookid=?");
    $stmt1->bind_param('ssi', $book_status, $updated_on, $bookToReactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminLibraryUpdate($isUpdate = 1);
}

//DeleteBook function
function DeleteBook() {

    global $mysqli;

    //Gather data posted and assign variables
    $bookToDelete = filter_input(INPUT_POST, 'bookToDelete', FILTER_SANITIZE_STRING);

    //Delete book
    $stmt1 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE bookid=?");
    $stmt1->bind_param('i', $bookToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete book
    $stmt2 = $mysqli->prepare("DELETE FROM system_book WHERE bookid=?");
    $stmt2->bind_param('i', $bookToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Update tables
    AdminLibraryUpdate($isUpdate = 1);
}

function AdminLibraryUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $active_book;
    global $inactive_book;

    //Get active, reserved or requested books
    $book_status1 = 'active';
    $book_status2 = 'reserved';
    $book_status3 = 'requested';

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_location, book_publisher, book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language, book_status, created_on, updated_on FROM system_book WHERE book_status=? OR book_status=? OR book_status=?");
    $stmt1->bind_param('sss', $book_status1, $book_status2, $book_status3);
    $stmt1->execute();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind results to the variable
            $active_book .=

           '<tr>
			<td data-title="Name"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-book?id='.$bookid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a id="deactivate-'.$bookid.'" class="btn-deactivate-book">Deactivate</a></li>
            <li><a href="#delete-'.$bookid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-book?id='.$bookid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$bookid.'" class="btn btn-primary btn-md btn-deactivate-book">Deactivate</a>
            <a href="#delete-'.$bookid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$bookid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete book?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$book_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$bookid.'" class="btn btn-primary btn-lg btn-delete-book btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

    $stmt1->close();

    //Get inactive books
    $book_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_location, book_publisher, book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language, book_status, created_on, updated_on FROM system_book WHERE book_status=?");
    $stmt2->bind_param('s', $book_status);
    $stmt2->execute();
    $stmt2->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind results to the variable
            $inactive_book .=

           '<tr>
			<td data-title="Book"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a id="reactivate-'.$bookid.'" class="btn btn-primary btn-reactivate-book">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$bookid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a id="reactivate-'.$bookid.'" class="btn btn-primary btn-md btn-reactivate-book">Reactivate</a>
            <a href="#delete-'.$bookid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-'.$bookid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete book?</h4>
            </div>

			<div class="modal-body">
			<p class="text-center">Are you sure you want to delete "'.$book_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$bookid.'" class="btn btn-success btn-lg btn-delete-book btn-load">Delete</a>
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

    $stmt2->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'active_book'=>$active_book,
            'inactive_book'=>$inactive_book
        );

        //Send data back to the Ajax call
        echo json_encode($array);

    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////

//Transport functions
function GetTubeLineLiveStatus() {

    //Global variables
	global $mysqli;
    global $bakerloo, $bakerloo1, $central, $central1, $circle, $circle1, $district, $district1, $hammersmith, $hammersmith1, $jubilee, $jubilee1, $metropolitan, $metropolitan1, $northern, $northern1, $piccadilly, $piccadilly1, $victoria, $victoria1, $waterloo, $waterloo1, $overground, $overground1, $dlr, $dlr1;

    //Get Bakerloo line status
    $stmt1 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Bakerloo'");
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bakerloo, $bakerloo1);
    $stmt1->fetch();
    $stmt1->close();

    //Get Central line status
    $stmt2 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Central'");
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($central, $central1);
    $stmt2->fetch();
    $stmt2->close();

    //Get Circle line status
    $stmt3 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Circle'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($circle, $circle1);
    $stmt3->fetch();
    $stmt3->close();

    //Get District line status
    $stmt4 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='District'");
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($district, $district1);
    $stmt4->fetch();
    $stmt4->close();

    //Get Hammersmith and City line status
    $stmt5 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Hammersmith and City'");
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($hammersmith, $hammersmith1);
    $stmt5->fetch();
    $stmt5->close();

    //Get Jubilee line status
    $stmt6 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Jubilee'");
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($jubilee, $jubilee1);
    $stmt6->fetch();
    $stmt6->close();

    //Get Metropolitan line status
    $stmt7 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Metropolitan'");
    $stmt7->execute();
    $stmt7->store_result();
    $stmt7->bind_result($metropolitan, $metropolitan1);
    $stmt7->fetch();
    $stmt7->close();

    //Get Northern line status
    $stmt8 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Northern'");
    $stmt8->execute();
    $stmt8->store_result();
    $stmt8->bind_result($northern, $northern1);
    $stmt8->fetch();
    $stmt8->close();

    //Get Piccadilly line status
    $stmt9 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Piccadilly'");
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->bind_result($piccadilly, $piccadilly1);
    $stmt9->fetch();
    $stmt9->close();

    //Get Victoria line status
    $stmt10 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Victoria'");
    $stmt10->execute();
    $stmt10->store_result();
    $stmt10->bind_result($victoria, $victoria1);
    $stmt10->fetch();
    $stmt10->close();

    //Get Waterloo and City line status
    $stmt11 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Waterloo and City'");
    $stmt11->execute();
    $stmt11->store_result();
    $stmt11->bind_result($waterloo, $waterloo1);
    $stmt11->fetch();
    $stmt11->close();

    //Get Overground line status
    $stmt12 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='Overground'");
    $stmt12->execute();
    $stmt12->store_result();
    $stmt12->bind_result($overground, $overground1);
    $stmt12->fetch();
    $stmt12->close();

    //Get DLR line status
    $stmt13 = $mysqli->prepare("SELECT tube_line, tube_line_status from tube_line_status_now WHERE tube_line='DLR'");
    $stmt13->execute();
    $stmt13->store_result();
    $stmt13->bind_result($dlr, $dlr1);
    $stmt13->fetch();
    $stmt13->close();

}

function GetTransportStatusLastUpdated() {

    //Global variables
    global $mysqli;
    global $transport_status_last_updated;

    //Get last updated time
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

    //Global variables
	global $mysqli;
	global $session_userid;
	global $created_on;

    //Gather data posted and assign variables
	$task_name = filter_input(INPUT_POST, 'create_task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'create_task_notes', FILTER_SANITIZE_STRING);
    $task_url = filter_input(INPUT_POST, 'create_task_url', FILTER_SANITIZE_STRING);
    $task_startdate = filter_input(INPUT_POST, 'create_task_startdate', FILTER_SANITIZE_STRING);
    $task_duedate = filter_input(INPUT_POST, 'create_task_duedate', FILTER_SANITIZE_STRING);

    //Check if task name exists
    $stmt1 = $mysqli->prepare("SELECT taskid FROM user_task WHERE task_name=? AND userid=? LIMIT 1");
    $stmt1->bind_param('si', $task_name, $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_taskid);
    $stmt1->fetch();

    //If task name exists, do the following
    if ($stmt1->num_rows == 1) {

        $stmt1->close();
	    header('HTTP/1.0 550 A task with the task name entered already exists.');
	    exit();

    //If task name does not exist, do the following
    } else {

        //Set value
        $task_class = 'event-info';

        //Convert dates to MySQL format
        $task_startdate = DateTime::createFromFormat('d/m/Y H:i', $task_startdate);
        $task_startdate = $task_startdate->format('Y-m-d H:i');
        $task_duedate = DateTime::createFromFormat('d/m/Y H:i', $task_duedate);
        $task_duedate = $task_duedate->format('Y-m-d H:i');

        //Create task
        $task_status = 'active';

	    $stmt2 = $mysqli->prepare("INSERT INTO user_task (userid, task_name, task_notes, task_url, task_class, task_startdate, task_duedate, task_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    $stmt2->bind_param('issssssss', $session_userid, $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_status, $created_on);
	    $stmt2->execute();
	    $stmt2->close();

	    $stmt1->close();
    }

    //Update tables
    calendarUpdate($isUpdate = 1);
}

function GetTaskDetails() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $taskid = filter_input(INPUT_POST, 'taskToUpdate', FILTER_SANITIZE_NUMBER_INT);

    //Get task details
    $stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d/%m/%Y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d/%m/%Y %H:%i') as task_duedate FROM user_task WHERE taskid=? LIMIT 1");
    $stmt1->bind_param('i', $taskid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
    $stmt1->fetch();
    $stmt1->close();

    //Create array and bind results to the array
    $array = array(
        'taskid'=>$taskid,
        'task_name'=>$task_name,
        'task_notes'=>$task_notes,
        'task_url'=>$task_url,
        'task_startdate'=>$task_startdate,
        'task_duedate'=>$task_duedate
    );

    //Send data back to the Ajax call
    echo json_encode($array, JSON_UNESCAPED_SLASHES);
}

//UpdateTask function
function UpdateTask() {

    //Global variables
	global $mysqli;
    global $session_userid;
	global $updated_on;

    //Gather data posted and assign variables
	$taskid = filter_input(INPUT_POST, 'update_taskid', FILTER_SANITIZE_NUMBER_INT);
	$task_name = filter_input(INPUT_POST, 'update_task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'update_task_notes', FILTER_SANITIZE_STRING);
	$task_url = filter_input(INPUT_POST, 'update_task_url', FILTER_SANITIZE_STRING);
	$task_startdate = filter_input(INPUT_POST, 'update_task_startdate', FILTER_SANITIZE_STRING);
	$task_duedate = filter_input(INPUT_POST, 'update_task_duedate', FILTER_SANITIZE_STRING);

    //Check if task name changed
	$stmt1 = $mysqli->prepare("SELECT task_name FROM user_task WHERE taskid=? LIMIT 1");
	$stmt1->bind_param('i', $taskid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_taskname);
	$stmt1->fetch();

    //If task name hasn't, do the following
	if ($task_name === $db_taskname) {

        //Convert date to MySQL format
        $task_startdate = DateTime::createFromFormat('d/m/Y H:i', $task_startdate);
        $task_startdate = $task_startdate->format('Y-m-d H:i');
        $task_duedate = DateTime::createFromFormat('d/m/Y H:i', $task_duedate);
        $task_duedate = $task_duedate->format('Y-m-d H:i');

        //Update task
	    $stmt2 = $mysqli->prepare("UPDATE user_task SET task_notes=?, task_url=?, task_startdate=?, task_duedate=?, updated_on=? WHERE taskid = ?");
	    $stmt2->bind_param('sssssi', $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on, $taskid);
	    $stmt2->execute();
	    $stmt2->close();

    //If task name has changed, do the following
	} else {

        //Check if task name exists
        $stmt3 = $mysqli->prepare("SELECT taskid FROM user_task WHERE task_name=? AND userid=? LIMIT 1");
        $stmt3->bind_param('si', $task_name, $session_userid);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_taskid);
        $stmt3->fetch();

        //If task name exists, do the following
	    if ($stmt3->num_rows > 0) {
            $stmt3->close();
            header('HTTP/1.0 550 A task with the name entered already exists.');
            exit();

        //If task name doesn't exist, do the following
        } else {

            //Convert date to MySQL format
            $task_startdate = DateTime::createFromFormat('d/m/Y H:i', $task_startdate);
            $task_startdate = $task_startdate->format('Y-m-d H:i');
            $task_duedate = DateTime::createFromFormat('d/m/Y H:i', $task_duedate);
            $task_duedate = $task_duedate->format('Y-m-d H:i');

            //Update task
            $stmt4 = $mysqli->prepare("UPDATE user_task SET task_name=?, task_notes=?, task_url=?, task_startdate=?, task_duedate=?, updated_on=? WHERE taskid = ?");
            $stmt4->bind_param('ssssssi', $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on, $taskid);
            $stmt4->execute();
            $stmt4->close();
        }
	}

    //Update tables
    calendarUpdate($isUpdate = 1);
}

//CompleteTask function
function CompleteTask() {

    //Global variables
	global $mysqli;
    global $updated_on;
    global $completed_on;

    //Gather data posted and assign variables
	$taskToComplete = filter_input(INPUT_POST, 'taskToComplete', FILTER_SANITIZE_NUMBER_INT);

    //Complete task
    $task_status = 'completed';

	$stmt1 = $mysqli->prepare("UPDATE user_task SET task_status = ?, updated_on = ?, completed_on=? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('sssi', $task_status, $updated_on, $completed_on, $taskToComplete);
	$stmt1->execute();
	$stmt1->close();

    //Update tables
    calendarUpdate($isUpdate = 1);
}

//DeactivateTask function
function DeactivateTask() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $taskToDeactivate = filter_input(INPUT_POST, 'taskToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate task
    $task_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_task SET task_status=?, updated_on=? WHERE taskid = ?");
    $stmt1->bind_param('ssi', $task_status, $updated_on, $taskToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    calendarUpdate($isUpdate = 1);
}

//ReactivateTask function
function ReactivateTask() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $taskToReactivate = filter_input(INPUT_POST, 'taskToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Reactivate task
    $task_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE user_task SET task_status=?, updated_on=? WHERE taskid = ?");
    $stmt1->bind_param('ssi', $task_status, $updated_on, $taskToReactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    calendarUpdate($isUpdate = 1);
}

//DeleteTask function
function DeleteTask() {

    //Global variable
    global $mysqli;

    //Gather data posted and assign variables
    $taskToDelete = filter_input(INPUT_POST, 'taskToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete task
    $stmt1 = $mysqli->prepare("DELETE FROM user_task WHERE taskid = ?");
    $stmt1->bind_param('i', $taskToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    calendarUpdate($isUpdate = 1);
}

function calendarUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $session_userid;
    global $due_task;
    global $completed_task;
    global $archived_task;

    //Get active tasks
    $task_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid=? AND task_status=?");
    $stmt1->bind_param('is', $session_userid, $task_status);
    $stmt1->execute();
    $stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

        //Bind results to variable
        $due_task .=

       '<tr>
        <td data-title="Name"><a href="#view-'.$taskid .'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'. $task_startdate .'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="complete-'.$taskid.'" class="btn btn-primary btn-complete-task">Complete</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a id="#update-'.$taskid.'" class="btn-update-task">Update</a></li>
        <li><a id="deactivate-'.$taskid.'" class="btn-deactivate-task">Archive</a></li>
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
        </ul>
        </div>

        <div id="view-'.$taskid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close"><i class="fa fa-calendar"></i></div>
        <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
        </div>

        <div class="modal-body">
        <p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
        <p><b>URL:</b> '.(empty($task_url) ? "-" : "<a href=\"//$task_url\" target=\"_blank\">Link</a>").'</p>
        <p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
        <p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a id="#update-'.$taskid.'" class="btn btn-primary btn-md btn-update-task">Update</a>
        <a id="#complete-'.$taskid.'" class="btn btn-primary btn-md btn-complete-task">Complete</a>
        <a id="#deactivate-'.$taskid.'" class="btn btn-primary btn-md btn-deactivate-task">Archive</a>
        <a href="#delete-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!--/modal -->
        </div><!--/modal-dialog-->
        </div><!--/modal-content-->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="pull-right">
        <a id="delete-'.$taskid.'" class="btn btn-primary btn-lg btn-delete-task btn-load">Delete</a>
        <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        </td>
        </tr>';
        }
    }
    $stmt1->close();

    //Get completed tasks
    $task_status = 'completed';

    $stmt2 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid=? AND task_status=?");
    $stmt2->bind_param('is', $session_userid, $task_status);
    $stmt2->execute();
    $stmt2->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt2->store_result();

    while($stmt2->fetch()) {

        if ($stmt2->num_rows > 0) {

        //Bind results to variable
        $completed_task .=

       '<tr>
        <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal" data-dismiss="modal">'.$task_name.'</a></td>
        <td data-title="Start">'.$task_startdate.'</td>
        <td data-title="Due">'.$task_duedate.'</td>
        <td data-title="Completed on">'.$task_duedate.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate-task">Restore</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
        </ul>
        </div>

        <div id="view-'.$taskid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close">
        <i class="fa fa-calendar"></i>
        </div>
        <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
        </div>

        <div class="modal-body">
        <p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
        <p><b>URL:</b> '.(empty($task_url) ? "-" : "<a href=\"//$task_url\" target=\"_blank\">Link</a>").'</p>
        <p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
        <p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
        <p><b>Completed on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a id="#reactivate-'.$taskid.'" class="btn btn-primary btn-md btn-reactivate-task">Restore</a>
        <a href="#delete-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="text-center">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a id="delete-'.$taskid.'" class="btn btn-primary btn-lg btn-delete-task btn-load">Confirm</a>
        <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->
        </td>
        </tr>';
        }
    }

    $stmt2->close();

    //Get inactive tasks
    $task_status = 'inactive';

    $stmt3 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task WHERE userid=? AND task_status=?");
    $stmt3->bind_param('is', $session_userid, $task_status);
    $stmt3->execute();
    $stmt3->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt3->store_result();

        if ($stmt3->num_rows > 0) {

        while($stmt3->fetch()) {

        //Bind results to variable
        $archived_task .=

       '<tr>
        <td data-title="Name"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'.$task_startdate.'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Archived on">'.$updated_on.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate-task">Restore</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
        </ul>
        </div>

        <div id="view-'.$taskid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close"><i class="fa fa-calendar"></i></div>
        <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
        </div>

        <div class="modal-body">
        <p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
        <p><b>URL:</b> '.(empty($task_url) ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</p>
        <p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
        <p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
        <p><b>Archived on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a id="#reactivate-'.$taskid.'" class="btn btn-primary btn-md btn-reactivate">Restore</a>
        <a href="#delete-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a id="delete-'.$taskid.'" class="btn btn-primary btn-lg btn-delete-task btn-load">Confirm</a>
        <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->
        </td>
        </tr>';
        }
    }

    $stmt3->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'due_task'=>$due_task,
            'completed_task'=>$completed_task,
            'archived_task'=>$archived_task
        );

        //Send data back to the Ajax call
        echo json_encode($array);

    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//University map function
//CreateLocation function
function CreateLocation() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $marker_name = filter_input(INPUT_POST, 'marker_name', FILTER_SANITIZE_STRING);
    $marker_notes = filter_input(INPUT_POST, 'marker_notes', FILTER_SANITIZE_STRING);
    $marker_url = filter_input(INPUT_POST, 'marker_url', FILTER_SANITIZE_STRING);
    $marker_lat = filter_input(INPUT_POST, 'marker_lat', FILTER_SANITIZE_STRING);
    $marker_long = filter_input(INPUT_POST, 'marker_long', FILTER_SANITIZE_STRING);
    $marker_category = filter_input(INPUT_POST, 'marker_category', FILTER_SANITIZE_STRING);

    //Check if the location name exists
    $stmt1 = $mysqli->prepare("SELECT markerid FROM system_map_marker WHERE marker_name=? LIMIT 1");
    $stmt1->bind_param('s', $marker_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_markerid);
    $stmt1->fetch();

    //If the location name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 The location name you entered already exists.');
        exit();

    //If the location name doesn't exist, do the following
    } else {

        //Create marker
        $marker_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_url, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssiisss', $marker_name, $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $marker_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

    }
}

//UpdateLocation function
function UpdateLocation() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign to variables
    $markerid = filter_input(INPUT_POST, 'markerid', FILTER_SANITIZE_STRING);
    $marker_name = filter_input(INPUT_POST, 'marker_name1', FILTER_SANITIZE_STRING);
    $marker_notes = filter_input(INPUT_POST, 'marker_notes1', FILTER_SANITIZE_STRING);
    $marker_url = filter_input(INPUT_POST, 'marker_url1', FILTER_SANITIZE_STRING);
    $marker_lat = filter_input(INPUT_POST, 'marker_lat1', FILTER_SANITIZE_STRING);
    $marker_long = filter_input(INPUT_POST, 'marker_long1', FILTER_SANITIZE_STRING);
    $marker_category = filter_input(INPUT_POST, 'marker_category1', FILTER_SANITIZE_STRING);

    //Check if the event name has changed
    $stmt1 = $mysqli->prepare("SELECT marker_name FROM system_map_marker WHERE markerid=? LIMIT 1");
    $stmt1->bind_param('i', $markerid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_marker_name);
    $stmt1->fetch();

    //If the event name hasn't changed, do the following
    if ($db_marker_name === $marker_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_map_marker SET marker_notes=?, marker_url=?, marker_lat=?, marker_long=?, marker_category=?, updated_on=? WHERE markerid=?");
        $stmt2->bind_param('ssiissi', $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $updated_on, $markerid);
        $stmt2->execute();
        $stmt2->close();

    //If the event name has changed, do the following
    } else {

        //Check if the event name exists
        $stmt3 = $mysqli->prepare("SELECT markerid FROM system_map_marker WHERE marker_name = ?");
        $stmt3->bind_param('s', $marker_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_markerid);
        $stmt3->fetch();

        //If the location name exists, do the folowing
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A location with the name entered already exists.');
            exit();

        //If the location name doesn't exist, do the folowing
        } else {

            //Update location
            $stmt4 = $mysqli->prepare("UPDATE system_map_marker SET marker_name=?, marker_notes=?, marker_url=?, marker_lat=?, marker_long=?, marker_category=?, updated_on=? WHERE markerid=?");
            $stmt4->bind_param('sssiissi', $marker_name, $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $updated_on, $markerid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateLocation function
function DeactivateLocation() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign to variables
    $locationToDeactivate = filter_input(INPUT_POST, 'locationToDeactivate', FILTER_SANITIZE_STRING);

    //Deactivate location
    $marker_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_map_marker SET marker_status=?, updated_on=? WHERE markerid=?");
    $stmt1->bind_param('ssi', $marker_status, $updated_on, $locationToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminUniversityMapUpdate($isUpdate = 1);

}

//ReactivateLocation function
function ReactivateLocation() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign to variables
    $locationToReactivate = filter_input(INPUT_POST, 'locationToReactivate', FILTER_SANITIZE_STRING);

    //Reactivate location
    $marker_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_map_marker SET marker_status=?, updated_on=? WHERE markerid=?");
    $stmt1->bind_param('ssi', $marker_status, $updated_on, $locationToReactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminUniversityMapUpdate($isUpdate = 1);

}

//DeleteLocation function
function DeleteLocation() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign to variables
    $locationToDelete = filter_input(INPUT_POST, 'locationToDelete', FILTER_SANITIZE_STRING);

    //Delete location
    $stmt1 = $mysqli->prepare("DELETE FROM system_map_marker WHERE markerid=?");
    $stmt1->bind_param('i', $locationToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminUniversityMapUpdate($isUpdate = 1);
}


function AdminUniversityMapUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $active_location;
    global $inactive_location;

    //Get active map markers
    $marker_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_marker WHERE marker_status=?");
    $stmt1->bind_param('s', $marker_status);
    $stmt1->execute();
    $stmt1->bind_result($markerid, $marker_name, $marker_lat, $marker_long, $marker_category, $created_on, $updated_on);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind results to the variable
            $active_location .=

           '<tr>
			<td data-title="Location"><a href="#view-location-'.$markerid.'" data-toggle="modal">'.$marker_name.'</a></td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.ucfirst($marker_category).'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-location/?id='.$markerid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a id="deactivate-'.$markerid.'" class="btn-deactivate-location">Deactivate</a></li>
            <li><a href="#delete-'.$markerid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-location-'.$markerid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-map-marker"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$marker_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Latitude:</b> '.(empty($marker_lat) ? "-" : "$marker_lat").'</p>
			<p><b>Longitude:</b> '.(empty($marker_long) ? "-" : "$marker_long").'</p>
			<p><b>Category:</b> '.(empty($marker_category) ? "-" : ucfirst($marker_category)).'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-location?id='.$markerid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$markerid.'" class="btn btn-primary btn-md btn-deactivate-location" data-dismiss="modal">Deactivate</a>
            <a href="#delete-'.$markerid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$markerid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete location?</h4>
            </div>

			<div class="modal-body">
			<p class="text-center">Are you sure you want to delete "'.$marker_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$markerid.'" class="btn btn-danger btn-md btn-delete-location btn-load">Delete</a>
			<a class="btn btn-success btn-md" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

	$stmt1->close();

    //Get inactive map markers
    $marker_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_marker WHERE marker_status=?");
    $stmt2->bind_param('s', $marker_status);
    $stmt2->execute();
    $stmt2->bind_result($markerid, $marker_name, $marker_lat, $marker_long, $marker_category, $created_on, $updated_on);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind results to the variable
            $inactive_location .=

           '<tr>
			<td data-title="Location"><a href="#view-location-'.$markerid.'">'.$marker_name.'</a></td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.ucfirst($marker_category).'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a id="reactivate-'.$markerid.'" class="btn btn-primary btn-reactivate-location">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$markerid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-location-'.$markerid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-map-marker"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$marker_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Latitude:</b> '.(empty($marker_lat) ? "-" : "$marker_lat").'</p>
			<p><b>Longitude:</b> '.(empty($marker_long) ? "-" : "$marker_long").'</p>
			<p><b>Category:</b> '.(empty($marker_category) ? "-" : ucfirst($marker_category)).'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-location?id='.$markerid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$markerid.'" class="btn btn-primary btn-md btn-deactivate-location" data-dismiss="modal">Deactivate</a>
            <a href="#delete-'.$markerid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$markerid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete location?</h4>
            </div>

			<div class="modal-body">
			<p class="text-center">Are you sure you want to delete "'.$marker_name.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$markerid.'" class="btn btn-danger btn-lg btn-delete-location btn-load">Delete</a>
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
	}

	$stmt2->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'active_location'=>$active_location,
            'inactive_location'=>$inactive_location
        );

        //Send data back to the Ajax call
        echo json_encode($array);

    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Events functions
//EventsPaypalPaymentSuccess function
function EventsPaypalPaymentSuccess() {

    //Global variables
	global $mysqli;
	global $newquantity;
	global $created_on;
    global $updated_on;
	global $completed_on;

    //Get data from Paypal IPN
    $invoiceid = $_POST["invoice"];
    $transactionid  = $_POST["txn_id"];

	$payment_status = strtolower($_POST["payment_status"]);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

    $item_number1 = $_POST["item_number1"];
    $product_name = $_POST["item_name1"];
    $quantity1 = $_POST["quantity1"];
    $product_amount = $_POST["mc_gross"];

    //Get userid by using invoiceid
	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoiceid = ? LIMIT 1");
	$stmt1->bind_param('i', $invoiceid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

    //Create booked event
    $event_class = 'event-important';

	$stmt2 = $mysqli->prepare("INSERT INTO system_event_booked (event_class, userid, eventid, event_amount_paid, ticket_quantity, booked_on) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt2->bind_param('siiiis', $event_class, $userid, $item_number1, $product_amount, $quantity1, $created_on);
	$stmt2->execute();
	$stmt2->close();

    //Get event_ticket_no
	$stmt3 = $mysqli->prepare("SELECT event_ticket_no from system_event where eventid=? LIMIT 1");
	$stmt3->bind_param('i', $item_number1);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($event_ticket_no);
	$stmt3->fetch();
	$stmt3->close();

    //Decrease event_ticket_no, bind result variable
	$newquantity = $event_ticket_no - $quantity1;

    //Update event
	$stmt4 = $mysqli->prepare("UPDATE system_event SET event_ticket_no=? WHERE eventid=?");
	$stmt4->bind_param('ii', $newquantity, $item_number1);
	$stmt4->execute();
	$stmt4->close();

    //Update PayPal log
	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET transactionid=?, payment_status =?, updated_on=?, completed_on=? WHERE invoiceid =?");
	$stmt5->bind_param('ssssi', $transactionid, $payment_status, $updated_on, $completed_on, $invoiceid);
	$stmt5->execute();
	$stmt5->close();

    //Get user details
    $stmt6 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($email, $firstname, $surname);
    $stmt6->fetch();
    $stmt6->close();

	//Creating email

    //email subject
	$subject = 'Payment confirmation';

    //email message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent payment! Below, you can find the payment summary:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Invoice ID:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $invoiceid</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Transaction ID:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $transactionid</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $product_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Amount paid (&pound;):</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> &pound;$product_amount</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment time and date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $payment_date</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $payment_status1</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

    //email headers
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    //Send the email
	mail($email, $subject, $message, $headers);
}

//EventTicketQuantityCheck function
function EventTicketQuantityCheck () {

    //Global variable
	global $mysqli;

    //Gather data and assign variables
	$eventid = filter_input(INPUT_POST, 'eventid', FILTER_SANITIZE_STRING);
	$product_quantity = filter_input(INPUT_POST, 'product_quantity', FILTER_SANITIZE_STRING);

    //Check if quantity requested is greater than tickets available
	$stmt1 = $mysqli->prepare("SELECT event_ticket_no FROM system_event WHERE eventid = ? LIMIT 1");
	$stmt1->bind_param('i', $eventid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($event_ticket_no);
	$stmt1->fetch();

    //If quantity requested is greater than tickets available, do the following
	if ($product_quantity > $event_ticket_no) {
		echo 'error';
		$stmt1->close();
	}

}

//CreateEvent function
function CreateEvent() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $event_name = filter_input(INPUT_POST, 'create_event_name', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'create_event_notes', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'create_event_url', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'create_event_from', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'create_event_to', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'create_event_amount', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'create_event_ticket_no', FILTER_SANITIZE_STRING);

    // Check if event name exists
    $stmt1 = $mysqli->prepare("SELECT eventid FROM system_event WHERE event_name=? LIMIT 1");
    $stmt1->bind_param('s', $event_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_eventid);
    $stmt1->fetch();

    //If event name exists, do the following
    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 The event name you entered already exists.');
        exit();

    //If event name does not exist, do the following
    } else {

        //Set value
        $event_class = 'event-important';

        //Convert dates to MySQL format
        $event_from = DateTime::createFromFormat('d/m/Y H:i', $event_from);
        $event_from = $event_from->format('Y-m-d H:i');
        $event_to = DateTime::createFromFormat('d/m/Y H:i', $event_to);
        $event_to = $event_to->format('Y-m-d H:i');

        //Create event
        $event_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO system_event (event_class, event_name, event_notes, event_url, event_from, event_to, event_amount, event_ticket_no, event_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('ssssssiiss', $event_class, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $event_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

    }
}

//UpdateEvent function
function UpdateEvent() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $eventid = filter_input(INPUT_POST, 'update_eventid', FILTER_SANITIZE_STRING);
    $event_name = filter_input(INPUT_POST, 'update_event_name', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'update_event_notes', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'update_event_url', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'update_event_from', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'update_event_to', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'update_event_amount', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'update_event_ticket_no', FILTER_SANITIZE_STRING);

    //Check if the event name has changed
    $stmt1 = $mysqli->prepare("SELECT event_name FROM system_event WHERE eventid = ?");
    $stmt1->bind_param('i', $eventid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_event_name);
    $stmt1->fetch();

    //Convert dates to MySQL format
    $event_from = DateTime::createFromFormat('d/m/Y H:i', $event_from);
    $event_from = $event_from->format('Y-m-d H:i');
    $event_to = DateTime::createFromFormat('d/m/Y H:i', $event_to);
    $event_to = $event_to->format('Y-m-d H:i');

    //If the event name hasn't changed, do the following
    if ($db_event_name === $event_name) {

        //Update event
        $stmt2 = $mysqli->prepare("UPDATE system_event SET event_notes=?, event_url=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, updated_on=? WHERE eventid=?");
        $stmt2->bind_param('ssssiisi', $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $updated_on, $eventid);
        $stmt2->execute();
        $stmt2->close();

    //If the event name has changed, do the following
    } else {

        //Check if event name exists
        $stmt3 = $mysqli->prepare("SELECT eventid FROM system_event WHERE event_name = ?");
        $stmt3->bind_param('s', $event_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_eventid);
        $stmt3->fetch();

        //If the event name exists, do the following
        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 An event with the name entered already exists.');
            exit();

        //If the event name doesn't exist, do the following
        } else {

            //Update event
            $stmt4 = $mysqli->prepare("UPDATE system_event SET event_name=?, event_notes=?, event_url=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, updated_on=? WHERE eventid=?");
            $stmt4->bind_param('sssssiisi', $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $updated_on, $eventid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateEvent function
function DeactivateEvent() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $eventToDeactivate = filter_input(INPUT_POST, 'eventToDeactivate', FILTER_SANITIZE_STRING);

    //Deactivate event
    $event_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_event SET event_status=?, updated_on=? WHERE eventid=?");
    $stmt1->bind_param('ssi', $event_status, $updated_on, $eventToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminEventUpdate($isUpdate = 1);
}

//ReactivateEvent function
function ReactivateEvent() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $eventToReactivate = filter_input(INPUT_POST, 'eventToReactivate', FILTER_SANITIZE_STRING);

    //Reactivate event
    $event_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_event SET event_status=?, updated_on=? WHERE eventid=?");
    $stmt1->bind_param('ssi', $event_status, $updated_on, $eventToReactivate);
    $stmt1->execute();
    $stmt1->close();

    //Update tables
    AdminEventUpdate($isUpdate = 1);
}

//DeleteEvent function
function DeleteEvent() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $eventToDelete = filter_input(INPUT_POST, 'eventToDelete', FILTER_SANITIZE_STRING);

    //Delete event
    $stmt1 = $mysqli->prepare("DELETE FROM system_event_booked WHERE eventid=?");
    $stmt1->bind_param('i', $eventToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete event
    $stmt2 = $mysqli->prepare("DELETE FROM system_event WHERE eventid=?");
    $stmt2->bind_param('i', $eventToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Gather data posted and assign variables
    AdminEventUpdate($isUpdate = 1);
}

function AdminEventUpdate($isUpdate = 0) {

    //Global variables
    global $mysqli;
    global $active_event;
    global $inactive_event;

    //Get active events
    $event_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE event_status=?");
    $stmt1->bind_param('s', $event_status);
    $stmt1->execute();
    $stmt1->bind_result($eventid, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            //Bind results to the variable
            $active_event .=

            '<tr>
            <td data-title="Event"><a href="#view-'.$eventid.'" data-toggle="modal" data-dismiss="modal">'.$event_name.'</a></td>
            <td data-title="From">'.$event_from.'</td>
            <td data-title="To">'.$event_to.'</td>
            <td data-title="Price (&pound;)">'.$event_amount.'</td>
            <td data-title="Tickets available">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-event?id='.$eventid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a id="deactivate-'.$eventid.'" class="btn-deactivate-event">Deactivate</a></li>
            <li><a href="#delete-'.$eventid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-'.$eventid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="close"><i class="fa fa-ticket"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$event_name.'</h4>
            </div>

            <div class="modal-body">
            <p><b>Description:</b> '.(empty($event_notes) ? "-" : "$event_notes").'</p>
            <p><b>URL:</b> '.(empty($event_url) ? "-" : "$event_url").'</p>
            <p><b>From:</b> '.$event_from.'</p>
            <p><b>To:</b> '.$event_to.'</p>
            <p><b>Price (&pound;):</b> '.$event_amount.'</p>
            <p><b>Ticket available:</b> '.$event_ticket_no.'</p>
            </div>

            <div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-event?id='.$eventid.'" class="btn btn-primary btn-md">Update</a>
            <a id="deactivate-'.$eventid.'" class="btn btn-primary btn-md btn-deactivate-event">Deactivate</a>
            <a href="#delete-'.$eventid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
            </div>
            <div class="view-close pull-right">
            <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            <div id="delete-'.$eventid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete event?</h4>
            </div>

            <div class="modal-body">
            <p class="text-left">Are you sure you want to delete "'.$event_name.'"?</p>
            </div>

            <div class="modal-footer">
            <div class="text-right">
            <a id="delete-'.$eventid.'" class="btn btn-primary btn-lg btn-delete-event btn-load">Delete</a>
            <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>

            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            </td>
            </tr>';
        }
    }

    $stmt1->close();

    //Get inactivate events
    $event_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE event_status=?");
    $stmt2->bind_param('s', $event_status);
    $stmt2->execute();
    $stmt2->bind_result($eventid, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            //Bind results to the variable
            $inactive_event .=

           '<tr>
            <td data-title="Event"><a href="#view-'.$eventid.'" data-toggle="modal" data-dismiss="modal">'.$event_name.'</a></td>
            <td data-title="From">'.$event_from.'</td>
            <td data-title="To">'.$event_to.'</td>
            <td data-title="Price (&pound;)">'.$event_amount.'</td>
            <td data-title="Tickets available">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a id="reactivate-'.$eventid.'" class="btn btn-primary btn-reactivate-event">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$eventid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div id="view-'.$eventid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="close"><i class="fa fa-ticket"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$event_name.'</h4>
            </div>

            <div class="modal-body">
            <p><b>Description:</b> '.(empty($event_notes) ? "-" : "$event_notes").'</p>
            <p><b>URL:</b> '.(empty($event_url) ? "-" : "$event_url").'</p>
            <p><b>From:</b> '.$event_from.'</p>
            <p><b>To:</b> '.$event_to.'</p>
            <p><b>Price (&pound;):</b> '.$event_amount.'</p>
            <p><b>Ticket available:</b> '.$event_ticket_no.'</p>
            </div>

            <div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-event?id='.$eventid.'" class="btn btn-primary btn-md" >Update</a>
            <a id="reactivate-'.$eventid.'" class="btn btn-primary btn-md btn-reactivate-event">Reactivate</a>
            <a href="#delete-'.$eventid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
            </div>
            <div class="view-close pull-right">
            <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            <div id="delete-'.$eventid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete event?</h4>
            </div>

            <div class="modal-body">
            <p class="text-left">Are you sure you want to delete "'.$event_name.'"?</p>
            </div>

            <div class="modal-footer">
            <div class="text-right">
            <a id="delete-'.$eventid.'" class="btn btn-primary btn-lg btn-delete-event btn-load">Delete</a>
            <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            </td>
            </tr>';
        }
	}

	$stmt2->close();

    //If the call to the function was made with parameter 'isUpdate' = 1, do the following
    if ($isUpdate === 1) {

        //Create array and bind results to the array
        $array = array(
            'active_event'=>$active_event,
            'inactive_event'=>$inactive_event
        );

        //Send data back to the array
        echo json_encode($array);

    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Feedback functions
//SubmitFeedback function
function SubmitFeedback() {

    //Global variables
    global $mysqli;
    global $session_userid;
    global $created_on;

    //Gather data posted and assign variables
    $feedback_moduleid = filter_input(INPUT_POST, 'feedback_moduleid', FILTER_SANITIZE_STRING);
    $feedback_lecturer = filter_input(INPUT_POST, 'feedback_lecturer', FILTER_SANITIZE_STRING);
    $feedback_tutorial_assistant = filter_input(INPUT_POST, 'feedback_tutorial_assistant', FILTER_SANITIZE_STRING);
    $feedback_subject = filter_input(INPUT_POST, 'feedback_subject', FILTER_SANITIZE_STRING);
    $feedback_body = filter_input(INPUT_POST, 'feedback_body', FILTER_SANITIZE_STRING);

    //Create feedback
    $feedback_status = 'active';
    $isApproved = 0;

    $stmt1 = $mysqli->prepare("INSERT INTO user_feedback (moduleid, feedback_subject, feedback_body, feedback_status, isApproved, created_on) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('isssis', $feedback_moduleid, $feedback_subject, $feedback_body, $feedback_status, $isApproved, $created_on);
    $stmt1->execute();
    $stmt1->close();

    //Get feedbackid
    $stmt2 = $mysqli->prepare("SELECT feedbackid FROM user_feedback ORDER BY feedbackid DESC LIMIT 1");
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($feedbackid);
    $stmt2->fetch();

    //Set value
    $isRead = 0;

    //Create feedback
    $stmt3 = $mysqli->prepare("INSERT INTO user_feedback_sent (feedbackid, feedback_from, moduleid, module_staff) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param('iiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_lecturer);
    $stmt3->execute();
    $stmt3->close();

    //Create feedback
    $stmt4 = $mysqli->prepare("INSERT INTO user_feedback_sent (feedbackid, feedback_from, moduleid, module_staff) VALUES (?, ?, ?, ?)");
    $stmt4->bind_param('iiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_tutorial_assistant);
    $stmt4->execute();
    $stmt4->close();

    //Create feedback
    $stmt5 = $mysqli->prepare("INSERT INTO user_feedback_received (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt5->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_lecturer, $isRead);
    $stmt5->execute();
    $stmt5->close();


    //Create feedback
    $stmt6 = $mysqli->prepare("INSERT INTO user_feedback_received (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt6->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_tutorial_assistant, $isRead);
    $stmt6->execute();
    $stmt6->close();

}

//ApproveFeedback function
function ApproveFeedback () {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $feedbackToApprove = filter_input(INPUT_POST, 'feedbackToApprove', FILTER_SANITIZE_STRING);

    //Set isApproved flag to 1
    $isApproved = 1;

    $stmt1 = $mysqli->prepare("UPDATE user_feedback SET isApproved=? WHERE feedbackid=?");
    $stmt1->bind_param('ii', $isApproved, $feedbackToApprove);
    $stmt1->execute();
    $stmt1->close();

    //Get feedback details
    $stmt2 = $mysqli->prepare("SELECT feedback_subject, feedback_body FROM user_feedback WHERE feedbackid = ? LIMIT 1");
    $stmt2->bind_param('i', $feedbackToApprove);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($feedback_subject, $feedback_body);
    $stmt2->fetch();
    $stmt2->close();

    //Get recipient email
    $stmt3 = $mysqli->prepare("SELECT s.email FROM user_feedback_received f LEFT JOIN user_signin s ON f.module_staff=s.userid WHERE f.feedbackid=? ORDER BY f.module_staff ASC LIMIT 1");
    $stmt3->bind_param('i', $feedbackToApprove);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($lecturer_feedback_to_email);
    $stmt3->fetch();
    $stmt3->close();

    //Get recipient email
    $stmt4 = $mysqli->prepare("SELECT s.email FROM user_feedback_received f LEFT JOIN user_signin s ON f.module_staff=s.userid WHERE f.feedbackid=? ORDER BY f.module_staff DESC LIMIT 1");
    $stmt4->bind_param('i', $feedbackToApprove);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($tutorial_assistant_feedback_to_email);
    $stmt4->fetch();
    $stmt4->close();

    //Get sender userid
    $stmt5 = $mysqli->prepare("SELECT feedback_from FROM user_feedback_received WHERE feedbackid = ? LIMIT 1");
    $stmt5->bind_param('i', $feedbackToApprove);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($feedback_from);
    $stmt5->fetch();
    $stmt5->close();

    //Get sender details
    $stmt6 = $mysqli->prepare("SELECT s.email, d.firstname, d.surname FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid WHERE s.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $feedback_from);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($feedback_from_email, $feedback_from_firstname, $feedback_from_surname);
    $stmt6->fetch();
    $stmt6->close();

    //Creating email

    //email subject
    $subject = "$feedback_from_firstname $feedback_from_surname - New feedback on Student Portal";

    //email message
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

    //email headers
    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= "From: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";
    $headers .= "Reply-To: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";

    //Send the email
    mail("$lecturer_feedback_to_email, $tutorial_assistant_feedback_to_email", $subject, $message, $headers);
}

//SetFeedbackRead function
function SetFeedbackRead () {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $feedbackToRead = filter_input(INPUT_POST, 'feedbackToRead', FILTER_SANITIZE_STRING);

    //Get isApproved
    $stmt1 = $mysqli->prepare("SELECT isApproved FROM user_feedback WHERE feedbackid = ? LIMIT 1");
    $stmt1->bind_param('i', $feedbackToRead);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($isApproved);
    $stmt1->fetch();
    $stmt1->close();

    //If isApproved is 1, do the following
    if($isApproved === 1) {

        //Set value
        $isRead = 1;

        //Set isRead flag to 1
        $stmt1 = $mysqli->prepare("UPDATE user_feedback_received SET isRead=? WHERE feedbackid=?");
        $stmt1->bind_param('ii', $isRead, $feedbackToRead);
        $stmt1->execute();
        $stmt1->close();
    }
}

//DeleteFeedback function
function DeleteFeedback () {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $feedbackToDelete = filter_input(INPUT_POST, 'feedbackToDelete', FILTER_SANITIZE_STRING);

    //Delete sent feedback
    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedbackid=?");
    $stmt1->bind_param('i', $feedbackToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete received feedback
    $stmt2 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE feedbackid=?");
    $stmt2->bind_param('i', $feedbackToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Delete feedback
    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback WHERE feedbackid=?");
    $stmt3->bind_param('i', $feedbackToDelete);
    $stmt3->execute();
    $stmt3->close();
}

//DeleteSentFeedback function
function DeleteSentFeedback () {

    //Global variables
    global $mysqli;
    global $session_userid;

    //Gather data posted and assign variables
    $sentFeedbackToDelete = filter_input(INPUT_POST, 'sentFeedbackToDelete', FILTER_SANITIZE_STRING);

    //Delete sent feedback
    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedbackid=? AND feedback_from=?");
    $stmt1->bind_param('ii', $sentFeedbackToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteReceivedFeedback function
function DeleteReceivedFeedback () {

    //Global variables
    global $mysqli;
    global $session_userid;

    //Gather data posted and assign variables
    $receivedFeedbackToDelete = filter_input(INPUT_POST, 'receivedFeedbackToDelete', FILTER_SANITIZE_STRING);

    //Delete received feedback
    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE feedbackid=? AND module_staff=?");
    $stmt1->bind_param('ii', $receivedFeedbackToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();

}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//Messenger functions
//MessageUser function
function SendMessage() {

    //Global variables
	global $mysqli;
	global $session_userid;
	global $created_on;

    //Gather data posted and assign variables
	$message_to_userid = filter_input(INPUT_POST, 'message_to_userid', FILTER_SANITIZE_STRING);
	$message_to_firstname = filter_input(INPUT_POST, 'message_to_firstname', FILTER_SANITIZE_STRING);
	$message_to_surname = filter_input(INPUT_POST, 'message_to_surname', FILTER_SANITIZE_STRING);
	$message_to_email = filter_input(INPUT_POST, 'message_to_email', FILTER_SANITIZE_EMAIL);
    $message_to_email = filter_var($message_to_email, FILTER_VALIDATE_EMAIL);
	$message_subject = filter_input(INPUT_POST, 'message_subject', FILTER_SANITIZE_STRING);
	$message_body = filter_input(INPUT_POST, 'message_body', FILTER_SANITIZE_STRING);

    //Create message
    $message_status = 'active';

	$stmt1 = $mysqli->prepare("INSERT INTO user_message (message_subject, message_body, message_status, created_on) VALUES (?, ?, ?, ?)");
	$stmt1->bind_param('ssss', $message_subject, $message_body, $message_status, $created_on);
	$stmt1->execute();
	$stmt1->close();

    //Create sent message
    $stmt2 = $mysqli->prepare("INSERT INTO user_message_sent (message_from, message_to) VALUES (?, ?)");
    $stmt2->bind_param('ii', $session_userid, $message_to_userid);
    $stmt2->execute();
    $stmt2->close();

    //Create received message

    $isRead = 0;
    $stmt3 = $mysqli->prepare("INSERT INTO user_message_received (message_from, message_to, isRead) VALUES (?, ?, ?)");
    $stmt3->bind_param('iii', $session_userid, $message_to_userid, $isRead);
    $stmt3->execute();
    $stmt3->close();

	//Create email

    //email subject
	$subject = "$message_to_firstname $message_to_surname - New message on Student Portal";

    //email message
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

    //email headers
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= "From: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";
	$headers .= "Reply-To: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";

    //Send the email
	mail($message_to_email, $subject, $message, $headers);

}

//SetMessageRead function
function SetMessageRead () {

    //Global variables
	global $mysqli;

    //Gather data posted and assign variables
    $messageToRead = filter_input(INPUT_POST, 'messageToRead', FILTER_SANITIZE_STRING);

    //Set isRead flag to 1
	$isRead = 1;

	$stmt1 = $mysqli->prepare("UPDATE user_message_received SET isRead=? WHERE messageid=?");
	$stmt1->bind_param('ii', $isRead, $messageToRead);
	$stmt1->execute();
	$stmt1->close();
}

//DeleteReceivedMessage function
function DeleteReceivedMessage () {

    //Global variables
    global $mysqli;
    global $session_userid;

    //Gather data posted and assign variables
    $receivedFeedbackToDelete = filter_input(INPUT_POST, 'receivedMessageToDelete', FILTER_SANITIZE_STRING);

    //Delete received message
    $stmt1 = $mysqli->prepare("DELETE FROM user_message_received WHERE messageid=? AND message_to=?");
    $stmt1->bind_param('ii', $receivedFeedbackToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();

}

//DeleteSentMessage function
function DeleteSentMessage () {

    //Global variables
    global $mysqli;
    global $session_userid;

    //Gather data posted and assign variables
    $sentMessageToDelete = filter_input(INPUT_POST, 'sentMessageToDelete', FILTER_SANITIZE_STRING);

    //Delete sent message
    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE messageid=? AND message_from=?");
    $stmt1->bind_param('ii', $sentMessageToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();

}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//Account functions
//UpdateAccount function
function UpdateAccount() {

    //Global variables
	global $mysqli;
	global $session_userid;
	global $updated_on;

    //Gather data posted and assign variables
	$firstname = filter_input(INPUT_POST, 'update_firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'update_surname', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'update_gender', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'update_email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$nationality = filter_input(INPUT_POST, 'update_nationality', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'update_dateofbirth', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'update_phonenumber', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'update_address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'update_address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'update_town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'update_city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'update_country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'update_postcode', FILTER_SANITIZE_STRING);

    //Convert to lowercase
    $gender = strtolower($gender);
    $nationality = strtolower($nationality);

    //If dateofbirth is empty, do the following
    if ($dateofbirth == '') {

        //Set value
		$dateofbirth = NULL;

	} else {

        //Convert date to MySQL format
        $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
        $dateofbirth = $dateofbirth->format('Y-m-d');
    }

    //Check if email is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	}
	else {

        //Check if email has changed
        $stmt1 = $mysqli->prepare("SELECT email from user_signin where userid = ?");
        $stmt1->bind_param('i', $session_userid);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_email);
        $stmt1->fetch();

        //If the email hasn't changed, do the following
	    if ($db_email === $email) {

            //Update account
            $stmt2 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
            $stmt2->bind_param('sssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $session_userid);
            $stmt2->execute();
            $stmt2->close();

            //Create email

            //email subject
            $subject = 'Account updated successfully';

            //email message
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

            //email headers
            $headers  = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            // Send the message
            mail($email, $subject, $message, $headers);

	    } else {

            //Check if the email address exists
            $stmt3 = $mysqli->prepare("SELECT userid from user_signin where email = ?");
            $stmt3->bind_param('s', $email);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($db_userid);
            $stmt3->fetch();

            //If the email address exists, do the following
            if ($stmt3->num_rows == 1) {
                $stmt3->close();
                header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
                exit();

            //If the email address doesn't exist, do the following
            } else {

                //Update account
                $stmt4 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
                $stmt4->bind_param('sssssssssssssi', $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $session_userid);
                $stmt4->execute();
                $stmt4->close();

                //Update account
                $stmt5 = $mysqli->prepare("UPDATE user_signin SET email=?, updated_on=? WHERE userid = ?");
                $stmt5->bind_param('ssi', $email, $updated_on, $session_userid);
                $stmt5->execute();
                $stmt5->close();

                //Create email

                //email subject
                $subject = 'Account updated successfully';

                //email message
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

                //email headers
                $headers  = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
                $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

                // Send the email
                mail($email, $subject, $message, $headers);

	        }
	    }
	}
}

//ChangePassword function
function ChangePassword() {

    //Global variables
	global $mysqli;
	global $session_userid;
	global $updated_on;

    //Gather data posted and assign variables
    $old_password = filter_input(INPUT_POST, 'change_password_old_password', FILTER_SANITIZE_STRING);
	$new_password = filter_input(INPUT_POST, 'change_password_password', FILTER_SANITIZE_STRING);

    //Get password
    $stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_password);
    $stmt1->fetch();

    //If the old password entered and the database password match, do the following
    if (password_verify($old_password, $db_password)) {
        //If the new password entered and the database password match, do the following
        if (password_verify($new_password, $db_password)) {
            $stmt1->close();
            header('HTTP/1.0 550 The new password you entered is your current password. Please enter a new password.');
            exit();

        //If the new password entered and the database password do not match, do the following
        } else {

            //hash the password
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            //Update account
            $stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
            $stmt2->bind_param('ssi', $password_hash, $updated_on, $session_userid);
            $stmt2->execute();
            $stmt2->close();

            //Get user details
            $stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ?");
            $stmt3->bind_param('i', $session_userid);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($email, $firstname);
            $stmt3->fetch();

            //Create email

            //email subject
            $subject = 'Password changed successfully';

            //email message
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

            //email headers
            $headers  = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            //Send the email
            mail($email, $subject, $message, $headers);

            $stmt1->close();
        }

    //If the old password entered and the database password do not match, do the following
    } else {
        $stmt1->close();
        header('HTTP/1.0 550 The old password you entered is incorrect.');
        exit();
    }
}

//PaypalPaymentSuccess function
function FeesPaypalPaymentSuccess() {

    //Global variables
	global $mysqli;
	global $updated_on;
	global $completed_on;

    //Get data from Paypal IPN
    $invoiceid = $_POST["invoice"];
	$transactionid  = $_POST["txn_id"];
	$payment_status = $_POST["payment_status"];
    $payment_status = strtolower($payment_status);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

	$product_name = $_POST["item_name1"];
	$product_amount = $_POST["mc_gross"];

    //Get userid using the invoiceid
	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoiceid = ? LIMIT 1");
	$stmt1->bind_param('i', $invoiceid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

    //Get user details and isHalf
	$stmt2 = $mysqli->prepare("SELECT s.email, d.firstname, d.surname, f.isHalf FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid LEFT JOIN user_fee f ON s.userid=f.userid WHERE s.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($email, $firstname, $surname, $isHalf);
	$stmt2->fetch();
	$stmt2->close();

    //If product name is 'Full fees', do the following
	if ($product_name == 'Full fees') {

        //Set values
        $fee_amount = 0.00;
        $updated_on = date("Y-m-d G:i:s");

        //Update fees
        $stmt3 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
        $stmt3->bind_param('isi', $fee_amount, $updated_on, $userid);
        $stmt3->execute();
        $stmt3->close();

    //If product name is not 'Full fees', do the following
	} else {

        //If product name is 'Half fees' and isHalf is '0', do the following
        if ($product_name == 'Half fees' AND $isHalf == '0') {

            //Set value
            $isHalf = 1;

            //Update fees
            $stmt4 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, isHalf=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt4->bind_param('iisi', $product_amount, $isHalf, $updated_on, $userid);
            $stmt4->execute();
            $stmt4->close();

        //If product name is 'Half fees' and isHalf is '1', do the following
        } elseif ($product_name == 'Half fees' AND $isHalf == '1') {

            //Set values
            $fee_amount = 0.00;
            $updated_on = date("Y-m-d G:i:s");

            //Update fees
            $stmt5 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt5->bind_param('isi', $fee_amount, $updated_on, $userid);
            $stmt5->execute();
            $stmt5->close();

	    }
    }

    //Update PayPal log
	$stmt6 = $mysqli->prepare("UPDATE paypal_log SET transactionid=?, payment_status=?, updated_on=?, completed_on=? WHERE invoiceid =?");
	$stmt6->bind_param('ssssi', $transactionid, $payment_status, $updated_on, $completed_on, $invoiceid);
	$stmt6->execute();
	$stmt6->close();

    //Create email

	//email subject
	$subject = 'Payment confirmation';

	//email message
	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent payment! Below, you can find the payment summary:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Invoice ID:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $invoiceid</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Transaction ID:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $transactionid</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $product_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Amount paid (&pound;):</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> &pound;$product_amount</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment time and date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $payment_date</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Payment status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $payment_status1</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

	//email headers
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

	//Send the email
	mail($email, $subject, $message, $headers);
}

//PaypalPaymentCancel function
function PaypalPaymentCancel() {

    //Global variables
	global $mysqli;
	global $session_userid;
	global $updated_on;
	global $cancelled_on;

    //Update PayPal log
	$payment_status = 'cancelled';

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status = ?, updated_on=?, cancelled_on=? WHERE userid = ? ORDER BY paymentid DESC LIMIT 1");
	$stmt5->bind_param('sssi', $payment_status, $updated_on, $cancelled_on, $session_userid);
	$stmt5->execute();
	$stmt5->close();
}

//DeleteAccount function
function DeleteAccount() {

    //Global variable
	global $mysqli;

    //Gather data posted and assign variables
    $accountToDelete = filter_input(INPUT_POST, 'accountToDelete', FILTER_SANITIZE_STRING);

    //Delete sent messages
    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE message_from = ?");
    $stmt1->bind_param('i', $accountToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete received messages
    $stmt2 = $mysqli->prepare("DELETE FROM user_message_received WHERE message_to = ?");
    $stmt2->bind_param('i', $accountToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Delete sent feedback
    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedback_from = ?");
    $stmt3->bind_param('i', $accountToDelete);
    $stmt3->execute();
    $stmt3->close();

    //Delete user from module look-up table
    $stmt4 = $mysqli->prepare("DELETE FROM user_module WHERE userid = ?");
    $stmt4->bind_param('i', $accountToDelete);
    $stmt4->execute();
    $stmt4->close();

    //Delete user from lecture look-up table
    $stmt5 = $mysqli->prepare("DELETE FROM user_lecture WHERE userid = ?");
    $stmt5->bind_param('i', $accountToDelete);
    $stmt5->execute();
    $stmt5->close();

    //Delete user from tutorial look-up table
    $stmt6 = $mysqli->prepare("DELETE FROM user_tutorial WHERE userid = ?");
    $stmt6->bind_param('i', $accountToDelete);
    $stmt6->execute();
    $stmt6->close();

    //Delete user from exam look-up table
    $stmt7 = $mysqli->prepare("DELETE FROM user_exam WHERE userid = ?");
    $stmt7->bind_param('i', $accountToDelete);
    $stmt7->execute();
    $stmt7->close();

    //Delete user from result look-up table
    $stmt8 = $mysqli->prepare("DELETE FROM user_result WHERE userid = ?");
    $stmt8->bind_param('i', $accountToDelete);
    $stmt8->execute();
    $stmt8->close();

    //Delete user from reserved books look-up table
    $stmt9 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE userid = ?");
    $stmt9->bind_param('i', $accountToDelete);
    $stmt9->execute();
    $stmt9->close();

    //Delete user from booked events look-up table
    $stmt10 = $mysqli->prepare("DELETE FROM system_event_booked WHERE userid = ?");
    $stmt10->bind_param('i', $accountToDelete);
    $stmt10->execute();
    $stmt10->close();

    //Delete account
    $stmt11 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
    $stmt11->bind_param('i', $accountToDelete);
    $stmt11->execute();
    $stmt11->close();

    //Unset session
	session_unset();

    //Destroy session
	session_destroy();

    //SignOut
    SignOut();
}

//////////////////////////////////////////////////////////////////////////

//Admin account functions
//CreateAnAccount function
function CreateAnAccount() {

    //Global variables
    global $mysqli;
    global $created_on;

    //Gather data posted and assign variables
    $account_type = filter_input(INPUT_POST, 'create_account_account_type', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'create_account_firstname', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'create_account_surname', FILTER_SANITIZE_STRING);
	$gender = filter_input(INPUT_POST, 'create_account_gender', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'create_account_email', FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'create_account_password', FILTER_SANITIZE_STRING);
    $fee_amount = filter_input(INPUT_POST, 'create_account_fee_amount', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'create_account_studentno', FILTER_SANITIZE_STRING);
	$degree = filter_input(INPUT_POST, 'create_account_degree', FILTER_SANITIZE_STRING);
    $nationality = filter_input(INPUT_POST, 'create_account_nationality', FILTER_SANITIZE_STRING);
    $dateofbirth = filter_input(INPUT_POST, 'create_account_dateofbirth', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'create_account_phonenumber', FILTER_SANITIZE_STRING);
    $address1 = filter_input(INPUT_POST, 'create_account_address1', FILTER_SANITIZE_STRING);
    $address2 = filter_input(INPUT_POST, 'create_account_address2', FILTER_SANITIZE_STRING);
    $town = filter_input(INPUT_POST, 'create_account_town', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'create_account_city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'create_account_country', FILTER_SANITIZE_STRING);
    $postcode = filter_input(INPUT_POST, 'create_account_postcode', FILTER_SANITIZE_STRING);

    //Check if email address is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    } else {

        //Check if studentno exists
        $stmt1 = $mysqli->prepare("SELECT userid FROM user_detail WHERE studentno = ? AND NOT studentno = '0' LIMIT 1");
        $stmt1->bind_param('i', $studentno);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($userid);
        $stmt1->fetch();

        //If studentno exist, do the following
        if ($stmt1->num_rows == 1) {
            $stmt1->close();
            header('HTTP/1.0 550 An account with the student number entered already exists.');
            exit();
        }

        //Check if email address exists
        $stmt2 = $mysqli->prepare("SELECT userid FROM user_signin WHERE email = ? LIMIT 1");
        $stmt2->bind_param('s', $email);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($userid);
        $stmt2->fetch();

        //If the email address exists, do the following
        if ($stmt2->num_rows == 1) {
            $stmt2->close();
            header('HTTP/1.0 550 An account with the email address entered already exists.');
            exit();
        }

        //Get userid
        $stmt3 = $mysqli->prepare("SELECT userid FROM user_signin ORDER BY userid DESC LIMIT 1");
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($userid);
        $stmt3->fetch();

        //If studentno is empty, do the following
        if (empty($studentno)) {

            //Add one to the userid
            $studentno = $userid + 1;
        }

        //hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        //Convert to lowercase
        $account_type = strtolower($account_type);

        //Create account
        $stmt4 = $mysqli->prepare("INSERT INTO user_signin (account_type, email, password, created_on) VALUES (?, ?, ?, ?)");
        $stmt4->bind_param('ssss', $account_type, $email, $password_hash, $created_on);
        $stmt4->execute();
        $stmt4->close();

        //If dateofbirth is empty, do the following
        if ($dateofbirth == '') {

            //Set value
            $dateofbirth = NULL;

        } else {

            //Convert date to MySQL format
            $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
            $dateofbirth = $dateofbirth->format('Y-m-d');
        }

        //Convert to lowercase
        $gender = strtolower($gender);
        $nationality = strtolower($nationality);

        //Create account
        $user_status = 'active';

        $stmt5 = $mysqli->prepare("INSERT INTO user_detail (firstname, surname, gender, studentno, degree, nationality, dateofbirth, phonenumber, address1, address2, town, city, country, postcode, user_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssissssssssssss', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $user_status, $created_on);
        $stmt5->execute();
        $stmt5->close();

        //Set value
        $token = null;

        //Create token
        $stmt6 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
        $stmt6->bind_param('s', $token);
        $stmt6->execute();
        $stmt6->close();

        //If account_type is 'academic staff', do the following
        if ($account_type == 'academic staff') {

            //Set value
            $fee_amount = '0.00';
        }

        //If account_type is 'administrator', do the following
        elseif ($account_type == 'administrator') {

            //Set value
            $fee_amount = '0.00';
        }

        //Create fees
        $stmt7 = $mysqli->prepare("INSERT INTO user_fee (fee_amount, created_on) VALUES (?, ?)");
        $stmt7->bind_param('is', $fee_amount, $created_on);
        $stmt7->execute();
        $stmt7->close();
    }
}

//UpdateAnAccount function
function UpdateAnAccount() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $userid = filter_input(INPUT_POST, 'update_account_userid', FILTER_SANITIZE_STRING);
	$account_type = filter_input(INPUT_POST, 'update_account_account_type', FILTER_SANITIZE_STRING);
	$firstname = filter_input(INPUT_POST, 'update_account_firstname', FILTER_SANITIZE_STRING);
	$surname = filter_input(INPUT_POST, 'update_account_surname', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'update_account_gender', FILTER_SANITIZE_STRING);
    $studentno = filter_input(INPUT_POST, 'update_account_studentno', FILTER_SANITIZE_STRING);
    $degree = filter_input(INPUT_POST, 'update_account_degree', FILTER_SANITIZE_STRING);
    $fee_amount = filter_input(INPUT_POST, 'update_account_fee_amount', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'update_account_email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$nationality = filter_input(INPUT_POST, 'update_account_nationality', FILTER_SANITIZE_STRING);
	$dateofbirth = filter_input(INPUT_POST, 'update_account_dateofbirth', FILTER_SANITIZE_STRING);
	$phonenumber = filter_input(INPUT_POST, 'update_account_phonenumber', FILTER_SANITIZE_STRING);
	$address1 = filter_input(INPUT_POST, 'update_account_address1', FILTER_SANITIZE_STRING);
	$address2 = filter_input(INPUT_POST, 'update_account_address2', FILTER_SANITIZE_STRING);
	$town = filter_input(INPUT_POST, 'update_account_town', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'update_account_city', FILTER_SANITIZE_STRING);
	$country = filter_input(INPUT_POST, 'update_account_country', FILTER_SANITIZE_STRING);
	$postcode = filter_input(INPUT_POST, 'update_account_postcode', FILTER_SANITIZE_STRING);

    //Check if email addres is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	} else {

        //Check if email address has changed
        $stmt1 = $mysqli->prepare("SELECT email from user_signin where userid = ?");
        $stmt1->bind_param('i', $userid);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_email);
        $stmt1->fetch();

        //If email address hasn't changed, do the following
        if ($db_email == $email) {

            //Convert to lower case
            $account_type = strtolower($account_type);

            //Update account
            $stmt2 = $mysqli->prepare("UPDATE user_signin SET account_type=?, updated_on=? WHERE userid = ?");
            $stmt2->bind_param('ssi', $account_type, $updated_on, $userid);
            $stmt2->execute();
            $stmt2->close();

            //Convert to lowercase
            $gender = strtolower($gender);
            $nationality = strtolower($nationality);

            //If dateofbirth is empty, do the following
            if ($dateofbirth == '') {

                //Set value
                $dateofbirth = NULL;

            } else {

                //Convert date to MySQL format
                $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
                $dateofbirth = $dateofbirth->format('Y-m-d');
            }

            //Update accoount
            $stmt3 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
            $stmt3->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
            $stmt3->execute();
            $stmt3->close();

            //If account_type is 'academic staff', do the following
            if ($account_type == 'academic staff') {

                //Set value
                $fee_amount = '0.00';
            }

            //If account_type is 'administrator', do the following
            elseif ($account_type == 'administrator') {

                //Set value
                $fee_amount = '0.00';
            }

            //Update fees
            $stmt4 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=?");
            $stmt4->bind_param('isi', $fee_amount, $updated_on, $userid);
            $stmt4->execute();
            $stmt4->close();

	    } else {

            //Check if email address exists
            $stmt5 = $mysqli->prepare("SELECT userid from user_signin where email = ?");
            $stmt5->bind_param('s', $email);
            $stmt5->execute();
            $stmt5->store_result();
            $stmt5->bind_result($db_userid);
            $stmt5->fetch();

            //If email address exists, do the following
            if ($stmt5->num_rows == 1) {
                $stmt5->close();
                header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
                exit();

            //If email address doesn't exist, do the following
            }  else {

                //Update account
                $stmt6 = $mysqli->prepare("UPDATE user_signin SET account_type=?, email=?, updated_on=? WHERE userid = ?");
                $stmt6->bind_param('sssi', $account_type, $email, $updated_on, $userid);
                $stmt6->execute();
                $stmt6->close();

                //Update account
                $stmt7 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=? WHERE userid=?");
                $stmt7->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
                $stmt7->execute();
                $stmt7->close();

                //If account_type is 'academic staff', do the following
                if ($account_type == 'academic staff') {

                    //Set value
                    $fee_amount = '0.00';

                //If account_type is 'administrator', do the following
                } elseif ($account_type == 'administrator') {

                    //Set value
                    $fee_amount = '0.00';
                }

                //Update fees
                $stmt8 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=?");
                $stmt8->bind_param('isi', $fee_amount, $updated_on, $userid);
                $stmt8->execute();
                $stmt8->close();

	        }
	    }
	}
}

//ChangeAccountPassword function
function ChangeAccountPassword() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $userid = filter_input(INPUT_POST, 'change_account_password_userid', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'change_account_password_password', FILTER_SANITIZE_STRING);

	// Get password
	$stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_password);
	$stmt1->fetch();

    //If password entered and database password match, do the following
    if (password_verify($password, $db_password)) {
        $stmt1->close();
		header('HTTP/1.0 550 This is the account\'s current password. Please enter a new password.');
		exit();

    //If password entered and database password does not match, do the following
	} else {

        //hash password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        //Update account
        $stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
        $stmt2->bind_param('ssi', $password_hash, $updated_on, $userid);
        $stmt2->execute();
        $stmt2->close();

        $stmt1->close();
	}
}

//DeactivateUser function
function DeactivateUser() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $userToDeactivate = filter_input(INPUT_POST, 'userToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    //Deactivate account
    $user_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_detail SET user_status=?, updated_on=? WHERE userid = ?");
    $stmt1->bind_param('ssi', $user_status, $updated_on, $userToDeactivate);
    $stmt1->execute();
    $stmt1->close();
}

//ReactivateUser function
function ReactivateUser() {

    //Global variables
    global $mysqli;
    global $updated_on;

    //Gather data posted and assign variables
    $userToReactivate = filter_input(INPUT_POST, 'userToReactivate', FILTER_SANITIZE_NUMBER_INT);

    //Reactivate account
    $user_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE user_detail SET user_status=?, updated_on=? WHERE userid = ?");
    $stmt1->bind_param('ssi', $user_status, $updated_on, $userToReactivate);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteUser function
function DeleteUser() {

    //Global variables
    global $mysqli;

    //Gather data posted and assign variables
    $userToDelete = filter_input(INPUT_POST, 'userToDelete', FILTER_SANITIZE_NUMBER_INT);

    //Delete sent messages
    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE message_from = ?");
    $stmt1->bind_param('i', $userToDelete);
    $stmt1->execute();
    $stmt1->close();

    //Delete received messages
    $stmt2 = $mysqli->prepare("DELETE FROM user_message_received WHERE message_to = ?");
    $stmt2->bind_param('i', $userToDelete);
    $stmt2->execute();
    $stmt2->close();

    //Delete sent feedback
    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedback_from = ?");
    $stmt3->bind_param('i', $userToDelete);
    $stmt3->execute();
    $stmt3->close();

    //Delete user from module look-up table
    $stmt4 = $mysqli->prepare("DELETE FROM user_module WHERE userid = ?");
    $stmt4->bind_param('i', $userToDelete);
    $stmt4->execute();
    $stmt4->close();

    //Delete user from lecture look-up table
    $stmt5 = $mysqli->prepare("DELETE FROM user_lecture WHERE userid = ?");
    $stmt5->bind_param('i', $userToDelete);
    $stmt5->execute();
    $stmt5->close();

    //Delete user from tutorial look-up table
    $stmt6 = $mysqli->prepare("DELETE FROM user_tutorial WHERE userid = ?");
    $stmt6->bind_param('i', $userToDelete);
    $stmt6->execute();
    $stmt6->close();

    //Delete user from exam look-up table
    $stmt7 = $mysqli->prepare("DELETE FROM user_exam WHERE userid = ?");
    $stmt7->bind_param('i', $userToDelete);
    $stmt7->execute();
    $stmt7->close();

    //Delete user from result look-up table
    $stmt8 = $mysqli->prepare("DELETE FROM user_result WHERE userid = ?");
    $stmt8->bind_param('i', $userToDelete);
    $stmt8->execute();
    $stmt8->close();

    //Delete user from reserved books look-up table
    $stmt9 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE userid = ?");
    $stmt9->bind_param('i', $userToDelete);
    $stmt9->execute();
    $stmt9->close();

    //Delete user from booked events look-up table
    $stmt10 = $mysqli->prepare("DELETE FROM system_event_booked WHERE userid = ?");
    $stmt10->bind_param('i', $userToDelete);
    $stmt10->execute();
    $stmt10->close();

    //Delete account
    $stmt11 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
    $stmt11->bind_param('i', $userToDelete);
    $stmt11->execute();
    $stmt11->close();
}

/////////////////////////////////////////////////////////////////////////////////////////////
