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

    <title>Student Portal | Forgotten Password</title>

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

    <header class="intro">
    <div class="intro-body">

    <form class="form-custom">

    <div class="logo-custom animated fadeIn delay">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">You are already signed in which means you haven't forgotten your password. <br><br>If you have, you can sign out and access the "Forgotten your password?" facility.</p>

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

    <form class="form-custom" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="post" name="forgotpassword_form">

    <div class="logo-custom animated fadeIn delay">
    <i class="fa fa-lock"></i>
    </div>

    <hr class="hr-custom">
	
    <p id="hide" class="feedback-custom text-justify">Please enter the email you used to register to the <b>Student Portal</b> and we will email you a link to reset your password.</p>
	
	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
	<label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Email address">
    <p id="error1" class="feedback-sad text-center"></p>

    <hr class="hr-custom">

    <div id="register-button" class="pull-left">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    <div id="register-button" class="text-right">
    <button id="FormSubmit" class="btn btn-lg btn-custom ladda-button" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Continue</span></button>
    </div>
	
	<div id="success-button" class="text-center" style="display:none">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Continue</span></a>
    </div>

    </form>

    </div><!-- /intro-body -->
    </header>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    $(document).ready(function() {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 1000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var email2 = $("#email").val();
	if(email2 === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
        $("#error1").hide();
        $("#email").css("border-color", "#4DC742");
    }
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'email2=' + email2,
    success:function(){
        $("#error").hide();
		$("#hide").hide();
        $("label").hide();
        $("#email").hide();
		$("#register-button").hide();
		$("#FormSubmit").hide();
		$("#success").append('Please check your email account for instructions to reset your password.');
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
