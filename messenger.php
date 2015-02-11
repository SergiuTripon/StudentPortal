<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/js-paths/pacejs-js-path.php'; ?>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Messenger</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="library-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Messenger</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

	<?php
	$stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE NOT userid = '$userid'");
	while($row = $stmt1->fetch_assoc()) {

	$userid1 = $row["userid"];

 	echo '<form id="message-user-form-'.$userid1.'" style="display: none;" action="/messenger/message-user/" method="POST">
		<input type="hidden" name="recordToMessage" id="recordToMessage" value="'.$userid1.'"/>
		</form>';
	}
	$stmt1->close();
	?>

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Send a message - click to minimize or maximize</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom user-table">

	<thead>
	<tr>
	<th>First name</th>
	<th>Surname</th>
	<th>Student number</th>
	<th>Email address</th>
	<th>Message</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname, user_details.studentno FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt2->fetch_assoc()) {

	$userid2 = $row["userid"];
	$email = $row["email"];
	$firstname = $row["firstname"];
	$surname = $row["surname"];
    $studentno = $row["studentno"];

	echo '<tr id="book-'.$userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Student number">'.$studentno.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td id="message-hide" data-title="Message"><a id="message-'.$userid2.'" class="message-button"><i class="fa fa-envelope"></i></a></td>
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

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a id="message-read-trigger" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Received messages - click to minimize or maximize</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Reserved books -->
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

	$stmt2 = $mysqli->query("SELECT user_messages.userid, user_messages.message_subject, user_messages.message_body, DATE_FORMAT(user_messages.created_on,'%d %b %y %H:%i') as created_on FROM user_messages LEFT JOIN user_details as join1 ON user_messages.userid=join1.userid LEFT JOIN user_details as join2 ON user_messages.message_to=join2.userid WHERE user_messages.message_to = '$userid'");

	while($row = $stmt2->fetch_assoc()) {

    $message_from = $row["userid"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_sent_on = $row["created_on"];

	$stmt3 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt3->bind_param('i', $message_from);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($firstname, $surname);
	$stmt3->fetch();

	echo '<tr>

			<td data-title="From">'.$firstname.' '.$surname.'</td>
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
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Sent messages - click to minimize or maximize</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Reserved books -->
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

	$stmt4 = $mysqli->query("SELECT user_messages.message_to, user_messages.message_subject, user_messages.message_body, user_messages.isRead, DATE_FORMAT(user_messages.created_on,'%d %b %y %H:%i') as created_on FROM user_messages LEFT JOIN user_details as join1 ON user_messages.userid=join1.userid LEFT JOIN user_details as join2 ON user_messages.message_to=join2.userid WHERE user_messages.userid = '$userid'");

	while($row = $stmt4->fetch_assoc()) {

    $message_to = $row["message_to"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_isread = $row["isRead"];
	$message_sent_on = $row["created_on"];

	$stmt5 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt5->bind_param('i', $message_to);
	$stmt5->execute();
	$stmt5->store_result();
	$stmt5->bind_result($firstname, $surname);
	$stmt5->fetch();

	echo '<tr>

			<td data-title="To">'.$firstname.' '.$surname.'</td>
			<td data-title="Subject">'.$message_subject.'</td>
			<td data-title="Message">'.$message_body.'</td>
			<td data-title="Message">'.($event_ticket_no === '' ? "No" : "Yes").'</td>
			<td data-title="Sent on">'.$message_sent_on.'</td>
			</tr>';
	}

	$stmt4->close();
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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script>
	$(document).ready(function () {

	//DataTables
    $('.user-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no users to display."
		}
	});

	$('.message-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no messages to display."
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

	//Book event form submit
	$("body").on("click", ".message-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#message-user-form-" + DbNumberID).submit();

	});

	});
	</script>

</body>
</html>
