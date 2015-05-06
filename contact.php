<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Contact</title>

    <style>
    #contact {
        background-color: #735326;
    }
    #contact a {
        color: #FFFFFF;
    }
    #contact a:focus, #contact a:hover {
        color: #FFFFFF;
    }
    </style>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <!-- Contact -->
    <div id="contact-showcase" class="container"><!-- container -->

    <ol class="breadcrumb breadcrumb-custom text-left">
        <li><a href="../../home/">Home</a></li>
        <li class="active">Contact</li>
    </ol>

	<form class="form-horizontal form-custom" style="max-width: 700px;">

    <p id="success" class="feedback-success text-center"></p>
    <p id="error" class="feedback-danger text-center"></p>

    <div id="hide">

	<div class="form-group">
	<div class="col-xs-4 col-sm-4 full-width">
	<input class="form-control" type="text" name="firstname" id="firstname" placeholder="First name">
    </div>
	<div class="col-xs-4 col-sm-4 full-width">
    <input class="form-control" type="text" name="surname" id="surname" placeholder="Surname">
	</div>
	<div class="col-xs-4 col-sm-4 full-width">
    <input class="form-control" type="email" name="email" id="email" placeholder="E-mail address">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<textarea class="form-control" rows="8" name="message" id="message" placeholder="Message"></textarea>
	</div>
	</div>
    <p id="error2" class="feedback-danger text-center"></p>

    <hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Contact us</button>
	</div>

    </div>

    </form>

    </div><!-- /.container -->

	<!-- Social -->
	<div id="social-showcase" class="container text-center"><!-- container -->

    <hr>

    <a href="https://facebook.com/triponsergiu" target="_blank"><i class="fa fa-facebook-square"></i></a>
    <a href="https://twitter.com/SergiuTripon" target="_blank"><i class="fa fa-twitter-square"></i></a>
    <a href="https://www.linkedin.com/in/triponsergiu"><i class="fa fa-linkedin-square" target="_blank"></i></a>

	</div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <!-- Contact -->
    <div id="contact-showcase" class="container"><!-- container -->

    <h1 class="text-center">Contact</h1>
    <hr class="hr-small">

	<form class="form-horizontal form-custom" style="max-width: 700px;">

    <p id="success" class="feedback-success text-center"></p>
    <p id="error" class="feedback-danger text-center"></p>

    <div id="hide">

	<div class="form-group">
	<div class="col-xs-4 col-sm-4 full-width">
	<input class="form-control" type="text" name="firstname" id="firstname" placeholder="First name">
    </div>
	<div class="col-xs-4 col-sm-4 full-width">
    <input class="form-control" type="text" name="surname" id="surname" placeholder="Surname">
	</div>
	<div class="col-xs-4 col-sm-4 full-width">
    <input class="form-control" type="email" name="email" id="email" placeholder="E-mail address">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<textarea class="form-control" rows="8" name="message" id="message" placeholder="Message"></textarea>
	</div>
	</div>
    <p id="error2" class="feedback-danger text-center"></p>

    <hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Contact us</button>
	</div>

    </div>

    </form>

    </div><!-- /.container -->

	<!-- Social -->
	<div id="social-showcase" class="container text-center"><!-- container -->

    <hr>

    <a href="https://facebook.com/triponsergiu" target="_blank"><i class="fa fa-facebook-square"></i></a>
    <a href="https://twitter.com/SergiuTripon" target="_blank"><i class="fa fa-twitter-square"></i></a>
    <a href="https://www.linkedin.com/in/triponsergiu"><i class="fa fa-linkedin-square" target="_blank"></i></a>

	</div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>


	<script>

    //Contact us process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    //Checking if firstname is inputted
	var firstname = $('#firstname').val();
	if (firstname === '') {
        $("#error1").empty().append("Please enter a first name.");
		$("#firstname").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error1").hide();
		$("#firstname").addClass("success-style");
	}

    //Checking if surname is inputted
	var surname = $("#surname").val();
    if(surname === '') {
        $("#error1").show();
        $("#error1").empty().append("Please enter a surname.");
        $("#surname").addClass("error-style");
        hasError  = true;
        return false;
    } else {
        $("#error1").hide();
        $("#surname").addClass("success-style");
    }

    //Checking if email is inputted
    var email = $("#email").val();
    if(email === '') {
        $("#error1").show();
        $("#error1").empty().append("Please enter an email address.");
        $("#email").addClass("error-style");
        hasError  = true;
        return false;
    } else {
        $("#error1").hide();
        $("#email").addClass("success-style");
    }

    //Checking if message is inputted
    var message = $("#message").val();
    if(message === '') {
        $("#error2").show();
        $("#error2").empty().append("Please enter a message.");
        $("#message").addClass("error-style");
        hasError  = true;
        return false;
    } else {
        $("#error2").hide();
        $("#message").addClass("success-style");
    }

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'contact_firstname=' + firstname + '&contact_surname=' + surname + '&contact_email=' + email + '&contact_message=' + message,

    //If action completed, do the following
    success:function(){
        $("#error").hide();
        $("#hide").hide();
        $("#success").show();
        $("#success").append('Thank you for contacting us.<br>We will check your message and reply as soon as possible.');
    },

    //If action failed, do the following
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
