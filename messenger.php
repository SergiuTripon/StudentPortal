<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Messenger</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="library-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Messenger</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Send a message</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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

    //Get active users
	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE NOT user_signin.userid = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
	$email = $row["email"];
	$firstname = $row["firstname"];
	$surname = $row["surname"];

	echo '<tr>

			<td data-title="Full name">'.$firstname.' '.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md message-button btn-load" href="../messenger/message-user?id='.$userid.'" >Message</a></td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Received messages</a>
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
	<th>Sent on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    //Get messages received by the currently signed in user
	$stmt2 = $mysqli->query("SELECT r.message_from, m.messageid, m.message_subject, m.message_body, DATE_FORMAT(m.created_on,'%d %b %y %H:%i') as created_on, d.userid, d.firstname, d.surname FROM user_message_received r LEFT JOIN user_message m ON r.messageid=m.messageid LEFT JOIN user_detail d ON r.message_from=d.userid WHERE r.message_to = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $messageid = $row["messageid"];
    $message_from = $row["message_from"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_sent_on = $row["created_on"];
    $userid = $row["userid"];
    $message_from_firstname = $row["firstname"];
    $message_from_surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);

	        echo
           '<tr>
			<td data-title="From"><a href="#view-user-'.$userid.'" data-toggle="modal">'.$message_from_firstname.' '.$message_from_surname.'</a></td>
			<td data-title="Subject"><a id="message-'.$messageid.'" class="message-read-trigger" href="#view-message-'.$messageid.'" data-toggle="modal">'.$message_subject.'</a></td>
			<td data-title="Sent on">'.$message_sent_on.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/messenger/message-user?id='.$userid.'">Reply</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$messageid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div id="view-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-comments"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$message_from_firstname.' '.$message_from_surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Gender:</b> '.(empty($gender) ? "-" : "$gender").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
            <a class="btn btn-primary btn-md message-button" href="../messenger/message-user?id='.$userid.'" >Send another</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-message-'.$messageid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-comments"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$message_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>To:</b> '.$message_from_firstname.' '.$message_from_surname.'</p>
			<p><b>Subject:</b> '.(empty($message_subject) ? "-" : "$message_subject").'</p>
			<p><b>Message:</b> '.(empty($message_body) ? "-" : "$message_body").'</p>
			<p><b>Sent on:</b> '.(empty($message_sent_on) ? "-" : "$message_sent_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a class="btn btn-primary btn-md message-button" href="../messenger/message-user?id='.$userid.'" >Reply</a>
            <a href="#delete-'.$messageid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$messageid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete message?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$message_subject.'""?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$messageid.'" class="btn btn-primary btn-lg btn-delete-received-message btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
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
	<th>Sent on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    //Get messages sent by the currently signed in user
	$stmt1 = $mysqli->query("SELECT s.messageid, s.message_to, r.isRead, m.message_subject, m.message_body, DATE_FORMAT(m.created_on,'%d %b %y %H:%i') as created_on, d.userid, d.firstname, d.surname, d.gender FROM user_message_sent s LEFT JOIN user_message_received r ON s.messageid=r.messageid LEFT JOIN user_message m ON s.messageid=m.messageid LEFT JOIN user_detail d ON s.message_to=d.userid WHERE s.message_from = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

    $messageid = $row["messageid"];
    $message_to = $row["message_to"];
    $message_isRead = $row["isRead"];
	$message_subject = $row["message_subject"];
	$message_body = $row["message_body"];
	$message_sent_on = $row["created_on"];
    $userid = $row["userid"];
    $message_to_firstname = $row["firstname"];
    $message_to_surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);

	echo '<tr id="message-'.$messageid.'">

			<td data-title="To"><a href="#view-user-'.$userid.'" data-toggle="modal">'.$message_to_firstname.' '.$message_to_surname.'</a></td>
			<td data-title="Subject"><a href="#view-message-'.$messageid.'" data-toggle="modal">'.$message_subject.'</a></td>
			<td data-title="Sent on">'.$message_sent_on.'</td>
			<td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/messenger/message-user?id='.$userid.'">Send another</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$messageid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div id="view-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa fa-comments"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$message_to_firstname.' '.$message_to_surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Gender:</b> '.(empty($gender) ? "-" : "$gender").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-action pull-left">
            <a class="btn btn-primary btn-md message-button" href="../messenger/message-user?id='.$userid.'" >Send another</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-message-'.$messageid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-comments"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$message_subject.'</h4>
			</div>

			<div class="modal-body">
			<p><b>To:</b> '.$message_to_firstname.' '.$message_to_surname.'</p>
			<p><b>Subject:</b> '.(empty($message_subject) ? "-" : "$message_subject").'</p>
			<p><b>Message:</b> '.(empty($message_body) ? "-" : "$message_body").'</p>
			<p><b>Read:</b> '.($message_isRead === '0' ? "No" : "Yes").'</p>
			<p><b>Sent on:</b> '.(empty($message_sent_on) ? "-" : "$message_sent_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a class="btn btn-primary btn-md message-button" href="../messenger/message-user?id='.$userid.'" >Send another</a>
            <a href="#delete-'.$messageid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$messageid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete message?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$message_subject.'""?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$messageid.'" class="btn btn-primary btn-lg btn-delete-sent-message">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
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

	<?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

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

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>

	//Initialize DataTables
    $('.table-custom').dataTable(settings);

    //Set message read process
	$(".message-read-trigger").click(function (e) {
	e.preventDefault();

    //Get clicked ID
    var clickedID = this.id.split('-');
    var messageToRead = clickedID[1];

    //Initialize Ajax call
	jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'messageToRead=' + messageToRead,

    //If action completed, do the following
    success:function() {
    },
    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError) {
    }
	});
	});

   //Delete received message process
    $("body").on("click", ".btn-delete-received-message", function(e) {
    e.preventDefault();

    //Get clicked ID
    var clickedID = this.id.split('-');
    var receivedMessageToDelete = clickedID[1];

    //Initialize Ajax call
	jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",

    //Data posted
	data:'receivedMessageToDelete='+ receivedMessageToDelete,


    //If action completed, do the following
	success:function(){
        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            location.reload();
        });
	},

    //If action failed, do the following
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete sent message process
    $("body").on("click", ".btn-delete-sent-message", function(e) {
    e.preventDefault();

    //Get clicked ID
    var clickedID = this.id.split('-');
    var sentMessageToDelete = clickedID[1];

    //Initialize Ajax call
	jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",

    //Data posted
	data:'sentMessageToDelete='+ sentMessageToDelete,

    //If action completed, do the following
	success:function(){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            location.reload();
        });
	},
    //If action failed, do the following
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });
	</script>

</body>
</html>
