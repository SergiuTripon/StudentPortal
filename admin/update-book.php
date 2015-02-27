<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

    $bookToUpdate = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_author, book_notes, book_copy_no FROM system_books WHERE bookid = ? LIMIT 1");
    $stmt1->bind_param('i', $bookToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no);
    $stmt1->fetch();
    $stmt1->close();

} else {
    header('Location: ../../library/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Update book</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Update book</li>
    </ol>

    <!-- Update book -->
	<form class="form-custom" style="max-width: 100%;" name="updatebook_form" id="updatebook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <input type="hidden" name="bookid" id="bookid" value="<?php echo $bookid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book name</label>
    <input class="form-control" type="text" name="book_name" id="book_name" value="<?php echo $book_name; ?>" placeholder="Enter a name">
	</div>
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book name</label>
    <input class="form-control" type="text" name="book_author" id="book_author" value="<?php echo $book_author; ?>" placeholder="Enter an author">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book notes</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter notes"><?php echo $book_notes; ?></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book copy number</label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" value="<?php echo $book_copy_no; ?>" placeholder="Enter a copy number">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update book</span></button>
    </div>

    </div>
	
    </form>
    <!-- End of Update book -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
    var bookid = $("#bookid").val();

	var book_name = $("#book_name").val();
	if(book_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a name.");
		$("#book_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#book_name").addClass("success-style");
	}

    var book_author = $("#book_author").val();
	if(book_author === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter an author.");
		$("#book_author").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#book_author").addClass("success-style");
	}

    var book_copy_no = $("#book_copy_no").val();
	if(book_copy_no === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a copy number.");
		$("#book_copy_no").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#book_copy_no").addClass("success-style");
	}

    var book_notes = $("#book_notes").val();


	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'bookid1='        + bookid +
         '&book_name1='    + book_name +
         '&book_author1='  + book_author +
         '&book_notes1='   + book_notes +
         '&book_copy_no1=' + book_copy_no,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('Book updated successfully.');
	},
    error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
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
