<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
    $userid = $_SESSION['userid'];
else $userid = '';

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");

if (isset($_POST['task_name'], $_POST['task_notes'], $_POST['task_url'], $_POST['task_startdate'], $_POST['task_duedate'])) {

    $task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'task_notes', FILTER_SANITIZE_STRING);
    $task_url = filter_input(INPUT_POST, 'task_url', FILTER_SANITIZE_STRING);
    $task_startdate = filter_input(INPUT_POST, 'task_startdate', FILTER_SANITIZE_STRING);
    $task_duedate = filter_input(INPUT_POST, 'task_duedate', FILTER_SANITIZE_STRING);

    $task_class = 'event-important';

    // Check if task exists
    $stmt1 = $mysqli->prepare("SELECT taskid FROM user_tasks WHERE task_name = ? AND userid = ? LIMIT 1");
    $stmt1->bind_param('si', $task_name, $userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($db_taskid);
    $stmt1->fetch();

    if ($stmt1->num_rows == 1) {
        header('HTTP/1.0 550 A task with the task name entered already exists.');
        exit();
        $stmt1->close();
    } else {
        $task_status = 'active';

        $stmt2 = $mysqli->prepare("INSERT INTO user_tasks (userid, task_name, task_notes, task_url, task_class, task_startdate, task_duedate, task_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('issssssss', $userid, $task_name, $task_notes, $task_url, $task_class, $task_startdate, $task_duedate, $task_status, $created_on);
        $stmt2->execute();
        $stmt2->close();

        $stmt1->close();
    }

} else {
    header('HTTP/1.0 550 A task with the task name entered already exists.');
    exit();
}

