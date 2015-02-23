<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/bootstrap-select-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create event</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../events/">Events</a></li>
    <li class="active">Create event</li>
    </ol>

    <!-- Create event -->
	<form class="form-custom" style="max-width: 100%;" name="createbook_form" id="createbook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Name</label>
    <input class="form-control" type="text" name="event_name" id="event_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="event_notes" id="event_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>URL</label>
    <input class="form-control" type="text" name="event_url" id="event_url" placeholder="Enter a URL">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>From</label>
	<input type="text" class="form-control" name="event_from" id="event_from" placeholder="Select a date and time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>To</label>
	<input type="text" class="form-control" name="event_to" id="event_to" placeholder="Select a date and time">
	</div>
	</div>
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Price</label>
	<input type="text" class="form-control" name="event_amount" id="event_amount" placeholder="Enter an amount">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Ticket amount</label>
	<input type="text" class="form-control" name="event_ticket_no" id="event_ticket_no" placeholder="Enter a number">
	</div>
	</div>
    <p id="error3" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Category</label>
    <select class="selectpicker event_category" name="event_category" id="event_category">
        <option data-hidden="true">Select an option</option>
        <option>Social</option>
        <option>Careers</option>
    </select>

    </div>
    </div>
    <p id="error4" class="feedback-sad text-center"></p>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create event</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
    <?php include '../assets/js-paths/bootstrap-select-js-path.php'; ?>
    <?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    $('.selectpicker').selectpicker();

    $(".filter-option").css("color", "gray");

    $( ".bootstrap-select .dropdown-menu > li > a" ).click(function() {
        $(".filter-option").css("cssText", "color: #333333 !important;");
    });

    // Date Time Picker
    var today = new Date();
	$(function () {

    $('#event_from').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#tutorial_to_date").datepicker( "option", "minDate", selectedDate);
        }
    });
    $('#event_to').datepicker({
        dateFormat: "yy-mm-dd",
        controlType: 'select',
        minDate: today,
        changeMonth: true,
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#tutorial_from_date").datepicker( "option", "minDate", selectedDate);
        }
    });

	});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
	var event_name = $("#event_name").val();
	if(event_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a name.");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
	}

    var event_notes = $("#event_notes").val();
    var event_url = $("#event_url").val();

    var event_from = $("#event_from").val();
	if(event_from === '') {
		$("#error2").show();
        $("#error2").empty().append("Please select a date and time.");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
	}

    var event_to = $("#event_to").val();
	if(event_to === '') {
		$("#error2").show();
        $("#error2").empty().append("Please select a date and time.");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
	}

    var event_amount = $("#event_amount").val();
	if(event_amount === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a price.");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
	}

    var event_ticket_no = $("#event_ticket_no").val();
	if(event_ticket_no === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a number.");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
	}

    var event_category_check = $("#event_category option:selected").html();
    if (event_category_check === 'Select an option') {
        $("#error4").show();
        $("#error4").empty().append("Please select an option.");
        hasError  = true;
        return false;
    }
    else {
        $("#error4").hide();
    }

    var event_category = $("#event_category option:selected").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'event_name='       + event_name +
         '&event_notes='     + event_notes +
         '&event_url='       + event_url +
         '&event_from='      + event_from +
         '&event_to='        + event_to +
         '&event_amount='    + event_amount +
         '&event_ticket_no=' + event_ticket_no +
         '&event_category='  + event_category,

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
	});
	</script>

</body>
</html>
