<?php
include '../includes/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Create an account</title>
	
	<style>
	#account_type {
		background-color: #333333;
    }

    #account_type option {
		color: #FFA500;
    }
	
    #gender {
		background-color: #333333;
    }
	
	#gender option {
		color: #FFA500;
    }
    </style>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>
    
	<div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Create an account</li>
    </ol>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create an account</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    
	<div class="panel-body">
	
	<!-- Create single account -->
    <div class="content-panel mb10" style="border: none;">
    
	<form class="form-custom" style="max-width: 800px; padding-top: 0px;" name="createsingleaccount_form" id="createsingleaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <div class="form-group">

    <div class="col-xs-12 col-sm-12 full-width">
    <label>Account type</label>
    <select class="form-control" name="account_type" id="account_type">
    <option style="color:gray" value="null" disabled selected>Select an account type</option>
    <option style="color: #FFA500" class="others">student</option>
    <option style="color: #FFA500" class="others">lecturer</option>
    <option style="color: #FFA500" class="others">admin</option>
    </select>
    </div>

    </div>

	<div class="form-group">
    
	<div class="col-xs-12 col-sm-12 full-width">
    <label>Gender</label>
    <select class="form-control" name="gender" id="gender">
    <option style="color:gray" value="null" disabled selected>Select a gender</option>
    <option style="color: #FFA500" class="others">Male</option>
    <option style="color: #FFA500" class="others">Female</option>
	<option style="color: #FFA500" class="others">Other</option>
    </select>
    </div>
    
	</div>

    <div class="form-group">
	
    <div class="col-xs-6 col-sm-6 mb20 full-width">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="" placeholder="Enter a first name">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="" placeholder="Enter a surname">
	<label for="studentno">Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="" placeholder="Enter a student number">
	 </div>

    <div class="col-xs-6 col-sm-6 mb20 full-width">
	<label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="" placeholder="Enter a email address">
	<label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">
	<label>Confirm password</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter a password confirmation">
    </div>
	
    </div>

    <div class="form-group">
	
    <div class="col-xs-6 col-sm-6 full-width">
	<label>Date of Birth</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="dateofbirth" placeholder="Select the date of birth"/>
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Enter a phone number">
    </div>
	
    </div>

    <div class="form-group">
	
    <div class="col-xs-12 col-sm-12 mb20 full-width">
    <label for="degree">Programme of Study</label>
    <input class="form-control" type="text" name="degree" id="degree" value="" placeholder="Enter a programme of study">
    </div>
	
    </div>

    <div class="form-group">
    
	<div class="col-xs-6 col-sm-6 full-width">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="" placeholder="Enter a address line 1">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="" placeholder="Enter a address line 2 (Optional)">
    <label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="" placeholder="Enter a town">
	</div>

    <div class="col-xs-6 col-sm-6 full-width">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="" placeholder="Enter a city">
    <label>Country</label>
    <input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    <label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="" placeholder="Enter a postcode">
    </div>
    
	</div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10 mr5" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Create</span></button>
    </div>
	
    </form>
    
	</div><!-- /content-panel -->
    <!-- End of Change Password -->
	
	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->
	
	</div><!-- /panel-group -->
            
	</div> <!-- /container -->
	
	<?php include '../includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<style>
	html, body {
		height: 100% !important;
	}
	</style>

    <header class="intro">
    <div class="intro-body">
    <form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">
	
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div><!-- /intro-body -->
    </header>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	<?php else : ?>

    <style>
    html, body {
		height: 100% !important;
	}
    </style>

    <header class="intro">
    <div class="intro-body">
	
    <form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="mt10 hr-custom">
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
	</div>
	
    </form>

    </div><!-- /intro-body -->
    </header>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>
	Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

	<script>
	$(function () {
	$('#dateofbirth').datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(1985, 00, 01)
	});
	});
	</script>
	
	<script>
    $(document).ready(function () {
	$('#account_type').css('color', 'gray');
    $('#account_type').change(function () {
	var account_type = $('#account_type option:selected').val();
	if (account_type != '') {
        $('#account_type').css('color', '#FFA500');
	} else {
		$('#account_type').css('color', 'gray');
	}
    });

	$('#account_type').change(function(){
		if($(this).val() == 'student'){
			$('label[for="studentno"]').show();
			$('#studentno').show();
			$('label[for="degree"]').show();
			$('#degree').show();
		}
		if($(this).val() == 'lecturer'){
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}
		if($(this).val() == 'admin'){
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}
	});

	$('#gender').css('color', 'gray');
    $('#gender').change(function () {
	var gender = $('#gender option:selected').val();
	if (gender != '') {
        $('#gender').css('color', '#FFA500');
	} else {
		$('#gender').css('color', 'gray');
	}
    });

    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	if (account_type === 'null') {
        $("#error").empty().append("Please select an account type.");
		$("#account_type").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#account_type").css("border-color", "#4DC742");
	}

	if (gender === 'null') {
		$("#error").show();
        $("#error").empty().append("Please select a gender.");
		$("#gender").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#gender").css("border-color", "#4DC742");
	}
	var firstname = $("#firstname").val();
	if(firstname === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a first name.");
		$("#firstname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#firstname").css("border-color", "#4DC742");
	}
	
	var surname = $("#surname").val();
	if(surname === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a surname.");
		$("#surname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#surname").css("border-color", "#4DC742");
	}

	if (account_type === 'student') {
		var studentno = $("#studentno").val();
		if(studentno === '') {
			$("#error").show();
			$("#error").empty().append("Please enter a student number.");
			$("#studentno").css("border-color", "#FF5454");
			hasError  = true;
			return false;
		} else {
			$("#error").hide();
			$("#studentno").css("border-color", "#4DC742");
		}
	} else {
		var studentno = $("#studentno").val();
	}
	
	var email = $("#email").val();
	if(email === '') {
		$("#error").show();
        $("#error").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#email").css("border-color", "#4DC742");
	}
	
	var password = $("#password").val();
	if(password === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	}
	
	if (password.length < 6) {
		$("#error").show();
		$("#error").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	}
	
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');
	
	if(password.match(upperCase) && password.match(lowerCase) && password.match(numbers)) {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	} else {
		$("#error").show();
		$("#error").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	if(password != confirmpwd) {
		$("#error").show();
		$("#error").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").css("border-color", "#FF5454");
		$("#confirmpwd").css("border-color", "#FF5454");
        hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	var dateofbirth = $("#dateofbirth").val();
	var phonenumber = $("#phonenumber").val();
	var degree = $("#degree").val();
 	var address1 = $("#address1").val();
	var address2 = $("#address2").val();
	var town = $("#town").val();
	var city = $("#city").val();
	var country = $("#country").val();
	var postcode = $("#postcode").val();

	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/adminaccount_process.php",
    data:'account_type=' + account_type + '&gender=' + gender + '&firstname=' + firstname + '&surname=' + surname + '&studentno=' + studentno + '&email=' + email + '&password=' + password + '&confirmpwd=' + confirmpwd + '&dateofbirth=' + dateofbirth + '&phonenumber=' + phonenumber + '&degree=' + degree + '&address1=' + address1 + '&address2=' + address2 + '&town=' + town + '&city=' + city + '&country=' + country + '&postcode=' + postcode,
    success:function(response){
		$("#error").hide();
		$("#success").empty().append('Account created successfully. To create another account, simply fill in the form again.');
		$('#createsingleaccount_form').trigger("reset");
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
