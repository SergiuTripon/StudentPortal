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

    <div id="marker-toggle">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('building')"> <span style="color: #6991FD; font-weight: 600;">Buildings</span>
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('student_centre')"> Student centre
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('lecture_theatre')"> Lecture theatre
    </label>
        <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('computer_lab')"> Computer lab
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('library')"> Library
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_hire')"> Cycle hire
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_parking')"> Cycle parking
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('atm')"> ATM
    </label>
    </div>

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
