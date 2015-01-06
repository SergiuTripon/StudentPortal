<?php
include 'includes/signin.php';

$url = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
$result = file_get_contents($url);
$xml_weekend = new SimpleXMLElement($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon/favicon.ico">

    <title>Student Portal | Tube - This Weekend</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda-themeless.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
	<table class="table table-condensed line-status-table">

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
	<table class="table table-condensed station-status-table">

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
    <script src="../assets/js/sign-out-inactive.js"></script>

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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	
	<!-- dataTables JS -->
	<script src="http://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" class="init">
    $(document).ready(function () {
	$('.line-status-table').dataTable({
		"iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false
	});
    $('.station-status-table').dataTable({
		"iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false
	});
    });
	</script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- tileJS -->
	<script src="../assets/js/tileJs.min.js"></script>

	<!-- Spin JS -->
	<script src="../assets/js/spin.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda.min.js"></script>
	
	<!-- Pace JS -->
    <script src="../../assets/js/pace.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
