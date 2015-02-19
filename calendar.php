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

    <title>Student Portal | Calendar</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="calendar-portal" class="container">

	<ol class="breadcrumb">
		<li><a href="../overview/">Overview</a></li>
		<li class="active">Calendar</li>
	</ol>

	<div class="row">

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/calendar/create-task/">
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

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="duetasks-toggle" class="panel panel-default">

	<?php
	$stmt2 = $mysqli->query("SELECT taskid FROM user_tasks WHERE userid = '$userid' AND task_status = 'active'");
	while($row = $stmt2->fetch_assoc()) {
	  echo '<form id="update-task-form-'.$row["taskid"].'" style="display: none;" action="/calendar/update-task/" method="POST">
			<input type="hidden" name="recordToUpdate" id="recordToUpdate" value="'.$row["taskid"].'"/>
			</form>';
	}
	$stmt2->close();
	?>

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Due tasks - click to minimize or maximize</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Due tasks -->
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
	<th>Action</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, task_category FROM user_tasks WHERE userid = '$userid' AND task_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$taskid = $row["taskid"];
	$task_name = $row["task_name"];
	$task_notes = $row["task_notes"];
	$task_startdate = $row["task_startdate"];
	$task_duedate = $row["task_duedate"];
	$task_url = $row["task_url"];
	$task_category = $row["task_category"];
	$task_category = ucfirst($row["task_category"]);

	echo '<tr id="task-'.$taskid.'">

			<td data-title="Name">'.$task_name.'</td>
			<td data-title="Notes">'.$task_notes.'</td>
			<td data-title="External URL">'.($task_url === '' ? "" : "<a clas=\"btn btn-default btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</td>
			<td data-title="Start date">'.$task_startdate.'</td>
			<td data-title="Due date">'.$task_duedate.'</td>
			<td data-title="Category">'.$task_category.'</td>
			<td data-title="Action"><a id="complete-'.$taskid.'" class="btn btn-primary btn-md complete-button">Complete</a></td>
			<td data-title="Action"><a id="update-'.$taskid.'" class="btn btn-primary btn-md update-button">Update</a></td>
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

	<div id="completedtasks-toggle" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Completed tasks - click to minimize or maximize</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Completed tasks -->
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

	$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, task_category FROM user_tasks where userid = '$userid' AND task_status = 'completed'");

	while($row = $stmt2->fetch_assoc()) {

	$url = $row["task_url"];
	$task_category = ucfirst($row["task_category"]);

	if (!empty($row["task_url"])) {
		$url1 = "<a target=\"_blank\" href=\"//$url\">Link</a>";
	} else {
		$url1 = "";
	}

	echo '<tr id="task-'.$row["taskid"].'">

	<td data-title="Name">'.$row["task_name"].'</td>
	<td class="notes-hide" data-title="Notes">'.$row["task_notes"].'</td>
	<td class="url-hide" data-title="External URL">'.$url1.'</td>
	<td data-title="Start date">'.$row["task_startdate"].'</td>
	<td data-title="Due date">'.$row["task_duedate"].'</td>
	<td data-title="Category">'.$task_category.'</td>
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

	</div><!-- /panel-group -->

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="calendar-toggle" class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingThree">
	<h4 class="panel-title">
	<a data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Calendar - click to minimize or maximize</a>
	</h4>
	</div>
	<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

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


	<script>
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
	
	$("#calendar-toggle").hide();
	$(".task-tile").addClass("tile-selected");
	$(".task-tile p").addClass("tile-text-selected");
	$(".task-tile i").addClass("tile-text-selected");
	
	$("#task-button").click(function (e) {
    e.preventDefault();
		$("#calendar-toggle").hide();
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
		$("#duetasks-toggle").hide();
		$("#completedtasks-toggle").hide();
		$("#calendar-toggle").show();
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
