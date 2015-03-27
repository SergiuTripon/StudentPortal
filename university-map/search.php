<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Search</title>

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.google.com/maps/api/js"></script>

    <script src="https://student-portal.co.uk/assets/js/university-map/search.js"></script>

    <style>

    </style>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li><a href="/university-map/">University Map</a></li>
        <li class="active">Search</li>
    </ol>

    <form class="form-horizontal form-custom">

    <p id="error" class="feedback-sad text-center"></p>

    <div id="map-search">

    <label for="addressInput">Location<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="addressInput" id="addressInput" placeholder="Enter a location"/>

    <label for="radiusSelect">Radius<span class="field-required">*</span></label>
    <select class="form-control" id="radiusSelect">
        <option></option>
        <option value="25">25mi</option>
        <option value="100">100mi</option>
        <option value="200">200mi</option>
    </select>

    <div id="map-search-button" class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" onclick="searchLocations()" data-style="slide-up"><span class="ladda-label">Search</span></a>
    </div>

    <div id="map-search-results" class="mt10">
    <select class="form-control" id="locationSelect" style="width:100%; display: none;">
        <option></option>
    </select>
    </div>

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

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
    <?php include '../assets/js-paths/select2-js-path.php'; ?>

    <script>
    $(document).ready(function() {
    //google-maps
    loadMap();
    //select2
    $("#radiusSelect").select2({placeholder: "Select an option"});
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});
    </script>

</body>
</html>
