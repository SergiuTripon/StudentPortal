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

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">
                
	<div class="form-logo text-center">
    <i class="fa fa-check-square-o"></i>
    </div>
    
	<hr>
                
	<p class="feedback-sad text-center">You already have an account and therefore cannot register for another. Only one account is allowed per user.</p>
    
	<hr>
                
	<div class="pull-left">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="../overview/"><span class="ladda-label">Overview</span></a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-danger btn-lg ladda-button" data-style="slide-up" href="../sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>
    
	</form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-custom" style="max-width: 600px;" id="register_form" name="register_form">

    <div class="form-logo text-center">
	<i class="fa fa-check-square-o"></i>
    </div>

    <hr>

	<p id="success" class="feedback-happy text-center"></p>
    <p id="error" class="feedback-sad text-center"></p>

    <div id="hide">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter your first name">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" placeholder="Enter your surname">
    </div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

	<label>Gender - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg gender">
		<input type="radio" name="options" id="option1" autocomplete="off"> Male
	</label>
	<label class="btn btn-default btn-lg gender">
		<input type="radio" name="options" id="option2" autocomplete="off"> Female
	</label>
	<label class="btn btn-default btn-lg gender">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
    <p id="error2" class="feedback-sad text-center"></p>

    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email address">
    <p id="error3" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Confirm password</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter your password confirmation">
    </div>
    </div>
    <p id="error4" class="feedback-sad text-center"></p>

	<div class="text-right">
    <a href="#modal-help" data-toggle="modal">Need help?</a>
    </div>
	
	</div>

    <hr>

	<div id="register-button" class="pull-left">
    <a class="btn btn-info btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>
	
    <div id="register-button" class="text-right">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up" data-spinner-color="#333333"><span class="ladda-label">Register</span></button>
    </div>
	
	<div id="success-button" class="text-center" style="display:none">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
    </div>
	
    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Help Modal -->
    <div class="modal fade modal-custom" id="modal-help" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Back</button>
    </div>
            
	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Help Modal -->

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	
	<script>
    $(document).ready(function() {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 480){
			$('.btn-group').removeClass('btn-group-justified');
			$('.btn-group').addClass('btn-group-vertical full-width');
		} else {
			$('.btn-group').addClass('btn-group-justified');
		}
	})
	.resize();//trigger the resize event on page load.

    //Global variable
	var gender;

	//Setting variable value
	$('.btn-group .gender').click(function(){
        gender = ($(this).text().replace(/^\s+|\s+$/g,''))
	})

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError;

    var firstname = $("#firstname").val();
	if(firstname === '') {
        $("#error").hide();
		$("#error1").show();
        $("#error1").empty().append("Please enter a first name.");
        $("#firstname").removeClass("success-style");
        $("#firstname").addClass("error-style");
		hasError = true;
        return false;
    } else {
        $("#error").hide();
		$("#error1").hide();
        $("#firstname").removeClass("error-style");
		$("#firstname").addClass("success-style");
        hasError = false;
	}
	
	var surname = $("#surname").val();
	if(surname === '') {
        $("#error").hide();
		$("#error1").show();
        $("#error1").empty().append("Please enter a surname.");
        $("#surname").removeClass("success-style");
		$("#surname").addClass("error-style");
		hasError = true;
        return false;
    } else {
        $("#error").hide();
		$("#error1").hide();
        $("#surname").removeClass("error-style");
		$("#surname").addClass("success-style");
        hasError = false;
	}

    var gender_check = $(".gender");
	if (gender_check.hasClass('active')) {
        $("#error").hide();
		$("#error2").hide();
        $(".btn-group > .btn-default").removeClass("error-style");
		$(".btn-group > .btn-default").addClass("success-style");
        hasError = false;
	}
	else {
        $("#error").hide();
        $("#error2").show();
		$("#error2").empty().append("Please select a gender.");
        $(".btn-group > .btn-default").removeClass("success-style");
		$(".btn-group > .btn-default").addClass("error-style");
		hasError = true;
        return false;
	}
	
	var email = $("#email").val();
	if(email === '') {
        $("#error").hide();
		$("#error3").show();
        $("#error3").empty().append("Please enter an email address.");
        $("#email").removeClass("success-style");
		$("#email").addClass("error-style");
		hasError = true;
        return false;
    } else {
        $("#error").hide();
		$("#error3").hide();
        $("#email").removeClass("error-style");
		$("#email").addClass("success-style");
        hasError = false;
	}

	var password = $("#password").val();
	if(password === '') {
        $("#error").hide();
		$("#error4").show();
        $("#error4").empty().append("Please enter a password.");
        $("#password").removeClass("success-style");
		$("#password").addClass("error-style");
		hasError = true;
        return false;
    } else {
        $("#error").hide();
		$("#error4").hide();
        $("#password").removeClass("error-style");
		$("#password").addClass("success-style");
        hasError = false;
	}

    password = $("#password").val();
	if (password.length < 6) {
        $("#error").hide();
		$("#error4").show();
		$("#error4").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").removeClass("success-style");
        $("#password").addClass("error-style");
		hasError = true;
        return false;
	} else {
        $("#error").hide();
		$("#error4").hide();
        $("#password").removeClass("error-style");
        $("#password").addClass("success-style");
        hasError = false;
	}
	
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

    password = $("#password").val();
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("#error").hide();
		$("#error4").hide();
        $("#password").removeClass("error-style");
		$("#password").addClass("success-style");
        hasError = false;
	} else {
        $("#error").hide();
		$("#error4").show();
		$("#error4").empty().append("Passwords must contain at least one number,<br>one lowercase and one uppercase letter. Please try again.");
        $("#password").removeClass("success-style");
        $("#password").addClass("error-style");
        hasError = true;
        return false;
	}
	
	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("#error").hide();
		$("#error4").show();
        $("#error4").empty().append("Please enter a password confirmation.");
        $("#confirmpwd").removeClass("success-style");
		$("#confirmpwd").addClass("error-style");
		hasError = true;
        return false;
    } else {
		$("#error").hide();
        $("#error4").hide();
        $("#confirmpwd").removeClass("error-style");
        $("#confirmpwd").addClass("success-style");
        hasError = false;
	}
	
	if(password != confirmpwd) {
        $("#error").hide();
		$("#error4").show();
		$("#error4").empty().append("Your password and confirmation do not match. Please try again.");
        $("#password").removeClass("success-style");
        $("#confirmpwd").removeClass("success-style");
        $("#password").addClass("error-style");
		$("#confirmpwd").addClass("error-style");
        hasError  = true;
        return false;
	} else {
        $("#error").hide();
		$("#error4").hide();
        $("#password").removeClass("error-style");
        $("#confirmpwd").removeClass("error-style");
		$("#password").addClass("success-style");
		$("#confirmpwd").addClass("success-style");
        hasError = false;
	}
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'firstname=' + firstname + '&surname=' + surname + '&gender=' + gender + '&email1=' + email + '&password1=' + password,
    success:function(){
        $("#error").hide();
		$("#hide").hide();
        $("#FormSubmit").hide();
		$("#register-button").hide();
        $("#success").show();
		$("#success").append('Thank you for your registration. You can now sign in to your account.');
		$("#success-button").show();
    },
    error:function (xhr, ajaxOptions, thrownError){
        $("#success").hide();
        $("#error1").hide();
        $("#error2").hide();
        $("#error3").hide();
        $("#error4").hide();
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

