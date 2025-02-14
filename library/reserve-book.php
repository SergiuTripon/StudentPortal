<?php
include '../includes/session.php';

global $mysqli;
global $bookid;
global $book_name;
global $book_author;
global $book_notes;

global $userid;
global $email;
global $studentno;
global $firstname;
global $surname;

//If URL parameter is set, do the following
if (isset($_GET["id"])) {

    $bookToReserve = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes FROM system_book WHERE bookid = ? LIMIT 1");
    $stmt1->bind_param('i', $bookToReserve);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $mysqli->prepare("SELECT user_signin.userid, user_signin.email, user_detail.studentno, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt->bind_param('i', $session_userid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid, $email, $studentno, $firstname, $surname);
    $stmt->fetch();

//If URL parameter is not set, do the following
} else {
    header('Location: ../../library/');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Reserve book</title>

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
    <li class="active">Reserve a book</li>
    </ol>

	<!-- Book event -->
    <form class="form-horizontal form-custom" style="max-width: 100%;" method="post" name="reservebook_form" id="reservebook_form" novalidate>

    <p id="success" class="feedback-success text-center"></p>
    <p id="error" class="feedback-danger text-center"></p>

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

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Reserve book</button>
	</div>

    </div>

    </form>
    <!-- End of Reserve book -->

    </div><!-- /container -->

    <div id="modal-error" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
    <div class="close"><i class="fa fa-book"></i></div>
    <h4 class="modal-title" id="modal-custom-label">Error</h4>
    </div>

    <div class="modal-body">
    <p></p>
    </div>

    <div class="modal-footer">
    <div class="view-close text-center">
    <a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

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

    //Reserve book process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    var bookid = $("#bookid").val();
    var book_name = $("#book_name").val();
    var book_author = $("#book_author").val();
    var book_notes = $("#book_notes").val();

    //Initialize Ajax call
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'bookid=' + bookid + '&book_name=' + book_name + '&book_author=' + book_author + '&book_notes=' + book_notes,

   //If action completed, do the following
    success:function(){
        $("#error").hide();
        $("#hide").hide();
        $("#success").empty().append('All done! The book has been reserved.');
    },

    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError){
        buttonReset();
        $("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
	return true;
	});
	</script>

</body>
</html>
