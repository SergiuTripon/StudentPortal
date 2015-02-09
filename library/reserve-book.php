<?php
include '../includes/session.php';

if (isset($_POST["recordToReserve"])) {

    $idToReserve = filter_input(INPUT_POST, 'recordToReserve', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT book_name, book_author, book_notes FROM system_books WHERE bookid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToReserve);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($book_name, $book_author, $book_notes);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.email, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email, $studentno, $firstname, $surname);
    $stmt->fetch();

    $bookreserved_from = date("Y-m-d");

    $add10days = new DateTime($bookreserved_from);
    $add10days->add(new DateInterval('P10D'));
    $bookreserved_to = $add10days->format('Y-m-d');

} else {
    header('Location: ../../library/');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Reserve book</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Reserve a book</li>
    </ol>

	<!-- Book event -->
    <form class="form-custom" style="max-width: 100%;" method="post" name="reservebook_form" id="reservebook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter a first name" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter a surname" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter an email address" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Enter a student number" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Name</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $book_name; ?>" placeholder="Name" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Author</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $book_author; ?>" placeholder="Name" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Notes</label>
    <input class="form-control" type="text" name="product_name" id="product_name" value="<?php echo $book_notes; ?>" placeholder="Name" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>From</label>
    <input class="form-control" type="text" name="event_from" id="event_from" value="<?php echo $bookreserved_from; ?>" placeholder="From" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>To</label>
    <input class="form-control" type="text" name="event_to" id="event_to" value="<?php echo $bookreserved_to; ?>" placeholder="To" readonly="readonly">
    </div>
    </div>

    <p id="error3" class="feedback-sad text-center"></p>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mr5" data-style="slide-up"><span class="ladda-label">Reserve book</span></button>
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
