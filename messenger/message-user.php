<?php
include '../includes/session.php';

if (isset($_POST["recordToMessage"])) {

    $idToMessage = filter_input(INPUT_POST, 'recordToMessage', FILTER_SANITIZE_NUMBER_INT);

    $stmt1 = $mysqli->prepare("SELECT user_signin.email, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($email, $studentno, $firstname, $surname);
    $stmt1->fetch();

} else {
    header('Location: ../../messenger/');
}

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Message a user</title>

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
    <li class="active">Message a user</li>
    </ol>

	<!-- Message user -->
    <form class="form-custom" style="max-width: 100%;" method="post" name="messageuser_form" id="messageuser_form" novalidate>

    <p id="success" class="feedback-happy text-center"></p>
    <p id="error" class="feedback-sad text-center"></p>

    <div id="hide">
    <input type="hidden" name="bookid" id="bookid" value="<?php echo $bookid; ?>">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width pl0">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width pr0">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pl0">
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width pr0 pl0">
    <label>Message</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" readonly="readonly"></textarea>
    </div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Mesasge user</span></button>
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

    var bookid = $("#bookid").val();
    var book_name = $("#book_name").val();
    var book_author = $("#book_author").val();
    var book_notes = $("#book_notes").val();
    var bookreserved_from = $("#bookreserved_from").val();
    var bookreserved_to = $("#bookreserved_to").val();

    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'bookid=' + bookid + '&book_name=' + book_name + '&book_author=' + book_author + '&book_notes=' + book_notes + '&bookreserved_from=' + bookreserved_from + '&bookreserved_to=' + bookreserved_to,
    success:function(){
        $("#error").hide();
        $("#hide").hide();
        $("#success").empty().append('Book reserved successfully.');
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
