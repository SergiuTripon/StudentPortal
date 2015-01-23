<?php
include 'includes/signin.php';
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

    <title>Student Portal | Overview</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

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

    <div class="logo-custom animated fadeIn delay1">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
    
	</div><!-- /intro-body -->
    </header>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
