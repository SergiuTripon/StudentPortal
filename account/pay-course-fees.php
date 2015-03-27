<?php
include '../includes/session.php';

$stmt = $mysqli->prepare("SELECT s.email, d.studentno, d.firstname, d.surname, d.gender, d.dateofbirth, d.phonenumber, d.degree, d.address1, d.address2, d.town, d.city, d.postcode, f.fee_amount FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid LEFT JOIN user_fee f ON s.userid=f.userid WHERE s.userid = ? LIMIT 1");
$stmt->bind_param('i', $session_userid);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($email, $studentno, $firstname, $surname, $gender, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $postcode, $fee_amount);
$stmt->fetch();


if ($fee_amount == "0.00") {
    $fee_title = 'Nothing to pay';
    $conditional_style = "<style> #product_name-hide { display: none !important; } .btn-primary { display: none !important; }</style>";
    $conditional_script = "$('#payer_address1').prop('readonly', true);";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Pay Course Fees</title>

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <?php
    if (!empty($conditional_style)) {
        echo $conditional_style;
    }
    ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Pay course fees</li>
    </ol>
	
	<!-- Pay course fees -->
    <form class="form-custom" style="max-width: 100%;" action="https://student-portal.co.uk/includes/paypal/fees_paypal_process.php?sandbox=1" method="post" name="paycoursefees_form" id="paycoursefees_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>

	<!-- Hidden fields -->
    <input type="hidden" name="initial_fee_amount" id="initial_fee_amount" value="<?php echo $fee_amount; ?>">

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
    <label for="payer_address1">Address line 1<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="payer_address1" id="payer_address1" value="<?php echo $address1; ?>" placeholder="Address 1">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="payer_city">City<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="payer_city" id="payer_city" value="<?php echo $city; ?>" placeholder="City">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="payer_country" id="payer_country" value="United Kingdom" placeholder="Country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="payer_postcode">Post code<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="payer_postcode" id="payer_postcode" value="<?php echo $postcode; ?>" placeholder="Post Code">
    </div>
    </div>

	<div id="product_name-hide" class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="product_name">Pay half or the full fee amount<span class="field-required">*</span></label>
    <select class="form-control" name="product_name" id="product_name" style="width: 100%;">
        <?php
        $stmt1 = $mysqli->query("SELECT isHalf FROM user_fee WHERE userid='$session_userid'");

        while ($row = $stmt1->fetch_assoc()){

            $isHalf = $row["isHalf"];

            if ($isHalf === 1) {
                echo '<option selected>Half fees</option>';
            } else {
                echo '<option></option>';
                echo '<option>Full fees</option>';
                echo '<option>Half fees</option>';
            }
        }

        ?>
    </select>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
        <label>Amount due (&pound;)</label>
        <input class="form-control" type="text" name="product_amount" id="product_amount" value="<?php echo $fee_amount; ?>" placeholder="Amount" readonly="readonly">
    </div>
    </div>

    <div class="form-group">

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-success btn-lg ladda-button" href="/overview" data-style="slide-up"><span class="ladda-label">Back to Home</span></a>
    </div>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Pay with PayPal</span></button>
	</div>

    </form>
    <!-- End of Pay course fees -->
	
    </div><!-- /container -->
	
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
    <?php include '../assets/js-paths/select2-js-path.php'; ?>
	
	<script>
    //On load
    $(document).ready(function () {
        //select2
        $("#product_name").select2({placeholder: "Select an option"});
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    var fee_type;
    var fee_amount;
    var new_fee_amount;

    $('#product_name').on("change", function (e) {
        var fee_type = $('#product_name :selected').html();

        if(fee_type === 'Half fees') {
            fee_amount = $('#initial_fee_amount').val();
            new_fee_amount = fee_amount / 2;
            $('#product_amount').val(new_fee_amount.toFixed(2));
        } else {
            fee_amount = $('#initial_fee_amount').val();
            $('#product_amount').val(fee_amount);
        }
    });

    //Pay course fees form submit
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var payer_address1 = $('#payer_address1').val();
	if (payer_address1 === '') {
        $("label[for='payer_address1']").empty().append("Please enter the first line of an address.");
        $("label[for='payer_address1']").removeClass("feedback-happy");
        $("label[for='payer_address1']").addClass("feedback-sad");
        $("#payer_address1").focus();
		hasError  = true;
		return false;
	} else {
        $("label[for='payer_address1']").empty().append("All good!");
        $("label[for='payer_address1']").removeClass("feedback-sad");
        $("label[for='payer_address1']").addClass("feedback-happy");
	}

    var payer_city = $("#payer_city").val();
	if(payer_city === '') {
        $("label[for='payer_city']").empty().append("Please enter a city.");
        $("label[for='payer_city']").removeClass("feedback-happy");
        $("label[for='payer_city']").addClass("feedback-sad");
        $("#payer_city").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='payer_city']").empty().append("All good!");
        $("label[for='payer_city']").removeClass("feedback-sad");
        $("label[for='payer_city']").addClass("feedback-happy");
	}

    var payer_postcode = $("#payer_postcode").val();
	if(payer_postcode === '') {
        $("label[for='payer_postcode']").empty().append("Please enter a postcode.");
        $("label[for='payer_postcode']").removeClass("feedback-happy");
        $("label[for='payer_postcode']").addClass("feedback-sad");
        $("#payer_city").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='payer_postcode']").empty().append("All good!");
        $("label[for='payer_postcode']").removeClass("feedback-sad");
        $("label[for='payer_postcode']").addClass("feedback-happy");
	}

    var fee_type_check = $('#product_name :selected').html();
    if (fee_type_check === '') {
        $("label[for='product_name']").empty().append("Please select an option.");
        $("label[for='product_name']").removeClass("feedback-happy");
        $("label[for='product_name']").addClass("feedback-sad");
        $("[aria-owns='select2-product_name-results']").removeClass("input-happy");
        $("[aria-owns='select2-product_name-results']").addClass("input-sad");
        $("[aria-owns='select2-product_name-results']").focus();
        hasError  = true;
        return false;
    }
    else {
        $("label[for='product_name']").empty().append("All good!");
        $("label[for='product_name']").removeClass("feedback-sad");
        $("label[for='product_name']").addClass("feedback-happy");
        $("[aria-owns='select2-product_name-results']").removeClass("input-sad");
        $("[aria-owns='select2-product_name-results']").addClass("input-happy");
    }
	
	if(hasError == false) {
    	$("#paycoursefees_form").submit();
    }
	
	return true;
	
	});
	</script>
	
</body>
</html>
