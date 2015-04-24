<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../../assets/meta-tags.php'; ?>

    <title>Student Portal | Payment Cancelled</title>

    <?php include '../../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
	<div class="preloader"></div>
	
	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../../includes/menus/portal_menu.php'; ?>

    <div class="container">
    
	<form class="form-horizontal form-custom" name="paypal_success_form">
    
    <div class="form-logo text-center">
    <i class="fa fa-paypal"></i>
    </div>
    
    <hr>
    <p class="feedback-success text-center">All done! The payment has been cancelled.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="../../home/">Home</a>
	</div>
	
    </form>
	
	</div>

    <?php include '../../includes/footers/footer.php'; ?>
    <?php include '../../assets/js-paths/common-js-paths.php'; ?>

	<?php else : ?>

    <?php include '../../includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">
    
    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>
    
    <hr>
	<p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
    </div>

    </form>
	</div>

    <?php include '../../includes/footers/footer.php'; ?>
    <?php include '../../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
	
</body>
</html>

