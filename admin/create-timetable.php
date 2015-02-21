<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <link href="https://www.fuelcdn.com/fuelux/3.5.0/css/fuelux.min.css" rel="stylesheet">
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
    <input class="form-control" type="text" name="module_name" id="module_name" value="" placeholder="Enter a module name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter module notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" placeholder="Enter a module URL">
	</div>
	</div>
    <!-- End of Create module -->

    <hr class="hr-separator">

    <!-- Create lecture -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture name</label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" value="" placeholder="Enter a lecture name">
	</div>
	</div>
	<p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">

    <div class="btn-group selectlist" data-resize="auto" data-initialize="selectlist" id="#lecturers">
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
    <span class="selected-label"></span>
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
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

            echo '<li data-value="'.$lectureid.'"><a href="#">'.$firstname.' '.$surname.'</a></li>';

        }

        ?>
    </ul>
    <input class="hidden hidden-field" name="mySelectlist" readonly="readonly" aria-hidden="true" type="text"/>
    </div>

    </div>
    </div>
    <p id="error3" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter lecture notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Lecture day</label>
    <input class="form-control" type="text" name="lecture_day" id="lecture_day" placeholder="Select a lecture day">
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
    <input class="form-control" type="text" name="tutorial_name" id="tutorial_name" value="" placeholder="Enter a tutorial name">
	</div>
	</div>
	<p id="error8" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Tutorial assistant</label>
    <select class="selectpicker tutorial_assistants" name="tutorial_assistants" id="tutorial_assistants" title="Select a tutorial assistant">
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

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Tutorial notes</label>
    <textarea class="form-control" rows="5" name="tutorial_notes" id="tutorial_notes" placeholder="Enter tutorial notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Tutorial day</label>
    <input class="form-control" type="text" name="tutorial_day" id="tutorial_day" placeholder="Select a day">
    </div>
    </div>
    <p id="error9" class="feedback-sad text-center"></p>

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
    <p id="error10" class="feedback-sad text-center"></p>

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
	<p id="error11" class="feedback-sad text-center"></p>

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
    <p id="error12" class="feedback-sad text-center"></p>
    <!-- End of Create tutorial -->

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
    <script src="https://www.fuelcdn.com/fuelux/3.5.0/js/fuelux.min.js"></script>
    <?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    // Date Time Picker
	$(function () {
	$('#lecture_from_time').timepicker();
    $('#lecture_to_time').timepicker();
    $('#lecture_from_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('#lecture_to_date').datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('#tutorial_from_time').timepicker();
    $('#tutorial_to_time').timepicker();
    $('#tutorial_from_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('#tutorial_to_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
	});

    $('#lecturers').selectlist();
    $('#tutorial_assistants').selectlist();

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
	var module_name = $("#module_name").val();
    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Lectures
	var lecture_name = $("#lecture_name").val();
    var lecture_lecturer = $(".lecturers option:selected").val();
    var lecture_notes = $("#lecture_notes").val();
    var lecture_day = $("#lecture_day").val();
    var lecture_from_time = $("#lecture_from_time").val();
    var lecture_to_time = $("#lecture_to_time").val();
    var lecture_from_date = $("#lecture_from_date").val();
    var lecture_to_date = $("#lecture_to_date").val();
    var lecture_location = $("#lecture_location").val();
    var lecture_capacity = $("#lecture_capacity").val();

    //Tutorials
	var tutorial_name = $("#tutorial_name").val();
    var tutorial_assistant = $(".tutorial_assistants option:selected").val();
    var tutorial_notes = $("#tutorial_notes").val();
    var tutorial_day = $("#tutorial_day").val();
    var tutorial_from_time = $("#tutorial_from_time").val();
    var tutorial_to_time = $("#tutorial_to_time").val();
    var tutorial_from_date = $("#tutorial_from_date").val();
    var tutorial_to_date = $("#tutorial_to_date").val();
    var tutorial_location = $("#tutorial_location").val();
    var tutorial_capacity = $("#tutorial_capacity").val();

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
         '&tutorial_capacity='  + tutorial_capacity,

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
