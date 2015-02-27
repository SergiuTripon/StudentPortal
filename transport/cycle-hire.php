<?php
include '../includes/session.php';
include '../includes/functions.php';

GetCycleHireStatus();

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

	<ol class="breadcrumb">
	<li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Cycle Hire</li>
	</ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<!-- Cycle Hire | Availability updates -->
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Cycle Hire | Availability updates</a>
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
	<?php foreach ($cycle_hire->station as $xml_var) : ?>
	<tr>
	<td data-title="Dock Name"><?php echo $xml_var->name ?></td>
	<td class="text-center" data-title="Installed"><?php echo $xml_var->installed ?></td>
	<td class="text-center" data-title="Locked"><?php echo $xml_var->locked ?></td>
	<td class="text-center" data-title="Temporary"><?php echo $xml_var->temporary ?></td>
	<td class="text-center" data-title="Bikes Available"><?php echo $xml_var->nbBikes ?></td>
	<td class="text-center" data-title="Empty Docks"><?php echo $xml_var->nbEmptyDocks ?></td>
	<td class="text-center" data-title="Total Docks"><?php echo $xml_var->nbDocks ?></td>
	</tr>
	<?php endforeach; ?>
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
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
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
