<?php
include '../includes/session.php';

global $mysqli;
global $userToChangePassword;

//If URL parameter is set, do the following
if (isset($_GET["id"])) {

    $userToChangePassword = $_GET["id"];

//If URL parameter is not set, do the following
} else {
    header('Location: ../../account/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Change password</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Change password</li>
    </ol>

	<!-- Change Password -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="changepassword_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>
    <p id="error1" class="feedback-danger text-center"></p>

    <div id="hide">

	<input type="hidden" name="userid" id="userid" value="<?php echo $userToChangePassword; ?>" />

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
    <label for="password">New password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="password" id="password" placeholder="New password">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="confirmpwd">New password confirmation<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Confirm new password">
	</div>
	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="admin-change-password-submit" class="btn btn-primary btn-lg btn-load">Change password</button>
    </div>

    </div>

    </form>

	</div> <!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Change an account's password process
    $("#admin-change-password-submit").click(function (e) {
    e.preventDefault();

	var hasError = false;

	var userid = $("#userid").val();

    //Checking if password is inputted
	var password = $("#password").val();
	if(password === '') {
        $("label[for='password']").empty().append("Please enter a password.");
        $("label[for='password']").removeClass("feedback-success");
        $("label[for='password']").addClass("feedback-danger");
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
        $("#password").focus();
        hasError  = true;
		return false;
    } else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-danger");
        $("label[for='password']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
	}

    //Checking if password is more than 6 characters long
	if (password.length < 6) {
        $("label[for='password']").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").removeClass("feedback-success");
        $("label[for='password']").addClass("feedback-danger");
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
        $("#password").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-danger");
        $("label[for='password']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
	}

    //Checking if password contains at least one number, one lowercase, and one uppercase letter
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-danger");
        $("label[for='password']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
	} else {
		$("label[for='password']").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").removeClass("feedback-success");
        $("label[for='password']").addClass("feedback-danger");
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
        $("#password").focus();
        hasError  = true;
        return false;
	}

    //Checking if confirmpwd is inputted
	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("label[for='confirmpwd']").empty().append("Please enter a password confirmation.");
        $("label[for='confirmpwd']").removeClass("feedback-success");
        $("label[for='confirmpwd']").addClass("feedback-danger");
        $("#confirmpwd").removeClass("input-success");
        $("#confirmpwd").addClass("input-danger");
        $("#confirmpwd").focus();
        hasError  = true;
        return false;
    } else {
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='confirmpwd']").removeClass("feedback-danger");
        $("label[for='confirmpwd']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
	}

    //Checking if password and password confirmation match
	if(password != confirmpwd) {
		$("label[for='password'").empty().append("The password and confirmation do not match. Please try again.");
        $("label[for='confirmpwd'").empty().append("The password and confirmation do not match. Please try again.");
        $("label[for='password']").removeClass("feedback-success");
        $("label[for='password']").addClass("feedback-danger");
        $("label[for='confirmpwd']").removeClass("feedback-success");
        $("label[for='confirmpwd']").addClass("feedback-danger");
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
        $("#confirmpwd").removeClass("input-success");
        $("#confirmpwd").addClass("input-danger");
        $("#password").focus();
        $("#confirmpwd").focus();
        hasError  = true;
        return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='confirmpwd']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-danger");
        $("label[for='password']").addClass("feedback-success");
        $("label[for='confirmpwd']").removeClass("feedback-danger");
        $("label[for='confirmpwd']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
        $("#confirmpwd").removeClass("input-danger");
        $("#confirmpwd").addClass("input-success");
	}

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'change_account_password_userid=' + userid + '&change_account_password_password=' + password,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
        $("#error1").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").append('All done! The password has been changed.');
		$("#success-button").show();
    },

    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError){
        buttonReset();
		$("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }
	return true;
	});
	</script>

	<?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>

    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/home/">Home</a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
	</div>

    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

</body>
</html>
