<?php
include 'includes/signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

$stmt1 = $mysqli->prepare("SELECT studentno, firstname, surname, gender, dateofbirth, phonenumber, degree, address1, address2, town, city, postcode FROM user_details WHERE userid = ? LIMIT 1");
$stmt1->bind_param('i', $userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($studentno, $firstname, $surname, $gender, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $postcode);
$stmt1->fetch();

$stmt2 = $mysqli->prepare("SELECT email FROM user_signin WHERE userid = ? LIMIT 1");
$stmt2->bind_param('i', $userid);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($email);
$stmt2->fetch();

$stmt3 = $mysqli->prepare("SELECT fee_amount FROM user_fees WHERE userid = ? LIMIT 1");
$stmt3->bind_param('i', $userid);
$stmt3->execute();
$stmt3->store_result();
$stmt3->bind_result($fee_amount);
$stmt3->fetch();

if ($dateofbirth == "0000-00-00") {
    $dateofbirth = '';
}

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
	
    <title>Student Portal | Update Account</title>

    <!-- Bootstrap CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- FontAwesome CSS -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">

    <!-- Ladda CSS -->
    <link rel="stylesheet" href="../assets/css/ladda-themeless.min.css">

    <!-- Bootstrap Date Picker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
    #gender {
		color: #FFA500;
		background-color: #333333;
	}
    </style>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <header class="intro">
    <div class="intro-body">
	
	<form class="form-custom">

    <div class="custom-logo animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="mt10 custom-hr">

    <p class="error text-center">You need to have a student or lecturer account to access this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/overview/"><span class="ladda-label">Overview</span></a>
	</div>

    </form>
	
	</div><!-- /intro-body -->
    </header>
	
    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

    <?php else : ?>

    <div class="container">

    <?php include 'includes/menus/portal_menu.php'; ?>

    <ol class="breadcrumb">
	<li><a href="../overview/">Overview</a></li>
	<li><a href="../account/">Account</a></li>
    <li class="active">Update account</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	
    <div class="panel panel-default">
    
	<div class="panel-heading" role="tab" id="headingOne">
	<h4 class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Update account</a>
	</h4>
    </div>
	
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

	<div class="panel-body">

	<!-- Update account -->
    <div class="content-panel mb10" style="border: none;">

	<form class="form-custom" style="max-width: 800px; padding-top: 0px;" name="updateaccount_form" novalidate>
	
	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>
	
	<div class="form-group">

    <div class="col-xs-12 col-sm-12 full-width">
    <label>Gender</label>
    <select class="form-control" name="gender" id="gender">
    <option <?php if($gender == "Male") echo "selected=selected"; ?> class="others">Male</option>
    <option <?php if($gender == "Female") echo "selected=selected"; ?> class="others">Female</option>
    <option <?php if($gender == "Other") echo "selected=selected"; ?> class="others">Other</option>
    </select>
    </div>
	
    </div>

    <div class="form-group">

    <div class="col-xs-6 col-sm-6 full-width">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter your first name">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter your surname">
	<label>Date of Birth (YYYY-MM-DD)</label>
    <input type='text' class="form-control" type="text" name="dateofbirth" id="datepicker1" data-date-format="YYYY-MM-DD" value="<?php echo $dateofbirth; ?>" placeholder="Select your date of birth"/>
	<label>Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Enter your student number" disabled="disabled">
    <label>Email address</label>
    <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter your email address">
	<label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Enter your phone number">
	</div>

    <div class="col-xs-6 col-sm-6 full-width">
	<label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter your address line 1">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter your address line 2 (Optional)">
	<label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="<?php echo $town; ?>" placeholder="Enter your town">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="Enter your city">
    <label>Country</label>
	<input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter your country" readonly="readonly">
	<label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" placeholder="Enter your postcode">
	</div>

    </div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Programme of Study</label>
    <input class="form-control" type="text" name="degree" id="degree" value="<?php echo $degree; ?>" placeholder="Enter your programme of study">
	</div>
	</div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10 mr5" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Update</span></button>
    </div>

    </form>

    </div><!-- /content-panel -->
    <!-- End of Update account -->

    </div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
    </div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div> <!-- /container -->

	<?php include 'includes/footers/portal_footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>
	
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

	<!-- JS library -->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Bootstrap JS -->
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Bootstrap Date Picker JS -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="../assets/js/bootstrap-datetimepicker.js"></script>

	<script>
    $(function () {
        $('#datepicker1').datetimepicker({
            pickTime: false
        });
    });
	</script>

	<!-- tileJS -->
	<script src="../assets/js/tileJs.min.js"></script>

	<!-- Spin JS -->
	<script src="../assets/js/spin.min.js"></script>

	<!-- Ladda JS -->
	<script src="../assets/js/ladda.min.js"></script>
	
	<!-- Pace JS -->
    <script src="../assets/js/pace.js"></script>

	<!-- Custom JS -->
	<script src="../assets/js/custom.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

	<script>
    // Bind normal buttons
    Ladda.bind('.ladda-button', {timeout: 1000});
	</script>
	
	<script>
	val = $("#gender").val();
	if(val === '') { $("#gender").css("border-color", "#FF5454"); }
	val = $("#firstname").val();
	if(val === '') { $("#firstname").css("border-color", "#FF5454"); }
	val = $("#surname").val();
	if(val === '') { $("#surname").css("border-color", "#FF5454"); }
	val = $("#datepicker1").val();
	if(val === '') { $("#datepicker1").css("border-color", "#FF5454"); }
	val = $("#email").val();
	if(val === '') { $("#email").css("border-color", "#FF5454"); }
	val = $("#phonenumber").val();
	if(val === '') { $("#phonenumber").css("border-color", "#FF5454"); }
	val = $("#address1").val();
	if(val === '') { $("#address1").css("border-color", "#FF5454"); }
	val = $("#address2").val();
	if(val === '') { $("#address2").css("border-color", "#FF5454"); }
	val = $("#town").val();
	if(val === '') { $("#town").css("border-color", "#FF5454"); }
	val = $("#city").val();
	if(val === '') { $("#city").css("border-color", "#FF5454"); }
	val = $("#country").val();
	if(val === '') { $("#country").css("border-color", "#FF5454"); }
	val = $("#postcode").val();
	if(val === '') { $("#postcode").css("border-color", "#FF5454"); }
	val = $("#degree").val();
	if(val === '') { $("#degree").css("border-color", "#FF5454"); }
	</script>
	
	<script>
	$(document).ready(function() {
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	gender = $("#gender").val();
	
	firstname = $("#firstname").val();
	if(firstname === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a first name.");
		$("#firstname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	surname = $("#surname").val();
	if(surname === '') {
		$("#error").show();
        $("#error").empty().append("Please enter a surname.");
		$("#surname").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	studentno = $("#studentno").val();
	email = $("#email").val();
	if(email === '') {
		$("#error").show();
        $("#error").empty().append("Please enter an email address.");
		$("#email").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	}
	
	dateofbirth = $("#datepicker1").val();
	if(dateofbirth === '') {
		dateofbirth = null;
	}
	
	phonenumber = $("#phonenumber").val();
	address1 = $("#address1").val();
	address2 = $("#address2").val();
	town = $("#town").val();
	city = $("#city").val();
	country = $("#country").val();
	postcode = $("#postcode").val();
	degree = $("#degree").val();
	
    jQuery.ajax({
	type: "POST",
	url: "http://test.student-portal.co.uk/includes/account_process.php",
    data:'gender=' + gender + '&firstname=' + firstname + '&surname=' + surname + '&dateofbirth=' + dateofbirth + '&studentno=' + studentno + '&email=' + email + '&phonenumber=' + phonenumber + '&address1=' + address1 + '&address2=' + address2 + '&town=' + town + '&city=' + city + '&country=' + country + '&postcode=' + postcode + '&degree=' + degree,
    success:function(response){
		$("#error").hide();
		$("#success").empty().append('Your personal details have been updated successfully. You can review them below:');
    },
    error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
	
	return true;
	
	});
	});
	</script>

</body>
</html>

