<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'assets/css-paths/common-css-paths.php'; ?>
	<?php include 'assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Library</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="library-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Library</li>
    </ol>

	<div class="row">

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
	<a id="books-toggle">
    <div class="tile book-tile">
	<i class="fa fa-book"></i>
	<p class="tile-text">Book view</p>
    </div>
    </a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
	<a id="calendar-toggle">
	<div class="tile calendar-tile">
    <i class="fa fa-calendar"></i>
	<p class="tile-text">Returns - Calendar view</p>
    </div>
    </a>
	</div>

	</div><!-- /row -->

	<div class="panel-group book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="books-content" class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Available books</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom books-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Status</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_books WHERE book_status = 'active' OR book_status = 'reserved'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.$book_notes.'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Status">'.$book_status.'</td>
			<td data-title="Action">'.($book_status === 'Reserved' ? "<a id=\"request-$bookid\" class=\"btn btn-primary btn-md ladda-button\" data-style=\"slide-up\"><span class=\"ladda-label\">Request</span></a>" : "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/reserve-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Reserve</span></a>").'</td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	<div id="reservedbooks-content" class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Reserved books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom reservedbooks-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Booked on</th>
	<th>Return on</th>
    <th>Returned on</th>
	<th>Status</th>
    <th>Returned</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT reserved_books.bookid, DATE_FORMAT(reserved_books.reserved_on,'%d %b %y') as reserved_on, DATE_FORMAT(reserved_books.toreturn_on,'%d %b %y') as toreturn_on, DATE_FORMAT(reserved_books.returned_on,'%d %b %y') as returned_on, reserved_books.isReturned, system_books.book_name, system_books.book_author, system_books.book_notes, system_books.book_status FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid  WHERE reserved_books.userid = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $book_name = $row["book_name"];
    $book_author = $row["book_author"];
    $book_notes = $row["book_notes"];
    $reserved_on = $row["reserved_on"];
    $toreturn_on = $row["toreturn_on"];
    $returned_on = $row["returned_on"];
	$book_status = $row["book_status"];
    $isReturned = $row["isReturned"];

	$book_status = ucfirst($book_status);

	echo '<tr>

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.$book_notes.'</td>
			<td data-title="Booken on">'.$reserved_on.'</td>
			<td data-title="Return on">'.$toreturn_on.'</td>
			<td data-title="Returned on">'.$returned_on.'</td>
			<td data-title="Status">'.$book_status.'</td>
			<td data-title="isReturned">'.($isReturned === '0' ? "No" : "Yes").'</td>
			</tr>';
	}

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

	<div class="panel-group calendar-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="calendar-content" class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingThree">
	<h4 class="panel-title">
	<a data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Calendar - click to minimize or maximize</a>
	</h4>
	</div>
	<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
	<div class="panel-body">

	<div class="calendar-buttons text-right">
	<div id="calendar-buttons1" class="btn-group">
		<button class="btn btn-default" data-calendar-nav="prev"><< Prev</button>
		<button class="btn btn-default" data-calendar-nav="today">Today</button>
		<button class="btn btn-default" data-calendar-nav="next">Next >></button>
	</div>
	<div id="calendar-buttons2" class="btn-group">
		<button class="btn btn-default" data-calendar-view="year">Year</button>
		<button class="btn btn-default active" data-calendar-view="month">Month</button>
		<button class="btn btn-default" data-calendar-view="week">Week</button>
		<button class="btn btn-default" data-calendar-view="day">Day</button>
	</div>
	</div>

	<div class="page-header">
	<h3></h3>
	<hr>
	</div>

	<div id="calendar"></div>

	</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="library-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Library</li>
    </ol>

    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="../admin/create-book/"><span class="ladda-label">Create book</span></a>

    <div class="panel-group book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Active books</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Active books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom books-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Status</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_books WHERE book_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);

	echo '<tr id="cancel-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.$book_notes.'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Status">'.$book_status.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../admin/update-book?id='.$bookid.'" data-style="slide-up"><span class="ladda-label">Update</span></a></td>
			<td data-title="Action"><a id=cancel-'.$bookid.' class="btn btn-primary btn-md cancel-button ladda-button" data-style="slide-up"><span class="ladda-label">Cancel</span></a></td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Reserved books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom books-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Status</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_books WHERE book_status = 'reserved'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);

	echo '<tr id="return-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.$book_notes.'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Status">'.$book_status.'</td>
			<td data-title="Action"><a id=return-'.$bookid.' class="btn btn-primary btn-md return-button ladda-button" data-style="slide-up"><span class="ladda-label">Mark returned</span></a></td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Cancelled books</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Cancelled books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom books-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Status</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_books WHERE book_status = 'cancelled'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);

	echo '<tr id="activate-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.$book_notes.'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Status">'.$book_status.'</td>
			<td data-title="Action"><a id=activate-'.$bookid.' class="btn btn-primary btn-md activate-button ladda-button" data-style="slide-up"><span class="ladda-label">Activate</span></a></td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

	<?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

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

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script>
	$(document).ready(function () {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

	//Sets calendar options
	(function($) {

	"use strict";

	var options = {
		events_source: 'https://student-portal.co.uk/includes/calendar/source/reservedbooks_json.php',
		view: 'month',
		tmpl_path: '../assets/tmpls/',
		tmpl_cache: false,
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	var calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});
	}(jQuery));

	//DataTables
    $('.books-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no books to display."
		}
	});

	$('.reservedbooks-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no reserved books to display."
		}
	});

    //Request book ajax call
    $("body").on("click", ".request-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToRequest = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToRequest='+ bookToRequest,
	success:function(){
		$('#book-'+bookToRequest).fadeOut();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Return book ajax call
    $("body").on("click", ".return-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToReturn = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToReturn='+ bookToReturn,
	success:function(){
		$('#return-'+bookToReturn).fadeOut();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Cancel book ajax call
    $("body").on("click", ".cancel-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToCancel = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToCancel='+ bookToCancel,
	success:function(){
		$('#cancel-'+bookToCancel).fadeOut();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Activate book ajax call
    $("body").on("click", ".activate-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToActivate = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToActivate='+ bookToActivate,
	success:function(){
		$('#activate-'+bookToActivate).fadeOut();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

	//Event view/Calendar view toggle
	$("#calendar-content").hide();
	$(".book-tile").addClass("tile-selected");
	$(".book-tile p").addClass("tile-text-selected");
	$(".book-tile i").addClass("tile-text-selected");

	$("#books-toggle").click(function (e) {
    e.preventDefault();
        $(".calendar-view").hide();
		$("#calendar-content").hide();
        $(".book-view").show();
		$("#books-content").show();
		$("#reservedbooks-content").show();
		$(".calendar-tile").removeClass("tile-selected");
		$(".calendar-tile p").removeClass("tile-text-selected");
		$(".calendar-tile i").removeClass("tile-text-selected");
		$(".book-tile").addClass("tile-selected");
		$(".book-tile p").addClass("tile-text-selected");
		$(".book-tile i").addClass("tile-text-selected");
	});

	$("#calendar-toggle").click(function (e) {
    e.preventDefault();
        $(".book-view").hide();
		$("#books-content").hide();
		$("#reservedbooks-content").hide();
        $(".calendar-view").show();
		$("#calendar-content").show();
		$(".book-tile").removeClass("tile-selected");
		$(".book-tile p").removeClass("tile-text-selected");
		$(".book-tile i").removeClass("tile-text-selected");
		$(".calendar-tile").addClass("tile-selected");
		$(".calendar-tile p").addClass("tile-text-selected");
		$(".calendar-tile i").addClass("tile-text-selected");
	});

	});
	</script>

</body>
</html>
