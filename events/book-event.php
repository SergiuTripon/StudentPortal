<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

    $eventToBook = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT eventid, event_name, event_from, event_to, event_amount FROM system_event WHERE eventid = ? LIMIT 1");
    $stmt1->bind_param('i', $eventToBook);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($eventid, $event_name, $event_from, $event_to, $event_amount);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.email, user_detail.studentno, user_detail.firstname, user_detail.surname, user_detail.gender, user_detail.dateofbirth, user_detail.phonenumber, user_detail.degree, user_detail.address1, user_detail.address2, user_detail.town, user_detail.city, user_detail.postcode FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
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

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../events/">Events</a></li>
    <li class="active">Book event</li>
    </ol>

	<!-- Book event -->
    <form class="form-horizontal form-custom" style="max-width: 100%;" action="https://student-portal.co.uk/includes/paypal/events_paypal_process.php?sandbox=1" method="post" name="bookevent_form" id="bookevent_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>

	<!-- Hidden fields -->
    <input type="hidden" name="payment" id="payment" value="process"/>
    <input type="hidden" name="product_id" id="product_id" value="<?php echo $eventid; ?>">
    <input type="hidden" name="payer_email" id="payer_email" value="<?php echo $email; ?>">
    <input type="hidden" name="payer_phonenumber" id="payer_phonenumber" value="<?php echo $phonenumber; ?>">
    <input type="hidden" name="payer_address2" id="payer_address2" value="<?php echo $address2; ?>">
	<input type="hidden" name="payer_town" id="payer_town" value="<?php echo $town; ?>">
	<!-- End of Hidden fields -->

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>First Name</label>
    <input class="form-control" type="text" name="payer_firstname" id="payer_firstname" value="<?php echo $firstname; ?>" placeholder="First Name" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="payer_surname" id="payer_surname" value="<?php echo $surname; ?>" placeholder="Surname" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="payer_address1">Address line 1<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="payer_address1" id="payer_address1" value="<?php echo $address1; ?>" placeholder="Enter the first line of an address">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="payer_city">City<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="payer_city" id="payer_city" value="<?php echo $city; ?>" placeholder="Enter a city">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Country</label>
    <input class="form-control" type="text" name="payer_country" id="payer_country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="payer_postcode">Post code<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="payer_postcode" id="payer_postcode" value="<?php echo $postcode; ?>" placeholder="Enter a post code">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label>Name</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $event_name; ?>" placeholder="Name" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>From</label>
    <input class="form-control" type="text" name="event_from" id="event_from" value="<?php echo $event_from; ?>" placeholder="From" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>To</label>
    <input class="form-control" type="text" name="event_to" id="event_to" value="<?php echo $event_to; ?>" placeholder="To" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Price (&pound;)</label>
    <input class="form-control" type="text" name="product_amount" id="product_amount" value="<?php echo $event_amount; ?>" placeholder="Amount" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label for="product_quantity">Quantity<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="product_quantity" id="product_quantity" placeholder="Quantity">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label>Total to pay (&pound;)</label>
    <input class="form-control" type="text" name="total_to_pay" id="total_to_pay" placeholder="Total to pay" readonly="readonly">
	</div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="book-event-submit" class="btn btn-primary btn-lg btn-load">Pay with PayPal</button>
	</div>

    </form>
    <!-- End of Book event -->

    </div><!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    $('#product_quantity').keyup(function() {
        var quantity = $("#product_quantity").val();
        var iPrice = $("#product_amount").val();

        var total = quantity * iPrice;
        $("#total_to_pay").val(total.toFixed(2));
    });

    //Pay course fees form submit
    $("#book-event-submit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    var payer_address1 = $("#payer_address1").val();
	if (payer_address1 === '') {
        $("label[for='payer_address1']").empty().append("Please enter an address.");
        $("label[for='payer_address1']").removeClass("feedback-success");
        $("label[for='payer_address1']").addClass("feedback-danger");
        $("#payer_address1").removeClass("input-success");
        $("#payer_address1").addClass("input-danger");
        $("#payer_address1").focus();
		hasError  = true;
        return false;
	} else {
        $("label[for='payer_address1']").empty().append("All good!");
        $("label[for='payer_address1']").removeClass("feedback-danger");
        $("label[for='payer_address1']").addClass("feedback-success");
        $("#payer_address1").removeClass("input-danger");
        $("#payer_address1").addClass("input-success");
	}

    var payer_city = $("#payer_city").val();
    if(payer_city === '') {
        $("label[for='payer_city']").empty().append("Please enter a city.");
        $("label[for='payer_city']").removeClass("feedback-success");
        $("label[for='payer_city']").addClass("feedback-danger");
        $("#payer_city").removeClass("input-success");
        $("#payer_city").addClass("input-danger");
        $("#payer_city").focus();
		hasError  = true;
        return false;
    } else {
        $("label[for='payer_city']").empty().append("All good!");
        $("label[for='payer_city']").removeClass("feedback-danger");
        $("label[for='payer_city']").addClass("feedback-success");
        $("#payer_city").removeClass("input-danger");
        $("#payer_city").addClass("input-success");
	}

    var payer_postcode = $("#payer_postcode").val();
	if(payer_postcode === '') {
        $("label[for='payer_postcode']").empty().append("Please enter a postcode.");
        $("label[for='payer_postcode']").removeClass("feedback-success");
        $("label[for='payer_postcode']").addClass("feedback-danger");
        $("#payer_postcode").removeClass("input-success");
        $("#payer_postcode").addClass("input-danger");
        $("#payer_postcode").focus();
		hasError  = true;
        return false;
    } else {
        $("label[for='payer_postcode']").empty().append("All good!");
        $("label[for='payer_postcode']").removeClass("feedback-danger");
        $("label[for='payer_postcode']").addClass("feedback-success");
        $("#payer_postcode").removeClass("input-danger");
        $("#payer_postcode").addClass("input-success");
	}

    var product_quantity = $("#product_quantity").val();
    if(product_quantity === '') {
        $("label[for='product_quantity']").empty().append("Please enter a quantity.");
        $("label[for='product_quantity']").removeClass("feedback-success");
        $("label[for='product_quantity']").addClass("feedback-danger");
        $("#product_quantity").removeClass("input-success");
        $("#product_quantity").addClass("input-danger");
        $("#product_quantity").focus();
        hasError  = true;
        return false;
    } else {
        $("label[for='product_quantity']").empty().append("All good!");
        $("label[for='product_quantity']").removeClass("feedback-danger");
        $("label[for='product_quantity']").addClass("feedback-success");
        $("#product_quantity").removeClass("input-danger");
        $("#product_quantity").addClass("input-success");
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

    <?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

	<div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">You need to have a student account to access this area.</p>

    <hr>

    <div class="text-center">
    <a class="btn btn-orange btn-lg btn-load" href="/home/">Home</a>
    </div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
	<?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

</body>
</html>
