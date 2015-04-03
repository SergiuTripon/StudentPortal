<?php
include 'includes/session.php';
include 'includes/functions.php';

Test();

function Test() {

    global $mysqli;
    global $session_userid;
    global $due_tasks;
    global $completed_tasks;

    $task_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid=? AND task_status=?");
    $stmt1->bind_param('is', $session_userid, $task_status);
    $stmt1->execute();
    $stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

        $due_tasks = array();
        $due_tasks[] =

        '<tr id="task-'.$taskid .'">

        <td data-title="Name"><a href="#view-'.$taskid .'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'. $task_startdate .'</td>
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
        </div><!-- /modal-content -->
        </td>
        </tr>';
        }
    }
    $stmt1->close();

    $task_status = 'completed';

    $stmt2 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task where userid=? AND task_status=?");
    $stmt2->bind_param('is', $session_userid, $task_status);
    $stmt2->execute();
    $stmt2->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt2->store_result();

    while($stmt2->fetch()) {

        if ($stmt2->num_rows > 0) {

        $completed_tasks =

        '<tr id="task-'.$taskid.'">

        <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal" data-dismiss="modal">'.$task_name.'</a></td>
        <td data-title="Start">'.$task_startdate.'</td>
        <td data-title="Due">'.$task_duedate.'</td>
        <td data-title="Completed on">'.$task_duedate.'</td>
        <td data-title="Action"><a class="btn btn-primary btn-md" href="#delete-confirmation-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a>
        <div id="view-'.$taskid .'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
        </div><!-- /modal-content -->
        </td>
        </tr>';
        }
    }

    $stmt2->close();

    echo $due_tasks;
}

