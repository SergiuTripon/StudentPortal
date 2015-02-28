<?php
include 'session.php';
include 'functions.php';


//Call ApproveFeedback function
if (isset($_POST["feedbackToApprove"])) {
    ApproveFeedback();
} else {
    header('HTTP/1.0 550 An event with the name entered already exists.');
    exit();
}
