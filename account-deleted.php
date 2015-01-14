<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include 'assets/css-paths.php'; ?>

    <title>Student Portal | Account deleted</title>
	
	<style>
	html, body {
		height: 100% !important;
	}
	</style>

</head>

<body>

	<div class="preloader"></div>

    <header class="intro">
    <div class="intro-body">
	
	<form class="form-custom" name="paypal_success_form">

    <div class="logo-custom">
    <i class="fa fa-trash"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-happy text-center">Your account has been deleted successfully.</p>

    <hr class="hr-custom">

	<div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
	</div>

    <div class="text-right">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/register"><span class="ladda-label">Register</span></a>

	</div>

    </form>

	</div><!-- /intro-body -->
    </header>

    <?php include 'assets/js-paths.php'; ?>
	
	<script>
	Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>

</body>
</html>



