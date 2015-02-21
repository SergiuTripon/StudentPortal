<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create timetable</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Create an account</li>
    </ol>

    <!-- Create timetable -->
	<form class="form-custom" style="max-width: 100%;" name="createtimetable_form" id="createtimetable_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <!-- Create module -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module name</label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="" placeholder="Enter a module name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module notes</label>
    <input class="form-control" type="text" name="module_notes" id="module_notes" placeholder="Enter module notes">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Module URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" placeholder="Enter a module URL">
	</div>
	</div>
    <!-- End of Create module -->

    <hr>

    <!-- Create lecture -->
	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture name</label>
    <input class="form-control" type="text" name="lecture_notes" id="lecture_notes" value="" placeholder="Enter a module name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Lecture lecturer</label>
    <select class="form-control" name="lecturers">
    <?php
    $stmt1 = $mysqli->query("SELECT userid FROM user_signin WHERE account_type = 'lecturer'");

    while ($row = $stmt1->fetch_assoc()){

    $lectureid = $row["userid"];

    $stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
    $stmt2->bind_param('i', $lectureid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($firstname, $surname);
    $stmt2->fetch();

        echo '<option value="'.$lectureid.'">'.$firstname.' '.$surname.'</option>';
    }

    ?>
    </select>
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Lecture notes</label>
    <input class="form-control" type="text" name="lecture_notes" id="lecture_notes" placeholder="Enter module notes">
	</div>
	</div>
    <!-- End of Create lecture -->

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create timetable</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create timetable -->

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
	$(document).ready(function () {

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
	.resize();//trigger the resize event on page load.

    //Global variable
	var account_type;
	var gender2;
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

	})
	$('.btn-group > .gender').click(function(){
		gender2 = ($(this).text().replace(/^\s+|\s+$/g,''))
	})

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var account_type_check = $(".account_type");
	if (account_type_check.hasClass('active')) {
		$("#error1").hide();
		$(".btn-group > .account_type").addClass("success-style");
	}
	else {
		$("#error1").empty().append("Please select an account type.");
		$(".btn-group > .account_type").addClass("error-style");
		hasError  = true;
		return false;
	}

	var firstname2 = $("#firstname").val();
	if(firstname2 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a first name.");
		$("#firstname").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#firstname").addClass("success-style");
	}
	
	var surname2 = $("#surname").val();
	if(surname2 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a surname.");
		$("#surname").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#surname").addClass("success-style");
	}

	var gender_check = $(".gender");
	if (gender_check.hasClass('active')) {
		$("#error3").hide();
		$(".btn-group > .gender").addClass("success-style");
	}
	else {
		$("#error3").empty().append("Please select a gender.");
		$(".btn-group > .gender").addClass("error-style");
		hasError  = true;
		return false;
	}

	if (account_type === 'Student') {
		studentno = $("#studentno").val();
		degree = $("#degree").val();

		if(studentno === '') {
			$("#error4").show();
			$("#error4").empty().append("Please enter a student number.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		}
		if ($.isNumeric(studentno)) {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		} else {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must be numeric.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		}
		if (studentno.length != 9) {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must exactly 9 digits in length.");
			$("#studentno").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").addClass("success-style");
		}
		if(degree === '') {
			$("#error4").show();
			$("#error4").empty().append("Please enter a programme of study.");
			$("#degree").addClass("error-style");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#degree").addClass("success-style");
		}
	} else {
		studentno = $("#studentno").val();
		degree = $("#degree").val();
	}

	var email5 = $("#email").val();
	if(email5 === '') {
		$("#error5").show();
        $("#error5").empty().append("Please enter an email address.");
		$("#email").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error5").hide();
		$("#email").addClass("success-style");
	}

	var password4 = $("#password").val();
	if(password4 === '') {
		$("#error6").show();
        $("#error6").empty().append("Please enter a password.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error6").hide();
		$("#password").addClass("error-style");
	}

	if (password4.length < 6) {
		$("#error6").show();
		$("#error6").empty().append("Passwords must be at least 6 characters long. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	} else {
		$("#error6").hide();
		$("#password").addClass("success-style");
	}

	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');

	if(password4.match(upperCase) && password4.match(lowerCase) && password4.match(numbers)) {
		$("#error6").hide();
		$("#password").addClass("success-style");
	} else {
		$("#error6").show();
		$("#error6").empty().append("Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again.");
		$("#password").addClass("error-style");
		hasError  = true;
		return false;
	}

	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd === '') {
		$("#error6").show();
        $("#error6").empty().append("Please enter a password confirmation.");
		$("#confirmpwd").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error6").hide();
		$("#confirmpwd").addClass("success-style");
	}

	if(password4 != confirmpwd) {
		$("#error6").show();
		$("#error6").empty().append("Your password and confirmation do not match. Please try again.");
		$("#password").addClass("error-style");
		$("#confirmpwd").addClass("error-style");
        hasError  = true;
		return false;
	} else {
		$("#error6").hide();
		$("#password").addClass("success-style");
		$("#confirmpwd").addClass("success-style");
	}

	var nationality1 = $("#nationality").val();
	var dateofbirth1 = $("#dateofbirth").val();
	var phonenumber1 = $("#phonenumber").val();
 	var address11 = $("#address1").val();
	var address21 = $("#address2").val();
	var town1 = $("#town").val();
	var city1 = $("#city").val();
	var country1 = $("#country").val();
	var postcode1 = $("#postcode").val();

	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'account_type=' + account_type + '&firstname2=' + firstname2 + '&surname2=' + surname2 + '&gender2=' + gender2 + '&studentno=' + studentno + '&degree=' + degree + '&email5=' + email5 + '&password4=' + password4 + '&nationality1=' + nationality1 + '&dateofbirth1=' + dateofbirth1 + '&phonenumber1=' + phonenumber1 + '&address11=' + address11 + '&address21=' + address21 + '&town1=' + town1 + '&city1=' + city1 + '&country1=' + country1 + '&postcode1=' + postcode1,
    success:function(){
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
	});
	</script>

</body>
</html>
