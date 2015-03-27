<?php
include '../includes/session.php';
include '../includes/functions.php';

GetTransportStatusLastUpdated();

global $transport_status_last_updated;

?>


<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/datatables-css-path.php'; ?>
	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Cycle Hire</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <div class="container">

	<?php include '../includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb breadcrumb-custom">
	<li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Cycle Hire</li>
	</ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<!-- Cycle Hire | Availability updates -->
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Cycle Hire</a>
    <a class="pull-right"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Dock Name</th>
	<th>Installed</th>
	<th>Locked</th>
	<th>Temporary</th>
	<th>Bikes Available</th>
	<th>Empty Docks</th>
	<th>Total Docks</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT dock_name, dock_installed, dock_locked, dock_temporary, dock_bikes_available, dock_empty_docks, dock_total_docks FROM cycle_hire_status_now");

	while($row = $stmt1->fetch_assoc()) {

    $dock_name = $row["dock_name"];
    $dock_installed = $row["dock_installed"];
    $dock_locked = $row["dock_locked"];
    $dock_temporary = $row["dock_temporary"];
    $dock_bikes_available = $row["dock_bikes_available"];
    $dock_empty_docks = $row["dock_empty_docks"];
    $dock_total_docks = $row["dock_total_docks"];

	echo '<tr>

			<td data-title="Dock name">'.$dock_name.'</td>
			<td data-title="Installed">'.($dock_installed === 'true' ? "Yes" : "No").'</td>
			<td data-title="Locked">'.($dock_locked === 'true' ? "Yes" : "No").'</td>
			<td data-title="Temporary">'.($dock_temporary === 'true' ? "Yes" : "No").'</td>
			<td data-title="Bikes available">'.$dock_bikes_available.'</td>
			<td data-title="Empty docks">'.$dock_empty_docks.'</td>
			<td data-title="Total docks">'.$dock_total_docks.'</td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>
	</div><!-- /content-panel -->
	</div>
	<!-- End of Cycle hire | Availability Updates -->

	</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>

	<script>
	$(document).ready(function () {
	$('.table-custom').dataTable({
		"iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false
	});
	});
	</script>

</body>
</html>
