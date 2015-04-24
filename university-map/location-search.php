<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Location search</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACUYPrcbhUGQsa7KDR9ZtvzDATtGySw68"></script>

    <script src="https://student-portal.co.uk/assets/js/files/location-search.js"></script>

    <style>

    </style>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff')) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li><a href="/university-map/">University Map</a></li>
        <li class="active">Location search</li>
    </ol>

    <form class="form-horizontal form-custom" style="max-width: 100%;">

    <p id="error" class="feedback-danger text-center"></p>

    <div id="map-search">

    <label for="addressInput">Location<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="addressInput" id="addressInput" placeholder="Enter a location"/>

    <label for="radiusSelect">Radius<span class="field-required">*</span></label>
    <select class="form-control" id="radiusSelect" style="width: 100%">
        <option></option>
        <option value="25">25mi</option>
        <option value="100">100mi</option>
        <option value="200">200mi</option>
    </select>

    <div id="map-search-button" class="text-center">
    <a id="location-search-submit" class="btn btn-primary btn-lg btn-load">Search</a>
    </div>

    <div id="map-search-results">
    <select class="form-control" id="locationSelect" style="width:100%; display: none;">
        <option></option>
    </select>
    </div>

    </div>

    <hr>

    <div id="map"></div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <script>
    $(document).ready(function() {
        //google-maps
        loadMap();
        //select2
        $("#radiusSelect").select2({placeholder: "Select an option"});
    });

    </script>

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

</body>
</html>
