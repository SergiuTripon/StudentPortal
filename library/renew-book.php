<?php
include '../includes/session.php';

global $mysqli;
global $session_userid;

if (isset($_GET["id"])) {

    $bookToRenew = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes FROM system_book WHERE bookid = ? LIMIT 1");
    $stmt1->bind_param('i', $bookToRenew);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes);
    $stmt1->fetch();
    $stmt1->close();

    $stmt1 = $mysqli->prepare("SELECT DATE_FORMAT(toreturn_on,'%d-%m-%Y') as toreturn_on FROM system_book_loaned WHERE bookid=? AND userid=? ORDER BY loanid DESC LIMIT 1");
    $stmt1->bind_param('ii', $bookToRenew, $session_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($toreturn_on);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_detail.studentno, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt->bind_param('i', $session_userid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid, $email, $studentno, $firstname, $surname);
    $stmt->fetch();

    $toreturn_on_old = DateTime::createFromFormat('d-m-Y', $toreturn_on);
    $toreturn_on_old = $toreturn_on_old->format('d/m/Y');

    $add14days = new DateTime($toreturn_on);
    $add14days->add(new DateInterval('P14D'));
    $toreturn_on_new = $add14days->format('d/m/Y');

} else {
    header('Location: ../../library/');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Renew book</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Renew book</li>
    </ol>

	<!-- Renew book -->
    <form class="form-horizontal form-custom" style="max-width: 100%;" method="post" name="renewbook_form" id="renewbook_form" novalidate>

    <p id="success" class="feedback-happy text-center"></p>
    <p id="error" class="feedback-sad text-center"></p>

    <div id="hide">
    <input type="hidden" name="bookid" id="bookid" value="<?php echo $bookid; ?>">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Name</label>
    <input class="form-control" type="text" name="book_name" id="book_name" value="<?php echo $book_name; ?>" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Author</label>
    <input class="form-control" type="text" name="book_author" id="book_author" value="<?php echo $book_author; ?>" readonly="readonly">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label>Notes</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" readonly="readonly"><?php echo $book_notes; ?></textarea>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>From</label>
    <input class="form-control" type="text" name="renew_book_from" id="renew_book_from" value="<?php echo $toreturn_on_old; ?>" readonly="readonly">
	</div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>To</label>
    <input class="form-control" type="text" name="renew_book_to" id="renew_book_to" value="<?php echo $toreturn_on_new; ?>" readonly="readonly">
    </div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Renew book</button>
	</div>

    </div>

    </form>
    <!-- End of Reserve book -->

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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>

    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Reserve book
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    var bookToRenew = $("#bookid").val();

    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'bookToRenew='+ bookToRenew,
    success:function(html){

        if(html) {
            alert(html);
        }

        $("#error").hide();
        $("#hide").hide();
        $("#success").empty().append('All done! Book has been reserved.');
    },
    error:function (xhr, ajaxOptions, thrownError){
        $("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
	return true;
	});
	</script>

</body>
</html>
