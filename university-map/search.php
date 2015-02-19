<?php
include '../includes/session.php';
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Search</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

</head>
<body onload="load()">

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb">
        <li><a href="../overview/">Overview</a></li>
        <li><a href="../university-map/">University Map</a></li>
        <li class="active">Search</li>
    </ol>

    <form class="form-custom">

    <div id="map-search">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <input class="form-control" type="text" id="addressInput" placeholder="Enter a valid address"/>
    </div>

    <div class="col-xs-2 col-sm-2 full-width pl0">
    <select class="form-control" id="radiusSelect">
    <option value="25" selected>25mi</option>
    <option value="100">100mi</option>
    <option value="200">200mi</option>
    </select>
    </div>
    </div>

    <div id="search-button">
    <input class="btn btn-primary btn-lg" type="button" onclick="searchLocations()" value="Search"/>
    </div>

    <div><select class="form-control" id="locationSelect" style="width:100%; display: none;"></select></div>

    </div>

    <div id="map"></div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

</body>
</html>
