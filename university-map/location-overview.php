<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Location overview</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACUYPrcbhUGQsa7KDR9ZtvzDATtGySw68"></script>

    <script src="https://student-portal.co.uk/assets/js/files/location-overview.js"></script>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff')) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li><a href="../../university-map/">University Map</a></li>
        <li class="active">Location overview</li>
    </ol>

    <form class="form-horizontal form-custom" style="max-width: 100%;">

    <div class="marker-toggle">
    <div id="building-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('building');"> Buildings
    </label>
    </div>
    <div id="student-centre-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('student centre');"> Student centre
    </label>
    </div>
    <div id="lecture-theatre-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('lecture theatre');"> Lecture theatre
    </label>
    </div>
    <div id="computer-lab-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('computer lab');"> Computer lab
    </label>
    </div>
    <div id="library-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('library');"> Library
    </label>
    </div>
    <div id="cycle-hire-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle hire');"> Cycle hire
    </label>
    </div>
    <div id="cycle-parking-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle parking');"> Cycle parking
    </label>
    </div>
    <div id="atm-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('atm');"> ATM
    </label>
    </div>
    </div>

    <hr>

    <div id="map"></div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>




    <?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg" href="/">Sign in</a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <script>
    $(document).ready(function() {
        //google-maps
        loadMap();
    });




    </script>

</body>
</html>
