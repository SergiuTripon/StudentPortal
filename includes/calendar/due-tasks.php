<?php
include '../session.php';

	$stmt1 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, task_category FROM user_task WHERE userid = '$session_userid' AND task_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

        $taskid = $row["taskid"];
        $task_name = $row["task_name"];
        $task_notes = $row["task_notes"];
        $task_url = $row["task_url"];
        $task_startdate = $row["task_startdate"];
        $task_duedate = $row["task_duedate"];
        $task_category = $row["task_category"];
        $task_category = ucfirst($row["task_category"]);

        echo '<tr id="task-'.$taskid.'">

			<td data-title="Name">'.$task_name.'</td>
			<td data-title="Notes">'.($task_notes === '' ? "-" : "$task_notes").'</td>
			<td data-title="URL">'.($task_url === '' ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</td>
			<td data-title="Start date">'.$task_startdate.'</td>
			<td data-title="Due date">'.$task_duedate.'</td>
			<td data-title="Category">'.$task_category.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#complete-'.$taskid.'" data-toggle="modal">Complete</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="../calendar/update-task?id='.$taskid.'" data-toggle="modal" data-toggle="modal">Update</a></li>
            <li><a href="#deactivate-'.$taskid.'" data-toggle="modal" data-toggle="modal">Archive</a></li>
            </ul>
            </div>
            </td>

			</tr>

            <div id="complete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="complete-question" class="text-center feedback-sad">Are you sure you want to complete '.$task_name.'?</p>
			<p id="complete-confirmation" class="text-center feedback-happy" style="display: none;">'.$task_name.' has been completed successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="complete-hide">
			<div class="pull-left">
			<a id="complete-'.$taskid.'" class="btn btn-danger btn-lg complete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="complete-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="deactivate-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="deactivate-question" class="text-center feedback-sad">Are you sure you want to archive '.$task_name.'?</p>
			<p id="deactivate-confirmation" class="text-center feedback-happy" style="display: none;">'.$task_name.' has been archived successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="deactivate-hide">
			<div class="pull-left">
			<a id="deactivate-'.$taskid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="deactivate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
    }

	$stmt1->close();