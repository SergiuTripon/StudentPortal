<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Feedback</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lectures</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_lecturer, system_lectures.lecture_day, DATE_FORMAT(system_lectures.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(system_lectures.lecture_to_time,'%H:%i') as lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid='$session_userid' AND system_lectures.lecture_status='active' LIMIT 1");

	while($row = $stmt1->fetch_assoc()) {

	$lecture_name = $row["lecture_name"];
	$lecture_lecturer = $row["lecture_lecturer"];
	$lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
	$lecture_capacity = $row["lecture_capacity"];

	$stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('i', $lecture_lecturer);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($firstname, $surname);
	$stmt2->fetch();

	echo '<tr>

			<td data-title="Name">'.$lecture_name.'</td>
			<td data-title="Lecturer">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_day.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>';
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tutorials</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Tutorial assistant</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_assistant, system_tutorials.tutorial_day, DATE_FORMAT(system_tutorials.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(system_tutorials.tutorial_to_time,'%H:%i') as tutorial_to_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid='$session_userid' AND system_tutorials.tutorial_status ='active' LIMIT 1");

	while($row = $stmt3->fetch_assoc()) {

	$tutorial_name = $row["tutorial_name"];
	$tutorial_assistant = $row["tutorial_assistant"];
	$tutorial_day = $row["tutorial_day"];
	$tutorial_from_time = $row["tutorial_from_time"];
	$tutorial_to_time = $row["tutorial_to_time"];
	$tutorial_location = $row["tutorial_location"];
	$tutorial_capacity = $row["tutorial_capacity"];

	$stmt4 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('i', $tutorial_assistant);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($firstname, $surname);
	$stmt4->fetch();

	echo '<tr>

			<td data-title="Name">'.$tutorial_name.'</td>
			<td data-title="Notes">'.$firstname.' '.$surname.'</td>
			<td data-title="Notes">'.$tutorial_day.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>';
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

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>


    <?php endif; ?>

    <?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
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
    $(document).ready(function () {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//DataTables
    $('.lecture-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no lectures to display."
		}
	});

    $('.tutorial-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no tutorials to display."
		}
	});

    $("body").on("click", ".assign-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#assign-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".cancel-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToCancel = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToCancel='+ timetableToCancel,
	success:function(){
		$('#cancel-'+timetableToCancel).fadeOut();
        setTimeout(function(){
            location.reload();
        }, 1000);
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

    $("body").on("click", ".activate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToActivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToActivate='+ timetableToActivate,
	success:function(){
		$('#activate-'+timetableToActivate).fadeOut();
        setTimeout(function(){
            location.reload();
        }, 1000);
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

	});

	</script>

</body>
</html>
