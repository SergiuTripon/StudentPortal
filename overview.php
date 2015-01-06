<?php
include 'includes/signin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Pace JS -->
    <script src="../assets/js/pace.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Overview</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda-themeless.min.css">

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

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <div class="container">
    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="row mb10">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="">
    <div class="tile large-tile">
    <i class="fa fa-table"></i>
	<p class="large-tile-text">Timetable</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="">
    <div class="tile">
	<i class="fa fa-pencil"></i>
	<p class="tile-text">Exams</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<a href="">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-bus"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feeback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="tile-text">Account</p>
    </div>
    </a>
	</div>
	
	</div><!-- /row -->
	
	</div> <!-- /container -->

	<?php include 'includes/footers/portal_footer.php'; ?>
	
    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

    <?php else : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

            <div class="container">
    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="row">

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<a href="">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-bus"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feeback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="tile-text">Account</p>
    </div>
    </a>
	</div>
	
	</div><!-- /row -->
    
	</div> <!-- /container -->

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

    <?php else : ?>

	    <div class="container">
    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="">
    <div class="tile large-tile">
    <i class="fa fa-table"></i>
	<p class="large-tile-text">Timetable</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="">
    <div class="tile">
	<i class="fa fa-pencil"></i>
	<p class="tile-text">Exams</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<a href="">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-bus"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feeback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="tile-text">Account</p>
    </div>
    </a>
	</div>
	
	</div><!-- /row -->
    
	</div><!-- /container -->

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

    <?php endif; ?>
    <?php endif; ?>

	<?php else : ?>
	
	<style>
	 html, body {
		height: 100% !important;
	}
	</style>
	
    <header class="intro">
    <div class="intro-body">
    
	<form class="form-custom">

    <div class="custom-logo animated fadeIn delay1">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="custom-hr">

    <p class="sad-feedback text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr class="custom-hr">

    <div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
    
	</div><!-- /intro-body -->
    </header>

	<?php endif; ?>

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- tileJS -->
	<script src="../assets/js/tileJs.min.js"></script>

	<!-- Spin JS -->
	<script src="../assets/js/spin.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda.min.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

	<script>
    // Bind normal buttons
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
