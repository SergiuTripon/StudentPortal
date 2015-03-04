<?php
include 'session.php';
include 'functions.php';

//Call DeactivateTimetable function
if (isset($_POST['timetableToDeactivate'])) {
    DeactivateTimetable();
}
