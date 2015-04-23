<?php
include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Register</title>

    <style>
    #register a {
        color: #FFFFFF;
        background-color: #992320;
    }
    #register a:focus, #register a:hover {
        color: #FFFFFF;
        background-color: #992320;
    }
    </style>

</head>

<body>
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">
                
	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>
    
	<hr>
                
	<p class="feedback-danger text-center">You already have an account and therefore cannot register for another. Only one account is allowed per user.</p>
    
	<hr>
                
	<div class="pull-left">
    <a class="btn btn-success btn-lg btn-load" href="../home/">Home</a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-danger btn-lg btn-load" href="../sign-out/">Sign Out</a>
    </div>
    
	</form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php else : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>

	<hr>

	<p class="feedback-danger text-justify">Note: The register facility is available to students only.</p>

	<hr>

	<div class="pull-left">
    <a class="btn btn-success btn-lg btn-load" href="../home/">Home</a>
    </div>

    <div class="text-right">
    <a class="btn btn-danger btn-lg btn-load" href="../sign-out/">Sign Out</a>
    </div>

	</form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom" style="max-width: 600px;" id="register_form" name="register_form">

    <div class="form-logo text-center">
	<i class="fa fa-check-square-o"></i>
    </div>

    <hr>

    <p id="error" class="feedback-danger text-center"></p>
    <p id="error1" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

    <div id="hide">

    <hr>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="firstname">First name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter your first name">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="surname">Surname<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="surname" id="surname" placeholder="Enter your surname">
    </div>
    </div>

	<div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="gender">Gender<span class="field-required">*</span></label>
    <select class="form-control" name="gender" id="gender" style="width: 100%;">
        <option></option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select>
    </div>
    </div>

    <label for="email">Email address<span class="field-required">*</span></label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email address">
    <p id="error3" class="feedback-danger text-center"></p>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="password">Password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
	<label for="confirmpwd">Confirm password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter your password confirmation">
    </div>
    </div>

	<div class="text-right">
    <a href="#modal-help" data-toggle="modal">Need help?</a>
    </div>
	
	</div>

    <hr>

	<div id="register-button" class="pull-left">
    <a class="btn btn-info btn-lg btn-load" href="/">Sign in</a>
    </div>
	
    <div id="register-button" class="text-right">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Register</button>
    </div>
	
	<div id="success-button" class="text-center" style="display:none">
    <a class="btn btn-success btn-lg btn-load" href="/">Sign in</a>
    </div>
	
    </form>

    </div>

    <!-- Help Modal -->
    <div id="modal-help" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
    <h4 class="modal-title" id="modal-custom-label">Need help?</h4>
    </div>

    <div class="modal-body">
    <ul class="feedback-custom">
    <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
    <li>Emails must have a valid email format</li>
    <li>Passwords must be at least 6 characters long</li>
    <li>Passwords must contain
    <ul>
    <li>At least one upper case letter (A..Z)</li>
    <li>At least one lower case letter (a..z)</li>
    <li>At least one number (0..9)</li>
    </ul>
    </li>
    <li>Your password and confirmation must match exactly</li>
    </ul>
    </div>

	<div class="modal-footer">
    <div class="text-right">
    <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
    </div>
    </div>

	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Help Modal -->

    <!-- Info Modal -->
    <div id="modal-info" class="modal fade modal-custom modal-info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
    <h4 class="modal-title" id="modal-custom-label">Registration info</h4>
    </div>

    <div class="modal-body">
    <p>Note: The register facility is available to students only. If you're a lecturer, tutorial assistant or administrator, please contact an administrator who will create an account for you.</p>
    </div>

	<div class="modal-footer">
    <div class="text-right">
    <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
    </div>
    </div>

	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Help Modal -->

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>
    //On load
    $(document).ready(function () {
        //select2
        $("#gender").select2({placeholder: "Select an option"});
        $("#modal-info").modal('show');
    });

	//Register user
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    var firstname = $("#firstname").val();
	if(firstname === '') {
        $("label[for='firstname']").empty().append("Please enter a first name.");
        $("label[for='firstname']").removeClass("feedback-success");
        $("label[for='firstname']").addClass("feedback-danger");
        $("#firstname").removeClass("input-success");
        $("#firstname").addClass("input-danger");
        $("#firstname").focus();
		hasError = true;
        return false;
    } else {
        $("label[for='firstname']").empty().append("All good!");
        $("label[for='firstname']").removeClass("feedback-danger");
        $("label[for='firstname']").addClass("feedback-success");
        $("#firstname").removeClass("input-danger");
        $("#firstname").addClass("input-success");
	}

	var surname = $("#surname").val();
	if(surname === '') {
        $("label[for='surname']").empty().append("Please enter a surname.");
        $("label[for='surname']").removeClass("feedback-success");
        $("label[for='surname']").addClass("feedback-danger");
        $("#surname").removeClass("input-success");
        $("#surname").addClass("input-danger");
        $("#surname").focus();
		hasError = true;
        return false;
    } else {
        $("label[for='surname']").empty().append("All good!");
        $("label[for='surname']").removeClass("feedback-danger");
        $("label[for='surname']").addClass("feedback-success");
        $("#surname").removeClass("input-danger");
        $("#surname").addClass("input-success");
	}

    var gender_check = $("#gender :selected").html();
    if (gender_check === 'Select an option') {
        $("label[for='gender']").empty().append("Please select an option.");
        $("label[for='gender']").removeClass("feedback-success");
        $("label[for='gender']").addClass("feedback-danger");
        $("#gender").removeClass("input-success");
        $("#gender").addClass("input-danger");
        $("#gender").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='gender']").empty().append("All good!");
        $("label[for='gender']").removeClass("feedback-danger");
        $("label[for='gender']").addClass("feedback-success");
        $("#marker_category").removeClass("input-danger");
        $("#marker_category").addClass("input-success");
    }

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

    password = $("#password").val();
	if (password.length < 6) {
        $("#error1").show();
        $("#error1").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
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
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

    password = $("#password").val();
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-danger");
        $("label[for='password']").addClass("feedback-success");
        $("#password").removeClass("input-danger");
        $("#password").addClass("input-success");
	} else {
        $("#error1").show();
        $("#error1").empty().append("Passwords must contain at least one number,<br>one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-success");
        $("label[for='password']").addClass("feedback-danger");
        $("#password").removeClass("input-success");
        $("#password").addClass("input-danger");
        $("#password").focus();
		hasError  = true;
		return false;
	}

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
        $("#confirmpwd").removeClass("input-danger");
        $("#confirmpwd").addClass("input-success");
	}

	if(password != confirmpwd) {
        $("#error1").show();
        $("#error1").empty().append("Your password and confirmation do not match. Please try again.");
        $("label[for='confirmpwd']").empty().append("Wait a minute!");
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
        $("#confirmpwd").removeClass("input-danger");
        $("#confirmpwd").addClass("input-success");
        $("#error1").hide();
	}

    var gender = $("#gender :selected").val();

    if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'register_firstname=' + firstname +
         '&register_surname='  + surname +
         '&register_gender='   + gender +
         '&register_email='    + email +
         '&register_password=' + password,
    success:function(){
        $("#error").hide();
		$("#hide").hide();
        $("#FormSubmit").hide();
		$("#register-button").hide();
        $("#success").show();
		$("#success").append('Thank you for your registration. You can now Sign in to your account.');
		$("#success-button").show();
    },
    error:function (xhr, ajaxOptions, thrownError){
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

