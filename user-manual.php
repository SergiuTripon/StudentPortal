    <?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | User Manual</title>

    <style>
    #user-manual a {
        color: #FFFFFF;
        background-color: #C9302C;
    }
    #user-manual a:focus, #user-manual a:hover {
        color: #FFFFFF !important;
        background-color: #C9302C !important;
    }
    #find-out-more a {
        color: #FFFFFF;
        background-color: #C9302C;
    }
    </style>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <header><!-- Header -->
    <div class="wrapper"><!-- Wrapper -->

    <form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>

    <hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg ladda-button" data-style="slide-up" href="sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

    </form>

    </div><!-- End of Wrapper -->
    </header><!-- End of Header -->

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <h1 class="text-center">User manual</h1>
    <hr class="hr-small">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div id="user-manual-panel" class="panel panel-default">
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
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Account | Changing your password</a>
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
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Account | Changing your password</a>
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

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>

</body>
</html>