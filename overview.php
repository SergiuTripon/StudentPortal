<?php
include 'includes/session.php';
include 'includes/functions.php';

    GetDashboardData();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Overview</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../timetable/">
    <div class="tile large-tile">
    <i class="fa fa-table"></i>
	<p class="large-tile-text">Timetable<span class="badge"><?php echo ($timetable_count == '0' ? "" : "$timetable_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../exams/">
    <div class="tile">
	<i class="fa fa-pencil"></i>
	<p class="tile-text">Exams<span class="badge"><?php echo ($exams_count == '0' ? "" : "$exams_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<a href="../library/">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library<span class="badge"><?php echo ($library_count == '0' ? "" : "$library_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-subway"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar<span class="badge"><?php echo ($calendar_count == '0' ? "" : "$calendar_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../events/">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events<span class="badge"><?php echo ($events_count == '0' ? "" : "$events_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../university-map/">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../feedback/">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feedback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../messenger/">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger<span class="badge"><?php echo ($messenger_count == '0' ? "" : "$messenger_count"); ?></span></p>
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

	<?php include 'includes/footers/footer.php'; ?>
	
    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../library/">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library<span class="badge"><?php echo ($library_count == '0' ? "" : "$library_count"); ?></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-subway"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar<span class="badge"><?php echo ($calendar_count == '0' ? "" : "$calendar_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../events/">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events<span class="badge"><?php echo ($events_count == '0' ? "" : "$events_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="university-map">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../feedback/">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feedback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../messenger/">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger<span class="badge"><?php echo ($messenger_count == '0' ? "" : "$messenger_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="tile-text">Account</p>
    </div>
    </a>
	</div>
	
	</div><!-- /row -->
    
	</div> <!-- /container -->

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="overview-portal" class="container">

    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../timetable/">
    <div class="tile large-tile">
    <i class="fa fa-table"></i>
	<p class="large-tile-text">Timetable</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../exams/">
    <div class="tile">
	<i class="fa fa-pencil"></i>
	<p class="tile-text">Exams</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<a href="../library/">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p class="tile-text">Library</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../transport/">
    <div class="tile">
    <i class="fa fa-subway"></i>
	<p class="tile-text">Transport</p>
    </div>
    </a>
	</div>
	
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../calendar/">
	<div class="tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Calendar<span class="badge"><?php echo ($calendar_count == '0' ? "" : "$calendar_count"); ?></span></p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="../events/">
    <div class="tile">
	<i class="fa fa-beer"></i>
	<p class="tile-text">Events</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../university-map/">
    <div class="tile">
    <i class="fa fa-map-marker"></i>
	<p class="tile-text">University Map</p>
    </div>
	<a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<a href="../feedback/">
    <div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p class="tile-text">Feedback</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="../messenger/">
    <div class="tile">
    <i class="fa fa-comments"></i>
	<p class="tile-text">Messenger<span class="badge"><?php echo ($messenger_count == '0' ? "" : "$messenger_count"); ?></span></p>
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

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>
	
    <div class="container">
    
	<form class="form-custom text-center">

    <div class="form-logo">
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

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
