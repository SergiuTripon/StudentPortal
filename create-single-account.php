<?php
include 'includes/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Create a single account</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda-themeless.min.css">
	
	<!-- Bootstrap Date Picker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
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
	<?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li><a href="../account/">Account</a></li>
    <li class="active">Create a single account</li>
    </ol>

	<p class="feedback-custom text-center">What type of account do you want to create?</p>

	<div class="row mb10">

	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="student-button">
	<div class="tile student-tile">
	<i class="fa fa-user"></i>
	<p class="tile-text">Student</p>
	</div>
	</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a id="lecture-button">
	<div class="tile lecturer-tile">
	<i class="fa fa-user"></i>
	<p class="tile-text">Lecturer</p>
	</div>
	</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a id="admin-button">
	<div class="tile admin-tile">
	<i class="fa fa-user"></i>
	<p class="tile-text">Administrator</p>
	</div>
	</a>
	</div>

	</div><!-- /row -->
	
	<div class="panel-group" id="accordion student-toggle" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create a single account</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    
	<div class="panel-body">
	
	<!-- Create a student account -->
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
	<label>Date of Birth (YYYY-MM-DD)</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="datepicker1" data-date-format="YYYY-MM-DD" value="" placeholder="Select the date of birth (YYYY-MM-DD)"/>
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

	<div class="panel-group" id="accordion lecturer-toggle" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create a single account</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

	<div class="panel-body">

	<!-- Create a lecturer account -->
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
	<label>Date of Birth (YYYY-MM-DD)</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="datepicker1" data-date-format="YYYY-MM-DD" value="" placeholder="Select the date of birth (YYYY-MM-DD)"/>
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

	<div class="panel-group" id="accordion admin-toggle" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create a single account</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

	<div class="panel-body">

	<!-- Create an admin account -->
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
	<label>Date of Birth (YYYY-MM-DD)</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="datepicker1" data-date-format="YYYY-MM-DD" value="" placeholder="Select the date of birth (YYYY-MM-DD)"/>
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
    <!-- End of Create an admin account -->

	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->

	</div><!-- /panel-group -->

	</div> <!-- /container -->

	<?php include 'includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

    <?php else : ?>

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
    <script src="../assets/js/sign-out-inactive.js"></script>

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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	<!-- Bootstrap Date Picker JS -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="../assets/js/bootstrap-datetimepicker.js"></script>

	<script>
    $(function () {
        $('#datepicker1').datetimepicker({
            pickTime: false
        });
    });
	</script>

	<!-- Spin JS -->
	<script src="../assets/js/spin.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda.min.js"></script>
	
	<!-- Pace JS -->
    <script src="../assets/js/pace.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

	<script>
		// Bind normal buttons
		Ladda.bind('.ladda-button', {timeout: 2000});
	</script>
	
	<script>
    $(document).ready(function () {
    $('#gender').css('color', 'gray');
    $('#gender').change(function () {
    var current = $('#gender').val();
	if (current != '') {
        $('#gender').css('color', '#FFA500');
	} else {
		$('#gender').css('color', 'gray');
	}
    });
	$('#account_type').css('color', 'gray');
    $('#account_type').change(function () {
    var current = $('#account_type').val();
	if (current != '') {
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

    });
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	account_type1 = $('#account_type option:selected').val();
	if (account_type1 === 'null') {
        $("#error").empty().append("Please select an account type.");
		$("#account_type").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#account_type").css("border-color", "#4DC742");
	}
	
	gender1 = $('#gender option:selected').val();
	if (gender1 === 'null') {
		$("#error").show();
        $("#error").empty().append("Please select a gender.");
		$("#gender").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#gender").css("border-color", "#4DC742");
	}
	
	firstname1 = $("#firstname").val();
	if(firstname1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a first name.");
		$("#firstname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#firstname").css("border-color", "#4DC742");
	}
	
	surname1 = $("#surname").val();
	if(surname1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a surname.");
		$("#surname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#surname").css("border-color", "#4DC742");
	}

	if (account_type1 === 'student') {
		studentno1 = $("#studentno").val();
	}

	if(studentno1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a student number.");
		$("#studentno").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#studentno").css("border-color", "#4DC742");
	}

	studentno1 = $("#studentno").val();
	
	email1 = $("#email").val();
	if(email1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#email").css("border-color", "#4DC742");
	}
	
	password1 = $("#password").val();
	if(password1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	}
	
	if (password1.length < 6) {
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
	
	if(password1.match(upperCase) && password1.match(lowerCase) && password1.match(numbers)) {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
	} else {
		$("#error").show();
		$("#error").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	confirmpwd1 = $("#confirmpwd").val();
	if(confirmpwd1 === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error").hide();
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	if(password1 != confirmpwd1) {
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
	
	dateofbirth1 = $("#dateofbirth").val();
	phonenumber1 = $("#phonenumber").val();
	degree1 = $("#degree").val();
	address11 = $("#address1").val();
	address21 = $("#address2").val();
	town1 = $("#town").val();
	city1 = $("#city").val();
	country1 = $("#country").val();
	postcode1 = $("#postcode").val();

	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "http://test.student-portal.co.uk/includes/account_process.php",
    data:'account_type1=' + account_type1 + '&gender1=' + gender1 + '&firstname1=' + firstname1 + '&surname1=' + surname1 + '&studentno1=' + studentno1 + '&email1=' + email1 + '&password1=' + password1 + '&confirmpwd1=' + confirmpwd1 + '&dateofbirth1=' + dateofbirth1 + '&phonenumber1=' + phonenumber1 + '&degree1=' + degree1 + '&address11=' + address11 + '&address21=' + address21 + '&town1=' + town1 + '&city1=' + city1 + '&country1=' + country1 + '&postcode1=' + postcode1,
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

	$("#student-toggle").hide();
	$("#lecturer-toggle").hide();
	$("#admin-toggle").hide();

	$("#student-button").click(function (e) {
		e.preventDefault();
		$("#lecturer-toggle").fadeOut();
		$("#admin-toggle").fadeOut();
		$("#student-toggle").fadeIn();
		$(".lecturer-tile").removeClass("tile-selected");
		$(".lecturer-tile p").removeClass("tile-text-selected");
		$(".lecturer-tile i").removeClass("tile-text-selected");
		$(".admin-tile").removeClass("tile-selected");
		$(".admin-tile p").removeClass("tile-text-selected");
		$(".admin-tile i").removeClass("tile-text-selected");
		$(".student-tile").addClass("tile-selected");
		$(".student-tile p").addClass("tile-text-selected");
		$(".student-tile i").addClass("tile-text-selected");
	});

	$("#lecture-button").click(function (e) {
		e.preventDefault();
		$("#student-toggle").fadeOut();
		$("#admin-toggle").fadeOut();
		$("#lecturer-toggle").fadeIn();
		$(".student-tile").removeClass("tile-selected");
		$(".student-tile p").removeClass("tile-text-selected");
		$(".student-tile i").removeClass("tile-text-selected");
		$(".admin-tile").removeClass("tile-selected");
		$(".admin-tile p").removeClass("tile-text-selected");
		$(".admin-tile i").removeClass("tile-text-selected");
		$(".lecturer-tile").addClass("tile-selected");
		$(".lecturer-tile p").addClass("tile-text-selected");
		$(".lecturer-tile i").addClass("tile-text-selected");
	});

	$("#admin-button").click(function (e) {
		e.preventDefault();
		$("#student-toggle").fadeOut();
		$("#lecturer-toggle").fadeOut();
		$("#admin-toggle").fadeIn();
		$(".student-tile").removeClass("tile-selected");
		$(".student-tile p").removeClass("tile-text-selected");
		$(".student-tile i").removeClass("tile-text-selected");
		$(".lecturer-tile").removeClass("tile-selected");
		$(".lecturer-tile p").removeClass("tile-text-selected");
		$(".lecturer-tile i").removeClass("tile-text-selected");
		$(".admin-tile").addClass("tile-selected");
		$(".admin-tile p").addClass("tile-text-selected");
		$(".admin-tile i").addClass("tile-text-selected");
	});

	});
	</script>

</body>
</html>
