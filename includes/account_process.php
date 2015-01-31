<?php
include 'signin.php';
include 'functions.php';

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


