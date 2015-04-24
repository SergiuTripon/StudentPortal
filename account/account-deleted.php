<?php
include '../includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Account deleted</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

    <div class="preloader"></div>

    <?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>

	<hr>

	<p class="feedback-danger text-center">You haven't deleted your account, and we hope you never will. But if you actually want to, click the button below.</p>

	<hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg btn-load" href="../../home/">Home</a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg btn-load" href="../delete-account/">Delete account</a>
    </div>

	</form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

	<div class="preloader"></div>

    <div class="container">
	
	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-trash"></i>
    </div>

    <hr>

    <p class="feedback-success text-center">All done! Your account has been deleted.</p>

    <hr>

	<div class="pull-left">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
	</div>

    <div class="text-right">
    <a class="btn btn-primary btn-lg btn-load" href="/register">Register</a>

	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
</body>
</html>



