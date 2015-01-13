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

    <title>Student Portal | Change password</title>

	<!-- Open Sans font -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300">

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link href="..assets/css/font-awesome/font-awesome.min.css">

    <!-- Ladda CSS -->
    <link href="../assets/css/ladda/ladda-themeless.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/common/custom.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	#success-title1 {
		display: none;
	}
	</style>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>
    
	<header class="intro">
    <div class="intro-body">
    <form class="form-custom">

	<div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="mt10 hr-custom">
	
	<p class="feedback-sad text-center">You need to have a student or lecturer account to access this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div><!-- /intro-body -->
    </header>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

    <div class="container">
	<?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li><a href="../account/">Account</a></li>
    <li class="active">Change password</li>
    </ol>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a id="normal-title1" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Change password</a>
	<a id="success-title1" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Password changed successfully.</a>
    </h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    
	<div class="panel-body">
	
	<!-- Change Password -->
    <div class="content-panel mb10" style="border: none;">
    
	<form class="form-custom" style="max-width: 700px; padding-top: 0px;" name="changepassword_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
    <div id="hide">

    <div class="form-group">
    
	<div class="col-xs-6 col-sm-6 full-width">
    <label>New password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="New password">
    </div>

    <div class="col-xs-6 col-sm-6 full-width">
    <label>New password confirmation</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Confirm new password">
    </div>
	
	</div><!-- /form-group -->

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10 mr5" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Change</span></button>
    </div>

    </div>

    </form>
    </div><!-- /content-panel -->
    <!-- End of Change Password -->
	
	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->
	
	</div><!-- /panel-group -->
            
	</div> <!-- /container -->
	
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
	
    <form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="mt10 hr-custom">
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
	<script src="../assets/js/bootstrap/bootstrap.min.js"></script>

	<!-- Pace JS -->
	<script src="../assets/js/pace-js/spin.min.js"></script>
	<script src="../assets/js/pace-js/pace.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda/ladda.min.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/common/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

	<script>
	Ladda.bind('.ladda-button', {timeout: 1000});
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	password = $("#password").val();
	if(password === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	}
	
	if (password.length < 6) {
		$("#error").show();
		$(".sad-feedback").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	}
	
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');
	
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	} else {
		$("#error").show();
		$(".sad-feedback").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	if(password != confirmpwd) {
		$("#error").show();
		$(".sad-feedback").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").css("border-color", "#FF5454");
		$("#confirmpwd").css("border-color", "#FF5454");
        hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "http://test.student-portal.co.uk/includes/account_process.php",
    data:'password=' + password + '&confirmpwd=' + confirmpwd,
    success:function(response){
		$("#hide").hide();
		$("#error").hide();
		$("#success").append('Your password has been changed successfully.');
		$("#success-button").show();
    },
    error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }
	
	return true;
	
	});
	});
	</script>

</body>
</html>
