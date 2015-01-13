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

    <title>Student Portal | Password Reset</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda/ladda-themeless.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/common/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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

    <div class="logo-custom animated fadeIn delay">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">You are already signed in which means you haven't forgotten your password.<br><br>If you have, you can sign out and access the "Forgotten your password?" facility.</p>

    <hr class="hr-custom">

    <div class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="overview/"><span class="ladda-label">Overview</span></a>
    </div>
	
    <div class="text-right">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="../sign-out/"><span class="ladda-label">Sign Out</span></a>
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

    <form class="form-custom" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="passwordreset_form">

    <div class="logo-custom animated fadeIn delay">
	<i class="fa fa-key"></i>
    </div>

    <hr class="hr-custom">

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <?php if (isset($_GET['token'])) {
    $token = $_GET['token'];
	} ?>

	<div id="hide">
    <label>Email address</label>
    <input class="form-control" type="text" name="email1" id="email1" placeholder="Enter your email address">

    <label>New password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your new password">

    <label>Confirm new password</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Enter your new password confirmation">
    <input class="form-control" type="hidden" name="token" id="token" value="<?php echo $token; ?>">
	
	</div>
	
	<hr class="hr-custom">

    <?php if (!empty($success_footer)) {
    echo $success_footer;
    } ?>

    <div id="register-button" class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    <div id="register-button" class="text-right">
	<button id="FormSubmit" class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Continue</span></button>
    </div>
	
	<div id="success-button" class="text-center" style="display:none;">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

    </div><!-- /intro-body -->
    </header>

    <?php include 'includes/showcase/showcase.php'; ?>

	<?php endif; ?>

	<!-- JS -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Easing JS -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- tileJS -->
    <script src="../assets/js/tilejs/tileJs.min.js"></script>

	<!-- Pace JS -->
	<script src="../assets/js/pacejs/spin.min.js"></script>
	<script src="../assets/js/pacejs/pace.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda/ladda.min.js"></script>

	<!-- Custom JS-->
	<script src="../assets/js/common/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/common/ie10-viewport-bug-workaround.js"></script>

	<script>
    Ladda.bind('.ladda-button', {timeout: 1000});
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	token = $("#token").val();
	
	email = $("#email1").val();
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
	
	if (password.length < 6) {
		$("#error").show();
		$(".sad-feedback").empty().append("Passwords must be at least 6 characters long. Please try again.");
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
		$(".sad-feedback").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	confirmpwd = $("#confirmpwd").val();
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
		$(".sad-feedback").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").css("border-color", "#FF5454");
		$("#confirmpwd").css("border-color", "#FF5454");
        hasError  = true;
		return false;
	} else {
		$("#error").hide();
		$("#password").css("border-color", "#4DC742");
		$("#confirmpwd").css("border-color", "#4DC742");
	}
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "http://test.student-portal.co.uk/includes/forgottenpassword_process.php",
    data:'token=' + token + '&email=' + email + '&password=' + password + '&confirmpwd=' + confirmpwd,
    success:function(response){
		$("#hide").hide();
		$("#register-button").hide();
		$("#FormSubmit").hide();
		$("#email").hide();
		$("#error").hide();
		$("#success").append('Your password has been reset successfully. You can now sign in with your new password.');
		$("#success-button").show();
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
