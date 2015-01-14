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
    <link rel="icon" href="assets/img/favicon/favicon.ico">

    <title>Student Portal | Sign In</title>

    <!-- OpenSans -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet">

    <!-- bootstrap -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- font-awesome -->
    <link href="assets/css/font-awesome/font-awesome.min.css" rel="stylesheet">

    <!-- ladda -->
    <link href="assets/css/ladda/ladda-themeless.min.css" rel="stylesheet">

    <!-- common -->
    <link href="assets/css/common/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/common/html5shiv.min.js"></script>
    <script src="assets/js/common/respond.min.js"></script>
    <![endif]-->
	
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
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="register/"><span class="ladda-label">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Sign In</span></button>
	</div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <?php include 'includes/showcase/showcase.php'; ?>

	<?php endif; ?>

	<!-- js -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- bootstrap -->
	<script src="assets/js/bootstrap/bootstrap.min.js"></script>
	
	<!-- easing -->
	<script src="assets/js/easing/jquery.easing.min.js"></script>

    <!-- tile-js -->
    <script src="assets/js/tile-js/tileJs.min.js"></script>

    <!-- pace-js -->
    <script src="assets/js/pace-js/spin.min.js"></script>
    <script src="assets/js/pacejs/pace.js"></script>

	<!-- ladda -->
	<script src="assets/js/ladda/ladda.min.js"></script>

	<!-- common -->
	<script src="assets/js/common/custom.js"></script>
	<script src="assets/js/common/ie10-viewport-bug-workaround.js"></script>

	<script>
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	email = $('#email').val();
	if (email === '') {
        $("#error").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#email").css("border-color", "#4DC742");
	}
	
	password = $("#password").val();
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
	url: "http://test.student-portal.co.uk/includes/signin_process.php",
    data:'email=' + email + '&password=' + password,
    success:function(response){
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
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Timetable");
        $('.close').empty().append("<i class=\"fa fa-table\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#exams" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Exams");
        $('.close').empty().append("<i class=\"fa fa-pencil\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#library" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Library");
        $('.close').empty().append("<i class=\"fa fa-book\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#transport" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Transport");
        $('.close').empty().append("<i class=\"fa fa-bus\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#calendar" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Calendar");
        $('.close').empty().append("<i class=\"fa fa-calendar\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#events" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Events");
        $('.close').empty().append("<i class=\"fa fa-beer\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#universitymap" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("University Map");
        $('.close').empty().append("<i class=\"fa fa-map-marker\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#feedback" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Feedback");
        $('.close').empty().append("<i class=\"fa fa-check-square-o\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#messenger" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Messenger");
        $('.close').empty().append("<i class=\"fa fa-comments\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    $( "#account" ).click(function() {
        $('#modal-custom').modal('show');
        $('#modal-custom-label').empty().append("Account");
        $('.close').empty().append("<i class=\"fa fa-user\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin facilisis non ante at sollicitudin. Curabitur lorem massa, malesuada sed dapibus at, euismod nec turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur metus arcu, varius eu facilisis sit amet, rutrum eget ligula. Cras tempor sapien at massa pellentesque, fermentum placerat arcu iaculis. Nullam iaculis elit felis, ut vestibulum nisl ornare in. Nam eu orci vitae justo ullamcorper mollis at eget nisi. Pellentesque eleifend massa eget nunc sagittis porta. Nulla a feugiat nisl. Donec turpis ante, mollis a urna nec, mollis bibendum neque. Phasellus in varius metus. Suspendisse nec maximus magna. Sed rhoncus tincidunt turpis at condimentum. Donec a facilisis nisl.</p>");
    });
    </script>

</body>
</html>
