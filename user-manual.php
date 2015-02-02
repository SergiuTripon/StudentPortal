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

    <form class="form-custom" name="signin_form" id="signin_form">

    <div class="logo-custom">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address">

    <label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">

    <div class="text-right">
    <a class="forgot-password" href="forgotten-password/">Forgotten your password?</a>
    </div>

    <hr class="hr-custom">

    <div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="register/"><span class="ladda-label">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Sign In</span></button>
	</div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <?php include 'includes/showcase/showcase.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>

</body>
</html>



    <h1 class="page-header">Account <small>Updating your account</small></h1>
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
    </div>

    <div id="change-password">
    <h1 class="page-header">Account <small>Changing your password</small></h1>
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
    </div>

    <div id="pay-course-fees">
    <h1 class="page-header">Account <small>Paying your course fees</small></h1>
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
    </div>

    <div id="delete-account">
    <h1 class="page-header">Account <small>Deleting your account</small></h1>
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
    </div>

    <div id="create-task">
    <h1 class="page-header">Calendar <small>Creating a task</small></h1>
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
    </div>

    <div id="update-task">
    <h1 class="page-header">Calendar <small>Deleting your account</small></h1>
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
    </div>

    <div id="complete-task">
    <h1 class="page-header">Calendar <small>Completing a task</small></h1>
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
    </div>
