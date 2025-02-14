<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create lecture</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Create lecture</li>
    </ol>

    <!-- Create lecture -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createlecture_form" id="createlecture_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="lecture_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_moduleid" id="lecture_moduleid" style="width: 100%;">
        <option></option>
    <?php

    //Getting active modules
    $stmt1 = $mysqli->query("SELECT moduleid, module_name FROM system_module WHERE module_status='active'");

    while ($row = $stmt1->fetch_assoc()){

        $moduleid = $row["moduleid"];
        $module_name = $row["module_name"];

        echo '<option value="'.$moduleid.'">'.$module_name.'</option>';
    }

    ?>
    </select>
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="lecture_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="lecture_lecturer">Lecturer<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_lecturer" id="lecture_lecturer" style="width: 100%;">
        <option></option>
    <?php

    //Getting users with account type: academic stuff
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'academic staff'");

    while ($row = $stmt1->fetch_assoc()){

        $userid = $row["userid"];

        $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
        $stmt2->bind_param('i', $userid);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($firstname, $surname);
        $stmt2->fetch();

        echo '<option value="'.$userid.'">'.$firstname.' '.$surname.'</option>';
    }

    ?>
    </select>

    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="lecture_day">Day<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_day" id="lecture_day" style="width: 100%;">
        <option></option>
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_from_time">From (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_time" id="lecture_from_time" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_to_time">To (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_time" id="lecture_to_time" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_from_date">From (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_date" id="lecture_from_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_to_date">To (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_date" id="lecture_to_date" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_location" id="lecture_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_capacity" id="lecture_capacity" placeholder="Enter a capacity">
	</div>
	</div>

    <hr>

	</div>

    <div class="text-center">
    <a id="create-lecture-submit" class="btn btn-primary btn-lg btn-load">Create lecture</a>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
    <hr class="hr-success">
	<a class="btn btn-primary btn-lg btn-load" href="">Create another</a>
	</div>
	
    </form>
    <!-- End of Create lecture -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    //On load
	$(document).ready(function () {
        //select2
        $("#lecture_moduleid").select2({placeholder: "Select an option"});
        $("#lecture_lecturer").select2({placeholder: "Select an option"});
        $("#lecture_day").select2({placeholder: "Select an option"});
    });

    // Date Time Picker
    $('#lecture_from_time').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });
    $('#lecture_to_time').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });
    $('#lecture_from_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
    });
    $('#lecture_to_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
	});

    //Create lecture process
    $("#create-lecture-submit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Checking if option on the drop-down is inputted
    var lecture_moduleid_check = $('#lecture_moduleid :selected').html();
    if (lecture_moduleid_check === '') {
        $("label[for='lecture_moduleid']").empty().append("Please select a module.");
        $("label[for='lecture_moduleid']").removeClass("feedback-success");
        $("label[for='lecture_moduleid']").addClass("feedback-danger");
        $("[aria-owns='select2-lecture_moduleid-results']").removeClass("input-success");
        $("[aria-owns='select2-lecture_moduleid-results']").addClass("input-danger");
        $("[aria-owns='select2-lecture_moduleid-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_moduleid']").empty().append("All good!");
        $("label[for='lecture_moduleid']").removeClass("feedback-danger");
        $("label[for='lecture_moduleid']").addClass("feedback-success");
        $("[aria-owns='select2-lecture_moduleid-results']").removeClass("input-danger");
        $("[aria-owns='select2-lecture_moduleid-results']").addClass("input-success");
    }

    var lecture_moduleid= $("#lecture_moduleid :selected").val();

    //Checking lecture_name is inputted
    var lecture_name = $("#lecture_name").val();
	if(lecture_name === '') {
        $("label[for='lecture_name']").empty().append("Please enter a lecture name.");
        $("label[for='lecture_name']").removeClass("feedback-success");
        $("label[for='lecture_name']").addClass("feedback-danger");
        $("#lecture_name").removeClass("input-success");
        $("#lecture_name").addClass("input-danger");
        $("#lecture_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='lecture_name']").empty().append("All good!");
        $("label[for='lecture_name']").removeClass("feedback-danger");
        $("label[for='lecture_name']").addClass("feedback-success");
        $("#lecture_name").removeClass("input-danger");
        $("#lecture_name").addClass("input-success");
	}

    //Checking if option on the drop-down is inputted
    var lecture_lecturer_check = $('#lecture_lecturer :selected').html();
    if (lecture_lecturer_check === '') {
        $("label[for='lecture_lecturer']").empty().append("Please select a lecturer.");
        $("label[for='lecture_lecturer']").removeClass("feedback-success");
        $("label[for='lecture_lecturer']").addClass("feedback-danger");
        $("[aria-owns='select2-lecture_lecturer-results']").removeClass("input-success");
        $("[aria-owns='select2-lecture_lecturer-results']").addClass("input-danger");
        $("[aria-owns='select2-lecture_lecturer-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_lecturer']").empty().append("All good!");
        $("label[for='lecture_lecturer']").removeClass("feedback-danger");
        $("label[for='lecture_lecturer']").addClass("feedback-success");
        $("[aria-owns='select2-lecture_lecturer-results']").removeClass("input-danger");
        $("[aria-owns='select2-lecture_lecturer-results']").addClass("input-success");
    }

    var lecture_lecturer = $("#lecture_lecturer :selected").val();
    var lecture_notes = $("#lecture_notes").val();

    //Checking if option on the drop-down is inputted
    var lecture_day_check = $('#lecture_day :selected').html();
    if (lecture_day_check === '') {
        $("label[for='lecture_day']").empty().append("Please select a day.");
        $("label[for='lecture_day']").removeClass("feedback-success");
        $("label[for='lecture_day']").addClass("feedback-danger");
        $("[aria-owns='select2-lecture_day-results']").removeClass("input-success");
        $("[aria-owns='select2-lecture_day-results']").addClass("input-danger");
        $("[aria-owns='select2-lecture_day-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='lecture_day']").empty().append("All good!");
        $("label[for='lecture_day']").removeClass("feedback-danger");
        $("label[for='lecture_day']").addClass("feedback-success");
        $("[aria-owns='select2-lecture_day-results']").removeClass("input-danger");
        $("[aria-owns='select2-lecture_day-results']").addClass("input-success");
    }

    var lecture_day = $("#lecture_day :selected").html();

    //Checking lecture_from_time is inputted
    var lecture_from_time = $("#lecture_from_time").val();
	if(lecture_from_time === '') {
        $("label[for='lecture_from_time']").empty().append("Please select a time.");
        $("label[for='lecture_from_time']").removeClass("feedback-success");
        $("label[for='lecture_from_time']").addClass("feedback-danger");
        $("#lecture_from_time").removeClass("input-success");
        $("#lecture_from_time").addClass("input-danger");
        $("#lecture_from_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_time']").empty().append("All good!");
        $("label[for='lecture_from_time']").removeClass("feedback-danger");
        $("label[for='lecture_from_time']").addClass("feedback-success");
        $("#lecture_from_time").removeClass("input-danger");
        $("#lecture_from_time").addClass("input-success");
	}

    //Checking lecture_to_time is inputted
    var lecture_to_time = $("#lecture_to_time").val();
	if(lecture_to_time === '') {
        $("label[for='lecture_to_time']").empty().append("Please select a time.");
        $("label[for='lecture_to_time']").removeClass("feedback-success");
        $("label[for='lecture_to_time']").addClass("feedback-danger");
        $("#lecture_to_time").removeClass("input-success");
        $("#lecture_to_time").addClass("input-danger");
        $("#lecture_to_time").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_time']").empty().append("All good!");
        $("label[for='lecture_to_time']").removeClass("feedback-danger");
        $("label[for='lecture_to_time']").addClass("feedback-success");
        $("#lecture_to_time").removeClass("input-danger");
        $("#lecture_to_time").addClass("input-success");
	}

    //Checking lecture_from_date is inputted
    var lecture_from_date = $("#lecture_from_date").val();
	if(lecture_from_date === '') {
        $("label[for='lecture_from_date']").empty().append("Please select a date.");
        $("label[for='lecture_from_date']").removeClass("feedback-success");
        $("label[for='lecture_from_date']").addClass("feedback-danger");
        $("#lecture_from_date").removeClass("input-success");
        $("#lecture_from_date").addClass("input-danger");
        $("#lecture_from_date").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='lecture_from_date']").empty().append("All good!");
        $("label[for='lecture_from_date']").removeClass("feedback-danger");
        $("label[for='lecture_from_date']").addClass("feedback-success");
        $("#lecture_from_date").removeClass("input-danger");
        $("#lecture_from_date").addClass("input-success");
	}

    //Checking lecture_to_date is inputted
    var lecture_to_date = $("#lecture_to_date").val();
	if(lecture_to_date === '') {
        $("label[for='lecture_to_date']").empty().append("Please select a date.");
        $("label[for='lecture_to_date']").removeClass("feedback-success");
        $("label[for='lecture_to_date']").addClass("feedback-danger");
        $("#lecture_to_date").removeClass("input-success");
        $("#lecture_to_date").addClass("input-danger");
        $("lecture_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_to_date']").empty().append("All good!");
        $("label[for='lecture_to_date']").removeClass("feedback-danger");
        $("label[for='lecture_to_date']").addClass("feedback-success");
        $("#lecture_to_date").removeClass("input-danger");
        $("#lecture_to_date").addClass("input-success");
	}

    //Checking lecture_location is inputted
    var lecture_location = $("#lecture_location").val();
	if(lecture_location === '') {
        $("label[for='lecture_location']").empty().append("Please enter a location.");
        $("label[for='lecture_location']").removeClass("feedback-success");
        $("label[for='lecture_location']").addClass("feedback-danger");
        $("#lecture_location").removeClass("input-success");
        $("#lecture_location").addClass("input-danger");
        $("#lecture_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_location']").empty().append("All good!");
        $("label[for='lecture_location']").removeClass("feedback-danger");
        $("label[for='lecture_location']").addClass("feedback-success");
        $("#lecture_location").removeClass("input-danger");
        $("#lecture_location").addClass("input-success");
	}

    //Checking lecture_capacity is inputted
    var lecture_capacity = $("#lecture_capacity").val();
	if(lecture_capacity === '') {
        $("label[for='lecture_capacity']").empty().append("Please enter a capacity.");
        $("label[for='lecture_capacity']").removeClass("feedback-success");
        $("label[for='lecture_capacity']").addClass("feedback-danger");
        $("#lecture_capacity").removeClass("input-success");
        $("#lecture_capacity").addClass("input-danger");
        $("#lecture_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='lecture_capacity']").empty().append("All good!");
        $("label[for='lecture_capacity']").removeClass("feedback-danger");
        $("label[for='lecture_capacity']").addClass("feedback-success");
        $("#lecture_capacity").removeClass("input-danger");
        $("#lecture_capacity").addClass("input-success");
	}

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'create_lecture_moduleid='    + lecture_moduleid +
         '&create_lecture_name='       + lecture_name +
         '&create_lecture_lecturer='   + lecture_lecturer +
         '&create_lecture_notes='      + lecture_notes +
         '&create_lecture_day='        + lecture_day +
         '&create_lecture_from_time='  + lecture_from_time +
         '&create_lecture_to_time='    + lecture_to_time +
         '&create_lecture_from_date='  + lecture_from_date +
         '&create_lecture_to_date='    + lecture_to_date +
         '&create_lecture_location='   + lecture_location +
         '&create_lecture_capacity='   + lecture_capacity,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#create-lecture-submit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The lecture has been created.');
		$("#success-button").show();
	},

    //If action failed, do the following
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

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/home/">Home</a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>
        <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>

</body>
</html>
