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

    #contact {
        color: #333333;
        background: #FFA500;
    }

	/* Contact section */
	.contact {
		color: #FFA500;
		padding: 100px 0;
		border-top: 1px solid #FFA500;
	}
	.contact h1 {
		margin-top: 0px;
		margin-bottom: 0px;
	}
	textarea[name=message] {
		resize: none;
	}
	/* End of Contact section */

	/* Social section */
	.social {
		color: #FFA500;
		padding: 100px 0;
		text-align: center;
		border-top: 1px solid #FFA500;
		border-bottom: 1px solid #FFA500;
	}
	.social h1 {
		margin-top: 0px;
		margin-bottom: 0px;
	}
	.social-buttons {
		margin-top: 30px;
	}
	.social-buttons i {
		color: #FFA500;
		font-size: 80px;
	}
	/* End of Social section */

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
    <a href="#contact1" class="btn btn-circle page-scroll">
    <i class="fa fa-angle-double-down animated"></i>
    </a>
    </div>

    </div><!-- /intro-body -->
    </header>

    <!-- Contact -->
    <section class="contact" id="contact1">
    <div class="container">
	<div class="row text-center">
	<h1>Contact Us</h1>
	<hr class="hr-custom hr-small">
	</div>
    <div class="row text-center">
    <div class="col-lg-12">

	<form class="form-custom" style="max-width: 700px;">

	<div class="form-group">
	<div class="col-sm-4 full-width">
	<input class="form-control" type="firstname" name="firstname" id="firstname" placeholder="First name">
    </div>
	</div>

	<div class="form-group">
	<div class="col-sm-4 full-width">
    <input class="form-control" type="surname" name="surname" id="surname" placeholder="Surname">
	</div>
	</div>

	<div class="form-group">
	<div class="col-sm-4 full-width">
    <input class="form-control" type="email" name="email" id="email" placeholder="E-mail address">
	</div>
	</div>

	<div class="form-group">
	<div class="col-sm-12 full-width">
	<textarea class="form-control" rows="5" name="message" id="message" placeholder="Message"></textarea>
	</div>
	</div>

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button mt20" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Contact us</span></a>
    </div>

    </form>

	</div>
	</div>
    <!-- /.row -->
    </div>
	<!-- /.container -->
    </section>

	<!-- Social -->
	<div class="social" id="social">
    <div class="container">
	<div class="row">
	<h1>Connect with us</h1>
	<hr class="hr-custom hr-small">
	</div>
    <div class="row">
    <div class="social-buttons">
    <a href="https://facebook.com/triponsergiu" target="_blank"><i class="fa fa-facebook-square mr10"></i></a>
    <a href="https://twitter.com/SergiuTripon" target="_blank"><i class="fa fa-twitter-square mr10"></i></a>
    <a href="https://www.linkedin.com/in/triponsergiu"><i class="fa fa-linkedin-square" target="_blank"></i></a>
	</div>
    </div>
	</div><!-- /.container -->
	</div><!-- /.Social -->

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