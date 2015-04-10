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

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <h1 class="text-center">User manual</h1>
    <hr class="hr-small">

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

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


    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="user-manual-showcase" class="container"><!-- container -->

    <h1 class="text-center">User manual</h1>
    <hr class="hr-small">

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

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


</body>
</html>
