<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;

$task_status = 'active';

$stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid=? AND task_status=?");
$stmt1->bind_param('is', $session_userid, $task_status);
$stmt1->execute();
$stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
$stmt1->store_result();

if ($stmt1->num_rows > 0) {

    while ($stmt1->fetch()) {
        echo $taskid;
    }
}


