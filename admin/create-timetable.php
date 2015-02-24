<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/bootstrap-select-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create timetable</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb">
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
	<label>Module name</label>
    <input class="form-control" type="text" name="module_name" id="module_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

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

    <hr class="hr-separator">

    <!-- Create lecture -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture name</label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Lecturer</label>
    <select class="selectpicker lecturer" name="lecturer" id="lecturer">
        <option data-hidden="true">Select an option</option>
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lectureid = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lectureid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$lectureid.'">'.$firstname.' '.$surname.'</option>';
    }

    ?>
    </select>

    </div>
    </div>
    <p id="error3" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Lecture day</label>
    <input class="form-control" type="text" name="lecture_day" id="lecture_day" placeholder="Select a day">
    </div>
    </div>
    <p id="error4" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Lecture from (time)</label>
	<input type="text" class="form-control" name="lecture_from_time" id="lecture_from_time" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Lecture to (time)</label>
	<input type="text" class="form-control" name="lecture_to_time" id="lecture_to_time" placeholder="Select a time">
	</div>
	</div>
    <p id="error5" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Lecture from (date)</label>
	<input type="text" class="form-control" name="lecture_from_date" id="lecture_from_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Lecture to (date)</label>
	<input type="text" class="form-control" name="lecture_to_date" id="lecture_to_date" placeholder="Select a date">
	</div>
	</div>
	<p id="error6" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Lecture location</label>
	<input type="text" class="form-control" name="lecture_location" id="lecture_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Lecture capacity</label>
	<input type="text" class="form-control" name="lecture_capacity" id="lecture_capacity" placeholder="Enter a capacity">
	</div>
	</div>
    <p id="error7" class="feedback-sad text-center"></p>
    <!-- End of Create lecture -->

    <hr class="hr-separator">

    <!-- Create tutorial -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Tutorial name</label>
    <input class="form-control" type="text" name="tutorial_name" id="tutorial_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error8" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Tutorial assistant</label>
    <select class="selectpicker tutorial_assistant" name="tutorial_assistant" id="tutorial_assistant">
        <option data-hidden="true">Select an option</option>
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lectureid = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lectureid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$lectureid.'">'.$firstname.' '.$surname.'</option>';
    }

    ?>
    </select>
    </div>
    </div>
    <p id="error9" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Tutorial notes</label>
    <textarea class="form-control" rows="5" name="tutorial_notes" id="tutorial_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Tutorial day</label>
    <input class="form-control" type="text" name="tutorial_day" id="tutorial_day" placeholder="Select a day">
    </div>
    </div>
    <p id="error10" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Tutorial from (time)</label>
	<input type="text" class="form-control" name="tutorial_from_time" id="tutorial_from_time" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Tutorial to (time)</label>
	<input type="text" class="form-control" name="tutorial_to_time" id="tutorial_to_time" placeholder="Select a time">
	</div>
	</div>
    <p id="error11" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Tutorial from (date)</label>
	<input type="text" class="form-control" name="tutorial_from_date" id="tutorial_from_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Tutorial to (date)</label>
	<input type="text" class="form-control" name="tutorial_to_date" id="tutorial_to_date" placeholder="Select a date">
	</div>
	</div>
	<p id="error12" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Tutorial location</label>
	<input type="text" class="form-control" name="tutorial_location" id="tutorial_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Tutorial capacity</label>
	<input type="text" class="form-control" name="tutorial_capacity" id="tutorial_capacity" placeholder="Enter a capacity">
	</div>
	</div>
    <p id="error13" class="feedback-sad text-center"></p>
    <!-- End of Create tutorial -->

    <!-- Create exam -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Exam name</label>
    <input class="form-control" type="text" name="exam_name" id="exam_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error14" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Exam notes</label>
    <textarea class="form-control" rows="5" name="exam_notes" id="exam_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Exam date</label>
	<input type="text" class="form-control" name="exam_date" id="exam_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Exam time</label>
	<input type="text" class="form-control" name="exam_time" id="exam_time" placeholder="Select a time">
	</div>
	</div>
    <p id="error15" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Exam location</label>
	<input type="text" class="form-control" name="exam_location" id="exam_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Exam capacity</label>
	<input type="text" class="form-control" name="exam_capacity" id="exam_capacity" placeholder="Enter a capacity">
	</div>
	</div>
    <p id="error16" class="feedback-sad text-center"></p>
    <!-- End of Create exam -->

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create timetable</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
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
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    $('.selectpicker').selectpicker();

    $(".selectpicker").css("color", "gray");

    $( ".bootstrap-select .dropdown-menu > li > a" ).click(function() {
        $(".filter-option").css("cssText", "color: #333333 !important;");
        $(".bootstrap-select > .error-style").css("cssText", "color: #CCCCCC !important;");

    });

    // Date Time Picker
    var today = new Date();
	$(function () {
	$('#lecture_from_time').timepicker();
    $('#lecture_to_time').timepicker();
    $('#lecture_from_date').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#lecture_to_date").datepicker( "option", "minDate", selectedDate);
        }
    });
    $('#lecture_to_date').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#lecture_from_date").datepicker( "option", "minDate", selectedDate);
        }
    });

    $('#tutorial_from_time').timepicker();
    $('#tutorial_to_time').timepicker();

    $('#tutorial_from_date').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#tutorial_to_date").datepicker( "option", "minDate", selectedDate);
        }
    });
    $('#tutorial_to_date').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#tutorial_from_date").datepicker( "option", "minDate", selectedDate);
        }
    });

    $('#exam_date').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#tutorial_from_date").datepicker( "option", "minDate", selectedDate);
        }
    });

    $('#exam_time').timepicker();

	});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
	var module_name = $("#module_name").val();
	if(module_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a module name.");
		$("#module_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#module_name").addClass("success-style");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Lectures
	var lecture_name = $("#lecture_name").val();
	if(lecture_name === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a lecture name.");
		$("#lecture_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#lecture_name").addClass("success-style");
	}

    var lecturer_check = $("#lecturer option:selected").html();
    if (lecturer_check === 'Select an option') {
        $("#error3").show();
        $("#error3").empty().append("Please select a lecturer.");
        $(".lecturer > .selectpicker").addClass("error-style");
        hasError  = true;
        return false;
    }
    else {
        $("#error3").hide();
        $(".lecturer > .selectpicker").addClass("success-style");
        $(".lecturer > .error-style > .filter-option").css("cssText", "color: #FFFFFF; !important");
    }

    var lecture_day = $("#lecture_day").val();
	if(lecture_day === '') {
		$("#error4").show();
		$("#error4").empty().append("Please enter a day.");
		$("#lecture_day").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error4").hide();
		$("#lecture_day").addClass("success-style");
	}

    var lecture_from_time = $("#lecture_from_time").val();
	if(lecture_from_time === '') {
		$("#error5").show();
		$("#error5").empty().append("Please select a time.");
		$("#lecture_from_time").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error5").hide();
		$("#lecture_from_time").addClass("success-style");
	}

    var lecture_to_time = $("#lecture_to_time").val();
	if(lecture_to_time === '') {
		$("#error5").show();
		$("#error5").empty().append("Please select a time.");
		$("#lecture_to_time").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error5").hide();
		$("#lecture_to_time").addClass("success-style");
	}

    var lecture_from_date = $("#lecture_from_date").val();
	if(lecture_from_date === '') {
		$("#error6").show();
		$("#error6").empty().append("Please select a date.");
		$("#lecture_from_date").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error6").hide();
		$("#lecture_from_date").addClass("success-style");
	}

    var lecture_to_date = $("#lecture_to_date").val();
	if(lecture_to_date === '') {
		$("#error6").show();
		$("#error6").empty().append("Please select a date.");
		$("#lecture_to_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error6").hide();
		$("#lecture_to_date").addClass("success-style");
	}

    var lecture_location = $("#lecture_location").val();
	if(lecture_location === '') {
		$("#error7").show();
		$("#error7").empty().append("Please enter a location.");
		$("#lecture_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error7").hide();
		$("#lecture_location").addClass("success-style");
	}

    var lecture_capacity = $("#lecture_capacity").val();
	if(lecture_capacity === '') {
		$("#error7").show();
		$("#error7").empty().append("Please enter a capacity.");
		$("#lecture_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error7").hide();
		$("#lecture_capacity").addClass("success-style");
	}

    var lecture_lecturer = $("#lecturer option:selected").val();
    var lecture_notes = $("#lecture_notes").val();

    //Tutorials
	var tutorial_name = $("#tutorial_name").val();
	if(tutorial_name === '') {
		$("#error8").show();
        $("#error8").empty().append("Please enter a tutorial name.");
		$("#tutorial_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error8").hide();
		$("#tutorial_name").addClass("success-style");
	}

    var tutorial_assistant_check = $("#tutorial_assistant option:selected").html();
    if (tutorial_assistant_check === 'Select an option') {
        $("#error9").show();
        $("#error9").empty().append("Please select a tutorial assistant.");
        $("#tutorial_assistants").addClass("error-style");
        hasError  = true;
        return false;
    }
    else {
        $("#error9").hide();
        $("#tutorial_assistants").addClass("success-style");
    }

    var tutorial_day = $("#tutorial_day").val();
	if(tutorial_day === '') {
		$("#error10").show();
		$("#error10").empty().append("Please enter a day.");
		$("#tutorial_day").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error10").hide();
		$("#tutorial_day").addClass("success-style");
	}

    var tutorial_from_time = $("#tutorial_from_time").val();
	if(tutorial_from_time === '') {
		$("#error11").show();
		$("#error11").empty().append("Please select a time.");
		$("#tutorial_from_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error11").hide();
		$("#tutorial_from_time").addClass("success-style");
	}

    var tutorial_to_time = $("#tutorial_to_time").val();
	if(tutorial_to_time === '') {
		$("#error11").show();
		$("#error11").empty().append("Please select a time.");
		$("#tutorial_to_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error11").hide();
		$("#tutorial_to_time").addClass("success-style");
	}

    var tutorial_from_date = $("#tutorial_from_date").val();
	if(tutorial_from_date === '') {
		$("#error12").show();
		$("#error12").empty().append("Please select a time.");
		$("#tutorial_from_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error12").hide();
		$("#tutorial_from_date").addClass("success-style");
	}

    var tutorial_to_date = $("#tutorial_to_date").val();
	if(tutorial_to_date === '') {
		$("#error12").show();
		$("#error12").empty().append("Please select a date.");
		$("#tutorial_to_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error12").hide();
		$("#tutorial_to_date").addClass("success-style");
	}

    var tutorial_location = $("#tutorial_location").val();
	if(tutorial_location === '') {
		$("#error13").show();
		$("#error13").empty().append("Please enter a location.");
		$("#tutorial_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error13").hide();
		$("#tutorial_location").addClass("success-style");
	}

    var tutorial_capacity = $("#tutorial_capacity").val();
	if(tutorial_capacity === '') {
		$("#error13").show();
		$("#error13").empty().append("Please enter a capacity.");
		$("#tutorial_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error13").hide();
		$("#tutorial_capacity").addClass("success-style");
	}

    var tutorial_assistant = $("#tutorial_assistant option:selected").val();
    var tutorial_notes = $("#tutorial_notes").val();

    //Exams
	var exam_name = $("#exam_name").val();
	if(exam_name === '') {
		$("#error14").show();
        $("#error14").empty().append("Please enter a tutorial name.");
		$("#exam_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error14").hide();
		$("#exam_name").addClass("success-style");
	}

    var exam_date = $("#exam_date").val();
	if(exam_date === '') {
		$("#error15").show();
		$("#error15").empty().append("Please select a date.");
		$("#exam_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error15").hide();
		$("#exam_date").addClass("success-style");
	}

    var exam_time = $("#exam_time").val();
	if(exam_time === '') {
		$("#error15").show();
		$("#error15").empty().append("Please select a time.");
		$("#exam_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error15").hide();
		$("#exam_time").addClass("success-style");
	}

    var exam_location = $("#exam_location").val();
	if(exam_location === '') {
		$("#error16").show();
		$("#error16").empty().append("Please enter a location.");
		$("#exam_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error16").hide();
		$("#exam_location").addClass("success-style");
	}

    var exam_capacity = $("#exam_capacity").val();
	if(exam_capacity === '') {
		$("#error16").show();
		$("#error16").empty().append("Please enter a capacity.");
		$("#exam_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error16").hide();
		$("#exam_capacity").addClass("success-style");
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
	});
	</script>

</body>
</html>
