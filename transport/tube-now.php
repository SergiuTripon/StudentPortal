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

    <title>Student Portal | Tube - Now</title>

	<?php include '../assets/css-paths/datatables-css-path.php'; ?>
	<?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <div class="container">

    <?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Tube - Now</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<!-- Tube | Now | Line status -->
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Line status</a>
    <a class="pull-right"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead class="cf">
	<tr>
	<th>Line</th>
	<th>Status</th>
	<th>Info</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT tube_line, tube_line_status, tube_line_info FROM tube_line_status_now");

	while($row = $stmt1->fetch_assoc()) {

    $tube_line = $row["tube_line"];
    $tube_line_status = $row["tube_line_status"];
    $tube_line_info = $row["tube_line_info"];

	echo '<tr>

			<td data-title="Line">'.$tube_line.'</td>
			<td data-title="Status">'.$tube_line_status.'</td>
			<td data-title="Info">'.(empty($tube_line_info) ? "No extra info" : "$tube_line_info").'</td>
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
	<!-- End of Tube | Now | Line status -->

	<!-- Tube | Now | Station status -->
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Station status</a>
    <a class="pull-right"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-stationstatus">

	<thead>
	<tr>
	<th>Station</th>
	<th>Status</th>
	<th>Info</th>
	</tr>
	</thead>

	<tbody>
    <?php

    $stmt1 = $mysqli->query("SELECT tube_station, tube_station_status, tube_station_info FROM tube_station_status_now");

    while($row = $stmt1->fetch_assoc()) {

        $tube_station = $row["tube_station"];
        $tube_station_status = $row["tube_station_status"];
        $tube_station_info = $row["tube_station_info"];

        echo '<tr>

			<td data-title="Station">'.$tube_station.'</td>
			<td data-title="Status">'.$tube_station_status.'</td>
			<td data-title="Info">'.(empty($tube_station_info) ? "No extra info" : "$tube_station_info").'</td>
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
	<!-- End of Tube | Now | Station status -->

	</div><!-- /panel-group -->

    </div><!-- /container -->
	
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
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign in</span></a>
	</div>

	</form>

	</div>

    <?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>

	<script type="text/javascript" class="init">
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
