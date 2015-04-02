<?php
include 'includes/session.php';

global $mysqli;
global $session_userid;

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Calendar</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff' || $_SESSION['account_type'] == 'administrator')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="calendar-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
		<li><a href="../home/">Home</a></li>
		<li class="active">Calendar</li>
	</ol>

	<div class="row">

    <a href="/calendar/create-task/">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <div class="tile">
    <i class="fa fa-plus"></i>
	<p class="tile-text">Create a task</p>
    </div>
	</div>
    </a>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<div id="task-button">
    <div class="tile task-tile">
	<i class="fa fa-tasks"></i>
	<p class="tile-text">Task view</p>
    </div>
    </div>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<div id="calendar-button">
	<div class="tile calendar-tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar view</p>
    </div>
    </div>
	</div>
	
	</div><!-- /row -->

	<div class="panel-group panel-custom task-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="duetasks-toggle" class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Due tasks</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Due tasks -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-due-tasks">

	<thead>
	<tr>
	<th>Task</th>
	<th>Start</th>
	<th>Due</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody id="content-due-tasks">
	<?php

	$stmt1 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid = '$session_userid' AND task_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$taskid = $row["taskid"];
	$task_name = $row["task_name"];
	$task_notes = $row["task_notes"];
    $task_url = $row["task_url"];
	$task_startdate = $row["task_startdate"];
	$task_duedate = $row["task_duedate"];

	echo '<tr id="task-'.$taskid.'">

			<td data-title="Name"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
			<td data-title="Start date">'.$task_startdate.'</td>
			<td data-title="Due date">'.$task_duedate.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a id="complete-button" class="btn btn-primary" href="#complete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Complete</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="../calendar/update-task?id='.$taskid.'">Update</a></li>
            <li><a href="#deactivate-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Archive</a></li>
            <li><a href="#delete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/calendar/update-task?id='.$taskid.'" class="btn btn-primary btn-sm" >Update</a>
            <a href="#complete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Complete</a>
            <a href="#deactivate-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Archive</a>
            <a href="#delete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!--/modal -->
			</div><!--/modal-dialog-->
			</div><!--/modal-content-->

            <div id="complete-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-happy">Are you sure you want to complete '.$task_name.'?</p></div>

			<div class="modal-footer">
			<div class="pull-left">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
			<a id="complete-'.$taskid.'" class="btn btn-success btn-lg complete-button">Complete</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="complete-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-happy">All done! '.$task_name.' has been completed.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="deactivate-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to archive '.$task_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="pull-left">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
            <a id="deactivate-'.$taskid.'" class="btn btn-danger btn-lg deactivate-button">Archive</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="deactivate-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-happy">All done! '.$task_name.' has been archived.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to delete '.$task_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="pull-left">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
			<a id="delete-'.$taskid.'" class="btn btn-danger btn-lg delete-button" >Delete</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-happy text-center">All done! '.$task_name.' has been deleted.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div id="completedtasks-toggle" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Completed tasks</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Completed tasks -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-completed-tasks">

	<thead>
	<tr>
	<th>Task</th>
	<th>Start</th>
	<th>Due</th>
    <th>Completed on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-completed-tasks">
	<?php

	$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid = '$session_userid' AND task_status = 'completed'");

	while($row = $stmt2->fetch_assoc()) {

    $taskid = $row["taskid"];
    $task_name = $row["task_name"];
    $task_notes = $row["task_notes"];
    $task_startdate = $row["task_startdate"];
    $task_duedate = $row["task_duedate"];
    $task_url = $row["task_url"];
    $updated_on = $row["updated_on"];

	echo '<tr id="task-'.$taskid.'">

            <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal" data-dismiss="modal">'.$task_name.'</a></td>
            <td data-title="Start">'.$task_startdate.'</td>
            <td data-title="Due">'.$task_duedate.'</td>
            <td data-title="Completed on">'.$task_duedate.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md" href="#delete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></td>
            </tr>

	        <div id="view-'.$taskid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close">
            <i class="fa fa-calendar"></i>
            </div>
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
            <a href="#delete-confirmation-'.$taskid.'" class="btn btn-primary btn-sm" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$task_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="pull-left">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
			<a id="delete-'.$taskid.'" class="btn btn-danger btn-lg delete-button" >Delete</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-happy text-center">All done! '.$task_name.' has been deleted.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
  	</div><!-- /panel-default -->

    <div id="archivedtasks-toggle" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Archived tasks</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Archived tasks -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-archived-tasks">

	<thead>
	<tr>
	<th>Task</th>
	<th>Start</th>
	<th>Due</th>
    <th>Archived on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-archived-tasks">
	<?php

	$stmt1 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task WHERE userid = '$session_userid' AND task_status = 'inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$taskid = $row["taskid"];
	$task_name = $row["task_name"];
	$task_notes = $row["task_notes"];
	$task_startdate = $row["task_startdate"];
	$task_duedate = $row["task_duedate"];
	$task_url = $row["task_url"];
    $updated_on = $row["updated_on"];

	echo '<tr id="task-'.$taskid.'">

			<td data-title="Name"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
			<td data-title="Start date">'.$task_startdate.'</td>
			<td data-title="Due date">'.$task_duedate.'</td>
			<td data-title="Archived on">'.$updated_on.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#reactivate-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Restore</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</td>
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
			<p><b>Archived on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#reactivate-confirmation-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Restore</a>
            <a href="#delete-confirmation-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="reactivate-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to restore '.$task_name.'?</p>
			</div>

			<div class="modal-footer">
			<div>
			<div class="pull-left">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
			<a id="reactivate-'.$taskid.'" class="btn btn-success btn-lg reactivate-button">Reactivate</a>
			</div>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="reactivate-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-happy text-center">All done! '.$task_name.' has been restored.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-confirmation-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-question"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete '.$task_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="pull-left">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			<div class="text-right">
			<a id="delete-'.$taskid.'" class="btn btn-danger btn-lg delete-button" >Delete</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-success-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-check"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-happy text-center">All done! '.$task_name.' has been deleted.</p>
			</div>

			<div class="modal-footer">
			<div class="text-center">
			<a class="btn btn-primary btn-lg" data-dismiss="modal">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
  	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

	<div class="panel-group panel-custom calendar-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="calendar-toggle" class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingFour">
	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Calendar</a>
	</h4>
	</div>
	<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
	<div class="panel-body">

	<div class="calendar-buttons text-right">
	<div id="calendar-buttons1" class="btn-group">
		<button class="btn btn-default" data-calendar-nav="prev"><< Prev</button>
		<button class="btn btn-default" data-calendar-nav="today">Today</button>
		<button class="btn btn-default" data-calendar-nav="next">Next >></button>
	</div>
	<div id="calendar-buttons2" class="btn-group">
		<button class="btn btn-default" data-calendar-view="year">Year</button>
		<button class="btn btn-default active" data-calendar-view="month">Month</button>
		<button class="btn btn-default" data-calendar-view="week">Week</button>
		<button class="btn btn-default" data-calendar-view="day">Day</button>
	</div>
	</div>

	<div class="page-header">
	<h3></h3>
	<hr>
	</div>

	<div id="calendar"></div>

	</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->
	
    </div><!-- /container -->
	
	<?php include 'includes/footers/footer.php'; ?>
		
	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>
    <?php include 'assets/js-paths/calendar-js-path.php'; ?>

    <script>
    $(document).ready(function () {
        $("#calendar-toggle").hide();
        $(".task-tile").addClass("tile-selected");
        $(".task-tile p").addClass("tile-text-selected");
        $(".task-tile i").addClass("tile-text-selected");
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //Calendar
	(function($) {

	"use strict";

	var options = {
		events_source: '../../includes/calendar/source/tasks_json.php',
		view: 'month',
		tmpl_path: '../assets/tmpls/',
		tmpl_cache: false,
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	var calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});
	}(jQuery));

    var settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display at the moment."
        }
    };

    //DataTables
    $('.table-due-tasks').dataTable(settings);
    $('.table-completed-tasks').dataTable(settings);
    $('.table-archived-tasks').dataTable(settings);

    //Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 550){
			$('.calendar-buttons .btn-group').addClass('btn-group-vertical full-width');
            $('#calendar-buttons2').addClass("mt10");
        } else {
            $('.calendar-buttons .btn-group').removeClass('btn-group-vertical full-width');
            $('#calendar-buttons2').removeClass("mt10");
        }
	}).resize();



    //Complete record
	$("body").on("click", ".complete-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToComplete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToComplete='+ taskToComplete,
	success:function(data){

            $('#complete-confirmation-'+taskToComplete).modal('hide');

            $('#content-due-tasks').empty();
            $('#content-due-tasks').append(data.due_tasks);

            $('#content-completed-tasks').empty();
            $('#content-completed-tasks').append(data.completed_tasks);

            $('#complete-success-'+taskToComplete).modal('show');
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});

    });

    //Deactivate record
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToDeactivate='+ taskToDeactivate,
	success:function(data){

        $('#deactivate-confirmation-'+taskToDeactivate).modal('hide');

        $(".table-due-tasks").dataTable().fnDestroy();
        $('#content-due-tasks').empty();
        $('#content-due-tasks').append(data.due_tasks);
        $(".table-due-tasks").dataTable(settings);

        $('#content-archived-tasks').empty();
        $(".table-archived-tasks").dataTable().fnDestroy();
        $('#content-archived-tasks').append(data.archived_tasks);
        $(".table-archived-tasks").dataTable(settings);

        $('#deactivate-success-'+taskToDeactivate).modal('show');
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate record
    $("body").on("click", ".reactivate-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToReactivate='+ taskToReactivate,
	success:function(data){

        $('#reactivate-confirmation-'+taskToReactivate).modal('hide');

        $(".table-archived-tasks").dataTable().fnDestroy();
        $('#content-archived-tasks').empty();
        $('#content-archived-tasks').append(data.archived_tasks);
        $(".table-archived-tasks").dataTable(settings);

        $('#content-due-tasks').empty();
        $(".table-due-tasks").dataTable().fnDestroy();
        $('#content-due-tasks').append(data.due_tasks);
        $(".table-due-tasks").dataTable(settings);

        $('#reactivate-success-'+taskToReactivate).modal('show');
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete record
    $("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToDelete='+ taskToDelete,
	success:function(data){

        $('#delete-confirmation-'+taskToDelete).modal('hide');

        $('#content-due-tasks').empty();
        $(".table-due-tasks").dataTable().fnDestroy();
        $('#content-due-tasks').append(data.due_tasks);
        $(".table-due-tasks").dataTable(settings);

        $('#content-completed-tasks').empty();
        $(".table-completed-tasks").dataTable().fnDestroy();
        $('#content-completed-tasks').append(data.completed_tasks);
        $(".table-completed-tasks").dataTable(settings);

        $('#content-archived-tasks').empty();
        $(".table-archived-tasks").dataTable().fnDestroy();
        $('#content-archived-tasks').append(data.archived_tasks);
        $(".table-archived-tasks").dataTable(settings);

        $('#delete-success-'+taskToDelete).modal('show');

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

	$("#task-button").click(function (e) {
    e.preventDefault();
        $(".calendar-view").hide();
		$("#calendar-toggle").hide();
        $(".task-view").show();
		$("#duetasks-toggle").show();
		$("#completedtasks-toggle").show();
		$(".calendar-tile").removeClass("tile-selected");
		$(".calendar-tile p").removeClass("tile-text-selected");
		$(".calendar-tile i").removeClass("tile-text-selected");
		$(".task-tile").addClass("tile-selected");
		$(".task-tile p").addClass("tile-text-selected");
		$(".task-tile i").addClass("tile-text-selected");
	});

	$("#calendar-button").click(function (e) {
    e.preventDefault();
        $(".task-view").hide();
		$("#duetasks-toggle").hide();
		$("#completedtasks-toggle").hide();
        $(".calendar-view").show();
		$("#calendar-toggle").show();
		$(".task-tile").removeClass("tile-selected");
		$(".task-tile p").removeClass("tile-text-selected");
		$(".task-tile i").removeClass("tile-text-selected");
		$(".calendar-tile").addClass("tile-selected");
		$(".calendar-tile p").addClass("tile-text-selected");
		$(".calendar-tile i").addClass("tile-text-selected");
	});

	</script>

    <?php endif; ?>

	<?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a id="signin-button" class="btn btn-primary btn-lg" href="/">Sign in</a>
    </div>

    </form>
     
	</div>

	<?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <script>

    $('#signin-button').on('click', function () {
        $(this).button('loading');
    });

    </script>

	<?php endif; ?>

</body>
</html>
