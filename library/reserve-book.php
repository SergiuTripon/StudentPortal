<?php
include '../includes/session.php';

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
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Reserve a book</li>
    </ol>

	<!-- Book event -->
    <form class="form-horizontal form-custom" style="max-width: 100%;" method="post" name="reservebook_form" id="reservebook_form" novalidate>

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

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Reserve book</span></button>
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
    <a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
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

    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'bookid=' + bookid + '&book_name=' + book_name + '&book_author=' + book_author + '&book_notes=' + book_notes,
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
