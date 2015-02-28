<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

    $lectureToFeedback = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT system_lectures.moduleid, system_lectures.lecture_name, user_signin.email, user_details.firstname, user_details.surname FROM system_lectures LEFT JOIN user_signin ON system_lectures.lecture_lecturer=user_signin.userid LEFT JOIN user_details ON system_lectures.lecture_lecturer=user_details.userid WHERE system_lectures.lectureid=?");
    $stmt1->bind_param('i', $lectureToFeedback);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $lecture_name, $feedback_to_email, $feedback_to_firstname, $feedback_to_surname);
    $stmt1->fetch();

    $stmt2 = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt2->bind_param('i', $session_userid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($feedback_from_email, $feedback_from_firstname, $feedback_from_surname);
    $stmt2->fetch();

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

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../feedback/">Feedback</a></li>
    <li class="active">Submit lecture feedback</li>
    </ol>

	<!-- Message user -->
    <form class="form-custom" style="max-width: 100%;" method="post" name="submitlecturefeedaback_form" id="submitlecturefeedaback_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
    <p id="error1" class="feedback-sad text-center"></p>
    <p id="success" class="feedback-happy text-center"></p>

    <div id="hide">
    <input type="hidden" name="feedback_moduleid" id="feedback_moduleid" value="<?php echo $moduleid; ?>">
    <input type="hidden" name="feedback_to_userid" id="feedback_to_userid" value="<?php echo $moduleid; ?>">

    <h4 class="text-center">Lecture</h4>
    <hr class="hr-custom">

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Name</label>
    <input class="form-control" type="text" name="lecture_name" id="lecture_name" value="<?php echo $lecture_name; ?>" readonly="readonly">
	</div>
    </div>

    <h4 class="text-center">Student</h4>
    <hr class="hr-custom">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="feedback_from_firstname" id="feedback_from_firstname" value="<?php echo $feedback_from_firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="feedback_from_surname" id="feedback_from_surname" value="<?php echo $feedback_from_surname; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="feedback_from_email" id="feedback_from_email" value="<?php echo $feedback_from_email; ?>" readonly="readonly">
	</div>
    </div>

    <h4 class="text-center">Lecturer</h4>
    <hr class="hr-custom">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="feedback_to_firstname" id="feedback_to_firstname" value="<?php echo $feedback_to_firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="feedback_to_surname" id="feedback_to_surname" value="<?php echo $feedback_to_surname; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0">
    <label>Email address</label>
    <input class="form-control" type="email" name="feedback_to_email" id="feedback_to_email" value="<?php echo $feedback_to_email; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Subject</label>
    <input class="form-control" type="text" name="feedback_subject" id="feedback_subject" value="<?php echo $lecture_name; ?> - Lecture - Feedback" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label for="feedback_body">Feedback<span class="field-required">*</span></label>
    <textarea class="form-control" rows="5" name="feedback_body" id="feedback_body"></textarea>
    </div>
    </div>

    <hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Submit feedback</span></button>
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

    var feedback_moduleid = $("#feedback_moduleid").val();
    var feedback_to_firstname = $("#feedback_to_firstname").val();
    var feedback_to_surname = $("#feedback_to_surname").val();
    var feedback_to_email = $("#feedback_to_email").val();

    var feedback_subject = $("#feedback_subject").val();

    var feedback_body = $("#feedback_body").val();
	if(feedback_body === '') {
        $("label[for='feedback_body']").empty().append("Please enter feedback.");
        $("label[for='feedback_body']").removeClass("feedback-happy");
        $("label[for='feedback_body']").addClass("feedback-sad");
        $("#feedback_body").removeClass("input-happy");
        $("#feedback_body").addClass("input-sad");
        $("#feedback_body").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='feedback_body']").empty().append("All good!");
        $("label[for='feedback_body']").removeClass("feedback-sad");
        $("label[for='feedback_body']").addClass("feedback-happy");
        $("#feedback_body").removeClass("input-sad");
        $("#feedback_body").addClass("input-happy");
	}
    if (feedback_body.length > 5000) {
        $("#error1").show();
        $("#error1").empty().append("The message entered is too long.<br>The maximum length of the message is 5000 characters.");
        $("#feedback_body").removeClass("input-happy");
        $("#feedback_body").addClass("input-sad");
        $("#feedback_body").focus();
        hasError  = true;
        return false;
    } else {
        $("#error1").hide();
        $("label[for='feedback_body']").empty().append("All good!");
        $("label[for='feedback_body']").removeClass("feedback-sad");
        $("label[for='feedback_body']").addClass("feedback-happy");
        $("#feedback_body").removeClass("input-sad");
        $("#feedback_body").addClass("input-happy");
    }

    if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'feedback_moduleid=' + feedback_moduleid + '&feedback_to_firstname=' + feedback_to_firstname + '&feedback_to_surname=' + feedback_to_surname + '&feedback_to_email=' + feedback_to_email + '&feedback_moduleid=' + feedback_moduleid + '&feedback_subject=' + feedback_subject + '&feedback_body=' + feedback_body,
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
