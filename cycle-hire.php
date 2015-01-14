<?php
include 'includes/signin.php';

$url = 'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml';
$result = file_get_contents($url);
$cycle_hire = new SimpleXMLElement($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<!-- pace-js -->
	<script src="../assets/js/pace-js/pace.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Cycle Hire</title>

	<!-- OpenSans -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet">

    <!-- boostrap -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- fontawesome -->
    <link href="../assets/css/font-awesome/font-awesome.min.css" rel="stylesheet">

    <!-- ladda -->
    <link rel="stylesheet" href="../assets/css/ladda/ladda-themeless.min.css">

    <!-- data-tables -->
    <link rel="stylesheet" href="../assets/css/data-tables/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../assets/css/data-tables/dataTables.fontAwesome.css">

    <!-- common -->
    <link href="../assets/css/common/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../assets/js/common/html5shiv.min.js"></script>
    <script src="../assets/js/common/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <div class="container">

	<?php include 'includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
	<li><a href="../../overview/">Overview</a></li>
	<li><a href="../../transport/">Transport</a></li>
	<li class="active">Cycle Hire</li>
	</ol>

	<div class="row">
	<div class="col-lg-12">

	<div class="row">

	<!-- Cycle Hire - Availability updates -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="content-panel mb10">
	<h4><i class="fa fa-angle-right"></i> Cycle Hire | Availability updates</h4>
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
	<!-- End of Tube Live - Line Status -->

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

	<!-- js -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	
	<!-- data-tables js -->
	<script src="../assets/js/data-tables/jquery.dataTables.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="../assets/js/bootstrap/bootstrap.min.js"></script>

	<!-- tile-js -->
	<script src="../../assets/js/tile-js/tileJs.min.js"></script>

	<!-- ladda -->
	<script src="../../assets/js/ladda/ladda.min.js"></script>

    <!-- pace-js -->
	<script src="../../assets/js/pace-js/spin.min.js"></script>

	<!-- custom -->
	<script src="../../assets/js/common/custom.js"></script>
	<script src="../../assets/js/common/ie10-viewport-bug-workaround.js"></script>

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
