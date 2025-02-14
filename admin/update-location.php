<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET["id"])) {

    $locationToUpdate = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT markerid, marker_name, marker_notes, marker_url, marker_lat, marker_long, marker_category FROM system_map_marker WHERE markerid = ? LIMIT 1");
    $stmt1->bind_param('i', $locationToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($markerid, $marker_name, $marker_notes, $marker_url, $marker_lat, $marker_long, $marker_category);
    $stmt1->fetch();
    $stmt1->close();

//If URL parameter is not set, do the following
} else {
    header('Location: ../../university-map/');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create location</title>

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
	<li><a href="../../university-map/">University Map</a></li>
    <li class="active">Create location</li>
    </ol>

    <!-- Create location -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createlocation_form" id="createlocation_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input class="form-control" type="hidden" name="markerid" id="markerid" value="<?php echo $markerid ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="marker_name" id="marker_name" value="<?php echo $marker_name ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_notes">Notes</label>
    <textarea class="form-control" rows="5" name="marker_notes" id="marker_notes" placeholder="Enter notes"><?php echo $marker_notes ?></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_url">URL</label>
    <input class="form-control" type="text" name="marker_url" id="marker_url" value="<?php echo $marker_url ?>" placeholder="Enter a URL">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="marker_lat">Latitude<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="marker_lat" id="marker_lat" value="<?php echo $marker_lat ?>" placeholder="Enter latitude">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="marker_long">Longitude<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="marker_long" id="marker_long" value="<?php echo $marker_lat ?>" placeholder="Enter longitude">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="marker_category">Lecturer<span class="field-required">*</span></label>
    <select class="form-control marker_category" name="marker_category" id="marker_category">
        <?php

        //Get location categories
        $stmt1 = $mysqli->query("SELECT DISTINCT marker_category FROM system_map_marker WHERE marker_status = 'active' AND NOT marker_category=''");

        while ($row = $stmt1->fetch_assoc()){

            $marker_category = $row["marker_category"];
            $marker_category = ucfirst($marker_category);

            echo '<option>'.$marker_category.'</option>';
        }

        ?>
    </select>
    </div>
    </div>

	</div>

	<hr>

    <div class="text-center">
    <button id="update-location-submit" class="btn btn-primary btn-lg">Update location</button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg" href="">Create another</a>
	</div>
	
    </form>
    <!-- End of Create location -->

	</div> <!-- /container -->
	
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
	$(document).ready(function () {
        //On load actions
        $("#marker_category").select2({placeholder: "Select an option"});
    });

    //Update location process
    $("#update-location-submit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var markerid = $("#markerid").val();


    //Checking if marker_name is inputted
	var marker_name = $("#marker_name").val();
	if(marker_name === '') {
        $("label[for='marker_name']").empty().append("Please enter a name.");
        $("label[for='marker_name']").removeClass("feedback-success");
        $("label[for='marker_name']").addClass("feedback-danger");
        $("#marker_name").removeClass("input-success");
        $("#marker_name").addClass("input-danger");
        $("#marker_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_name']").empty().append("All good!");
        $("label[for='marker_name']").removeClass("feedback-danger");
        $("label[for='marker_name']").addClass("feedback-success");
        $("#marker_name").removeClass("input-danger");
        $("#marker_name").addClass("input-success");
	}

    var marker_notes = $("#marker_notes").val();
    var marker_url = $("#marker_url").val();

    //Checking if marker_lat is inputted
    var marker_lat = $("#marker_lat").val();
	if(marker_lat === '') {
        $("label[for='marker_lat']").empty().append("Please enter latitude.");
        $("label[for='marker_lat']").removeClass("feedback-success");
        $("label[for='marker_lat']").addClass("feedback-danger");
        $("#marker_lat").removeClass("input-success");
        $("#marker_lat").addClass("input-danger");
        $("#marker_lat").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_lat']").empty().append("All good!");
        $("label[for='marker_lat']").removeClass("feedback-danger");
        $("label[for='marker_lat']").addClass("feedback-success");
        $("#marker_lat").removeClass("input-danger");
        $("#marker_lat").addClass("input-success");
	}

    //Checking if marker_long is inputted
    var marker_long = $("#marker_long").val();
	if(marker_long === '') {
        $("label[for='marker_long']").empty().append("Please enter longitude.");
        $("label[for='marker_long']").removeClass("feedback-success");
        $("label[for='marker_long']").addClass("feedback-danger");
        $("#marker_long").removeClass("input-success");
        $("#marker_long").addClass("input-danger");
        $("#marker_long").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_long']").empty().append("All good!");
        $("label[for='marker_long']").removeClass("feedback-danger");
        $("label[for='marker_long']").addClass("feedback-success");
        $("#marker_long").removeClass("input-danger");
        $("#marker_long").addClass("input-success");
	}

    //Checking if option on the drop-down is inputted
    var marker_category_check = $("#marker_category option:selected").html();
    if (marker_category_check === 'Select an option') {
        $("label[for='marker_category']").empty().append("Please select an option.");
        $("label[for='marker_category']").removeClass("feedback-success");
        $("label[for='marker_category']").addClass("feedback-danger");
        $("#marker_category").removeClass("input-success");
        $("#marker_category").addClass("input-danger");
        $("#marker_category").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='marker_category']").empty().append("All good!");
        $("label[for='marker_category']").removeClass("feedback-danger");
        $("label[for='marker_category']").addClass("feedback-success");
        $("#marker_category").removeClass("input-danger");
        $("#marker_category").addClass("input-success");
    }

    var marker_category = $("#marker_category option:selected").val();

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'markerid='          + markerid +
         '&marker_name1='     + marker_name +
         '&marker_notes1='    + marker_notes +
         '&marker_url1='      + marker_url +
         '&marker_lat1='      + marker_lat +
         '&marker_long1='     + marker_long +
         '&marker_category1=' + marker_category,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#update-location-submit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The location has been updated.');
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

</body>
</html>
