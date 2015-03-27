<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	
	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Change password</title>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Change password</li>
    </ol>
	
	<!-- Change Password -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="changepassword_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
    <p id="error1" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
    <div id="hide">

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
    <label for="oldpwd">Old password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="oldpwd" id="oldpwd" placeholder="Enter your old password">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
    <label for="password">New password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a new password">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
    <label for="confirmpwd">Confirm new password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter the new password again">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mt10 mr5" data-style="slide-up"><span class="ladda-label">Change password</span></button>
    </div>

    </div>

    </form>
            
	</div><!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
	$(document).ready(function() {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 1000});

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var oldpwd = $("#oldpwd").val();
	if(oldpwd === '') {
        $("label[for='oldpwd']").empty().append("Please enter your old password.");
        $("label[for='oldpwd']").removeClass("feedback-happy");
        $("label[for='oldpwd']").addClass("feedback-sad");
        $("#oldpwd").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='oldpwd']").empty().append("All good!");
        $("label[for='oldpwd']").removeClass("feedback-sad");
        $("label[for='oldpwd']").addClass("feedback-happy");
	}

	var password = $("#password").val();
	if(password === '') {
        $("label[for='password']").empty().append("Please enter a new password.");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
	}

    password = $("#password").val();
	if (password.length < 6) {
        $("#error1").show();
        $("#error1").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").focus();
		hasError  = true;
		return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#error1").hide();
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

    password = $("#password").val();
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#error1").hide();
	} else {
        $("#error1").show();
        $("#error1").empty().append("Passwords must contain at least one number,<br>one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").focus();
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("label[for='confirmpwd']").empty().append("Please enter the new password again.");
        $("label[for='confirmpwd']").removeClass("feedback-happy");
        $("label[for='confirmpwd']").addClass("feedback-sad");
        $("#confirmpwd").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='confirmpwd']").removeClass("feedback-sad");
        $("label[for='confirmpwd']").addClass("feedback-happy");
	}

	if(password != confirmpwd) {
        $("#error1").show();
        $("#error1").empty().append("Your password and confirmation do not match. Please try again.");
        $("label[for='confirmpwd']").empty().append("Wait a minute!");
        $("label[for='confirmpwd']").removeClass("feedback-happy");
        $("label[for='confirmpwd']").addClass("feedback-sad");
        $("#confirmpwd").focus();
        hasError  = true;
		return false;
	} else {
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='confirmpwd']").removeClass("feedback-sad");
        $("label[for='confirmpwd']").addClass("feedback-happy");
        $("#error1").hide();
	}

    alert(oldpwd);
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'change_oldpwd=' + oldpwd +
         'change_password=' + password,
    success:function(){
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
