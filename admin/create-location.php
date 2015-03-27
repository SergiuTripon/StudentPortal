<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Create location</title>
	
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

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="marker_name" id="marker_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_notes">Notes</label>
    <textarea class="form-control" rows="5" name="marker_notes" id="marker_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="marker_url">URL</label>
    <input class="form-control" type="text" name="marker_url" id="marker_url" placeholder="Enter a URL">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="marker_lat">Latitude<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="marker_lat" id="marker_lat" placeholder="Enter latitude">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="marker_long">Longitude<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="marker_long" id="marker_long" placeholder="Enter longitude">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
    <label for="marker_category">Category<span class="field-required">*</span></label>
    <select class="selectpicker marker_category" name="marker_category" id="marker_category">
        <option data-hidden="true">Select an option</option>
    <?php
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
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create location</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create location -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
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
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/home/"><span class="ladda-label">Home</span></a>
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
	
    <form class="form-horizontal form-custom">

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

	<script>
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    $('.selectpicker').selectpicker();

    $(".filter-option").css("color", "gray");

    $( ".bootstrap-select .dropdown-menu > li > a" ).click(function() {
        $(".filter-option").css("cssText", "color: #333333 !important;");
    });

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Locations
	var marker_name = $("#marker_name").val();
	if(marker_name === '') {
        $("label[for='marker_name']").empty().append("Please enter a name.");
        $("label[for='marker_name']").removeClass("feedback-happy");
        $("label[for='marker_name']").addClass("feedback-sad");
        $("#marker_name").removeClass("input-happy");
        $("#marker_name").addClass("input-sad");
        $("#marker_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_name']").empty().append("All good!");
        $("label[for='marker_name']").removeClass("feedback-sad");
        $("label[for='marker_name']").addClass("feedback-happy");
        $("#marker_name").removeClass("input-sad");
        $("#marker_name").addClass("input-happy");
	}

    var marker_notes = $("#marker_notes").val();
    var marker_url = $("#marker_url").val();

    var marker_lat = $("#marker_lat").val();
	if(marker_lat === '') {
        $("label[for='marker_lat']").empty().append("Please enter latitude.");
        $("label[for='marker_lat']").removeClass("feedback-happy");
        $("label[for='marker_lat']").addClass("feedback-sad");
        $("#marker_lat").removeClass("input-happy");
        $("#marker_lat").addClass("input-sad");
        $("#marker_lat").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_lat']").empty().append("All good!");
        $("label[for='marker_lat']").removeClass("feedback-sad");
        $("label[for='marker_lat']").addClass("feedback-happy");
        $("#marker_lat").removeClass("input-sad");
        $("#marker_lat").addClass("input-happy");
	}

    var marker_long = $("#marker_long").val();
	if(marker_long === '') {
        $("label[for='marker_long']").empty().append("Please enter longitude.");
        $("label[for='marker_long']").removeClass("feedback-happy");
        $("label[for='marker_long']").addClass("feedback-sad");
        $("#marker_long").removeClass("input-happy");
        $("#marker_long").addClass("input-sad");
        $("#marker_long").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='marker_long']").empty().append("All good!");
        $("label[for='marker_long']").removeClass("feedback-sad");
        $("label[for='marker_long']").addClass("feedback-happy");
        $("#marker_long").removeClass("input-sad");
        $("#marker_long").addClass("input-happy");
	}

    var marker_category_check = $("#marker_category option:selected").html();
    if (marker_category_check === 'Select an option') {
        $("label[for='marker_category']").empty().append("Please select an option.");
        $("label[for='marker_category']").removeClass("feedback-happy");
        $("label[for='marker_category']").addClass("feedback-sad");
        $("#marker_category").removeClass("input-happy");
        $("#marker_category").addClass("input-sad");
        $("#marker_category").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='marker_category']").empty().append("All good!");
        $("label[for='marker_category']").removeClass("feedback-sad");
        $("label[for='marker_category']").addClass("feedback-happy");
        $("#marker_category").removeClass("input-sad");
        $("#marker_category").addClass("input-happy");
    }


    var marker_category = $("#marker_category option:selected").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'marker_name='      + marker_name +
         '&marker_notes='    + marker_notes +
         '&marker_url='      + marker_url +
         '&marker_lat='      + marker_lat +
         '&marker_long='     + marker_long +
         '&marker_category=' + marker_category,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Location created successfully.');
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
