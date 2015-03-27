<?php
include '../includes/session.php';

$stmt1 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname, user_detail.gender, user_detail.nationality, user_detail.dateofbirth, user_detail.phonenumber, user_detail.address1, user_detail.address2, user_detail.town, user_detail.city, user_detail.postcode, user_fee.fee_amount FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid LEFT JOIN user_fee ON user_signin.userid=user_fee.userid WHERE user_signin.userid = ? LIMIT 1");
$stmt1->bind_param('i', $session_userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($email, $firstname, $surname, $gender, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $postcode, $fee_amount);
$stmt1->fetch();

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
	
    <title>Student Portal | Update Account</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
	<li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Update account</li>
    </ol>

	<!-- Update account -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updateaccount_form" novalidate>

	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter your first name">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter your surname">
    </div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Gender - select below</label>
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
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Email address</label>
    <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter a email address">
    </div>
    </div>
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Nationality</label>
    <input class="form-control" type="text" name="nationality" id="nationality" value="<?php echo $nationality; ?>" placeholder="Enter a country">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Date of Birth</label>
    <input type='text' class="form-control" type="text" name="dateofbirth" id="dateofbirth" data-date-format="YYYY-MM-DD" value="<?php echo $dateofbirth; ?>" placeholder="Select a date"/>
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Enter a phone number">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter the address line 1">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter the address line 2 (Optional)">
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

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update account</span></button>
    </div>

	</div>

    </form>

    </div> <!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>
	
	<?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

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
    $(document).ready(function() {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 1000});

    // Date Time Picker
	$(function () {
	$('#dateofbirth').datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(1993, 00, 01)
	});
	});

    //Checking if fields are empty
	var val;

    val = $("#gender").val();
	if(val === '') { $("#gender").addClass("input-sad"); }
	val = $("#firstname").val();
	if(val === '') { $("#firstname").addClass("input-sad"); }
	val = $("#surname").val();
	if(val === '') { $("#surname").addClass("input-sad"); }
	val = $("#email").val();
	if(val === '') { $("#email").addClass("input-sad"); }
    val = $("#nationality").val();
    if(val === '') { $("#nationality").addClass("input-sad"); }
    val = $("#dateofbirth").val();
    if(val === '') { $("#dateofbirth").addClass("input-sad"); }
	val = $("#phonenumber").val();
	if(val === '') { $("#phonenumber").addClass("input-sad"); }
	val = $("#address1").val();
	if(val === '') { $("#address1").addClass("input-sad"); }
	val = $("#address2").val();
	if(val === '') { $("#address2").addClass("input-sad"); }
	val = $("#town").val();
	if(val === '') { $("#town").addClass("input-sad"); }
	val = $("#city").val();
	if(val === '') { $("#city").addClass("input-sad"); }
	val = $("#country").val();
	if(val === '') { $("#country").addClass("input-sad"); }
	val = $("#postcode").val();
	if(val === '') { $("#postcode").addClass("input-sad"); }

    //Responsiveness
	$(window).resize(function(){
		var width = $(window).width();
		if(width <= 480){
			$('.btn-group').removeClass('btn-group-justified');
			$('.btn-group').addClass('btn-group-vertical full-width');
		} else {
			$('.btn-group').addClass('btn-group-justified');
		}
	}).resize();

    //Global variable
    var gender;

    gender = ($('.gender.active').text().replace(/^\s+|\s+$/g,''));

    //Setting variable value
    $('.btn-group .gender').click(function(){
        gender = ($(this).text().replace(/^\s+|\s+$/g,''))
    });

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var firstname = $("#firstname").val();
	if(firstname === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a first name.");
		$("#firstname").addClass("error-style");
		hasError  = true;
		return false;
	}
	
	var surname = $("#surname").val();
	if(surname === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a surname.");
		$("#surname").addClass("error-style");
		hasError  = true;
		return false;
	}

	var email = $("#email").val();
	if(email === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter an email address.");
		$("#email").addClass("error-style");
		hasError  = true;
		return false;
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
    data:'firstname1=' + firstname + '&surname1=' + surname + '&gender1=' + gender + '&email4=' + email + '&nationality=' + nationality + '&dateofbirth=' + dateofbirth + '&phonenumber=' + phonenumber + '&address1=' + address1 + '&address2=' + address2 + '&town=' + town + '&city=' + city + '&country=' + country + '&postcode=' + postcode,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").empty().append('Your personal details have been updated successfully.');
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

</body>
</html>

