<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET['id'])) {

    $lectureToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT l.moduleid, l.lectureid, l.lecture_name, l.lecture_lecturer, l.lecture_notes, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') AS lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') AS lecture_to_time, DATE_FORMAT(l.lecture_from_date,'%d/%m/%Y %H:%i') as lecture_from_date, DATE_FORMAT(l.lecture_to_date,'%d/%m/%Y %H:%i') as lecture_to_date, l.lecture_location, l.lecture_capacity FROM system_lecture l WHERE l.lectureid = ? LIMIT 1");
    $stmt1->bind_param('i', $lectureToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $lectureid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity);
    $stmt1->fetch();
    $stmt1->close();

//If URL parameter is not set, do the following
} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Update lecture</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Update lecture</li>
    </ol>

    <!-- Update lecture -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updatelecture_form" id="updatelecture_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input type="hidden" name="lectureid" id="lectureid" value="<?php echo $lectureid; ?>">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="lecture_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_moduleid" id="lecture_moduleid" style="width: 100%;">
    <?php

    //Get active modules
    $stmt1 = $mysqli->query("SELECT DISTINCT m.moduleid, m.module_name FROM system_module m WHERE m.moduleid = '$moduleid' AND module_status='active'");

    while ($row = $stmt1->fetch_assoc()){

        $moduleid = $row["moduleid"];
        $module_name = $row["module_name"];

        echo '<option value="'.$moduleid.'" selected>'.$module_name.'</option>';
    }

    ?>
    <?php
    $stmt1 = $mysqli->query("SELECT DISTINCT m.moduleid, m.module_name FROM system_module m WHERE NOT m.moduleid = '$moduleid' AND module_status='active'");

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
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" value="<?php echo $lecture_name; ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="lecture_lecturer">Lecturer<span class="field-required">*</span></label>
    <select class="form-control lecture_lecturer" name="lecture_lecturer" id="lecture_lecturer">
    <?php

    //Get users with account type: academic staff
    $stmt1 = $mysqli->query("SELECT firstname, surname FROM user_detail WHERE userid = '$lecture_lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lecturer_firstname = $row["firstname"];
    $lecturer_surname = $row["surname"];

        echo '<option value="'.$lecture_lecturer.'" selected>'.$lecturer_firstname.' '.$lecturer_surname.'</option>';
    }

    $stmt2 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type='academic staff' AND NOT userid = '$lecture_lecturer'");

    while ($row = $stmt2->fetch_assoc()){

        $other_lecturers = $row["userid"];

        $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
        $stmt3->bind_param('i', $other_lecturers);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($other_lecturers_firstname, $other_lecturers_surname);
        $stmt3->fetch();

        echo '<option value="'.$other_lecturers.'">'.$other_lecturers_firstname.' '.$other_lecturers_surname.'</option>';
    }
    ?>
    </select>
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter notes"><?php echo $lecture_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="lecture_day">Day<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_day" id="lecture_day" style="width: 100%;">
        <option <?php if($lecture_day == "Monday") echo "selected"; ?>>Monday</option>
        <option <?php if($lecture_day == "Tuesday") echo "selected"; ?>>Tuesday</option>
        <option <?php if($lecture_day == "Wednesday") echo "selected"; ?>>Wednesday</option>
        <option <?php if($lecture_day == "Thursday") echo "selected"; ?>>Thursday</option>
        <option <?php if($lecture_day == "Friday") echo "selected"; ?>>Friday</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_from_time">From (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_time" id="lecture_from_time" value="<?php echo $lecture_from_time; ?>" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_to_time">To (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_time" id="lecture_to_time" value="<?php echo $lecture_to_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_from_date">From (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_date" id="lecture_from_date" value="<?php echo $lecture_from_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_to_date">To (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_date" id="lecture_to_date" value="<?php echo $lecture_to_date; ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_location" id="lecture_location" value="<?php echo $lecture_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="lecture_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_capacity" id="lecture_capacity" value="<?php echo $lecture_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="update-lecture-submit" class="btn btn-primary btn-lg">Update lecture</button>
    </div>

    </div>
	
    </form>
    <!-- End of Update lecture -->
	</div>
    <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

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

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    //On load actions
    $(document).ready(function () {
        //select2
        $("#lecture_moduleid").select2({placeholder: "Select an option"});
        $("#lecture_lecturer").select2({placeholder: "Select an option"});
        $("#lecture_day").select2({placeholder: "Select an option"});
    });

    //Initialize Date Time Picker
    $('#lecture_from_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#lecture_to_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#lecture_from_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#lecture_to_date').datetimepicker({
        format: 'DD/MM/YYYY'
	});

    //Update lecture process
    $("#update-lecture-submit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var lectureid = $("#lectureid").val();

    $("label[for='lecture_moduleid']").empty().append("All good!");
    $("label[for='lecture_moduleid']").removeClass("feedback-danger");
    $("label[for='lecture_moduleid']").addClass("feedback-success");
    $("[aria-owns='select2-lecture_moduleid-results']").removeClass("input-danger");
    $("[aria-owns='select2-lecture_moduleid-results']").addClass("input-success");

    var lecture_moduleid= $("#lecture_moduleid :selected").val();


    //Checking if lecture_name is inputted
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

    $("label[for='lecture_lecturer']").empty().append("All good!");
    $("label[for='lecture_lecturer']").removeClass("feedback-danger");
    $("label[for='lecture_lecturer']").addClass("feedback-success");
    $("[aria-owns='select2-lecture_lecturer-results']").removeClass("input-danger");
    $("[aria-owns='select2-lecture_lecturer-results']").addClass("input-success");

    var lecture_lecturer = $("#lecture_lecturer :selected").val();

    $("label[for='lecture_notes']").empty().append("All good!");
    $("label[for='lecture_notes']").removeClass("feedback-danger");
    $("label[for='lecture_notes']").addClass("feedback-success");
    $("[aria-owns='select2-lecture_notes-results']").removeClass("input-danger");
    $("[aria-owns='select2-lecture_notes-results']").addClass("input-success");

    var lecture_notes = $("#lecture_notes").val();

    $("label[for='lecture_day']").empty().append("All good!");
    $("label[for='lecture_day']").removeClass("feedback-danger");
    $("label[for='lecture_day']").addClass("feedback-success");
    $("[aria-owns='select2-lecture_day-results']").removeClass("input-danger");
    $("[aria-owns='select2-lecture_day-results']").addClass("input-success");

    var lecture_day = $("#lecture_day :selected").html();

    //Checking if lecture_from_time is inputted
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

    //Checking if lecture_to_time is inputted
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

    //Checking if lecture_from_date is inputted
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

    //Checking if lecture_to_date is inputted
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

    //Checking if lecture_location is inputted
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

    //Checking if lecture_capacity is inputted
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
    data:'update_lecture_moduleid='    + lecture_moduleid +
         '&update_lectureid='          + lectureid +
         '&update_lecture_name='       + lecture_name +
         '&update_lecture_lecturer='   + lecture_lecturer +
         '&update_lecture_notes='      + lecture_notes +
         '&update_lecture_day='        + lecture_day +
         '&update_lecture_from_time='  + lecture_from_time +
         '&update_lecture_to_time='    + lecture_to_time +
         '&update_lecture_from_date='  + lecture_from_date +
         '&update_lecture_to_date='    + lecture_to_date +
         '&update_lecture_location='   + lecture_location +
         '&update_lecture_capacity='   + lecture_capacity,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The lecture has been updated.');
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

</body>
</html>
