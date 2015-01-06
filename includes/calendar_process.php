<?php
include 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

date_default_timezone_set('Europe/London');
$completed_on = date("Y-m-d G:i:s");
$updated_on = date("Y-m-d G:i:s");

if (isset($_POST["recordToComplete"])) {

	$idToComplete = filter_input(INPUT_POST, 'recordToComplete', FILTER_SANITIZE_NUMBER_INT);
	
	$task_status = 'completed';
	
	$stmt1 = $mysqli->prepare("UPDATE user_tasks SET task_status = ?, completed_on = ? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('ssi', $task_status, $completed_on, $idToComplete);
	$stmt1->execute();
	$stmt1->close();

}

elseif (isset($_POST['taskid'], $_POST['task_name'], $_POST['task_notes'], $_POST['task_url'], $_POST['task_startdate'], $_POST['task_duedate'], $_POST['task_category'])) {

	$taskid = filter_input(INPUT_POST, 'taskid', FILTER_SANITIZE_NUMBER_INT);
	$task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'task_notes', FILTER_SANITIZE_STRING);
	$task_url = filter_input(INPUT_POST, 'task_url', FILTER_SANITIZE_STRING);
	$task_startdate = filter_input(INPUT_POST, 'task_startdate', FILTER_SANITIZE_STRING);
	$task_duedate = filter_input(INPUT_POST, 'task_duedate', FILTER_SANITIZE_STRING);
	$task_category = filter_input(INPUT_POST, 'task_category', FILTER_SANITIZE_STRING);
	
	$stmt1 = $mysqli->prepare("SELECT task_name from user_tasks where taskid = ?");
	$stmt1->bind_param('i', $taskid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_taskname);
	$stmt1->fetch();
	
	if ($db_taskname == $task_name) {
	
	$stmt2 = $mysqli->prepare("UPDATE user_tasks SET task_notes=?, task_url=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt2->bind_param('ssssssi', $task_notes, $task_url, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
	$stmt2->execute();
	$stmt2->close();

	}
	
	else {
	
	$stmt3 = $mysqli->prepare("SELECT taskid from user_tasks where task_name = ? AND userid = ? LIMIT 1");
	$stmt3->bind_param('si', $task_name, $userid);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($db_taskid);
	$stmt3->fetch();
	
	if ($stmt3->num_rows == 1) {
	header('HTTP/1.0 550 A task with the name entered already exists.');
	exit();
	$stmt3->close();
	}
	else {

	$stmt4 = $mysqli->prepare("UPDATE user_tasks SET task_name=?, task_notes=?, task_url=?, task_startdate=?, task_duedate=?, task_category=?, updated_on=? WHERE taskid = ?");
	$stmt4->bind_param('sssssssi', $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $task_category, $updated_on, $taskid);
	$stmt4->execute();
	$stmt4->close();
	
	}
	}
}
