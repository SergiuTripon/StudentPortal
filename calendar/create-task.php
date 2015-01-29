<?php
include '../includes/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>
	<?php include '../assets/css-paths/select2-css-path.php'; ?>

	<title>Student Portal | Create a task</title>

	<style>
	#task_category {
		background-color: #333333;
    }

    #task_category option {
		color: #FFA500;
    }
    </style>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
    
    <div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../calendar/">Calendar</a></li>
    <li class="active">Create a task</li>
    </ol>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create a task</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    
	<div class="panel-body">
	
	<!-- Create a task -->
    <div class="content-panel mb10" style="border: none;">
    
	<form class="form-custom" style="max-width: 600px; padding-top: 0px;" name="createtask_form" id="createtask_form">
	
    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	
	<div class="col-xs-12 col-sm-12 full-width">
    <label>Name</label>
    <input class="form-control" type="text" name="task_name" id="task_name" placeholder="Enter a name">

    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Enter notes"></textarea>

	<label>External URL (www.example.com)</label>
	<input class="form-control" type="text" name="task_url" id="task_url" placeholder="Enter an external URL">
	</div>
    
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label>Start date and time</label>
	<input type="text" class="form-control" name="task_startdate" id="task_startdate" placeholder="Select a start date and time">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label>Due date and time</label>
	<input type="text" class="form-control" name="task_duedate" id="task_duedate" placeholder="Select a due date and time">
	</div>
	</div>
	
	<div class="form-group">

	<div class="col-xs-12 col-sm-12 full-width">
	<label>Task category</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-custom">
		<input type="radio" name="options" id="option1" autocomplete="off"> University
	</label>
	<label class="btn btn-custom">
		<input type="radio" name="options" id="option2" autocomplete="off"> Work
	</label>
	<label class="btn btn-custom">
		<input type="radio" name="options" id="option3" autocomplete="off"> Personal
	</label>
	<label class="btn btn-custom">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
	</div>
    
	</div>

	</div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Create</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    </div><!-- /content-panel -->
    <!-- End of Change Password -->
	
	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->
	
	</div><!-- /panel-group -->
            
	</div> <!-- /container -->
	
	<?php include '../includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

    <style>
    html, body {
		height: 100% !important;
	}
    </style>

    <header class="intro">
    <div class="intro-body">
	
    <form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="mt10 hr-custom">
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
	</div>
	
    </form>

    </div><!-- /intro-body -->
    </header>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>
	<?php include '../assets/js-paths/select2-js-path.php'; ?>

	<script>
	Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

	<script>
	$(function () {
	$('#task_startdate').datetimepicker({
		dateFormat: "yy-mm-dd", controlType: 'select'
	});
	$('#task_duedate').datetimepicker({
		dateFormat: "yy-mm-dd", controlType: 'select'
	});
	});
	</script>
	
	<script>
    $(document).ready(function () {

    $('#task_category').css('color', 'gray');
    $('#task_category').change(function () {
    var current = $('#task_category').val();
	if (current != '') {
        $('#task_category').css('color', '#FFA500');
	} else {
		$('#task_category').css('color', 'gray');
	}
    });
    });
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	task_name = $("#task_name").val();
	if(task_name === '') {
        $("#error").empty().append("Please enter task name.");
		$("#task_name").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#task_name").css("border-color", "#4DC742");
	}
	
	task_notes = $("#task_notes").val();
	task_url = $("#task_url").val();

	task_startdate = $("#task_startdate").val();
	if(task_startdate === '') {
		$("#error").show();
		$("#error").empty().append("Please enter a task start date and time.");
		$("#task_startdate").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#task_startdate").css("border-color", "#4DC742");
	}

	task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a task due date and time.");
		$("#task_duedate").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#task_duedate").css("border-color", "#4DC742");
	}
	
	task_category = $('#task_category option:selected').val();
	if (task_category === 'null') {
		$("#error").show();
        $("#error").empty().append("Please select a task category.");
		$("#task_category").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#task_category").css("border-color", "#4DC742");
	}
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/createtask_process.php",
    data:'task_name=' + task_name + '&task_notes=' + task_notes + '&task_url=' + task_url + '&task_startdate=' + task_startdate + '&task_duedate=' + task_duedate + '&task_category=' + task_category,
    success:function(response){
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
