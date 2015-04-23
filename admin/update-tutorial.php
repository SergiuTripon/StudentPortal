<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $tutorialToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT t.moduleid, t.tutorialid, t.tutorial_name, t.tutorial_assistant, t.tutorial_notes, t.tutorial_day, DATE_FORMAT(tutorial_from_time,'%H:%i') AS tutorial_from_time, DATE_FORMAT(tutorial_to_time,'%H:%i') AS tutorial_to_time, DATE_FORMAT(t.tutorial_from_date,'%d/%m/%Y %H:%i') as tutorial_from_date, DATE_FORMAT(t.tutorial_to_date,'%d/%m/%Y %H:%i') as tutorial_to_date, t.tutorial_location, t.tutorial_capacity FROM system_tutorial t WHERE t.tutorialid = ? LIMIT 1");
    $stmt1->bind_param('i', $tutorialToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $tutorialid, $tutorial_name, $tutorial_assistant, $tutorial_notes, $tutorial_day, $tutorial_from_time, $tutorial_to_time, $tutorial_from_date, $tutorial_to_date, $tutorial_location, $tutorial_capacity);
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

    <title>Student Portal | Update tutorial</title>

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
    <li class="active">Update tutorial</li>
    </ol>

    <!-- Update tutorial -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updatetimetable_form" id="updatetimetable_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input type="hidden" name="tutorialid" id="tutorialid" value="<?php echo $tutorialid; ?>">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="tutorial_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="tutorial_moduleid" id="tutorial_moduleid" style="width: 100%;">
    <?php
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
	<label for="tutorial_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="tutorial_name" id="tutorial_name" value="<?php echo $tutorial_name; ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="tutorial_assistant">Tutorial assistant<span class="field-required">*</span></label>
    <select class="form-control tutorial_assistant" name="tutorial_assistant" id="tutorial_assistant">
    <?php
    $stmt1 = $mysqli->query("SELECT firstname, surname FROM user_detail WHERE userid = '$tutorial_assistant'");

    while ($row = $stmt1->fetch_assoc()){

    $tutorial_assistant_firstname = $row["firstname"];
    $tutorial_assistant_surname = $row["surname"];

        echo '<option value="'.$tutorial_assistant.'" selected>'.$tutorial_assistant_firstname.' '.$tutorial_assistant_surname.'</option>';
    }

    $stmt2 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type='academic staff' AND NOT userid = '$tutorial_assistant'");

    while ($row = $stmt2->fetch_assoc()){

        $other_tutorial_assistant = $row["userid"];

        $stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
        $stmt3->bind_param('i', $other_tutorial_assistant);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($other_tutorial_assistant_firstname, $other_tutorial_assistant_surname);
        $stmt3->fetch();

        echo '<option value="'.$other_tutorial_assistant.'">'.$other_tutorial_assistant_firstname.' '.$other_tutorial_assistant_surname.'</option>';
    }
    ?>
    </select>

    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="tutorial_notes" id="tutorial_notes" placeholder="Enter notes"><?php echo $tutorial_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="tutorial_day">Day<span class="field-required">*</span></label>
    <select class="form-control" name="tutorial_day" id="tutorial_day" style="width: 100%;">
        <option <?php if($tutorial_day == "Monday") echo "selected"; ?>>Monday</option>
        <option <?php if($tutorial_day == "Tuesday") echo "selected"; ?>>Tuesday</option>
        <option <?php if($tutorial_day == "Wednesday") echo "selected"; ?>>Wednesday</option>
        <option <?php if($tutorial_day == "Thursday") echo "selected"; ?>>Thursday</option>
        <option <?php if($tutorial_day == "Friday") echo "selected"; ?>>Friday</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_from_time">From (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_from_time" id="tutorial_from_time" value="<?php echo $tutorial_from_time; ?>" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_to_time">To (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_to_time" id="tutorial_to_time" value="<?php echo $tutorial_to_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_from_date">From (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_from_date" id="tutorial_from_date" value="<?php echo $tutorial_from_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_to_date">To (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_to_date" id="tutorial_to_date" value="<?php echo $tutorial_to_date; ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_location" id="tutorial_location" value="<?php echo $tutorial_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="tutorial_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="tutorial_capacity" id="tutorial_capacity" value="<?php echo $tutorial_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Update tutorial</span></button>
    </div>

    </div>
	
    </form>
    <!-- End of Update tutorial -->
	</div>
    <!-- /container -->
	
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
	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>
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
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
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
        $("#tutorial_moduleid").select2({placeholder: "Select an option"});
        $("#tutorial_assistant").select2({placeholder: "Select an option"});
        $("#tutorial_day").select2({placeholder: "Select an option"});
    });





    // Date Time Picker
    $('#tutorial_from_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#tutorial_to_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#tutorial_from_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#tutorial_to_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    //Update tutorial process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Validation and data gathering
    var tutorialid = $("#tutorialid").val();
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

    var tutorial_assistant = $("#tutorial_assistant :selected").val();
    var tutorial_notes = $("#tutorial_notes").val();
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

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'update_tutorial_moduleid='   + tutorial_moduleid +
         '&update_tutorialid='         + tutorialid +
         '&update_tutorial_name='      + tutorial_name +
         '&update_tutorial_assistant=' + tutorial_assistant +
         '&update_tutorial_notes='     + tutorial_notes +
         '&update_tutorial_day='       + tutorial_day +
         '&update_tutorial_from_time=' + tutorial_from_time +
         '&update_tutorial_to_time='   + tutorial_to_time +
         '&update_tutorial_from_date=' + tutorial_from_date +
         '&update_tutorial_to_date='   + tutorial_to_date +
         '&update_tutorial_location='  + tutorial_location +
         '&update_tutorial_capacity='  + tutorial_capacity,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The tutorial has been updated.');
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
