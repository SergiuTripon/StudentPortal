<?php
include 'includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Exams</title>

    <?php include 'assets/css-paths/datatables-css-path.php'; ?>
    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'admin')) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="exams-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Exams</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Exams</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Exams -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom exam-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Date</th>
    <th>Time</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_exams.exam_name, DATE_FORMAT(system_exams.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(system_exams.exam_time,'%H:%i') as exam_time, system_exams.exam_location, system_exams.exam_capacity FROM user_timetable LEFT JOIN system_exams ON user_timetable.moduleid=system_exams.moduleid WHERE user_timetable.userid = '$session_userid' AND system_exams.exam_status='active'");

	while($row = $stmt1->fetch_assoc()) {

    $exam_name = $row["exam_name"];
    $exam_date = $row["exam_date"];
    $exam_time = $row["exam_time"];
    $exam_location = $row["exam_location"];
    $exam_capacity = $row["exam_capacity"];


	echo '<tr>

			<td data-title="Name">'.$exam_name.'</td>
			<td data-title="Date">'.$exam_date.'</td>
			<td data-title="Time">'.$exam_time.'</td>
			<td data-title="Location">'.$exam_location.'</td>
			<td data-title="Capacity">'.$exam_capacity.'</td>
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
    //DataTables
    $('.exam-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no exams to display."
		}
	});
	</script>

</body>
</html>
