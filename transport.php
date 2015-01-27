<?php
include'includes/signin.php';
include 'includes/tube/tube_brief.php';

date_default_timezone_set('Europe/London');
$time = date('H:i');
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

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Transport</title>

</head>

<body>
<div class="preloader"></div>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
	<li><a href="../overview/">Overview</a></li>
    <li class="active">Transport</li>
    </ol>

    <div class="row">
    <div class="col-lg-12">

    <!-- 1st row -->
    <div class="row">

	<!-- Tube now -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 full-width">
    <div class="transport-panel">

    <div class="transport-header">
    <h4>Tube</h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="/account/tube-now/">Now</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../../tube-now/">Station status <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Tube now -->

    <!-- Tube this weekend -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 full-width">
    <div class="transport-panel">

    <div class="transport-header">
    <h4>Tube</h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-this-weekend/">This weekend</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-this-weekend/">Station status <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Tube this weekend -->

    <!-- Tube map -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 full-width">
    <div class="transport-panel">

    <div class="transport-header">
	<h4>Tube</h4>
    </div>

    <div class="transport-body">
	<h1><i class="fa fa-map-marker"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="https://www.tfl.gov.uk/cdn/static/cms/documents/standard-tube-map.pdf" target="_blank">Map</a></h4>
    </div>

    </div>
    </div>
    <!-- End of Tube map -->

	<!-- Cycle hire -->
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 full-width">
    <div class="transport-panel">
    <div class="transport-header">
	<h4>Cycle Hire</h4>
	</div>

    <div class="transport-body">
    <h1><i class="fa fa-bicycle"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../cycle-hire/">Now</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../cycle-hire/">Availability updates <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

	</div>
    </div>
	<!-- End of Cycle hire -->

    </div>
    <!--/End of 1st row -->

    <!-- 2nd row -->
    <div class="row">

    <!-- Bakerloo line -->
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel bakerloo">

    <div class="transport-header">
    <h4><?php echo $bakerloo1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
	<h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $bakerloo ?></a></h4>
    </div>

    <div class="transport-footer">
	<div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
	</div>

    </div>
    </div>
    <!-- End of Bakerloo line -->

    <!-- Central line -->
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel central">

    <div class="transport-header">
    <h4><?php echo $central1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $central ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
	</div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Central line -->

    <!-- Circle line -->
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel circle">

    <div class="transport-header">
    <h4 style="color: #FFFFFF;"><?php echo $circle1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
    <h4><a class="ladda-button" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/"><?php echo $circle ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

	</div>
    </div>
    <!-- End of Circle line -->

    </div>
    <!--/End of 2nd row -->

    <!-- 3rd row -->
    <div class="row">

    <!-- District line -->
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
    <div class="transport-panel district">

    <div class="transport-header">
    <h4><?php echo $district1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $circle ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="ladda-button long" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of District line -->

    <!-- DLR -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
    <div class="transport-panel dlr">

    <div class="transport-header">
    <h4><?php echo $dlr1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $dlr ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="ladda-button long" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of DLR -->

    <!-- Hammersmith & City line -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
    <div class="transport-panel hammersmith">

    <div class="transport-header">
    <h4 style="color: #FFFFFF;"><?php echo $hammersmith1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
	<h4><a class="ladda-button" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/"><?php echo $hammersmith ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
	</div>
    <div class="pull-right">
    <h5><a class="ladda-button long" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

	</div>
    </div>
    <!-- End of Hammersmith & City line -->

    <!-- Jubilee line -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
    <div class="transport-panel jubilee">

    <div class="transport-header">
    <h4><?php echo $jubilee1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $jubilee ?></a></h4>
    </div>

    <div class="transport-footer">
	<div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
	</div>
    <!-- End of Jubilee line -->

    </div>
    <!--/End of 3rd row -->

    <!-- 4th row -->
    <div class="row">

    <!-- Metropolitan line -->
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel metropolitan">

    <div class="transport-header">
    <h4><?php echo $metropolitan1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $metropolitan ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Metropolitan line -->

    <!-- Northern line -->
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel northern">

    <div class="transport-header">
    <h4><?php echo $northern1 ?></h4>
                            </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $northern ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
    </div>

    </div>
    </div>
    <!-- End of Northern line -->

    <!-- Picadilly line -->
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel picadilly">

    <div class="transport-header">
    <h4><?php echo $picadilly1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $picadilly ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Picadilly line -->

	</div>
    <!-- End of 4th row -->

	<!-- 5th row -->
	<div class="row">

	<!-- Victoria line -->
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
	<div class="transport-panel victoria">

	<div class="transport-header">
	<h4><?php echo $victoria1 ?></h4>
	</div>

	<div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
	<h4><a class="ladda-button" data-style="slide-down" href="../tube-now/"><?php echo $victoria ?></a></h4>
	</div>

	<div class="transport-footer">
	<div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
	</div>
	<div class="pull-right">
	<h5><a class="ladda-button" data-style="slide-down" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
	</div>

	</div>
	</div>
	<!-- End of Victoria line -->

	<!-- Waterloo & City line -->
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
	<div class="transport-panel waterloo">

	<div class="transport-header">
	<h4 style="color: #FFFFFF !important;"><?php echo $waterloo1 ?></h4>
	</div>

	<div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
	<h4><a class="ladda-button" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/"><?php echo $waterloo ?></a></h4>
	</div>

	<div class="transport-footer">
	<div class="pull-left">
	<h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $time ?></h5>
	</div>
	<div class="pull-right">
	<h5><a class="ladda-button" style="color: #113892 !important;" data-style="slide-down" data-spinner-color="#113892" href="../tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
	</div>
    
	</div>
	</div>
	<!-- End of Waterloo & City line -->

	</div>
	<!-- End of 5th row -->
	
	</div><!-- /col-lg-12 -->
	</div><!-- /row -->

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

	<script>
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
