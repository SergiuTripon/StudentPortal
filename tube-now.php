<?php
include 'includes/signin.php';

$url1 = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
$result1 = file_get_contents($url1);
$xml_line_status = new SimpleXMLElement($result1);

$url2 = 'http://cloud.tfl.gov.uk/TrackerNet/StationStatus';
$result2 = file_get_contents($url2);
$xml_station_status = new SimpleXMLElement($result2);
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Tube - Now</title>

	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/datatables-css-path.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Tube - Now</li>
    </ol>

    <div class="row">
    <div class="col-lg-12">

	<div class="row">

	<!-- Tube now - Line status -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full-width">
	<div class="content-panel mb10">
	<h4><i class="fa fa-angle-right"></i> Line status | Now</h4>
	<section id="no-more-tables">
	<table class="table table-condensed table-transport">

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
	</div><!-- /content-panel -->
	</div>
	<!-- End of Tube now - Line status -->

	<!-- Tube now - Station status -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full-width">
	<div class="content-panel mb10">
	<h4><i class="fa fa-angle-right"></i> Station status | Now</h4>
	<section id="no-more-tables">
	<table class="table table-condensed table-transport">

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
	</div><!-- /content-panel -->
	</div>
	<!-- End of Tube Live - Status Status -->

	</div><!-- /row -->

	</div>
	</div>

    </div><!-- /container -->
	
	<?php include 'includes/footers/portal_footer.php'; ?>

   <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

    <style>
    html, body {
		height: 100% !important;
	}
    </style>
	
    <header class="intro">
	<div class="intro-body">
	<form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
	<i class="fa fa-graduation-cap"></i>
	</div>

	<hr class="mt10 hr-custom">

	<p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

	<hr class="hr-custom">

	<div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
	</div>

	</form>
	</div>
    </header>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script type="text/javascript" class="init">
	$(document).ready(function () {
	$('.table-transport').dataTable({
		"iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false
	});
	});
	</script>

</body>
</html>
