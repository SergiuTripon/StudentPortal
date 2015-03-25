<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

	$userToUpdate = $_GET["id"];

	$stmt1 = $mysqli->prepare("SELECT user_signin.account_type, user_signin.email, user_detail.firstname, user_detail.surname, user_detail.gender, user_detail.studentno, user_detail.degree, user_detail.nationality, user_detail.dateofbirth, user_detail.phonenumber, user_detail.address1, user_detail.address2, user_detail.town, user_detail.city, user_detail.country, user_detail.postcode FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
	$stmt1->bind_param('i', $userToUpdate);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($account_type, $email, $firstname, $surname, $gender, $studentno, $degree, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $country, $postcode);
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

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>
	<?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Update an account</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Update account</li>
    </ol>

	<!-- Update an account -->
	<form class="form-custom" style="max-width: 100%;" name="updateanaccount_form" id="updateanaccount_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
    <p id="error1" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<input type="hidden" name="userid" id="userid" value="<?php echo $userToUpdate; ?>">

	<div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="lecture_day">Account type<span class="field-required">*</span></label>
    <select class="form-control" name="lecture_day" id="lecture_day" style="width: 100%;">
        <option <?php if($account_type == "student") echo "selected"; ?>>Monday</option>
        <option <?php if($account_type == "academic_staff") echo "selected"; ?>>Tuesday</option>
        <option <?php if($account_type == "administrator") echo "selected"; ?>>Wednesday</option>
    </select>
    </div>
    </div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
    <label for="firstname">First name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter a first name">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="surname">Surname<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter a surname">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="gender">Gender - select below<span class="field-required">*</span></label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg gender <?php if($gender == "male") echo "active"; ?>">
		<input type="radio" name="options" id="option1" autocomplete="off"> Male
	</label>
	<label class="btn btn-default btn-lg gender <?php if($gender == "female") echo "active"; ?>">
		<input type="radio" name="options" id="option2" autocomplete="off"> Female
	</label>
	<label class="btn btn-default btn-lg gender <?php if($gender == "other") echo "active"; ?>">
		<input type="radio" name="options" id="option3" autocomplete="off"> Other
	</label>
	</div>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="studentno">Student number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Enter a student number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="degree">Programme of Study<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="degree" id="degree" value="<?php echo $degree; ?>" placeholder="Enter a programme of study">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="email">Email address<span class="field-required">*</span></label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter a email address">
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
	<input class="form-control" type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $dateofbirth; ?>" placeholder="Select the date of birth"/>
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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
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
	var account_type;
	var gender;
	var studentno;
    var degree;

	account_type = ($('.account_type.active').text().replace(/^\s+|\s+$/g,''));
	gender = ($('.gender.active').text().replace(/^\s+|\s+$/g,''));

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

	});

	$('.btn-group > .gender').click(function(){
		gender = ($(this).text().replace(/^\s+|\s+$/g,''))
	});

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

	var userid = $("#userid").val();

	var firstname = $("#firstname").val();
	if(firstname === '') {
        $("label[for='firstname']").empty().append("Please enter a first name.");
        $("label[for='firstname']").removeClass("feedback-happy");
        $("label[for='firstname']").addClass("feedback-sad");
        $("#firstname").removeClass("input-happy");
        $("#firstname").addClass("input-sad");
        $("#firstname").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='firstname']").empty().append("All good!");
        $("label[for='firstname']").removeClass("feedback-sad");
        $("label[for='firstname']").addClass("feedback-happy");
        $("#firstname").removeClass("input-sad");
        $("#firstname").addClass("input-happy");
	}

	var surname = $("#surname").val();
	if(surname === '') {
        $("label[for='surname']").empty().append("Please enter a surname.");
        $("label[for='surname']").removeClass("feedback-happy");
        $("label[for='surname']").addClass("feedback-sad");
        $("#surname").removeClass("input-happy");
        $("#surname").addClass("input-sad");
        $("#surname").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='surname']").empty().append("All good!");
        $("label[for='surname']").removeClass("feedback-sad");
        $("label[for='surname']").addClass("feedback-happy");
        $("#surname").removeClass("input-sad");
        $("#surname").addClass("input-happy");
	}

	if (account_type === 'Student') {
		studentno = $("#studentno").val();
		degree = $("#degree").val();

		if(studentno === '') {
            $("label[for='studentno']").empty().append("Please enter a student number.");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
		}
		if ($.isNumeric(studentno)) {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
            $("#error1").hide();
		} else {
			$("#error1").show();
			$("#error1").empty().append("The student number entered is invalid.<br>The student number must be numeric.");
            $("label[for='studentno']").empty().append("Wait a minute!");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		}
		if (studentno.length != 9) {
			$("#error1").show();
			$("#error1").empty().append("The student number entered is invalid.<br>The student number must exactly 9 digits in length.");
            $("label[for='studentno']").empty().append("Wait a minute!");
            $("label[for='studentno']").removeClass("feedback-happy");
            $("label[for='studentno']").addClass("feedback-sad");
            $("#studentno").removeClass("input-happy");
            $("#studentno").addClass("input-sad");
            $("#studentno").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='studentno']").empty().append("All good!");
            $("label[for='studentno']").removeClass("feedback-sad");
            $("label[for='studentno']").addClass("feedback-happy");
            $("#studentno").removeClass("input-sad");
            $("#studentno").addClass("input-happy");
            $("#error1").hide();
		}
		if(degree === '') {
            $("label[for='degree']").empty().append("Please enter a programme of study.");
            $("label[for='degree']").removeClass("feedback-happy");
            $("label[for='degree']").addClass("feedback-sad");
            $("#degree").removeClass("input-happy");
            $("#degree").addClass("input-sad");
            $("#degree").focus();
			hasError  = true;
			return false;
		} else {
            $("label[for='degree']").empty().append("All good!");
            $("label[for='degree']").removeClass("feedback-sad");
            $("label[for='degree']").addClass("feedback-happy");
            $("#degree").removeClass("input-sad");
            $("#degree").addClass("input-happy");
		}
	} else {
		studentno = $("#studentno").val();
		degree = $("#degree").val();
	}

	var email = $("#email").val();
	if(email === '') {
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

	var nationality = $("#nationality").val();
	var dateofbirth = $("#dateofbirth").val();
	var phonenumber = $("#phonenumber").val();
 	var address1 = $("#address1").val();
	var address2 = $("#address2").val();
	var town = $("#town").val();
	var city = $("#city").val();
	var country = $("#country").val();
	var postcode = $("#postcode").val();


	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'userid=' + userid + '&account_type1=' + account_type + '&firstname3=' + firstname + '&surname3=' + surname + '&gender3=' + gender + '&studentno1=' + studentno + '&degree1=' + degree + '&email6=' + email + '&nationality2=' + nationality + '&dateofbirth2=' + dateofbirth + '&phonenumber2=' + phonenumber + '&address12=' + address1 + '&address22=' + address2 + '&town2=' + town + '&city2=' + city + '&country2=' + country + '&postcode2=' + postcode,
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
