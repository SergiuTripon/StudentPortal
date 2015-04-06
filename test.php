<?php
include 'includes/session.php';
include 'includes/functions.php';

AdminTimetableUpdate($isUpdate = 1, $userid = 3);

$userid = '3';
$result_status = 'inactive';

$stmt10 = $mysqli->prepare("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid=? AND user_result.result_status=?");
$stmt10->bind_param('is', $userid, $result_status);
$stmt10->execute();
$stmt10->bind_result($resultid, $module_name, $result_coursework_mark, $result_exam_mark, $result_overall_mark);
$stmt10->store_result();

if ($stmt10->num_rows > 0) {

    while ($stmt10->fetch()) {

        $inactive_result .=

            '<tr>
			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a id="reactivate-'.$resultid.'" class="btn btn-primary btn-reactivate-result">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$resultid.'" data-dismiss="modal" data-toggle="modal">Delete</a></li>
            </ul>
            </div>

            <div class="modal modal-custom fade" id="delete-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="feedback-sad text-center">Are you sure you want to delete this result for '.$module_name.'?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
			<a class="btn btn-success btn-lg" data-dismiss="modal">Cancel</a>
            <a id="delete-'.$resultid.'" class="btn btn-danger btn-lg btn-delete-result">Confirm</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
    }
}
$stmt10->close();

echo $inactive_result;