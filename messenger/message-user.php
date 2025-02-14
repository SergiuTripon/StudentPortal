<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET["id"])) {

    $idToMessage = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($message_from_email, $message_from_firstname, $message_from_surname);
    $stmt1->fetch();

    $stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToMessage);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($message_to_userid, $message_to_email, $message_to_firstname, $message_to_surname);
    $stmt1->fetch();

//If URL parameter is not set, do the following
} else {
    header('Location: ../../messenger/');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Message a user</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div id="messenger-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../messenger/">Messenger</a></li>
    <li class="active">Send a message</li>
    </ol>

	<!-- Message user -->
    <form class="form-horizontal form-custom" style="max-width: 100%;" method="post" name="messageuser_form" id="messageuser_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
    <p id="error1" class="feedback-danger text-center"></p>
    <p id="success" class="feedback-success text-center"></p>

    <div id="hide">
    <input type="hidden" name="message_to_userid" id="message_to_userid" value="<?php echo $message_to_userid; ?>">

    <h4 class="text-center title-separator">From</h4>
    <hr class="hr-custom hr-separator">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="message_from_firstname" id="message_from_firstname" value="<?php echo $message_from_firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="message_from_surname" id="message_from_surname" value="<?php echo $message_from_surname; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="message_from_email" id="message_from_email" value="<?php echo $message_from_email; ?>" readonly="readonly">
	</div>
    </div>

    <h4 class="text-center title-separator">To</h4>
    <hr class="hr-custom hr-separator">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="message_to_firstname" id="message_to_firstname" value="<?php echo $message_to_firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="message_to_surname" id="message_to_surname" value="<?php echo $message_to_surname; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="message_to_email" id="message_to_email" value="<?php echo $message_to_email; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="message_subject">Subject<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="message_subject" id="message_subject">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="message_body">Message<span class="field-required">*</span></label>
    <textarea class="form-control" rows="5" name="message_body" id="message_body"></textarea>
    </div>
    </div>

    <hr>

    <div class="text-center">
    <a id="FormSubmit" class="btn btn-primary btn-lg btn-load">Message user</a>
	</div>

    </div>

    </form>
    <!-- End of Book event -->

    </div><!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>

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
    <a class="btn btn-primary btn-lg" href="/">Sign in</a>
	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Send message process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    var hasError = false;

    //Checking if message_subject is inputted
    var message_subject = $("#message_subject").val();
	if(message_subject === '') {
        $("label[for='message_subject']").empty().append("Please enter a subject.");
        $("label[for='message_subject']").removeClass("feedback-success");
        $("label[for='message_subject']").addClass("feedback-danger");
        $("#message_subject").removeClass("input-success");
        $("#message_subject").addClass("input-danger");
        $("#message_subject").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='message_subject']").empty().append("All good!");
        $("label[for='message_subject']").removeClass("feedback-danger");
        $("label[for='message_subject']").addClass("feedback-success");
        $("#message_subject").removeClass("input-danger");
        $("#message_subject").addClass("input-success");
	}
    //Checking if message_subject is more than 300 characters long
    if (message_subject.length > 300) {
        $("#error1").show();
        $("#error1").empty().append("The subject entered is too long.<br>The maximum length of the subject is 300 characters.");
        $("label[for='message_subject']").empty().append("Wait a minute!");
        $("label[for='message_subject']").removeClass("feedback-success");
        $("label[for='message_subject']").addClass("feedback-danger");
        $("#message_subject").removeClass("input-success");
        $("#message_subject").addClass("input-danger");
        $("#message_subject").focus();
        hasError  = true;
        return false;
    } else {
        $("label[for='message_subject']").empty().append("All good!");
        $("label[for='message_subject']").removeClass("feedback-danger");
        $("label[for='message_subject']").addClass("feedback-success");
        $("#message_subject").removeClass("input-danger");
        $("#message_subject").addClass("input-success");
    }

    //Checking if message_body is inputted
    var message_body = $("#message_body").val();
	if(message_body === '') {
        $("label[for='message_body']").empty().append("Please enter a message.");
        $("label[for='message_body']").removeClass("feedback-success");
        $("label[for='message_body']").addClass("feedback-danger");
        $("#message_body").removeClass("input-success");
        $("#message_body").addClass("input-danger");
        $("#message_body").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='message_body']").empty().append("All good!");
        $("label[for='message_body']").removeClass("feedback-danger");
        $("label[for='message_body']").addClass("feedback-success");
        $("#message_body").removeClass("input-danger");
        $("#message_body").addClass("input-success");
	}

    //Checking if message_body is more than 10000 characters long
    if (message_body.length > 10000) {
        $("#error1").show();
        $("#error1").empty().append("The message entered is too long.<br>The maximum length of the message is 5000 characters.");
        $("label[for='message_body']").empty().append("Wait a minute!");
        $("label[for='message_body']").removeClass("feedback-success");
        $("label[for='message_body']").addClass("feedback-danger");
        $("#message_body").removeClass("input-success");
        $("#message_body").addClass("input-danger");
        $("#message_body").focus();
        hasError  = true;
        return false;
    } else {
        $("label[for='message_body']").empty().append("All good!");
        $("label[for='message_body']").removeClass("feedback-danger");
        $("label[for='message_body']").addClass("feedback-success");
        $("#message_body").removeClass("input-danger");
        $("#message_body").addClass("input-success");
    }

    var message_to_userid = $("#message_to_userid").val();
    var message_to_firstname = $("#message_to_firstname").val();
    var message_to_surname = $("#message_to_surname").val();
    var message_to_email = $("#message_to_email").val();

    //If there are no errors, initialize the Ajax call
    if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'message_to_userid=' + message_to_userid + '&message_to_firstname=' + message_to_firstname + '&message_to_surname=' + message_to_surname + '&message_to_email=' + message_to_email + '&message_subject=' + message_subject + '&message_body=' + message_body,

    //If action completed, do the following
    success:function(){
        $("#error").hide();
        $("#hide").hide();
        $("#success").empty().append('All done! Message has been sent.');
    },

    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError){
        buttonReset();
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
