<?php
include 'session.php';
include 'functions.php';

//Call External functions
//Call ContactUs function
if (isset($_POST["firstname4"], $_POST["surname4"], $_POST["email7"], $_POST["message"])) {
    ContactUs();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

//Call SignIn function
elseif (isset($_POST['email'], $_POST['password'])) {
	SignIn();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Register function
//Call RegisterUser function
elseif(isset($_POST["firstname"], $_POST["surname"], $_POST["gender"], $_POST["email1"], $_POST["password1"])) {
	RegisterUser();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Forgotten Password/Password Reset functions
//Call SendPasswordToken function
elseif (isset($_POST["email2"])) {
	SendPasswordToken();
}

//Call ResetPassword function
elseif (isset($_POST["rp_token"], $_POST["rp_email"], $_POST["rp_password"])) {
	ResetPassword();
}

/////////////////////////////////////////////////////////////////////////////////////////////////

//Call Timetable functions
//Call CreateModule function
elseif (isset(
    $_POST['create_module_name'],
    $_POST['create_module_notes'],
    $_POST['create_module_url'])) {
    CreateModule();
}

//Call CreateLecture function
elseif (isset(
    $_POST['create_lecture_moduleid'],
    $_POST['create_lecture_name'],
    $_POST['create_lecture_lecturer'],
    $_POST['create_lecture_notes'],
    $_POST['create_lecture_day'],
    $_POST['create_lecture_from_time'],
    $_POST['create_lecture_to_time'],
    $_POST['create_lecture_from_date'],
    $_POST['create_lecture_to_date'],
    $_POST['create_lecture_location'],
    $_POST['create_lecture_capacity'])) {
    CreateLecture();
}

//Call CreateTutorial function
elseif (isset(
    $_POST['create_tutorial_moduleid'],
    $_POST['create_tutorial_name'],
    $_POST['create_tutorial_assistant'],
    $_POST['create_tutorial_notes'],
    $_POST['create_tutorial_day'],
    $_POST['create_tutorial_from_time'],
    $_POST['create_tutorial_to_time'],
    $_POST['create_tutorial_from_date'],
    $_POST['create_tutorial_to_date'],
    $_POST['create_tutorial_location'],
    $_POST['create_tutorial_capacity'])) {
    CreateTutorial();
}

//Call UpdateModule function
elseif (isset(
    $_POST['update_moduleid'],
    $_POST['update_module_name'],
    $_POST['update_module_notes'],
    $_POST['update_module_url'])) {
    UpdateModule();
}

//Call UpdateLecture function
elseif (isset(
    $_POST['update_lecture_moduleid'],
    $_POST['update_lectureid'],
    $_POST['update_lecture_name'],
    $_POST['update_lecture_lecturer'],
    $_POST['update_lecture_notes'],
    $_POST['update_lecture_day'],
    $_POST['update_lecture_from_time'],
    $_POST['update_lecture_to_time'],
    $_POST['update_lecture_from_date'],
    $_POST['update_lecture_to_date'],
    $_POST['update_lecture_location'],
    $_POST['update_lecture_capacity'])) {
    UpdateLecture();
}

//Call UpdateTutorial function
elseif (isset(
    $_POST['update_tutorial_moduleid'],
    $_POST['update_tutorialid'],
    $_POST['update_tutorial_name'],
    $_POST['update_tutorial_assistant'],
    $_POST['update_tutorial_notes'],
    $_POST['update_tutorial_day'],
    $_POST['update_tutorial_from_time'],
    $_POST['update_tutorial_to_time'],
    $_POST['update_tutorial_from_date'],
    $_POST['update_tutorial_to_date'],
    $_POST['update_tutorial_location'],
    $_POST['update_tutorial_capacity'])) {
    UpdateTutorial();
}

//Call DeactivateModule function
elseif (isset($_POST['moduleToDeactivate'])) {
    DeactivateModule();
}

//Call DeactivateLecture function
elseif (isset($_POST['lectureToDeactivate'])) {
    DeactivateLecture();
}

//Call DeactivateTutorial function
elseif (isset($_POST['tutorialToDeactivate'])) {
    DeactivateTutorial();
}

//Call ReactivateModule function
elseif (isset($_POST['moduleToReactivate'])) {
    ReactivateModule();
}

//Call ReactivateLecture function
elseif (isset($_POST['lectureToReactivate'])) {
    ReactivateLecture();
}

//Call ReactivateTutorial function
elseif (isset($_POST['tutorialToReactivate'])) {
    ReactivateTutorial();
}

//Call DeleteModule function
elseif (isset($_POST['moduleToDelete'])) {
    DeleteModule();
}

//Call DeleteLecture function
elseif (isset($_POST['lectureToDelete'])) {
    DeleteLecture();
}

//Call DeleteTutorial function
elseif (isset($_POST['tutorialToDelete'])) {
    DeleteTutorial();
}

//Call AllocateModule function
elseif (isset($_POST["userToAllocate"], $_POST["moduleToAllocate"])) {
    AllocateModule();
}

//Call AllocateLecture function
elseif (isset($_POST["userToAllocate"], $_POST["lectureToAllocate"])) {
    AllocateLecture();
}

//Call AllocateTutorial function
elseif (isset($_POST["userToAllocate"], $_POST["tutorialToAllocate"])) {
    AllocateTutorial();
}

//Call DeallocateModule function
elseif (isset($_POST["userToDeallocate"], $_POST["moduleToDeallocate"])) {
    DeallocateModule();
}

//Call DeallocateModule function
elseif (isset($_POST["userToDeallocate"], $_POST["moduleToDeallocate"])) {
    DeallocateLecture();
}

//Call DeallocateModule function
elseif (isset($_POST["userToDeallocate"], $_POST["tutorialToDeallocate"])) {
    DeallocateTutorial();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Exams functions
//Call CreateExam function
elseif (isset(
    $_POST['create_exam_moduleid'],
    $_POST['create_exam_name'],
    $_POST['create_exam_notes'],
    $_POST['create_exam_date'],
    $_POST['create_exam_time'],
    $_POST['create_exam_location'],
    $_POST['create_exam_capacity'])) {
    CreateExam();
}

//Call UpdateExam function
elseif (isset(
    $_POST['update_exam_moduleid'],
    $_POST['update_examid'],
    $_POST['update_exam_name'],
    $_POST['update_exam_notes'],
    $_POST['update_exam_date'],
    $_POST['update_exam_time'],
    $_POST['update_exam_location'],
    $_POST['update_exam_capacity'])) {
    UpdateExam();
}

//Call DeactivateExam function
elseif (isset($_POST['examToDeactivate'])) {
    DeactivateExam();
}

//Call ReactivateExam function
elseif (isset($_POST['examToReactivate'])) {
    ReactivateExam();
}

//Call DeleteExam function
elseif (isset($_POST['examToDelete'])) {
    DeleteExam();
}

//Call AllocateExam function
elseif (isset($_POST['examToAllocate'])) {
    AllocateExam();
}

//Call DeallocateExam function
elseif (isset($_POST['examToDeallocate'])) {
    DeallocateExam();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Results functions
//Call CreateResult function
elseif (isset($_POST["result_userid"], $_POST["result_moduleid"], $_POST["result_coursework_mark"], $_POST["result_exam_mark"], $_POST["result_overall_mark"], $_POST["result_notes"])) {
    CreateResult();
}

//Call UpdateResult function
elseif (isset($_POST["result_resultid"], $_POST["result_coursework_mark1"], $_POST["result_exam_mark1"], $_POST["result_overall_mark1"], $_POST["result_notes1"])) {
    UpdateResult();
}

//Call DeactivateResult function
elseif (isset($_POST["resultToDeactivate"])) {
    DeactivateResult();
}

//Call ReactivateResult function
elseif (isset($_POST["resultToReactivate"])) {
    ReactivateResult();
}

//Call DeleteResult function
elseif (isset($_POST["resultToDelete"])) {
    DeleteResult();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Library functions
//Call ReserveBook function
elseif (isset($_POST["bookid"], $_POST["book_name"], $_POST["book_author"], $_POST["book_notes"])) {
    ReserveBook();
}

//Call RequestBook function
elseif (isset($_POST["bookToRequest"])) {
    RequestBook();
}

//Call SetMessageRead function
elseif (isset($_POST["request_read"])) {
    SetRequestRead();
}

//Call ApproveRequest function
elseif (isset($_POST["requestToApprove"])) {
    ApproveRequest();
}

//Call CollectBook function
elseif (isset($_POST["bookToCollect"])) {
    CollectBook();
}

//Call ReturnBook function
elseif (isset($_POST["bookToReturn"])) {
    ReturnBook();
}

//Call CreateBook function
elseif (isset(
    $_POST['create_book_name'],
    $_POST['create_book_notes'],
    $_POST['create_book_author'],
    $_POST['create_book_copy_no'],
    $_POST['create_book_location'],
    $_POST['create_book_publisher'],
    $_POST['create_book_publish_date'],
    $_POST['create_book_publish_place'],
    $_POST['create_book_page_amount'],
    $_POST['create_book_barcode'],
    $_POST['create_book_discipline'],
    $_POST['create_book_language'])) {
    CreateBook();
}

//Call UpdateBook function
elseif (isset(
    $_POST['update_bookid'],
    $_POST['update_book_name'],
    $_POST['update_book_notes'],
    $_POST['update_book_author'],
    $_POST['update_book_copy_no'],
    $_POST['update_book_location'],
    $_POST['update_book_publisher'],
    $_POST['update_book_publish_date'],
    $_POST['update_book_publish_place'],
    $_POST['update_book_page_amount'],
    $_POST['update_book_barcode'],
    $_POST['update_book_discipline'],
    $_POST['update_book_language'])) {
    UpdateBook();
}

//Call DeactivateBook function
elseif (isset($_POST["bookToDeactivate"])) {
    DeactivateBook();
}

//Call ReactivateBook function
elseif (isset($_POST["bookToReactivate"])) {
    ReactivateBook();
}

//Call DeleteBook function
elseif (isset($_POST["bookToDelete"])) {
    DeleteBook();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

//Call Calendar functions
//Call CreateTask function
elseif (isset(
    $_POST['create_task_name'],
    $_POST['create_task_notes'],
    $_POST['create_task_url'],
    $_POST['create_task_startdate'],
    $_POST['create_task_duedate'])) {
    CreateTask();
}

//Call UpdateTask function
elseif (isset(
    $_POST['update_taskid'],
    $_POST['update_task_name'],
    $_POST['update_task_notes'],
    $_POST['update_task_url'],
    $_POST['update_task_startdate'],
    $_POST['update_task_duedate'])) {
    UpdateTask();
}

//Call CompleteTask function
elseif (isset($_POST["taskToComplete"])) {
    CompleteTask();
}

//Call DeactivateTask function
elseif (isset($_POST["taskToDeactivate"])) {
    DeactivateTask();
}

//Call ReactivateTask function
elseif (isset($_POST["taskToReactivate"])) {
    ReactivateTask();
}

//Call DeleteTask function
elseif (isset($_POST["taskToDelete"])) {
    DeleteTask();
}

/////////////////////////////////////////////////////////////

//Call Events functions
//Call EventsQuantityCheck function
elseif (isset($_POST["eventid"], $_POST["product_quantity"])) {
    EventTicketQuantityCheck();
}

//Call CreateEvent function
elseif (isset(
    $_POST['event_name'],
    $_POST['event_notes'],
    $_POST['event_url'],
    $_POST['event_from'],
    $_POST['event_to'],
    $_POST['event_amount'],
    $_POST['event_ticket_no'],
    $_POST['event_category'])) {
    CreateEvent();
}

//Call UpdateEvent function
elseif (isset(
    $_POST['eventid1'],
    $_POST['event_name1'],
    $_POST['event_notes1'],
    $_POST['event_url1'],
    $_POST['event_from1'],
    $_POST['event_to1'],
    $_POST['event_amount1'],
    $_POST['event_ticket_no1'],
    $_POST['event_category1'])) {
    UpdateEvent();
}

//Call DeactivateEvent function
elseif (isset($_POST["eventToDeactivate"])) {
    DeactivateEvent();
}

//Call ReactivateEvent function
elseif (isset($_POST["eventToReactivate"])) {
    ReactivateEvent();
}

//Call DeleteEvent function
elseif (isset($_POST["eventToDelete"])) {
    DeleteEvent();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

//Call University map functions
//Call CreateLocation function
elseif (isset(
    $_POST['marker_name'],
    $_POST['marker_notes'],
    $_POST['marker_url'],
    $_POST['marker_lat'],
    $_POST['marker_long'],
    $_POST['marker_category'])) {
    CreateLocation();
}

//Call UpdateLocation function
elseif (isset(
    $_POST['markerid'],
    $_POST['marker_name1'],
    $_POST['marker_notes1'],
    $_POST['marker_url1'],
    $_POST['marker_lat1'],
    $_POST['marker_long1'],
    $_POST['marker_category1'])) {
    UpdateLocation();
}


//Call DeactivateLocation function
elseif (isset($_POST["locationToDeactivate"])) {
    DeactivateLocation();
}

//Call ReactivateLocation function
elseif (isset($_POST["locationToReactivate"])) {
    ReactivateLocation();
}

//Call DeleteLocation function
elseif (isset($_POST["locationToDelete"])) {
    DeleteLocation();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////

//Call Feedback functions
//Call SubmitFeedback functions
elseif (isset($_POST["feedback_moduleid"], $_POST["feedback_lecturer"], $_POST["feedback_tutorial_assistant"], $_POST["feedback_from_firstname"], $_POST["feedback_from_surname"], $_POST["feedback_from_email"], $_POST["lecturer_feedback_to_email"], $_POST["tutorial_assistant_feedback_to_email"], $_POST["feedback_subject"], $_POST["feedback_body"])) {
    SubmitFeedback();
}

//Call ApproveFeedback function
elseif (isset($_POST["feedbackToApprove"])) {
    ApproveFeedback();
}

//Call SetFeedbackRead function
elseif (isset($_POST["feedback_read"])) {
    SetFeedbackRead();
}

//Call DeleteFeedback function
elseif (isset($_POST["feedbackToDelete"])) {
    DeleteFeedback();
}

//Call DeleteSentFeedback function
elseif (isset($_POST["sentFeedbackToDelete"])) {
    DeleteSentFeedback();
}

//Call DeleteReceivedFeedback function
elseif (isset($_POST["receivedFeedbackToDelete"])) {
    DeleteReceivedFeedback();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

//Call Messenger functions
//Call MessageUser functions
elseif (isset($_POST["message_to_userid"], $_POST["message_to_firstname"], $_POST["message_to_surname"], $_POST["message_to_email"], $_POST["message_subject"], $_POST["message_body"])) {
    MessageUser();
}

//Call SetMessageRead function
elseif (isset($_POST["message_read"])) {
    SetMessageRead();
}

//Call DeleteReceivedMessage function
elseif (isset($_POST["receivedMessageToDelete"])) {
    DeleteReceivedMessage();
}
//Call DeleteSentMessage function
elseif (isset($_POST["sentMessageToDelete"])) {
    DeleteSentMessage();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

//Call Account functions
//Call UpdateAccount function
elseif (isset($_POST['firstname1'], $_POST['surname1'], $_POST['gender1'], $_POST['email4'], $_POST['nationality'], $_POST['dateofbirth'], $_POST['phonenumber'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['city'], $_POST['country'], $_POST['postcode'])) {
	UpdateAccount();
}

//Call ChangePassword function
elseif (isset($_POST["change_oldpwd"], $_POST["change_password"])) {
	ChangePassword();
}

//Call DeactivateAccount function
elseif (isset($_POST['userToDeactivate'])) {
    DeactivateUser();
}

//Call ReactivateAccount function
elseif (isset($_POST['userToReactivate'])) {
    ReactivateUser();
}

//Call DeleteAccount function
elseif (isset($_POST['accountToDelete'])) {
	DeleteAccount();
}

///////////////////////////////////////////////////////////////////////////////////////////////////

//Call Admin Account functions
//Call CreateAnAccount function
elseif (isset(
    $_POST['create_account_account_type'],
    $_POST['create_account_firstname'],
    $_POST['create_account_surname'],
    $_POST['create_account_gender'],
    $_POST['create_account_studentno'],
    $_POST['create_account_degree'],
    $_POST['create_account_fee_amount'],
    $_POST['create_account_email'],
    $_POST['create_account_password'],
    $_POST['create_account_nationality'],
    $_POST['create_account_dateofbirth'],
    $_POST['create_account_phonenumber'],
    $_POST['create_account_address1'],
    $_POST['create_account_address2'],
    $_POST['create_account_town'],
    $_POST['create_account_city'],
    $_POST['create_account_country'],
    $_POST['create_account_postcode'])) {
	CreateAnAccount();
}

//Call UpdateAnAccount function
elseif (isset(
    $_POST['update_account_userid'],
    $_POST['update_account_account_type'],
    $_POST['update_account_firstname'],
    $_POST['update_account_surname'],
    $_POST['update_account_gender'],
    $_POST['update_account_email'],
    $_POST['update_account_studentno'],
    $_POST['update_account_degree'],
    $_POST['update_account_fee_amount'],
    $_POST['update_account_nationality'],
    $_POST['update_account_dateofbirth'],
    $_POST['update_account_phonenumber'],
    $_POST['update_account_address1'],
    $_POST['update_account_address2'],
    $_POST['update_account_town'],
    $_POST['update_account_city'],
    $_POST['update_account_country'],
    $_POST['update_account_postcode'])) {
	UpdateAnAccount();
}

//Call ChangeAccountPassword function
elseif (isset($_POST["userid1"], $_POST["password5"])) {
	ChangeAccountPassword();
}

//Call DeleteAnAccount function
elseif (isset($_POST["userToDelete"])) {
	DeleteUser();
}

////////////////////////////////////////////////////////////

