<?php
include 'session.php';
include 'functions.php';

//Call SignIn function
if (isset($_POST['email'], $_POST['password'])) {
	SignIn();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Register function
//Call RegisterUser function
if(isset($_POST["firstname"], $_POST["surname"], $_POST["gender"], $_POST["email1"], $_POST["password1"])) {
	RegisterUser();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Forgotten Password/Password Reset functions
//Call SendPasswordToken function
if (isset($_POST["email2"])) {
	SendPasswordToken();
}

//Call ResetPassword function
elseif (isset($_POST["token"], $_POST["email3"], $_POST["password2"])) {
	ResetPassword();
}

/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////

//Call Account functions
//Call UpdateAccount function
elseif (isset($_POST['module_name'],
              $_POST['module_notes'],
              $_POST['module_url'],
              $_POST['lecture_lecturer'],
              $_POST['lecture_notes'],
              $_POST['lecture_day'],
              $_POST['lecture_from_time'],
              $_POST['lecture_to_time'],
              $_POST['lecture_from_date'],
              $_POST['lecture_to_date'],
              $_POST['lecture_location'],
              $_POST['lecture_capacity'],
              $_POST['tutorial_name'],
              $_POST['tutorial_assistant'],
              $_POST['tutorial_notes'],
              $_POST['tutorial_day'],
              $_POST['tutorial_from_time'],
              $_POST['tutorial_to_time'],
              $_POST['tutorial_from_date'],
              $_POST['tutorial_to_date'],
              $_POST['tutorial_location'],
              $_POST['tutorial_capacity'])) {
    CreateTimetable();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Account functions
//Call UpdateAccount function
elseif (isset($_POST['firstname1'], $_POST['surname1'], $_POST['gender1'], $_POST['email4'], $_POST['nationality'], $_POST['dateofbirth'], $_POST['phonenumber'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['city'], $_POST['country'], $_POST['postcode'])) {
	UpdateAccount();
}

//Call ChangePassword function
elseif (isset($_POST["password3"])) {
	ChangePassword();
}

//Call DeleteAccount function
elseif (isset($_POST['deleteaccount_button'])) {
	DeleteAccount();
}

///////////////////////////////////////////////////////////

//Call Calendar functions
//Call CreateTask function
elseif (isset($_POST['task_name'], $_POST['task_notes'], $_POST['task_url'], $_POST['task_startdate'], $_POST['task_duedate'], $_POST['task_category'])) {
	CreateTask();
}

//Call UpdateTask function
elseif (isset($_POST['taskid'], $_POST['task_name1'], $_POST['task_notes1'], $_POST['task_url1'], $_POST['task_startdate1'], $_POST['task_duedate1'], $_POST['task_category1'])) {
	UpdateTask();
}

//Call CompleteTask function
elseif (isset($_POST["recordToComplete"])) {
	CompleteTask();
}

/////////////////////////////////////////////////////////////

//Call EventsQuantityCheck function
elseif (isset($_POST["eventid"], $_POST["product_quantity"])) {
	EventsQuantityCheck();
}

/////////////////////////////////////////////////////////////

//Call ReserveBook function
elseif (isset($_POST["bookid"], $_POST["book_name"], $_POST["book_author"], $_POST["book_notes"], $_POST["bookreserved_from"], $_POST["bookreserved_to"])) {
	ReserveBook();
}

//////////////////////////////////////////////////////////////

//Call ContactUs function
elseif (isset($_POST["firstname4"], $_POST["surname4"], $_POST["email7"], $_POST["message"])) {
	ContactUs();
}

///////////////////////////////////////////////////////////////////////////////////////////////////

//Call Admin Account functions
//Call CreateAnAccount function
elseif (isset($_POST['account_type'], $_POST['firstname2'], $_POST['surname2'], $_POST['gender2'], $_POST['studentno'], $_POST['degree'], $_POST['email5'], $_POST['password4'], $_POST['nationality1'], $_POST['dateofbirth1'], $_POST['phonenumber1'], $_POST['address11'], $_POST['address21'], $_POST['town1'], $_POST['city1'], $_POST['country1'], $_POST['postcode1'])) {
	CreateAnAccount();
}

//Call UpdateAnAccount function
elseif (isset($_POST['userid'], $_POST['account_type1'], $_POST['firstname3'], $_POST['surname3'], $_POST['gender3'], $_POST['email6'], $_POST['studentno1'], $_POST['degree1'], $_POST['nationality2'], $_POST['dateofbirth2'], $_POST['phonenumber2'], $_POST['address12'], $_POST['address22'], $_POST['town2'], $_POST['city2'], $_POST['country2'], $_POST['postcode2'])) {
	UpdateAnAccount();
}

//Call ChangeAccountPassword function
elseif (isset($_POST["userid1"], $_POST["password5"])) {
	ChangeAccountPassword();
}

//Call DeleteAnAccount function
elseif (isset($_POST["recordToDelete"])) {
	DeleteAnAccount();
}

////////////////////////////////////////////////////////////

//Call MessageUser function
elseif (isset($_POST["userid2"], $_POST["firstname5"], $_POST["surname5"], $_POST["email8"], $_POST["subject"], $_POST["message1"])) {
	MessageUser();
}

//Call SetMessageRead function
elseif (isset($_POST["message_read"])) {
	SetMessageRead();
}

