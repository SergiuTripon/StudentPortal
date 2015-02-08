<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/favicon/favicon.ico">

    <title>Student Portal | Locked out</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>
	
	<style>
	html, body {
		height: 100% !important;
	}
	</style>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>
    <hr>

    <div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" href="../sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <header id="before" class="intro">
    <div class="intro-body">

    <div id="showtime">
    <div id="showdate"></div>
    <ul>
      <li id="hours"></li>
      <li id="point">:</li>
      <li id="min"></li>
      <li id="point">:</li>
      <li id="sec"></li>
    </ul>
    </div>
	<p class="feedback-custom text-center" style="font-size: 20px;">You've been inactive for 15 minutes, so we've locked you out for security reasons</>
    <div id="lock-screen">
    <a id="lock-icon"><i class="fa fa-lock"></i></a><br>
    <a id="lock-text">UNLOCK</a>
    </div>
	
	</div>
    </header>

    <div class="container">
	
	<form class="form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">
	
	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address" autocomplete="no">

    <label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password" autocomplete="no">

    <div class="text-right">
    <a class="forgot-password" href="forgotten-password/">Forgotten your password?</a>
    </div>

    <hr class="hr-custom">

    <div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="../register/"><span class="ladda-label">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Sign In</span></button>
	</div>

    </form>
	
	</div>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

    <script>
    $(document).ready(function() {
    // Create two variable with the names of the months and days in an array
    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
    var dayNames= ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]

    // Create a newDate() object
    var newDate = new Date();
    // Extract the current date from Date object
    newDate.setDate(newDate.getDate());
    // Output the day, date, month and year
    $('#showdate').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

    setInterval( function() {
        // Create a newDate() object and extract the seconds of the current time on the visitor's
        var seconds = new Date().getSeconds();
        // Add a leading zero to seconds value
        $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
    });

    setInterval( function() {
        // Create a newDate() object and extract the minutes of the current time on the visitor's
        var minutes = new Date().getMinutes();
        // Add a leading zero to the minutes value
        $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    });

    setInterval( function() {
        // Create a newDate() object and extract the hours of the current time on the visitor's
        var hours = new Date().getHours();
        // Add a leading zero to the hours value
        $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});
	
	$("#after").hide();
	
    $("#lock-icon").click(function (e) {

	$("#before").fadeOut("700");	
	$("#after").fadeIn();
	
	});
	
	$("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var email = $('#email').val();
	if (email === '') {
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
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'email=' + email + '&password=' + password,
    success:function(){
		window.location = '../overview/';
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

