<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>University Map | Overview</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <script src="https://maps.googleapis.com/maps/api/js"></script>

    <script src="https://student-portal.co.uk/assets/js/google-maps/overview.js"></script>

</head>
<body>
<div class="preloader"></div>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

    <ol class="breadcrumb">
        <li><a href="../../overview/">Overview</a></li>
        <li><a href="../university-map/">University Map</a></li>
        <li class="active">Overview</li>
    </ol>

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
