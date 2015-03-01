<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

    $eventToBook = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_from, event_to, event_amount FROM system_events WHERE eventid = ? LIMIT 1");
    $stmt1->bind_param('i', $eventToBook);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($eventid, $event_name, $event_from, $event_to, $event_amount);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.email, user_details.studentno, user_details.firstname, user_details.surname, user_details.gender, user_details.dateofbirth, user_details.phonenumber, user_details.degree, user_details.address1, user_details.address2, user_details.town, user_details.city, user_details.postcode FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt->bind_param('i', $session_userid);
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

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Book event</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../events/">Events</a></li>
    <li class="active">Book event</li>
    </ol>

	<!-- Book event -->
    <form class="form-custom" style="max-width: 100%;" action="https://student-portal.co.uk/includes/paypal/events_paypal_process.php?sandbox=1" method="post" name="bookevent_form" id="bookevent_form" novalidate>

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
    <label for="payer_address1">Address line 1<span class="field-required">*</span></label>
    <input class="form-control" name="payer_address1" id="payer_address1" value="<?php echo $address1; ?>" placeholder="Enter the first line of an address">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="payer_city">City<span class="field-required">*</span></label>
	<input class="form-control" name="payer_city" id="payer_city" value="<?php echo $city; ?>" placeholder="Enter a city">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Country</label>
    <input class="form-control" name="payer_country" id="payer_country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="payer_postcode">Post code<span class="field-required">*</span></label>
    <input class="form-control" name="payer_postcode" id="payer_postcode" value="<?php echo $postcode; ?>" placeholder="Enter a post code">
    </div>
    </div>

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
    <input class="form-control" type="text" name="ticket_price" id="ticket_price" value="<?php echo $event_amount; ?>" placeholder="Amount" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label for="product_quantity">Quantity<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="ticket_quantity" id="ticket_quantity" placeholder="Quantity">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Total to pay</label>
    <input class="form-control" type="text" name="product_amount" id="product_amount" placeholder="Total to pay" readonly="readonly">
	</div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Pay with PayPal</span></button>
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
        //Checks for empty values
        var payer_address1 = $("#payer_address1").val();
        if (payer_address1 === '') {
            $("#payer_address1").addClass("input-sad");
        }
        var payer_city = $("#payer_city").val();
        if (payer_city === '') {
            $("#payer_city").addClass("input-sad");
        }
        var payer_postcode = $("#payer_postcode").val();
        if (payer_postcode === '') {
            $("#payer_postcode").addClass("input-sad");
        }
        var product_quantity = $("#product_quantity").val();
        if (product_quantity === '') {
            $("#product_quantity").addClass("input-sad");
        }
    });

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    $('#product_quantity').keyup(function() {
        var quantity = $("#ticket_quantity").val();
        var iPrice = $("#ticket_price").val();

        var total = quantity * iPrice;
        $("#product_amount").val(total);
    });

    //Pay course fees form submit
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    var payer_address1 = $("#payer_address1").val();
	if (payer_address1 === '') {
        $("label[for='payer_address1']").empty().append("Please enter an address.");
        $("label[for='payer_address1']").removeClass("feedback-happy");
        $("#payer_address1").removeClass("input-happy");
        $("label[for='payer_address1']").addClass("feedback-sad");
        $("#payer_address1").addClass("input-sad");
        $("#payer_address1").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='payer_address1']").empty().append("All good!");
        $("label[for='payer_address1']").removeClass("feedback-sad");
        $("#payer_address1").removeClass("input-sad");
        $("label[for='payer_address1']").addClass("feedback-happy");
        $("#payer_address1").addClass("input-happy");
	}

    var payer_city = $("#payer_city").val();
    if(payer_city === '') {
        $("label[for='payer_city']").empty().append("Please enter a city.");
        $("label[for='payer_city']").removeClass("feedback-happy");
        $("#payer_city").removeClass("input-happy");
        $("label[for='payer_city']").addClass("feedback-sad");
        $("#payer_city").addClass("input-sad");
        $("#payer_city").focus();
		hasError  = true;
        return false;
    } else {
        $("label[for='payer_city']").empty().append("All good!");
        $("label[for='payer_city']").removeClass("feedback-sad");
        $("#payer_city").removeClass("input-sad");
        $("label[for='payer_city']").addClass("feedback-happy");
        $("#payer_city").addClass("input-happy");
	}

    var payer_postcode = $("#payer_postcode").val();
	if(payer_postcode === '') {
        $("label[for='payer_postcode']").empty().append("Please enter a postcode.");
        $("label[for='payer_postcode']").removeClass("feedback-happy");
        $("#payer_postcode").removeClass("input-happy");
        $("label[for='payer_postcode']").addClass("feedback-sad");
        $("#payer_postcode").addClass("input-sad");
        $("#payer_postcode").focus();
		hasError  = true;
        return false;
    } else {
        $("label[for='payer_postcode']").empty().append("All good!");
        $("label[for='payer_postcode']").removeClass("feedback-sad");
        $("#payer_postcode").removeClass("input-sad");
        $("label[for='payer_postcode']").addClass("feedback-happy");
        $("#payer_postcode").addClass("input-happy");
	}

    var product_quantity = $("#product_quantity").val();
    if(product_quantity === '') {
        $("label[for='product_quantity']").empty().append("Please enter a quantity.");
        $("label[for='product_quantity']").removeClass("feedback-happy");
        $("#product_quantity").removeClass("input-happy");
        $("label[for='product_quantity']").addClass("feedback-sad");
        $("#payer_postcode").addClass("input-sad");
        $("#payer_postcode").focus();
        hasError  = true;
        return false;
    } else {
        $("label[for='product_quantity']").empty().append("All good!");
        $("label[for='product_quantity']").removeClass("feedback-sad");
        $("#product_quantity").removeClass("input-sad");
        $("label[for='product_quantity']").addClass("feedback-happy");
        $("#product_quantity").addClass("input-happy");
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
            $("#bookevent_form").submit();
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
	</script>

</body>
</html>
