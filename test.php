<?php
include 'includes/session.php';

calendarUpdate($isUpdate = '1');

function calendarUpdate($isUpdate = '0') {

    global $mysqli;
    global $session_userid;
    global $due_tasks;
    global $completed_tasks;
    global $archived_tasks;
    global $isUpdate;

    $task_status = 'active';

    $stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate FROM user_task WHERE userid=? AND task_status=?");
    $stmt1->bind_param('is', $session_userid, $task_status);
    $stmt1->execute();
    $stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

        $due_tasks .=

        '<tr>
        <td data-title="Name"><a href="#view-'.$taskid .'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'. $task_startdate .'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Action">

        <div class="btn-group btn-action">
        <a id="complete-'.$taskid.'" class="btn btn-primary btn-complete">Complete</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="../calendar/update-task?id='.$taskid.'">Update</a></li>
        <li><a id="archive-'.$taskid.'" class="btn-archive">Archive</a></li>
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
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
        <a href="#complete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Complete</a>
        <a href="#deactivate-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Archive</a>
        <a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!--/modal -->
        </div><!--/modal-dialog-->
        </div><!--/modal-content-->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
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

            $completed_tasks .=

                '<tr>
        <td data-title="Task"><a href="#view-'.$taskid.'" data-toggle="modal" data-dismiss="modal">'.$task_name.'</a></td>
        <td data-title="Start">'.$task_startdate.'</td>
        <td data-title="Due">'.$task_duedate.'</td>
        <td data-title="Completed on">'.$task_duedate.'</td>
        <td data-title="Action">
        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate">Restore</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
        </ul>
        </div>

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

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-center">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
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

    $task_status = 'inactive';

    $stmt3 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_task WHERE userid=? AND task_status=?");
    $stmt3->bind_param('is', $session_userid, $task_status);
    $stmt3->execute();
    $stmt3->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate, $updated_on);
    $stmt3->store_result();

    if ($stmt3->num_rows > 0) {

        while($stmt3->fetch()) {

            $archived_tasks .=

                '<tr>
        <td data-title="Name"><a href="#view-'.$taskid.'" data-toggle="modal">'.$task_name.'</a></td>
        <td data-title="Start date">'.$task_startdate.'</td>
        <td data-title="Due date">'.$task_duedate.'</td>
        <td data-title="Archived on">'.$updated_on.'</td>
        <td data-title="Action">
        <div class="btn-group btn-action">
        <a id="reactivate-'.$taskid.'" class="btn btn-primary btn-reactivate">Restore</a>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="fa fa-caret-down"></span>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#delete-'.$taskid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
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
        <p><b>Archived on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
        </div>

        <div class="modal-footer">
        <div class="view-action pull-left">
        <a href="#reactivate-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Restore</a>
        <a href="#delete-'.$taskid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
        </div>
        <div class="view-close pull-right">
        <a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->

        <div id="delete-'.$taskid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
        <h4 class="modal-title" id="modal-custom-label">Delete task?</h4>
        </div>

        <div class="modal-body">
        <p class="confirmation-default text-left">Are you sure you want to delete "'.$task_name.'"?</p>
        </div>

        <div class="modal-footer">
        <div class="text-right">
        <a class="btn btn-confirmation-cancel btn-lg" data-dismiss="modal">Cancel</a>
        <a id="delete-'.$taskid.'" class="btn btn-confirmation-confirm btn-lg btn-delete">Confirm</a>
        </div>
        </div>

        </div><!-- /modal -->
        </div><!-- /modal-dialog -->
        </div><!-- /modal-content -->
        </td>
        </tr>';
        }
    }

    $stmt3->close();

    if ($isUpdate == 1) {

        global $due_tasks;

        echo $due_tasks;
    }
}