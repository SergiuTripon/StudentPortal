<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal</title>

    <style>
    #signin a {
        color: #FFFFFF;
        background-color: #992320;
    }
    #signin a:focus, #signin a:hover {
        color: #FFFFFF;
        background-color: #992320;
    }
    </style>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

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

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php else : ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p id="error" class="feedback-danger text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="email">Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">
    </div>
    </div>

    <div class="text-right">
    <a class="forgot-password" href="forgotten-password/">Forgotten your password?</a>
    </div>

    <hr>

    <div class="pull-left">
    <a class="btn btn-info btn-lg btn-load" href="register/">Register</a>
    </div>

    <div class="text-right">
    <a id="sign-in-submit" class="btn btn-primary btn-lg btn-load">Sign in</a>
	</div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <script>

    //Sign In process
    $("#sign-in-submit").click(function (e) {
    e.preventDefault();

    var hasError = false;

    //Checking if email is inputted
	var email = $('#email').val();
	if (email === '') {
        $("label[for='email']").empty().append("Please enter an email address.");
        $("label[for='email']").removeClass("feedback-success");
        $("label[for='email']").addClass("feedback-danger");
        $("#email").removeClass("input-success");
        $("#email").addClass("input-danger");
        $("#email").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='email']").empty().append("All good!");
        $("label[for='email']").removeClass("feedback-danger");
        $("label[for='email']").addClass("feedback-success");
        $("#email").removeClass("input-danger");
        $("#email").addClass("input-success");
	}

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

    //If there are no errors, initialize the Ajax call
	if(hasError == false){

    //Initialize Ajax call
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'email=' + email + '&password=' + password,

    //If action completed, do the following
    success:function(){
		window.location = '../home/';
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

	<?php endif; ?>

</body>
</html>
