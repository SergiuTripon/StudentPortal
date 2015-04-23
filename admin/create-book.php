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
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Create book</li>
    </ol>

    <!-- Create book -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createbook_form" id="createbook_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_name" id="book_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Description</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter a description"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_author">Author<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_author" id="book_author" placeholder="Enter an author">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_copy_no">Copy number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_location">Location<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_location" id="book_location" placeholder="Enter a location">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_publisher">Publisher<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publisher" id="book_publisher" placeholder="Enter a publisher">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_publish_date">Publish date<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_date" id="book_publish_date" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_publish_place">Publish place<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_place" id="book_publish_place" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_page_amount">Pages<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_page_amount" id="book_page_amount" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_barcode">Barcode<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" placeholder="Enter a number">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_discipline">Discipline<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_discipline" id="book_discipline" placeholder="Enter a discipline">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_language">Language<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_language" id="book_language" placeholder="Enter a language">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Create book</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg" href="">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create book -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>




    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/home/">Home</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>




    <?php endif; ?>
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
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    // Date Time Picker
    $('#book_publish_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });




    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

	var book_name = $("#book_name").val();
	if(book_name === '') {
        $("label[for='book_name']").empty().append("Please enter a name.");
        $("label[for='book_name']").removeClass("feedback-success");
        $("label[for='book_name']").addClass("feedback-danger");
        $("#book_name").removeClass("input-success");
        $("#book_name").addClass("input-danger");
        $("#book_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_name']").empty().append("All good!");
        $("label[for='book_name']").removeClass("feedback-danger");
        $("label[for='book_name']").addClass("feedback-success");
        $("#book_name").removeClass("input-danger");
        $("#book_name").addClass("input-success");
	}

    var book_notes = $("#book_notes").val();

    var book_author = $("#book_author").val();
	if(book_author === '') {
        $("label[for='book_author']").empty().append("Please enter an author.");
        $("label[for='book_author']").removeClass("feedback-success");
        $("label[for='book_author']").addClass("feedback-danger");
        $("#book_author").removeClass("input-success");
        $("#book_author").addClass("input-danger");
        $("#book_author").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_author']").empty().append("All good!");
        $("label[for='book_author']").removeClass("feedback-danger");
        $("label[for='book_author']").addClass("feedback-success");
        $("#book_author").removeClass("input-danger");
        $("#book_author").addClass("input-success");
	}

    var book_copy_no = $("#book_copy_no").val();
	if(book_copy_no === '') {
        $("label[for='book_copy_no']").empty().append("Please enter a number.");
        $("label[for='book_copy_no']").removeClass("feedback-success");
        $("label[for='book_copy_no']").addClass("feedback-danger");
        $("#book_copy_no").removeClass("input-success");
        $("#book_copy_no").addClass("input-danger");
        $("#book_copy_no").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_copy_no']").empty().append("All good!");
        $("label[for='book_copy_no']").removeClass("feedback-danger");
        $("label[for='book_copy_no']").addClass("feedback-success");
        $("#book_copy_no").removeClass("input-danger");
        $("#book_copy_no").addClass("input-success");
	}

    var book_location = $("#book_location").val();
	if(book_location === '') {
        $("label[for='book_location']").empty().append("Please enter a name.");
        $("label[for='book_location']").removeClass("feedback-success");
        $("label[for='book_location']").addClass("feedback-danger");
        $("#book_location").removeClass("input-success");
        $("#book_location").addClass("input-danger");
        $("#book_location").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_location']").empty().append("All good!");
        $("label[for='book_location']").removeClass("feedback-danger");
        $("label[for='book_location']").addClass("feedback-success");
        $("#book_location").removeClass("input-danger");
        $("#book_location").addClass("input-success");
	}

    var book_publisher = $("#book_publisher").val();
	if(book_publisher === '') {
        $("label[for='book_publisher']").empty().append("Please enter a name.");
        $("label[for='book_publisher']").removeClass("feedback-success");
        $("label[for='book_publisher']").addClass("feedback-danger");
        $("#book_publisher").removeClass("input-success");
        $("#book_publisher").addClass("input-danger");
        $("#book_publisher").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publisher']").empty().append("All good!");
        $("label[for='book_publisher']").removeClass("feedback-danger");
        $("label[for='book_publisher']").addClass("feedback-success");
        $("#book_publisher").removeClass("input-danger");
        $("#book_publisher").addClass("input-success");
	}

    var book_publish_date = $("#book_publish_date").val();
	if(book_publish_date === '') {
        $("label[for='book_publish_date']").empty().append("Please select a date.");
        $("label[for='book_publish_date']").removeClass("feedback-success");
        $("label[for='book_publish_date']").addClass("feedback-danger");
        $("#book_publish_date").removeClass("input-success");
        $("#book_publish_date").addClass("input-danger");
        $("#book_publish_date").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publisher_date']").empty().append("All good!");
        $("label[for='book_publisher_date']").removeClass("feedback-danger");
        $("label[for='book_publisher_date']").addClass("feedback-success");
        $("#book_publisher_date").removeClass("input-danger");
        $("#book_publisher_date").addClass("input-success");
	}

    var book_publish_place = $("#book_publish_place").val();
	if(book_publish_place === '') {
        $("label[for='book_publish_place']").empty().append("Please enter a name.");
        $("label[for='book_publish_place']").removeClass("feedback-success");
        $("label[for='book_publish_place']").addClass("feedback-danger");
        $("#book_publish_place").removeClass("input-success");
        $("#book_publish_place").addClass("input-danger");
        $("#book_publish_place").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publish_place']").empty().append("All good!");
        $("label[for='book_publish_place']").removeClass("feedback-danger");
        $("label[for='book_publish_place']").addClass("feedback-success");
        $("#book_publish_place").removeClass("input-danger");
        $("#book_publish_place").addClass("input-success");
	}

    var book_page_amount = $("#book_page_amount").val();
	if(book_page_amount === '') {
        $("label[for='book_page_amount']").empty().append("Please enter a number.");
        $("label[for='book_page_amount']").removeClass("feedback-success");
        $("label[for='book_page_amount']").addClass("feedback-danger");
        $("#book_page_amount").removeClass("input-success");
        $("#book_page_amount").addClass("input-danger");
        $("#book_page_amount").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_page_amount']").empty().append("All good!");
        $("label[for='book_page_amount']").removeClass("feedback-danger");
        $("label[for='book_page_amount']").addClass("feedback-success");
        $("#book_page_amount").removeClass("input-danger");
        $("#book_page_amount").addClass("input-success");
	}

    var book_barcode = $("#book_barcode").val();
	if(book_barcode === '') {
        $("label[for='book_barcode']").empty().append("Please enter a barcode.");
        $("label[for='book_barcode']").removeClass("feedback-success");
        $("label[for='book_barcode']").addClass("feedback-danger");
        $("#book_barcode").removeClass("input-success");
        $("#book_barcode").addClass("input-danger");
        $("#book_barcode").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_barcode']").empty().append("All good!");
        $("label[for='book_barcode']").removeClass("feedback-danger");
        $("label[for='book_barcode']").addClass("feedback-success");
        $("#book_barcode").removeClass("input-danger");
        $("#book_barcode").addClass("input-success");
	}

    var book_discipline = $("#book_discipline").val();
	if(book_discipline === '') {
        $("label[for='book_discipline']").empty().append("Please enter a discipline.");
        $("label[for='book_discipline']").removeClass("feedback-success");
        $("label[for='book_discipline']").addClass("feedback-danger");
        $("#book_discipline").removeClass("input-success");
        $("#book_discipline").addClass("input-danger");
        $("#book_discipline").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_discipline']").empty().append("All good!");
        $("label[for='book_discipline']").removeClass("feedback-danger");
        $("label[for='book_discipline']").addClass("feedback-success");
        $("#book_discipline").removeClass("input-danger");
        $("#book_discipline").addClass("input-success");
	}

    var book_language = $("#book_language").val();
	if(book_language === '') {
        $("label[for='book_language']").empty().append("Please enter a language.");
        $("label[for='book_language']").removeClass("feedback-success");
        $("label[for='book_language']").addClass("feedback-danger");
        $("#book_language").removeClass("input-success");
        $("#book_language").addClass("input-danger");
        $("#book_language").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_language']").empty().append("All good!");
        $("label[for='book_language']").removeClass("feedback-danger");
        $("label[for='book_language']").addClass("feedback-success");
        $("#book_language").removeClass("input-danger");
        $("#book_language").addClass("input-success");
	}


	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'create_book_name='           + book_name +
         '&create_book_notes='         + book_notes +
         '&create_book_author='        + book_author +
         '&create_book_copy_no='       + book_copy_no +
         '&create_book_location='      + book_location +
         '&create_book_publisher='     + book_publisher +
         '&create_book_publish_date='  + book_publish_date +
         '&create_book_publish_place=' + book_publish_place +
         '&create_book_page_amount='   + book_page_amount +
         '&create_book_barcode='       + book_barcode +
         '&create_book_discipline='    + book_discipline +
         '&create_book_language='      + book_language,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The book has been created.');
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
	</script>

</body>
</html>
