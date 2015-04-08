<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Locked out</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>
    <hr>

    <div class="pull-left">
    <a class="btn btn-custom btn-lg" href="home/">Home</span></a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-custom btn-lg" href="../sign-out/">Sign Out</span></a>
    </div>

    </form>

    </div>

    <?php include 'includes/footers/footer.php'; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="before" class="container">

	<form class="form-horizontal form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
        <i class="fa fa-lock"></i>
    </div>

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

    <hr>
    <p class="feedback-sad text-center">You've been inactive for 15 minutes, so we've locked you out for security reasons.</p>
    <hr>

    <div class="text-center">
    <a id="unlock-button" class="btn btn-primary btn-lg" >Unlock</span></a>
	</div>

    </form>

	</div>

    <div id="after" class="container">
	
	<form class="form-horizontal form-custom" name="signin_form" id="signin_form">

    <div class="form-logo text-center">
	<i class="fa fa-unlock"></i>
    </div>

    <hr>

    <p id="error" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="email">Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address" autocomplete="no">
    </div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password" autocomplete="no">
    </div>
    </div>
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="text-right">
    <a class="forgot-password" href="../forgotten-password/">Forgotten your password?</a>
    </div>

    <hr>

    <div class="pull-left">
    <a class="btn btn-success btn-lg" href="../register/">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Sign in</span></button>
	</div>

    </form>
	
	</div>

    <?php include 'includes/footers/footer.php'; ?>

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

    });

	$("#after").hide();
    $("#unlock-button").click(function (e) {
	$("#before").hide();
	$("#after").show();
	
	});
	
	$("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var email = $('#email').val();
	if (email === '') {
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
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'email=' + email + '&password=' + password,
    success:function(){
		window.location = '../home/';
    },
    error:function (xhr, ajaxOptions, thrownError){
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

