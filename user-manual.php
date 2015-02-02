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

    <title>Student Portal | Sign In</title>

	<style>
	html, body {
		height: 100% !important;
	}
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

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>
    <a href="#about" class="btn btn-circle page-scroll">
    <i class="fa fa-angle-double-down animated"></i>
    </a>

    </div><!-- /intro-body -->
    </header>

	<!-- User Manual -->
	<section class="about" id="about">
    <div class="container">
    <div class="row">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Account | Updating your account</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>

    </div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Account | Changing your account's password</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
    <div class="panel-body">

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>

    </div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Account | Paying your course fees</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
    <div class="panel-body">

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas bibendum libero sed nisl aliquet, bibendum dictum enim luctus. Suspendisse consequat fermentum tortor non egestas. Cras sed purus turpis.
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam non massa sit amet elit pretium maximus. Maecenas eu metus aliquam, gravida massa a, posuere odio. Maecenas dictum non odio eu commodo.
    Nunc scelerisque mauris ac ultricies laoreet. Nunc tincidunt consequat commodo. Etiam viverra ullamcorper metus ut porttitor. Vivamus a tortor at elit blandit congue.</p>

    </div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /.row -->
    </div><!-- /.container -->
    </section>
    <!-- End of User Manual -->

    <?php include 'includes/showcase/showcase.php'; ?>


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