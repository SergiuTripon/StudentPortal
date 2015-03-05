<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Create book</title>
	
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
    <li class="active">Create book</li>
    </ol>

    <!-- Create book -->
	<form class="form-custom" style="max-width: 100%;" name="createbook_form" id="createbook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="book_name">Book name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_name" id="book_name" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="book_author">Book author<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_author" id="book_author" placeholder="Enter an author">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book notes</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="book_copy_no">Book copy number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" placeholder="Enter a copy number">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create book</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create book -->

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
	var book_name = $("#book_name").val();
	if(book_name === '') {
        $("label[for='book_name']").empty().append("Please enter a name.");
        $("label[for='book_name']").removeClass("feedback-happy");
        $("label[for='book_name']").addClass("feedback-sad");
        $("#book_name").removeClass("input-happy");
        $("#book_name").addClass("input-sad");
        $("#book_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_name']").empty().append("All good!");
        $("label[for='book_name']").removeClass("feedback-sad");
        $("label[for='book_name']").addClass("feedback-happy");
        $("#book_name").removeClass("input-sad");
        $("#book_name").addClass("input-happy");
	}

    var book_author = $("#book_author").val();
	if(book_author === '') {
        $("label[for='book_author']").empty().append("Please enter a name.");
        $("label[for='book_author']").removeClass("feedback-happy");
        $("label[for='book_author']").addClass("feedback-sad");
        $("#book_author").removeClass("input-happy");
        $("#book_author").addClass("input-sad");
        $("#book_author").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_author']").empty().append("All good!");
        $("label[for='book_author']").removeClass("feedback-sad");
        $("label[for='book_author']").addClass("feedback-happy");
        $("#book_author").removeClass("input-sad");
        $("#book_author").addClass("input-happy");
	}

    var book_notes = $("#book_notes").val();

    var book_copy_no = $("#book_copy_no").val();
	if(book_copy_no === '') {
        $("label[for='book_copy_no']").empty().append("Please enter a number.");
        $("label[for='book_copy_no']").removeClass("feedback-happy");
        $("label[for='book_copy_no']").addClass("feedback-sad");
        $("#book_copy_no").removeClass("input-happy");
        $("#book_copy_no").addClass("input-sad");
        $("#book_copy_no").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_copy_no']").empty().append("All good!");
        $("label[for='book_copy_no']").removeClass("feedback-sad");
        $("label[for='book_copy_no']").addClass("feedback-happy");
        $("#book_copy_no").removeClass("input-sad");
        $("#book_copy_no").addClass("input-happy");
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'book_name='     + book_name +
         '&book_author='  + book_author +
         '&book_notes='   + book_notes +
         '&book_copy_no=' + book_copy_no,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Book created successfully.');
		$("#success-button").show();
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
