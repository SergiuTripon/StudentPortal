<?php
include 'signin.php';
include 'functions.php';

//Call SignIn function
if (isset($_POST['email'], $_POST['password'])) {
	SignIn();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Register function
//Call RegisterUser function
if(isset($_POST["gender1"], $_POST["firstname1"], $_POST["surname1"], $_POST["studentno1"], $_POST["email1"], $_POST["password1"], $_POST["confirmpwd1"])) {
	RegisterUser();
}

//////////////////////////////////////////////////////////////////////////////////////////////////

//Call Forgotten Password/Password Reset functions
//Call SendPasswordToken function
if (isset($_POST["email3"])) {
	SendPasswordToken();
}

//Call ResetPassword function
elseif (isset($_POST["toke4"], $_POST["email4"], $_POST["password4"], $_POST["confirmpwd4"])) {
	ResetPassword();
}

/////////////////////////////////////////////////////////////////////////////////////////////////

//Call Account functions
//Call UpdateAccount function
elseif (isset($_POST['gender5'], $_POST['firstname5'], $_POST['surname5'], $_POST['dateofbirth5'], $_POST['email5'], $_POST['phonenumber5'], $_POST['address5'], $_POST['address5'], $_POST['town5'], $_POST['city5'], $_POST['country5'], $_POST['postcode5'], $_POST['degree5'])) {
	UpdateAccount();
}

//Call ChangePassword function
elseif (isset($_POST["password6"], $_POST["confirmpwd6"])) {
	ChangePassword();
}

//Call DeleteAccount function
elseif (isset($_POST['deleteaccount_button7'])) {
	DeleteAccount();
}

///////////////////////////////////////////////////////////

//Call Admin Account functions
//Call CreateAnAccount function
elseif (isset($_POST['account_type8'], $_POST['gender8'], $_POST['firstname8'], $_POST['surname8'], $_POST['studentno8'], $_POST['email'], $_POST['password8'], $_POST['confirmpwd8'], $_POST['dateofbirth8'], $_POST['phonenumber8'], $_POST['degree8'], $_POST['address18'], $_POST['address28'], $_POST['town8'], $_POST['city8'], $_POST['country8'], $_POST['postcode8'])) {
	CreateAnAccount();
}

//Call UpdateAnAccount function
elseif (isset($_POST['userid9'], $_POST['firstname9'], $_POST['surname9'], $_POST['gender9'], $_POST['dateofbirth9'], $_POST['studentno9'], $_POST['degree9'], $_POST['email9'], $_POST['phonenumber9'], $_POST['address19'], $_POST['address29'], $_POST['town9'], $_POST['city9'], $_POST['country9'], $_POST['postcode9'])) {
	UpdateAnAccount();
}

//Call ChangeAccountPassword function
elseif (isset($_POST["userid10"], $_POST["password10"], $_POST["confirmpwd10"])) {
	ChangeAccountPassword();
}

//Call DeleteAnAccount function
elseif (isset($_POST["recordToDelete11"])) {
	DeleteAnAccount();
}

////////////////////////////////////////////////////////////

//Call Calendar functions
//Call CreateTask function
elseif (isset($_POST['taskid12'], $_POST['task_name12'], $_POST['task_notes12'], $_POST['task_url12'], $_POST['task_startdate12'], $_POST['task_duedate13'], $_POST['task_category14'])) {
	CreateTask();
}

//Call UpdateTask function
elseif (isset($_POST['taskid15'], $_POST['task_name15'], $_POST['task_notes15'], $_POST['task_url15'], $_POST['task_startdate15'], $_POST['task_duedate15'], $_POST['task_category15'])) {
	UpdateTask();
}

//Call CompleteTask function
elseif (isset($_POST["recordToComplete16"])) {
	CompleteTask();
}
