<?php
include 'includes/session.php';

global $due_tasks;
global $completed_tasks;

$session_userid = '1';

$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid = '$session_userid' AND task_status = 'active'");

while($row = $stmt2->fetch_assoc()) {

    $taskid = $row["taskid"];
    $task_name = $row["task_name"];
    $task_notes = $row["task_notes"];
    $task_startdate = $row["task_startdate"];
    $task_duedate = $row["task_duedate"];
    $task_url = $row["task_url"];
    $updated_on = $row["updated_on"];

    $due_tasks = '<tr id="task-'.$taskid.'">

            <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
            <td data-title="Start">'.$task_startdate.'</td>
            <td data-title="Due">'.$task_duedate.'</td>
            <td data-title="Completed on">'.$task_duedate.'</td>
            <td data-title="Action"><a class="btn btn-md btn-primary ladda-button" data-style="slide-up" href="#delete-'.$taskid.'" data-toggle="modal"><span class="ladda-label">Delete</span></a></td>
            </tr>

	        <div id="view-'.$taskid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-calendar"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
			<p><b>URL:</b> '.(empty($task_url) ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</p>
			<p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
			<p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
			<p><b>Completed on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
            <a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete '.$task_name.'?</p>
			<p id="delete-confirmation" class="text-center feedback-happy" style="display: none;">'.$task_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$taskid.'" class="btn btn-success btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
}

$stmt2->close();

$stmt3 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid = '$session_userid' AND task_status = 'completed'");

while($row = $stmt3->fetch_assoc()) {

    $taskid = $row["taskid"];
    $task_name = $row["task_name"];
    $task_notes = $row["task_notes"];
    $task_startdate = $row["task_startdate"];
    $task_duedate = $row["task_duedate"];
    $task_url = $row["task_url"];
    $updated_on = $row["updated_on"];

    $completed_tasks = '<tr id="task-'.$taskid.'">

            <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
            <td data-title="Start">'.$task_startdate.'</td>
            <td data-title="Due">'.$task_duedate.'</td>
            <td data-title="Completed on">'.$task_duedate.'</td>
            <td data-title="Action"><a class="btn btn-md btn-primary ladda-button" data-style="slide-up" href="#delete-'.$taskid.'" data-toggle="modal"><span class="ladda-label">Delete</span></a></td>
            </tr>

	        <div id="view-'.$taskid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-calendar"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$task_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Notes:</b> '.(empty($task_notes) ? "-" : "$task_notes").'</p>
			<p><b>URL:</b> '.(empty($task_url) ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</p>
			<p><b>Start date and time:</b> '.(empty($task_startdate) ? "-" : "$task_startdate").'</p>
			<p><b>Due date and time:</b> '.(empty($task_duedate) ? "-" : "$task_duedate").'</p>
			<p><b>Completed on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
            <a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete '.$task_name.'?</p>
			<p id="delete-confirmation" class="text-center feedback-happy" style="display: none;">'.$task_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$taskid.'" class="btn btn-success btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
}

$stmt3->close();

$array = array(
    'due_tasks'=>$due_tasks,
    'completed_tasks'=>$completed_tasks
);

echo $due_tasks;

echo json_encode($array);
