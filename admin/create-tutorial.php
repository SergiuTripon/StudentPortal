<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create tutorial</title>

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
    <li class="active">Create tutorial</li>
    </ol>

    <!-- Create tutorial -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createtutorial_form" id="createtutorial_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="tutorial_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="tutorial_moduleid" id="tutorial_moduleid" style="width: 100%;">
        <option></option>
    <?php
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
	<label for="tutorial_name">Name</label>
    <input class="form-control" type="text" name="tutorial_name" id="tutorial_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="tutorial_notes">Notes</label>
    <textarea class="form-control" rows="5" name="tutorial_notes" id="tutorial_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="tutorial_assistant">Tutorial assistant<span class="field-required">*</span></label>
    <select class="form-control" name="tutorial_assistant" id="tutorial_assistant" style="width: 100%;">
        <option></option>
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'academic staff'");

    while ($row = $stmt1->fetch_assoc()){

    $lectureid = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
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
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="tutorial_day">Day<span class="field-required">*</span></label>
    <select class="form-control" name="tutorial_day" id="tutorial_day" style="width: 100%;">
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
	<label for="tutorial_from_time">From (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_from_time" id="tutorial_from_time" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_to_time">To (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_to_time" id="tutorial_to_time" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_from_date">From (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_from_date" id="tutorial_from_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_to_date">To (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_to_date" id="tutorial_to_date" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_location" id="tutorial_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_capacity" id="tutorial_capacity" placeholder="Enter a capacity">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Create tutorial</button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-primary btn-lg btn-load" href="">Create another</a>
	</div>
	
    </form>
    <!-- End of Create tutorial -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    //On load
	$(document).ready(function () {
        //select2
        $("#tutorial_moduleid").select2({placeholder: "Select an option"});
        $("#tutorial_assistant").select2({placeholder: "Select an option"});
        $("#tutorial_day").select2({placeholder: "Select an option"});
    });

    // Date Time Picker
    $('#tutorial_from_time').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });
    $('#tutorial_to_time').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });
    $('#tutorial_from_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
    });
    $('#tutorial_to_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
	});

    //Create tutorial
    $("#create-tutorial-submit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Validation
    var tutorial_moduleid_check = $('#tutorial_moduleid :selected').html();
    if (tutorial_moduleid_check === '') {
        $("label[for='tutorial_moduleid']").empty().append("Please select a module.");
        $("label[for='tutorial_moduleid']").removeClass("feedback-success");
        $("label[for='tutorial_moduleid']").addClass("feedback-danger");
        $("[aria-owns='select2-tutorial_moduleid-results']").removeClass("input-success");
        $("[aria-owns='select2-tutorial_moduleid-results']").addClass("input-danger");
        $("[aria-owns='select2-tutorial_moduleid-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_moduleid']").empty().append("All good!");
        $("label[for='tutorial_moduleid']").removeClass("feedback-danger");
        $("label[for='tutorial_moduleid']").addClass("feedback-success");
        $("[aria-owns='select2-tutorial_moduleid-results']").removeClass("input-danger");
        $("[aria-owns='select2-tutorial_moduleid-results']").addClass("input-success");
    }

    var tutorial_moduleid= $("#tutorial_moduleid :selected").val();

	var tutorial_name = $("#tutorial_name").val();
	if(tutorial_name === '') {
        $("label[for='tutorial_name']").empty().append("Please enter a tutorial name.");
        $("label[for='tutorial_name']").removeClass("feedback-success");
        $("label[for='tutorial_name']").addClass("feedback-danger");
        $("#tutorial_name").removeClass("input-success");
        $("#tutorial_name").addClass("input-danger");
        $("#tutorial_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='tutorial_name']").empty().append("All good!");
        $("label[for='tutorial_name']").removeClass("feedback-danger");
        $("label[for='tutorial_name']").addClass("feedback-success");
        $("#tutorial_name").removeClass("input-danger");
        $("#tutorial_name").addClass("input-success");
	}

    var tutorial_assistant_check = $('#tutorial_assistant :selected').html();
    if (tutorial_assistant_check === '') {
        $("label[for='tutorial_assistant']").empty().append("Please select a tutorial assistant.");
        $("label[for='tutorial_assistant']").removeClass("feedback-success");
        $("label[for='tutorial_assistant']").addClass("feedback-danger");
        $("[aria-owns='select2-tutorial_assistant-results']").removeClass("input-success");
        $("[aria-owns='select2-tutorial_assistant-results']").addClass("input-danger");
        $("[aria-owns='select2-tutorial_assistant-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_assistant']").empty().append("All good!");
        $("label[for='tutorial_assistant']").removeClass("feedback-danger");
        $("label[for='tutorial_assistant']").addClass("feedback-success");
        $("[aria-owns='select2-tutorial_assistant-results']").removeClass("input-danger");
        $("[aria-owns='select2-tutorial_assistant-results']").addClass("input-success");
    }

    var tutorial_assistant = $("#tutorial_assistant :selected").val();
    var tutorial_notes = $("#tutorial_notes").val();

    var tutorial_day_check = $('#tutorial_day :selected').html();
    if (tutorial_day_check === '') {
        $("label[for='tutorial_day']").empty().append("Please select a day.");
        $("label[for='tutorial_day']").removeClass("feedback-success");
        $("label[for='tutorial_day']").addClass("feedback-danger");
        $("[aria-owns='select2-tutorial_day-results']").removeClass("input-success");
        $("[aria-owns='select2-tutorial_day-results']").addClass("input-danger");
        $("[aria-owns='select2-tutorial_day-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='tutorial_day']").empty().append("All good!");
        $("label[for='tutorial_day']").removeClass("feedback-danger");
        $("label[for='tutorial_day']").addClass("feedback-success");
        $("[aria-owns='select2-tutorial_day-results']").removeClass("input-danger");
        $("[aria-owns='select2-tutorial_day-results']").addClass("input-success");
    }

    var tutorial_day = $("#tutorial_day :selected").html();

    var tutorial_from_time = $("#tutorial_from_time").val();
	if(tutorial_from_time === '') {
        $("label[for='tutorial_from_time']").empty().append("Please select a time.");
        $("label[for='tutorial_from_time']").removeClass("feedback-success");
        $("label[for='tutorial_from_time']").addClass("feedback-danger");
        $("#tutorial_from_time").removeClass("input-success");
        $("#tutorial_from_time").addClass("input-danger");
        $("#tutorial_from_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_time']").empty().append("All good!");
        $("label[for='tutorial_from_time']").removeClass("feedback-danger");
        $("label[for='tutorial_from_time']").addClass("feedback-success");
        $("#tutorial_from_time").removeClass("input-danger");
        $("#tutorial_from_time").addClass("input-success");
	}

    var tutorial_to_time = $("#tutorial_to_time").val();
	if(tutorial_to_time === '') {
        $("label[for='tutorial_to_time']").empty().append("Please select a time.");
        $("label[for='tutorial_to_time']").removeClass("feedback-success");
        $("label[for='tutorial_to_time']").addClass("feedback-danger");
        $("#tutorial_to_time").removeClass("input-success");
        $("#tutorial_to_time").addClass("input-danger");
        $("#tutorial_to_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_time']").empty().append("All good!");
        $("label[for='tutorial_to_time']").removeClass("feedback-danger");
        $("label[for='tutorial_to_time']").addClass("feedback-success");
        $("#tutorial_to_time").removeClass("input-danger");
        $("#tutorial_to_time").addClass("input-success");
	}

    var tutorial_from_date = $("#tutorial_from_date").val();
	if(tutorial_from_date === '') {
        $("label[for='tutorial_from_date']").empty().append("Please select a date.");
        $("label[for='tutorial_from_date']").removeClass("feedback-success");
        $("label[for='tutorial_from_date']").addClass("feedback-danger");
        $("#tutorial_from_date").removeClass("input-success");
        $("#tutorial_from_date").addClass("input-danger");
        $("#tutorial_from_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_from_date']").empty().append("All good!");
        $("label[for='tutorial_from_date']").removeClass("feedback-danger");
        $("label[for='tutorial_from_date']").addClass("feedback-success");
        $("#tutorial_from_date").removeClass("input-danger");
        $("#tutorial_from_date").addClass("input-success");
	}

    var tutorial_to_date = $("#tutorial_to_date").val();
	if(tutorial_to_date === '') {
        $("label[for='tutorial_to_date']").empty().append("Please select a date.");
        $("label[for='tutorial_to_date']").removeClass("feedback-success");
        $("label[for='tutorial_to_date']").addClass("feedback-danger");
        $("#tutorial_to_date").removeClass("input-success");
        $("#tutorial_to_date").addClass("input-danger");
        $("#tutorial_to_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_to_date']").empty().append("All good!");
        $("label[for='tutorial_to_date']").removeClass("feedback-danger");
        $("label[for='tutorial_to_date']").addClass("feedback-success");
        $("#tutorial_to_date").removeClass("input-danger");
        $("#tutorial_to_date").addClass("input-success");
	}

    var tutorial_location = $("#tutorial_location").val();
	if(tutorial_location === '') {
        $("label[for='tutorial_location']").empty().append("Please enter a location.");
        $("label[for='tutorial_location']").removeClass("feedback-success");
        $("label[for='tutorial_location']").addClass("feedback-danger");
        $("#tutorial_location").removeClass("input-success");
        $("#tutorial_location").addClass("input-danger");
        $("#tutorial_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_location']").empty().append("All good!");
        $("label[for='tutorial_location']").removeClass("feedback-danger");
        $("label[for='tutorial_location']").addClass("feedback-success");
        $("#tutorial_location").removeClass("input-danger");
        $("#tutorial_location").addClass("input-success");
	}

    var tutorial_capacity = $("#tutorial_capacity").val();
	if(tutorial_capacity === '') {
        $("label[for='tutorial_capacity']").empty().append("Please enter a location.");
        $("label[for='tutorial_capacity']").removeClass("feedback-success");
        $("label[for='tutorial_capacity']").addClass("feedback-danger");
        $("#tutorial_capacity").removeClass("input-success");
        $("#tutorial_capacity").addClass("input-danger");
        $("#tutorial_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='tutorial_capacity']").empty().append("All good!");
        $("label[for='tutorial_capacity']").removeClass("feedback-danger");
        $("label[for='tutorial_capacity']").addClass("feedback-success");
        $("#tutorial_capacity").removeClass("input-danger");
        $("#tutorial_capacity").addClass("input-success");
	}

    //Ajax
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'create_tutorial_moduleid='   + tutorial_moduleid +
         '&create_tutorial_name='      + tutorial_name +
         '&create_tutorial_assistant=' + tutorial_assistant +
         '&create_tutorial_notes='     + tutorial_notes +
         '&create_tutorial_day='       + tutorial_day +
         '&create_tutorial_from_time=' + tutorial_from_time +
         '&create_tutorial_to_time='   + tutorial_to_time +
         '&create_tutorial_from_date=' + tutorial_from_date +
         '&create_tutorial_to_date='   + tutorial_to_date +
         '&create_tutorial_location='  + tutorial_location +
         '&create_tutorial_capacity='  + tutorial_capacity,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#create-tutorial-submit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The tutorial has been created.');
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
    <a class="btn btn-primary btn-lg" href="/home/">Home</a>
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
    <a class="btn btn-primary btn-lg" href="/">Sign in</a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>

</body>
</html>
