<?php
include'includes/signin.php';
include 'includes/tube/tube_brief.php';

date_default_timezone_set('Europe/London');
$time = date('G:i');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Pace JS -->
    <script src="../assets/js/pacejs/pace.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Transport</title>

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
    <link rel="stylesheet" href="../assets/css/ladda/ladda-themeless.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/common/custom.css" rel="stylesheet">

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
	<li><a href="../overview/">Overview</a></li>
    <li class="active">Transport</li>
    </ol>

    <div class="row">
    <div class="col-lg-12">

    <!-- 1st row -->
    <div class="row">

	<!-- Tube now -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 full-width">
    <div class="transport-panel animated fadeIn delay1">

    <div class="transport-header">
    <h4>Tube</h4>
    </div>

    <div class="transport-body">
	<div class="img-responsive">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
	</div>
    <h4><a class="ladda-button" data-style="slide-down" href="../tube-now/">Now</a></h4>
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
    <div class="transport-panel animated fadeIn delay1">

    <div class="transport-header">
    <h4>Tube</h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel animated fadeIn delay1">

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
    <div class="transport-panel animated fadeIn delay1">
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
    <div class="transport-panel bakerloo animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $bakerloo1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
	</div>
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
    <div class="transport-panel central animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $central1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel circle animated fadeIn delay1">

    <div class="transport-header">
    <h4 style="color: #FFFFFF;"><?php echo $circle1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground-blue.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel district animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $district1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel dlr animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $dlr1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel hammersmith animated fadeIn delay1">

    <div class="transport-header">
    <h4 style="color: #FFFFFF;"><?php echo $hammersmith1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground-blue.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel jubilee animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $jubilee1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel metropolitan animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $metropolitan1 ?></h4>
    </div>

    <div class="transport-body">
	<div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel northern animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $northern1 ?></h4>
                            </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
    <div class="transport-panel picadilly animated fadeIn delay1">

    <div class="transport-header">
    <h4><?php echo $picadilly1 ?></h4>
    </div>

    <div class="transport-body">
    <div class="img-responsive tfl-logo">
    <img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
    </div>
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
	<div class="transport-panel victoria animated fadeIn delay1">

	<div class="transport-header">
	<h4><?php echo $victoria1 ?></h4>
	</div>

	<div class="transport-body">
	<div class="img-responsive tfl-logo">
	<img src="../assets/img/logo/other/underground.png" width="115px" height="92px"/>
	</div>
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
	<div class="transport-panel waterloo animated fadeIn delay1">

	<div class="transport-header">
	<h4 style="color: #FFFFFF !important;"><?php echo $waterloo1 ?></h4>
	</div>

	<div class="transport-body">
	<div class="img-responsive tfl-logo">
	<img src="../assets/img/logo/other/underground-blue.png" width="115px" height="92px"/>
	</div>
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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Pace JS -->
	<script src="../assets/js/pacejs/spin.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda/ladda.min.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/common/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

	<script>
    // Bind normal buttons
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
