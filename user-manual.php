<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | User Manual</title>

    <style>
    #user-manual {
        background-color: #735326;
    }
    #user-manual a {
        color: #FFFFFF;
    }
    #user-manual a:focus, #user-manual a:hover {
        color: #FFFFFF;
    }
    </style>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li class="active">User manual - Student</li>
    </ol>

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a target="_blank" href="user-manual-student.pdf">
    <div class="tile">
    <i class="fa fa-cloud-download"></i>
	<p class="tile-text">User manual</p>
    </div>
    </a>
	</div>

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'academic staff') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li class="active">User manual - Academic staff</li>
    </ol>

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a target="_blank" href="user-manual-academic-staff.pdf">
    <div class="tile">
    <i class="fa fa-cloud-download"></i>
	<p class="tile-text">User manual</p>
    </div>
    </a>
	</div>

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <ol class="breadcrumb breadcrumb-custom">
        <li><a href="../../home/">Home</a></li>
        <li class="active">User manual - Administrator</li>
    </ol>

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a target="_blank" href="user-manual-administrator.pdf">
    <div class="tile">
    <i class="fa fa-cloud-download"></i>
	<p class="tile-text">User manual</p>
    </div>
    </a>
	</div>

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
	</div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>



</body>
</html>
