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

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Change password</li>
    </ol>
	
	<!-- Change Password -->
	<form class="form-custom" style="max-width: 100%;" name="changepassword_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
    <div id="hide">

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="password">New password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="New password">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="confirmpwd">New password confirmation</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Confirm new password">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mt10 mr5" data-style="slide-up"><span class="ladda-label">Change password</span></button>
    </div>

    </div>

    </form>
            
	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-custom">

	<div class="form-logo text-center">
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

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
	$(document).ready(function() {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 1000});

	//Hiding error message
	$("#error1").hide();
	$("#error2").hide();

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

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
        $("#error1").show;
        $("#error1").empty().append("Passwords must be at least 6 characters long. Please try again.");
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

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

    password = $("#password").val();
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
	} else {
        $("#error1").show;
        $("#error1").empty().append("Passwords must contain at least one number,<br>one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").focus();
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("label[for='confirmpwd']").empty().append("Please enter a password confirmation.");
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
        $("label[for='confirmpwd']").empty().append("Your password and confirmation do not match. Please try again.");
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
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'password3=' + password,
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
