<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | About</title>

	<style>
	html, body {
		height: 100% !important;
	}

    #about {
        color: #333333;
        background: #FFA500;
    }

    /* About */
    #about1 {
        border-top: 1px solid #FFA500;
        border-bottom: 1px solid #FFA500;
    }

    #about1 h1, h2 {
        color: #FFA500;
    }

    /* Footer */
    footer {
        color: #FFA500;
        text-align: center;
    }
    footer .container {
        padding-top: 20px;
        padding-bottom: 10px;
    }
    footer p {
        color: #FFA500;
        text-align: center;
    }
    /* End of Footer */
	</style>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <header class="intro">
    <div class="intro-body">

    <form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>

    <hr class="hr-custom">

	<div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>

    <div class="text-right">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <header class="intro">
    <div class="intro-body">

    <div class="text-center">
    <div class="logo-custom">
    <i class="fa fa-graduation-cap" style="font-size: 150px;"></i>
    </div>
    <a href="#about1" class="btn btn-circle page-scroll">
    <i class="fa fa-angle-double-down animated"></i>
    </a>
    </div>

    </div><!-- /intro-body -->
    </header>

    <!-- About -->
    <header class="intro" id="about1">
    <div class="intro-body">
    <div class="text-center">
    <h1>Student Portal</h1>
	<h2>All your university needs, in one single place.</h2>
    </div>
    </div><!-- /intro-body -->
    </header>

    <!-- Footer -->
    <footer>
    <div class="container">
    <div class="row">
    <p>&copy; 2014 Student Portal - All Rights Reserved.</p>
    </div>
    </div><!-- /.container -->
    </footer><!-- /.footer -->


	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>

	<script>
    $(document).ready(function() {

    // jQuery to collapse the navbar on scroll
    $(window).scroll(function () {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function () {
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function () {
        $('.navbar-toggle:visible').click();
    });

    });
	</script>

</body>
</html>