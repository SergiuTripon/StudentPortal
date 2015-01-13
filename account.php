<?php
include 'includes/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Account</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda/ladda-themeless.min.css">

    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="../assets/css/datetimepicker/jquery-ui-1.10.0.custom.css">
    <link rel="stylesheet" href="../assets/css/datetimepicker/jquery-ui-timepicker-addon.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/common/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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

    <?php else : ?>
	
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
	
	<?php else : ?>
	
	<div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>
			
	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Account</li>
    </ol>
			
    <div class="row">

	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">

    <a href="/create-single-account/">
    <div class="tile">
    <i class="fa fa-user"></i>
	<p class="large-tile-text">Create a single account</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="/create-multiple-accounts/">
    <div class="tile">
    <i class="fa fa-users"></i>
	<p class="tile-text">Create multiple accounts</p>
    </div>
    </a>
	</div>
				
	<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<a href="/update-an-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update an account</p>
    </div>
	</a>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
	<a href="/change-account-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change an account's password</p>
	</div>
    </a>
	</div>
	
    <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
	<a href="/delete-an-account/">
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

    <div class="logo-custom animated fadeIn delay1">
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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- tileJS -->
	<script src="../assets/js/tilejs/tileJs.min.js"></script>

	<!-- Spin JS -->
	<script src="../assets/js/pacejs/spin.min.js"></script>
    <script src="../assets/js/pacejs/pace.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda/ladda.min.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/common/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
