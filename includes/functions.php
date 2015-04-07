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

    //Create email

	//subject
	$subject = 'New Message';

    //recipient
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

	//headers
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

	global $mysqli;
	global $session_userid;
    global $updated_on;

    //Gathering posted data and assigning variables
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    //Checking if email address is valid
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    } else {

        //Checking if email address exists in the system
        $stmt1 = $mysqli->prepare("SELECT userid, account_type, password FROM user_signin WHERE email = ? LIMIT 1");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($userid, $session_account_type, $db_password);
        $stmt1->fetch();

        //If the email address exists, do the following
        if ($stmt1->num_rows == 1) {

        //Checking if password entered matches the password in the database
        if (password_verify($password, $db_password)) {

            $isSignedIn = 1;

            //Update database to set the signed in flag to 1
            $stmt3 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt3->bind_param('isi', $isSignedIn, $updated_on, $userid);
            $stmt3->execute();
            $stmt3->close();

            //Setting sign in session variable to true
            $_SESSION['signedIn'] = true;

            //Escaping the session variable
            $session_userid = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);

            //Assigning variables to session variables
            $_SESSION['session_userid'] = $session_userid;
            $_SESSION['account_type'] = $session_account_type;

        //Otherwise, if password entered doesn't match the password in the database, do the following:
	    } else {
            $stmt1->close();
            header('HTTP/1.0 550 The password you entered is incorrect.');
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

    global $mysqli;
    global $session_userid;
    global $updated_on;

    //Setting sign in value to a variable
    $isSignedIn = 0;

    //Update database to set the signed in flag to 0
    $stmt1 = $mysqli->prepare("UPDATE user_signin SET isSignedIn=?, updated_on=? WHERE userid=? LIMIT 1");
    $stmt1->bind_param('isi', $isSignedIn, $updated_on, $session_userid);
    $stmt1->execute();
    $stmt1->close();

    //Unsetting the session
    session_unset();
    //Destroying the session
    session_destroy();
    //Redirecting to the Sign In page
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
        $gender = strtolower($gender);
        $user_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO user_detail (firstname, surname, gender, user_status, created_on) VALUES (?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssss', $firstname, $surname, $gender, $user_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

        //Creating user token
        $token = null;

        $stmt5 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
        $stmt5->bind_param('s', $token);
        $stmt5->execute();
        $stmt5->close();

        //Creating user fees
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
		$stmt2->bind_param('ssi', $token, $created_on, $userid);
		$stmt2->execute();
		$stmt2->close();

        //Creating link to be sent to the user
		$passwordlink = "<a href=https://student-portal.co.uk/password-reset/?token=$token>here</a>";

        //Getting firstname, surname using userid
        $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
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
		$headers  = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

		// Additional headers
		$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
		$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

		// Mail it
		mail($email, $subject, $message, $headers);

		$stmt1->close();
	}
	else {
		header('HTTP/1.0 550 The email address you entered is incorrect.');
        exit();
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

//ResetPassword function
function ResetPassword() {

	global $mysqli;
	global $updated_on;

	$token = $_POST["rp_token"];
	$email = filter_input(INPUT_POST, 'rp_email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'rp_password', FILTER_SANITIZE_STRING);

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

    if ($stmt1->num_rows == 0) {
        $stmt1->close();
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    } else {

        //Getting token from database
        $stmt2 = $mysqli->prepare("SELECT user_token.token, user_detail.firstname FROM user_token LEFT JOIN user_detail ON user_token.userid=user_detail.userid WHERE user_token.userid = ? LIMIT 1");
        $stmt2->bind_param('i', $userid);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($db_token, $firstname);
        $stmt2->fetch();

        //Comparing client side token with database token
        if ($token === $db_token) {

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

            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            mail($email, $subject, $message, $headers);
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

    //Getting number of lectures the student is taking
    $lecture_status = 'active';

	$stmt1 = $mysqli->prepare("SELECT l.lectureid FROM user_lecture u LEFT JOIN system_lecture l ON u.lectureid=l.lectureid WHERE u.userid=? AND l.lecture_status=? AND DATE(l.lecture_to_date) > DATE(NOW())");
	$stmt1->bind_param('is', $session_userid, $lecture_status);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($lectureid);
	$stmt1->fetch();

    $stmt2 = $mysqli->prepare("SELECT l.lectureid FROM system_lecture l WHERE l.lecture_lecturer=? AND l.lecture_status=? AND DATE(l.lecture_to_date) > DATE(NOW())");
    $stmt2->bind_param('is', $session_userid, $lecture_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($lectureid);
    $stmt2->fetch();

    $tutorial_status = 'active';

	$stmt3 = $mysqli->prepare("SELECT t.tutorialid FROM user_tutorial u LEFT JOIN system_tutorial t ON u.tutorialid=t.tutorialid WHERE u.userid=? AND t.tutorial_status=? AND DATE(t.tutorial_to_date) > DATE(NOW())");
	$stmt3->bind_param('is', $session_userid, $tutorial_status);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($tutorialid);
	$stmt3->fetch();

    $stmt4 = $mysqli->prepare("SELECT t.tutorialid FROM system_tutorial t WHERE t.tutorial_assistant=? AND t.tutorial_status=? AND DATE(t.tutorial_to_date) > DATE(NOW())");
    $stmt4->bind_param('is', $session_userid, $tutorial_status);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($tutorialid);
    $stmt4->fetch();

    $exam_status = 'active';

	$stmt5 = $mysqli->prepare("SELECT e.examid FROM user_exam u LEFT JOIN system_exam e ON u.examid=e.examid WHERE u.userid=? AND e.exam_status=?");
	$stmt5->bind_param('is', $session_userid, $exam_status);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($examid);
	$stmt5->fetch();

    $stmt6 = $mysqli->prepare("SELECT resultid FROM user_result WHERE userid=?");
    $stmt6->bind_param('i', $session_userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($resultid);
    $stmt6->fetch();

    $isReturned = 0;
    $book_status = 'active';
    $loan_status = 'ongoing';

	$stmt7 = $mysqli->prepare("SELECT l.bookid FROM system_book_loaned l LEFT JOIN system_book b ON l.bookid=b.bookid WHERE l.userid=? AND l.isReturned=? AND b.book_status=? AND l.loan_status=?");
	$stmt7->bind_param('iiss', $session_userid, $isReturned, $book_status, $loan_status);
	$stmt7->execute();
	$stmt7->store_result();
	$stmt7->bind_result($bookid);
	$stmt7->fetch();

    $isRead = 0;
    $isApproved = 0;
    $book_status = 'active';
    $request_status = 'pending';

    $stmt8 = $mysqli->prepare("SELECT r.bookid FROM system_book_requested r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.isRead = ? AND r.isApproved = ? AND b.book_status=? AND r.request_status = ?");
	$stmt8->bind_param('iiss', $isRead, $isApproved, $book_status, $request_status);
	$stmt8->execute();
	$stmt8->store_result();
	$stmt8->bind_result($bookid);
	$stmt8->fetch();

	$task_status = 'active';

	$stmt9 = $mysqli->prepare("SELECT taskid FROM user_task WHERE userid = ? AND task_status = ?");
	$stmt9->bind_param('is', $session_userid, $task_status);
	$stmt9->execute();
	$stmt9->store_result();
	$stmt9->bind_result($taskid);
	$stmt9->fetch();

    $event_status = 'active';

	$stmt10 = $mysqli->prepare("SELECT b.eventid FROM system_event_booked b LEFT JOIN system_event e ON b.eventid = e.eventid WHERE b.userid = ? AND e.event_status=? AND DATE(e.event_to) > DATE(NOW())");
	$stmt10->bind_param('is', $session_userid, $event_status);
	$stmt10->execute();
	$stmt10->store_result();
	$stmt10->bind_result($eventid);
	$stmt10->fetch();

	$isRead = '0';
	$stmt11 = $mysqli->prepare("SELECT r.messageid FROM user_message_received r WHERE r.message_to=? AND r.isRead=?");
	$stmt11->bind_param('ii', $session_userid, $isRead);
	$stmt11->execute();
	$stmt11->store_result();
	$stmt11->bind_result($messageid);
	$stmt11->fetch();

    $isRead = 0;
    $isApproved = 1;

    $stmt12 = $mysqli->prepare("SELECT DISTINCT r.feedbackid FROM user_feedback_received r LEFT JOIN user_feedback f ON r.feedbackid=f.feedbackid WHERE r.module_staff=? AND r.isRead=? AND f.isApproved=?");
    $stmt12->bind_param('iii', $session_userid, $isRead, $isApproved);
    $stmt12->execute();
    $stmt12->store_result();
    $stmt12->bind_result($feedbackid);
    $stmt12->fetch();

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

    global $mysqli;
    global $created_on;

    //Getting the data posted and assigning variables
    $module_name = filter_input(INPUT_POST, 'create_module_name', FILTER_SANITIZE_STRING);
    $module_notes = filter_input(INPUT_POST, 'create_module_notes', FILTER_SANITIZE_STRING);
    $module_url = filter_input(INPUT_POST, 'create_module_url', FILTER_SANITIZE_STRING);

    // Check if there is an existing module name
    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE module_name = ? LIMIT 1");
    $stmt1->bind_param('s', $module_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_moduleid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A module with the name entered already exists.');
        exit();
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

    global $mysqli;
    global $updated_on;

    //Getting the data posted and assigning variables
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

        $stmt3 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE module_name = ?");
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
            $stmt4 = $mysqli->prepare("UPDATE system_module SET module_name=?, module_notes=?, module_url=?, updated_on=? WHERE moduleid=?");
            $stmt4->bind_param('ssssi', $module_name, $module_notes, $module_url, $updated_on, $moduleid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateModule function
function DeactivateModule() {

    global $mysqli;
    global $updated_on;

    $moduleToDeactivate = filter_input(INPUT_POST, 'moduleToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $module_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_module SET module_status=?, updated_on=? WHERE moduleid=?");
    $stmt1->bind_param('ssi', $module_status, $updated_on, $moduleToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    $lecture_status = 'inactive';

    $stmt2 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE moduleid=?");
    $stmt2->bind_param('ssi', $lecture_status, $updated_on, $moduleToDeactivate);
    $stmt2->execute();
    $stmt2->close();

    $tutorial_status = 'inactive';

    $stmt3 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE moduleid=?");
    $stmt3->bind_param('ssi', $tutorial_status, $updated_on, $moduleToDeactivate);
    $stmt3->execute();
    $stmt3->close();

    $exam_status = 'inactive';

    $stmt4 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE moduleid=?");
    $stmt4->bind_param('ssi', $exam_status, $updated_on, $moduleToDeactivate);
    $stmt4->execute();
    $stmt4->close();

    $result_status = 'inactive';

    $stmt5 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE moduleid=?");
    $stmt5->bind_param('ssi', $result_status, $updated_on, $moduleToDeactivate);
    $stmt5->execute();
    $stmt5->close();

    AdminTimetableUpdate($isUpdate = 1);
}

//ReactivateModule function
function ReactivateModule() {

    global $mysqli;
    global $updated_on;

    $moduleToReactivate = filter_input(INPUT_POST, 'moduleToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $module_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_module SET module_status=?, updated_on=? WHERE moduleid=?");
    $stmt1->bind_param('ssi', $module_status, $updated_on, $moduleToReactivate);
    $stmt1->execute();
    $stmt1->close();

    $lecture_status = 'active';

    $stmt2 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE moduleid=?");
    $stmt2->bind_param('ssi', $lecture_status, $updated_on, $moduleToReactivate);
    $stmt2->execute();
    $stmt2->close();

    $tutorial_status = 'active';

    $stmt3 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE moduleid=?");
    $stmt3->bind_param('ssi', $tutorial_status, $updated_on, $moduleToReactivate);
    $stmt3->execute();
    $stmt3->close();

    $exam_status = 'active';

    $stmt4 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE moduleid=?");
    $stmt4->bind_param('ssi', $exam_status, $updated_on, $moduleToReactivate);
    $stmt4->execute();
    $stmt4->close();

    $result_status = 'active';

    $stmt5 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE moduleid=?");
    $stmt5->bind_param('ssi', $result_status, $updated_on, $moduleToReactivate);
    $stmt5->execute();
    $stmt5->close();

    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteModule function
function DeleteModule() {

    global $mysqli;

    $moduleToDelete = filter_input(INPUT_POST, 'moduleToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE moduleid=?");
    $stmt1->bind_param('i', $moduleToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE moduleid=?");
    $stmt2->bind_param('i', $moduleToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback WHERE moduleid=?");
    $stmt3->bind_param('i', $moduleToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM user_result WHERE moduleid=?");
    $stmt4->bind_param('i', $moduleToDelete);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM system_exam WHERE moduleid=?");
    $stmt5->bind_param('i', $moduleToDelete);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("DELETE FROM system_tutorial WHERE moduleid=?");
    $stmt6->bind_param('i', $moduleToDelete);
    $stmt6->execute();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("DELETE FROM system_lecture WHERE moduleid=?");
    $stmt7->bind_param('i', $moduleToDelete);
    $stmt7->execute();
    $stmt7->close();

    $stmt8 = $mysqli->prepare("DELETE FROM user_module WHERE moduleid=?");
    $stmt8->bind_param('i', $moduleToDelete);
    $stmt8->execute();
    $stmt8->close();

    $stmt9 = $mysqli->prepare("DELETE FROM system_module WHERE moduleid=?");
    $stmt9->bind_param('i', $moduleToDelete);
    $stmt9->execute();
    $stmt9->close();

    AdminTimetableUpdate($isUpdate = 1);
}

//AllocateModule function
function AllocateModule() {

    global $mysqli;

    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $moduleToAllocate = filter_input(INPUT_POST, 'moduleToAllocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("INSERT INTO user_module (userid, moduleid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $moduleToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateModule function
function DeallocateModule() {

    global $mysqli;

    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $moduleToDeallocate = filter_input(INPUT_POST, 'moduleToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_module WHERE userid=? AND moduleid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $moduleToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

//CreateLecture function
function CreateLecture() {

    global $mysqli;
    global $created_on;

    //Getting the data posted and assigning variables
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

    // Check if there is an existing lecture name
    $stmt1 = $mysqli->prepare("SELECT lectureid FROM system_lecture WHERE lecture_name = ? LIMIT 1");
    $stmt1->bind_param('s', $lecture_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_lectureid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A lecture with the name entered already exists.');
        exit();
    } else {

        //Create the lecture record
        $lecture_from_date = DateTime::createFromFormat('d/m/Y', $lecture_from_date);
        $lecture_from_date = $lecture_from_date->format('Y-m-d');
        $lecture_to_date = DateTime::createFromFormat('d/m/Y', $lecture_to_date);
        $lecture_to_date = $lecture_to_date->format('Y-m-d');
        $lecture_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_lecture (moduleid, lecture_name, lecture_lecturer, lecture_notes, lecture_day, lecture_from_time, lecture_to_time, lecture_from_date, lecture_to_date, lecture_location, lecture_capacity, lecture_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('isisssssssiss', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $lecture_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }
}

//UpdateLecture function
function UpdateLecture() {

    global $mysqli;
    global $updated_on;

    //Getting the data posted and assigning variables
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
        $stmt3 = $mysqli->prepare("SELECT lectureid FROM system_lecture WHERE lecture_name = ?");
        $stmt3->bind_param('s', $lecture_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_lectureid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A lecture with the name entered already exists.');
            exit();
        } else {
            $stmt4 = $mysqli->prepare("UPDATE system_lecture SET moduleid=?, lecture_name=?, lecture_lecturer=?, lecture_notes=?, lecture_day=?, lecture_from_time=?, lecture_to_time=?, lecture_from_date=?, lecture_to_date=?, lecture_location=?, lecture_capacity=?, updated_on=? WHERE lectureid=?");
            $stmt4->bind_param('isisssssssisi', $moduleid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $updated_on, $lectureid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateLecture function
function DeactivateLecture() {

    global $mysqli;
    global $updated_on;

    $lectureToDeactivate = filter_input(INPUT_POST, 'lectureToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $lecture_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE lectureid=?");
    $stmt1->bind_param('ssi', $lecture_status, $updated_on, $lectureToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminTimetableUpdate($isUpdate = 1);
}

//ReactivateLecture function
function ReactivateLecture() {

    global $mysqli;
    global $updated_on;

    $lectureToReactivate = filter_input(INPUT_POST, 'lectureToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_lecture WHERE lectureid = ?");
    $stmt1->bind_param('i', $lectureToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    if ($stmt2->num_rows > 0) {

        $lecture_status = 'active';

        $stmt3 = $mysqli->prepare("UPDATE system_lecture SET lecture_status=?, updated_on=? WHERE lectureid=?");
        $stmt3->bind_param('ssi', $lecture_status, $updated_on, $lectureToReactivate);
        $stmt3->execute();
        $stmt3->close();

    } else {
        $stmt2->close();
        $error_msg = 'You cannot reactivate this lecture because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this lecture.';

        $array = array(
            'error_msg'=>$error_msg
        );

        echo json_encode($array);

        exit();
    }

    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteLecture function
function DeleteLecture() {

    global $mysqli;

    $lectureToDelete = filter_input(INPUT_POST, 'lectureToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM system_lecture WHERE lectureid=?");
    $stmt1->bind_param('i', $lectureToDelete);
    $stmt1->execute();
    $stmt1->close();

    $lectureid = '';

    $stmt2 = $mysqli->prepare("DELETE FROM user_lecture WHERE lectureid=?");
    $stmt2->bind_param('ii', $lectureid, $lectureToDelete);
    $stmt2->execute();
    $stmt2->close();

    AdminTimetableUpdate($isUpdate = 1);
}

//AllocateLecture function
function AllocateLecture() {

    global $mysqli;

    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $lectureToAllocate = filter_input(INPUT_POST, 'lectureToAllocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("INSERT INTO user_lecture (userid, lectureid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $lectureToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateLecture function
function DeallocateLecture() {

    global $mysqli;

    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $lectureToDeallocate = filter_input(INPUT_POST, 'lectureToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_lecture WHERE userid=? AND lectureid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $lectureToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

//CreateTutorial function
function CreateTutorial() {

    global $mysqli;
    global $created_on;

    //Getting the data posted and assigning variables
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

    //Check if there is an existing tutorial name
    $stmt1 = $mysqli->prepare("SELECT tutorialid FROM system_tutorial WHERE tutorial_name = ? LIMIT 1");
    $stmt1->bind_param('s', $tutorial_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_tutorialid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 A tutorial with the name entered already exists.');
        exit();
    } else {

        //Create the tutorial record
        $tutorial_from_date = DateTime::createFromFormat('d/m/Y', $tutorial_from_date);
        $tutorial_from_date = $tutorial_from_date->format('Y-m-d');
        $tutorial_to_date = DateTime::createFromFormat('d/m/Y', $tutorial_to_date);
        $tutorial_to_date = $tutorial_to_date->format('Y-m-d');
        $tutorial_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO system_tutorial (moduleid, tutorial_name, tutorial_assistant, tutorial_notes, tutorial_day, tutorial_from_time, tutorial_to_time, tutorial_from_date, tutorial_to_date, tutorial_location, tutorial_capacity, tutorial_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('isisssssssiss', $moduleid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $tutorial_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }
}

//UpdateTutorial function
function UpdateTutorial() {

    global $mysqli;
    global $updated_on;

    //Getting the data posted and assigning variables
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
        $stmt3 = $mysqli->prepare("SELECT tutorialid FROM system_tutorial WHERE tutorial_name = ?");
        $stmt3->bind_param('s', $tutorial_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_tutorialid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A tutorial with the name entered already exists.');
            exit();
        } else {
            $stmt4 = $mysqli->prepare("UPDATE system_tutorial SET moduleid=?, tutorial_name=?, tutorial_assistant=?, tutorial_notes=?, tutorial_day=?, tutorial_from_time=?, tutorial_to_time=?, tutorial_from_date=?, tutorial_to_date=?, tutorial_location=?, tutorial_capacity=?, updated_on=? WHERE tutorialid=?");
            $stmt4->bind_param('isisssssssisi', $moduleid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $updated_on, $tutorialid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateTutorial function
function DeactivateTutorial() {

    global $mysqli;
    global $updated_on;

    $tutorialToDeactivate = filter_input(INPUT_POST, 'tutorialToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $tutorial_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE tutorialid=?");
    $stmt1->bind_param('ssi', $tutorial_status, $updated_on, $tutorialToDeactivate);
    $stmt1->execute();
    $stmt1->close();


}

//ReactivateTutorial function
function ReactivateTutorial() {

    global $mysqli;
    global $updated_on;

    $tutorialToReactivate = filter_input(INPUT_POST, 'tutorialToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_tutorial WHERE tutorialid = ?");
    $stmt1->bind_param('i', $tutorialToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    if ($stmt2->num_rows > 0) {

        $tutorial_status = 'active';

        $stmt1 = $mysqli->prepare("UPDATE system_tutorial SET tutorial_status=?, updated_on=? WHERE tutorialid=?");
        $stmt1->bind_param('ssi', $tutorial_status, $updated_on, $tutorialToReactivate);
        $stmt1->execute();
        $stmt1->close();

    } else {
        $stmt2->close();
        $error_msg = 'You cannot reactivate this tutorial because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this tutorial.';

        $array = array(
            'error_msg'=>$error_msg
        );

        echo json_encode($array);

        exit();
    }

    AdminTimetableUpdate($isUpdate = 1);
}

//DeleteTutorial function
function DeleteTutorial() {

    global $mysqli;

    $tutorialToDelete = filter_input(INPUT_POST, 'tutorialToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM system_tutorial WHERE tutorialid=?");
    $stmt1->bind_param('i', $tutorialToDelete);
    $stmt1->execute();
    $stmt1->close();

    $tutorialid = '';

    $stmt2 = $mysqli->prepare("DELETE FROM user_tutorial WHERE tutorialid=?");
    $stmt2->bind_param('ii', $tutorialid, $tutorialToDelete);
    $stmt2->execute();
    $stmt2->close();

    AdminTimetableUpdate($isUpdate = 1);

}

//AllocateTutorial function
function AllocateTutorial() {

    global $mysqli;

    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $tutorialToAllocate = filter_input(INPUT_POST, 'tutorialToAllocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("INSERT INTO user_tutorial (userid, tutorialid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $tutorialToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateTutorial function
function DeallocateTutorial() {

    global $mysqli;

    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $tutorialToDeallocate = filter_input(INPUT_POST, 'tutorialToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_tutorial WHERE userid=? AND tutorialid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $tutorialToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

function AdminTimetableUpdate($isUpdate = 0) {

    global $mysqli;
    global $active_module;
    global $active_lecture;
    global $active_tutorial;
    global $inactive_module;
    global $inactive_lecture;
    global $inactive_tutorial;

    $module_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_module m WHERE m.module_status=?");
    $stmt1->bind_param('s', $module_status);
    $stmt1->execute();
    $stmt1->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

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
            <a href="/admin/update-module?id='.$moduleid.'" class="btn btn-primary btn-sm">Update</a>
            <a id="deactivate-'.$moduleid.'" class="btn btn-primary btn-sm btn-deactivate-module">Deactivate</a>
            <a id="delete-'.$moduleid.'" class="btn btn-primary btn-sm btn-deactivate-module">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-module-'.$moduleid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$module_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$moduleid.'" class="btn btn-success btn-lg btn-delete-module">Confirm</a>
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

    $module_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_module m WHERE m.module_status=?");
    $stmt2->bind_param('s', $module_status);
    $stmt2->execute();
    $stmt2->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

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
            <a id="reactivate-'.$moduleid.'" class="btn btn-primary btn-sm btn-reactivate-module">Reactivate</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-module-'.$moduleid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$module_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$moduleid.'" class="btn btn-success btn-lg btn-delete-module">Confirm</a>
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

            <div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a href="/admin/update-timetable?id='.$lectureid.'" class="btn btn-primary btn-sm">Update</a>
            <a id="deactivate-'.$lectureid.'" class="btn btn-primary btn-sm btn-deactivate-lecture">Deactivate</a>
            <a href="#delete-lecture-'.$lectureid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-lecture-'.$lectureid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$lecture_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$lectureid.'" class="btn btn-success btn-lg btn-delete-lecture">Confirm</a>
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

            <div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a href="/admin/update-timetable?id='.$lectureid.'" class="btn btn-primary btn-sm" >Update</a>
            <a id="reactivate-'.$lectureid.'" class="btn btn-primary btn-sm btn-reactivate-lecture">Reactivate</a>
            <a href="#delete-lecture-'.$lectureid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-lecture-'.$lectureid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$lecture_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>
            <a id="delete-'.$lectureid.'" class="btn btn-success btn-lg btn-delete-lecture">Confirm</a>
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

            <div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a href="/admin/update-timetable?id='.$tutorialid.'" class="btn btn-primary btn-sm">Update</a>
            <a id="deactivate-'.$tutorialid.'" class="btn btn-primary btn-sm btn-deactivate-tutorial">Deactivate</a>
            <a href="#delete-tutorial-'.$tutorialid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-tutorial-'.$tutorialid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$tutorial_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$tutorialid.'" class="btn btn-success btn-lg btn-delete-tutorial">Confirm</a>
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

    $tutorial_status = 'active';

    $stmt6 = $mysqli->prepare("SELECT t.tutorialid, t.tutorial_name, t.tutorial_assistant, t.tutorial_notes, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t WHERE t.tutorial_status=?");
    $stmt6->bind_param('s', $tutorial_status);
    $stmt6->execute();
    $stmt6->bind_result($lectureid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_location, $tutorial_capacity);
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

            <div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a id="reactivate-'.$tutorialid.'" class="btn btn-primary btn-sm btn-reactivate-tutorial">Reactivate</a>
            <a href="#delete-tutorial-'.$tutorialid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-tutorial-'.$tutorialid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$tutorial_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$tutorialid.'" class="btn btn-success btn-lg btn-delete-tutorial">Confirm</a>
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

    if ($isUpdate === 1) {

        $array = array(
            'active_module'=>$active_module,
            'active_lecture'=>$active_lecture,
            'active_tutorial'=>$active_tutorial,
            'inactive_module'=>$inactive_module,
            'inactive_lecture'=>$inactive_lecture,
            'inactive_tutorial'=>$inactive_tutorial
        );

        echo json_encode($array);
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Exams
//CreateExam function
function CreateExam() {

    global $mysqli;
    global $created_on;

    //Exam
    $moduleid = filter_input(INPUT_POST, 'create_exam_moduleid', FILTER_SANITIZE_STRING);
    $exam_name = filter_input(INPUT_POST, 'create_exam_name', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'create_exam_notes', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'create_exam_date', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'create_exam_time', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'create_exam_location', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'create_exam_capacity', FILTER_SANITIZE_STRING);

    //Check existing exam name
    $stmt1 = $mysqli->prepare("SELECT examid FROM system_exam WHERE exam_name = ? LIMIT 1");
    $stmt1->bind_param('s', $exam_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_examid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 An exam with the name entered already exists.');
        exit();
    }

    //Create the exam record
    $exam_date = DateTime::createFromFormat('d/m/Y', $exam_date);
    $exam_date = $exam_date->format('Y-m-d');
    $exam_status = 'active';

    $stmt2 = $mysqli->prepare("INSERT INTO system_exam (moduleid, exam_name, exam_notes, exam_date, exam_time, exam_location, exam_capacity, exam_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param('issssssss', $moduleid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $exam_status, $created_on);
    $stmt2->execute();
    $stmt2->close();
}

//UpdateExam function
function UpdateExam() {

    global $mysqli;
    global $updated_on;

    //Exam
    $moduleid = filter_input(INPUT_POST, 'update_exam_moduleid', FILTER_SANITIZE_STRING);
    $examid = filter_input(INPUT_POST, 'update_examid', FILTER_SANITIZE_STRING);
    $exam_name = filter_input(INPUT_POST, 'update_exam_name', FILTER_SANITIZE_STRING);
    $exam_notes = filter_input(INPUT_POST, 'update_exam_notes', FILTER_SANITIZE_STRING);
    $exam_date = filter_input(INPUT_POST, 'update_exam_date', FILTER_SANITIZE_STRING);
    $exam_time = filter_input(INPUT_POST, 'update_exam_time', FILTER_SANITIZE_STRING);
    $exam_location = filter_input(INPUT_POST, 'update_exam_location', FILTER_SANITIZE_STRING);
    $exam_capacity = filter_input(INPUT_POST, 'update_exam_capacity', FILTER_SANITIZE_STRING);

    //Exam
    $stmt1 = $mysqli->prepare("SELECT exam_name FROM system_exam WHERE examid = ?");
    $stmt1->bind_param('i', $examid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_exam_name);
    $stmt1->fetch();

    $exam_date = DateTime::createFromFormat('d/m/Y', $exam_date);
    $exam_date = $exam_date->format('Y-m-d');

    if ($db_exam_name === $exam_name) {
        $stmt3 = $mysqli->prepare("UPDATE system_exam SET moduleid=?, exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
        $stmt3->bind_param('issssssi', $moduleid, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
        $stmt3->execute();
        $stmt3->close();
    } else {
        $stmt4 = $mysqli->prepare("SELECT examid FROM system_exam WHERE exam_name = ?");
        $stmt4->bind_param('s', $exam_name);
        $stmt4->execute();
        $stmt4->store_result();
        $stmt4->bind_result($db_examid);
        $stmt4->fetch();

        if ($stmt4->num_rows == 1) {
            $stmt4->close();
            header('HTTP/1.0 550 An exam with the name entered already exists.');
            exit();
        } else {
            $stmt5 = $mysqli->prepare("UPDATE system_exam SET moduleid=?, exam_name=?, exam_notes=?, exam_date=?, exam_time=?, exam_location=?, exam_capacity=?, updated_on=? WHERE examid=?");
            $stmt5->bind_param('isssssssi', $moduleid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity, $updated_on, $examid);
            $stmt5->execute();
            $stmt5->close();
        }
    }

}

//DeactivateExam function
function DeactivateExam() {

    global $mysqli;
    global $updated_on;

    $examToDeactivate = filter_input(INPUT_POST, 'examToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $exam_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE examid=?");
    $stmt1->bind_param('ssi', $exam_status, $updated_on, $examToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminExamUpdate($isUpdate = 1);
}

//ReactivateExam function
function ReactivateExam() {

    global $mysqli;
    global $updated_on;

    $examToReactivate = filter_input(INPUT_POST, 'examToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT moduleid FROM system_exam WHERE examid = ?");
    $stmt1->bind_param('i', $examToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    if ($stmt2->num_rows > 0) {

        $exam_status = 'active';

        $stmt3 = $mysqli->prepare("UPDATE system_exam SET exam_status=?, updated_on=? WHERE examid=?");
        $stmt3->bind_param('ssi', $exam_status, $updated_on, $examToReactivate);
        $stmt3->execute();
        $stmt3->close();

    } else {

        $stmt2->close();
        $error_msg = 'You cannot reactivate this exam because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this exam.';

        $array = array(
            'error_msg'=>$error_msg
        );

        echo json_encode($array);

        exit();
    }

    AdminExamUpdate($isUpdate = 1);
}

//DeleteTimetable function
function DeleteExam() {

    global $mysqli;

    $examToDelete = filter_input(INPUT_POST, 'examToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM system_exam WHERE examid=?");
    $stmt1->bind_param('i', $examToDelete);
    $stmt1->execute();
    $stmt1->close();

    $examid = '';

    $stmt2 = $mysqli->prepare("DELETE FROM user_exam WHERE examid=?");
    $stmt2->bind_param('ii', $examid, $examToDelete);
    $stmt2->execute();
    $stmt2->close();

    AdminExamUpdate($isUpdate = 1);
}

//AllocateExam function
function AllocateExam() {

    global $mysqli;

    $userToAllocate = filter_input(INPUT_POST, 'userToAllocate', FILTER_SANITIZE_NUMBER_INT);
    $examToAllocate = filter_input(INPUT_POST, 'examToAllocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("INSERT INTO user_exam (userid, examid) VALUES (?, ?)");
    $stmt1->bind_param('ii', $userToAllocate, $examToAllocate);
    $stmt1->execute();
    $stmt1->close();
}

//DeallocateExam function
function DeallocateExam() {

    global $mysqli;

    $userToDeallocate = filter_input(INPUT_POST, 'userToDeallocate', FILTER_SANITIZE_NUMBER_INT);
    $examToDeallocate = filter_input(INPUT_POST, 'examToDeallocate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_exam WHERE userid=? AND examid=?");
    $stmt1->bind_param('ii', $userToDeallocate, $examToDeallocate);
    $stmt1->execute();
    $stmt1->close();
}

function AdminExamUpdate($isUpdate = 0) {

    global $mysqli;
    global $active_exam;
    global $inactive_exam;

    $exam_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT e.examid, e.exam_name, e.exam_notes, DATE_FORMAT(e.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(e.exam_time,'%H:%i') as exam_time, e.exam_location, e.exam_capacity FROM system_exam e WHERE e.exam_status=?");
    $stmt1->bind_param('s', $exam_status);
    $stmt1->execute();
    $stmt1->bind_result($examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

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

            <div id="view-exam-'.$examid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</span></a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-exam-'.$examid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$exam_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$examid.'" class="btn btn-success btn-lg btn-delete-exam">Confirm</a>
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

    $exam_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT e.examid, e.exam_name, e.exam_notes, DATE_FORMAT(e.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(e.exam_time,'%H:%i') as exam_time, e.exam_location, e.exam_capacity FROM system_exam e WHERE e.exam_status=?");
    $stmt2->bind_param('s', $exam_status);
    $stmt2->execute();
    $stmt2->bind_result($examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

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

            <div id="view-exam-'.$examid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</span></a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-exam-'.$examid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$exam_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$examid.'" class="btn btn-success btn-lg btn-delete-exam">Confirm</a>
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

    if ($isUpdate === 1) {

        $array = array(
            'active_exam'=>$active_exam,
            'inactive_exam'=>$inactive_exam
        );

        echo json_encode($array);
    }

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

    $result_status = 'active';

    $stmt1 = $mysqli->prepare("INSERT INTO user_result (userid, moduleid, result_coursework_mark, result_exam_mark, result_overall_mark, result_notes, result_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iissssss', $result_userid, $result_moduleid, $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $result_status, $created_on);
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

    $stmt1 = $mysqli->prepare("UPDATE user_result SET result_coursework_mark=?, result_exam_mark=?, result_overall_mark=?, result_notes=?, updated_on=? WHERE resultid=?");
    $stmt1->bind_param('sssssi', $result_coursework_mark, $result_exam_mark, $result_overall_mark, $result_notes, $updated_on, $result_resultid);
    $stmt1->execute();
    $stmt1->close();
}

//DeactivateResult function
function DeactivateResult() {

    global $mysqli;
    global $updated_on;

    $resultToDeactivate = filter_input(INPUT_POST, 'resultToDeactivate', FILTER_SANITIZE_STRING);
    $userToCreateResult = filter_input(INPUT_POST, 'userToCreateResult', FILTER_SANITIZE_STRING);

    $result_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE resultid=?");
    $stmt1->bind_param('ssi', $result_status, $updated_on, $resultToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminResultUpdate($isUpdate = 1);
}

//ReactivateResult function
function ReactivateResult() {

    global $mysqli;
    global $updated_on;

    $resultToReactivate = filter_input(INPUT_POST, 'resultToReactivate', FILTER_SANITIZE_STRING);
    $userToCreateResult = filter_input(INPUT_POST, 'userToCreateResult', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("SELECT moduleid FROM user_result WHERE resultid = ?");
    $stmt1->bind_param('i', $resultToReactivate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid);
    $stmt1->fetch();

    $module_status = 'active';

    $stmt2 = $mysqli->prepare("SELECT moduleid FROM system_module WHERE moduleid = ? AND module_status=?");
    $stmt2->bind_param('is', $moduleid, $module_status);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_moduleid);
    $stmt2->fetch();

    if ($stmt2->num_rows > 0) {

        $result_status = 'active';

        $stmt1 = $mysqli->prepare("UPDATE user_result SET result_status=?, updated_on=? WHERE resultid=?");
        $stmt1->bind_param('ssi', $result_status, $updated_on, $resultToReactivate);
        $stmt1->execute();
        $stmt1->close();

    } else {

        $stmt2->close();
        $error_msg = 'You cannot reactivate this result because it is linked to a module which is deactivated. You will need to reactivate the linked module before reactivating this result.';

        $array = array(
            'error_msg'=>$error_msg
        );

        echo json_encode($array);

        exit();
    }

    AdminResultUpdate($isUpdate = 1);
}

//DeleteResult function
function DeleteResult() {

    global $mysqli;

    $resultToDelete = filter_input(INPUT_POST, 'resultToDelete', FILTER_SANITIZE_STRING);
    $userToCreateResult = filter_input(INPUT_POST, 'userToCreateResult', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_result WHERE resultid=?");
    $stmt1->bind_param('i', $resultToDelete);
    $stmt1->execute();
    $stmt1->close();

    AdminResultUpdate($isUpdate = 1);
}

function AdminResultUpdate($isUpdate = 0) {

    global $mysqli;
    global $active_result;
    global $inactive_result;

    $result_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid=? AND user_result.result_status=?");
    $stmt1->bind_param('is', $userid, $result_status);
    $stmt1->execute();
    $stmt1->bind_result($resultid, $module_name, $result_coursework_mark, $result_exam_mark, $result_overall_mark);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            $active_result .=

           '<tr>
			<td data-title="Name">'.$module_name.'</td>
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

            <div class="modal modal-custom fade" id="delete-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete this result for '.$module_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a type="button" class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$resultid.'" class="btn btn-danger btn-lg btn-delete-result">Confirm</a>
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

    $result_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid=? AND user_result.result_status=?");
    $stmt2->bind_param('is', $userid, $result_status);
    $stmt2->execute();
    $stmt2->bind_result($resultid, $module_name, $result_coursework_mark, $result_exam_mark, $result_overall_mark);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            $inactive_result .=

           '<tr>
			<td data-title="Name">'.$module_name.'</td>
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

            <div class="modal modal-custom fade" id="delete-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete this result for '.$module_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$resultid.'" class="btn btn-danger btn-lg btn-delete-result">Confirm</a>
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

    if ($isUpdate === 1) {

        $array = array(
            'active_result'=>$active_result,
            'inactive_result'=>$inactive_result
        );

        echo json_encode($array);
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Library functions
//ReserveBook function
function ReserveBook() {

	global $mysqli;
	global $session_userid;
    global $created_on;

	$bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_STRING);
	$book_name = filter_input(INPUT_POST, 'book_name', FILTER_SANITIZE_STRING);
	$book_author = filter_input(INPUT_POST, 'book_author', FILTER_SANITIZE_STRING);

    $add7days = new DateTime($created_on);
    $add7days->add(new DateInterval('P7D'));
    $tocollect_on = $add7days->format('Y-m-d');
    $collected_on = '';
    $isCollected = 0;
    $reservation_status = 'active';

	$stmt1 = $mysqli->prepare("INSERT INTO system_book_reserved (userid, bookid, tocollect_on, collected_on, isCollected, reservation_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt1->bind_param('iississ', $session_userid, $bookid, $tocollect_on, $collected_on, $isCollected, $reservation_status, $created_on);
	$stmt1->execute();
	$stmt1->close();

	$isReserved = 1;

	$stmt2 = $mysqli->prepare("UPDATE system_book SET isReserved=? WHERE bookid =?");
	$stmt2->bind_param('ii', $isReserved, $bookid);
	$stmt2->execute();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt3->bind_param('i', $session_userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($email, $firstname, $surname, $studentno);
	$stmt3->fetch();
	$stmt3->close();

	$reservation_status = 'Pending';

	//Creating email
	$subject = 'Reservation confirmation';

	$message = '<html>';
	$message .= '<body>';
	$message .= '<p>Thank you for your recent book reservation! Below, you can find the reservation summary:</p>';
	$message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $studentno</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $created_on</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $tocollect_on</td></tr>";
	$message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $reservation_status</td></tr>";
	$message .= '</table>';
	$message .= '</body>';
	$message .= '</html>';

	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

	mail($email, $subject, $message, $headers);
}

//CollectBook function
function CollectBook() {

    global $mysqli;
    global $created_on;
    global $updated_on;

    //Book
    $bookToCollect = filter_input(INPUT_POST, 'bookToCollect', FILTER_SANITIZE_STRING);

    $isCollected = 1;
    $reservation_status = 'completed';

    $stmt1 = $mysqli->prepare("UPDATE system_book_reserved SET collected_on=?, isCollected=?, reservation_status=? WHERE bookid=? ORDER BY bookid DESC");
    $stmt1->bind_param('sisi', $updated_on, $isCollected, $reservation_status, $bookToCollect);
    $stmt1->execute();
    $stmt1->close();

    $stmt3 = $mysqli->prepare("SELECT r.userid, b.book_name, b.book_author FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.bookid=? ORDER BY r.reservationid DESC LIMIT 1");
    $stmt3->bind_param('i', $bookToCollect);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($userid, $book_name, $book_author);
    $stmt3->fetch();

    $book_class = 'event-success';
    $add14days = new DateTime($created_on);
    $add14days->add(new DateInterval('P14D'));
    $toreturn_on = $add14days->format('Y-m-d');
    $returned_on = '';
    $isReturned = 0;
    $isRequested = 0;
    $loan_status = 'ongoing';

    $stmt1 = $mysqli->prepare("INSERT INTO system_book_loaned (userid, bookid, book_class, toreturn_on, returned_on, isReturned, isRequested, loan_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iisssiiss', $userid, $bookToCollect, $book_class, $toreturn_on, $returned_on, $isReturned, $isRequested, $loan_status, $created_on);
    $stmt1->execute();
    $stmt1->close();

    $isLoaned = 1;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isLoaned=?, updated_on=? WHERE bookid =?");
    $stmt2->bind_param('isi', $isLoaned, $updated_on, $bookToCollect);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt3->bind_param('i', $userid);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($email, $firstname, $surname, $studentno);
    $stmt3->fetch();
    $stmt3->close();

    $loan_status = 'Ongoing';

    //Creating email
    $subject = 'Loan confirmation';

    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>This is an email to let you know that your book loan has now started. Below, you can find the loan summary:</p>';
    $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $studentno</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Loan date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $created_on</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $toreturn_on</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Loan status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $loan_status</td></tr>";
    $message .= '</table>';
    $message .= '</body>';
    $message .= '</html>';

    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
    $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    mail($email, $subject, $message, $headers);
}

//ReturnBook function
function ReturnBook() {

    global $mysqli;
    global $updated_on;

    //Book
    $bookToReturn = filter_input(INPUT_POST, 'bookToReturn', FILTER_SANITIZE_STRING);

    $loan_status = 'completed';

    $isReturned = 1;

    $stmt1 = $mysqli->prepare("UPDATE system_book_loaned SET returned_on=?, isReturned=?, loan_status=? WHERE bookid=? ORDER BY bookid DESC");
    $stmt1->bind_param('sisi', $updated_on, $isReturned, $loan_status, $bookToReturn);
    $stmt1->execute();
    $stmt1->close();

    $isReserved = 0;
    $isLoaned = 0;
    $isRequested = 0;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isReserved=?, isLoaned=?, isRequested=?, updated_on=? WHERE bookid=?");
    $stmt2->bind_param('iiisi', $isReserved, $isLoaned, $isRequested, $updated_on, $bookToReturn);
    $stmt2->execute();
    $stmt2->close();

    $isApproved = 0;
    $request_status = 'active';

    $stmt3 = $mysqli->prepare("SELECT requestid FROM system_book_requested WHERE bookid=? AND isApproved=? AND request_status=?");
    $stmt3->bind_param('iis', $bookToReturn, $isApproved, $request_status);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($requestid);
    $stmt3->fetch();

    if ($stmt3->num_rows == 1) {
        $isApproved = 1;
        $request_status = 'completed';

        $stmt4 = $mysqli->prepare("UPDATE system_book_requested SET isApproved=?, request_status=? WHERE requestid=?");
        $stmt4->bind_param('isi', $isApproved, $request_status, $requestid);
        $stmt4->execute();
        $stmt4->close();

        $stmt5 = $mysqli->prepare("SELECT userid, bookid FROM system_book_requested WHERE requestid=?");
        $stmt5->bind_param('i', $requestid);
        $stmt5->execute();
        $stmt5->store_result();
        $stmt5->bind_result($userid, $bookid);
        $stmt5->fetch();
        $stmt5->close();

        $add7days = new DateTime($updated_on);
        $add7days->add(new DateInterval('P7D'));
        $tocollect_on = $add7days->format('Y-m-d');
        $collected_on = '';
        $isCollected = 0;
        $reservation_status = 'active';

        $stmt6 = $mysqli->prepare("INSERT INTO system_book_reserved (userid, bookid, tocollect_on, collected_on, isCollected, reservation_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt6->bind_param('iississ', $userid, $bookid, $tocollect_on, $collected_on, $isCollected, $reservation_status, $updated_on);
        $stmt6->execute();
        $stmt6->close();

        $isReserved = 1;
        $isRequested = 0;

        $stmt7 = $mysqli->prepare("UPDATE system_book SET isReserved=?, isRequested=? WHERE bookid =?");
        $stmt7->bind_param('iii', $isReserved, $isRequested, $bookid);
        $stmt7->execute();
        $stmt7->close();

        $stmt8 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
        $stmt8->bind_param('i', $userid);
        $stmt8->execute();
        $stmt8->store_result();
        $stmt8->bind_result($email, $firstname, $surname, $studentno);
        $stmt8->fetch();
        $stmt8->close();

        $stmt9 = $mysqli->prepare("SELECT r.userid, b.book_name, b.book_author FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.bookid=? ORDER BY r.reservationid DESC LIMIT 1");
        $stmt9->bind_param('i', $bookToReturn);
        $stmt3->execute();
        $stmt9->store_result();
        $stmt9->bind_result($userid, $book_name, $book_author);
        $stmt9->fetch();

        //Creating email
        $subject = 'Reservation confirmation';

        $message = '<html>';
        $message .= '<body>';
        $message .= '<p>Just wanted to let you know that the book you requested has now been reserved! Below, you can find the reservation summary:</p>';
        $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$firstname</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $surname</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $email</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $studentno</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $updated_on</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Collect by:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $tocollect_on</td></tr>";
        $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Reservation status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $reservation_status</td></tr>";
        $message .= '</table>';
        $message .= '</body>';
        $message .= '</html>';

        $headers  = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

        $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
        $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

        mail($email, $subject, $message, $headers);

    } else {
        $stmt3->close();
        exit();
    }
}

function RenewBookCheck () {

    global $mysqli;
    global $updated_on;

    //Book to
    $bookToRenew = filter_input(INPUT_POST, 'bookToRenew', FILTER_SANITIZE_STRING);

    $isApproved = 0;

    $stmt1 = $mysqli->prepare("SELECT bookid FROM system_book_requested WHERE bookid=? AND isApproved=? ORDER BY requestid DESC LIMIT 1");
    $stmt1->bind_param('ii', $bookToRenew, $isApproved);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_bookid);
    $stmt1->fetch();

    if ($stmt1->num_rows > 0) {
        $stmt1->close();
        echo 'You cannot renew this book at this time. Another user requested this book. Once the book is collected and loaned again, you will be able to request it.';
        exit();
    } else {

        $isRenewed = 3;

        $stmt2 = $mysqli->prepare("SELECT bookid FROM system_book_loaned WHERE bookid=? AND isRenewed=? ORDER BY loanid DESC LIMIT 1");
        $stmt2->bind_param('ii', $bookToRenew, $isRenewed);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($db_bookid);
        $stmt2->fetch();

        if ($stmt2->num_rows > 0) {
            $stmt2->close();
            echo 'You cannot renew this book now. You have already renewed it 3 times, which is the maximum renewal limit.';
            exit();
        }
    }
}

//RenewBook function
function RenewBook() {

    global $mysqli;
    global $updated_on;

    //Book to
    $bookToRenew = filter_input(INPUT_POST, 'bookToRenew', FILTER_SANITIZE_STRING);

    $isApproved = 0;

    $stmt1 = $mysqli->prepare("SELECT bookid FROM system_book_requested WHERE bookid=? AND isApproved=? ORDER BY requestid DESC LIMIT 1");
    $stmt1->bind_param('ii', $bookToRenew, $isApproved);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_bookid);
    $stmt1->fetch();

    if ($stmt1->num_rows > 0) {
        $stmt1->close();
        echo 'You cannot renew this book at this time. Another user requested this book. Once the book is collected and loaned again, you will be able to request it.';
        exit();
    } else {

        $isRenewed = 3;

        $stmt2 = $mysqli->prepare("SELECT bookid FROM system_book_loaned WHERE bookid=? AND isRenewed=? ORDER BY loanid DESC LIMIT 1");
        $stmt2->bind_param('ii', $bookToRenew, $isRenewed);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($db_bookid);
        $stmt2->fetch();

        if ($stmt2->num_rows > 0) {
            $stmt2->close();
            echo 'You cannot renew this book now. You have already renewed it 3 times, which is the maximum renewal limit.';
            exit();
        } else {
            $stmt3 = $mysqli->prepare("SELECT bookid, toreturn_on, isRenewed FROM system_book_loaned WHERE bookid=? ORDER BY loanid DESC LIMIT 1");
            $stmt3->bind_param('i', $bookToRenew);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($db_bookid, $toreturn_on, $isRenewed);
            $stmt3->fetch();
            $stmt3->close();

            $add14days = new DateTime($toreturn_on);
            $add14days->add(new DateInterval('P14D'));
            $toreturn_on = $add14days->format('Y-m-d');
            $isRenewed = $isRenewed + 1;

            $stmt4 = $mysqli->prepare("UPDATE system_book_loaned SET toreturn_on=?, isRenewed=?, updated_on=? WHERE bookid =?");
            $stmt4->bind_param('sis', $toreturn_on, $isRenewed, $updated_on);
            $stmt4->execute();
            $stmt4->close();
        }
    }

}

//RequestBook function
function RequestBook() {

    global $mysqli;
    global $session_userid;
    global $created_on;

    //Book
    $bookToRequest = filter_input(INPUT_POST, 'bookToRequest', FILTER_SANITIZE_STRING);

    $isRead = 0;
    $isApproved = 0;
    $request_status = 'pending';

    $stmt1 = $mysqli->prepare("INSERT INTO system_book_requested (userid, bookid, isRead, isApproved, request_status, created_on) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('iiiiss', $session_userid, $bookToRequest, $isRead, $isApproved, $request_status, $created_on);
    $stmt1->execute();
    $stmt1->close();

    $isRequested = 1;

    $stmt2 = $mysqli->prepare("UPDATE system_book SET isRequested=? WHERE bookid =?");
    $stmt2->bind_param('ii', $isRequested, $bookToRequest);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("UPDATE system_book_loaned SET isRequested=? WHERE bookid =?");
    $stmt3->bind_param('ii', $isRequested, $bookToRequest);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("SELECT system_book_reserved.userid, system_book_reserved.created_on, system_book_reserved.tocollect_on, system_book.book_name, system_book.book_author, system_book.book_status FROM system_book_reserved LEFT JOIN system_book ON system_book_reserved.bookid=system_book.bookid WHERE system_book_reserved.bookid=?");
    $stmt4->bind_param('i', $bookToRequest);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($userid, $bookreserved_from, $bookreserved_to, $book_name, $book_author, $book_status);
    $stmt4->fetch();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt5->bind_param('i', $userid);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($reservee_email, $reservee_firstname, $reservee_surname, $reservee_studentno);
    $stmt5->fetch();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $session_userid);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($requester_email, $requester_firstname, $requester_surname, $requester_studentno);
    $stmt6->fetch();
    $stmt6->close();

    $book_status = ucfirst($book_status);

    //Creating email
    $subject = 'Request notice';

    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>Hi! Someone requested a book you reserved. Below, you can find the request summary:</p>';
    $message .= '<table rules="all" cellpadding="10" style="color: #333333; background-color: #F0F0F0; border: 1px solid #CCCCCC;">';
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>First name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\">$requester_firstname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Surname:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $requester_surname</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Email:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $requester_email</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Student number:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $requester_studentno</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Name:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_name</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Author:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_author</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Booking date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $bookreserved_from</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Return date:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $bookreserved_to</td></tr>";
    $message .= "<tr><td style=\"border: 1px solid #CCCCCC;\"><strong>Book status:</strong> </td><td style=\"border: 1px solid #CCCCCC;\"> $book_status</td></tr>";
    $message .= '</table>';
    $message .= '</body>';
    $message .= '</html>';

    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
    $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

    mail("$reservee_email, admin@student-portal.co.uk", $subject, $message, $headers);

}

//SetRequestRead function
function SetRequestRead () {

    global $mysqli;

    $isRead = 1;

    $stmt1 = $mysqli->prepare("UPDATE system_book_requested SET isRead=?");
    $stmt1->bind_param('i', $isRead);
    $stmt1->execute();
    $stmt1->close();
}

//CreateBook function
function CreateBook() {

    global $mysqli;
    global $created_on;

    //Book
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

    //If book exists, increase copy number
    $stmt1 = $mysqli->prepare("SELECT bookid, book_copy_no FROM system_book WHERE book_name=? AND book_author=? ORDER BY bookid DESC LIMIT 1");
    $stmt1->bind_param('ss', $book_name, $book_author);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_bookid, $db_book_copy_no);
    $stmt1->fetch();

    $book_publish_date = DateTime::createFromFormat('d/m/Y', $book_publish_date);
    $book_publish_date = $book_publish_date->format('Y-m-d');

    if ($stmt1->num_rows > 0) {

        $book_status = 'active';
        $book_copy_no = $db_book_copy_no + 1;

        $isReserved = 0;
        $isLoaned = 0;

        $stmt5 = $mysqli->prepare("INSERT INTO system_book (book_name, book_notes, book_author, book_copy_no, book_location, book_publisher, book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language, book_status, isReserved, isLoaned, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssissssiisssiis', $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $book_status, $isReserved, $isLoaned, $created_on);
        $stmt5->execute();
        $stmt5->close();

    } else {

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
function UpdateBook()
{

    global $mysqli;
    global $updated_on;

    //Book
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

    // Check if event name is different
    $stmt1 = $mysqli->prepare("SELECT book_name FROM system_book WHERE bookid = ?");
    $stmt1->bind_param('i', $bookid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_book_name);
    $stmt1->fetch();

    $book_publish_date = DateTime::createFromFormat('d/m/Y', $book_publish_date);
    $book_publish_date = $book_publish_date->format('Y-m-d');

    if ($book_name === $db_book_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_book SET book_notes=?, book_author=?, book_copy_no=?, book_location=?, book_publisher=?, book_publish_date=?, book_publish_place=?, book_page_amount=?, book_barcode=?, book_discipline=?, book_language=?, updated_on=? WHERE bookid=?");
        $stmt2->bind_param('ssissssiisssi', $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $updated_on, $bookid);
        $stmt2->execute();
        $stmt2->close();

    } else {

        // Check existing book name
        $stmt3 = $mysqli->prepare("SELECT bookid FROM system_book WHERE book_name = ?");
        $stmt3->bind_param('s', $event_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_bookid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 An event with the name entered already exists.');
            exit();
        } else {
            $stmt5 = $mysqli->prepare("UPDATE system_book SET book_name=?, book_notes=?, book_author=?, book_copy_no=?, book_location=?, book_publisher=?, book_publish_date=?, book_publish_place=?, book_page_amount=?, book_barcode=?, book_discipline=?, book_language=?, updated_on=? WHERE bookid=?");
            $stmt5->bind_param('sssissssiisssi', $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language, $updated_on, $bookid);
            $stmt5->execute();
            $stmt5->close();
        }
    }
}

//DeactivateBook function
function DeactivateBook() {

    global $mysqli;
    global $updated_on;

    $bookToDeactivate = filter_input(INPUT_POST, 'bookToDeactivate', FILTER_SANITIZE_STRING);

    $book_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_book SET book_status=?, updated_on=? WHERE bookid=?");
    $stmt1->bind_param('ssi', $book_status, $updated_on, $bookToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminLibraryUpdate($isUpdate = 1);
}

//DeactivateBook function
function ReactivateBook() {

    global $mysqli;
    global $updated_on;

    $bookToReactivate = filter_input(INPUT_POST, 'bookToReactivate', FILTER_SANITIZE_STRING);

    $book_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_book SET book_status=?, updated_on=? WHERE bookid=?");
    $stmt1->bind_param('ssi', $book_status, $updated_on, $bookToReactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminLibraryUpdate($isUpdate = 1);
}

//DeleteBook function
function DeleteBook() {

    global $mysqli;

    $bookToDelete = filter_input(INPUT_POST, 'bookToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE bookid=?");
    $stmt1->bind_param('i', $bookToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM system_book WHERE bookid=?");
    $stmt2->bind_param('i', $bookToDelete);
    $stmt2->execute();
    $stmt2->close();

    AdminLibraryUpdate($isUpdate = 1);
}

function AdminLibraryUpdate($isUpdate = 0) {

    global $mysqli;
    global $isUpdate;
    global $active_book;
    global $inactive_book;

    $book_status1 = 'active';
    $book_status2 = 'reserved';
    $book_status3 = 'requested';

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_book WHERE book_status=? OR book_status=? OR book_status=?");
    $stmt1->bind_param('sss', $book_status1, $book_status2, $book_status3);
    $stmt1->execute();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no, $book_status);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

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

            			<div id="view-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-book?id='.$bookid.'" class="btn btn-primary btn-sm">Update</a>
            <a id="deactivate-'.$bookid.'" class="btn btn-primary btn-sm btn-deactivate-book">Deactivate</a>
            <a href="#delete-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to delete '.$book_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$bookid.'" class="btn btn-danger btn-lg btn-delete-book">Confirm</a>
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

    $book_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_book WHERE book_status=?");
    $stmt2->bind_param('s', $book_status);
    $stmt2->execute();
    $stmt2->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no, $book_status);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            $inactive_book .=

           '<tr>
			<td data-title="Name"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
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

            <div id="view-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a id="reactivate-'.$bookid.'" class="btn btn-primary btn-sm btn-reactivate-book">Reactivate</a>
            <a href="#delete-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$book_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$bookid.'" class="btn btn-success btn-lg btn-delete-book">Confirm</a>
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

    if ($isUpdate === 1) {

        $array = array(
            'active_book'=>$active_book,
            'inactive_book'=>$inactive_book
        );

        echo json_encode($array);
    }

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

	$task_name = filter_input(INPUT_POST, 'create_task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'create_task_notes', FILTER_SANITIZE_STRING);
    $task_url = filter_input(INPUT_POST, 'create_task_url', FILTER_SANITIZE_STRING);
    $task_startdate = filter_input(INPUT_POST, 'create_task_startdate', FILTER_SANITIZE_STRING);
    $task_duedate = filter_input(INPUT_POST, 'create_task_duedate', FILTER_SANITIZE_STRING);

    // Check if task exists
    $stmt1 = $mysqli->prepare("SELECT taskid FROM user_task WHERE task_name = ? AND userid = ? LIMIT 1");
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

        $task_class = 'event-info';
        $task_status = 'active';

	    $stmt2 = $mysqli->prepare("INSERT INTO user_task (userid, task_name, task_notes, task_url, task_class, task_startdate, task_duedate, task_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    $stmt2->bind_param('issssssss', $session_userid, $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_status, $created_on);
	    $stmt2->execute();
	    $stmt2->close();

	    $stmt1->close();
    }

    calendarUpdate($isUpdate = 1);
}

//UpdateTask function
function UpdateTask() {

	global $mysqli;
	global $updated_on;

	$taskid = filter_input(INPUT_POST, 'update_taskid', FILTER_SANITIZE_NUMBER_INT);
	$task_name = filter_input(INPUT_POST, 'update_task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'update_task_notes', FILTER_SANITIZE_STRING);
	$task_url = filter_input(INPUT_POST, 'update_task_url', FILTER_SANITIZE_STRING);
	$task_startdate = filter_input(INPUT_POST, 'update_task_startdate', FILTER_SANITIZE_STRING);
	$task_duedate = filter_input(INPUT_POST, 'update_task_duedate', FILTER_SANITIZE_STRING);

	$stmt1 = $mysqli->prepare("SELECT task_name from user_task where taskid = ?");
	$stmt1->bind_param('i', $taskid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_taskname);
	$stmt1->fetch();

	if ($db_taskname == $task_name) {

        $task_class = 'event-important';

	    $stmt2 = $mysqli->prepare("UPDATE user_task SET task_notes=?, task_url=?, task_class=?, task_startdate=?, task_duedate=?, updated_on=? WHERE taskid = ?");
	    $stmt2->bind_param('ssssssi', $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $updated_on, $taskid);
	    $stmt2->execute();
	    $stmt2->close();

	} else {

        $stmt3 = $mysqli->prepare("SELECT taskid from user_task where task_name = ? AND userid = ? LIMIT 1");
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

        $task_class = 'event-important';

        $stmt4 = $mysqli->prepare("UPDATE user_task SET task_name=?, task_notes=?, task_url=?, task_class=?, task_startdate=?, task_duedate=?, updated_on=? WHERE taskid = ?");
        $stmt4->bind_param('sssssssi', $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $updated_on, $taskid);
        $stmt4->execute();
        $stmt4->close();

        }
	}
}

//CompleteTask function
function CompleteTask() {

	global $mysqli;
    global $updated_on;
    global $completed_on;

	$taskToComplete = filter_input(INPUT_POST, 'taskToComplete', FILTER_SANITIZE_NUMBER_INT);
	$task_status = 'completed';

	$stmt1 = $mysqli->prepare("UPDATE user_task SET task_status = ?, updated_on = ?, completed_on=? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('sssi', $task_status, $updated_on, $completed_on, $taskToComplete);
	$stmt1->execute();
	$stmt1->close();

    calendarUpdate($isUpdate = 1);
}

//DeactivateTask function
function DeactivateTask() {

    global $mysqli;
    global $updated_on;

    $taskToDeactivate = filter_input(INPUT_POST, 'taskToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $task_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_task SET task_status=?, updated_on=? WHERE taskid = ?");
    $stmt1->bind_param('ssi', $task_status, $updated_on, $taskToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    calendarUpdate($isUpdate = 1);
}

//ReactivateTask function
function ReactivateTask() {

    global $mysqli;
    global $updated_on;

    $taskToReactivate = filter_input(INPUT_POST, 'taskToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $task_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE user_task SET task_status=?, updated_on=? WHERE taskid = ?");
    $stmt1->bind_param('ssi', $task_status, $updated_on, $taskToReactivate);
    $stmt1->execute();
    $stmt1->close();

    calendarUpdate($isUpdate = 1);
}

//DeleteTask function
function DeleteTask() {

    global $mysqli;

    $taskToDelete = filter_input(INPUT_POST, 'taskToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_task WHERE taskid = ?");
    $stmt1->bind_param('i', $taskToDelete);
    $stmt1->execute();
    $stmt1->close();

    calendarUpdate($isUpdate = 1);
}

function calendarUpdate($isUpdate = 0) {

    global $mysqli;
    global $session_userid;
    global $due_task;
    global $completed_task;
    global $archived_task;

    $task_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid=? AND task_status=?");
    $stmt1->bind_param('is', $session_userid, $task_status);
    $stmt1->execute();
    $stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

        $due_task .=

       '<tr>
        <td data-title="Name"><a href="#view-'.$taskid .'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'. $task_startdate .'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="complete-'.$taskid.'" class="btn btn-primary btn-complete">Complete</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="../calendar/update-task?id='.$taskid.'">Update</a></li>
        <li><a id="deactivate-'.$taskid.'" class="btn-deactivate">Archive</a></li>
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
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a href="/calendar/update-task?id='.$taskid.'" class="btn btn-primary btn-sm" >Update</a>
        <a href="#complete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Complete</a>
        <a href="#deactivate-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Archive</a>
        <a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!--/modal -->
        </div><!--/modal-dialog-->
        </div><!--/modal-content-->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
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

    $task_status = 'completed';

    $stmt2 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid=? AND task_status=?");
    $stmt2->bind_param('is', $session_userid, $task_status);
    $stmt2->execute();
    $stmt2->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt2->store_result();

    while($stmt2->fetch()) {

        if ($stmt2->num_rows > 0) {

        $completed_task .=

       '<tr>
        <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal" data-dismiss="modal">'.$task_name.'</a></td>
        <td data-title="Start">'.$task_startdate.'</td>
        <td data-title="Due">'.$task_duedate.'</td>
        <td data-title="Completed on">'.$task_duedate.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate">Restore</a>
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
        <div class="close">
        <i class="fa fa-calendar"></i>
        </div>
        <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
        </div>

        <div class="modal-body">
        <p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
        <p><b>URL:</b> '.(empty($task_url) ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</p>
        <p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
        <p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
        <p><b>Completed on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a href="#delete-confirmation-'.$taskid.'" class="btn btn-primary btn-sm" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-center">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
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

    $task_status = 'inactive';

    $stmt3 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task WHERE userid=? AND task_status=?");
    $stmt3->bind_param('is', $session_userid, $task_status);
    $stmt3->execute();
    $stmt3->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt3->store_result();

        if ($stmt3->num_rows > 0) {

        while($stmt3->fetch()) {

        $archived_task .=

       '<tr>
        <td data-title="Name"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'.$task_startdate.'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Archived on">'.$updated_on.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate">Restore</a>
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
        <a href="#reactivate-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Restore</a>
        <a href="#delete-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
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

    if ($isUpdate === 1) {

        $array = array(
            'due_task'=>$due_task,
            'completed_task'=>$completed_task,
            'archived_task'=>$archived_task
        );

        echo json_encode($array);

    }
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

	$invoiceid = $_POST["invoice"];
	$transactionid  = $_POST["txn_id"];

	$payment_status = strtolower($_POST["payment_status"]);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

    //Get userid by using invoice_id
	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoiceid = ? LIMIT 1");
	$stmt1->bind_param('i', $invoiceid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

    $event_class = 'event-important';

	$stmt2 = $mysqli->prepare("INSERT INTO system_event_booked (userid, eventid, event_amount_paid, ticket_quantity, event_class, booked_on) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt2->bind_param('iiiiss', $userid, $item_number1, $product_amount, $quantity1, $event_class, $created_on);
	$stmt2->execute();
	$stmt2->close();

	$stmt3 = $mysqli->prepare("SELECT event_ticket_no from system_event where eventid=? LIMIT 1");
	$stmt3->bind_param('i', $item_number1);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($event_ticket_no);
	$stmt3->fetch();
	$stmt3->close();

	$newquantity = $event_ticket_no - $quantity1;

	$stmt4 = $mysqli->prepare("UPDATE system_event SET event_ticket_no=? WHERE eventid=?");
	$stmt4->bind_param('ii', $newquantity, $item_number1);
	$stmt4->execute();
	$stmt4->close();

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET transaction_id=?, payment_status =?, updated_on=?, completed_on=? WHERE invoice_id =?");
	$stmt5->bind_param('ssssi', $transactionid, $payment_status, $updated_on, $completed_on, $invoiceid);
	$stmt5->execute();
	$stmt5->close();

    //Get name and email for sending email
    $stmt6 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
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

	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

	mail($email, $subject, $message, $headers);
}

//EventTicketQuantityCheck function
function EventTicketQuantityCheck () {

	global $mysqli;

	$eventid = filter_input(INPUT_POST, 'eventid', FILTER_SANITIZE_STRING);
	$product_quantity = filter_input(INPUT_POST, 'product_quantity', FILTER_SANITIZE_STRING);

	$stmt1 = $mysqli->prepare("SELECT event_ticket_no FROM system_event WHERE eventid = ? LIMIT 1");
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

    $event_name = filter_input(INPUT_POST, 'create_event_name', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'create_event_notes', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'create_event_url', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'create_event_from', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'create_event_to', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'create_event_amount', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'create_event_ticket_no', FILTER_SANITIZE_STRING);

    // Check existing event name
    $stmt1 = $mysqli->prepare("SELECT eventid FROM system_event WHERE event_name=? LIMIT 1");
    $stmt1->bind_param('s', $event_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_eventid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 The event name you entered already exists.');
        exit();

    } else {

        //Creating event record

        $event_class = 'event-important';
        $event_from = DateTime::createFromFormat('d/m/Y H:i', $event_from);
        $event_from = $event_from->format('Y-m-d H:i');
        $event_to = DateTime::createFromFormat('d/m/Y H:i', $event_to);
        $event_to = $event_to->format('Y-m-d H:i');
        $event_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO system_event (event_class, event_name, event_notes, event_url, event_from, event_to, event_amount, event_ticket_no, event_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('ssssssiiss', $event_class, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $event_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

    }
}

//UpdateEvent function
function UpdateEvent() {

    global $mysqli;
    global $updated_on;

    $eventid = filter_input(INPUT_POST, 'update_eventid', FILTER_SANITIZE_STRING);
    $event_name = filter_input(INPUT_POST, 'update_event_name', FILTER_SANITIZE_STRING);
    $event_notes = filter_input(INPUT_POST, 'update_event_notes', FILTER_SANITIZE_STRING);
    $event_url = filter_input(INPUT_POST, 'update_event_url', FILTER_SANITIZE_STRING);
    $event_from = filter_input(INPUT_POST, 'update_event_from', FILTER_SANITIZE_STRING);
    $event_to = filter_input(INPUT_POST, 'update_event_to', FILTER_SANITIZE_STRING);
    $event_amount = filter_input(INPUT_POST, 'update_event_amount', FILTER_SANITIZE_STRING);
    $event_ticket_no = filter_input(INPUT_POST, 'update_event_ticket_no', FILTER_SANITIZE_STRING);

    // Check if event name is different
    $stmt1 = $mysqli->prepare("SELECT event_name FROM system_event WHERE eventid = ?");
    $stmt1->bind_param('i', $eventid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_event_name);
    $stmt1->fetch();

    $event_from = DateTime::createFromFormat('d/m/Y H:i', $event_from);
    $event_from = $event_from->format('Y-m-d H:i');
    $event_to = DateTime::createFromFormat('d/m/Y H:i', $event_to);
    $event_to = $event_to->format('Y-m-d H:i');

    if ($db_event_name === $event_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_event SET event_notes=?, event_url=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, updated_on=? WHERE eventid=?");
        $stmt2->bind_param('ssssiisi', $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $updated_on, $eventid);
        $stmt2->execute();
        $stmt2->close();

    } else {

        // Check existing event name
        $stmt3 = $mysqli->prepare("SELECT eventid FROM system_event WHERE event_name = ?");
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
            $stmt4 = $mysqli->prepare("UPDATE system_event SET event_name=?, event_notes=?, event_url=?, event_from=?, event_to=?, event_amount=?, event_ticket_no=?, updated_on=? WHERE eventid=?");
            $stmt4->bind_param('sssssiisi', $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no, $updated_on, $eventid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateEvent function
function DeactivateEvent() {

    global $mysqli;
    global $updated_on;

    $eventToDeactivate = filter_input(INPUT_POST, 'eventToDeactivate', FILTER_SANITIZE_STRING);

    $event_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_event SET event_status=?, updated_on=? WHERE eventid=?");
    $stmt1->bind_param('ssi', $event_status, $updated_on, $eventToDeactivate);
    $stmt1->execute();
    $stmt1->close();

    AdminEventUpdate($isUpdate = 1);
}

//ReactivateEvent function
function ReactivateEvent() {

    global $mysqli;
    global $updated_on;

    $eventToReactivate = filter_input(INPUT_POST, 'eventToReactivate', FILTER_SANITIZE_STRING);

    $event_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_event SET event_status=?, updated_on=? WHERE eventid=?");
    $stmt1->bind_param('ssi', $event_status, $updated_on, $eventToReactivate);
    $stmt1->execute();
    $stmt1->close();

    echo 'blah';
}

//DeleteEvent function
function DeleteEvent() {

    global $mysqli;

    $eventToDelete = filter_input(INPUT_POST, 'eventToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM system_event_booked WHERE eventid=?");
    $stmt1->bind_param('i', $eventToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM system_event WHERE eventid=?");
    $stmt2->bind_param('i', $eventToDelete);
    $stmt2->execute();
    $stmt2->close();

    AdminEventUpdate($isUpdate = 1);
}

function AdminEventUpdate($isUpdate = 0) {

    global $mysqli;
    global $active_event;
    global $inactive_event;
    global $archived_task;

    $event_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE event_status=?");
    $stmt1->bind_param('s', $event_status);
    $stmt1->execute();
    $stmt1->bind_result($eventid, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            $active_event .=

            '<tr>
            <td data-title="Name"><a href="#view-'.$eventid.'" data-toggle="modal" data-dismiss="modal">'.$event_name.'</a></td>
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
            </td>
            </tr>

            <div id="view-'.$eventid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a href="/admin/update-event?id='.$eventid.'" class="btn btn-primary btn-sm">Update</a>
            <a id="deactivate-'.$eventid.'" class="btn btn-primary btn-sm btn-deactivate-event">Deactivate</a>
            <a href="#delete-'.$eventid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
            </div>
            <div class="view-close pull-right">
            <a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            <div id="delete-'.$eventid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="form-logo text-center">
            <i class="fa fa-trash"></i>
            </div>
            </div>

            <div class="modal-body">
            <p class="feedback-sad text-center">Are you sure you want to delete '.$event_name.'?</p>
            </div>

            <div class="modal-footer">
            <div class="text-right">
            <a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$eventid.'" class="btn btn-success btn-lg btn-delete-event">Confirm</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->';
        }
    }

    $stmt1->close();

    $event_status = 'inactive';

    $stmt2 = $mysqli->prepare("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE event_status=?");
    $stmt2->bind_param('s', $event_status);
    $stmt2->execute();
    $stmt2->bind_result($eventid, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

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
            </td>
            </tr>

            <div id="view-'.$eventid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
            <a href="/admin/update-event?id='.$eventid.'" class="btn btn-primary btn-sm" >Update</a>
            <a id="reactivate-'.$eventid.'" class="btn btn-primary btn-sm btn-reactivate-event">Reactivate</a>
            <a href="#delete-'.$eventid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm">Delete</a>
            </div>
            <div class="view-close pull-right">
            <a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->

            <div id="delete-'.$eventid.'" class="modal modal-custom fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
            <div class="form-logo text-center">
            <i class="fa fa-trash"></i>
            </div>
            </div>

            <div class="modal-body">
            <p class="feedback-sad text-center">Are you sure you want to delete '.$event_name.'?</p>
            </div>

            <div class="modal-footer">
            <div class="text-right">
            <a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$eventid.'" class="btn btn-danger btn-lg btn-delete-event">Confirm</a>
            </div>
            </div>

            </div><!-- /modal -->
            </div><!-- /modal-dialog -->
            </div><!-- /modal-content -->';
        }
	}

	$stmt2->close();

    if ($isUpdate === 1) {

        $array = array(
            'active_event'=>$active_event,
            'inactive_event'=>$inactive_event
        );

        echo json_encode($array);

    }
}


function AdminEventUpdate($isUpdate = 0) {

    global $mysqli;
    global $isUpdate;
    global $active_event;
    global $inactive_event;



    if ($isUpdate === 1) {

        $array = array(
            'active_event'=>$active_event,
            'inactive_event'=>$inactive_event
        );

        echo json_encode($array);
    }

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//University map function
//CreateLocation function
function CreateLocation() {

    global $mysqli;
    global $created_on;

    $marker_name = filter_input(INPUT_POST, 'marker_name', FILTER_SANITIZE_STRING);
    $marker_notes = filter_input(INPUT_POST, 'marker_notes', FILTER_SANITIZE_STRING);
    $marker_url = filter_input(INPUT_POST, 'marker_url', FILTER_SANITIZE_STRING);
    $marker_lat = filter_input(INPUT_POST, 'marker_lat', FILTER_SANITIZE_STRING);
    $marker_long = filter_input(INPUT_POST, 'marker_long', FILTER_SANITIZE_STRING);
    $marker_category = filter_input(INPUT_POST, 'marker_category', FILTER_SANITIZE_STRING);

    // Check existing location name
    $stmt1 = $mysqli->prepare("SELECT markerid FROM system_map_marker WHERE marker_name=? LIMIT 1");
    $stmt1->bind_param('s', $marker_name);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_markerid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        $stmt1->close();
        header('HTTP/1.0 550 The location name you entered already exists.');
        exit();
    } else {

        $marker_status = 'active';

        $stmt3 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_url, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssiisss', $marker_name, $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $marker_status, $created_on);
        $stmt3->execute();
        $stmt3->close();

    }
}

//UpdateLocation function
function UpdateLocation() {

    global $mysqli;
    global $updated_on;

    $markerid = filter_input(INPUT_POST, 'markerid', FILTER_SANITIZE_STRING);
    $marker_name = filter_input(INPUT_POST, 'marker_name1', FILTER_SANITIZE_STRING);
    $marker_notes = filter_input(INPUT_POST, 'marker_notes1', FILTER_SANITIZE_STRING);
    $marker_url = filter_input(INPUT_POST, 'marker_url1', FILTER_SANITIZE_STRING);
    $marker_lat = filter_input(INPUT_POST, 'marker_lat1', FILTER_SANITIZE_STRING);
    $marker_long = filter_input(INPUT_POST, 'marker_long1', FILTER_SANITIZE_STRING);
    $marker_category = filter_input(INPUT_POST, 'marker_category1', FILTER_SANITIZE_STRING);

    // Check if event name is different
    $stmt1 = $mysqli->prepare("SELECT marker_name FROM system_map_marker WHERE markerid=? LIMIT 1");
    $stmt1->bind_param('i', $markerid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_marker_name);
    $stmt1->fetch();

    if ($db_marker_name === $marker_name) {

        $stmt2 = $mysqli->prepare("UPDATE system_map_marker SET marker_notes=?, marker_url=?, marker_lat=?, marker_long=?, marker_category=?, updated_on=? WHERE markerid=?");
        $stmt2->bind_param('ssiissi', $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $updated_on, $markerid);
        $stmt2->execute();
        $stmt2->close();

    } else {

        // Check existing event name
        $stmt3 = $mysqli->prepare("SELECT markerid FROM system_map_marker WHERE marker_name = ?");
        $stmt3->bind_param('s', $marker_name);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($db_markerid);
        $stmt3->fetch();

        if ($stmt3->num_rows == 1) {
            $stmt3->close();
            header('HTTP/1.0 550 A location with the name entered already exists.');
            exit();
        } else {
            $stmt4 = $mysqli->prepare("UPDATE system_map_marker SET marker_name=?, marker_notes=?, marker_url=?, marker_lat=?, marker_long=?, marker_category=?, updated_on=? WHERE markerid=?");
            $stmt4->bind_param('sssiissi', $marker_name, $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $updated_on, $markerid);
            $stmt4->execute();
            $stmt4->close();
        }
    }
}

//DeactivateLocation function
function DeactivateLocation() {

    global $mysqli;
    global $updated_on;

    $locationToDeactivate = filter_input(INPUT_POST, 'locationToDeactivate', FILTER_SANITIZE_STRING);

    $marker_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE system_map_marker SET marker_status=?, updated_on=? WHERE markerid=?");
    $stmt1->bind_param('ssi', $marker_status, $updated_on, $locationToDeactivate);
    $stmt1->execute();
    $stmt1->close();

}

//ReactivateLocation function
function ReactivateLocation() {

    global $mysqli;
    global $updated_on;

    $locationToReactivate = filter_input(INPUT_POST, 'locationToReactivate', FILTER_SANITIZE_STRING);

    $marker_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE system_map_marker SET marker_status=?, updated_on=? WHERE markerid=?");
    $stmt1->bind_param('ssi', $marker_status, $updated_on, $locationToReactivate);
    $stmt1->execute();
    $stmt1->close();

}

//DeleteLocation function
function DeleteLocation() {

    global $mysqli;

    $locationToDelete = filter_input(INPUT_POST, 'locationToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM system_map_marker WHERE markerid=?");
    $stmt1->bind_param('i', $locationToDelete);
    $stmt1->execute();
    $stmt1->close();

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
    $feedback_subject = filter_input(INPUT_POST, 'feedback_subject', FILTER_SANITIZE_STRING);
    $feedback_body = filter_input(INPUT_POST, 'feedback_body', FILTER_SANITIZE_STRING);

    $feedback_status = 'active';
    $isApproved = 0;

    $stmt1 = $mysqli->prepare("INSERT INTO user_feedback (moduleid, feedback_subject, feedback_body, feedback_status, isApproved, created_on) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param('isssis', $feedback_moduleid, $feedback_subject, $feedback_body, $feedback_status, $isApproved, $created_on);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("SELECT feedbackid FROM user_feedback ORDER BY feedbackid DESC LIMIT 1");
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($feedbackid);
    $stmt2->fetch();

    $isRead = 0;

    $stmt3 = $mysqli->prepare("INSERT INTO user_feedback_sent (feedbackid, feedback_from, moduleid, module_staff) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param('iiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_lecturer);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("INSERT INTO user_feedback_sent (feedbackid, feedback_from, moduleid, module_staff) VALUES (?, ?, ?, ?)");
    $stmt4->bind_param('iiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_tutorial_assistant);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("INSERT INTO user_feedback_received (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt5->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_lecturer, $isRead);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("INSERT INTO user_feedback_received (feedbackid, feedback_from, moduleid, module_staff, isRead) VALUES (?, ?, ?, ?, ?)");
    $stmt6->bind_param('iiiii', $feedbackid, $session_userid, $feedback_moduleid, $feedback_tutorial_assistant, $isRead);
    $stmt6->execute();
    $stmt6->close();

}

//ApproveFeedback function
function ApproveFeedback () {

    global $mysqli;

    $feedbackToApprove = filter_input(INPUT_POST, 'feedbackToApprove', FILTER_SANITIZE_STRING);

    $isApproved = 1;

    $stmt1 = $mysqli->prepare("UPDATE user_feedback SET isApproved=? WHERE feedbackid=?");
    $stmt1->bind_param('ii', $isApproved, $feedbackToApprove);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("SELECT feedback_subject, feedback_body FROM user_feedback WHERE feedbackid = ? LIMIT 1");
    $stmt2->bind_param('i', $feedbackToApprove);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($feedback_subject, $feedback_body);
    $stmt2->fetch();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("SELECT s.email FROM user_feedback_received f LEFT JOIN user_signin s ON f.module_staff=s.userid WHERE f.feedbackid=? ORDER BY f.module_staff ASC LIMIT 1");
    $stmt3->bind_param('i', $feedbackToApprove);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($lecturer_feedback_to_email);
    $stmt3->fetch();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("SELECT s.email FROM user_feedback_received f LEFT JOIN user_signin s ON f.module_staff=s.userid WHERE f.feedbackid=? ORDER BY f.module_staff DESC LIMIT 1");
    $stmt4->bind_param('i', $feedbackToApprove);
    $stmt4->execute();
    $stmt4->store_result();
    $stmt4->bind_result($tutorial_assistant_feedback_to_email);
    $stmt4->fetch();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("SELECT feedback_from FROM user_feedback_received WHERE feedbackid = ? LIMIT 1");
    $stmt5->bind_param('i', $feedbackToApprove);
    $stmt5->execute();
    $stmt5->store_result();
    $stmt5->bind_result($feedback_from);
    $stmt5->fetch();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("SELECT s.email, d.firstname, d.surname FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid WHERE s.userid = ? LIMIT 1");
    $stmt6->bind_param('i', $feedback_from);
    $stmt6->execute();
    $stmt6->store_result();
    $stmt6->bind_result($feedback_from_email, $feedback_from_firstname, $feedback_from_surname);
    $stmt6->fetch();
    $stmt6->close();

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

    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    $headers .= "From: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";
    $headers .= "Reply-To: $feedback_from_firstname $feedback_from_surname <$feedback_from_email>" . "\r\n";

    mail("$lecturer_feedback_to_email, $tutorial_assistant_feedback_to_email", $subject, $message, $headers);
}

//SetFeedbackRead function
function SetFeedbackRead () {

    global $mysqli;
    global $session_userid;

    $isRead = 1;

    $stmt1 = $mysqli->prepare("UPDATE user_feedback_received SET isRead=? WHERE module_staff=?");
    $stmt1->bind_param('ii', $isRead, $session_userid);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteFeedback function
function DeleteFeedback () {

    global $mysqli;

    $feedbackToDelete = filter_input(INPUT_POST, 'feedbackToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedbackid=?");
    $stmt1->bind_param('i', $feedbackToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE feedbackid=?");
    $stmt2->bind_param('i', $feedbackToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback WHERE feedbackid=?");
    $stmt3->bind_param('i', $feedbackToDelete);
    $stmt3->execute();
    $stmt3->close();
}

//DeleteSentFeedback function
function DeleteSentFeedback () {

    global $mysqli;
    global $session_userid;

    $sentFeedbackToDelete = filter_input(INPUT_POST, 'sentFeedbackToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedbackid=? AND feedback_from=?");
    $stmt1->bind_param('ii', $sentFeedbackToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteReceivedFeedback function
function DeleteReceivedFeedback () {

    global $mysqli;
    global $session_userid;

    $receivedFeedbackToDelete = filter_input(INPUT_POST, 'receivedFeedbackToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_feedback_received WHERE feedbackid=? AND module_staff=?");
    $stmt1->bind_param('ii', $receivedFeedbackToDelete, $session_userid);
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

	$stmt1 = $mysqli->prepare("INSERT INTO user_message (message_subject, message_body, created_on) VALUES (?, ?, ?)");
	$stmt1->bind_param('sss', $message_subject, $message_body, $created_on);
	$stmt1->execute();
	$stmt1->close();

    $isRead = 0;

    $stmt2 = $mysqli->prepare("INSERT INTO user_message_sent (message_from, message_to) VALUES (?, ?)");
    $stmt2->bind_param('ii', $session_userid, $message_to_userid);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("INSERT INTO user_message_received (message_from, message_to, isRead) VALUES (?, ?, ?)");
    $stmt3->bind_param('iii', $session_userid, $message_to_userid, $isRead);
    $stmt3->execute();
    $stmt3->close();

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

	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

	$headers .= "From: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";
	$headers .= "Reply-To: $message_to_firstname $message_to_surname <$message_to_email>" . "\r\n";

	mail($message_to_email, $subject, $message, $headers);

}

//SetMessageRead function
function SetMessageRead () {

	global $mysqli;
	global $session_userid;

	$isRead = 1;
	$stmt1 = $mysqli->prepare("UPDATE user_message_received SET isRead=? WHERE message_to=?");
	$stmt1->bind_param('ii', $isRead, $session_userid);
	$stmt1->execute();
	$stmt1->close();
}

//DeleteReceivedMessage function
function DeleteReceivedMessage () {

    global $mysqli;
    global $session_userid;

    $receivedFeedbackToDelete = filter_input(INPUT_POST, 'receivedMessageToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_message_received WHERE messageid=? AND message_to=?");
    $stmt1->bind_param('ii', $receivedFeedbackToDelete, $session_userid);
    $stmt1->execute();
    $stmt1->close();

}

//DeleteSentMessage function
function DeleteSentMessage () {

    global $mysqli;
    global $session_userid;

    $sentMessageToDelete = filter_input(INPUT_POST, 'sentMessageToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE messageid=? AND message_from=?");
    $stmt1->bind_param('ii', $sentMessageToDelete, $session_userid);
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

    $gender = strtolower($gender);
    $nationality = strtolower($nationality);
	if ($dateofbirth == '') {
		$dateofbirth = NULL;
	} else {
        $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
        $dateofbirth = $dateofbirth->format('Y-m-d');
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

            $stmt2 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
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
            $headers  = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

            // Additional headers
            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            // Mail it
            mail($email, $subject, $message, $headers);

	    } else {

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

                $stmt4 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
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
                $headers  = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

                // Additional headers
                $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
                $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

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

    $old_password = filter_input(INPUT_POST, 'change_oldpwd', FILTER_SANITIZE_STRING);
	$new_password = filter_input(INPUT_POST, 'change_password', FILTER_SANITIZE_STRING);

    // Getting user login details
    $stmt1 = $mysqli->prepare("SELECT password FROM user_signin WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_password);
    $stmt1->fetch();

    if (password_verify($old_password, $db_password)) {
        if (password_verify($new_password, $db_password)) {
            $stmt1->close();
            header('HTTP/1.0 550 The new password you entered is your current password. Please enter a new password.');
            exit();
        } else {

            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            $stmt2 = $mysqli->prepare("UPDATE user_signin SET password=?, updated_on=? WHERE userid = ?");
            $stmt2->bind_param('ssi', $password_hash, $updated_on, $session_userid);
            $stmt2->execute();
            $stmt2->close();

            $stmt3 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ?");
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
            $headers  = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

            // Additional headers
            $headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
            $headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

            // Mail it
            mail($email, $subject, $message, $headers);

            $stmt1->close();
        }
    } else {
        $stmt1->close();
        header('HTTP/1.0 550 The old password you entered is incorrect.');
        exit();
    }
}

//PaypalPaymentSuccess function
function FeesPaypalPaymentSuccess() {

	global $mysqli;
	global $updated_on;
	global $completed_on;

    $invoiceid = $_POST["invoice"];
	$transactionid  = $_POST["txn_id"];
	$payment_status = $_POST["payment_status"];
    $payment_status = strtolower($payment_status);
	$payment_status1 = ($_POST["payment_status"]);
	$payment_date = date('H:i d/m/Y', strtotime($_POST["payment_date"]));

	$product_name = $_POST["item_name1"];
	$product_amount = $_POST["mc_gross"];

	$stmt1 = $mysqli->prepare("SELECT userid FROM paypal_log WHERE invoiceid = ? LIMIT 1");
	$stmt1->bind_param('i', $invoiceid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid);
	$stmt1->fetch();
	$stmt1->close();

	$stmt2 = $mysqli->prepare("SELECT s.email, d.firstname, d.surname, f.isHalf FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid LEFT JOIN user_fee f ON s.userid=f.userid WHERE s.userid = ? LIMIT 1");
	$stmt2->bind_param('i', $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($email, $firstname, $surname, $isHalf);
	$stmt2->fetch();
	$stmt2->close();

	if ($product_name == 'Full fees') {

        $fee_amount = 0.00;
        $updated_on = date("Y-m-d G:i:s");

        $stmt3 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
        $stmt3->bind_param('isi', $fee_amount, $updated_on, $userid);
        $stmt3->execute();
        $stmt3->close();

	} else {

        if ($product_name == 'Half fees' AND $isHalf == '0') {

            $isHalf = 1;

            $stmt4 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, isHalf=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt4->bind_param('iisi', $product_amount, $isHalf, $updated_on, $userid);
            $stmt4->execute();
            $stmt4->close();

        } elseif ($product_name == 'Half fees' AND $isHalf == '1') {

            $fee_amount = 0.00;
            $updated_on = date("Y-m-d G:i:s");

            $stmt5 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=? LIMIT 1");
            $stmt5->bind_param('isi', $fee_amount, $updated_on, $userid);
            $stmt5->execute();
            $stmt5->close();

	    }
    }

	$stmt6 = $mysqli->prepare("UPDATE paypal_log SET transactionid=?, payment_status=?, updated_on=?, completed_on=? WHERE invoiceid =?");
	$stmt6->bind_param('ssssi', $transactionid, $payment_status, $updated_on, $completed_on, $invoiceid);
	$stmt6->execute();
	$stmt6->close();

	//subject
	$subject = 'Payment confirmation';

	//message
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

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

	// Additional headers
	$headers .= 'From: Student Portal <admin@student-portal.co.uk>'."\r\n";
	$headers .= 'Reply-To: Student Portal <admin@student-portal.co.uk>'."\r\n";

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

	$stmt5 = $mysqli->prepare("UPDATE paypal_log SET payment_status = ?, updated_on=?, cancelled_on=? WHERE userid = ? ORDER BY paymentid DESC LIMIT 1");
	$stmt5->bind_param('sssi', $payment_status, $updated_on, $cancelled_on, $session_userid);
	$stmt5->execute();
	$stmt5->close();
}

//DeleteAccount function
function DeleteAccount() {

	global $mysqli;

    $accountToDelete = filter_input(INPUT_POST, 'accountToDelete', FILTER_SANITIZE_STRING);

    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE message_from = ?");
    $stmt1->bind_param('i', $accountToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_message_received WHERE message_to = ?");
    $stmt2->bind_param('i', $accountToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedback_from = ?");
    $stmt3->bind_param('i', $accountToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM user_timetable WHERE userid = ?");
    $stmt4->bind_param('i', $accountToDelete);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM user_result WHERE userid = ?");
    $stmt5->bind_param('i', $accountToDelete);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE userid = ?");
    $stmt6->bind_param('i', $accountToDelete);
    $stmt6->execute();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("DELETE FROM system_event_booked WHERE userid = ?");
    $stmt7->bind_param('i', $accountToDelete);
    $stmt7->execute();
    $stmt7->close();

    $stmt8 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
    $stmt8->bind_param('i', $accountToDelete);
    $stmt8->execute();
    $stmt8->close();

	session_unset();
	session_destroy();

    SignOut();
}

//////////////////////////////////////////////////////////////////////////

//Admin account functions
//CreateAnAccount function
function CreateAnAccount() {

    global $mysqli;
    global $created_on;

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

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('HTTP/1.0 550 The email address you entered is invalid.');
        exit();

    } else {

        // Check existing studentno
        $stmt1 = $mysqli->prepare("SELECT userid FROM user_detail WHERE studentno = ? AND NOT studentno = '0' LIMIT 1");
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
            $stmt2->close();
            header('HTTP/1.0 550 An account with the email address entered already exists.');
            exit();
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
        } else {
            $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
            $dateofbirth = $dateofbirth->format('Y-m-d');
        }

        $gender = strtolower($gender);
        $nationality = strtolower($nationality);
        $user_status = 'active';

        $stmt5 = $mysqli->prepare("INSERT INTO user_detail (firstname, surname, gender, studentno, degree, nationality, dateofbirth, phonenumber, address1, address2, town, city, country, postcode, user_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param('sssissssssssssss', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $user_status, $created_on);
        $stmt5->execute();
        $stmt5->close();

        $token = null;

        $stmt6 = $mysqli->prepare("INSERT INTO user_token (token) VALUES (?)");
        $stmt6->bind_param('s', $token);
        $stmt6->execute();
        $stmt6->close();

        if ($account_type == 'academic staff') {
            $fee_amount = '0.00';
        }
        elseif ($account_type == 'administrator') {
            $fee_amount = '0.00';
        }

        $stmt7 = $mysqli->prepare("INSERT INTO user_fee (fee_amount, created_on) VALUES (?, ?)");
        $stmt7->bind_param('is', $fee_amount, $created_on);
        $stmt7->execute();
        $stmt7->close();
    }
}

//UpdateAnAccount function
function UpdateAnAccount() {

    global $mysqli;
    global $updated_on;

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

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('HTTP/1.0 550 The email address you entered is invalid.');
		exit();
	} else {

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

            $gender = strtolower($gender);
            $nationality = strtolower($nationality);

            if ($dateofbirth == '') {
                $dateofbirth = NULL;
            } else {
                $dateofbirth = DateTime::createFromFormat('d/m/Y', $dateofbirth);
                $dateofbirth = $dateofbirth->format('Y-m-d');
            }

            $stmt3 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=?  WHERE userid = ?");
            $stmt3->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
            $stmt3->execute();
            $stmt3->close();

            if ($account_type == 'lecturer') {
                $fee_amount = '0.00';
            }
            elseif ($account_type == 'admin') {
                $fee_amount = '0.00';
            }

            $stmt4 = $mysqli->prepare("UPDATE user_fee SET fee_amount=?, updated_on=? WHERE userid=?");
            $stmt4->bind_param('isi', $fee_amount, $updated_on, $userid);
            $stmt4->execute();
            $stmt4->close();

	    } else {

            $stmt5 = $mysqli->prepare("SELECT userid from user_signin where email = ?");
            $stmt5->bind_param('s', $email);
            $stmt5->execute();
            $stmt5->store_result();
            $stmt5->bind_result($db_userid);
            $stmt5->fetch();

            if ($stmt5->num_rows == 1) {
                $stmt5->close();
                header('HTTP/1.0 550 An account with the e-mail address entered already exists.');
                exit();

            }  else {

                $stmt6 = $mysqli->prepare("UPDATE user_signin SET account_type=?, email=?, updated_on=? WHERE userid = ?");
                $stmt6->bind_param('sssi', $account_type, $email, $updated_on, $userid);
                $stmt6->execute();
                $stmt6->close();

                $stmt7 = $mysqli->prepare("UPDATE user_detail SET firstname=?, surname=?, gender=?, studentno=?, degree=?, nationality=?, dateofbirth=?, phonenumber=?, address1=?, address2=?, town=?, city=?, country=?, postcode=?, updated_on=? WHERE userid=?");
                $stmt7->bind_param('sssisssssssssssi', $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode, $updated_on, $userid);
                $stmt7->execute();
                $stmt7->close();

                if ($account_type == 'lecturer') {
                    $fee_amount = '0.00';
                } elseif ($account_type == 'admin') {
                    $fee_amount = '0.00';
                }

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

//DeactivateUser function
function DeactivateUser() {

    global $mysqli;
    global $updated_on;

    $userToDeactivate = filter_input(INPUT_POST, 'userToDeactivate', FILTER_SANITIZE_NUMBER_INT);

    $user_status = 'inactive';

    $stmt1 = $mysqli->prepare("UPDATE user_detail SET user_status=?, updated_on=? WHERE userid = ?");
    $stmt1->bind_param('ssi', $user_status, $updated_on, $userToDeactivate);
    $stmt1->execute();
    $stmt1->close();
}

//ReactivateUser function
function ReactivateUser() {

    global $mysqli;
    global $updated_on;

    $userToReactivate = filter_input(INPUT_POST, 'userToReactivate', FILTER_SANITIZE_NUMBER_INT);

    $user_status = 'active';

    $stmt1 = $mysqli->prepare("UPDATE user_detail SET user_status=?, updated_on=? WHERE userid = ?");
    $stmt1->bind_param('ssi', $user_status, $updated_on, $userToReactivate);
    $stmt1->execute();
    $stmt1->close();
}

//DeleteUser function
function DeleteUser() {

    global $mysqli;

    $userToDelete = filter_input(INPUT_POST, 'userToDelete', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("DELETE FROM user_message_sent WHERE message_from = ?");
    $stmt1->bind_param('i', $userToDelete);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM user_message_received WHERE message_to = ?");
    $stmt2->bind_param('i', $userToDelete);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM user_feedback_sent WHERE feedback_from = ?");
    $stmt3->bind_param('i', $userToDelete);
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM user_module WHERE userid = ?");
    $stmt4->bind_param('i', $userToDelete);
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM user_lecture WHERE userid = ?");
    $stmt5->bind_param('i', $userToDelete);
    $stmt5->execute();
    $stmt5->close();

    $stmt6 = $mysqli->prepare("DELETE FROM user_tutorial WHERE userid = ?");
    $stmt6->bind_param('i', $userToDelete);
    $stmt6->execute();
    $stmt6->close();

    $stmt7 = $mysqli->prepare("DELETE FROM user_exam WHERE userid = ?");
    $stmt7->bind_param('i', $userToDelete);
    $stmt7->execute();
    $stmt7->close();

    $stmt8 = $mysqli->prepare("DELETE FROM user_result WHERE userid = ?");
    $stmt8->bind_param('i', $userToDelete);
    $stmt8->execute();
    $stmt8->close();

    $stmt9 = $mysqli->prepare("DELETE FROM system_book_reserved WHERE userid = ?");
    $stmt9->bind_param('i', $userToDelete);
    $stmt9->execute();
    $stmt9->close();

    $stmt10 = $mysqli->prepare("DELETE FROM system_event_booked WHERE userid = ?");
    $stmt10->bind_param('i', $userToDelete);
    $stmt10->execute();
    $stmt10->close();

    $stmt11 = $mysqli->prepare("DELETE FROM user_signin WHERE userid = ?");
    $stmt11->bind_param('i', $userToDelete);
    $stmt11->execute();
    $stmt11->close();
}

/////////////////////////////////////////////////////////////////////////////////////////////
