<?php
include '../includes/session.php';

if (isset($_POST["recordToAssign"])) {

	$idToAssign = filter_input(INPUT_POST, 'recordToAssign', FILTER_SANITIZE_NUMBER_INT);

} else {
	header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Update an account</title>

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
	<li><a href="../update-delete-an-account/">Update/Delete an account</a></li>
    <li class="active">Update an account</li>
    </ol>

	<!-- Update an account -->
	<form class="form-custom" style="max-width: 100%;" name="updateanaccount_form" id="updateanaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<input type="hidden" name="userid" id="userid" value="<?php echo $idToAssign; ?>">

	<hr>

	</div>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update account</span></button>
    </div>

    </form>

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

	//Date Time Picker
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
	var account_type1;
	var gender3;
	var studentno1;

	account_type1 = ($('.account_type.active').text().replace(/^\s+|\s+$/g,''));
	gender3 = ($('.gender.active').text().replace(/^\s+|\s+$/g,''));

	//Setting variable value
	$('.btn-group > .account_type').click(function(){
		account_type1 = ($(this).text().replace(/^\s+|\s+$/g,''))

		if(account_type1 === 'Student') {
			$('label[for="studentno"]').show();
			$('#studentno').show();
			$('label[for="degree"]').show();
			$('#degree').show();
		}
		if(account_type1 === 'Lecturer') {
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}
		if(account_type1 === 'Admin') {
			$('label[for="studentno"]').hide();
			$('#studentno').hide();
			$('label[for="degree"]').hide();
			$('#degree').hide();
		}

	})
	$('.btn-group > .gender').click(function(){
		gender3 = ($(this).text().replace(/^\s+|\s+$/g,''))
	})

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

	var userid = $("#userid").val();

	var firstname3 = $("#firstname").val();
	if(firstname3 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a first name.");
		$("#firstname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#firstname").css("border-color", "#4DC742");
	}

	var surname3 = $("#surname").val();
	if(surname3 === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a surname.");
		$("#surname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#surname").css("border-color", "#4DC742");
	}

	var email6 = $("#email").val();
	if(email6 === '') {
		$("#error5").show();
        $("#error5").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error5").hide();
		$("#email").css("border-color", "#4DC742");
	}

	if (account_type1 === 'Student') {
		studentno1 = $("#studentno").val();
		if(studentno1 === '') {
			$("#error4").show();
			$("#error4").empty().append("Please enter a student number.");
			$("#studentno").css("border-color", "#FF5454");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").css("border-color", "#4DC742");
		}
		if ($.isNumeric(studentno1)) {
			$("#error4").hide();
			$("#studentno").css("border-color", "#4DC742");
		} else {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must be numeric.");
			$("#studentno").css("border-color", "#FF5454");
			hasError  = true;
			return false;
		}
		if (studentno1.length != 9) {
			$("#error4").show();
			$("#error4").empty().append("The student number entered is invalid.<br>The student number must exactly 9 digits in length.");
			$("#studentno").css("border-color", "#FF5454");
			hasError  = true;
			return false;
		} else {
			$("#error4").hide();
			$("#studentno").css("border-color", "#4DC742");
		}
	} else {
		studentno1 = $("#studentno").val();
	}

	var degree1 = $("#degree").val();
	if(degree1 === '') {
		$("#error4").show();
        $("#error4").empty().append("Please enter a programme of study.");
		$("#degree").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error4").hide();
		$("#degree").css("border-color", "#4DC742");
	}

	var nationality2 = $("#nationality").val();
	var dateofbirth2 = $("#dateofbirth").val();
	var phonenumber2 = $("#phonenumber").val();
 	var address12 = $("#address1").val();
	var address22 = $("#address2").val();
	var town2 = $("#town").val();
	var city2 = $("#city").val();
	var country2 = $("#country").val();
	var postcode2 = $("#postcode").val();


	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'userid=' + userid + '&account_type1=' + account_type1 + '&firstname3=' + firstname3 + '&surname3=' + surname3 + '&gender3=' + gender3 + '&studentno1=' + studentno1 + '&degree1=' + degree1 + '&email6=' + email6 + '&nationality2=' + nationality2 + '&dateofbirth2=' + dateofbirth2 + '&phonenumber2=' + phonenumber2 + '&address12=' + address12 + '&address22=' + address22 + '&town2=' + town2 + '&city2=' + city2 + '&country2=' + country2 + '&postcode2=' + postcode2,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('The account has been updated successfully.');
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
