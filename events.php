<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $session_userid;
global $active_event;
global $inactive_event;

AdminEventUpdate();

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

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
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

	<div class="panel-group panel-custom event-view" id="accordion" role="tablist" aria-multiselectable="true">

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
	<table class="table table-condensed table-custom event-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>Tickets available</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE event_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$eventid = $row["eventid"];
	$event_name = $row["event_name"];
	$event_notes = $row["event_notes"];
	$event_url = $row["event_url"];
	$event_from = $row["event_from"];
	$event_to = $row["event_to"];
	$event_amount = $row["event_amount"];
	$event_ticket_no = $row["event_ticket_no"];

	echo '<tr id="task-'.$eventid.'">

			<td data-title="Name"><a href="#view-'.$eventid.'" data-toggle="modal" data-dismiss="modal">'.$event_name.'</a></td>
			<td data-title="From">'.$event_from.'</td>
			<td data-title="To">'.$event_to.'</td>
			<td data-title="Price">'.$event_amount.'</td>
			<td data-title="Ticket available">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
			<td data-title="Action">'.($event_ticket_no === '0' ? "<a class=\"btn btn-primary btn-md btn-disabled\" href=\"../events/book-event?id=$eventid\" data-style=\"slide-up\"><span class=\"ladda-label\">Book</span></a>" : "<a class=\"btn btn-primary btn-md\" href=\"../events/book-event?id=$eventid\" data-style=\"slide-up\"><span class=\"ladda-label\">Book</span></a>").'</td>
			</tr>

			<div id="view-'.$eventid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-ticket"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$event_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($event_notes) ? "-" : "$event_notes").'</p>
			<p><b>URL:</b> '.(empty($event_url) ? "-" : "$event_url").'</p>
			<p><b>From:</b> '.$event_from.'</p>
			<p><b>To:</b> '.$event_to.'</p>
			<p><b>Price (&pound;):</b> '.$event_amount.'</p>
			<p><b>Ticket available:</b> '.$event_ticket_no.'</p>
			</div>

			<div class="modal-footer">
            '.($event_ticket_no === '0' ? "" : "<div class=\"view-action pull-left\"><a href=\"/events/book-event?id=$eventid\" class=\"btn btn-primary btn-sm\" data-style=\"slide-up\">Book</a></div>").'
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
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
	<table class="table table-condensed table-custom event-table">

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

	$stmt2 = $mysqli->query("SELECT e.eventid, e.event_name, e.event_notes, e.event_url, e.event_from, e.event_to, e.event_amount, e.event_ticket_no, b.event_amount_paid, b.ticket_quantity, DATE_FORMAT(b.booked_on,'%d %b %y %H:%i') as booked_on FROM system_event_booked b LEFT JOIN system_event e ON b.eventid=e.eventid WHERE b.userid = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $eventid = $row["eventid"];
    $event_name = $row["event_name"];
    $event_notes = $row["event_notes"];
    $event_url = $row["event_url"];
    $event_from = $row["event_from"];
    $event_to = $row["event_to"];
    $event_amount = $row["event_amount"];
    $event_ticket_no = $row["event_ticket_no"];

    $event_amount_paid = $row["event_amount_paid"];
    $ticket_quantity = $row["ticket_quantity"];
    $booked_on = $row["booked_on"];

	echo '<tr>

			<td data-title="Name">'.$event_name.'</td>
			<td data-title="Total paid">'.$event_amount_paid.'</td>
			<td data-title="Quantity">'.$ticket_quantity.'</td>
			<td data-title="Booked on">'.$booked_on.'</td>
			</tr>

			<div id="view-'.$eventid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-ticket"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$event_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Description:</b> '.(empty($event_notes) ? "-" : "$event_notes").'</p>
			<p><b>URL:</b> '.(empty($event_url) ? "-" : "$event_url").'</p>
			<p><b>From:</b> '.$event_from.'</p>
			<p><b>To:</b> '.$event_to.'</p>
			<p><b>Price (&pound;):</b> '.$event_amount.'</p>
			<p><b>Ticket available:</b> '.$event_ticket_no.'</p>
			</div>

			<div class="modal-footer">
            '.($event_ticket_no === '0' ? "" : "<div class=\"view-action pull-left\"><a href=\"/events/book-event?id=$eventid\" class=\"btn btn-primary btn-sm\" data-style=\"slide-up\">Book</a></div>").'
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

	</div><!-- /panel-group -->

	<div class="panel-group panel-custom calendar-view" id="accordion" role="tablist" aria-multiselectable="true">

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
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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

    //DataTables
    settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

    $('.table-custom').dataTable(settings);

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

    //Responsiveness
    $(window).resize(function(){
        var width = $(window).width();
        if(width <= 480){
            $('.btn-group').addClass('btn-group-vertical full-width');
        } else {
            $('.btn-group').removeClass('btn-group-vertical full-width');
        }
    }).resize();

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

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../home/">Home</a></li>
    <li class="active">Events</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin" href="../admin/create-event/">Create event</span></a>

    <div class="panel-group panel-custom book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Events</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Active events -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-event">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
	<th>To</th>
	<th>Price (&pound;)</th>
	<th>Tickets available</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-event">
	<?php
    echo $active_event;
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

	<!-- Inactive events -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-event">

	<thead>
	<tr>
	<th>Event</th>
	<th>From</th>
	<th>To</th>
	<th>Price (&pound;)</th>
	<th>Tickets available</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-event">
	<?php
    echo $inactive_event;
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
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>
    //DataTables
    settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

    $('.table-active-event').dataTable(settings);
    $('.table-inactive-event').dataTable(settings);

    //Deactivate event
    $("body").on("click", ".btn-deactivate-event", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'eventToDeactivate='+ eventToDeactivate,
	success:function(html){

        $(".table-active-event").dataTable().fnDestroy();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate event process
    $("body").on("click", ".btn-reactivate-event", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'eventToReactivate='+ eventToReactivate,
	success:function(html){

        $(".table-inactive-event").dataTable().fnDestroy();
        $('#content-inactive-event').empty();
        $('#content-inactive-event').html(html.inactive_event);
        $(".table-inactive-event").dataTable(settings);

        $(".table-active-event").dataTable().fnDestroy();
        $('#content-active-event').empty();
        $('#content-active-event').html(html.active_event);
        $(".table-active-event").dataTable(settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Cancel event process
    $("body").on("click", ".btn-delete-event", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var eventToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'eventToDelete='+ eventToDelete,
	success:function(){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $(".table-active-event").dataTable().fnDestroy();
            $('#content-active-event').empty();
            $('#content-active-event').html(html.active_event);
            $(".table-active-event").dataTable(settings);

            $(".table-inactive-event").dataTable().fnDestroy();
            $('#content-inactive-event').empty();
            $('#content-inactive-event').html(html.inactive_event);
            $(".table-inactive-event").dataTable(settings);
        });
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
