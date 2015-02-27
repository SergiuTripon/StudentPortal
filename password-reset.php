<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Password Reset</title>

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
    <script src="assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
	<i class="fa fa-lock"></i>
    </div>

    <hr class="hr-custom">

    <p id="error" class="feedback-sad text-center"></p>
    <p id="error1" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <?php if (isset($_GET['token'])) {
    $token = $_GET['token'];
	} ?>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pr0 pl0">
    <label for="email">Email address<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="email" id="email" placeholder="Enter your email address">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="password">New password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your new password">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="confirmpwd">Confirm new password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter your new password confirmation">
    </div>
    </div>

    <input class="form-control" type="hidden" name="token" id="token" value="<?php echo $token; ?>">

	</div>

	<hr class="hr-custom">

    <?php if (!empty($success_footer)) {
    echo $success_footer;
    } ?>

    <div id="extra-button" class="pull-left">
    <a class="btn btn-info btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    <div class="text-right">
	<button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Continue</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

	</div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 1000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError;

	var token = $("#token").val();

	var email = $("#email").val();
	if(email === '') {
        $("label[for='email']").empty().append("Please enter an email address.");
        $("label[for='email']").removeClass("feedback-happy");
		$("label[for='email']").addClass("feedback-sad");
        $("#email").removeClass("input-happy");
        $("#email").addClass("input-sad");
        $("#email").focus();
		hasError = true;
		return false;
	} else {
        $("label[for='email']").empty().append("All good!");
        $("label[for='email']").removeClass("feedback-sad");
        $("label[for='email']").addClass("feedback-happy");
        $("#email").removeClass("input-sad");
        $("#email").addClass("input-happy");
    }

	var password = $("#password").val();
	if(password === '') {
        $("label[for='password']").empty().append("Please enter a password.");
        $("label[for='password']").removeClass("feedback-happy");
		$("label[for='password']").addClass("feedback-sad");
        $("#password").removeClass("input-happy");
        $("#password").addClass("input-sad");
        $("#password").focus();
		hasError = true;
		return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
    }

	password = $("#password").val();
	if (password.length < 6) {
        $("#error1").show();
        $("#error1").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").removeClass("input-happy");
        $("#password").addClass("input-sad");
        $("#password").focus();
		hasError = true;
        return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

    password = $("#password").val();
	if(!password.match(upperCase) && !password.match(lowerCase) && !password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
	} else {
        $("#error1").show();
        $("#error1").empty().append("Passwords must contain at least one number,<br>one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").removeClass("input-happy");
        $("#password").addClass("input-sad");
        $("#password").focus();
        hasError = true;
        return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("label[for='confirmpwd']").empty().append("Please enter a confirmation.");
        $("label[for='confirmpwd']").removeClass("feedback-happy");
        $("label[for='confirmpwd']").addClass("feedback-sad");
        $("#confirmpwd").removeClass("input-sad");
        $("#confirmpwd").addClass("input-happy");
        $("#confirmpwd").focus();
		hasError = true;
        return false;
    } else {
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='confirmpwd']").removeClass("feedback-sad");
        $("label[for='confirmpwd']").addClass("feedback-happy");
        $("#confirmpwd").removeClass("input-sad");
        $("#confirmpwd").addClass("input-happy");
	}

	if(password != confirmpwd) {
        $("#error1").show();
        $("#error1").empty().append("Your password and confirmation do not match. Please try again");
        $("label[for='confirmpwd']").empty().append("Wait a minute!");
        $("label[for='confirmpwd']").removeClass("feedback-happy");
        $("label[for='confirmpwd']").addClass("feedback-sad");
        $("#confirmpwd").removeClass("input-happy");
        $("#confirmpwd").addClass("input-sad");
        $("#confirmpwd").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='confirmpwd']").removeClass("feedback-sad");
        $("label[for='confirmpwd']").addClass("feedback-happy");
        $("#confirmpwd").removeClass("input-sad");
        $("#confirmpwd").addClass("input-happy");
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'token=' + token + '&email3=' + email + '&password2=' + password,
    success:function(){
        $("#error").hide();
        $("#error1").hide();
        $("#error2").hide();
        $("#error3").hide();
        $("#hide").hide();
		$("#extra-button").hide();
		$("#FormSubmit").hide();
        $(".fa").removeClass("fa-lock");
        $(".fa").addClass("fa-key");
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
	</script>

</body>
</html>
