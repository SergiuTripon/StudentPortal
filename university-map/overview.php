<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Overview</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/awesome-bootstrap-checkbox-css-path.php'; ?>

    <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <script src="https://student-portal.co.uk/assets/js/university-map/overview.js"></script>

</head>
<body onload="toggleGroup('cycle_hire')">
<div class="preloader"></div>

    <?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../overview/">Overview</a></li>
        <li><a href="../../university-map/">University Map</a></li>
        <li class="active">Overview</li>
    </ol>

    <form class="form-custom">

    <div class="row">

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" onclick="toggleGroup('building')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Building</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2" onclick="toggleGroup('student_centre')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Student centre</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2" onclick="toggleGroup('lecture_theatre')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Lecture theatre</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2" onclick="toggleGroup('computer_lab')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Computer lab</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" onclick="toggleGroup('library')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Library</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2" onclick="toggleGroup('cycle_hire')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Cycle hire</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2" onclick="toggleGroup('cycle_parking')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>Cycle parking</p>
    </div>
	</div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" onclick="toggleGroup('atm')">
    <div class="tile small-tile">
    <i class="fa fa-clock-o"></i>
	<p>ATM</p>
    </div>
	</div>

	</div><!-- /row -->

    <div id="map"></div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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

    <script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    </script>

</body>
</html>
