<?php
include 'includes/signin.php';
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

    <title>Student Portal | Account</title>

</head>

<body>
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>
	
	<div class="container">
    <?php include 'includes/menus/portal_menu.php'; ?>
			
	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
    <a href="/update-account/">
    <div class="tile">
    <i class="fa fa-pencil"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a href="/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change Password</p>
    </div>
    </a>
	</div>
				
	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a href="/pay-course-fees/">
    <div class="tile">
    <i class="fa fa-gbp"></i>
	<p class="tile-text">Pay course fees</p>
    </div>
	</a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
	<a href="/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->
	
    </div><!-- /container -->
	
	<?php include 'includes/footers/portal_footer.php'; ?>
		
	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	
	<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>
	
	<div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>
			
	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">

    <a href="/update-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change Password</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a href="/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
	</div>
    </a>
	</div>            

    </div><!-- /row -->
    </div><!-- /container -->
	
	<?php include 'includes/footers/portal_footer.php'; ?>
		
	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>
	
	<div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>
			
	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <a href="/update-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change password</p>
	</div>
    </a>
	</div>

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->

    <h3>Perform actions against other accounts</h4>
    <hr class="hr-custom">

    <div class="row">

	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
    <a href="/admin/create-single-account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="tile-text">Create a single account</p>
    </div>
    </a>
	</div>

    <!--<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
    <a href="/create-multiple-accounts/">
    <div class="tile">
    <i class="fa fa-users"></i>
    <p class="tile-text">Create multiple accounts</p>
    </div>
    </a>
    </div>-->
				
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	<a href="/admin/update-an-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update an account</p>
    </div>
	</a>
	</div>
	
	<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<a href="/admin/change-account-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change an account's password</p>
	</div>
    </a>
	</div>
	
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<a href="/admin/delete-an-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete an account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->
    </div><!-- /container -->
	
	<?php include 'includes/footers/portal_footer.php'; ?>
		
	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	
	<?php else : ?>
	
	<style>
    html, body {
		height: 100% !important;
	}
	</style>

    <header class="intro">
    <div class="intro-body">
    
	<form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
     
	</div><!-- /intro-body -->
    </header>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

</body>
</html>
