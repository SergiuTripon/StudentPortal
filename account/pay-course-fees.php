<?php
include '../includes/session.php';

$stmt = $mysqli->prepare("SELECT user_signin.email, user_details.studentno, user_details.firstname, user_details.surname, user_details.gender, user_details.dateofbirth, user_details.phonenumber, user_details.degree, user_details.address1, user_details.address2, user_details.town, user_details.city, user_details.postcode, user_fees.fee_amount FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid LEFT JOIN user_fees ON user_signin.userid=user_fees.userid WHERE user_signin.userid = ? LIMIT 1");
$stmt->bind_param('i', $session_userid);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($email, $studentno, $firstname, $surname, $gender, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $postcode, $fee_amount);
$stmt->fetch();

if ($fee_amount == "9000.00") {
    $fee_title = 'Full Fees';
}

if ($fee_amount == "4500.00") {
    $fee_title = 'Half Fees';
    $conditional_style = "<style> .checkbox { display: none !important; }</style>";
}

if ($fee_amount == "0.00") {
    $fee_title = 'Nothing to pay';
    $conditional_style = "<style> .checkbox { display: none !important; } .btn-custom { display: none !important; }</style>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Pay Course Fees</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Pay course fees</li>
    </ol>
	
	<!-- Pay course fees -->
    <form class="form-custom" style="max-width: 100%;" action="https://student-portal.co.uk/includes/paypal/fees_paypal_process.php?sandbox=1" method="post" name="paycoursefees_form" id="paycoursefees_form" novalidate>

    <?php
    if (!empty($conditional_style)) {
		echo $conditional_style;
    }
    ?>

    <p id="error" class="feedback-sad text-center"></p>

	<!-- Hidden fields -->
	<input type="hidden" name="payment" value="process"/>
    <input type="hidden" name="product_id" id="product_id" value="1">
    <input type="hidden" name="product_quantity" id="product_quantity" value="1">
    <input type="hidden" name="payer_email" id="payer_email" value="<?php echo $email; ?>">
    <input type="hidden" name="payer_phonenumber" id="payer_phonenumber" value="<?php echo $phonenumber; ?>">
    <input type="hidden" name="payer_address2" id="payer_address2" value="<?php echo $address2; ?>">
	<input type="hidden" name="payer_town" id="payer_town" value="<?php echo $town; ?>">
	<!-- End of Hidden fields -->
	
    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First Name</label>
    <input class="form-control" type="text" name="payer_firstname" id="payer_firstname" value="<?php echo $firstname; ?>" placeholder="First Name" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Surname</label>
    <input class="form-control" type="text" name="payer_surname" id="payer_surname" value="<?php echo $surname; ?>" placeholder="Surname" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Half or Full fees</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $fee_title; ?>" placeholder="Product Name" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Amount due (&pound;)</label>
    <input class="form-control" type="text" name="product_amount" id="product_amount" value="<?php echo $fee_amount; ?>" placeholder="Amount" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Address line 1</label>
    <input class="form-control" name="payer_address1" id="payer_address1" value="<?php echo $address1; ?>" placeholder="Address 1">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>City</label>
	<input class="form-control" name="payer_city" id="payer_city" value="<?php echo $city; ?>" placeholder="City">
    </div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country</label>
    <input class="form-control" name="payer_country" id="payer_country" value="United Kingdom" placeholder="Country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Post code</label>
    <input class="form-control" name="payer_postcode" id="payer_postcode" value="<?php echo $postcode; ?>" placeholder="Post Code">
    </div>
    </div>
    <p id="error2" class="feedback-sad text-center"></p>

	<label>Pay half or the full fee amount - select below</label>
	<div class="btn-group btn-group-justified" data-toggle="buttons">
	<label class="btn btn-default btn-lg fees_type">
		<input type="radio" name="options" id="option1" autocomplete="off"> Full fees
	</label>
	<label class="btn btn-default btn-lg fees_type">
		<input type="radio" name="options" id="option2" autocomplete="off"> Half fees
	</label>
	</div>
    <p id="error3" class="feedback-sad text-center"></p>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mr5" data-style="slide-up"><span class="ladda-label">Pay with PayPal</span></button>
	</div>

    </form>
    <!-- End of Pay course fees -->
	
    </div><!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>
		
    <?php else : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">
               
	<form class="form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">You need to have a student account to access this area.</p>

    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
	
    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

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
	
	<script>
    $(document).ready(function () {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    var fees_type;

    //Setting variable value
	$('.btn-group > .fees_type').click(function(){
        fees_type = ($(this).text().replace(/^\s+|\s+$/g,''))

		if(fees_type === 'Full fees') {
            $('input[name=product_amount]').val('9000.00');
            $('input[name=product_name]').val('Full Fees');
		}
		if(fees_type === 'Half fees') {
            $('input[name=product_amount]').val('4500.00');
            $('input[name=product_name]').val('Half Fees');
		}

	})

    //Checks for empty values
    var val;
	val = $("#payer_firstname").val();
	if(val === '') { $("#payer_firstname").css("border-color", "#FF5454"); }
	val = $("#payer_surname").val();
	if(val === '') { $("#payer_surname").css("border-color", "#FF5454"); }
	val = $("#product_name").val();
	if(val === '') { $("#product_name").css("border-color", "#FF5454"); }
	val = $("#product_amount").val();
	if(val === '') { $("#product_amount").css("border-color", "#FF5454"); }
	val = $("#payer_address1").val();
	if(val === '') { $("#payer_address1").css("border-color", "#FF5454"); }
	val = $("#payer_city").val();
	if(val === '') { $("#payer_city").css("border-color", "#FF5454"); }
	val = $("#payer_postcode").val();
	if(val === '') { $("#payer_postcode").css("border-color", "#FF5454"); }

    //Pay course fees form submit
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var payer_address1 = $('#payer_address1').val();
	if (payer_address1 === '') {
        $("#error1").show();
        $("#error1").empty().append("Please enter the first line of an address.");
		$("#payer_address1").css("border-color", "#FF5454");
		hasError  = true;
		return false;
	} else {
		$("#error1").hide();
		$("#payer_address1").css("border-color", "#4DC742");
	}

    var payer_city = $("#payer_city").val();
	if(payer_city === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a city.");
		$("#payer_city").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#payer_city").css("border-color", "#4DC742");
	}

    var payer_postcode = $("#payer_postcode").val();
	if(payer_postcode === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a postcode.");
		$("#payer_postcode").css("border-color", "#FF5454");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#payer_postcode").css("border-color", "#4DC742");
	}

    var fees_type_check = $(".fees_type");
	if (fees_type_check.hasClass('active')) {
		$("#error3").hide();
		$(".btn-group > .fees_type").addClass("success-style");
	}
	else {
		$("#error3").empty().append("Please select how you want to pay your fees.");
		$(".btn-group > .fees_type").addClass("error-style");
		hasError  = true;
		return false;
	}
	
	if(hasError == false) {
	
	$("#paycoursefees_form").submit();
	
    }
	
	return true;
	
	});
	});
	</script>
	
</body>
</html>
