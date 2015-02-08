<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/js-paths/pacejs-js-path.php'; ?>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Account deleted</title>

</head>

<body>

    <?php include '../includes/menus/menu.php'; ?>

	<div class="preloader"></div>

    <div class="container">
	
	<form class="form-custom" name="paypal_success_form">

    <div class="form-logo">
    <i class="fa fa-trash"></i>
    </div>

    <hr>

    <p class="feedback-happy text-center">Your account has been deleted successfully.</p>

    <hr>

	<div class="pull-left">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
	</div>

    <div class="text-right">
    <a class="btn btn-register btn-lg ladda-button" data-style="slide-up" href="/register"><span class="ladda-label">Register</span></a>

	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
	
	<script>
	Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>

</body>
</html>



