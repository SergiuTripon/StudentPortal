<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET["id"])) {

    $bookToUpdate = $_GET["id"];

    $stmt1 = $mysqli->prepare("SELECT bookid, book_name, book_notes, book_author, book_copy_no, book_location, book_publisher, DATE_FORMAT(book_publish_date,'%d/%m/%Y') as book_publish_date, book_publish_place, book_page_amount, book_barcode, book_discipline, book_language FROM system_book WHERE bookid = ? LIMIT 1");
    $stmt1->bind_param('i', $bookToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($bookid, $book_name, $book_notes, $book_author, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language);
    $stmt1->fetch();
    $stmt1->close();

//If URL parameter is not set, do the following
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
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Update book</li>
    </ol>

    <!-- Update book -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updatebook_form" id="updatebook_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input type="hidden" name="bookid" id="bookid" value="<?php echo $bookid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_name" id="book_name" value="<?php echo $book_name ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Description</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter a description"><?php echo $book_notes ?></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_author">Author<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_author" id="book_author" value="<?php echo $book_author ?>" placeholder="Enter an author">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_copy_no">Copy number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" value="<?php echo $book_copy_no ?>" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_location">Location<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_location" id="book_location" value="<?php echo $book_location ?>" placeholder="Enter a location">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_publisher">Publisher<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="<?php echo $book_publisher ?>" placeholder="Enter a publisher">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_publish_date">Publish date<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_date" id="book_publish_date" value="<?php echo $book_publish_date ?>" placeholder="Select a date">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="book_publish_place">Publish place<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_publish_place" id="book_publish_place" value="<?php echo $book_publish_place ?>" placeholder="Enter a name">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_page_amount">Pages<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_page_amount" id="book_page_amount" value="<?php echo $book_page_amount ?>" placeholder="Enter a number">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_barcode">Barcode<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="<?php echo $book_barcode ?>" placeholder="Enter a number">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_discipline">Discipline<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_discipline" id="book_discipline" value="<?php echo $book_discipline ?>" placeholder="Enter a discipline">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="book_language">Language<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="book_language" id="book_language" value="<?php echo $book_language ?>" placeholder="Enter a language">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="update-book-submit" class="btn btn-primary btn-lg" >Update book</button>
    </div>

    </div>
	
    </form>
    <!-- End of Update book -->

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
    <a class="btn btn-primary btn-lg" href="/home/">Home</a>
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
    <a class="btn btn-primary btn-lg" href="/">Sign in</a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Initialize Date Time Picker
    $('#book_publish_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    //Update book process
    $("#update-book-submit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    var bookid = $("#bookid").val();

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

    var book_publish_place = $("#book_publisher_place").val();
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

    //If there are no errors, initialize the Ajax call
	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'update_bookid='              + bookid +
         '&update_book_name='          + book_name +
         '&update_book_notes='         + book_notes +
         '&update_book_author='        + book_author +
         '&update_book_copy_no='       + book_copy_no +
         '&update_book_location='      + book_location +
         '&update_book_publisher='     + book_publisher +
         '&update_book_publish_date='  + book_publish_date +
         '&update_book_publish_place=' + book_publish_place +
         '&update_book_page_amount='   + book_page_amount +
         '&update_book_barcode='       + book_barcode +
         '&update_book_discipline='    + book_discipline +
         '&update_book_language='      + book_language,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The book has been updated.');
	},

    //If action failed, do the following
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
