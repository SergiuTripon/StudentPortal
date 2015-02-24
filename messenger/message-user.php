<?php
include '../includes/session.php';

if (isset($_POST["recordToMessage"])) {

    $idToMessage = filter_input(INPUT_POST, 'recordToMessage', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($userid, $email1, $firstname1, $surname1);
    $stmt1->fetch();

    $stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $idToMessage);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($userid, $email2, $firstname2, $surname2);
    $stmt1->fetch();

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

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div id="messenger-portal" class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../messenger/">Messenger</a></li>
    <li class="active">Message a user</li>
    </ol>

	<!-- Message user -->
    <form class="form-custom" style="max-width: 100%;" method="post" name="messageuser_form" id="messageuser_form" novalidate>

    <p id="success" class="feedback-happy text-center"></p>
    <p id="error" class="feedback-sad text-center"></p>

    <div id="hide">
    <input type="hidden" name="userid2" id="userid2" value="<?php echo $userid2; ?>">

    <h4 class="text-center">From</h4>
    <hr class="hr-custom">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname1" id="firstname1" value="<?php echo $firstname1; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname1" id="surname1" value="<?php echo $surname1; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="email1" id="email1" value="<?php echo $email1; ?>" readonly="readonly">
	</div>
    </div>

    <h4 class="text-center">To</h4>
    <hr class="hr-custom">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname2" id="firstname2" value="<?php echo $firstname2; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname2" id="surname2" value="<?php echo $surname2; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="email2" id="email2" value="<?php echo $email2; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Subject</label>
    <input class="form-control" type="text" name="subject" id="subject">
	</div>
    </div>
    <p id="error1" class="feedback-sad text-center"></p>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Message</label>
    <textarea class="form-control" rows="5" name="message" id="message"></textarea>
    </div>
    </div>
    <p id="error2" class="feedback-sad text-center"></p>

    <hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Message user</span></button>
	</div>

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

    //Pay course fees form submit
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    var hasError = false;

    var subject = $("#subject").val();
	if(subject === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a subject.");
		$("#subject").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#subject").addClass("success-style");
	}
    if (subject.length > 300) {
        $("#error1").show();
        $("#error1").empty().append("The subject entered is too long.<br>The maximum length of the subject is 300 characters.");
        $("#subject").addClass("error-style");
        hasError  = true;
        return false;
    } else {
        $("#error1").hide();
        $("#subject").addClass("success-style");
    }

    var message = $("#message").val();
	if(message === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a message.");
		$("#message").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#message").addClass("success-style");
	}
    if (message.length > 5000) {
        $("#error2").show();
        $("#error2").empty().append("The message entered is too long.<br>The maximum length of the message is 5000 characters.");
        $("#message").addClass("error-style");
        hasError  = true;
        return false;
    } else {
        $("#error2").hide();
        $("#message").addClass("success-style");
    }


    var userid = $("#userid2").val();
    var firstname = $("#firstname2").val();
    var surname = $("#surname2").val();
    var email = $("#email2").val();

    if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'userid2=' + userid + '&firstname5=' + firstname + '&surname5=' + surname + '&email8=' + email + '&subject=' + subject + '&message1=' + message,
    success:function(){
        $("#error").hide();
        $("#hide").hide();
        $("#success").empty().append('Message sent successfully.');
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
