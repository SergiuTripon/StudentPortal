<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create event</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../events/">Events</a></li>
    <li class="active">Create event</li>
    </ol>

    <!-- Create event -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createbook_form" id="createbook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="event_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="event_name" id="event_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="event_notes" id="event_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>URL</label>
    <input class="form-control" type="text" name="event_url" id="event_url" placeholder="Enter a URL">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_from">From<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_from" id="event_from" placeholder="Select a date and time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_to">To<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_to" id="event_to" placeholder="Select a date and time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_amount">Price (&pound;)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_amount" id="event_amount" placeholder="Enter an amount">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_ticket_no">Tickets available<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_ticket_no" id="event_ticket_no" placeholder="Enter a number">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Create event</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg" href="">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create event -->

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
    <a class="btn btn-primary btn-lg" href="/home/">Home</span></a>
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
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
    <?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>




    // Date Time Picker
    $('#event_from').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
    });
    $('#event_to').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
    });

    //Create event ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Modules
	var event_name = $("#event_name").val();
	if(event_name === '') {
        $("label[for='event_name']").empty().append("Please enter a name.");
        $("label[for='event_name']").removeClass("feedback-happy");
        $("label[for='event_name']").addClass("feedback-sad");
        $("#event_name").removeClass("input-happy");
        $("#event_name").addClass("input-sad");
        $("#event_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='event_name']").empty().append("All good!");
        $("label[for='event_name']").removeClass("feedback-sad");
        $("label[for='event_name']").addClass("feedback-happy");
        $("#event_name").removeClass("input-sad");
        $("#event_name").addClass("input-happy");
	}

    var event_notes = $("#event_notes").val();
    var event_url = $("#event_url").val();

    var event_from = $("#event_from").val();
	if(event_from === '') {
        $("label[for='event_from']").empty().append("Please select a date and time.");
        $("label[for='event_from']").removeClass("feedback-happy");
        $("label[for='event_from']").addClass("feedback-sad");
        $("#event_from").removeClass("input-happy");
        $("#event_from").addClass("input-sad");
        $("#event_from").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='event_from']").empty().append("All good!");
        $("label[for='event_from']").removeClass("feedback-sad");
        $("label[for='event_from']").addClass("feedback-happy");
        $("#event_from").removeClass("input-sad");
        $("#event_from").addClass("input-happy");
	}

    var event_to = $("#event_to").val();
	if(event_to === '') {
        $("label[for='event_to']").empty().append("Please select a date and time.");
        $("label[for='event_to']").removeClass("feedback-happy");
        $("label[for='event_to']").addClass("feedback-sad");
        $("#event_to").removeClass("input-happy");
        $("#event_to").addClass("input-sad");
        $("#event_to").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='event_to']").empty().append("All good!");
        $("label[for='event_to']").removeClass("feedback-sad");
        $("label[for='event_to']").addClass("feedback-happy");
        $("#event_to").removeClass("input-sad");
        $("#event_to").addClass("input-happy");
	}

    var event_amount = $("#event_amount").val();
	if(event_amount === '') {
        $("label[for='event_amount']").empty().append("Please enter a price.");
        $("label[for='event_amount']").removeClass("feedback-happy");
        $("label[for='event_amount']").addClass("feedback-sad");
        $("#event_amount").removeClass("input-happy");
        $("#event_amount").addClass("input-sad");
        $("#event_amount").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='event_amount']").empty().append("All good!");
        $("label[for='event_amount']").removeClass("feedback-sad");
        $("label[for='event_amount']").addClass("feedback-happy");
        $("#event_amount").removeClass("input-sad");
        $("#event_amount").addClass("input-happy");
	}

    var event_ticket_no = $("#event_ticket_no").val();
	if(event_ticket_no === '') {
        $("label[for='event_ticket_no']").empty().append("Please enter a number.");
        $("label[for='event_ticket_no']").removeClass("feedback-happy");
        $("label[for='event_ticket_no']").addClass("feedback-sad");
        $("#event_ticket_no").removeClass("input-happy");
        $("#event_ticket_no").addClass("input-sad");
        $("#event_ticket_no").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='event_ticket_no']").empty().append("All good!");
        $("label[for='event_ticket_no']").removeClass("feedback-sad");
        $("label[for='event_ticket_no']").addClass("feedback-happy");
        $("#event_ticket_no").removeClass("input-sad");
        $("#event_ticket_no").addClass("input-happy");
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'create_event_name='       + event_name +
         '&create_event_notes='     + event_notes +
         '&create_event_url='       + event_url +
         '&create_event_from='      + event_from +
         '&create_event_to='        + event_to +
         '&create_event_amount='    + event_amount +
         '&create_event_ticket_no=' + event_ticket_no,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Event created successfully.');
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
