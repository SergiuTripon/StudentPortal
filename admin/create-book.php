<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Create book</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
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
	<label for="book_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_name" id="book_name" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Description</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter a description"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="book_author">Author<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_author" id="book_author" placeholder="Enter an author">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="book_copy_no">Copy number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="book_location">Location<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_location" id="book_location" placeholder="Enter a location">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="book_publisher">Publisher<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publisher" id="book_publisher" placeholder="Enter a publisher">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="book_publish_date">Publish date<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_date" id="book_publish_date" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="book_publish_place">Publish place<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_place" id="book_publish_place" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="book_page_amount">Pages<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_page_amount" id="book_page_amount" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="book_barcode">Barcode<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" placeholder="Enter a number">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="book_discipline">Discipline<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_discipline" id="book_discipline" placeholder="Enter a discipline">
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="book_language">Language<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_language" id="book_language" placeholder="Enter a language">
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
    <?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>

    // Date Time Picker
    $('#book_publish_date').datetimepicker({
        format: 'YYYY/MM/DD'
    });

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

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

    var book_notes = $("#book_notes").val();

    var book_author = $("#book_author").val();
	if(book_author === '') {
        $("label[for='book_author']").empty().append("Please enter an author.");
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

    var book_location = $("#book_location").val();
	if(book_location === '') {
        $("label[for='book_location']").empty().append("Please enter a name.");
        $("label[for='book_location']").removeClass("feedback-happy");
        $("label[for='book_location']").addClass("feedback-sad");
        $("#book_location").removeClass("input-happy");
        $("#book_location").addClass("input-sad");
        $("#book_location").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_location']").empty().append("All good!");
        $("label[for='book_location']").removeClass("feedback-sad");
        $("label[for='book_location']").addClass("feedback-happy");
        $("#book_location").removeClass("input-sad");
        $("#book_location").addClass("input-happy");
	}

    var book_publisher = $("#book_publisher").val();
	if(book_publisher === '') {
        $("label[for='book_publisher']").empty().append("Please enter a name.");
        $("label[for='book_publisher']").removeClass("feedback-happy");
        $("label[for='book_publisher']").addClass("feedback-sad");
        $("#book_publisher").removeClass("input-happy");
        $("#book_publisher").addClass("input-sad");
        $("#book_publisher").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publisher']").empty().append("All good!");
        $("label[for='book_publisher']").removeClass("feedback-sad");
        $("label[for='book_publisher']").addClass("feedback-happy");
        $("#book_publisher").removeClass("input-sad");
        $("#book_publisher").addClass("input-happy");
	}

    var book_publish_date = $("#book_publisher").val();
	if(book_publish_date === '') {
        $("label[for='book_publish_date']").empty().append("Please select a date.");
        $("label[for='book_publish_date']").removeClass("feedback-happy");
        $("label[for='book_publish_date']").addClass("feedback-sad");
        $("#book_publish_date").removeClass("input-happy");
        $("#book_publish_date").addClass("input-sad");
        $("#book_publish_date").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publisher_date']").empty().append("All good!");
        $("label[for='book_publisher_date']").removeClass("feedback-sad");
        $("label[for='book_publisher_date']").addClass("feedback-happy");
        $("#book_publisher_date").removeClass("input-sad");
        $("#book_publisher_date").addClass("input-happy");
	}

    var book_publish_place = $("#book_publish_place").val();
	if(book_publish_place === '') {
        $("label[for='book_publish_place']").empty().append("Please enter a name.");
        $("label[for='book_publish_place']").removeClass("feedback-happy");
        $("label[for='book_publish_place']").addClass("feedback-sad");
        $("#book_publish_place").removeClass("input-happy");
        $("#book_publish_place").addClass("input-sad");
        $("#book_publish_place").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_publish_place']").empty().append("All good!");
        $("label[for='book_publish_place']").removeClass("feedback-sad");
        $("label[for='book_publish_place']").addClass("feedback-happy");
        $("#book_publish_place").removeClass("input-sad");
        $("#book_publish_place").addClass("input-happy");
	}

    var book_page_amount = $("#book_page_amount").val();
	if(book_page_amount === '') {
        $("label[for='book_page_amount']").empty().append("Please enter a number.");
        $("label[for='book_page_amount']").removeClass("feedback-happy");
        $("label[for='book_page_amount']").addClass("feedback-sad");
        $("#book_page_amount").removeClass("input-happy");
        $("#book_page_amount").addClass("input-sad");
        $("#book_page_amount").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_page_amount']").empty().append("All good!");
        $("label[for='book_page_amount']").removeClass("feedback-sad");
        $("label[for='book_page_amount']").addClass("feedback-happy");
        $("#book_page_amount").removeClass("input-sad");
        $("#book_page_amount").addClass("input-happy");
	}

    var book_barcode = $("#book_barcode").val();
	if(book_barcode === '') {
        $("label[for='book_barcode']").empty().append("Please enter a barcode.");
        $("label[for='book_barcode']").removeClass("feedback-happy");
        $("label[for='book_barcode']").addClass("feedback-sad");
        $("#book_barcode").removeClass("input-happy");
        $("#book_barcode").addClass("input-sad");
        $("#book_barcode").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_barcode']").empty().append("All good!");
        $("label[for='book_barcode']").removeClass("feedback-sad");
        $("label[for='book_barcode']").addClass("feedback-happy");
        $("#book_barcode").removeClass("input-sad");
        $("#book_barcode").addClass("input-happy");
	}

    var book_discipline = $("#book_discipline").val();
	if(book_discipline === '') {
        $("label[for='book_discipline']").empty().append("Please enter a discipline.");
        $("label[for='book_discipline']").removeClass("feedback-happy");
        $("label[for='book_discipline']").addClass("feedback-sad");
        $("#book_discipline").removeClass("input-happy");
        $("#book_discipline").addClass("input-sad");
        $("#book_discipline").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_discipline']").empty().append("All good!");
        $("label[for='book_discipline']").removeClass("feedback-sad");
        $("label[for='book_discipline']").addClass("feedback-happy");
        $("#book_discipline").removeClass("input-sad");
        $("#book_discipline").addClass("input-happy");
	}

    var book_language = $("#book_language").val();
	if(book_language === '') {
        $("label[for='book_language']").empty().append("Please enter a language.");
        $("label[for='book_language']").removeClass("feedback-happy");
        $("label[for='book_language']").addClass("feedback-sad");
        $("#book_language").removeClass("input-happy");
        $("#book_language").addClass("input-sad");
        $("#book_language").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='book_language']").empty().append("All good!");
        $("label[for='book_language']").removeClass("feedback-sad");
        $("label[for='book_language']").addClass("feedback-happy");
        $("#book_language").removeClass("input-sad");
        $("#book_language").addClass("input-happy");
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
	</script>

</body>
</html>
