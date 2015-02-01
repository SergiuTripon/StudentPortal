<?php
include '../includes/signin.php';

if (isset($_POST["recordToUpdate"])) {

	$idToUpdate = filter_input(INPUT_POST, 'recordToUpdate', FILTER_SANITIZE_NUMBER_INT);

	$stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_signin.account_type, user_signin.email, user_details.firstname, user_details.surname, user_details.gender, user_details.studentno, user_details.degree, user_details.nationality, user_details.dateofbirth, user_details.phonenumber, user_details.address1, user_details.address2, user_details.town, user_details.city, user_details.country, user_details.postcode FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt1->bind_param('i', $idToUpdate);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($userid1, $account_type1, $email1, $firstname1, $surname1, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode);
	$stmt1->fetch();
	$stmt1->close();

} else {
	header('Location: ../../account/');
}

if ($dateofbirth == "0000-00-00") {
	$dateofbirth = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Update an account</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<div class="container">
	<?php include '../includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
	<li><a href="../account/update-delete-an-account/">Update/Delete an account</a></li>
    <li class="active">Update an account</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Create an account</a>
	</h4>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

	<div class="panel-body">

	<!-- Update an account -->
    <div class="content-panel mb10" style="border: none;">

	<form class="form-custom" style="max-width: 800px; padding-top: 0px;" name="updateanaccount_form" id="updateanaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<input type="hidden" name="userid" id="userid" value="<?php echo $userid1; ?>">

	<label>Account type - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-custom account_type <?php if($account_type1 == "student") echo "active"; ?>">
		<input type="radio" name="options" id="option1" autocomplete="off"> Student
	</label>
	<label class="btn btn-custom account_type <?php if($account_type1 == "lecturer") echo "active"; ?>">
		<input type="radio" name="options" id="option2" autocomplete="off"> Lecturer
	</label>
	<label class="btn btn-custom account_type <?php if($account_type1 == "admin") echo "active"; ?>">
		<input type="radio" name="options" id="option3" autocomplete="off"> Admin
	</label>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname1; ?>" placeholder="Enter a first name">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Surname</label>
	<input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname1; ?>" placeholder="Enter a surname">
	</div>
	</div>
	<p id="error2" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Gender - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-custom gender <?php if($gender == "Male") echo "active"; ?>">
		<input type="radio" name="options" id="option1" autocomplete="off"> Male
	</label>
	<label class="btn btn-custom gender <?php if($gender == "Female") echo "active"; ?>">
		<input type="radio" name="options" id="option2" autocomplete="off"> Female
	</label>
	<label class="btn btn-custom gender <?php if($gender == "Other") echo "active"; ?>">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
	</div>
	</div>
	<p id="error3" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="studentno">Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Enter a student number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="degree">Programme of Study</label>
	<input class="form-control" type="text" name="degree" id="degree" value="<?php echo $degree; ?>" placeholder="Enter a programme of study">
	</div>
	</div>
	<p id="error4" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email1; ?>" placeholder="Enter a email address">
	</div>
	</div>
	<p id="error5" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Nationality</label>
    <input class="form-control" type="text" name="nationality" id="nationality" value="<?php echo $nationality; ?>" placeholder="Enter a country">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label>Date of Birth</label>
	<input type='text' class="form-control" type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $dateofbirth; ?>" placeholder="Select the date of birth"/>
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Enter a phone number">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter a address line 1">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter a address line 2 (Optional)">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="<?php echo $town; ?>" placeholder="Enter a town">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="Enter a city">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country</label>
    <input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" placeholder="Enter a postcode">
	</div>
	</div>

	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10 mr5" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Update account</span></button>
    </div>

    </form>

	</div><!-- /content-panel -->
    <!-- End of Change Password -->

	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->

	</div><!-- /panel-group -->

	</div> <!-- /container -->

	<?php include '../includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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
		defaultDate: new Date(1985, 00, 01)
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
		$("#success").empty().append('Account created successfully.');
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
