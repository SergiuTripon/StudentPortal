<?php
include 'includes/session.php';
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
    <li><a href="../overview/">Overview</a></li>
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
	<table class="table table-condensed table-custom class-table">

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
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lectures l LEFT JOIN system_modules m ON l.moduleid = m.moduleid LEFT JOIN user_timetable u ON l.moduleid = u.moduleid LEFT JOIN user_details d ON l.lecture_lecturer = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Monday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorials t LEFT JOIN system_modules m ON t.moduleid = m.moduleid LEFT JOIN user_timetable u ON t.moduleid = u.moduleid LEFT JOIN user_details d ON t.tutorial_assistant = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Monday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
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
	<table class="table table-condensed table-custom class-table">

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
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lectures l LEFT JOIN system_modules m ON l.moduleid = m.moduleid LEFT JOIN user_timetable u ON l.moduleid = u.moduleid LEFT JOIN user_details d ON l.lecture_lecturer = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Tuesday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorials t LEFT JOIN system_modules m ON t.moduleid = m.moduleid LEFT JOIN user_timetable u ON t.moduleid = u.moduleid LEFT JOIN user_details d ON t.tutorial_assistant = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Tuesday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
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
	<table class="table table-condensed table-custom class-table">

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
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lectures l LEFT JOIN system_modules m ON l.moduleid = m.moduleid LEFT JOIN user_timetable u ON l.moduleid = u.moduleid LEFT JOIN user_details d ON l.lecture_lecturer = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Wednesday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorials t LEFT JOIN system_modules m ON t.moduleid = m.moduleid LEFT JOIN user_timetable u ON t.moduleid = u.moduleid LEFT JOIN user_details d ON t.tutorial_assistant = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Wednesday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
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
	<table class="table table-condensed table-custom class-table">

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
	$stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lectures l LEFT JOIN system_modules m ON l.moduleid = m.moduleid LEFT JOIN user_timetable u ON l.moduleid = u.moduleid LEFT JOIN user_details d ON l.lecture_lecturer = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Thursday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorials t LEFT JOIN system_modules m ON t.moduleid = m.moduleid LEFT JOIN user_timetable u ON t.moduleid = u.moduleid LEFT JOIN user_details d ON t.tutorial_assistant = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Thursday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
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
	<table class="table table-condensed table-custom class-table">

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
    $stmt1 = $mysqli->query("SELECT l.lectureid, l.lecture_name, l.lecture_notes, m.module_url, d.firstname, d.surname, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') as lecture_to_time, l.lecture_location, l.lecture_capacity FROM system_lectures l LEFT JOIN system_modules m ON l.moduleid = m.moduleid LEFT JOIN user_timetable u ON l.moduleid = u.moduleid LEFT JOIN user_details d ON l.lecture_lecturer = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND l.lecture_day = 'Friday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$lecture_lecturer.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
    }

    $stmt1->close();

    $stmt2 = $mysqli->query("SELECT t.tutorialid, t.tutorial_name, t.tutorial_notes, m.module_url, d.firstname, d.surname, t.tutorial_day, DATE_FORMAT(t.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(t.tutorial_to_time,'%H:%i') as tutorial_to_time, t.tutorial_location, t.tutorial_capacity FROM system_tutorials t LEFT JOIN system_modules m ON t.moduleid = m.moduleid LEFT JOIN user_timetable u ON t.moduleid = u.moduleid LEFT JOIN user_details d ON t.tutorial_assistant = d.userid WHERE m.module_status = 'active' AND u.userid = '$session_userid' AND t.tutorial_day = 'Friday'");

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
            <a href="'.$module_url.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Moodle</a>
            <a href="../feedback/" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Feedback</a>
			<a href="../messenger/message-user?id='.$tutorial_assistant.'" class="btn btn-primary btn-sm ladda-button">Messenger</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Timetable</li>
    </ol>

    <a class="btn btn-success btn-lg ladda-button btn-admin" data-style="slide-up" href="/admin/create-timetable/"><span class="ladda-label">Create timetable</span></a>

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Active modules</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Active timetables -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>URL</th>
    <th>Lecturer</th>
    <th>Tutorial assistant</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url, l.lecture_lecturer, t.tutorial_assistant FROM system_modules m LEFT JOIN system_lectures l ON m.moduleid=l.moduleid LEFT JOIN system_tutorials t ON m.moduleid=t.moduleid WHERE m.module_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
	$module_notes = $row["module_notes"];
	$module_url = $row["module_url"];
    $lecture_lecturer = $row["lecture_lecturer"];
    $tutorial_assistant = $row["tutorial_assistant"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lecture_lecturer);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($lecturer_fistname, $lecturer_surname);
    $stmt2->fetch();

    $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt3->bind_param('i', $tutorial_assistant);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($tutorial_assistant_firstname, $tutorial_assistant_surname);
    $stmt3->fetch();

	echo '<tr id="timetable-'.$moduleid.'">

			<td data-title="Name"><a href="#view-module-'.$moduleid.'" data-toggle="modal">'.$module_name.'</a></td>
			<td data-title="Notes">'.($module_notes === '' ? "No notes" : "$module_notes").'</td>
            <td data-title="URL">'.($module_url === '' ? "No link" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Lecturer">'.$lecturer_fistname.' '.$lecturer_surname.'</td>
            <td data-title="Tutorial assistant">'.$tutorial_assistant_firstname.' '.$tutorial_assistant_surname.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/allocate-timetable?id='.$moduleid.'">Allocate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/update-timetable?id='.$moduleid.'">Update</a></li>
            <li><a href="#deactivate-'.$moduleid.'" data-toggle="modal">Deactivate</a></li>
            <li><a href="#delete-'.$moduleid.'" data-toggle="modal" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

            <div id="view-module-'.$moduleid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-clock-o"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$module_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($module_notes) ? "No description" : "$module_notes").'</p>
			<p><b>Moodle link:</b> '.(empty($module_url) ? "No link" : "$module_url").'</p>
			<p><b>Lecture:</b> '.$lecture_lecturer.' '.$lecturer_surname.'</p>
			<p><b>Tutorial assistant:</b> '.$lecture_lecturer.' '.$lecturer_surname.'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/allocate-timetable?id='.$moduleid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Allocate</a>
            <a href="/admin/update-timetable?id='.$moduleid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Update</a>
            <a href="#deactivate-'.$moduleid.'" data-toggle="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Deactivate</a>
            <a href="#delete-'.$moduleid.'" data-toggle="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="deactivate-'.$moduleid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="deactivate-question" class="text-center feedback-sad">Are you sure you want to deactivate '.$module_name.'?</p>
            <p id="deactivate-confirmation" style="display: none;" class="text-center feedback-happy">'.$module_name.' has been deactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="deactivate-hide">
			<div class="pull-left">
			<a id="deactivate-'.$moduleid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
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
			</div><!-- /modal-content -->

			<div id="delete-'.$moduleid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete '.$module_name.'?</p>
			<p id="delete-confirmation" style="display: none;" class="text-center feedback-happy">'.$module_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$moduleid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive modules</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive timetables -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>URL</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT moduleid, module_name, module_notes, module_url FROM system_modules WHERE module_status = 'inactive'");

	while($row = $stmt3->fetch_assoc()) {

    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
	$module_notes = $row["module_notes"];
	$module_url = $row["module_url"];

	echo '<tr id="timetable-'.$moduleid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Notes">'.(empty($module_notes) ? "No notes" : "$module_notes").'</td>
            <td data-title="URL">'.(empty($module_url) ? "No link" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Action">

			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#reactivate-'.$moduleid.'" data-toggle="modal">Reactivate</a>
            </div>
            </td>

			</tr>

			<div id="reactivate-'.$moduleid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="reactivate-question" class="text-center feedback-sad">Are you sure you want to reactivate '.$module_name.'?</p>
            <p id="reactivate-confirmation" class="text-center feedback-happy" style="display: none;">'.$module_name.' has been reactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="reactivate-hide">
			<div class="pull-left">
			<a id="reactivate-'.$moduleid.'" class="btn btn-danger btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="reactivate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt3->close();
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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/select2-js-path.php'; ?>
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

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//DataTables
    $('.class-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "You have no classes on this day."
		}
	});

    $('.module-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no modules to display."
		}
	});

    //Deactivate record
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToDeactivate='+ timetableToDeactivate,
	success:function(){
		$('#timetable-'+timetableToDeactivate).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#deactivate-question').hide();
        $('#deactivate-confirmation').show();
        $('#deactivate-hide').hide();
        $('#deactivate-success-button').show();
        $("#deactivate-success-button").click(function () {
            location.reload();
        });
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
    var timetableToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToReactivate='+ timetableToReactivate,
	success:function(){
		$('#timetable-'+timetableToReactivate).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#reactivate-question').hide();
        $('#reactivate-confirmation').show();
        $('#reactivate-hide').hide();
        $('#reactivate-success-button').show();
        $("#reactivate-success-button").click(function () {
            location.reload();
        });
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
    var timetableToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToDelete='+ timetableToDelete,
	success:function(){
		$('#timetable-'+timetableToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-question').hide();
        $('#delete-confirmation').show();
        $('#delete-hide').hide();
        $('#delete-success-button').show();
        $("#delete-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });
	</script>

</body>
</html>
