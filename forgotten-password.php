<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Forgotten Password</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">You are already logged in. You don't have to log in again.</p>
    <hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg" href="home/">Home</a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg" href="sign-out/">Sign Out</a>
    </div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>


    <script src="assets/js/files/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom" method="post" name="forgotpassword_form">

    <div class="form-logo text-center">
    <i class="fa fa-lock"></i>
    </div>

    <hr>

    <p id="hide1">Please enter the email you used to sign in to the <b>Student Portal</b> and we will email you a link to reset your password.</p>

	<p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

    <div id="hide2">

	<label for="email">Email address<span class="field-required">*</span></label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Email address">

    </div>

    <hr>

    <div id="extra-button" class="pull-left">
    <a class="btn btn-info btn-lg" href="/">Sign in</a>
    </div>

    <div id="extra-button" class="text-right">
    <button id="FormSubmit" class="btn btn-lg btn-primary" >Continue</button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
    <a class="btn btn-primary btn-lg" href="/">Continue</a>
    </div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Forgotten password process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Checking if email is inputted
	var email = $("#email").val();
	if(email === '') {
        $("label[for='email']").empty().append("Please enter an email address.");
        $("label[for='email']").removeClass("feedback-success");
		$("label[for='email']").addClass("feedback-danger");
        $("#email").removeClass("input-success");
        $("#email").addClass("input-danger");
        $("#email").focus();
		hasError = true;
		return false;
	} else {
        $("label[for='email']").empty().append("All good!");
        $("label[for='email']").removeClass("feedback-danger");
        $("label[for='email']").addClass("feedback-success");
        $("#email").removeClass("input-danger");
        $("#email").addClass("input-success");
    }

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'fp_email=' + email,

    //If action completed, do the following
    success:function(){
        $("#error").hide();
        $("#error1").hide();
		$("#hide1").hide();
        $("#hide2").hide();
        $("#extra-button").hide();
        $("#FormSubmit").hide();
        $(".fa").removeClass("fa-lock");
        $(".fa").addClass("fa-envelope");
        $("#success").show();
		$("#success").append('Please check your email account for instructions to reset your password.');
		$("#success-button").show();
    },

    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError){
        $("#success").hide();
        $("#error1").hide();
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
