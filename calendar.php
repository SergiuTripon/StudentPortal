<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $session_userid;

$isUpdate = 0;

calendarUpdate($isUpdate);

global $due_tasks;
global $completed_tasks;
global $archived_tasks;

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

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff' || $_SESSION['account_type'] == 'administrator')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="calendar-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
		<li><a href="../home/">Home</a></li>
		<li class="active">Calendar</li>
	</ol>

	<div class="row">

    <a href="/calendar/create-task/">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <div class="tile">
    <i class="fa fa-plus"></i>
	<p class="tile-text">Create a task</p>
    </div>
	</div>
    </a>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<div id="task-button">
    <div class="tile task-tile">
	<i class="fa fa-tasks"></i>
	<p class="tile-text">Task view</p>
    </div>
    </div>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<div id="calendar-button">
	<div class="tile calendar-tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar view</p>
    </div>
    </div>
	</div>
	
	</div><!-- /row -->

	<div class="panel-group panel-custom task-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="duetasks-toggle" class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Due tasks</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

    <!-- Due tasks -->
    <section id="no-more-tables">
    <table class="table table-condensed table-custom table-due-tasks">

    <thead>
    <tr>
    <th>Task</th>
    <th>Start</th>
    <th>Due</th>
    <th>Action</th>
    </tr>
    </thead>

    <tbody id="content-due-tasks">

	<?php
    echo $due_tasks;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Completed tasks</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

    <!-- Completed tasks -->
    <section id="no-more-tables">
    <table class="table table-condensed table-custom table-completed-tasks">
    <thead>
    <tr>
    <th>Task</th>
    <th>Start</th>
    <th>Due</th>
    <th>Completed on</th>
    <th>Action</th>
    </tr>
    </thead>

    <tbody id="content-completed-tasks">

	<?php
    echo $completed_tasks;
	?>

    </tbody>

    </table>
    </section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
  	</div><!-- /panel-default -->

    <div id="archivedtasks-toggle" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Archived tasks</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Archived tasks -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-archived-tasks">

	<thead>
	<tr>
	<th>Task</th>
	<th>Start</th>
	<th>Due</th>
    <th>Archived on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-archived-tasks">
	<?php
    echo $archived_tasks;
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
	<div class="panel-heading" role="tab" id="headingFour">
	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Calendar</a>
	</h4>
	</div>
	<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
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
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>
    <?php include 'assets/js-paths/calendar-js-path.php'; ?>

    <script>
    $(document).ready(function () {
        $("#calendar-toggle").hide();
        $(".task-tile").addClass("tile-selected");
        $(".task-tile p").addClass("tile-text-selected");
        $(".task-tile i").addClass("tile-text-selected");
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //Calendar
	(function($) {

	"use strict";

	var options = {
		events_source: '../../includes/calendar/source/tasks_json.php',
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

    var settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display at the moment."
        }
    };

    //DataTables
    $('.table-due-tasks').dataTable(settings);
    $('.table-completed-tasks').dataTable(settings);
    $('.table-archived-tasks').dataTable(settings);

    //Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 550){
			$('.calendar-buttons .btn-group').addClass('btn-group-vertical full-width');
            $('#calendar-buttons2').addClass("mt10");
        } else {
            $('.calendar-buttons .btn-group').removeClass('btn-group-vertical full-width');
            $('#calendar-buttons2').removeClass("mt10");
        }
	}).resize();



    //Complete record
	$("body").on("click", ".btn-complete", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToComplete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToComplete='+ taskToComplete,
	success:function(html){

            $('.modal-custom').modal('hide');

            $('.modal-custom').on('hidden.bs.modal', function () {
                $(".table-due-tasks").dataTable().fnDestroy();
                $('#content-due-tasks').empty();
                $('#content-due-tasks').html(html.due_tasks);
                $(".table-due-tasks").dataTable(settings);

                $(".table-completed-tasks").dataTable().fnDestroy();
                $('#content-completed-tasks').empty();
                $('#content-completed-tasks').html(html.completed_tasks);
                $(".table-completed-tasks").dataTable(settings);
            });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});

    });

    //Deactivate record
    $("body").on("click", ".btn-deactivate", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToDeactivate='+ taskToDeactivate,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $('#content-due-tasks').empty();
            $(".table-due-tasks").dataTable().fnDestroy();
            $('#content-due-tasks').html(html.due_tasks);
            $(".table-due-tasks").dataTable(settings);

            $('#content-archived-tasks').empty();
            $(".table-archived-tasks").dataTable().fnDestroy();
            $('#content-archived-tasks').html(html.archived_tasks);
            $(".table-archived-tasks").dataTable(settings);
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate record
    $("body").on("click", ".btn-reactivate", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToReactivate='+ taskToReactivate,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $('#content-archived-tasks').empty();
            $(".table-archived-tasks").dataTable().fnDestroy();
            $('#content-archived-tasks').html(html.archived_tasks);
            $(".table-archived-tasks").dataTable(settings);

            $('#content-due-tasks').empty();
            $(".table-due-tasks").dataTable().fnDestroy();
            $('#content-due-tasks').html(html.due_tasks);
            $(".table-due-tasks").dataTable(settings);
        });

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete record
    $("body").on("click", ".btn-delete", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var taskToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'taskToDelete='+ taskToDelete,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $('#content-due-tasks').empty();
            $(".table-due-tasks").dataTable().fnDestroy();
            $('#content-due-tasks').html(html.due_tasks);
            $(".table-due-tasks").dataTable(settings);

            $('#content-completed-tasks').empty();
            $(".table-completed-tasks").dataTable().fnDestroy();
            $('#content-completed-tasks').html(html.completed_tasks);
            $(".table-completed-tasks").dataTable(settings);

            $('#content-archived-tasks').empty();
            $(".table-archived-tasks").dataTable().fnDestroy();
            $('#content-archived-tasks').html(html.archived_tasks);
            $(".table-archived-tasks").dataTable(settings);
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
        $(".task-view").show();
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
        $(".task-view").hide();
		$("#duetasks-toggle").hide();
		$("#completedtasks-toggle").hide();
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
	<a id="signin-button" class="btn btn-primary btn-lg" href="/">Sign in</a>
    </div>

    </form>
     
	</div>

	<?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <script>

    $('#signin-button').on('click', function () {
        $(this).button('loading');
    });

    </script>

	<?php endif; ?>

</body>
</html>
