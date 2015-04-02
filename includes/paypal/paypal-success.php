<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../../assets/meta-tags.php'; ?>

    <?php include '../../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Payment Completed</title>

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
    <p class="feedback-happy text-center">Payment completed successfully.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="../../home/"><span class="ladda-label">Home</span></a>
	</div>
	
    </form>
	
	</div>

    <?php include '../../includes/footers/footer.php'; ?>
	
	<?php else : ?>

    <?php include '../../includes/menus/menu.php'; ?>


    <div class="container">

    <form class="form-horizontal form-custom">
    
    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>
    
    <hr>
	<p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/"><span class="ladda-label">Sign in</span></a>
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

