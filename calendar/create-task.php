<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

	<title>Student Portal | Create a task</title>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../calendar/">Calendar</a></li>
    <li class="active">Create a task</li>
    </ol>
	
	<!-- Create a task -->
	<form class="form-custom" style="max-width: 100%;" name="createtask_form" id="createtask_form">

	<p id="success" class="feedback-happy text-center"></p>
	<p id="error" class="feedback-sad text-center"></p>

	<div id="hide">

    <label>Name</label>
	<input class="form-control" type="text" name="task_name" id="task_name" placeholder="Enter a name">
	<p id="error1" class="feedback-sad text-center"></p>

    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Enter notes"></textarea>

	<label>External URL (www.example.com)</label>
	<input class="form-control" type="text" name="task_url" id="task_url" placeholder="Enter an external URL">

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Start date and time</label>
	<input type="text" class="form-control" name="task_startdate" id="task_startdate" placeholder="Select a start date and time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Due date and time</label>
	<input type="text" class="form-control" name="task_duedate" id="task_duedate" placeholder="Select a due date and time">
	</div>
	</div>
	<p id="error2" class="feedback-sad text-center"></p>

	<label>Task category - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option1" autocomplete="off"> University
	</label>
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option2" autocomplete="off"> Work
	</label>
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option3" autocomplete="off"> Personal
	</label>
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
	<p id="error3" class="feedback-sad text-center"></p>
	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mt10" data-style="slide-up"><span class="ladda-label">Create task</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create a task -->
            
	</div><!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

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

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>

	$(document).ready(function() {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

	//Date Time Picker
    var today = new Date();
	$(function () {
	$('#task_startdate').datetimepicker({
		dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#task_duedate").datepicker( "option", "minDate", selectedDate);
        }
	});
	$('#task_duedate').datetimepicker({
		dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#task_startdate").datepicker("option", "minDate", selectedDate);
        }
	});
	});

	//Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 480){
			$('.btn-group').removeClass('btn-group-justified');
			$('.btn-group').addClass('btn-group-vertical full-width');
		} else {
			$('.btn-group').addClass('btn-group-justified');
		}
	})
	.resize();//trigger the resize event on page load.

	//Global variable
	var task_category;

	//Setting variable value
	$('.btn-group .task_category').click(function(){
		task_category = ($(this).text().replace(/^\s+|\s+$/g,''))
	})

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var task_name = $("#task_name").val();
	if(task_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter task name.");
		$("#task_name").addClass("error-style");
		hasError  = true;
    } else {
		$("#error1").hide();
		$("#task_name").addClass("success-style");
	}
	
	var task_notes = $("#task_notes").val();
	var task_url = $("#task_url").val();

	var task_startdate = $("#task_startdate").val();
	if(task_startdate === '') {
		$("#error2").show();
		$("#error2").empty().append("Please enter a task start date and time.");
		$("#task_startdate").addClass("error-style");
		hasError  = true;
	} else {
		$("#error2").hide();
		$("#task_startdate").addClass("success-style");
	}

	var task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a task due date and time.");
		$("#task_duedate").addClass("error-style");
		hasError  = true;
    } else {
		$("#error2").hide();
		$("#task_duedate").addClass("success-style");
	}

	var task_category_check = $(".task_category");
	if (task_category_check.hasClass('active')) {
		$("#error3").hide();
		$(".btn-group > .btn-default").addClass("success-style");
	}
	else {
		$("#error3").show();
		$("#error3").empty().append("Please select a task category.");
		$(".btn-group > .btn-default").addClass("error-style");
		hasError = true;
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'task_name=' + task_name + '&task_notes=' + task_notes + '&task_url=' + task_url + '&task_startdate=' + task_startdate + '&task_duedate=' + task_duedate + '&task_category=' + task_category,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Task created successfully.');
		$("#success-button").show();
    },
    error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }
	
	return true;
	
	});
	});
	</script>

</body>
</html>
