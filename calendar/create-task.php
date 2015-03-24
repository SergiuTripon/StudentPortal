<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

	<title>Student Portal | Create task</title>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../calendar/">Calendar</a></li>
    <li class="active">Create a task</li>
    </ol>
	
	<!-- Create a task -->
	<form class="form-custom" style="max-width: 100%;" name="createtask_form" id="createtask_form">

	<p id="success" class="feedback-happy text-center"></p>
	<p id="error" class="feedback-sad text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="task_name">Name<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="task_name" id="task_name" placeholder="Enter a name">
	<p id="error1" class="feedback-sad text-center"></p>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Enter notes"></textarea>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>External URL (www.example.com)</label>
	<input class="form-control" type="text" name="task_url" id="task_url" placeholder="Enter an external URL">
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="task_startdate">Start date<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="task_startdate" id="task_startdate" placeholder="Select a start date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="task_starttime">Start time<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="task_starttime" id="task_starttime" placeholder="Select a start time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="task_duedate">Due date<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="task_duedate" id="task_duedate" placeholder="Select a due date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="task_duetime">Due time<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="task_duetime" id="task_duetime" placeholder="Select a due time">
	</div>
	</div>

	<label for="task_category">Task category - select below<span class="field-required">*</span></label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option1" autocomplete="off"> University
	</label>
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option2" autocomplete="off"> Personal
	</label>
	<label class="btn btn-default btn-lg task_category">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create task</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create a task -->
            
	</div><!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    // Date Time Picker
    $(function () {
        $('#task_startdate').datepicker({ format: "dd/mm/yy" });
        $('#task_duedate').datepicker({ format: "dd/mm/yy" });
        $('#task_starttime').timepicker();
        $('#task_duetime').timepicker();
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
	}).resize();

	//Global variable
	var task_category;

	//Setting variable value
	$('.btn-group .task_category').click(function(){
		task_category = ($(this).text().replace(/^\s+|\s+$/g,''))
	});

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var task_name = $("#task_name").val();
	if(task_name === '') {
        $("label[for='task_name']").empty().append("Please enter a name.");
        $("label[for='task_name']").removeClass("feedback-happy");
        $("#task_name").removeClass("input-style-happy");
        $("label[for='task_name']").addClass("feedback-sad");
        $("#task_name").addClass("input-sad");
        $("#task_name").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_name']").empty().append("All good!");
        $("label[for='task_name']").removeClass("feedback-sad");
        $("#task_name").removeClass("input-style-sad");
        $("label[for='task_name']").addClass("feedback-happy");
        $("#task_name").addClass("input-happy");
	}
	
	var task_notes = $("#task_notes").val();
	var task_url = $("#task_url").val();

	var task_startdate = $("#task_startdate").val();
	if(task_startdate === '') {
        $("label[for='task_startdate']").empty().append("Please select a date and time.");
        $("label[for='task_startdate']").removeClass("feedback-happy");
        $("#task_startdate").removeClass("input-style-happy");
        $("label[for='task_startdate']").addClass("feedback-sad");
        $("#task_startdate").addClass("input-sad");
        $("#task_startdate").focus();
        hasError = true;
        return false;
	} else {
        $("label[for='task_startdate']").empty().append("All good!");
        $("label[for='task_startdate']").removeClass("feedback-sad");
        $("#task_startdate").removeClass("input-style-sad");
        $("label[for='task_startdate']").addClass("feedback-happy");
        $("#task_startdate").addClass("input-happy");
	}

	var task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
        $("label[for='task_duedate']").empty().append("Please select a date and time.");
        $("label[for='task_duedate']").removeClass("feedback-happy");
        $("#task_duedate").removeClass("input-style-happy");
        $("label[for='task_duedate']").addClass("feedback-sad");
        $("#task_duedate").addClass("input-sad");
        $("#task_duedate").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_duedate']").empty().append("All good!");
        $("label[for='task_duedate']").removeClass("feedback-sad");
        $("#task_duedate").removeClass("input-style-sad");
        $("label[for='task_duedate']").addClass("feedback-happy");
        $("#task_duedate").addClass("input-happy");
	}

	var task_category_check = $(".task_category");
	if (task_category_check.hasClass('active')) {
        $("label[for='task_category']").empty().append("All good!");
        $("label[for='task_category']").removeClass("feedback-sad");
        $(".task_category").removeClass("input-style-sad");
        $("label[for='task_category']").addClass("feedback-happy");
        $(".task_category").addClass("input-happy");
	}
	else {
        $("label[for='task_category']").empty().append("Please select a category.");
        $("label[for='task_category']").removeClass("feedback-happy");
        $("#task_category").removeClass("input-style-happy");
        $("label[for='task_category']").addClass("feedback-sad");
        $("#task_category").addClass("input-sad");
        $("#task_category").focus();
        hasError = true;
        return false;
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
	</script>

</body>
</html>
