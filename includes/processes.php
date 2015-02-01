<?php
include 'signin.php';
include 'functions.php';

//Call UpdateAnAccount function
if (isset($_POST['userid'], $_POST['firstname3'], $_POST['surname3'], $_POST['gender3'], $_POST['studentno1'], $_POST['degree1'], $_POST['email6'], $_POST['nationality2'], $_POST['dateofbirth2'], $_POST['phonenumber2'], $_POST['address12'], $_POST['address22'], $_POST['town2'], $_POST['city2'], $_POST['country2'], $_POST['postcode2'])) {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
} else {
	header('HTTP/1.0 550 The email address you entered is invalid.');
	exit();
}