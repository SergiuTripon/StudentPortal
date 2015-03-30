<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>
    <?php include 'assets/css-paths/ekko-lightbox-css-path.php'; ?>

    <title>Student Portal | Usability testing</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

     <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="usability-testing-showcase" class="container">

    <h1 class="text-center">Features</h1>
    <hr class="hr-small">

	<p class="text-left">Click and discover</p>

    <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="timetable">
	<div class="tile large-tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="exams">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div id="library">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="transport">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="calendar1">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="events">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="university-map">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="feedback">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="messenger">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div id="account">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
	</div>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="usability-testing-showcase" class="container">

    <h1 class="text-center">Usability testing</h1>
    <hr class="hr-small">

	<p class="text-left">Click to watch the videos</p>

    <div class="row">
    <a href="https://www.youtube.com/watch?v=IAkrF44858k" data-toggle="lightbox">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div class="tile large-tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
	</div>
	</div>
    </a>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="exams">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div id="library">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="transport">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="calendar1">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="events">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="university-map">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="feedback">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="messenger">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div id="account">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
	</div>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/ekko-lightbox-js-path.php'; ?>

    <script>
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
    </script>

</body>
</html>
