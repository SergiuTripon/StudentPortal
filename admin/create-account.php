<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create an account</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Create an account</li>
    </ol>
	
	<!-- Create single account -->
	<form class="form-custom" style="max-width: 100%;" name="createsingleaccount_form" id="createsingleaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<label>Account type - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg account_type">
		<input type="radio" name="options" id="option1" autocomplete="off"> Student
	</label>
	<label class="btn btn-default btn-lg account_type">
		<input type="radio" name="options" id="option2" autocomplete="off"> Lecturer
	</label>
	<label class="btn btn-default btn-lg account_type">
		<input type="radio" name="options" id="option3" autocomplete="off"> Admin
	</label>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="" placeholder="Enter a first name">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Surname</label>
	<input class="form-control" type="text" name="surname" id="surname" value="" placeholder="Enter a surname">
	</div>
	</div>
	<p id="error2" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
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
	</div>
	</div>
	<p id="error3" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="studentno">Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="" placeholder="Enter a student number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="degree">Programme of Study</label>
	<input class="form-control" type="text" name="degree" id="degree" value="" placeholder="Enter a programme of study">
	</div>
	</div>
	<p id="error4" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter a email address">
	</div>
	</div>
	<p id="error5" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Confirm password</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter a password confirmation">
	</div>
	</div>
	<p id="error6" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Nationality</label>
    <input class="form-control" type="text" name="nationality" id="nationality" placeholder="Enter a country">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Date of Birth</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="dateofbirth" placeholder="Select the date of birth"/>
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Enter a phone number">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="" placeholder="Enter a address line 1">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="" placeholder="Enter a address line 2 (Optional)">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="" placeholder="Enter a town">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="" placeholder="Enter a city">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country</label>
    <input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="" placeholder="Enter a postcode">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create account</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Change Password -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
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
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    // Date Time Picker
	$(function () {
	$('#dateofbirth').datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(1993, 00, 01)
	});
	});

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
	var account_type;
	var gender2;
	var studentno;
	var degree;

	//Setting variable value
	$('.btn-group > .account_type').click(function(){
		account_type = ($(this).text().replace(/^\s+|\s+$/g,''))

		if(account_type === 'Student') {
			$('label[for="studentno"]').show();
			$('#studentno').show();
			$('label[for="degree"]').show();
			$('#degree').show();
		}
		if(account_type === 'Lecturer') {
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}
		if(account_type === 'Admin') {
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}

	})
	$('.btn-group > .gender').click(function(){
		gender2 = ($(this).text().replace(/^\s+|\s+$/g,''))
	})

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var account_type_check = $(".account_type");
	if (account_type_check.hasClass('active')) {
		$("#error1").hide();
		$(".btn-group > .account_type").addClass("success-style");
	}
	else {
		$("#error1").empty().append("Please select an account type.");
		$(".btn-group > .account_type").addClass("error-style");
		hasError  = true;
		return false;
	}

	var firstname2 = $("#firstname").val();
	if(firstname2 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a first name.");
		$("#firstname").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#firstname").addClass("success-style");
	}
	
	var surname2 = $("#surname").val();
	if(surname2 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a surname.");
		$("#surname").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#surname").addClass("success-style");
	}

	var gender_check = $(".gender");
	if (gender_check.hasClass('active')) {
		$("#error3").hide();
		$(".btn-group > .gender").addClass("success-style");
	}
	else {
		$("#error3").empty().append("Please select a gender.");
		$(".btn-group > .gender").addClass("error-style");
		hasError  = true;
		return false;
	}

	if (account_type === 'Student') {
		studentno = $("#studentno").val();
		degree = $("#degree").val();

		if(studentno === '') {
			$("#error4").show();
			$("#error4").empty().append("Please enter a student number.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		}
		if ($.isNumeric(studentno)) {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		} else {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must be numeric.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		}
		if (studentno.length != 9) {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must exactly 9 digits in length.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		}
		if(degree === '') {
			$("#error4").show();
			$("#error4").empty().append("Please enter a programme of study.");
			$("#degree").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#degree").addClass("success-style");
		}
	} else {
		studentno = $("#studentno").val();
		degree = $("#degree").val();
	}

	var email5 = $("#email").val();
	if(email5 === '') {
		$("#error5").show();
        $("#error5").empty().append("Please enter an email address.");
		$("#email").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error5").hide();
		$("#email").addClass("success-style");
	}

	var password4 = $("#password").val();
	if(password4 === '') {
		$("#error6").show();
        $("#error6").empty().append("Please enter a password.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error6").hide();
		$("#password").addClass("error-style");
	}

	if (password4.length < 6) {
		$("#error6").show();
		$("#error6").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	} else {
		$("#error6").hide();
		$("#password").addClass("success-style");
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

	if(password4.match(upperCase) && password4.match(lowerCase) && password4.match(numbers)) {
		$("#error6").hide();
		$("#password").addClass("success-style");
	} else {
		$("#error6").show();
		$("#error6").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
		$("#error6").show();
        $("#error6").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error6").hide();
		$("#confirmpwd").addClass("success-style");
	}

	if(password4 != confirmpwd) {
		$("#error6").show();
		$("#error6").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").addClass("error-style");
		$("#confirmpwd").addClass("error-style");
        hasError  = true;
		return false;
	} else {
		$("#error6").hide();
		$("#password").addClass("success-style");
		$("#confirmpwd").addClass("success-style");
	}

	var nationality1 = $("#nationality").val();
	var dateofbirth1 = $("#dateofbirth").val();
	var phonenumber1 = $("#phonenumber").val();
 	var address11 = $("#address1").val();
	var address21 = $("#address2").val();
	var town1 = $("#town").val();
	var city1 = $("#city").val();
	var country1 = $("#country").val();
	var postcode1 = $("#postcode").val();

	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'account_type=' + account_type + '&firstname2=' + firstname2 + '&surname2=' + surname2 + '&gender2=' + gender2 + '&studentno=' + studentno + '&degree=' + degree + '&email5=' + email5 + '&password4=' + password4 + '&nationality1=' + nationality1 + '&dateofbirth1=' + dateofbirth1 + '&phonenumber1=' + phonenumber1 + '&address11=' + address11 + '&address21=' + address21 + '&town1=' + town1 + '&city1=' + city1 + '&country1=' + country1 + '&postcode1=' + postcode1,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Account created successfully.');
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
	});
	</script>

</body>
</html>
