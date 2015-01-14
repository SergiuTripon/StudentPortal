<?php
include_once 'signin.php';
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

    <title>Student Portal | Payment Cancelled</title>



</head>

	<style>
    html, body {
		height: 100% !important;
	}
    </style>

<body>
	<div class="preloader"></div>
	
	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
	<!-- Header -->
    <header class="intro">
    <div class="intro-body">
    
	<form class="form-custom" name="paypal_success_form">
    
    <div class="logo-custom animated fadeIn delay">
    <i class="fa fa-paypal"></i>
    </div>
    
    <hr class="mt10 hr-custom">
	
    <p class="feedback-sad text-center">Payment cancelled successfully.</p>
    
    <hr class="hr-custom">
    
    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="../../overview/"><span class="ladda-label">Overview</span></a>
	</div>
	
    </form>
	
	</div>
    </header>
	
	<?php else : ?>
	
	<header class="intro">
    <div class="intro-body">
    <form class="form-custom">
    
    <div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>
    
    <hr class="hr-custom">
    
	<p class="sad-feedback text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
	
    <hr class="hr-custom">
    
    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
	</div>
	</header>
	
	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>
    Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>
	
</body>
</html>

