<?php
include 'includes/session.php';
include 'includes/functions.php';

GetTubeLineLiveStatus();
GetTransportStatusLastUpdated();

global $bakerloo, $bakerloo1, $central, $central1, $circle, $circle1, $district, $district1, $hammersmith, $hammersmith1, $jubilee, $jubilee1, $metropolitan, $metropolitan1, $northern, $northern1, $piccadilly, $piccadilly1, $victoria, $victoria1, $waterloo, $waterloo1, $overground, $overground1, $dlr, $dlr1, $transport_status_last_updated;
global $transport_status_last_updated;

?>

<!DOCTYPE html>
<html lang="en">

<head>

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

<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb breadcrumb-custom">
	<li><a href="../home/">Home</a></li>
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
    <h4><a class="btn-load" href="/transport/tube-now/">Now</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Station status <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-this-weekend/">This weekend</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-this-weekend/">Station status <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="https://www.tfl.gov.uk/cdn/static/cms/documents/standard-tube-map.pdf" target="_blank">Map</a></h4>
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
    <h4><a class="btn-load" href="/transport/cycle-hire/">Now</a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/cycle-hire/">Availability updates <i class="fa fa-angle-right"></i></a></h5>
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
	<h4><a class="btn-load" href="/transport/tube-now/"><?php echo $bakerloo ?></a></h4>
    </div>

    <div class="transport-footer">
	<div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $central ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
	</div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of Central line -->

    <!-- Circle line -->
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel circle">

    <div class="transport-header" style="border-color: #113892; !important">
    <h4 style="color: #113892 !important;"><?php echo $circle1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
    <h4><a class="btn-load" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/"><?php echo $circle ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $circle ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="btn-load long" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $dlr ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="btn-load long" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
    </div>
    </div>

    </div>
    </div>
    <!-- End of DLR -->

    <!-- Hammersmith & City line -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
    <div class="transport-panel hammersmith">

    <div class="transport-header" style="border-color: #113892; !important">
    <h4 style="color: #113892;"><?php echo $hammersmith1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
	<h4><a class="btn-load" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/"><?php echo $hammersmith ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
	<h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
	</div>
    <div class="pull-right">
    <h5><a class="btn-load long" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $jubilee ?></a></h4>
    </div>

    <div class="transport-footer">
	<div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
	<h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $metropolitan ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $northern ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
    </div>

    </div>
    </div>
    <!-- End of Northern line -->

    <!-- Picadilly line -->
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 full-width">
    <div class="transport-panel picadilly">

    <div class="transport-header">
    <h4><?php echo $piccadilly1 ?></h4>
    </div>

    <div class="transport-body">
    <h1><i class="fa fa-subway"></i></h1>
    <h4><a class="btn-load" href="/transport/tube-now/"><?php echo $piccadilly ?></a></h4>
    </div>

    <div class="transport-footer">
    <div class="pull-left">
    <h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
    </div>
    <div class="pull-right">
    <h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
	<h4><a class="btn-load" href="/transport/tube-now/"><?php echo $victoria ?></a></h4>
	</div>

	<div class="transport-footer">
	<div class="pull-left">
	<h5><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
	</div>
	<div class="pull-right">
	<h5><a class="btn-load" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
	</div>
	</div>

	</div>
	</div>
	<!-- End of Victoria line -->

	<!-- Waterloo & City line -->
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 full-width">
	<div class="transport-panel waterloo">

	<div class="transport-header" style="border-color: #113892 !important;">
	<h4 style="color: #113892 !important;"><?php echo $waterloo1 ?></h4>
	</div>

	<div class="transport-body">
    <h1><i class="fa fa-subway" style="color: #113892 !important;"></i></h1>
	<h4><a class="btn-load" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/"><?php echo $waterloo ?></a></h4>
	</div>

	<div class="transport-footer">
	<div class="pull-left">
	<h5 style="color: #113892 !important;"><i class="fa fa-clock-o"></i> <?php echo $transport_status_last_updated ?></h5>
	</div>
	<div class="pull-right">
	<h5><a class="btn-load" style="color: #113892 !important;" data-spinner-color="#113892" href="/transport/tube-now/">Find out more <i class="fa fa-angle-right"></i></a></h5>
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
	
	<?php include 'includes/footers/footer.php'; ?>




	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">
	<form class="form-horizontal form-custom">

	<div class="form-logo text-center">
	<i class="fa fa-graduation-cap"></i>
	</div>

	<hr>
	<p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
	<hr>

	<div class="text-center">
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>

	</form>

	</div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>

	</script>

</body>
</html>
