<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create timetable</title>

    <?php include '../assets/css-paths/bootstrap-select-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Create timetable</li>
    </ol>

    <!-- Create timetable -->
	<form class="form-custom" style="max-width: 100%;" name="createtimetable_form" id="createtimetable_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <!-- Create module -->

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="module_name">Module name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="module_name" id="module_name" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" placeholder="Enter a URL">
	</div>
	</div>
    <!-- End of Create module -->

    <div class="text-center">
        <h4>Module</h4>
    </div>

	</div>
	
    </form>
    <!-- End of Create timetable -->

        <!-- Create timetable -->
	<form class="form-custom" style="max-width: 100%;" name="createtimetable_form" id="createtimetable_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <!-- Create module -->

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="module_name">Module name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="module_name" id="module_name" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" placeholder="Enter a URL">
	</div>
	</div>
    <!-- End of Create module -->

    <div class="text-center">
        <h4>Module</h4>
    </div>

	</div>

    </form>
    <!-- End of Create timetable -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
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
    <?php include '../assets/js-paths/bootstrap-select-js-path.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
    //On load
	$(document).ready(function () {

    //Select box
    $(".bootstrap-select > .selectpicker").css("cssText", "color: gray !important;");

    $(".lecture_lecturer .dropdown-menu > li > a").click(function () {
        $(".lecture_lecturer > .selectpicker").css("cssText", "color: #333333 !important;");
    });
    $(".lecture_day .dropdown-menu > li > a").click(function () {
        $(".lecture_day > .selectpicker").css("cssText", "color: #333333 !important;");
    });

    $(".tutorial_assistant .dropdown-menu > li > a").click(function () {
        $(".tutorial_assistant > .selectpicker").css("cssText", "color: #333333 !important;");
    });
    $(".tutorial_day .dropdown-menu > li > a").click(function () {
        $(".tutorial_day > .selectpicker").css("cssText", "color: #333333 !important;");
    });
    });

    //Select box
    $('.selectpicker').selectpicker();

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    // Date Time Picker
    var today = new Date();
	$(function () {
	$('#lecture_from_time').timepicker({ controlType: 'select' });
    $('#lecture_to_time').timepicker({ controlType: 'select' });
    $('#lecture_from_date').datepicker({ dateFormat: "yy-mm-dd", controlType: 'select', minDate: today });
    $('#lecture_to_date').datepicker({ dateFormat: "yy-mm-dd", controlType: 'select', minDate: today });
    $('#tutorial_from_time').timepicker({ controlType: 'select' });
    $('#tutorial_to_time').timepicker({ controlType: 'select' });
    $('#tutorial_from_date').datepicker({ dateFormat: "yy-mm-dd", controlType: 'select', minDate: today });
    $('#tutorial_to_date').datepicker({ dateFormat: "yy-mm-dd", controlType: 'select', minDate: today });
    $('#exam_date').datepicker({ dateFormat: "yy-mm-dd", controlType: 'select', minDate: today });
    $('#exam_time').timepicker({ controlType: 'select' });
	});

    //Create timetable ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
	var module_name = $("#module_name").val();
	if(module_name === '') {
        $("label[for='module_name']").empty().append("Please enter a module name.");
        $("label[for='module_name']").removeClass("feedback-happy");
        $("label[for='module_name']").addClass("feedback-sad");
        $("#module_name").removeClass("input-happy");
        $("#module_name").addClass("input-sad");
        $("#module_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='module_name']").empty().append("All good!");
        $("label[for='module_name']").removeClass("feedback-sad");
        $("label[for='module_name']").addClass("feedback-happy");
        $("#module_name").removeClass("input-sad");
        $("#module_name").addClass("input-happy");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Lectures
	var lecture_name = $("#lecture_name").val();
	if(lecture_name === '') {
        $("label[for='lecture_name']").empty().append("Please enter a lecture name.");
        $("label[for='lecture_name']").removeClass("feedback-happy");
        $("label[for='lecture_name']").addClass("feedback-sad");
        $("#lecture_name").removeClass("input-happy");
        $("#lecture_name").addClass("input-sad");
        $("#lecture_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='lecture_name']").empty().append("All good!");
        $("label[for='lecture_name']").removeClass("feedback-sad");
        $("label[for='lecture_name']").addClass("feedback-happy");
        $("#lecture_name").removeClass("input-sad");
        $("#lecture_name").addClass("input-happy");
	}

    var lecture_lecturer_check = $("#lecture_lecturer option:selected").html();
    if (lecture_lecturer_check === 'Select an option') {
        $("label[for='lecture_lecturer']").empty().append("Please select a lecturer name.");
        $("label[for='lecture_lecturer']").removeClass("feedback-happy");
        $("label[for='lecture_lecturer']").addClass("feedback-sad");
        $(".lecture_lecturer > .selectpicker").removeClass("input-happy");
        $(".lecture_lecturer > .selectpicker").addClass("input-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_lecturer']").empty().append("All good!");
        $("label[for='lecture_lecturer']").removeClass("feedback-sad");
        $("label[for='lecture_lecturer']").addClass("feedback-happy");
        $(".lecture_lecturer > .selectpicker").removeClass("input-sad");
        $(".lecture_lecturer > .selectpicker").addClass("input-happy");
    }

    var lecture_day = $("#lecture_day").val();
    if (lecture_day === '') {
        $("label[for='lecture_day']").empty().append("Please enter a day.");
        $("label[for='lecture_day']").removeClass("feedback-happy");
        $("label[for='lecture_day']").addClass("feedback-sad");
        $("#lecture_day").removeClass("input-happy");
        $("#lecture_day").addClass("input-sad");
        $("#lecture_day").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_day']").empty().append("All good!");
        $("label[for='lecture_day']").removeClass("feedback-sad");
        $("label[for='lecture_day']").addClass("feedback-happy");
        $("#lecture_day").removeClass("input-sad");
        $("#lecture_day").addClass("input-happy");
    }

    var lecture_from_time = $("#lecture_from_time").val();
	if(lecture_from_time === '') {
        $("label[for='lecture_from_time']").empty().append("Please select a time.");
        $("label[for='lecture_from_time']").removeClass("feedback-happy");
        $("label[for='lecture_from_time']").addClass("feedback-sad");
        $("#lecture_from_time").removeClass("input-happy");
        $("#lecture_from_time").addClass("input-sad");
        $("#lecture_from_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_time']").empty().append("All good!");
        $("label[for='lecture_from_time']").removeClass("feedback-sad");
        $("label[for='lecture_from_time']").addClass("feedback-happy");
        $("#lecture_from_time").removeClass("input-sad");
        $("#lecture_from_time").addClass("input-happy");
	}

    var lecture_to_time = $("#lecture_to_time").val();
	if(lecture_to_time === '') {
        $("label[for='lecture_to_time']").empty().append("Please select a time.");
        $("label[for='lecture_to_time']").removeClass("feedback-happy");
        $("label[for='lecture_to_time']").addClass("feedback-sad");
        $("#lecture_to_time").removeClass("input-happy");
        $("#lecture_to_time").addClass("input-sad");
        $("#lecture_to_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_time']").empty().append("All good!");
        $("label[for='lecture_to_time']").removeClass("feedback-sad");
        $("label[for='lecture_to_time']").addClass("feedback-happy");
        $("#lecture_to_time").removeClass("input-sad");
        $("#lecture_to_time").addClass("input-happy");
	}

    var lecture_from_date = $("#lecture_from_date").val();
	if(lecture_from_date === '') {
        $("label[for='lecture_from_date']").empty().append("Please select a date.");
        $("label[for='lecture_from_date']").removeClass("feedback-happy");
        $("label[for='lecture_from_date']").addClass("feedback-sad");
        $("#lecture_from_date").removeClass("input-happy");
        $("#lecture_from_date").addClass("input-sad");
        $("#lecture_from_date").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_date']").empty().append("All good!");
        $("label[for='lecture_from_date']").removeClass("feedback-sad");
        $("label[for='lecture_from_date']").addClass("feedback-happy");
        $("#lecture_from_date").removeClass("input-sad");
        $("#lecture_from_date").addClass("input-happy");
	}

    var lecture_to_date = $("#lecture_to_date").val();
	if(lecture_to_date === '') {
        $("label[for='lecture_to_date']").empty().append("Please select a date.");
        $("label[for='lecture_to_date']").removeClass("feedback-happy");
        $("label[for='lecture_to_date']").addClass("feedback-sad");
        $("#lecture_to_date").removeClass("input-happy");
        $("#lecture_to_date").addClass("input-sad");
        $("lecture_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_date']").empty().append("All good!");
        $("label[for='lecture_to_date']").removeClass("feedback-sad");
        $("label[for='lecture_to_date']").addClass("feedback-happy");
        $("#lecture_to_date").removeClass("input-sad");
        $("#lecture_to_date").addClass("input-happy");
	}

    var lecture_location = $("#lecture_location").val();
	if(lecture_location === '') {
        $("label[for='lecture_location']").empty().append("Please enter a location.");
        $("label[for='lecture_location']").removeClass("feedback-happy");
        $("label[for='lecture_location']").addClass("feedback-sad");
        $("#lecture_location").removeClass("input-happy");
        $("#lecture_location").addClass("input-sad");
        $("#lecture_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_location']").empty().append("All good!");
        $("label[for='lecture_location']").removeClass("feedback-sad");
        $("label[for='lecture_location']").addClass("feedback-happy");
        $("#lecture_location").removeClass("input-sad");
        $("#lecture_location").addClass("input-happy");
	}

    var lecture_capacity = $("#lecture_capacity").val();
	if(lecture_capacity === '') {
        $("label[for='lecture_capacity']").empty().append("Please enter a capacity.");
        $("label[for='lecture_capacity']").removeClass("feedback-happy");
        $("label[for='lecture_capacity']").addClass("feedback-sad");
        $("#lecture_capacity").removeClass("input-happy");
        $("#lecture_capacity").addClass("input-sad");
        $("#lecture_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_capacity']").empty().append("All good!");
        $("label[for='lecture_capacity']").removeClass("feedback-sad");
        $("label[for='lecture_capacity']").addClass("feedback-happy");
        $("#lecture_capacity").removeClass("input-sad");
        $("#lecture_capacity").addClass("input-happy");
	}

    var lecture_lecturer = $("#lecture_lecturer option:selected").val();
    var lecture_notes = $("#lecture_notes").val();

    //Tutorials
	var tutorial_name = $("#tutorial_name").val();
	if(tutorial_name === '') {
        $("label[for='tutorial_name']").empty().append("Please enter a tutorial name.");
        $("label[for='tutorial_name']").removeClass("feedback-happy");
        $("label[for='tutorial_name']").addClass("feedback-sad");
        $("#tutorial_name").removeClass("input-happy");
        $("#tutorial_name").addClass("input-sad");
        $("#tutorial_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='tutorial_name']").empty().append("All good!");
        $("label[for='tutorial_name']").removeClass("feedback-sad");
        $("label[for='tutorial_name']").addClass("feedback-happy");
        $("#tutorial_name").removeClass("input-sad");
        $("#tutorial_name").addClass("input-happy");
	}

    var tutorial_assistant_check = $("#tutorial_assistant option:selected").html();
    if (tutorial_assistant_check === 'Select an option') {
        $("label[for='tutorial_assistant']").empty().append("Please enter a tutorial assistant.");
        $("label[for='tutorial_assistant']").removeClass("feedback-happy");
        $("label[for='tutorial_assistant']").addClass("feedback-sad");
        $("#tutorial_assistant").removeClass("input-happy");
        $("#tutorial_assistant").addClass("input-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_assistant']").empty().append("All good!");
        $("label[for='tutorial_assistant']").removeClass("feedback-sad");
        $("label[for='tutorial_assistant']").addClass("feedback-happy");
        $("#tutorial_assistant").removeClass("input-sad");
        $("#tutorial_assistant").addClass("input-happy");
    }

    var tutorial_day = $("#tutorial_day").val();
    if (tutorial_day === '') {
        $("label[for='tutorial_day']").empty().append("Please enter a day.");
        $("label[for='tutorial_day']").removeClass("feedback-happy");
        $("label[for='tutorial_day']").addClass("feedback-sad");
        $("#tutorial_day").removeClass("input-happy");
        $("#tutorial_day").addClass("input-sad");
        $("#tutorial_day").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_day']").empty().append("All good!");
        $("label[for='tutorial_day']").removeClass("feedback-sad");
        $("label[for='tutorial_day']").addClass("feedback-happy");
        $("#tutorial_day").removeClass("input-sad");
        $("#tutorial_day").addClass("input-happy");
    }

    var tutorial_from_time = $("#tutorial_from_time").val();
	if(tutorial_from_time === '') {
        $("label[for='tutorial_from_time']").empty().append("Please select a time.");
        $("label[for='tutorial_from_time']").removeClass("feedback-happy");
        $("label[for='tutorial_from_time']").addClass("feedback-sad");
        $("#tutorial_from_time").removeClass("input-happy");
        $("#tutorial_from_time").addClass("input-sad");
        $("#tutorial_from_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_time']").empty().append("All good!");
        $("label[for='tutorial_from_time']").removeClass("feedback-sad");
        $("label[for='tutorial_from_time']").addClass("feedback-happy");
        $("#tutorial_from_time").removeClass("input-sad");
        $("#tutorial_from_time").addClass("input-happy");
	}

    var tutorial_to_time = $("#tutorial_to_time").val();
	if(tutorial_to_time === '') {
        $("label[for='tutorial_to_time']").empty().append("Please select a time.");
        $("label[for='tutorial_to_time']").removeClass("feedback-happy");
        $("label[for='tutorial_to_time']").addClass("feedback-sad");
        $("#tutorial_to_time").removeClass("input-happy");
        $("#tutorial_to_time").addClass("input-sad");
        $("#tutorial_to_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_time']").empty().append("All good!");
        $("label[for='tutorial_to_time']").removeClass("feedback-sad");
        $("label[for='tutorial_to_time']").addClass("feedback-happy");
        $("#tutorial_to_time").removeClass("input-sad");
        $("#tutorial_to_time").addClass("input-happy");
	}

    var tutorial_from_date = $("#tutorial_from_date").val();
	if(tutorial_from_date === '') {
        $("label[for='tutorial_from_date']").empty().append("Please select a date.");
        $("label[for='tutorial_from_date']").removeClass("feedback-happy");
        $("label[for='tutorial_from_date']").addClass("feedback-sad");
        $("#tutorial_from_date").removeClass("input-happy");
        $("#tutorial_from_date").addClass("input-sad");
        $("#tutorial_from_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_date']").empty().append("All good!");
        $("label[for='tutorial_from_date']").removeClass("feedback-sad");
        $("label[for='tutorial_from_date']").addClass("feedback-happy");
        $("#tutorial_from_date").removeClass("input-sad");
        $("#tutorial_from_date").addClass("input-happy");
	}

    var tutorial_to_date = $("#tutorial_to_date").val();
	if(tutorial_to_date === '') {
        $("label[for='tutorial_to_date']").empty().append("Please select a date.");
        $("label[for='tutorial_to_date']").removeClass("feedback-happy");
        $("label[for='tutorial_to_date']").addClass("feedback-sad");
        $("#tutorial_to_date").removeClass("input-happy");
        $("#tutorial_to_date").addClass("input-sad");
        $("#tutorial_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_date']").empty().append("All good!");
        $("label[for='tutorial_to_date']").removeClass("feedback-sad");
        $("label[for='tutorial_to_date']").addClass("feedback-happy");
        $("#tutorial_to_date").removeClass("input-sad");
        $("#tutorial_to_date").addClass("input-happy");
	}

    var tutorial_location = $("#tutorial_location").val();
	if(tutorial_location === '') {
        $("label[for='tutorial_location']").empty().append("Please enter a location.");
        $("label[for='tutorial_location']").removeClass("feedback-happy");
        $("label[for='tutorial_location']").addClass("feedback-sad");
        $("#tutorial_location").removeClass("input-happy");
        $("#tutorial_location").addClass("input-sad");
        $("#tutorial_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_location']").empty().append("All good!");
        $("label[for='tutorial_location']").removeClass("feedback-sad");
        $("label[for='tutorial_location']").addClass("feedback-happy");
        $("#tutorial_location").removeClass("input-sad");
        $("#tutorial_location").addClass("input-happy");
	}

    var tutorial_capacity = $("#tutorial_capacity").val();
	if(tutorial_capacity === '') {
        $("label[for='tutorial_capacity']").empty().append("Please enter a location.");
        $("label[for='tutorial_capacity']").removeClass("feedback-happy");
        $("label[for='tutorial_capacity']").addClass("feedback-sad");
        $("#tutorial_capacity").removeClass("input-happy");
        $("#tutorial_capacity").addClass("input-sad");
        $("#tutorial_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_capacity']").empty().append("All good!");
        $("label[for='tutorial_capacity']").removeClass("feedback-sad");
        $("label[for='tutorial_capacity']").addClass("feedback-happy");
        $("#tutorial_capacity").removeClass("input-sad");
        $("#tutorial_capacity").addClass("input-happy");
	}

    var tutorial_notes = $("#tutorial_notes").val();
    var tutorial_assistant = $("#tutorial_assistant option:selected").val();

    //Exams
	var exam_name = $("#exam_name").val();
	if(exam_name === '') {
        $("label[for='exam_name']").empty().append("Please enter a location.");
        $("label[for='exam_name']").removeClass("feedback-happy");
        $("label[for='exam_name']").addClass("feedback-sad");
        $("#exam_name").removeClass("input-happy");
        $("#exam_name").addClass("input-sad");
        $("#exam_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='exam_name']").empty().append("All good!");
        $("label[for='exam_name']").removeClass("feedback-sad");
        $("label[for='exam_name']").addClass("feedback-happy");
        $("#exam_name").removeClass("input-sad");
        $("#exam_name").addClass("input-happy");
	}

    var exam_date = $("#exam_date").val();
	if(exam_date === '') {
        $("label[for='exam_date']").empty().append("Please select a date.");
        $("label[for='exam_date']").removeClass("feedback-happy");
        $("label[for='exam_date']").addClass("feedback-sad");
        $("#exam_date").removeClass("input-happy");
        $("#exam_date").addClass("input-sad");
        $("#exam_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_date']").empty().append("All good!");
        $("label[for='exam_date']").removeClass("feedback-sad");
        $("label[for='exam_date']").addClass("feedback-happy");
        $("#exam_date").removeClass("input-sad");
        $("#exam_date").addClass("input-happy");
	}

    var exam_time = $("#exam_time").val();
	if(exam_time === '') {
        $("label[for='exam_time']").empty().append("Please select a time.");
        $("label[for='exam_time']").removeClass("feedback-happy");
        $("label[for='exam_time']").addClass("feedback-sad");
        $("#exam_time").removeClass("input-happy");
        $("#exam_time").addClass("input-sad");
        $("#exam_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_time']").empty().append("All good!");
        $("label[for='exam_time']").removeClass("feedback-sad");
        $("label[for='exam_time']").addClass("feedback-happy");
        $("#exam_time").removeClass("input-sad");
        $("#exam_time").addClass("input-happy");
	}

    var exam_location = $("#exam_location").val();
	if(exam_location === '') {
        $("label[for='exam_location']").empty().append("Please enter a location.");
        $("label[for='exam_location']").removeClass("feedback-happy");
        $("label[for='exam_location']").addClass("feedback-sad");
        $("#exam_location").removeClass("input-happy");
        $("#exam_location").addClass("input-sad");
        $("#exam_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_location']").empty().append("All good!");
        $("label[for='exam_location']").removeClass("feedback-sad");
        $("label[for='exam_location']").addClass("feedback-happy");
        $("#exam_location").removeClass("input-sad");
        $("#exam_location").addClass("input-happy");
	}

    var exam_capacity = $("#exam_capacity").val();
	if(exam_capacity === '') {
        $("label[for='exam_capacity']").empty().append("Please enter a capacity.");
        $("label[for='exam_capacity']").removeClass("feedback-happy");
        $("label[for='exam_capacity']").addClass("feedback-sad");
        $("#exam_capacity").removeClass("input-happy");
        $("#exam_capacity").addClass("input-sad");
        $("#exam_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_capacity']").empty().append("All good!");
        $("label[for='exam_capacity']").removeClass("feedback-sad");
        $("label[for='exam_capacity']").addClass("feedback-happy");
        $("#exam_capacity").removeClass("input-sad");
        $("#exam_capacity").addClass("input-happy");
	}

    var exam_notes = $("#exam_notes").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'module_name='         + module_name +
         '&module_notes='       + module_notes +
         '&module_url='         + module_url +
         '&lecture_name='       + lecture_name +
         '&lecture_lecturer='   + lecture_lecturer +
         '&lecture_notes='      + lecture_notes +
         '&lecture_day='        + lecture_day +
         '&lecture_from_time='  + lecture_from_time +
         '&lecture_to_time='    + lecture_to_time +
         '&lecture_from_date='  + lecture_from_date +
         '&lecture_to_date='    + lecture_to_date +
         '&lecture_location='   + lecture_location +
         '&lecture_capacity='   + lecture_capacity +
         '&tutorial_name='      + tutorial_name +
         '&tutorial_assistant=' + tutorial_assistant +
         '&tutorial_notes='     + tutorial_notes +
         '&tutorial_day='       + tutorial_day +
         '&tutorial_from_time=' + tutorial_from_time +
         '&tutorial_to_time='   + tutorial_to_time +
         '&tutorial_from_date=' + tutorial_from_date +
         '&tutorial_to_date='   + tutorial_to_date +
         '&tutorial_location='  + tutorial_location +
         '&tutorial_capacity='  + tutorial_capacity +
         '&exam_name='          + exam_name +
         '&exam_notes='         + exam_notes +
         '&exam_date='          + exam_date +
         '&exam_time='          + exam_time +
         '&exam_location='      + exam_location +
         '&exam_capacity='      + exam_capacity,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Timetable created successfully.');
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
