<?php
include '../includes/session.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University map | Overview</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

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

    <div class="checkbox checkbox-success checkbox-inline">
        <input type="checkbox" id="inlineCheckbox1" value="option1" onclick="toggleGroup('building')" checked="checked">
        <label for="inlineCheckbox1"> Building </label>
    </div>

    <div class="checkbox checkbox-danger checkbox-inline">
        <input type="checkbox" id="inlineCheckbox2" value="option2" onclick="toggleGroup('student_centre')" checked="checked">
        <label for="inlineCheckbox2"> Student centre </label>
    </div>

    <div class="checkbox checkbox-warning checkbox-inline">
        <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="toggleGroup('lecture_theatre')" checked="checked">
        <label for="inlineCheckbox3"> Lecture theatre </label>
    </div>

    <div class="checkbox checkbox-info checkbox-inline">
        <input type="checkbox" id="inlineCheckbox4" value="option4" onclick="toggleGroup('computer_lab')" checked="checked">
        <label for="inlineCheckbox4"> Computer lab </label>
    </div>

    <div class="checkbox checkbox-success checkbox-inline">
        <input type="checkbox" id="inlineCheckbox5" value="option5" onclick="toggleGroup('library')" checked="checked">
        <label for="inlineCheckbox5"> Library </label>
    </div>

    <div class="checkbox checkbox-primary checkbox-inline">
        <input type="checkbox" id="inlineCheckbox6" value="option6" onclick="toggleGroup('cycle_hire')" checked="checked">
        <label for="inlineCheckbox6"> Cycle hire </label>
    </div>

    <div class="checkbox checkbox-primary checkbox-inline">
        <input type="checkbox" id="inlineCheckbox7" value="option7" onclick="toggleGroup('cycle_parking')" checked="checked">
        <label for="inlineCheckbox7"> Cycle parking </label>
    </div>

    <div class="checkbox checkbox-default checkbox-inline">
        <input type="checkbox" id="inlineCheckbox8" value="option8" onclick="toggleGroup('atm')" checked="checked">
        <label for="inlineCheckbox8"> ATM </label>
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
