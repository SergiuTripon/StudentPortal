<?php
include 'includes/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Create a task</title>
	
    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda/ladda-themeless.min.css">

	<!-- Date Time Picker CSS -->
	<link href="../assets/css/datetimepicker/datetimepicker/jquery-ui-1.10.0.custom.css" rel='stylesheet' type='text/css'>
	<link href="../assets/css/datetimepicker/datetimepicker/jquery-ui-timepicker-addon.css" rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../assets/css/common/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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
	<?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li><a href="../calendar/">Calendar</a></li>
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
	
	<div class="form-group">
	
	<div class="col-xs-12 col-sm-12 full-width">
    <label>Name</label>
    <input class="form-control" type="text" name="task_name" id="task_name" placeholder="Enter a name">

    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Enter notes"></textarea>

	<label>External URL</label>
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
    <select class="form-control" name="task_category" id="task_category">
    <option style="color:gray" value="null" disabled selected>Select a task category</option>
    <option style="color: #FFA500" class="others">University</option>
    <option style="color: #FFA500" class="others">Work</option>
    <option style="color: #FFA500" class="others">Personal</option>
	<option style="color: #FFA500" class="others">Other</option>
	</select>
	</div>
    
	</div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Create</span></button>
    </div>
	
    </form>
    </div><!-- /content-panel -->
    <!-- End of Change Password -->
	
	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->
	
	</div><!-- /panel-group -->
            
	</div> <!-- /container -->
	
	<?php include 'includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda/ladda.min.js"></script>
	
	<!-- Pace JS -->
	<script src="../assets/js/ladda/spin.min.js"></script>
    <script src="../assets/js/pacejs/pace.js"></script>

	<!-- Date Time Picker JS -->
	<script src="../assets/js/datetimepicker/jquery-ui-1.10.0.custom.min.js"></script>
	<script src="../assets/js/datetimepicker/jquery-ui-timepicker-addon.js"></script>
	<script src="../assets/js/datetimepicker/jquery-ui-sliderAccess.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/common/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

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
		$("#datepicker1").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#datepicker1").css("border-color", "#4DC742");
	}

	task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a task due date and time.");
		$("#datepicker2").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#datepicker2").css("border-color", "#4DC742");
	}
	
	task_category = $('#task_category option:selected').val();
	if (task_category === 'null') {
		$("#error").show();
        $("#error").empty().append("Please select a gender.");
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
	url: "http://test.student-portal.co.uk/includes/createtask_process.php",
    data:'task_name=' + task_name + '&task_notes=' + task_notes + '&task_url=' + task_url + '&task_startdate=' + task_startdate + '&task_duedate=' + task_duedate + '&task_category=' + task_category,
    success:function(response){
		$("#error").hide();
		$("#success").empty().append('Task created successfully. To create another task, simply fill in the form again.');
		$('#createtask_form').trigger("reset");
    },
    error:function (xhr, ajaxOptions, thrownError){
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
