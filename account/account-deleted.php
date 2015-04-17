<?php
include '../includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Account deleted</title>

</head>

<body>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <div class="preloader"></div>

    <?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>

	<hr>

	<p class="feedback-sad text-center">You haven't deleted your account, and we hope you never will. But if you actually want to, click the button below.</p>

	<hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg" href="../../home/">Home</span></a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg" href="../delete-account/">Delete account</span></a>
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

    <p class="feedback-happy text-center">Your account has been deleted successfully.</p>

    <hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg" href="/">Sign in</span></a>
	</div>

    <div class="text-right">
    <a class="btn btn-success btn-lg" href="/register">Register</span></a>

	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
</body>
</html>



