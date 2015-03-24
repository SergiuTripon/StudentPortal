<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Messenger</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="library-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Messenger</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Send a message</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Send a message -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom user-table">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Email address</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE NOT user_signin.userid = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
	$email = $row["email"];
	$firstname = $row["firstname"];
	$surname = $row["surname"];

	echo '<tr id="book-'.$userid.'">

			<td data-title="Full name">'.$firstname.' '.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a class="btn btn-primary ladda-button btn-md message-button" href="../messenger/message-user?id='.$userid.'" data-style="slide-up"><span class="ladda-label">Message</span></a></td>
			</tr>';
	}
	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a id="message-read-trigger" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Received messages</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Received messages -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom message-table">

	<thead>
	<tr>
	<th>From</th>
	<th>Subject</th>
	<th>Message</th>
	<th>Sent on</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT user_message_received.message_from, user_message.message_subject, user_message.message_body, DATE_FORMAT(user_message.created_on,'%d %b %y %H:%i') as created_on, user_detail.firstname, user_detail.surname FROM user_message_received LEFT JOIN user_message ON user_message_received.messageid=user_message.messageid LEFT JOIN user_detail as user_detail ON user_message_received.message_from=user_detail.userid WHERE user_message_received.message_to = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $messageid = $row["messageid"];
    $message_from = $row["message_from"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_sent_on = $row["created_on"];
    $message_from_firstname = $row["firstname"];
    $message_from_surname = $row["surname"];

	echo '<tr id="'.$messageid.'">

			<td data-title="From">'.$message_from_firstname.' '.$message_from_surname.'</td>
			<td data-title="Subject">'.$message_subject.'</td>
			<td data-title="Message">'.$message_body.'</td>
			<td data-title="Sent on">'.$message_sent_on.'</td>
			</tr>';
	}

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Sent messages</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Sent messages -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom message-table">

	<thead>
	<tr>
	<th>To</th>
	<th>Subject</th>
	<th>Message</th>
	<th>Read</th>
	<th>Sent on</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT s.messageid, s.message_to, s.isRead, m.message_subject, m.message_body, DATE_FORMAT(m.created_on,'%d %b %y %H:%i') as created_on, d.firstname, d.surname FROM user_message_sent s LEFT JOIN user_message m ON s.messageid=m.messageid LEFT JOIN user_detail d ON s.message_to=d.userid WHERE s.message_from = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

    $messageid = $row["messageid"];
    $message_to = $row["message_to"];
    $message_isRead = $row["isRead"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_sent_on = $row["created_on"];
    $message_to_firstname = $row["firstname"];
    $message_to_surname = $row["surname"];

	echo '<tr id="'.$messageid.'">

			<td data-title="To">'.$message_to_firstname.' '.$message_to_surname.'</td>
			<td data-title="Subject"><a href="#view-'.$messageid.'" data-toggle="modal">'.$message_subject.'</a></td>
			<td data-title="Message">'.$message_body.'</td>
			<td data-title="Message">'.($message_isRead === '0' ? "No" : "Yes").'</td>
			<td data-title="Sent on">'.$message_sent_on.'</td>
			</tr>

			<div id="view-'.$messageid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-calendar"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$message_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>To:</b> '.(empty($task_notes) ? "-" : "$message_to_firstname $message_to_surname").'</p>
			<p><b>Subject:</b> '.(empty($message_subject) ? "-" : "$message_subject").'</p>
			<p><b>Message:</b> '.(empty($message_body) ? "-" : "$message_body").'</p>
			<p><b>Read:</b> '.($message_isRead === '0' ? "No" : "Yes").'</p>
			<p><b>Sent on:</b> '.(empty($message_sent_on) ? "-" : "$message_sent_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#delete-'.$messageid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$messageid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete '.$message_subject.'?</p>
			<p id="delete-confirmation" class="text-center feedback-happy" style="display: none;">'.$message_subject.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$messageid.'" class="btn btn-success btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

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

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//DataTables
    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no records to display."
		}
	});

	var message_read;
	message_read = '1';

	$("#message-read-trigger").click(function (e) {
	e.preventDefault();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'message_read=' + message_read,
    success:function() {
    },
    error:function (xhr, ajaxOptions, thrownError) {
    }
	});
	});
	</script>

</body>
</html>
