<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

    $eventToUpdate = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_notes, event_url, DATE_FORMAT(event_from,'%d/%m/%Y %H:%i') as event_from, DATE_FORMAT(event_to,'%d/%m/%Y %H:%i') as event_to, event_amount, event_ticket_no FROM system_event WHERE eventid = ? LIMIT 1");
    $stmt1->bind_param('i', $eventToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($eventid, $event_name, $event_notes, $event_url, $event_from, $event_to, $event_amount, $event_ticket_no);
    $stmt1->fetch();
    $stmt1->close();

    echo $event_to;

} else {
    header('Location: ../../events/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Update event</title>

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
	<li><a href="../../events/">Events</a></li>
    <li class="active">Update event</li>
    </ol>

    <!-- Update event -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updateevent_form" id="updateevent_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input type="hidden" name="eventid" id="eventid" value="<?php echo $eventid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="event_name">Name</label>
    <input class="form-control" type="text" name="event_name" id="event_name" value="<?php echo $event_name; ?>" placeholder="Enter a name">
	</div>
    </div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="event_notes" id="event_notes" placeholder="Enter notes"><?php echo $event_notes; ?></textarea>
	</div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>URL</label>
    <input class="form-control" type="text" name="event_url" id="event_url" value="<?php echo $event_url; ?>" placeholder="Enter a URL">
	</div>
    </div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_from">From<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_from" id="event_from" value="<?php echo $event_from; ?>" placeholder="Select a date and time">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="event_to">To<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_to" id="event_to" value="<?php echo $event_to; ?>" placeholder="Select a date and time">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label>Price (&pound;)<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_amount" id="event_amount" value="<?php echo $event_amount; ?>" placeholder="Enter an amount">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label>Ticket amount<span class="field-required">*</span></label>
	<input type="text" class="form-control" name="event_ticket_no" id="event_ticket_no" value="<?php echo $event_ticket_no; ?>" placeholder="Enter a number">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Update event</button>
    </div>

    </div>
	
    </form>
    <!-- End of Update book -->

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

    // Date Time Picker
    $('#event_from').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
    });
    $('#event_to').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
    });

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Events
    var eventid = $("#eventid").val();

	var event_name = $("#event_name").val();
	if(event_name === '') {
        $("label[for='event_name']").empty().append("Please enter a name.");
        $("label[for='event_name']").removeClass("feedback-success");
        $("label[for='event_name']").addClass("feedback-danger");
        $("#exam_name").removeClass("input-success");
        $("#exam_name").addClass("input-danger");
        $("#exam_name").focus();
        hasError  = true;
    } else {
        $("label[for='event_name']").empty().append("All good!");
        $("label[for='event_name']").removeClass("feedback-danger");
        $("label[for='event_name']").addClass("feedback-success");
        $("#event_name").removeClass("input-danger");
        $("#event_name").addClass("input-success");
	}

    var event_notes = $("#event_notes").val();
    var event_url = $("#event_url").val();

    var event_from = $("#event_from").val();
	if(event_from === '') {
        $("label[for='event_from']").empty().append("Please select a date and time.");
        $("label[for='event_from']").removeClass("feedback-success");
        $("label[for='event_from']").addClass("feedback-danger");
        $("#event_from").removeClass("input-success");
        $("#event_from").addClass("input-danger");
        $("#event_from").focus();
        hasError  = true;
    } else {
        $("label[for='event_from']").empty().append("All good!");
        $("label[for='event_from']").removeClass("feedback-danger");
        $("label[for='event_from']").addClass("feedback-success");
        $("#event_from").removeClass("input-danger");
        $("#event_from").addClass("input-success");
	}

    var event_to = $("#event_to").val();
	if(event_to === '') {
        $("label[for='event_to']").empty().append("Please select a date and time.");
        $("label[for='event_to']").removeClass("feedback-success");
        $("label[for='event_to']").addClass("feedback-danger");
        $("#event_to").removeClass("input-success");
        $("#event_to").addClass("input-danger");
        $("#event_to").focus();
        hasError  = true;
    } else {
        $("label[for='event_to']").empty().append("All good!");
        $("label[for='event_to']").removeClass("feedback-danger");
        $("label[for='event_to']").addClass("feedback-success");
        $("#event_to").removeClass("input-danger");
        $("#event_to").addClass("input-success");
	}

    var event_amount = $("#event_amount").val();
	if(event_amount === '') {
        $("label[for='event_amount']").empty().append("Please enter an amount.");
        $("label[for='event_amount']").removeClass("feedback-success");
        $("label[for='event_amount']").addClass("feedback-danger");
        $("#event_amount").removeClass("input-success");
        $("#event_amount").addClass("input-danger");
        $("#event_amount").focus();
        hasError  = true;
    } else {
        $("label[for='event_amount']").empty().append("All good!");
        $("label[for='event_amount']").removeClass("feedback-danger");
        $("label[for='event_amount']").addClass("feedback-success");
        $("#event_amount").removeClass("input-danger");
        $("#event_amount").addClass("input-success");
	}

    var event_ticket_no = $("#event_ticket_no").val();
	if(event_ticket_no === '') {
        $("label[for='event_amount']").empty().append("Please enter an amount.");
        $("label[for='event_amount']").removeClass("feedback-success");
        $("label[for='event_amount']").addClass("feedback-danger");
        $("#event_amount").removeClass("input-success");
        $("#event_amount").addClass("input-danger");
        $("#event_amount").focus();
        hasError  = true;
    } else {
        $("label[for='event_amount']").empty().append("All good!");
        $("label[for='event_amount']").removeClass("feedback-danger");
        $("label[for='event_amount']").addClass("feedback-success");
        $("#event_amount").removeClass("input-danger");
        $("#event_amount").addClass("input-success");
	}

    var event_category = $("#event_category option:selected").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'eventid1='          + eventid +
         '&event_name1='       + event_name +
         '&event_notes1='     + event_notes +
         '&event_url1='       + event_url +
         '&event_from1='      + event_from +
         '&event_to1='        + event_to +
         '&event_amount1='    + event_amount +
         '&event_ticket_no1=' + event_ticket_no +
         '&event_category1='  + event_category,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The event has been updated.');
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
