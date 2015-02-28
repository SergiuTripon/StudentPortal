<?php
include 'session.php';
include 'functions.php';


//Call ApproveFeedback function
if (isset($_POST["feedbackToApprove"])) {
    ApproveFeedback();
}
