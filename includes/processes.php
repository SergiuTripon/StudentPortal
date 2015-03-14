<?php
include 'session.php';
include 'functions.php';



//Call ResetPassword function
if (isset($_POST["rp_token"], $_POST["rp_email"], $_POST["rp_password"])) {
	ResetPassword();
} else {
    header('HTTP/1.0 550 The email address you entered is invalid.');
    exit();
}
