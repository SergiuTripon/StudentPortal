<?php
include 'includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Timetable</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Calendar</li>
    </ol>

	<br>

    <h3 class="feedback-custom">Lectures</h3>
    <hr class="hr-thin">

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Monday</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Monday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_notes, system_lectures.lecture_from_time, system_lectures.lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = '$userid' AND system_lectures.lecture_day = 'Monday' LIMIT 1");

	while($row = $stmt2->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["lecture_name"].'</td>
			<td data-title="Notes">'.$row["lecture_notes"].'</td>
			<td data-title="From">'.$row["lecture_from_time"].'</td>
			<td data-title="To">'.$row["lecture_to_time"].'</td>
			<td data-title="Location">'.$row["lecture_location"].'</td>
			<td data-title="Capacity">'.$row["lecture_capacity"].'</td>
			</tr>';
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
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Tuesday</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tuesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_notes, system_lectures.lecture_from_time, system_lectures.lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = '$userid' AND system_lectures.lecture_day = 'Tuesday' LIMIT 1");

	while($row = $stmt2->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["lecture_name"].'</td>
			<td data-title="Notes">'.$row["lecture_notes"].'</td>
			<td data-title="From">'.$row["lecture_from_time"].'</td>
			<td data-title="To">'.$row["lecture_to_time"].'</td>
			<td data-title="Location">'.$row["lecture_location"].'</td>
			<td data-title="Capacity">'.$row["lecture_capacity"].'</td>
			</tr>';
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
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Wednesday</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Wednesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_notes, system_lectures.lecture_from_time, system_lectures.lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = '$userid' AND system_lectures.lecture_day = 'Wednesday' LIMIT 1");

	while($row = $stmt3->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["lecture_name"].'</td>
			<td data-title="Notes">'.$row["lecture_notes"].'</td>
			<td data-title="From">'.$row["lecture_from_time"].'</td>
			<td data-title="To">'.$row["lecture_to_time"].'</td>
			<td data-title="Location">'.$row["lecture_location"].'</td>
			<td data-title="Capacity">'.$row["lecture_capacity"].'</td>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">Thursday</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headindFour">
  	<div class="panel-body">

	<!-- Thursday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt4 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_notes, system_lectures.lecture_from_time, system_lectures.lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = '$userid' AND system_lectures.lecture_day = 'Thursday' LIMIT 1");

	while($row = $stmt4->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["lecture_name"].'</td>
			<td data-title="Notes">'.$row["lecture_notes"].'</td>
			<td data-title="From">'.$row["lecture_from_time"].'</td>
			<td data-title="To">'.$row["lecture_to_time"].'</td>
			<td data-title="Location">'.$row["lecture_location"].'</td>
			<td data-title="Capacity">'.$row["lecture_capacity"].'</td>
			</tr>';
	}

	$stmt4->close();
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
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">Friday</a>
  	</h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Friday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt5 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_notes, system_lectures.lecture_from_time, system_lectures.lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid = '$userid' AND system_lectures.lecture_day = 'Friday' LIMIT 1");

	while($row = $stmt5->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["lecture_name"].'</td>
			<td data-title="Notes">'.$row["lecture_notes"].'</td>
			<td data-title="From">'.$row["lecture_from_time"].'</td>
			<td data-title="To">'.$row["lecture_to_time"].'</td>
			<td data-title="Location">'.$row["lecture_location"].'</td>
			<td data-title="Capacity">'.$row["lecture_capacity"].'</td>
			</tr>';
	}

	$stmt5->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    <br>

    <h3 class="feedback-custom">Tutorials</h3>
    <hr class="hr-thin">

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingSix">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">Monday</a>
  	</h4>
    </div>
    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
  	<div class="panel-body">

	<!-- Monday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt6 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_notes, system_tutorials.tutorial_from_time, system_tutorials.tutorial_from_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = '$userid' AND system_tutorials.tutorial_day = 'Monday' LIMIT 1");

	while($row = $stmt6->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["tutorial_name"].'</td>
			<td data-title="Notes">'.$row["tutorial_notes"].'</td>
			<td data-title="From">'.$row["tutorial_from_time"].'</td>
			<td data-title="To">'.$row["tutorial_to_time"].'</td>
			<td data-title="Location">'.$row["tutorial_location"].'</td>
			<td data-title="Capacity">'.$row["tutorial_capacity"].'</td>
			</tr>';
	}

	$stmt6->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

   	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingSeven">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">Tuesday</a>
  	</h4>
    </div>
    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
  	<div class="panel-body">

	<!-- Tuesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt7 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_notes, system_tutorials.tutorial_from_time, system_tutorials.tutorial_from_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = '$userid' AND system_tutorials.tutorial_day = 'Tuesday' LIMIT 1");

	while($row = $stmt7->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["tutorial_name"].'</td>
			<td data-title="Notes">'.$row["tutorial_notes"].'</td>
			<td data-title="From">'.$row["tutorial_from_time"].'</td>
			<td data-title="To">'.$row["tutorial_to_time"].'</td>
			<td data-title="Location">'.$row["tutorial_location"].'</td>
			<td data-title="Capacity">'.$row["tutorial_capacity"].'</td>
			</tr>';
	}

	$stmt7->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingEight">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight">Wednesday</a>
  	</h4>
    </div>
    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
  	<div class="panel-body">

	<!-- Wednesday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt8 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_notes, system_tutorials.tutorial_from_time, system_tutorials.tutorial_from_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = '$userid' AND system_tutorials.tutorial_day = 'Wednesday' LIMIT 1");

	while($row = $stmt8->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["tutorial_name"].'</td>
			<td data-title="Notes">'.$row["tutorial_notes"].'</td>
			<td data-title="From">'.$row["tutorial_from_time"].'</td>
			<td data-title="To">'.$row["tutorial_to_time"].'</td>
			<td data-title="Location">'.$row["tutorial_location"].'</td>
			<td data-title="Capacity">'.$row["tutorial_capacity"].'</td>
			</tr>';
	}

	$stmt8->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingNine">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">Thursday</a>
  	</h4>
    </div>
    <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headindNine">
  	<div class="panel-body">

	<!-- Thursday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt9 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_notes, system_tutorials.tutorial_from_time, system_tutorials.tutorial_from_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = '$userid' AND system_tutorials.tutorial_day = 'Thursday' LIMIT 1");

	while($row = $stmt9->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["tutorial_name"].'</td>
			<td data-title="Notes">'.$row["tutorial_notes"].'</td>
			<td data-title="From">'.$row["tutorial_from_time"].'</td>
			<td data-title="To">'.$row["tutorial_to_time"].'</td>
			<td data-title="Location">'.$row["tutorial_location"].'</td>
			<td data-title="Capacity">'.$row["tutorial_capacity"].'</td>
			</tr>';
	}

	$stmt9->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTen">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="true" aria-controls="collapseTen">Friday - <?php echo $nolectures; ?></a>
  	</h4>
    </div>
    <div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen">
  	<div class="panel-body">

	<!-- Friday -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt10 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_notes, system_tutorials.tutorial_from_time, system_tutorials.tutorial_from_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid = '$userid' AND system_tutorials.tutorial_day = 'Friday' LIMIT 1");

	if ($stmt10->num_rows == 0) {
		$nolectures = 'You have no lectures on this day!';
	}

	while($row = $stmt10->fetch_assoc()) {

	echo '<tr>

			<td data-title="Name">'.$row["tutorial_name"].'</td>
			<td data-title="Notes">'.$row["tutorial_notes"].'</td>
			<td data-title="From">'.$row["tutorial_from_time"].'</td>
			<td data-title="To">'.$row["tutorial_to_time"].'</td>
			<td data-title="Location">'.$row["tutorial_location"].'</td>
			<td data-title="Capacity">'.$row["tutorial_capacity"].'</td>
			</tr>';
	}

	$stmt10->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/portal_footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<style>
    html, body {
		height: 100% !important;
    }
    </style>

    <header class="intro">
    <div class="intro-body">

	<form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

	</div><!-- /intro-body -->
    </header>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>

	<script type="text/javascript" class="init">
    $(document).ready(function () {

	//DataTables
    $('.lecture-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "You have no lectures on this day."
		}
	});

    $('.tutorial-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "You have no tutorials on this day."
		}
	});

	//Ajax call
	$("body").on("click", ".complete-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];
    var myData = 'recordToComplete='+ DbNumberID;

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:myData,
	success:function(response){
		$('#task-'+DbNumberID).fadeOut();
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

	$("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-task-form-" + DbNumberID).submit();

	});

	});

	</script>

</body>
</html>
