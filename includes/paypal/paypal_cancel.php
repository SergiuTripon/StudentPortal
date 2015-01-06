<?php
include_once '../signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Pace JS -->
    <script src="../../assets/js/pace.js"></script>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../assets/img/favicon/favicon.ico">

    <title>Student Portal | Payment Cancelled</title>
    
    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    
    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
    
    <!-- Animate CSS -->
  	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">
    
	<!-- Ladda CSS -->
	<link rel="stylesheet" href="../../assets/css/ladda-themeless.min.css">
	
    <!-- Custom styles for this template -->
    <link href="../../assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
	
	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    
	<!-- Bootstrap JS -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	<!-- Spin JS -->
	<script src="../../assets/js/spin.min.js"></script>
	
	<!-- Ladda JS -->
	<script src="../../assets/js/ladda.min.js"></script>
	
    <!-- Custom JS -->
    <script src="../../assets/js/custom.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

	<script>
		// Bind normal buttons
		Ladda.bind( '.ladda-button', { timeout: 2000 } );
	</script>
	
</body>
</html>

