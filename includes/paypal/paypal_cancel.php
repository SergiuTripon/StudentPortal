<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../../assets/meta-tags.php'; ?>

    <?php include '../../assets/css-paths/common-css-paths.php'; ?>

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

    <?php include '../../includes/menus/portal_menu.php'; ?>

    <div class="container">
    
	<form class="form-custom" name="paypal_success_form">
    
    <div class="form-logo text-center">
    <i class="fa fa-paypal"></i>
    </div>
    
    <hr>
    <p class="feedback-sad text-center">Payment cancelled successfully.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="../../overview/"><span class="ladda-label">Overview</span></a>
	</div>
	
    </form>
	
	</div>

    <?php include '../../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/sign-out-inactive.js"></script>
	
	<?php else : ?>

    <?php include '../../includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-custom">
    
    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>
    
    <hr>
	<p class="sad-feedback text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
	</div>

    <?php include '../../includes/footers/footer.php'; ?>

    <?php endif; ?>

    <?php include '../../assets/js-paths/common-js-paths.php'; ?>

	<script>
    Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>
	
</body>
</html>

