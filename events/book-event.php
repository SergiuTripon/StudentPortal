<?php
include '../includes/session.php';

if (isset($_POST["recordToBook"])) {

    $idToBook = filter_input(INPUT_POST, 'recordToBook', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_from, event_to, event_amount FROM system_events WHERE eventid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToBook);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($eventid, $event_name, $event_from, $event_to, $event_amount);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.email, user_details.studentno, user_details.firstname, user_details.surname, user_details.gender, user_details.dateofbirth, user_details.phonenumber, user_details.degree, user_details.address1, user_details.address2, user_details.town, user_details.city, user_details.postcode FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email, $studentno, $firstname, $surname, $gender, $dateofbirth, $phonenumber, $degree, $address1, $address2, $town, $city, $postcode);
    $stmt->fetch();

} else {
    header('Location: ../../events/');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Book event</title>

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
	<li><a href="../../events/">Events</a></li>
    <li class="active">Book event</li>
    </ol>

	<!-- Book event -->
    <form class="form-custom" style="max-width: 100%;" action="https://student-portal.co.uk/includes/events_paypal_process.php?sandbox=1" method="post" name="paycoursefees_form" id="paycoursefees_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>

	<!-- Hidden fields -->
    <input type="hidden" name="payment" id="payment" value="process"/>
    <input type="hidden" name="product_id" id="product_id" value="<?php echo $eventid; ?>">
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
    <label>Address line 1</label>
    <input class="form-control" name="payer_address1" id="payer_address1" value="<?php echo $address1; ?>" placeholder="Enter the first line of an address">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>City</label>
	<input class="form-control" name="payer_city" id="payer_city" value="<?php echo $city; ?>" placeholder="Enter a city">
    </div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country</label>
    <input class="form-control" name="payer_country" id="payer_country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Post code</label>
    <input class="form-control" name="payer_postcode" id="payer_postcode" value="<?php echo $postcode; ?>" placeholder="Enter a post code">
    </div>
    </div>
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Name</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $event_name; ?>" placeholder="Name" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>From</label>
    <input class="form-control" type="text" name="event_from" id="event_from" value="<?php echo $event_from; ?>" placeholder="From" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>To</label>
    <input class="form-control" type="text" name="event_to" id="event_to" value="<?php echo $event_to; ?>" placeholder="To" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Price (&pound;)</label>
    <input class="form-control" type="text" name="product_amount" id="product_amount" value="<?php echo $event_amount; ?>" placeholder="Amount" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Quantity</label>
    <input class="form-control" type="text" name="product_quantity" id="product_quantity" placeholder="Quantity">
    </div>
    </div>
    <p id="error3" class="feedback-sad text-center"></p>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mr5" data-style="slide-up"><span class="ladda-label">Pay with PayPal</span></button>
	</div>

    </form>
    <!-- End of Book event -->

    </div><!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

	<div class="container">

	<form class="form-custom">

    <div class="form-logo">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedbac-sad text-center">You need to have a student account to access this area.</p>

    <hr>

    <div class="text-center">
    <a class="btn btn-orange btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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

    //Checks for empty values
    var payer_address1 = $("#payer_firstname").val();
	if(payer_address1 === '') { $("#payer_firstname").css("border-color", "#FF5454"); }
    var payer_city = $("#payer_city").val();
	if(payer_city === '') { $("#payer_city").css("border-color", "#FF5454"); }
    var payer_postcode = $("#payer_postcode").val();
	if(payer_postcode === '') { $("#payer_postcode").css("border-color", "#FF5454"); }
    var product_quantity = $("#product_quantity").val();
    if(product_quantity === '') { $("#product_quantity").css("border-color", "#FF5454"); }

    //Pay course fees form submit
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    var payer_address1 = $("#payer_address1").val();
	if (payer_address1 === '') {
        $("#error1").show();
        $("#error1").empty().append("Please enter the first line of an address.");
		$("#payer_address1").css("border-color", "#FF5454");
		hasError  = true;
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
    } else {
		$("#error2").hide();
		$("#payer_postcode").css("border-color", "#4DC742");
	}

    var product_quantity = $("#product_quantity").val();
    if(product_quantity === '') {
        $("#error3").show();
        $("#error3").empty().append("Please enter a quantity.");
        $("#product_quantity").css("border-color", "#FF5454");
        hasError  = true;
    } else {
        $("#error3").hide();
        $("#product_quantity").css("border-color", "#4DC742");
    }

    var eventid = $("#product_id").val();

    if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'eventid=' + eventid + '&product_quantity=' + product_quantity,
    success:function(msg){
        if (msg == 'error') {
            $("#error").empty().append("The quantity entered exceeds the amount of tickets available.<br>You can check the ticket availability on the Events page.");
        } else {
            $("#paycoursefees_form").submit();
        }
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
