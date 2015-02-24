<?php
include '../includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Account deleted</title>

</head>

<body>

    <div class="preloader"></div>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>

	<hr>

	<p class="feedback-sad text-center">You haven't deleted your account, and we hope you never will.</p>

	<hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="../../overview/"><span class="ladda-label">Overview</span></a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg ladda-button" data-style="slide-up" href="../../sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

	</form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

	<div class="preloader"></div>

    <div class="container">
	
	<form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-trash"></i>
    </div>

    <hr>

    <p class="feedback-happy text-center">Your account has been deleted successfully.</p>

    <hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
	</div>

    <div class="text-right">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/register"><span class="ladda-label">Register</span></a>

	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
	
	<script>
	Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>

</body>
</html>



