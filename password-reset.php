<?php
include 'includes/session.php';
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

    <title>Student Portal</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>
    <hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg ladda-button" data-style="slide-up" href="sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
	<i class="fa fa-key"></i>
    </div>

    <hr class="hr-custom">

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <?php if (isset($_GET['token'])) {
    $token = $_GET['token'];
	} ?>

	<div id="hide">

    <label>Email address</label>
    <input class="form-control" type="text" name="email" id="email" placeholder="Enter your email address">
    <p id="error1" class="feedback-sad text-center"></p>

    <label>New password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your new password">
    <label>Confirm new password</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter your new password confirmation">
    <p id="error2" class="feedback-sad text-center"></p>

    <input class="form-control" type="hidden" name="token" id="token" value="<?php echo $token; ?>">

	</div>

	<hr class="hr-custom">

    <?php if (!empty($success_footer)) {
    echo $success_footer;
    } ?>

    <div id="signin-button" class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    <div id="register-button" class="text-right">
	<button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Continue</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

	</div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    $(document).ready(function() {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 1000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

	var token = $("#token").val();

	var email3 = $("#email").val();
	if(email3 === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter an email address.");
		$("#email").addClass("error-style");
		hasError  = true;
		return false;
	} else {
		$("#error1").hide();
		$("#email").addClass("success-style");
	}

	var password2 = $("#password").val();
	if(password2 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a password.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#password").addClass("success-style");
	}

	if (password2.length < 6) {
		$("#error2").show();
		$("#error2").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	} else {
		$("#error2").hide();
		$("#password").addClass("success-style");
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

	if(password2.match(upperCase) && password2.match(lowerCase) && password2.match(numbers)) {
		$("#error2").hide();
		$("#password").addClass("success-style");
	} else {
		$("#error2").show();
		$("#error2").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#confirmpwd").addClass("success-style");
	}

	if(password2 != confirmpwd) {
		$("#error2").show();
		$("#error2").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").addClass("error-style");
		$("#confirmpwd").addClass("error-style");
        hasError  = true;
		return false;
	} else {
		$("#error2").hide();
		$("#password").addClass("success-style");
		$("#confirmpwd").addClass("success-style");
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'token=' + token + '&email3=' + email3 + '&password2=' + password2,
    success:function(){
		$("#hide").hide();
		$("#signin-button").hide();
		$("#FormSubmit").hide();
		$("#email").hide();
		$("#error").hide();
		$("#success").append('Your password has been reset successfully. You can now sign in with your new password.');
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
