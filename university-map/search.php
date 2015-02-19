<?php
include '../includes/session.php';
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Search</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <?php include '../assets/js-paths/google-maps-js-path.php'; ?>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb">
        <li><a href="../../overview/">Overview</a></li>
        <li><a href="../university-map/">University Map</a></li>
        <li class="active">Search</li>
    </ol>

    <form class="form-custom">

    <p id="error" class="feedback-sad text-center"></p>

    <div id="map-search">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <input class="form-control" type="text" id="addressInput" placeholder="Enter a valid address"/>
    </div>

    <div class="col-xs-2 col-sm-2 full-width">
    <select class="form-control" id="radiusSelect">
    <option value="25" selected>25mi</option>
    <option value="100">100mi</option>
    <option value="200">200mi</option>
    </select>
    </div>
    </div>

    <div id="map-search-button">
    <a class="btn btn-primary btn-lg ladda-button" onclick="searchLocations()" data-style="slide-up"><span class="ladda-label">Search</span></a>
    </div>

    <div><select class="form-control" id="locationSelect" style="width:100%; display: none;"></select></div>

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

    //Loading map
    window.onload = function () {
        loadMap();
    }
    </script>

</body>
</html>
