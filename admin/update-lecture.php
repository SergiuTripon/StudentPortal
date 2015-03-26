<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $lectureToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT l.moduleid, l.lectureid, l.lecture_name, l.lecture_lecturer, l.lecture_notes, l.lecture_day, DATE_FORMAT(l.lecture_from_time,'%H:%i') AS lecture_from_time, DATE_FORMAT(l.lecture_to_time,'%H:%i') AS lecture_to_time, l.lecture_from_date, l.lecture_to_date, l.lecture_location, l.lecture_capacity FROM system_lecture l WHERE l.lectureid = ? LIMIT 1");
    $stmt1->bind_param('i', $lectureToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $lectureid, $lecture_name, $lecture_lecturer, $lecture_notes, $lecture_day, $lecture_from_time, $lecture_to_time, $lecture_from_date, $lecture_to_date, $lecture_location, $lecture_capacity);
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

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Update lecture</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Update lecture</li>
    </ol>

    <!-- Update lecture -->
	<form class="form-custom" style="max-width: 100%;" name="updatelecture_form" id="updatelecture_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <input type="hidden" name="lectureid" id="lectureid" value="<?php echo $lectureid; ?>">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="lecture_moduleid">Module<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_moduleid" id="lecture_moduleid" style="width: 100%;">
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
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="lecture_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" value="<?php echo $lecture_name; ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="lecture_lecturer">Lecturer<span class="field-required">*</span></label>
    <select class="form-control lecture_lecturer" name="lecture_lecturer" id="lecture_lecturer">
    <?php
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
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="lecture_notes" id="lecture_notes" placeholder="Enter notes"><?php echo $lecture_notes; ?></textarea>
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
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
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_from_time">From (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_time" id="lecture_from_time" value="<?php echo $lecture_from_time; ?>" placeholder="Select a time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_to_time">To (time)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_time" id="lecture_to_time" value="<?php echo $lecture_to_time; ?>" placeholder="Select a time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_from_date">From (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_from_date" id="lecture_from_date" value="<?php echo $lecture_from_date; ?>" placeholder="Select a date">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_to_date">To (date)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_to_date" id="lecture_to_date" value="<?php echo $lecture_to_date; ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="lecture_location">Location<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_location" id="lecture_location" value="<?php echo $lecture_location; ?>" placeholder="Enter a location">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="lecture_capacity">Capacity<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="lecture_capacity" id="lecture_capacity" value="<?php echo $lecture_capacity; ?>" placeholder="Enter a capacity">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update lecture</span></button>
    </div>

    </div>
	
    </form>
    <!-- End of Update lecture -->
	</div>
    <!-- /container -->
	
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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
    <?php include '../assets/js-paths/select2-js-path.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
    //On load
    $(document).ready(function () {
        //select2
        $("#lecture_moduleid").select2({placeholder: "Select an option"});
        $("#lecture_lecturer").select2({placeholder: "Select an option"});
        $("#lecture_day").select2({placeholder: "Select an option"});
    });

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    // Date Time Picker
    $('#lecture_from_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#lecture_to_time').datetimepicker({
        format: 'HH:mm'
    });
    $('#lecture_from_date').datetimepicker({
        format: 'YYYY/MM/DD'
    });
    $('#lecture_to_date').datetimepicker({
        format: 'YYYY/MM/DD'
	});

    //Update lecture process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Validation and data gathering
    var lectureid = $("#lectureid").val();

    $("label[for='lecture_moduleid']").empty().append("All good!");
    $("label[for='lecture_moduleid']").removeClass("feedback-sad");
    $("label[for='lecture_moduleid']").addClass("feedback-happy");
    $("[aria-owns='select2-lecture_moduleid-results']").removeClass("input-sad");
    $("[aria-owns='select2-lecture_moduleid-results']").addClass("input-happy");

    var lecture_moduleid= $("#lecture_moduleid :selected").val();

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

    $("label[for='lecture_lecturer']").empty().append("All good!");
    $("label[for='lecture_lecturer']").removeClass("feedback-sad");
    $("label[for='lecture_lecturer']").addClass("feedback-happy");
    $("[aria-owns='select2-lecture_lecturer-results']").removeClass("input-sad");
    $("[aria-owns='select2-lecture_lecturer-results']").addClass("input-happy");

    var lecture_lecturer = $("#lecture_lecturer :selected").val();

    $("label[for='lecture_notes']").empty().append("All good!");
    $("label[for='lecture_notes']").removeClass("feedback-sad");
    $("label[for='lecture_notes']").addClass("feedback-happy");
    $("[aria-owns='select2-lecture_notes-results']").removeClass("input-sad");
    $("[aria-owns='select2-lecture_notes-results']").addClass("input-happy");

    var lecture_notes = $("#lecture_notes").val();

    $("label[for='lecture_day']").empty().append("All good!");
    $("label[for='lecture_day']").removeClass("feedback-sad");
    $("label[for='lecture_day']").addClass("feedback-happy");
    $("[aria-owns='select2-lecture_day-results']").removeClass("input-sad");
    $("[aria-owns='select2-lecture_day-results']").addClass("input-happy");

    var lecture_day = $("#lecture_day :selected").html();

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

    //Ajax
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
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
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('Lecture updated successfully.');
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
