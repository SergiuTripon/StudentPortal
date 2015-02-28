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

    <title>Student Portal | Feedback</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lectures</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>Day</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_lectures.lectureid, system_lectures.lecture_name, user_details.firstname, user_details.surname, system_lectures.lecture_day FROM system_lectures LEFT JOIN system_modules ON system_lectures.moduleid=system_modules.moduleid LEFT JOIN user_timetable ON system_lectures.moduleid=user_timetable.moduleid LEFT JOIN user_details ON system_lectures.lecture_lecturer=user_details.userid WHERE user_timetable.userid='$session_userid' AND system_lectures.lecture_status='active'");

	while($row = $stmt1->fetch_assoc()) {

    $lectureid = $row["lectureid"];
	$lecture_name = $row["lecture_name"];
	$firstname = $row["firstname"];
    $surname = $row["surname"];
	$lecture_day = $row["lecture_day"];

	echo '<tr>

			<td data-title="Name">'.$lecture_name.'</td>
			<td data-title="Lecturer">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_day.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../feedback/submit-lecture-feedback?id='.$lectureid.'" data-style="slide-up"><span class="ladda-label">Feedback</span></a></td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tutorials</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Tutorial assistant</th>
	<th>Day</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT system_tutorials.tutorialid, system_tutorials.tutorial_name, user_details.firstname, user_details.surname, system_tutorials.tutorial_day FROM system_tutorials LEFT JOIN system_modules ON system_tutorials.moduleid=system_modules.moduleid LEFT JOIN user_timetable ON system_tutorials.moduleid=user_timetable.moduleid LEFT JOIN user_details ON system_tutorials.tutorial_assistant=user_details.userid WHERE user_timetable.userid='$session_userid' AND system_tutorials.tutorial_status='active'");

	while($row = $stmt3->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
	$tutorial_name = $row["tutorial_name"];
	$firstname = $row["firstname"];
    $surname = $row["surname"];
	$tutorial_day = $row["tutorial_day"];

	echo '<tr>

			<td data-title="Name">'.$tutorial_name.'</td>
			<td data-title="Notes">'.$firstname.' '.$surname.'</td>
			<td data-title="Notes">'.$tutorial_day.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../feedback/submit-tutorial-feedback?id='.$tutorialid.'" data-style="slide-up"><span class="ladda-label">Feedback</span></a></td>
			</tr>';
	}

	$stmt3->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lectures</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>From</th>
	<th>Name</th>
    <th>Subject</th>
    <th>Feedback</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT user_details.firstname, user_details.surname, system_lectures.lecture_name, user_feedback.feedbackid,user_feedback.feedback_subject, user_feedback.feedback_body FROM user_feedback_lookup LEFT JOIN user_details ON user_feedback_lookup.feedback_from=user_details.userid LEFT JOIN system_lectures ON user_feedback_lookup.moduleid=system_lectures.moduleid LEFT JOIN user_feedback ON user_feedback_lookup.feedbackid=user_feedback.feedbackid WHERE isApproved = 0 AND isRead = 0");

	while($row = $stmt1->fetch_assoc()) {

    $feedbackid = $row["feedbackid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
	$lecture_name = $row["lecture_name"];
	$feedback_subject = $row["feedback_subject"];
    $feedback_body = $row["feedback_body"];

	echo '<tr id="approve-'.$feedbackid.'">

			<td data-title="From">'.$firstname.' '.$surname.'</td>
			<td data-title="Lecture name">'.$lecture_name.'</td>
			<td data-title="Subject">'.$feedback_subject.'</td>
			<td data-title="Feedback">'.$feedback_body.'</td>
            <td data-title="Action"><a id="approve-'.$feedbackid.'" class="btn btn-primary btn-md ladda-button approve-button" data-style="slide-up"><span class="ladda-label">Approve</span></a></a></td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tutorials</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Tutorial assistant</th>
	<th>Day</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT system_tutorials.tutorial_name, user_details.firstname, user_details.surname, system_tutorials.tutorial_day FROM system_tutorials LEFT JOIN system_modules ON system_tutorials.moduleid=system_modules.moduleid LEFT JOIN user_timetable ON system_tutorials.moduleid=user_timetable.moduleid LEFT JOIN user_details ON system_tutorials.tutorial_assistant=user_details.userid WHERE user_timetable.userid='$session_userid' AND system_tutorials.tutorial_status='active'");

	while($row = $stmt3->fetch_assoc()) {

    $tutorialid = $row["tutorialid"];
	$tutorial_name = $row["tutorial_name"];
	$firstname = $row["firstname"];
    $surname = $row["surname"];
	$tutorial_day = $row["tutorial_day"];

	echo '<tr>

			<td data-title="Name">'.$tutorial_name.'</td>
			<td data-title="Notes">'.$firstname.' '.$surname.'</td>
			<td data-title="Notes">'.$tutorial_day.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../feedback/submit-tutorial-feedback?id='.$tutorialid.'" data-style="slide-up"><span class="ladda-label">Feedback</span></a></td>
			</tr>';
	}

	$stmt3->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Feedback</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lectures</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>From</th>
	<th>Name</th>
    <th>Subject</th>
    <th>Feedback</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT user_details.firstname, user_details.surname, system_lectures.lecture_name, user_feedback.feedback_subject, user_feedback.feedback_body FROM user_feedback_lookup LEFT JOIN user_details ON user_feedback_lookup.feedback_from=user_details.userid LEFT JOIN system_lectures ON user_feedback_lookup.moduleid=system_lectures.moduleid LEFT JOIN user_feedback ON user_feedback_lookup.feedbackid=user_feedback.feedbackid WHERE user_feedback_lookup.isApproved = 1 AND system_lectures.lecture_lecturer='$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

    $firstname = $row["firstname"];
    $surname = $row["surname"];
	$lecture_name = $row["lecture_name"];
    $feedback_subject = $row["feedback_body"];
    $feedback_body = $row["feedback_body"];

	echo '<tr>

			<td data-title="From">'.$firstname.' '.$surname.'</td>
			<td data-title="Lecture name">'.$lecture_name.'</td>
			<td data-title="Subject">'.$feedback_subject.'</td>
			<td data-title="Feedback">'.$feedback_body.'</td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tutorials</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Tutorials -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom tutorial-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Tutorial assistant</th>
	<th>Day</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

    $stmt1 = $mysqli->query("SELECT user_details.firstname, user_details.surname, system_tutorials.tutorial_name, user_feedback.feedback_subject, user_feedback.feedback_body FROM user_feedback_lookup LEFT JOIN user_details ON user_feedback_lookup.feedback_from=user_details.userid LEFT JOIN system_tutorials ON user_feedback_lookup.moduleid=system_tutorials.moduleid LEFT JOIN user_feedback ON user_feedback_lookup.feedbackid=user_feedback.feedbackid WHERE isApproved = 0 AND system_tutorials.tutorial_assistant='$session_userid'");

    while($row = $stmt1->fetch_assoc()) {

        $firstname = $row["firstname"];
        $surname = $row["surname"];
        $tutorial_name = $row["tutorial_name"];
        $feedback_subject = $row["feedback_body"];
        $feedback_body = $row["feedback_body"];

        echo '<tr>

			<td data-title="From">'.$firstname.' '.$surname.'</td>
			<td data-title="Lecture name">'.$tutorial_name.'</td>
			<td data-title="Subject">'.$feedback_subject.'</td>
			<td data-title="Feedback">'.$feedback_body.'</td>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

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
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>

	<script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//DataTables
    $('.lecture-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no lectures to display."
		}
	});

    $('.tutorial-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no tutorials to display."
		}
	});

    $("body").on("click", ".approve-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var feedbackToApprove = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'feedbackToApprove='+ feedbackToApprove,
	success:function(){
		$('#approve-'+feedbackToApprove).hide();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });
	</script>

</body>
</html>
