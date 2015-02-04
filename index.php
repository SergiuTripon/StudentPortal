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

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Sign In</title>
	
	<style>
	html, body {
		height: 100% !important;
	}
	</style>
	
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <header class="intro">
    <div class="intro-body">

    <form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">You are already logged in. You don't have to log in again.</p>

    <hr class="hr-custom">

	<div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="sign-out/"><span class="ladda-label">Sign Out</span></a>
    </div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <header class="intro">
    <div class="intro-body">

    <form class="form-custom" name="signin_form" id="signin_form">

    <div class="logo-custom">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">
	
	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address">

    <label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">

    <div class="text-right">
    <a class="forgot-password" href="forgotten-password/">Forgotten your password?</a>
    </div>

    <hr class="hr-custom">

    <div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="register/"><span class="ladda-label">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Sign In</span></button>
	</div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <?php include 'includes/showcase/showcase.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    $(document).ready(function() {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
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

	<script>
    // jQuery to collapse the navbar on scroll
    $(window).scroll(function () {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function () {
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function () {
        $('.navbar-toggle:visible').click();
    });
	</script>

    <script>
    $( "#timetable" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Timetable");
        $('.close').empty().append("<i class=\"fa fa-table\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">No one likes 9am lectures, especially when hungover from the night before. An easily accessible timetable will help you organise yourself better as you roll out of bed in the morning‏.</p>");
    });
    $( "#exams" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Exams");
        $('.close').empty().append("<i class=\"fa fa-pencil\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">The word that every student hates. But this feature will make your life a little less stressful by helping you get to your exams on time and get the best results. Revision's all on you though.</p>");
    });
    $( "#library" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Library");
        $('.close').empty().append("<i class=\"fa fa-book\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Feeling like a couch potato and don't want to go to the library? No sweat, just log on, have a browse and reserve what you fancy, or renew something that you already have on loan‏.</p>");
    });
    $( "#transport" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Transport");
        $('.close').empty().append("<i class=\"fa fa-subway\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">So you get to the tube station and your line is delayed. We've all been there. Now you can check transport updates from our web app without the hassle of going on the TfL website‏.</p>");
    });
    $( "#calendar" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Calendar");
        $('.close').empty().append("<i class=\"fa fa-calendar\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Your own personal secretary who sits in your back pocket. They'll nag you about what you need to do and when.</p>");
    });
    $( "#events" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Events");
        $('.close').empty().append("<i class=\"fa fa-beer\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Let's be honest. We all say at the beginning of the year that we'll go to events but we never do. Here's your chance to get involved and have some fun. It's in your hands‏.</p>");
    });
    $( "#universitymap" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("University Map");
        $('.close').empty().append("<i class=\"fa fa-map-marker\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">That moment of panic when you have to go to a new classroom that you've never heard of. Admit it, it's not just freshers who get lost. But fear not, with the web app you'll have your own portable TomTom&#8482;‏.</p>");
    });
    $( "#feedback" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Feedback");
        $('.close').empty().append("<i class=\"fa fa-check-square-o\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Everyone dreads their lecturer handing them the paper-based Student Survey. Let's not kill anymore trees. Just keep calm and log on to provide your feedback. Your lecturer will even be able to contact you in person to discuss any concerns.</p>");
    });
    $( "#messenger" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Messenger");
        $('.close').empty().append("<i class=\"fa fa-comments\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">So your lecturers office is on the fourth floor and there's no lift. Why bother climbing the stairs or opening your email when you can just send them a quick message? Simples.</p>");
    });
    $( "#account" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Account");
        $('.close').empty().append("<i class=\"fa fa-user\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">There are some things in life you can't control, but you can have full control of your account right here. See what it feels like to be the boss.</p>");
    });
    </script>

</body>
</html>
