<?php
include 'signin.php';
include 'functions.php';

//Call Account functions
//Call UpdateAccount function
if (isset($_POST['gender'], $_POST['firstname'], $_POST['surname'], $_POST['dateofbirth'], $_POST['email'], $_POST['phonenumber'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['city'], $_POST['country'], $_POST['postcode'], $_POST['degree'])) {
	UpdateAccount();
}

//Call ChangePassword function
elseif (isset($_POST["password"], $_POST["confirmpwd"])) {
	ChangePassword();
}

//Call DeleteAccount function
elseif (isset($_POST['deleteaccount_button'])) {
	DeleteAccount();
}

///////////////////////////////////////////////////////////

//Call Admin Account functions
//Call CreateAnAccount function
if (isset($_POST['account_type1'], $_POST['gender1'], $_POST['firstname1'], $_POST['surname1'], $_POST['studentno1'], $_POST['email1'], $_POST['password1'], $_POST['confirmpwd1'], $_POST['dateofbirth1'], $_POST['phonenumber1'], $_POST['degree1'], $_POST['address11'], $_POST['address21'], $_POST['town1'], $_POST['city1'], $_POST['country1'], $_POST['postcode1'])) {
	CreateAnAccount();
}

//Call UpdateAnAccount function
elseif (isset($_POST['userid1'], $_POST['firstname2'], $_POST['surname2'], $_POST['gender2'], $_POST['dateofbirth2'], $_POST['studentno2'], $_POST['degree2'], $_POST['email2'], $_POST['phonenumber2'], $_POST['address12'], $_POST['address22'], $_POST['town2'], $_POST['city2'], $_POST['country2'], $_POST['postcode2'])) {
	UpdateAnAccount();
}

//Call ChangeAccountPassword function
elseif (isset($_POST["userid2"], $_POST["password2"], $_POST["confirmpwd2"])) {
	ChangeAccountPassword();
}

//Call DeleteAnAccount function
elseif (isset($_POST["recordToDelete"])) {
	DeleteAnAccount();
}

////////////////////////////////////////////////////////////

//Call Calendar functions
//Call CreateTask function
if (isset($_POST['taskid'], $_POST['task_name'], $_POST['task_notes'], $_POST['task_url'], $_POST['task_startdate'], $_POST['task_duedate'], $_POST['task_category'])) {
	CreateTask();
}

//Call UpdateTask function
else if (isset($_POST['taskid1'], $_POST['task_name1'], $_POST['task_notes1'], $_POST['task_url1'], $_POST['task_startdate1'], $_POST['task_duedate1'], $_POST['task_category1'])) {
	UpdateTask();
}

//Call CompleteTask function
elseif (isset($_POST["recordToComplete"])) {
	CompleteTask();
}
