<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $session_userid;

AdminTimetableUpdate();

global $active_module;
global $active_lecture;
global $active_tutorial;
global $inactive_module;
global $inactive_lecture;
global $inactive_tutorial;

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Timetable</title>

    <?php include 'assets/css-paths/select2-css-path.php'; ?>
    <?php include 'assets/css-paths/datatables-css-path.php'; ?>
    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Timetable</li>
    </ol>

    <div id="today" style="display: none;"><?php echo date("l"); ?></div>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a id="panel-monday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Monday</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Monday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-student-class">

	<thead>
	<tr>
	<th>Name</th>
    <th>Academic staff</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid LEFT JOIN user_detail d ON l.lecture_lecturer = d.userid WHERE l.lecture_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Monday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_lecturer = $row["lecture_lecturer"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid LEFT JOIN user_detail d ON t.tutorial_assistant = d.userid WHERE t.tutorial_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Monday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_assistant = $row["tutorial_assistant"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a id="panel-tuesday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tuesday</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tuesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-student-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
	</tr>
	</thead>

	<tbody>
    <?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid LEFT JOIN user_detail d ON l.lecture_lecturer = d.userid WHERE l.lecture_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Tuesday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_lecturer = $row["lecture_lecturer"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid LEFT JOIN user_detail d ON t.tutorial_assistant = d.userid WHERE t.tutorial_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Tuesday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_assistant = $row["tutorial_assistant"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a id="panel-wednesday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Wednesday</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Wednesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-student-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
	</tr>
	</thead>

	<tbody>
    <?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid LEFT JOIN user_detail d ON l.lecture_lecturer = d.userid WHERE l.lecture_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Wednesday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_lecturer = $row["lecture_lecturer"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid LEFT JOIN user_detail d ON t.tutorial_assistant = d.userid WHERE t.tutorial_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Wednesday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_assistant = $row["tutorial_assistant"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a id="panel-thursday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Thursday</a>
    </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Thursday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-student-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
	</tr>
	</thead>

	<tbody>
    <?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid LEFT JOIN user_detail d ON l.lecture_lecturer = d.userid WHERE l.lecture_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Thursday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_lecturer = $row["lecture_lecturer"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid LEFT JOIN user_detail d ON t.tutorial_assistant = d.userid WHERE t.tutorial_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Thursday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_assistant = $row["tutorial_assistant"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFive">
  	<h4 class="panel-title">
	<a id="panel-friday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive"> Friday</a>
    </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Friday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-student-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
	</tr>
	</thead>

	<tbody>
    <?php
    $stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid LEFT JOIN user_detail d ON l.lecture_lecturer = d.userid WHERE l.lecture_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Friday' AND DATE(l.lecture_to_date) > DATE(NOW())");

    while($row = $stmt1->fetch_assoc()) {

        $lectureid = $row["lectureid"];
        $lecture_name = $row["lecture_name"];
        $lecture_lecturer = $row["lecture_lecturer"];
        $lecture_notes= $row["lecture_notes"];
        $module_url = $row["module_url"];
        $firstname = $row["firstname"];
        $surname = $row["surname"];
        $lecture_day = $row["lecture_day"];
        $lecture_from_time = $row["lecture_from_time"];
        $lecture_to_time = $row["lecture_to_time"];
        $lecture_location = $row["lecture_location"];
        $lecture_capacity = $row["lecture_capacity"];

        echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
    }

    $stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid LEFT JOIN user_detail d ON t.tutorial_assistant = d.userid WHERE t.tutorial_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Friday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

    while($row = $stmt2->fetch_assoc()) {

        $tutorialid = $row["tutorialid"];
        $tutorial_name = $row["tutorial_name"];
        $tutorial_assistant = $row["tutorial_assistant"];
        $tutorial_notes = $row["tutorial_notes"];
        $module_url = $row["module_url"];
        $firstname = $row["firstname"];
        $surname = $row["surname"];
        $tutorial_day = $row["tutorial_day"];
        $tutorial_from_time = $row["tutorial_from_time"];
        $tutorial_to_time = $row["tutorial_to_time"];
        $tutorial_location = $row["tutorial_location"];
        $tutorial_capacity = $row["tutorial_capacity"];

        echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="Academic staff">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Academic staff:</b> '.$firstname.' '.$surname.'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>
    $( document ).ready(function() {
        var today = $('#today').html();

        if (today == 'Monday') {
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-monday').removeClass("collapsed");
            $('#collapseOne').addClass("in");
        } else if (today == 'Tuesday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-tuesday').removeClass("collapsed");
            $('#collapseTwo').addClass("in");
        } else if (today == 'Wednesday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-wednesday').removeClass("collapsed");
            $('#collapseThree').addClass("in");
        } else if (today == 'Thursday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-thursday').removeClass("collapsed");
            $('#collapseFour').addClass("in");
        } else if (today == 'Friday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#panel-friday').removeClass("collapsed");
            $('#collapseFive').addClass("in");
        }
    });

    student_settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "You have no classes on this day."
        }
    };

    //DataTables
    $('.table-student-class').dataTable(student_settings);
    </script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'academic staff') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Timetable</li>
    </ol>

    <div id="today" style="display: none;"><?php echo date("l"); ?></div>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a id="panel-monday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Monday</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Monday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-academic-staff-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid WHERE l.lecture_status = 'active' AND l.lecture_lecturer = '$session_userid' AND l.lecture_day = 'Monday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid WHERE t.tutorial_status = 'active' AND t.tutorial_assistant = '$session_userid' AND t.tutorial_day = 'Monday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a id="panel-tuesday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tuesday</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tuesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-academic-staff-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid WHERE l.lecture_status = 'active' AND l.lecture_lecturer = '$session_userid' AND l.lecture_day = 'Tuesday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid WHERE t.tutorial_status = 'active' AND t.tutorial_assistant = '$session_userid' AND t.tutorial_day = 'Tuesday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a id="panel-wednesday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Wednesday</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Wednesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-academic-staff-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid WHERE l.lecture_status = 'active' AND l.lecture_lecturer = '$session_userid' AND l.lecture_day = 'Wednesday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid WHERE t.tutorial_status = 'active' AND t.tutorial_assistant = '$session_userid' AND t.tutorial_day = 'Wednesday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a id="panel-thursday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Thursday</a>
    </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Thursday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-academic-staff-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid WHERE l.lecture_status = 'active' AND l.lecture_lecturer = '$session_userid' AND l.lecture_day = 'Thursday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid WHERE t.tutorial_status = 'active' AND t.tutorial_assistant = '$session_userid' AND t.tutorial_day = 'Thursday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFive">
  	<h4 class="panel-title">
	<a id="panel-friday" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive"> Friday</a>
    </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Friday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-academic-staff-class">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lecture l LEFT JOIN user_lecture u ON l.lectureid = u.lectureid LEFT JOIN system_module m ON l.moduleid = m.moduleid WHERE l.lecture_status = 'active' AND l.lecture_lecturer = '$session_userid' AND l.lecture_day = 'Friday' AND DATE(l.lecture_to_date) > DATE(NOW())");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
    $lecture_name = $row["lecture_name"];
    $lecture_notes= $row["lecture_notes"];
    $module_url = $row["module_url"];
    $lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
    $lecture_capacity = $row["lecture_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-lecture-'.$lectureid.'" data-toggle="modal">'.$lecture_name.'</a></td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>

			<div id="view-lecture-'.$lectureid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$lecture_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($lecture_notes) ? "No description" : "$lecture_notes").'</p>
			<p><b>Day:</b> '.$lecture_day.'</p>
			<p><b>From:</b> '.$lecture_from_time.'</p>
			<p><b>To:</b> '.$lecture_to_time.'</p>
			<p><b>Location:</b> '.$lecture_location.'</p>
			<p><b>Capacity:</b> '.$lecture_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t LEFT JOIN user_tutorial u ON t.tutorialid = u.tutorialid LEFT JOIN system_module m ON t.moduleid = m.moduleid WHERE t.tutorial_status = 'active' AND t.tutorial_assistant = '$session_userid' AND t.tutorial_day = 'Friday' AND DATE(t.tutorial_to_date) > DATE(NOW())");

	while($row = $stmt2->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
    $tutorial_name = $row["tutorial_name"];
    $tutorial_notes = $row["tutorial_notes"];
    $module_url = $row["module_url"];
    $tutorial_day = $row["tutorial_day"];
    $tutorial_from_time = $row["tutorial_from_time"];
    $tutorial_to_time = $row["tutorial_to_time"];
    $tutorial_location = $row["tutorial_location"];
    $tutorial_capacity = $row["tutorial_capacity"];

	echo '<tr>

			<td data-title="Name"><a href="#view-tutorial-'.$tutorialid.'" data-toggle="modal">'.$tutorial_name.'</a></td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>

			<div id="view-tutorial-'.$tutorialid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$tutorial_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($tutorial_notes) ? "No description" : "$tutorial_notes").'</p>
			<p><b>Day:</b> '.$tutorial_day.'</p>
			<p><b>From:</b> '.$tutorial_from_time.'</p>
			<p><b>To:</b> '.$tutorial_to_time.'</p>
			<p><b>Location:</b> '.$tutorial_location.'</p>
			<p><b>Capacity:</b> '.$tutorial_capacity.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="'.$module_url.'" class="btn btn-primary btn-sm" >Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm" >Feedback</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>
    $( document ).ready(function() {
        var today = $('#today').html();

        if (today == 'Monday') {
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-monday').removeClass("collapsed");
            $('#collapseOne').addClass("in");
        } else if (today == 'Tuesday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-tuesday').removeClass("collapsed");
            $('#collapseTwo').addClass("in");
        } else if (today == 'Wednesday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-wednesday').removeClass("collapsed");
            $('#collapseThree').addClass("in");
        } else if (today == 'Thursday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-friday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFive').removeClass("in");
            $('#panel-thursday').removeClass("collapsed");
            $('#collapseFour').addClass("in");
        } else if (today == 'Friday') {
            $('#panel-monday').addClass("collapsed");
            $('#panel-tuesday').addClass("collapsed");
            $('#panel-wednesday').addClass("collapsed");
            $('#panel-thursday').addClass("collapsed");
            $('#collapseOne').removeClass("in");
            $('#collapseTwo').removeClass("in");
            $('#collapseThree').removeClass("in");
            $('#collapseFour').removeClass("in");
            $('#panel-friday').removeClass("collapsed");
            $('#collapseFive').addClass("in");
        }
    });

    academic_staff_settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

    //DataTables
    $('.table-academic-staff-class').dataTable(academic_staff_settings);
    </script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../home/">Home</a></li>
    <li class="active">Timetable</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin" href="/admin/create-module/">Create module</span></a>
    <a class="btn btn-success btn-lg btn-admin" href="/admin/create-lecture/">Create lecture</span></a>
    <a class="btn btn-success btn-lg btn-admin" href="/admin/create-tutorial/">Create tutorial</span></a>

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Active modules</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Active modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-module">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>Moodle link</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-module">
	<?php
    echo $active_module;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Active lectures</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Active lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-lecture">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>From</th>
	<th>To</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-lecture">
    <?php
    echo $active_lecture;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Active tutorials</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Active tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-tutorial">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>From</th>
	<th>To</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-tutorial">
    <?php
    echo $active_tutorial;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Inactive modules</a>
    </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Inactive modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-module">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>Moodle link</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-module">
	<?php
    echo $inactive_module;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFive">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive"> Inactive lectures</a>
    </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Inactive lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-lecture">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>From</th>
	<th>To</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-lecture">
    <?php
    echo $inactive_lecture;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSix">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix"> Inactive tutorials</a>
    </h4>
    </div>
    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
  	<div class="panel-body">

	<!-- Inactive tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-tutorial">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>From</th>
	<th>To</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-tutorial">
    <?php
    echo $inactive_tutorial;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

    </div><!-- /container -->

    <div id="error-modal" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
    <div class="form-logo text-center">
    <i class="fa fa-exclamation"></i>
    </div>
    </div>

    <div class="modal-body">
    <p class="text-center feedback-sad"></p>
    </div>

    <div class="modal-footer">
    <div class="view-close text-center">
    <a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>
    admin_settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

	//DataTables
    $('.table-active-module').dataTable(admin_settings);
    $('.table-active-lecture').dataTable(admin_settings);
    $('.table-active-tutorial').dataTable(admin_settings);
    $('.table-inactive-module').dataTable(admin_settings);
    $('.table-inactive-lecture').dataTable(admin_settings);
    $('.table-inactive-tutorial').dataTable(admin_settings);

    //Deactivate module
    $("body").on("click", ".btn-deactivate-module", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var moduleToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'moduleToDeactivate='+ moduleToDeactivate,
	success:function(html){

        $(".table-active-module").dataTable().fnDestroy();
        $('#content-active-module').empty();
        $('#content-active-module').html(html.active_module);
        $(".table-active-module").dataTable(admin_settings);

        $(".table-inactive-module").dataTable().fnDestroy();
        $('#content-inactive-module').empty();
        $('#content-inactive-module').html(html.inactive_module);
        $(".table-inactive-module").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Deactivate lecture
    $("body").on("click", ".btn-deactivate-lecture", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var lectureToDeactivate = clickedID[1];

    alert(lectureToDeactivate);

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'lectureToDeactivate='+ lectureToDeactivate,
	success:function(html){

        $(".table-active-lecture").dataTable().fnDestroy();
        $('#content-active-lecture').empty();
        $('#content-active-lecture').html(html.active_lecture);
        $(".table-active-lecture").dataTable(admin_settings);

        $(".table-inactive-lecture").dataTable().fnDestroy();
        $('#content-inactive-lecture').empty();
        $('#content-inactive-lecture').html(html.inactive_lecture);
        $(".table-inactive-lecture").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Deactivate tutorial
    $("body").on("click", ".btn-deactivate-tutorial", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var tutorialToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'tutorialToDeactivate='+ tutorialToDeactivate,
	success:function(html){

        $(".table-active-tutorial").dataTable().fnDestroy();
        $('#content-active-tutorial').empty();
        $('#content-active-tutorial').html(html.active_tutorial);
        $(".table-active-tutorial").dataTable(admin_settings);

        $(".table-inactive-tutorial").dataTable().fnDestroy();
        $('#content-inactive-tutorial').empty();
        $('#content-inactive-tutorial').html(html.inactive_tutorial);
        $(".table-inactive-tutorial").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate module
    $("body").on("click", ".btn-reactivate-module", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var moduleToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'moduleToReactivate='+ moduleToReactivate,
	success:function(html){

        $(".table-inactive-module").dataTable().fnDestroy();
        $('#content-inactive-module').empty();
        $('#content-inactive-module').html(html.inactive_module);
        $(".table-inactive-module").dataTable(admin_settings);

        $(".table-inactive-tutorial").dataTable().fnDestroy();
        $('#content-inactive-tutorial').empty();
        $('#content-inactive-tutorial').html(html.inactive_tutorial);
        $(".table-inactive-tutorial").dataTable(admin_settings);

        $(".table-active-tutorial").dataTable().fnDestroy();
        $('#content-active-tutorial').empty();
        $('#content-active-tutorial').html(html.active_tutorial);
        $(".table-active-tutorial").dataTable(admin_settings);

        $(".table-inactive-lecture").dataTable().fnDestroy();
        $('#content-inactive-lecture').empty();
        $('#content-inactive-lecture').html(html.inactive_lecture);
        $(".table-inactive-lecture").dataTable(admin_settings);

        $(".table-active-lecture").dataTable().fnDestroy();
        $('#content-active-lecture').empty();
        $('#content-active-lecture').html(html.active_lecture);
        $(".table-active-lecture").dataTable(admin_settings);

        $(".table-active-module").dataTable().fnDestroy();
        $('#content-active-module').empty();
        $('#content-active-module').html(html.active_module);
        $(".table-active-module").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate lecture
    $("body").on("click", ".btn-reactivate-lecture", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var lectureToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'lectureToReactivate='+ lectureToReactivate,
	success:function(html){
        if (html) {
            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(html);
            $('#error-modal').modal('show');
        } else {
            $(".table-inactive-lecture").dataTable().fnDestroy();
            $('#content-inactive-lecture').empty();
            $('#content-inactive-lecture').html(html.inactive_lecture);
            $(".table-inactive-lecture").dataTable(admin_settings);

            $(".table-active-lecture").dataTable().fnDestroy();
            $('#content-active-lecture').empty();
            $('#content-active-lecture').html(html.active_lecture);
            $(".table-active-lecture").dataTable(admin_settings);
        }
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate tutorial
    $("body").on("click", ".btn-reactivate-tutorial", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var tutorialToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'tutorialToReactivate='+ tutorialToReactivate,
	success:function(errormsg){
        if (errormsg) {
            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(errormsg);
            $('#error-modal').modal('show');
        } else {
            $(".table-inactive-tutorial").dataTable().fnDestroy();
            $('#content-inactive-tutorial').empty();
            $('#content-inactive-tutorial').html(html.inactive_tutorial);
            $(".table-inactive-tutorial").dataTable(admin_settings);

            $(".table-active-tutorial").dataTable().fnDestroy();
            $('#content-active-tutorial').empty();
            $('#content-active-tutorial').html(html.active_tutorial);
            $(".table-active-tutorial").dataTable(admin_settings);
        }
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete module
    $("body").on("click", ".btn-delete-module", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var moduleToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'moduleToDelete='+ moduleToDelete,
	success:function(){

        $(".table-active-module").dataTable().fnDestroy();
        $('#content-active-module').empty();
        $('#content-active-module').html(html.active_module);
        $(".table-active-module").dataTable(admin_settings);

        $(".table-inactive-module").dataTable().fnDestroy();
        $('#content-inactive-module').empty();
        $('#content-inactive-module').html(html.inactive_module);
        $(".table-inactive-module").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete lecture
    $("body").on("click", ".btn-delete-lecture", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var lectureToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'lectureToDelete='+ lectureToDelete,
	success:function(){
        $(".table-active-lecture").dataTable().fnDestroy();
        $('#content-active-lecture').empty();
        $('#content-active-lecture').html(html.active_lecture);
        $(".table-active-lecture").dataTable(admin_settings);

        $(".table-inactive-lecture").dataTable().fnDestroy();
        $('#content-inactive-lecture').empty();
        $('#content-inactive-lecture').html(html.inactive_lecture);
        $(".table-inactive-lecture").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete tutorial
    $("body").on("click", ".btn-delete-tutorial", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var tutorialToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'tutorialToDelete='+ tutorialToDelete,
	success:function(){
        $(".table-active-tutorial").dataTable().fnDestroy();
        $('#content-active-tutorial').empty();
        $('#content-active-tutorial').html(html.active_tutorial);
        $(".table-active-tutorial").dataTable(admin_settings);

        $(".table-inactive-tutorial").dataTable().fnDestroy();
        $('#content-inactive-tutorial').empty();
        $('#content-inactive-tutorial').html(html.inactive_tutorial);
        $(".table-inactive-tutorial").dataTable(admin_settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
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
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

</body>
</html>
