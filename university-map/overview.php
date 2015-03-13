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

    <div class="marker-toggle">
    <div id="checkbox-master building-checkbox">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('building')"> Buildings
    </label>
    </div>
    <div id="checkbox-master student-centre-checkbox">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('student_centre')"> Student centre
    </label>
    </div>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('lecture_theatre')"> <span style="color: #FCEF03; font-weight: 600;">Lecture theatre</span>
    </label>
        <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('computer_lab')"> <span style="color: #A340D5; font-weight: 600;">Computer lab</span>
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('library')"> <span style="color: #DA4646; font-weight: 600;">Library</span>
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_hire')"> <span style="color: #95531A; font-weight: 600;">Cycle hire</span>
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_parking')"> <span style="color: #F6A428; font-weight: 600;">Cycle parking</span>
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('atm')"> <span style="color: #EA46B1; font-weight: 600;">ATM</span>
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
