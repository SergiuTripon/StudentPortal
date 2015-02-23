<?php
include 'session.php';
include 'functions.php';


//Call UpdateEvent function
if (isset(
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
} else {
    header('HTTP/1.0 550 Bla bla bla.');
    exit();
}
