<?php
include '../includes/session.php';

if (isset($_POST["recordToUpdate"])) {

    $moduleToUpdate = filter_input(INPUT_POST, 'recordToUpdate', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT

system_modules.moduleid,
system_modules.module_name,
system_modules.module_notes,
system_modules.module_url,

system_lectures.lectureid,
system_lectures.lecture_name,
system_lectures.lecture_lecturer,
system_lectures.lecture_notes,
system_lectures.lecture_day,
system_lectures.lecture_from_time,
system_lectures.lecture_to_time,
system_lectures.lecture_from_date,
system_lectures.lecture_to_date,
system_lectures.lecture_location,
system_lectures.lecture_capacity,

system_tutorials.tutorialid,
system_tutorials.tutorial_name,
system_tutorials.tutorial_assistant,
system_tutorials.tutorial_notes,
system_tutorials.tutorial_day,
system_tutorials.tutorial_from_time,
system_tutorials.tutorial_to_time,
system_tutorials.tutorial_from_date,
system_tutorials.tutorial_to_date,
system_tutorials.tutorial_location,
system_tutorials.tutorial_capacity,

system_exams.examid,
system_exams.exam_name,
system_exams.exam_notes,
system_exams.exam_date,
system_exams.exam_time,
system_exams.exam_location,
system_exams.exam_capacity

FROM system_modules

LEFT JOIN system_lectures  ON system_modules.moduleid=system_lectures.moduleid
LEFT JOIN system_tutorials ON system_modules.moduleid=system_tutorials.moduleid
LEFT JOIN system_exams     ON system_modules.moduleid=system_exams.moduleid

WHERE system_modules.moduleid = ? LIMIT 1
");
    $stmt1->bind_param('i', $moduleToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $module_name, $module_notes, $module_url, $lectureid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity, $tutorialid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity, $examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
    $stmt1->fetch();
    $stmt1->close();

} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/bootstrap-select-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Update timetable</title>
	
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
    <li class="active">Update timetable</li>
    </ol>

    <!-- Update timetable -->
	<form class="form-custom" style="max-width: 100%;" name="updatetimetable_form" id="updatetimetable_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <!-- Update module -->

    <input type="hidden" name="moduleid" id="moduleid" value="<?php echo $moduleid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="module_name">Module name</label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="<?php echo $module_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"><?php echo $module_notes; ?></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" value="<?php echo $module_url; ?>" placeholder="Enter a URL">
	</div>
	</div>
    <!-- End of Update module -->

    <hr class="hr-separator">

    <!-- Update lecture -->

    <input type="hidden" name="lectureid" id="lectureid" value="<?php echo $lectureid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="lecture_name">Lecture name</label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" value="<?php echo $lecture_name; ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="lecture_lecturer">Current lecturer</label>
    <select class="selectpicker lecture_lecturer" name="lecture_lecturer" id="lecture_lecturer">
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer' AND userid = '$lecture_lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lecturer = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lecturer);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$lecturer.'">'.$firstname.' '.$surname.'</option>';
    }
    ?>

    </select>

    </div>

    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="update_lecture_lecturer">Update lecturer</label>
    <select class="selectpicker update_lecture_lecturer" name="update_lecture_lecturer" id="update_lecture_lecturer">
        <option data-hidden="true">Select an option</option>
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer' AND NOT userid = '$lecture_lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lecturer = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lecturer);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$lecturer.'">'.$firstname.' '.$surname.'</option>';
    }
    ?>

    </select>

    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter notes"><?php echo $lecture_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="lecture_day">Lecture day</label>
    <select class="selectpicker lecture_day" name="lecture_day" id="lecture_day">
        <option data-hidden="true">Select an option</option>
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_from_time">Lecture from (time)</label>
	<input type="text" class="form-control" name="lecture_from_time" id="lecture_from_time" value="<?php echo $lecture_from_time; ?>" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_to_time">Lecture to (time)</label>
	<input type="text" class="form-control" name="lecture_to_time" id="lecture_to_time" value="<?php echo $lecture_to_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_from_date">Lecture from (date)</label>
	<input type="text" class="form-control" name="lecture_from_date" id="lecture_from_date" value="<?php echo $lecture_from_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_to_date">Lecture to (date)</label>
	<input type="text" class="form-control" name="lecture_to_date" id="lecture_to_date" value="<?php echo $lecture_to_date; ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_location">Lecture location</label>
	<input type="text" class="form-control" name="lecture_location" id="lecture_location" value="<?php echo $lecture_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_capacity">Lecture capacity</label>
	<input type="text" class="form-control" name="lecture_capacity" id="lecture_capacity" value="<?php echo $lecture_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>
    <!-- End of Update lecture -->

    <hr class="hr-separator">

    <!-- Update tutorial -->

    <input type="hidden" name="tutorialid" id="tutorialid" value="<?php echo $tutorialid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="tutorial_name">Tutorial name</label>
    <input class="form-control" type="text" name="tutorial_name" id="tutorial_name" value="<?php echo $tutorial_name; ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="tutorial_assistant">Current tutorial assistant</label>
    <select class="selectpicker tutorial_assistant" name="tutorial_assistant" id="tutorial_assistant">
    <?php

    $stmt1 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt1->bind_param('i', $tutorial_assistant);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($firstname, $surname);
    $stmt1->fetch();

        echo '<option value="'.$tutorial_assistant.'">'.$firstname.' '.$surname.'</option>';

    ?>

    </select>

    </div>

    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="update_tutorial_assistant">Update tutorial assistant</label>
    <select class="selectpicker update_tutorial_assistant" name="update_tutorial_assistant" id="update_tutorial_assistant">
        <option data-hidden="true">Select an option</option>
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer' AND NOT userid = '$tutorial_assistant'");

    while ($row = $stmt1->fetch_assoc()){

    $tutorial_assistant = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $tutorial_assistant);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$tutorial_assistant.'">'.$firstname.' '.$surname.'</option>';
    }
    ?>

    </select>

    </div>
    </div>
    <p id="error9" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Tutorial notes</label>
    <textarea class="form-control" rows="5" name="tutorial_notes" id="tutorial_notes" placeholder="Enter notes"><?php echo $tutorial_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="tutorial_day">Tutorial day</label>
    <select class="selectpicker tutorial_day" name="tutorial_day" id="tutorial_day" disabled>
        <option><?php echo $tutorial_day; ?></option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="update_tutorial_day">Tutorial day</label>
    <select class="selectpicker update_tutorial_day" name="update_tutorial_day" id="update_tutorial_day">
        <option data-hidden="true">Select an option</option>
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="tutorial_from_time">Tutorial from (time)</label>
	<input type="text" class="form-control" name="tutorial_from_time" id="tutorial_from_time" value="<?php echo $tutorial_from_time; ?>" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="tutorial_to_time">Tutorial to (time)</label>
	<input type="text" class="form-control" name="tutorial_to_time" id="tutorial_to_time" value="<?php echo $tutorial_to_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="tutorial_from_date">Tutorial from (date)</label>
	<input type="text" class="form-control" name="tutorial_from_date" id="tutorial_from_date" value="<?php echo $tutorial_from_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="tutorial_to_date">Tutorial to (date)</label>
	<input type="text" class="form-control" name="tutorial_to_date" id="tutorial_to_date" value="<?php echo $tutorial_to_date; ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="tutorial_location">Tutorial location</label>
	<input type="text" class="form-control" name="tutorial_location" id="tutorial_location" value="<?php echo $tutorial_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="tutorial_capacity">Tutorial capacity</label>
	<input type="text" class="form-control" name="tutorial_capacity" id="tutorial_capacity" value="<?php echo $tutorial_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>
    <!-- End of Update tutorial -->

    <!-- Update exam -->

    <input type="hidden" name="examid" id="examid" value="<?php echo $examid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="exam_name">Exam name</label>
    <input class="form-control" type="text" name="exam_name" id="exam_name" value="<?php echo $exam_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Exam notes</label>
    <textarea class="form-control" rows="5" name="exam_notes" id="exam_notes" value="<?php echo $exam_notes; ?>" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="exam_date">Exam date</label>
	<input type="text" class="form-control" name="exam_date" id="exam_date" value="<?php echo $exam_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="exam_time">Exam time</label>
	<input type="text" class="form-control" name="exam_time" id="exam_time" value="<?php echo $exam_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="exam_location">Exam location</label>
	<input type="text" class="form-control" name="exam_location" id="exam_location" value="<?php echo $exam_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="exam_capacity">Exam capacity</label>
	<input type="text" class="form-control" name="exam_capacity" id="exam_capacity" value="<?php echo $exam_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>
    <!-- End of Update exam -->

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update timetable</span></button>
    </div>

    </div>
	
    </form>
    <!-- End of Update timetable -->

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

    $(".filter-option").css("color", "gray");

    $( ".bootstrap-select .dropdown-menu > li > a" ).click(function() {
        $(".filter-option").css("cssText", "color: #333333;");
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

    $("#update_lecturer").change(function() {
        var new_lecturer = $("#update_lecturer option:selected").text();
        var new_lecturer1 = $("#update_lecturer option:selected").val();
        $("label[for='lecturer']").empty().append("New lecturer");
        $('#lecturer option:selected').text(new_lecturer);
        $('#lecturer option:selected').val(new_lecturer1);
        $('#lecturer').selectpicker('refresh');
    });

    $("#update_tutorial_assistant").change(function() {
        var new_tutorial_assistant = $("#update_tutorial_assistant option:selected").text();
        var new_tutorial_assistant1 = $("#update_tutorial_assistant option:selected").val();
        $("label[for='tutorial_assistant']").empty().append("New tutorial assistant");
        $('#tutorial_assistant option:selected').text(new_tutorial_assistant);
        $('#tutorial_assistant option:selected').val(new_tutorial_assistant1);
        $('#tutorial_assistant').selectpicker('refresh');
    });

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules

    var moduleid = $("#moduleid").val();

	var module_name = $("#module_name").val();
	if(module_name === '') {
        $("label[for='module_name']").empty().append("Please enter a module name.");
        $("label[for='module_name']").removeClass("feedback-happy");
        $("label[for='module_name']").addClass("feedback-sad");
        $("#module_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='module_name']").empty().append("All good!");
        $("label[for='module_name']").removeClass("feedback-sad");
        $("label[for='module_name']").addClass("feedback-happy");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Lectures

    var lectureid = $("#lectureid").val();

	var lecture_name = $("#lecture_name").val();
	if(lecture_name === '') {
        $("label[for='lecture_name']").empty().append("Please enter a lecture name.");
        $("label[for='lecture_name']").removeClass("feedback-happy");
        $("label[for='lecture_name']").addClass("feedback-sad");
        $("#lecture_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='lecture_name']").empty().append("All good!");
        $("label[for='lecture_name']").removeClass("feedback-sad");
        $("label[for='lecture_name']").addClass("feedback-happy");
	}

    var lecture_lecturer_check = $("#lecture_lecturer option:selected").html();
    if (lecture_lecturer_check === 'Select an option') {
        $("label[for='lecture_lecturer']").empty().append("Please select a lecturer name.");
        $("label[for='lecture_lecturer']").removeClass("feedback-happy");
        $("label[for='lecture_lecturer']").addClass("feedback-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_lecturer']").empty().append("All good!");
        $("label[for='lecture_lecturer']").removeClass("feedback-sad");
        $("label[for='lecture_lecturer']").addClass("feedback-happy");
    }

    var lecture_day_check = $("#lecture_day option:selected").html();
    if (lecture_day_check === 'Select an option') {
        $("label[for='lecture_day']").empty().append("Please select a day.");
        $("label[for='lecture_day']").removeClass("feedback-happy");
        $("label[for='lecture_day']").addClass("feedback-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_day']").empty().append("All good!");
        $("label[for='lecture_day']").removeClass("feedback-sad");
        $("label[for='lecture_day']").addClass("feedback-happy");
    }

    var lecture_from_time = $("#lecture_from_time").val();
	if(lecture_from_time === '') {
        $("label[for='lecture_from_time']").empty().append("Please select a time.");
        $("label[for='lecture_from_time']").removeClass("feedback-happy");
        $("label[for='lecture_from_time']").addClass("feedback-sad");
        $("#lecture_from_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_time']").empty().append("All good!");
        $("label[for='lecture_from_time']").removeClass("feedback-sad");
        $("label[for='lecture_from_time']").addClass("feedback-happy");
	}

    var lecture_to_time = $("#lecture_to_time").val();
	if(lecture_to_time === '') {
        $("label[for='lecture_to_time']").empty().append("Please select a time.");
        $("label[for='lecture_to_time']").removeClass("feedback-happy");
        $("label[for='lecture_to_time']").addClass("feedback-sad");
        $("#lecture_to_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_time']").empty().append("All good!");
        $("label[for='lecture_to_time']").removeClass("feedback-sad");
        $("label[for='lecture_to_time']").addClass("feedback-happy");
	}

    var lecture_from_date = $("#lecture_from_date").val();
	if(lecture_from_date === '') {
        $("label[for='lecture_from_date']").empty().append("Please select a date.");
        $("label[for='lecture_from_date']").removeClass("feedback-happy");
        $("label[for='lecture_from_date']").addClass("feedback-sad");
        $("#lecture_from_date").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_date']").empty().append("All good!");
        $("label[for='lecture_from_date']").removeClass("feedback-sad");
        $("label[for='lecture_from_date']").addClass("feedback-happy");
	}

    var lecture_to_date = $("#lecture_to_date").val();
	if(lecture_to_date === '') {
        $("label[for='lecture_to_date']").empty().append("Please select a date.");
        $("label[for='lecture_to_date']").removeClass("feedback-happy");
        $("label[for='lecture_to_date']").addClass("feedback-sad");
        $("lecture_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_date']").empty().append("All good!");
        $("label[for='lecture_to_date']").removeClass("feedback-sad");
        $("label[for='lecture_to_date']").addClass("feedback-happy");
	}

    var lecture_location = $("#lecture_location").val();
	if(lecture_location === '') {
        $("label[for='lecture_location']").empty().append("Please enter a location.");
        $("label[for='lecture_location']").removeClass("feedback-happy");
        $("label[for='lecture_location']").addClass("feedback-sad");
        $("#lecture_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_location']").empty().append("All good!");
        $("label[for='lecture_location']").removeClass("feedback-sad");
        $("label[for='lecture_location']").addClass("feedback-happy");
	}

    var lecture_capacity = $("#lecture_capacity").val();
	if(lecture_capacity === '') {
        $("label[for='lecture_capacity']").empty().append("Please enter a capacity.");
        $("label[for='lecture_capacity']").removeClass("feedback-happy");
        $("label[for='lecture_capacity']").addClass("feedback-sad");
        $("#lecture_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_capacity']").empty().append("All good!");
        $("label[for='lecture_capacity']").removeClass("feedback-sad");
        $("label[for='lecture_capacity']").addClass("feedback-happy");
	}

    var lecture_lecturer = $("#lecture_lecturer option:selected").val();
    var lecture_day = $("#lecture_day option:selected").val();
    var lecture_notes = $("#lecture_notes").val();

    //Tutorials

    var tutorialid = $("#tutorialid").val();

	var tutorial_name = $("#tutorial_name").val();
	if(tutorial_name === '') {
        $("label[for='tutorial_name']").empty().append("Please enter a tutorial name.");
        $("label[for='tutorial_name']").removeClass("feedback-happy");
        $("label[for='tutorial_name']").addClass("feedback-sad");
        $("#tutorial_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='tutorial_name']").empty().append("All good!");
        $("label[for='tutorial_name']").removeClass("feedback-sad");
        $("label[for='tutorial_name']").addClass("feedback-happy");
	}

    var tutorial_assistant_check = $("#tutorial_assistant option:selected").html();
    if (tutorial_assistant_check === 'Select an option') {
        $("label[for='tutorial_assistant']").empty().append("Please enter a tutorial assistant.");
        $("label[for='tutorial_assistant']").removeClass("feedback-happy");
        $("label[for='tutorial_assistant']").addClass("feedback-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_assistant']").empty().append("All good!");
        $("label[for='tutorial_assistant']").removeClass("feedback-sad");
        $("label[for='tutorial_assistant']").addClass("feedback-happy");
        $("#lecture_lecturer").focus();
    }

    var tutorial_day_check = $("#tutorial_day option:selected").html();
    if (tutorial_day_check === 'Select an option') {
        $("label[for='tutorial_day']").empty().append("Please select a day.");
        $("label[for='tutorial_day']").removeClass("feedback-happy");
        $("label[for='tutorial_day']").addClass("feedback-sad");
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_day']").empty().append("All good!");
        $("label[for='tutorial_day']").removeClass("feedback-sad");
        $("label[for='tutorial_day']").addClass("feedback-happy");
    }

    var tutorial_from_time = $("#tutorial_from_time").val();
	if(tutorial_from_time === '') {
        $("label[for='tutorial_from_time']").empty().append("Please select a time.");
        $("label[for='tutorial_from_time']").removeClass("feedback-happy");
        $("label[for='tutorial_from_time']").addClass("feedback-sad");
        $("#tutorial_from_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_time']").empty().append("All good!");
        $("label[for='tutorial_from_time']").removeClass("feedback-sad");
        $("label[for='tutorial_from_time']").addClass("feedback-happy");
	}

    var tutorial_to_time = $("#tutorial_to_time").val();
	if(tutorial_to_time === '') {
        $("label[for='tutorial_to_time']").empty().append("Please select a time.");
        $("label[for='tutorial_to_time']").removeClass("feedback-happy");
        $("label[for='tutorial_to_time']").addClass("feedback-sad");
        $("#tutorial_to_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_time']").empty().append("All good!");
        $("label[for='tutorial_to_time']").removeClass("feedback-sad");
        $("label[for='tutorial_to_time']").addClass("feedback-happy");
	}

    var tutorial_from_date = $("#tutorial_from_date").val();
	if(tutorial_from_date === '') {
        $("label[for='tutorial_from_date']").empty().append("Please select a date.");
        $("label[for='tutorial_from_date']").removeClass("feedback-happy");
        $("label[for='tutorial_from_date']").addClass("feedback-sad");
        $("#tutorial_from_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_date']").empty().append("All good!");
        $("label[for='tutorial_from_date']").removeClass("feedback-sad");
        $("label[for='tutorial_from_date']").addClass("feedback-happy");
	}

    var tutorial_to_date = $("#tutorial_to_date").val();
	if(tutorial_to_date === '') {
        $("label[for='tutorial_to_date']").empty().append("Please select a date.");
        $("label[for='tutorial_to_date']").removeClass("feedback-happy");
        $("label[for='tutorial_to_date']").addClass("feedback-sad");
        $("#tutorial_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_date']").empty().append("All good!");
        $("label[for='tutorial_to_date']").removeClass("feedback-sad");
        $("label[for='tutorial_to_date']").addClass("feedback-happy");
	}

    var tutorial_location = $("#tutorial_location").val();
	if(tutorial_location === '') {
        $("label[for='tutorial_location']").empty().append("Please enter a location.");
        $("label[for='tutorial_location']").removeClass("feedback-happy");
        $("label[for='tutorial_location']").addClass("feedback-sad");
        $("#tutorial_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_location']").empty().append("All good!");
        $("label[for='tutorial_location']").removeClass("feedback-sad");
        $("label[for='tutorial_location']").addClass("feedback-happy");
	}

    var tutorial_capacity = $("#tutorial_capacity").val();
	if(tutorial_capacity === '') {
        $("label[for='tutorial_capacity']").empty().append("Please enter a location.");
        $("label[for='tutorial_capacity']").removeClass("feedback-happy");
        $("label[for='tutorial_capacity']").addClass("feedback-sad");
        $("#tutorial_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_capacity']").empty().append("All good!");
        $("label[for='tutorial_capacity']").removeClass("feedback-sad");
        $("label[for='tutorial_capacity']").addClass("feedback-happy");
	}

    var tutorial_notes = $("#tutorial_notes").val();
    var tutorial_assistant = $("#tutorial_assistant option:selected").val();
    var tutorial_day = $("#tutorial_day option:selected").val();

    //Exams

    var examid = $("#examid").val();

	var exam_name = $("#exam_name").val();
	if(exam_name === '') {
        $("label[for='exam_name']").empty().append("Please enter a location.");
        $("label[for='exam_name']").removeClass("feedback-happy");
        $("label[for='exam_name']").addClass("feedback-sad");
        $("#exam_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='exam_name']").empty().append("All good!");
        $("label[for='exam_name']").removeClass("feedback-sad");
        $("label[for='exam_name']").addClass("feedback-happy");
	}

    var exam_date = $("#exam_date").val();
	if(exam_date === '') {
        $("label[for='exam_date']").empty().append("Please select a date.");
        $("label[for='exam_date']").removeClass("feedback-happy");
        $("label[for='exam_date']").addClass("feedback-sad");
        $("#exam_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_date']").empty().append("All good!");
        $("label[for='exam_date']").removeClass("feedback-sad");
        $("label[for='exam_date']").addClass("feedback-happy");
	}

    var exam_time = $("#exam_time").val();
	if(exam_time === '') {
        $("label[for='exam_time']").empty().append("Please select a time.");
        $("label[for='exam_time']").removeClass("feedback-happy");
        $("label[for='exam_time']").addClass("feedback-sad");
        $("#exam_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_time']").empty().append("All good!");
        $("label[for='exam_time']").removeClass("feedback-sad");
        $("label[for='exam_time']").addClass("feedback-happy");
	}

    var exam_location = $("#exam_location").val();
	if(exam_location === '') {
        $("label[for='exam_location']").empty().append("Please enter a location.");
        $("label[for='exam_location']").removeClass("feedback-happy");
        $("label[for='exam_location']").addClass("feedback-sad");
        $("#exam_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_location']").empty().append("All good!");
        $("label[for='exam_location']").removeClass("feedback-sad");
        $("label[for='exam_location']").addClass("feedback-happy");
	}

    var exam_capacity = $("#exam_capacity").val();
	if(exam_capacity === '') {
        $("label[for='exam_capacity']").empty().append("Please enter a capacity.");
        $("label[for='exam_capacity']").removeClass("feedback-happy");
        $("label[for='exam_capacity']").addClass("feedback-sad");
        $("#exam_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_capacity']").empty().append("All good!");
        $("label[for='exam_capacity']").removeClass("feedback-sad");
        $("label[for='exam_capacity']").addClass("feedback-happy");
	}

    var exam_notes = $("#exam_notes").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'moduleid='             + moduleid +
         '&module_name1='        + module_name +
         '&module_notes1='       + module_notes +
         '&module_url1='         + module_url +
         '&lectureid='           + lectureid +
         '&lecture_name1='       + lecture_name +
         '&lecture_lecturer1='   + lecture_lecturer +
         '&lecture_notes1='      + lecture_notes +
         '&lecture_day1='        + lecture_day +
         '&lecture_from_time1='  + lecture_from_time +
         '&lecture_to_time1='    + lecture_to_time +
         '&lecture_from_date1='  + lecture_from_date +
         '&lecture_to_date1='    + lecture_to_date +
         '&lecture_location1='   + lecture_location +
         '&lecture_capacity1='   + lecture_capacity +
         '&tutorialid='          + tutorialid +
         '&tutorial_name1='      + tutorial_name +
         '&tutorial_assistant1=' + tutorial_assistant +
         '&tutorial_notes1='     + tutorial_notes +
         '&tutorial_day1='       + tutorial_day +
         '&tutorial_from_time1=' + tutorial_from_time +
         '&tutorial_to_time1='   + tutorial_to_time +
         '&tutorial_from_date1=' + tutorial_from_date +
         '&tutorial_to_date1='   + tutorial_to_date +
         '&tutorial_location1='  + tutorial_location +
         '&tutorial_capacity1='  + tutorial_capacity +
         '&examid='              + examid +
         '&exam_name1='          + exam_name +
         '&exam_notes1='         + exam_notes +
         '&exam_date1='          + exam_date +
         '&exam_time1='          + exam_time +
         '&exam_location1='      + exam_location +
         '&exam_capacity1='      + exam_capacity,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('Timetable updated successfully.');
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
