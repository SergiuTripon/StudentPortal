<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | About</title>

    <style>
    #about {
        background-color: #735326;
    }
    #about a {
        color: #FFFFFF;
    }
    #about a:focus, #about a:hover {
        color: #FFFFFF;
    }
    </style>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <!-- About -->
    <div class="container text-center"><!-- container -->
    <div class="logo-custom">
    <i class="fa fa-comment-o" style="font-size: 150px;"></i>
    </div>
    <h1>Student Portal</h1>
	<h2>All your university needs, in one single place.</h2>
    </div><!-- ./container -->
    <!-- End of About -->

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <!-- About -->
    <div class="container text-center"><!-- container -->
    <div class="logo-custom">
    <i class="fa fa-comment-o" style="font-size: 150px;"></i>
    </div>
    <h1>Student Portal</h1>
	<h2>All your university needs, in one single place.</h2>
    </div><!-- ./container -->
    <!-- End of About -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>

</body>
</html>
