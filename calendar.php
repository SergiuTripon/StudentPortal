<?php
include 'includes/signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<!-- favicon -->
	<link rel="icon" href="../assets/img/favicon/favicon.ico">

	<!-- open-sans-font -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel='stylesheet' type="text/css">

	<!-- bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

	<!-- font-awesome -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- bootstrap calendar -->
	<link href="../assets/css/calendar/calendar.css" rel="stylesheet">

	<!-- common -->
	<link href="../assets/css/common/custom.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="../assets/css/common/html5shiv.min.js"></script>
	<script src="../assets/css/common/respond.min.js"></script>
	<![endif]-->

    <title>Student Portal | Calendar</title>

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
	
	<div class="row mb10">

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/create-task/">
    <div class="tile">
    <i class="fa fa-plus"></i>
	<p class="tile-text">Create a task</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a id="task-button">
    <div class="tile task-tile">
	<i class="fa fa-tasks"></i>
	<p class="tile-text">Task view</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a id="calendar-button">
	<div class="tile calendar-tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar view</p>
    </div>
    </a>
	</div>
	
	</div><!-- /row -->
	
	<div class="content-panel mb10" id="calendar-toggle">
	<h4><i class="fa fa-angle-right"></i> Calendar view</h4>
	
	<div class="pull-right form-inline">
	<div class="btn-group">
		<button class="btn btn-custom" data-calendar-nav="prev"><< Prev</button>
		<button class="btn btn-custom" data-calendar-nav="today">Today</button>
		<button class="btn btn-custom" data-calendar-nav="next">Next >></button>
	</div>
	<div class="btn-group">
		<button class="btn btn-custom" data-calendar-view="year">Year</button>
		<button class="btn btn-custom active" data-calendar-view="month">Month</button>
		<button class="btn btn-custom" data-calendar-view="week">Week</button>
		<button class="btn btn-custom" data-calendar-view="day">Day</button>
	</div>
	</div>
	
	<div class="page-header">
	<h3></h3>
	</div>
	
	<div id="calendar"></div>
	
	</div><!-- /content-panel -->
	
	<!-- Due tasks -->
	<div class="content-panel mb10" id="duetasks-toggle">
	<h4><i class="fa fa-angle-right"></i> Due tasks</h4>
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>External URL</th>
	<th>Start</th>
	<th>Due</th>
	<th>Category</th>
	<th>Complete</th>
	<th>Update</th>
	</tr>
	</thead>

	<tbody>	
	<?php

	$stmt1 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %Y %h:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %Y %h:%i') as task_duedate, task_category FROM user_tasks where userid = '$userid' AND task_status = 'active'");
	
	while($row = $stmt1->fetch_assoc()) {			
	  echo '<tr id="task-'.$row["taskid"].'">
		
			<td data-title="Name">'.$row["task_name"].'</td>
			<td class="notes-hide" data-title="Notes">'.$row["task_notes"].'</td>
			<td class="url-hide" data-title="External URL">'.$row["task_url"].'</td>
			<td data-title="Start date">'.$row["task_startdate"].'</td>
			<td data-title="Due date">'.$row["task_duedate"].'</td>
			<td data-title="Category">'.$row["task_category"].'</td>
			<td data-title="Complete"><a id="complete-'.$row["taskid"].'" class="complete-button"><i class="fa fa-check"></i></a></td>
			<td data-title="Update"><a id="update-'.$row["taskid"].'" class="update-button"><i class="fa fa-refresh"></i></a></td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>
	</div><!-- /content-panel -->
	
	<?php 
	
	$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %Y %h:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %Y %h:%i') as task_duedate, task_category, task_status FROM user_tasks where userid = '$userid'");

	while($row = $stmt2->fetch_assoc()) {			
	  echo '<form id="update-task-form-'.$row["taskid"].'" style="display: none;" action="../update-task/" method="POST">
			<input type="hidden" name="recordToUpdate" id="recordToUpdate" value="'.$row["taskid"].'"/>
			</form>';
	}
	
	$stmt2->close();
	?>

	<!-- Completed tasks -->
	<div class="content-panel mb10" id="completedtasks-toggle">
	<h4><i class="fa fa-angle-right"></i> Completed tasks</h4>
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>External URL</th>
	<th>Start</th>
	<th>Due</th>
	<th>Category</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %Y %h:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %Y %h:%i') as task_duedate, task_category FROM user_tasks where userid = '$userid' AND task_status = 'completed'");

	while($row = $stmt2->fetch_assoc()) {
	echo '<tr id="task-'.$row["taskid"].'">

	<td data-title="Name">'.$row["task_name"].'</td>
	<td data-title="Notes">'.$row["task_notes"].'</td>
	<td data-title="External URL">'.$row["task_url"].'</td>
	<td data-title="Start date">'.$row["task_startdate"].'</td>
	<td data-title="Due date">'.$row["task_duedate"].'</td>
	<td data-title="Category">'.$row["task_category"].'</td>
	</tr>';
	}

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>
	</div><!-- /content-panel -->
	
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

	<!-- pace-js -->
	<script src="../assets/js/pace-js/spin.min.js"></script>
	<script src="../assets/js/pace-js/pace.js"></script>

	<!-- js library -->
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>

	<!-- bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<!-- tile-js -->
	<script src="../assets/js/tile-js/tileJs.min.js"></script>

	<!-- dataTables JS -->
	<script src="../assets/js/data-tables/jquery.dataTables.min.js"></script>

	<!-- Bootstrap Calendar JS -->
	<script src="../assets/js/calendar/jstz.min.js"></script>
	<script src="../assets/js/calendar/underscore.min.js"></script>
	<script src="../assets/js/calendar/calendar.js"></script>
	<script src="../assets/js/calendar/calendar-app.js"></script>

	<!-- common-->
	<script src="../assets/js/common/custom.js"></script>
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

	<script type="text/javascript" class="init">
    $(document).ready(function () {
    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no tasks at the moment."
		}
	});
    });
	</script>
	
	<script>
		
	$(document).ready(function() {

	$("body").on("click", ".complete-button", function(e) {
    e.preventDefault();
		 
	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];
    var myData = 'recordToComplete='+ DbNumberID;

	jQuery.ajax({
	type: "POST",
	url: "http://test.student-portal.co.uk/includes/calendar_process.php",
	dataType:"text",
	data:myData,
	success:function(response){
		$('#task-'+DbNumberID).fadeOut();		
		setTimeout(function(){
			location.reload();
        }, 1000);
	},

	error:function (xhr, ajaxOptions, thrownError){
		alert(thrownError);
	}

	});

    });
	
	$("body").on("click", ".update-button", function(e) {
    e.preventDefault();
	
	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];
	
	$("#update-task-form-" + DbNumberID).submit();
	
	});
	
	$("#calendar-toggle").hide();
	$(".task-tile").addClass("tile-selected");
	$(".task-tile p").addClass("tile-text-selected");
	$(".task-tile i").addClass("tile-text-selected");
	
	$("#task-button").click(function (e) {
    e.preventDefault();
		$("#calendar-toggle").fadeOut();
		$("#duetasks-toggle").fadeIn();
		$("#completedtasks-toggle").fadeIn();
		$(".calendar-tile").removeClass("tile-selected");
		$(".calendar-tile p").removeClass("tile-text-selected");
		$(".calendar-tile i").removeClass("tile-text-selected");
		$(".task-tile").addClass("tile-selected");
		$(".task-tile p").addClass("tile-text-selected");
		$(".task-tile i").addClass("tile-text-selected");
	});
	
	$("#calendar-button").click(function (e) {
    e.preventDefault();
		$("#duetasks-toggle").fadeOut();
		$("#completedtasks-toggle").fadeOut();
		$("#calendar-toggle").fadeIn();
		$(".task-tile").removeClass("tile-selected");
		$(".task-tile p").removeClass("tile-text-selected");
		$(".task-tile i").removeClass("tile-text-selected");
		$(".calendar-tile").addClass("tile-selected");
		$(".calendar-tile p").addClass("tile-text-selected");
		$(".calendar-tile i").addClass("tile-text-selected");
	});

	});

	</script>

</body>
</html>
