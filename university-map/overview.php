<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Location overview</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/select2-css-path.php'; ?>

    <script src="https://maps.google.com/maps/api/js"></script>

    <script src="https://student-portal.co.uk/assets/js/university-map/overview.js"></script>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li><a href="../../university-map/">University Map</a></li>
        <li class="active">Home</li>
    </ol>

    <form class="form-horizontal form-custom">

    <div class="marker-toggle">
    <div id="building-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input id=icheckbox" type="checkbox" checked="checked" onclick="toggleGroup('building');"> Buildings
    </label>
    </div>
    <div id="student-centre-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('student_centre');"> Student centre
    </label>
    </div>
    <div id="lecture-theatre-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('lecture_theatre');"> Lecture theatre
    </label>
    </div>
    <div id="computer-lab-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('computer_lab');"> Computer lab
    </label>
    </div>
    <div id="library-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('library');"> Library
    </label>
    </div>
    <div id="cycle-hire-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_hire');"> Cycle hire
    </label>
    </div>
    <div id="cycle-parking-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('cycle_parking');"> Cycle parking
    </label>
    </div>
    <div id="atm-checkbox" class="checkbox-master">
    <label class="checkbox-inline">
        <input type="checkbox" checked="checked" onclick="toggleGroup('atm');"> ATM
    </label>
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
    <?php include '../assets/js-paths/icheck-js-path.php'; ?>

    <script>
    $(document).ready(function() {
        //google-maps
        loadMap();
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    $('#icheckbox').iCheck();

    </script>

</body>
</html>
