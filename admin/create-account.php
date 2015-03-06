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

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Create an account</li>
    </ol>
	
	<!-- Create single account -->
	<form class="form-custom" style="max-width: 100%;" name="createsingleaccount_form" id="createsingleaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
    <p id="error1" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<label for="account_type">Account type - select below<span class="field-required">*</span></label>
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

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="firstname">First name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="" placeholder="Enter a first name">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="surname">Surname<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="surname" id="surname" value="" placeholder="Enter a surname">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="gender">Gender - select below<span class="field-required">*</span></label>
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

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="studentno">Student number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="" placeholder="Enter a student number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="degree">Programme of Study<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="degree" id="degree" value="" placeholder="Enter a programme of study">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="email">Email address<span class="field-required">*</span></label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter a email address">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="password">Password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="confirmpwd">Confirm password<span class="field-required">*</span></label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter a password confirmation">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Nationality</label>
    <input class="form-control" type="text" name="nationality" id="nationality" placeholder="Enter a country">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Date of Birth</label>
	<input class="form-control" type="text" name="dateofbirth" id="dateofbirth" placeholder="Select the date of birth"/>
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
	.resize();

    //Global variable
	var account_type;
	var gender;
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

	});

    //Setting variable value
	$('.btn-group > .gender').click(function(){
		gender = ($(this).text().replace(/^\s+|\s+$/g,''))
	});

	//Creating record
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var account_type_check = $(".account_type");
	if (account_type_check.hasClass('active')) {
        $("label[for='account_type']").empty().append("All good!");
        $("label[for='account_type']").removeClass("feedback-sad");
        $("label[for='account_type']").addClass("feedback-happy");
        $(".btn-group > .account_type").removeClass("input-sad");
        $(".btn-group > .account_type").addClass("input-happy");
	}
	else {
        $("label[for='account_type']").empty().append("Please select an account type.");
        $("label[for='account_type']").removeClass("feedback-happy");
        $("label[for='account_type']").addClass("feedback-sad");
        $(".btn-group > .account_type").removeClass("input-happy");
        $(".btn-group > .account_type").addClass("input-sad");
		hasError  = true;
		return false;
	}

	var firstname = $("#firstname").val();
	if(firstname === '') {
        $("label[for='firstname']").empty().append("Please enter a first name.");
        $("label[for='firstname']").removeClass("feedback-happy");
        $("label[for='firstname']").addClass("feedback-sad");
        $("#firstname").removeClass("input-happy");
        $("#firstname").addClass("input-sad");
        $("#firstname").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='firstname']").empty().append("All good!");
        $("label[for='firstname']").removeClass("feedback-sad");
        $("label[for='firstname']").addClass("feedback-happy");
        $("#firstname").removeClass("input-sad");
        $("#firstname").addClass("input-happy");
	}
	
	var surname = $("#surname").val();
	if(surname === '') {
        $("label[for='surname']").empty().append("Please enter a surname.");
        $("label[for='surname']").removeClass("feedback-happy");
        $("label[for='surname']").addClass("feedback-sad");
        $("#surname").removeClass("input-happy");
        $("#surname").addClass("input-sad");
        $("#surname").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='surname']").empty().append("All good!");
        $("label[for='surname']").removeClass("feedback-sad");
        $("label[for='surname']").addClass("feedback-happy");
        $("#surname").removeClass("input-sad");
        $("#surname").addClass("input-happy");
	}

	var gender_check = $(".gender");
	if (gender_check.hasClass('active')) {
        $("label[for='gender']").empty().append("All good!");
        $("label[for='gender']").removeClass("feedback-sad");
        $("label[for='gender']").addClass("feedback-happy");
        $(".btn-group > .gender").removeClass("input-sad");
        $(".btn-group > .gender").addClass("input-happy");
	}
	else {
        $("label[for='gender']").empty().append("Please select an gender.");
        $("label[for='gender']").removeClass("feedback-happy");
        $("label[for='gender']").addClass("feedback-sad");
        $(".btn-group > .gender").removeClass("input-happy");
        $(".btn-group > .gender").addClass("input-sad");
		hasError  = true;
		return false;
	}

	if (account_type === 'Student') {
		studentno = $("#studentno").val();
		degree = $("#degree").val();

		if(studentno === '') {
            $("label[for='studentno']").empty().append("Please enter a student number.");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
		}
		if ($.isNumeric(studentno)) {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
            $("#error1").hide();
		} else {
			$("#error1").show();
			$("#error1").empty().append("The student number entered is invalid.<br>The student number must be numeric.");
            $("label[for='studentno']").empty().append("Wait a minute!");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		}
		if (studentno.length != 9) {
			$("#error1").show();
			$("#error1").empty().append("The student number entered is invalid.<br>The student number must exactly 9 digits in length.");
            $("label[for='studentno']").empty().append("Wait a minute!");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
            $("#error1").hide();
		}
		if(degree === '') {
            $("label[for='degree']").empty().append("Please enter a programme of study.");
            $("label[for='degree']").removeClass("feedback-happy");
            $("label[for='degree']").addClass("feedback-sad");
            $("#degree").removeClass("input-happy");
            $("#degree").addClass("input-sad");
            $("#degree").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='degree']").empty().append("All good!");
            $("label[for='degree']").removeClass("feedback-sad");
            $("label[for='degree']").addClass("feedback-happy");
            $("#degree").removeClass("input-sad");
            $("#degree").addClass("input-happy");
		}
	} else {
		studentno = $("#studentno").val();
		degree = $("#degree").val();
	}

	var email = $("#email").val();
	if(email === '') {
        $("label[for='email']").empty().append("Please enter an email address.");
        $("label[for='email']").removeClass("feedback-happy");
        $("label[for='email']").addClass("feedback-sad");
        $("#email").removeClass("input-happy");
        $("#email").addClass("input-sad");
        $("#email").focus();
		hasError  = true;
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
		hasError  = true;
		return false;
    } else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
	}

	if (password.length < 6) {
		$("#error1").show();
		$("#error1").empty().append("Passwords must be at least 6 characters long. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").removeClass("input-happy");
        $("#password").addClass("input-sad");
        $("#password").focus();
		hasError  = true;
		return false;
	} else {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
        $("#error1").hide();
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
        $("label[for='password']").empty().append("All good!");
        $("label[for='password']").removeClass("feedback-sad");
        $("label[for='password']").addClass("feedback-happy");
        $("#password").removeClass("input-sad");
        $("#password").addClass("input-happy");
        $("#error1").hide();
	} else {
		$("#error6").show();
		$("#error6").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
        $("label[for='password']").empty().append("Wait a minute!");
        $("label[for='password']").removeClass("feedback-happy");
        $("label[for='password']").addClass("feedback-sad");
        $("#password").removeClass("input-happy");
        $("#password").addClass("input-sad");
        $("#password").focus();
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
        $("label[for='confirmpwd']").empty().append("Please enter a confirmation.");
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

	if(password != confirmpwd) {
		$("#error1").show();
		$("#error1").empty().append("Your password and confirmation do not match. Please try again.");
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
        $("#error1").hide();
	}

	var nationality = $("#nationality").val();
	var dateofbirth = $("#dateofbirth").val();
	var phonenumber = $("#phonenumber").val();
 	var address1 = $("#address1").val();
	var address2 = $("#address2").val();
	var town = $("#town").val();
	var city = $("#city").val();
	var country = $("#country").val();
	var postcode = $("#postcode").val();

	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'account_type=' + account_type + '&firstname2=' + firstname + '&surname2=' + surname + '&gender2=' + gender + '&studentno=' + studentno + '&degree=' + degree + '&email5=' + email + '&password4=' + password + '&nationality1=' + nationality + '&dateofbirth1=' + dateofbirth + '&phonenumber1=' + phonenumber + '&address11=' + address1 + '&address21=' + address2 + '&town1=' + town + '&city1=' + city + '&country1=' + country + '&postcode1=' + postcode,
    success:function(){
        $("#error1").hide();
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
	</script>

</body>
</html>
