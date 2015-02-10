<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../../assets/js-paths/pacejs-js-path.php'; ?>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include '../../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Payment Completed</title>

</head>

<body>
	<div class="preloader"></div>
	
	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../../includes/menus/portal_menu.php'; ?>

    <div class="container">
    
	<form class="form-custom" name="paypal_success_form">
    
    <div class="form-logo">
    <i class="fa fa-paypal"></i>
    </div>
    
    <hr>
    <p class="feedback-happy text-center">Payment completed successfully.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="../../overview/"><span class="ladda-label">Overview</span></a>
	</div>
	
    </form>
	
	</div>

    <?php include '../../includes/footers/footer.php'; ?>
	
	<?php else : ?>

    <?php include '../../includes/menus/menu.php'; ?>


    <div class="container">

    <form class="form-custom">
    
    <div class="form-logo">
    <i class="fa fa-graduation-cap"></i>
    </div>
    
    <hr>
	<p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr>
    
    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>
	</div>

    <?php include '../../includes/footer/footers.php'; ?>
	
	<?php endif; ?>

    <?php include '../../assets/js-paths/common-js-paths.php'; ?>

	<script>
	Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>
	
</body>
</html>

