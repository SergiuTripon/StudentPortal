<?php
include 'signin.php';

date_default_timezone_set('Europe/London');

if (isset($_POST["recordToComplete"])) {

	$idToComplete = filter_input(INPUT_POST, 'recordToComplete', FILTER_SANITIZE_NUMBER_INT);
	
	$task_status = 'completed';
	$completed_date = date("Y-m-d G:i:s");
	
	$stmt1 = $mysqli->prepare("UPDATE user_tasks SET task_status = ?, completed_date = ? WHERE taskid = ? LIMIT 1");
	$stmt1->bind_param('ssi', $task_status, $completed_date, $idToComplete);
	$stmt1->execute();
	$stmt1->close();

}
