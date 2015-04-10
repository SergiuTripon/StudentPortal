<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>


	<?php include 'assets/css-paths/common-css-paths.php'; ?>


    <title>Student Portal | Feedback</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Modules</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
    <th>Tutorial assistant</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT m.moduleid, m.module_name, l.lecture_lecturer, t.tutorial_assistant FROM system_module m LEFT JOIN user_module u ON m.moduleid = u.moduleid LEFT JOIN system_lecture l ON m.moduleid = l.moduleid LEFT JOIN system_tutorial t ON m.moduleid = t.moduleid WHERE u.userid = '$session_userid' AND m.module_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
	$lecture_lecturer = $row["lecture_lecturer"];
    $tutorial_assistant = $row["tutorial_assistant"];

    $stmt2 = $mysqli->prepare("SELECT userid, firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lecture_lecturer);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($lecturer_userid, $lecturer_fistname, $lecturer_surname);
    $stmt2->fetch();

    $stmt3 = $mysqli->prepare("SELECT userid, firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
    $stmt3->bind_param('i', $tutorial_assistant);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($tutorial_assistant_userid, $tutorial_assistant_firstname, $tutorial_assistant_surname);
    $stmt3->fetch();

	echo '<tr>

			<td data-title="Name"><a href="#view-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Lecturer">'.$lecturer_fistname.' '.$lecturer_surname.'</td>
			<td data-title="Tutorial assistant">'.$tutorial_assistant_firstname.' '.$tutorial_assistant_surname.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md" href="../feedback/submit-feedback?id='.$moduleid.'" >Submit feedback</span></a></a></td>
			</tr>

            <div id="view-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
    $stmt2->close();
    $stmt3->close();
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Submitted feedback</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Submitted feedback -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom feedback-table">

	<thead>
	<tr>
	<th>Module</th>
    <th>Subject</th>
    <th>Submitted on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT DISTINCT m.moduleid, m.module_name, m.module_notes, m.module_url, f.feedbackid, f.feedback_subject, f.feedback_body, f.isApproved, r.isRead, DATE_FORMAT(f.created_on,'%d %b %y %H:%i') as created_on FROM user_feedback_sent s LEFT JOIN user_feedback_received r ON s.feedbackid=r.feedbackid LEFT JOIN system_module m ON s.moduleid = m.moduleid LEFT JOIN user_feedback f ON s.feedbackid = f.feedbackid WHERE s.feedback_from = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

    $feedbackid = $row["feedbackid"];
    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
    $module_notes = $row["module_notes"];
    $module_url = $row["module_url"];
    $feedback_subject = $row["feedback_subject"];
    $feedback_body = $row["feedback_body"];
    $isApproved = $row["isApproved"];
    $isRead = $row["isRead"];
    $created_on = $row["created_on"];

	echo '<tr id="feedback-'.$feedbackid.'">

			<td data-title="Module"><a href="#view-submitted-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Subject"><a href="#view-feedback-'.$feedbackid.'" data-toggle="modal">'.$feedback_subject.'</a></td>
			<td data-title="Submitted on">'.$created_on.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md" href="#delete-feedback-'.$feedbackid.'" data-toggle="modal">Delete</span></a></td>
			</tr>

            <div id="view-submitted-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="view-feedback-'.$feedbackid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$feedback_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Feedback:</b> '.(empty($feedback_body) ? "-" : "$feedback_body").'</p>
			<p><b>Submitted:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Approved:</b> '.($isApproved == 0 ? "No" : "Yes").'</p>
			<p><b>Read:</b> '.($isRead == 0 ? "No" : "Yes").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#delete-feedback-'.$feedbackid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-feedback-'.$feedbackid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-feedback-question" class="text-center feedback-sad">Are you sure you want to delete '.$feedback_subject.'?</p>
			<p id="delete-feedback-confirmation" style="display: none;" class="text-center feedback-happy">'.$feedback_subject.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-feedback-hide">
			<div class="pull-left">
			<a id="delete-'.$feedbackid.'" class="btn btn-success btn-lg delete-sent-feedback-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-feedback-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'academic staff') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a id="feedback-read-trigger" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Received feedback</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Received feedback -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom feedback-table">

	<thead>
	<tr>
	<th>From</th>
	<th>Module</th>
    <th>Subject</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT DISTINCT f.feedbackid, d.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.studentno, d.degree, m.moduleid, m.module_name, m.module_notes, m.module_url, f.feedback_subject, f.feedback_body, DATE_FORMAT(f.created_on,'%d %b %y %H:%i') as created_on FROM user_feedback_received r LEFT JOIN user_detail d ON r.feedback_from=d.userid LEFT JOIN system_module m ON r.moduleid=m.moduleid LEFT JOIN user_feedback f ON r.feedbackid=f.feedbackid WHERE r.module_staff = '$session_userid' AND f.isApproved = 1");

	while($row = $stmt1->fetch_assoc()) {

    $userid = $row["userid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);
    $dateofbirth = $row["dateofbirth"];
    $studentno = $row["studentno"];
    $degree = $row["degree"];
    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
    $module_notes = $row["module_notes"];
    $module_url = $row["module_url"];
    $feedbackid = $row["feedbackid"];
    $feedback_subject = $row["feedback_subject"];
    $feedback_body = $row["feedback_body"];
    $created_on = $row["created_on"];

	echo '<tr id="feedback-'.$feedbackid.'">

			<td data-title="From"><a href="#view-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Module"><a href="#view-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Subject"><a href="#view-feedback-'.$feedbackid.'" data-toggle="modal">'.$feedback_subject.'</a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md" href="#delete-feedback-'.$feedbackid.'" data-toggle="modal">Delete</span></a></td>
			</tr>

			<div id="view-user-'.$userid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Gender:</b> '.(empty($gender) ? "-" : "$gender").'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Student number:</b> '.(empty($studentno) ? "-" : "$studentno").'</p>
			<p><b>Degree:</b> '.(empty($degree) ? "-" : "$degree").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="view-feedback-'.$feedbackid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$feedback_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Feedback:</b> '.(empty($feedback_body) ? "-" : "$feedback_body").'</p>
			<p><b>Submitted:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#delete-feedback-'.$feedbackid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-feedback-'.$feedbackid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-feedback-question" class="text-center feedback-sad">Are you sure you want to delete '.$feedback_subject.'?</p>
			<p id="delete-feedback-confirmation" style="display: none;" class="text-center feedback-happy">'.$feedback_subject.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-feedback-hide">
			<div class="pull-left">
			<a id="delete-'.$feedbackid.'" class="btn btn-success btn-lg delete-received-feedback-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-feedback-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Submitted feedback</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Submitted feedback -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom feedback-table">

	<thead>
	<tr>
	<th>From</th>
	<th>Module</th>
    <th>Subject</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT DISTINCT r.feedbackid, d.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.studentno, d.degree, m.moduleid, m.module_name, m.module_notes, m.module_url, f.feedbackid, f.feedback_subject, f.feedback_body, DATE_FORMAT(f.created_on,'%d %b %y %H:%i') as created_on, f.isApproved, r.isRead FROM user_feedback_received r LEFT JOIN user_detail d ON r.feedback_from=d.userid LEFT JOIN system_module m ON r.moduleid=m.moduleid LEFT JOIN user_feedback f ON r.feedbackid=f.feedbackid WHERE f.isApproved=0 AND r.isRead = 0");

	while($row = $stmt1->fetch_assoc()) {

    $feedbackid = $row["feedbackid"];
    $userid = $row["userid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);
    $dateofbirth = $row["dateofbirth"];
    $studentno = $row["studentno"];
    $degree = $row["degree"];
    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
    $module_notes = $row["module_notes"];
    $module_url = $row["module_url"];
	$feedback_subject = $row["feedback_subject"];
    $feedback_body = $row["feedback_body"];
    $created_on = $row["created_on"];
    $isApproved = $row["isApproved"];
    $isRead = $row["isRead"];

	echo '<tr id="feedback-'.$feedbackid.'">

			<td data-title="From"><a href="#view-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Module"><a href="#view-submitted-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Subject"><a href="#view-submitted-feedback-'.$feedbackid.'" data-toggle="modal">'.$feedback_subject.'</a></td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="#approve-feedback-'.$feedbackid.'" data-toggle="modal">Approve</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-feedback-'.$feedbackid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

            <div id="view-user-'.$userid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Gender:</b> '.(empty($gender) ? "-" : "$gender").'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Student number:</b> '.(empty($studentno) ? "-" : "$studentno").'</p>
			<p><b>Degree:</b> '.(empty($degree) ? "-" : "$degree").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-submitted-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="view-submitted-feedback-'.$feedbackid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$feedback_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Feedback:</b> '.(empty($feedback_body) ? "-" : "$feedback_body").'</p>
			<p><b>Submitted:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Approved:</b> '.($isApproved == 0 ? "No" : "Yes").'</p>
			<p><b>Read:</b> '.($isRead == 0 ? "No" : "Yes").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#delete-feedback-'.$feedbackid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="approve-feedback-'.$feedbackid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="approve-feedback-question" class="text-center feedback-sad">Are you sure you want to approve '.$feedback_subject.'?</p>
			<p id="approve-feedback-confirmation" style="display: none;" class="text-center feedback-happy">'.$feedback_subject.' has been approved successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="approve-feedback-hide">
			<div class="pull-left">
			<a id="approve-'.$feedbackid.'" class="btn btn-success btn-lg approve-feedback-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="approve-feedback-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-feedback-'.$feedbackid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-feedback-question" class="text-center feedback-sad">Are you sure you want to delete '.$feedback_subject.'?</p>
			<p id="delete-feedback-confirmation" style="display: none;" class="text-center feedback-happy">'.$feedback_subject.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-feedback-hide">
			<div class="pull-left">
			<a id="delete-'.$feedbackid.'" class="btn btn-success btn-lg delete-feedback-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-feedback-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Feedback to delete</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Feedback to delete -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom feedback-table">

	<thead>
	<tr>
	<th>Module</th>
    <th>Subject</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT f.feedbackid, f.feedback_subject, f.feedback_body, f.created_on, f.moduleid, m.module_name, m.module_notes, m.module_url FROM user_feedback f LEFT JOIN system_module m ON f.moduleid=m.moduleid WHERE f.feedbackid NOT IN (SELECT feedbackid FROM user_feedback_sent) AND f.feedbackid NOT IN (SELECT feedbackid FROM user_feedback_received)");

	while($row = $stmt1->fetch_assoc()) {

    $feedbackid = $row["feedbackid"];
    $userid = $row["userid"];
    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
    $module_notes = $row["module_notes"];
    $module_url = $row["module_url"];
	$feedback_subject = $row["feedback_subject"];
    $feedback_body = $row["feedback_body"];
    $created_on = $row["created_on"];

	echo '<tr id="feedback-'.$feedbackid.'">

			<td data-title="Module"><a href="#view-submitted-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Subject"><a href="#view-submitted-feedback-'.$feedbackid.'" data-toggle="modal">'.$feedback_subject.'</a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md" href="#delete-feedback-'.$feedbackid.'" data-toggle="modal">Delete</span></a></td>
			</tr>

			<div id="view-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "-" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "-" : "$module_url").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="view-submitted-feedback-'.$feedbackid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-check-square-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$feedback_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Feedback:</b> '.(empty($feedback_body) ? "-" : "$feedback_body").'</p>
			<p><b>Submitted:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#delete-feedback-'.$feedbackid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm" >Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-feedback-'.$feedbackid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-feedback-question" class="text-center feedback-sad">Are you sure you want to delete '.$feedback_subject.'?</p>
			<p id="delete-feedback-confirmation" style="display: none;" class="text-center feedback-happy">'.$feedback_subject.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-feedback-hide">
			<div class="pull-left">
			<a id="delete-'.$feedbackid.'" class="btn btn-success btn-lg delete-feedback-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-feedback-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>

	<script>



	//DataTables
    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no records to display."
		}
	});

    $("body").on("click", ".approve-feedback-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var feedbackToApprove = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'feedbackToApprove='+ feedbackToApprove,
	success:function(){
        $('#feedback-'+feedbackToApprove).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#approve-feedback-question').hide();
        $('#approve-feedback-confirmation').show();
        $('#approve-feedback-hide').hide();
        $('#approve-feedback-success-button').show();
        $("#approve-feedback-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete feedback
    $("body").on("click", ".delete-feedback-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var feedbackToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'feedbackToDelete='+ feedbackToDelete,
	success:function(){
		$('#feedback-'+feedbackToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-feedback-question').hide();
        $('#delete-feedback-confirmation').show();
        $('#delete-feedback-hide').hide();
        $('#delete-feedback-success-button').show();
        $("#delete-feedback-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

   //Delete sent feedback
    $("body").on("click", ".delete-sent-feedback-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var sentFeedbackToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'sentFeedbackToDelete='+ sentFeedbackToDelete,
	success:function(){
		$('#feedback-'+sentFeedbackToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-feedback-question').hide();
        $('#delete-feedback-confirmation').show();
        $('#delete-feedback-hide').hide();
        $('#delete-feedback-success-button').show();
        $("#delete-feedback-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

   //Delete received feedback
    $("body").on("click", ".delete-received-feedback-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var receivedFeedbackToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'receivedFeedbackToDelete='+ receivedFeedbackToDelete,
	success:function(){
        $('#feedback-'+receivedFeedbackToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-feedback-question').hide();
        $('#delete-feedback-confirmation').show();
        $('#delete-feedback-hide').hide();
        $('#delete-feedback-success-button').show();
        $("#delete-feedback-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    var feedback_read;
    feedback_read = '1';

	$("#feedback-read-trigger").click(function (e) {
	e.preventDefault();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'feedback_read=' + feedback_read,
    success:function() {
    },
    error:function (xhr, ajaxOptions, thrownError) {
    }
	});
	});
	</script>

</body>
</html>
