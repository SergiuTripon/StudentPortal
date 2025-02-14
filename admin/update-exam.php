<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET['id'])) {

    $timetableToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT e.moduleid, e.examid, e.exam_name, e.exam_notes, DATE_FORMAT(e.exam_date,'%d/%m/%Y') AS exam_date, DATE_FORMAT(e.exam_time,'%H:%i') AS exam_time, e.exam_location, e.exam_capacity FROM system_exam e WHERE e.examid = ? LIMIT 1");
    $stmt1->bind_param('i', $timetableToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $examid, $exam_name, $exam_notes, $exam_date, $exam_time, $exam_location, $exam_capacity);
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

    <title>Student Portal | Update exam</title>

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
	<li><a href="../../exams/">Exams</a></li>
    <li class="active">Update exam</li>
    </ol>

    <!-- Update exam -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updateexam_form" id="updateexam_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

    <div id="hide">

    <input type="hidden" name="examid" id="examid" value="<?php echo $examid; ?>">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="exam_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="exam_moduleid" id="exam_moduleid" style="width: 100%;">
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

        echo '<option value="'.$moduleid.'" selected>'.$module_name.'</option>';
    }

    ?>
    </select>
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="exam_name">Exam name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="exam_name" id="exam_name" value="<?php echo $exam_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Exam notes</label>
    <textarea class="form-control" rows="5" name="exam_notes" id="exam_notes" placeholder="Enter notes"><?php echo $exam_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_date">Exam date<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_date" id="exam_date" value="<?php echo $exam_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_time">Exam time<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_time" id="exam_time" value="<?php echo $exam_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_location">Exam location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_location" id="exam_location" value="<?php echo $exam_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_capacity">Exam capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_capacity" id="exam_capacity" value="<?php echo $exam_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>
    <!-- End of Update exam -->

	<hr>

    <div class="text-center">
    <button id="update-exam-submit" class="btn btn-primary btn-lg" >Update exam</button>
    </div>

    </div>
	
    </form>
    <!-- End of Update exam -->
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
        $("#exam_moduleid").select2({placeholder: "Select an option"});
    });

    //Initialize Date Time Picker
    $('#exam_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#exam_time').datetimepicker({
        format: 'HH:mm'
    });

    //Update exam process
    $("#update-exam-submit").click(function (e) {
    e.preventDefault();


	var hasError = false;

    var examid = $("#examid").val();

    $("label[for='exam_moduleid']").empty().append("All good!");
    $("label[for='exam_moduleid']").removeClass("feedback-danger");
    $("label[for='exam_moduleid']").addClass("feedback-success");
    $("[aria-owns='select2-exam_moduleid-results']").removeClass("input-danger");
    $("[aria-owns='select2-exam_moduleid-results']").addClass("input-success");

    var exam_moduleid = $("#exam_moduleid option:selected").val();

    //Checking if exam_name is inputted
	var exam_name = $("#exam_name").val();
	if(exam_name === '') {
        $("label[for='exam_name']").empty().append("Please enter a location.");
        $("label[for='exam_name']").removeClass("feedback-success");
        $("label[for='exam_name']").addClass("feedback-danger");
        $("#exam_name").removeClass("input-success");
        $("#exam_name").addClass("input-danger");
        $("#exam_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='exam_name']").empty().append("All good!");
        $("label[for='exam_name']").removeClass("feedback-danger");
        $("label[for='exam_name']").addClass("feedback-success");
        $("#exam_name").removeClass("input-danger");
        $("#exam_name").addClass("input-success");
	}

    var exam_notes = $("#exam_notes").val();

    //Checking if exam_date is inputted
    var exam_date = $("#exam_date").val();
	if(exam_date === '') {
        $("label[for='exam_date']").empty().append("Please select a date.");
        $("label[for='exam_date']").removeClass("feedback-success");
        $("label[for='exam_date']").addClass("feedback-danger");
        $("#exam_date").removeClass("input-success");
        $("#exam_date").addClass("input-danger");
        $("#exam_date").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_date']").empty().append("All good!");
        $("label[for='exam_date']").removeClass("feedback-danger");
        $("label[for='exam_date']").addClass("feedback-success");
        $("#exam_date").removeClass("input-danger");
        $("#exam_date").addClass("input-success");
	}

    //Checking if exam_time is inputted
    var exam_time = $("#exam_time").val();
	if(exam_time === '') {
        $("label[for='exam_time']").empty().append("Please select a time.");
        $("label[for='exam_time']").removeClass("feedback-success");
        $("label[for='exam_time']").addClass("feedback-danger");
        $("#exam_time").removeClass("input-success");
        $("#exam_time").addClass("input-danger");
        $("#exam_time").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_time']").empty().append("All good!");
        $("label[for='exam_time']").removeClass("feedback-danger");
        $("label[for='exam_time']").addClass("feedback-success");
        $("#exam_time").removeClass("input-danger");
        $("#exam_time").addClass("input-success");
	}

    //Checking if exam_location is inputted
    var exam_location = $("#exam_location").val();
	if(exam_location === '') {
        $("label[for='exam_location']").empty().append("Please enter a location.");
        $("label[for='exam_location']").removeClass("feedback-success");
        $("label[for='exam_location']").addClass("feedback-danger");
        $("#exam_location").removeClass("input-success");
        $("#exam_location").addClass("input-danger");
        $("#exam_location").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_location']").empty().append("All good!");
        $("label[for='exam_location']").removeClass("feedback-danger");
        $("label[for='exam_location']").addClass("feedback-success");
        $("#exam_location").removeClass("input-danger");
        $("#exam_location").addClass("input-success");
	}

    //Checking if exam_capacity is inputted
    var exam_capacity = $("#exam_capacity").val();
	if(exam_capacity === '') {
        $("label[for='exam_capacity']").empty().append("Please enter a capacity.");
        $("label[for='exam_capacity']").removeClass("feedback-success");
        $("label[for='exam_capacity']").addClass("feedback-danger");
        $("#exam_capacity").removeClass("input-success");
        $("#exam_capacity").addClass("input-danger");
        $("#exam_capacity").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='exam_capacity']").empty().append("All good!");
        $("label[for='exam_capacity']").removeClass("feedback-danger");
        $("label[for='exam_capacity']").addClass("feedback-success");
        $("#exam_capacity").removeClass("input-danger");
        $("#exam_capacity").addClass("input-success");
	}

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'update_exam_moduleid='  + exam_moduleid +
         '&update_examid='        + examid +
         '&update_exam_name='     + exam_name +
         '&update_exam_notes='    + exam_notes +
         '&update_exam_date='     + exam_date +
         '&update_exam_time='     + exam_time +
         '&update_exam_location=' + exam_location +
         '&update_exam_capacity=' + exam_capacity,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The exam has been updated.');
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
