<?php
include '../includes/session.php';
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

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Tube - Now</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<!-- Tube | Now | Line status -->
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Tube | Now | Line status</a>
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
	<?php foreach ($xml_line_status->LineStatus as $name) : ?>
	<tr>
	<td data-title="Line"><?php echo $name->Line->attributes()->Name ?></td>
	<td data-title="Status"><?php echo $name->Status->attributes()->Description ?></td>
	<td class="text-justify" data-title="Info"><?php echo $name->attributes()->StatusDetails ?></td>
	</tr>
	<?php endforeach; ?>
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tube | Now | Station status</a>
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
	<?php foreach ($xml_station_status->StationStatus as $xml_var) : ?>
	<tr>
	<td data-title="Station"><?php echo $xml_var->Station->attributes()->Name ?></td>
	<td data-title="Status"><?php echo $xml_var->Status->attributes()->Description ?></td>
	<td class="text-justify" data-title="Info"><?php echo $xml_var->attributes()->StatusDetails ?></td>
	</tr>
	<?php endforeach; ?>
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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

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
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
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
