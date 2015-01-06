<?php
include_once 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

date_default_timezone_set('Europe/London');
 
if (isset($_POST['task_name'], $_POST['task_notes'], $_POST['task_duedate'], $_POST['task_category'])) {
	
	$task_name = filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING);
    $task_notes = filter_input(INPUT_POST, 'task_notes', FILTER_SANITIZE_STRING);
    $task_duedate = filter_input(INPUT_POST, 'task_duedate', FILTER_SANITIZE_STRING);
	$task_category = filter_input(INPUT_POST, 'task_category', FILTER_SANITIZE_STRING);
	
	if ($task_category == 'University') {
	$task_class = 'event-important';
	}
	
	// Check if task exists
	$stmt1 = $mysqli->prepare("SELECT taskid FROM user_tasks where userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userid);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($db_taskid);
	$stmt1->fetch();
	
	if ($stmt1->num_rows == 1) {
	
	// Check existing task name
	$stmt2 = $mysqli->prepare("SELECT taskid FROM user_tasks WHERE task_name = ? AND userid = ? LIMIT 1");
	$stmt2->bind_param('si', $task_name, $userid);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($db_taskid);
	$stmt2->fetch();
	
	if ($stmt2->num_rows == 1) {
	header('HTTP/1.0 550 A task with the task name entered already exists.');
	exit();
	$stmt2->close();
	}
	
	$stmt3 = $mysqli->prepare("SELECT heading, collapse FROM user_tasks ORDER BY taskid DESC LIMIT 1");
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($db_heading, $db_collapse);
	$stmt3->fetch();
	
	$task_status = 'active';
	$created_date = date("Y-m-d G:i:s");
	$task_startdate = date("Y-m-d");
	$heading = $db_collapse + 1;
	$collapse = $heading + 1;
	
	$stmt4 = $mysqli->prepare("INSERT INTO user_tasks (userid, task_name, task_notes, task_class, task_startdate, task_duedate, task_category, task_status, heading, collapse, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt4->bind_param('isssssssiis', $userid, $task_name, $task_notes, $task_class, $task_startdate, $task_duedate, $task_category, $task_status, $heading, $collapse, $created_date);
	$stmt4->execute();
	$stmt4->close();
	
	} else {
	
	// Check existing task name
	$stmt5 = $mysqli->prepare("SELECT userid FROM user_tasks WHERE task_name = ? LIMIT 1");
	$stmt5->bind_param('s', $task_name);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($db_userid);
	$stmt5->fetch();
	
	if ($stmt5->num_rows == 1) {
	header('HTTP/1.0 550 A task with the task name entered already exists.');
	exit();
	$stmt5->close();
	}
	
	$task_status = 'active';
	$created_date = date("Y-m-d G:i:s");
	$task_startdate = date("Y-m-d");
	$heading = 1;
	$collapse = 2;
	
	$stmt2 = $mysqli->prepare("INSERT INTO user_tasks (userid, task_name, task_notes, task_class, task_startdate, task_duedate, task_category, task_status, heading, collapse, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt2->bind_param('isssssssiis', $userid, $task_name, $task_notes, $task_class, $task_startdate, $task_duedate, $task_category, $task_status, $heading, $collapse, $created_date);
	$stmt2->execute();
	$stmt2->close();
	}
	
}

