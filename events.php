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

    <title>Student Portal | Events</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Events</li>
    </ol>

	<div class="row mb10">

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
	<a id="task-button">
    <div class="tile task-tile">
	<i class="fa fa-ticket"></i>
	<p class="tile-text">Event view</p>
    </div>
    </a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
	<a id="calendar-button">
	<div class="tile calendar-tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar view</p>
    </div>
    </a>
	</div>

	</div><!-- /row -->

	<div class="panel-group event-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="events-toggle" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Events</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Event -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom events-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>External URL</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>Tickets</th>
	<th>Category</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no, event_category FROM system_events WHERE event_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$eventid = $row["eventid"];
	$event_name = $row["event_name"];
	$event_notes = $row["event_notes"];
	$event_url = $row["event_url"];
	$event_from = $row["event_from"];
	$event_to = $row["event_to"];
	$event_amount = $row["event_amount"];
	$event_ticket_no = $row["event_ticket_no"];
	$event_category = ucfirst($row["event_category"]);

	echo '<tr id="task-'.$row["eventid"].'">

			<td data-title="Name">'.$event_name.'</td>
			<td class="notes-hide" data-title="Notes">'.$event_notes.'</td>
			<td class="url-hide" data-title="External URL">'.($event_url === '' ? "" : "<a target=\"_blank\" href=\"//$url\">Link</a>").'</td>
			<td data-title="From">'.$event_from.'</td>
			<td data-title="To">'.$event_to.'</td>
			<td data-title="Price">'.$event_amount.'</td>
			<td data-title="Tickets">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
			<td data-title="Category">'.$event_category.'</td>
			<td data-title="Action">'.($event_ticket_no === '0' ? "Sold Out" : "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../events/book-event?id=$eventid\" data-style=\"slide-up\"><span class=\"ladda-label\">Book</span></a>").'</td>
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

	<div id="bookedevents-toggle" class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Booked events</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Booked events -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom booked-event-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Total paid</th>
	<th>Quantity</th>
	<th>Booked on</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT system_events.event_name, system_events_booked.event_amount_paid, system_events_booked.ticket_quantity, DATE_FORMAT(system_events_booked.booked_on,'%d %b %y %H:%i') as booked_on FROM system_events_booked LEFT JOIN system_events ON system_events_booked.eventid=system_events.eventid WHERE system_events_booked.userid = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $event_name = $row["event_name"];
    $event_amount_paid = $row["event_amount_paid"];
    $ticket_quantity = $row["ticket_quantity"];
    $booked_on = $row["booked_on"];

	echo '<tr>

			<td data-title="Name">'.$event_name.'</td>
			<td data-title="Total paid">'.$event_amount_paid.'</td>
			<td data-title="Quantity">'.$ticket_quantity.'</td>
			<td data-title="Booked on">'.$booked_on.'</td>
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

	<div class="panel-group calendar-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="calendar-toggle" class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingThree">
	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Calendar</a>
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

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-admin">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Events</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin ladda-button" data-style="slide-up" href="../admin/create-event/"><span class="ladda-label">Create event</span></a>

    <div class="panel-group book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Events</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Event -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom event-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>Tickets</th>
	<th>Category</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT eventid, event_name, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no, event_category FROM system_events WHERE event_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$eventid = $row["eventid"];
	$event_name = $row["event_name"];
	$event_from = $row["event_from"];
	$event_to = $row["event_to"];
	$event_amount = $row["event_amount"];
	$event_ticket_no = $row["event_ticket_no"];
	$event_category = ucfirst($row["event_category"]);

	echo '<tr id="event-'.$row["eventid"].'">

			<td data-title="Name">'.$event_name.'</td>
			<td data-title="From">'.$event_from.'</td>
			<td data-title="To">'.$event_to.'</td>
			<td data-title="Price">'.$event_amount.'</td>
			<td data-title="Tickets">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
			<td data-title="Category">'.$event_category.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../admin/update-event/?id='.$eventid.'" data-style="slide-up"><span class="ladda-label">Update</span></a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button delete-trigger" href="#deactivate-'.$eventid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Deactivate</span></a></td>
			</tr>

			<div class="modal modal-custom fade" id="deactivate-'.$eventid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="text-center feedback-sad">Are you sure you want to deactivate '.$event_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="hide-deactivate">
			<div class="pull-left">
			<a id="deactivate-'.$eventid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-deactivate" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Inactive events</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Inactive event -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom event-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>Tickets</th>
	<th>Category</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT eventid, event_name, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no, event_category FROM system_events WHERE event_status = 'inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$eventid = $row["eventid"];
	$event_name = $row["event_name"];
	$event_from = $row["event_from"];
	$event_to = $row["event_to"];
	$event_amount = $row["event_amount"];
	$event_ticket_no = $row["event_ticket_no"];
	$event_category = ucfirst($row["event_category"]);

	echo '<tr id="event-'.$row["eventid"].'">

			<td data-title="Name">'.$event_name.'</td>
			<td data-title="From">'.$event_from.'</td>
			<td data-title="To">'.$event_to.'</td>
			<td data-title="Price">'.$event_amount.'</td>
			<td data-title="Tickets">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
			<td data-title="Category">'.$event_category.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#reactivate-'.$eventid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Reactivate</span></a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#delete-'.$eventid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Delete</span></a></td>
			</tr>

			<div class="modal modal-custom fade" id="reactivate-'.$eventid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to reactivate '.$event_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="hide-reactivate">
			<div class="pull-left">
			<a id="reactivate-'.$eventid.'" class="btn btn-danger btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-reactivate" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="delete-'.$eventid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to delete '.$event_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="hide-delete">
			<div class="pull-left">
			<a id="delete-'.$eventid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-delete" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

	</div><!-- /panel-group -->

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
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script>
	$(document).ready(function () {
        //Event view/Calendar view toggle
        $("#calendar-toggle").hide();
        $(".task-tile").addClass("tile-selected");
        $(".task-tile p").addClass("tile-text-selected");
        $(".task-tile i").addClass("tile-text-selected");
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//Sets calendar options
	(function($) {

	"use strict";

	var options = {
		events_source: '../../includes/calendar/source/events_json.php',
		view: 'month',
		tmpl_path: '../assets/tmpls/',
		tmpl_cache: false,
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	var calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});
	}(jQuery));

	//DataTables
    $('.event-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no events to display."
		}
	});

	$('.booked-event-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no booked events to display."
		}
	});

    //Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 480){
			$('.btn-group').addClass('btn-group-vertical full-width');
        } else {
            $('.btn-group').removeClass('btn-group-vertical full-width');
        }
	})
	.resize();

	//Book event form submit
	$("body").on("click", ".book-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#book-event-form-" + DbNumberID).submit();

	});

    //Update event form submit
	$("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-event-form-" + DbNumberID).submit();

	});

    //Deactivate event
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'eventToDeactivate='+ eventToDeactivate,
	success:function(){
		$('#event-'+eventToDeactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The event has been deactivated successfully.');
        $('#hide-deactivate').hide();
        $('#success-button-deactivate').show();
        $("#success-button-deactivate").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate event process
    $("body").on("click", ".reactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'eventToReactivate='+ eventToReactivate,
	success:function(){
		$('#event-'+eventToReactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The event has been reactivated successfully.');
        $('#hide-reactivate').hide();
        $('#success-button-reactivate').show();
        $("#success-button-reactivate").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Cancel event process
    $("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'eventToDelete='+ eventToDelete,
	success:function(){
		$('#event-'+eventToDelete).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The event has been deleted successfully.');
        $('#hide-delete').hide();
        $('#success-button-delete').show();
        $("#success-button-delete").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

	$("#task-button").click(function (e) {
    e.preventDefault();
        $(".calendar-view").hide();
		$("#calendar-toggle").hide();
        $(".event-view").show();
		$("#events-toggle").show();
		$("#bookedevents-toggle").show();
		$(".calendar-tile").removeClass("tile-selected");
		$(".calendar-tile p").removeClass("tile-text-selected");
		$(".calendar-tile i").removeClass("tile-text-selected");
		$(".task-tile").addClass("tile-selected");
		$(".task-tile p").addClass("tile-text-selected");
		$(".task-tile i").addClass("tile-text-selected");
	});

	$("#calendar-button").click(function (e) {
    e.preventDefault();
		$("#events-toggle").hide();
		$("#bookedevents-toggle").hide();
        $(".event-view").hide();
        $(".calendar-view").show();
		$("#calendar-toggle").show();
		$(".task-tile").removeClass("tile-selected");
		$(".task-tile p").removeClass("tile-text-selected");
		$(".task-tile i").removeClass("tile-text-selected");
		$(".calendar-tile").addClass("tile-selected");
		$(".calendar-tile p").addClass("tile-text-selected");
		$(".calendar-tile i").addClass("tile-text-selected");
	});
	</script>

</body>
</html>
