<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create exam</title>

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
	<li><a href="../../exams/">Exams</a></li>
    <li class="active">Create exam</li>
    </ol>

    <!-- Create exam -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createexam_form" id="createexam_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="exam_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="exam_moduleid" id="exam_moduleid" style="width: 100%">
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
	<label for="exam_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="exam_name" id="exam_name" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="exam_notes">Notes</label>
    <textarea class="form-control" rows="5" name="exam_notes" id="exam_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_date">Date<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_date" id="exam_date" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_time">Time<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_time" id="exam_time" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_location" id="exam_location" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="exam_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="exam_capacity" id="exam_capacity" placeholder="Enter a capacity">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Create exam</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg btn-load" href="">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create exam -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>


    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/home/">Home</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>


    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    //On load
    $(document).ready(function () {
        //select2
        $("#exam_moduleid").select2({placeholder: "Select an option"});
    });




    // Date Time Picker
    $('#exam_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#exam_time').datetimepicker({
        format: 'HH:mm'
    });

    //Create timetable ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var exam_moduleid_check = $('#exam_moduleid :selected').html();
    if (exam_moduleid_check === '') {
        $("label[for='exam_moduleid']").empty().append("Please select a module.");
        $("label[for='exam_moduleid']").removeClass("feedback-happy");
        $("label[for='exam_moduleid']").addClass("feedback-sad");
        $("[aria-owns='select2-exam_moduleid-results']").removeClass("input-happy");
        $("[aria-owns='select2-exam_moduleid-results']").addClass("input-sad");
        $("[aria-owns='select2-exam_moduleid-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='exam_moduleid']").empty().append("All good!");
        $("label[for='exam_moduleid']").removeClass("feedback-sad");
        $("label[for='exam_moduleid']").addClass("feedback-happy");
        $("[aria-owns='select2-exam_moduleid-results']").removeClass("input-sad");
        $("[aria-owns='select2-exam_moduleid-results']").addClass("input-happy");
    }

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

    var exam_moduleid= $("#exam_moduleid option:selected").val();
    var exam_notes = $("#exam_notes").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'create_exam_moduleid='  + exam_moduleid +
         '&create_exam_name='     + exam_name +
         '&create_exam_notes='    + exam_notes +
         '&create_exam_date='     + exam_date +
         '&create_exam_time='     + exam_time +
         '&create_exam_location=' + exam_location +
         '&create_exam_capacity=' + exam_capacity,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The exam has been created.');
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
