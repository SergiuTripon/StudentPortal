<?php
include 'session.php';
include 'functions.php';


//Call UpdateEvent function
if (isset(
    $_POST['eventid1'])) {
    UpdateEvent();
} else {
    header('HTTP/1.0 550 blah blah blah.');
    exit();
}
