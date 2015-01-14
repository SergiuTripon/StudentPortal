<?php
include 'includes/signin.php';

$url = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
$result = file_get_contents($url);
$xml_weekend = new SimpleXMLElement($result);
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

	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/datatables-css-path.php'; ?>

    <title>Student Portal | Tube - This Weekend</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
	<li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Tube - This Weekend</li>
	</ol>

	<div class="row">
	<div class="col-lg-12">

	<div class="row">

	<!-- Tube weekend - Line status -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full-width">
	<div class="content-panel mb10">
	<h4><i class="fa fa-angle-right"></i> Line Status | This Weekend</h4>
	<section id="no-more-tables">
	<table class="table table-condensed table-transport">

	<thead>
	<tr>
	<th>Line</th>
	<th>Status</th>
	<th>Info</th>
	</tr>
	</thead>

	<tbody>
	<?php foreach ($xml_weekend->Lines->Line as $xml_var) : ?>
	<tr>
	<td data-title="Line"><?php echo $xml_var->Name ?></td>
	<td data-title="Status"><?php echo $xml_var->Status->Text ?></td>
	<td class="text-justify" data-title="Info"><?php echo $xml_var->Status->Message->Text ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>

	</table>
	</section>
	</div><!-- /content-panel -->
	</div>
	<!-- End of Tube Live - Line Status -->

	<!-- Tube weekend - Station status -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full-width">
	<div class="content-panel mb10">
	<h4><i class="fa fa-angle-right"></i> Station Status | This Weekend</h4>
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
	<?php foreach ($xml_weekend->Stations->Station as $xml_var) : ?>
	<tr>
	<td data-title="Station"><?php echo $xml_var->Name ?></td>
	<td data-title="Status"><?php echo $xml_var->Status->Text ?></td>
	<td class="text-justify" data-title="Info"><?php echo $xml_var->Status->Message->Text ?></td>
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

    </div> <!-- /container -->
	
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
