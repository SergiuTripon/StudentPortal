<?php
include 'session.php';
include 'functions.php';

//Call UpdateTimetable function
if (isset(
    $_POST['moduleid'],
    $_POST['module_name1'],
    $_POST['module_notes1'],
    $_POST['module_url1'],
    $_POST['lectureid'],
    $_POST['lecture_name1'],
    $_POST['lecture_lecturer1'],
    $_POST['lecture_notes1'],
    $_POST['lecture_day1'],
    $_POST['lecture_from_time1'],
    $_POST['lecture_to_time1'],
    $_POST['lecture_from_date1'],
    $_POST['lecture_to_date1'],
    $_POST['lecture_location1'],
    $_POST['lecture_capacity1'],
    $_POST['tutorialid'],
    $_POST['tutorial_name1'],
    $_POST['tutorial_assistant1'],
    $_POST['tutorial_notes1'],
    $_POST['tutorial_day1'],
    $_POST['tutorial_from_time1'],
    $_POST['tutorial_to_time1'],
    $_POST['tutorial_from_date1'],
    $_POST['tutorial_to_date1'],
    $_POST['tutorial_location1'],
    $_POST['tutorial_capacity1'])) {
    UpdateTimetable();
} else {
    header("/timetable/");
}