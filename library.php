<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $session_userid;

global $active_book;
global $inactive_book;

AdminLibraryUpdate();

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Library</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="library-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
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

	<div class="panel-group panel-custom book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Books</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Book</th>
	<th>Author</th>
	<th>Reserve</th>
    <th>Request</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $book_status = 'active';

	$stmt1 = $mysqli->prepare("SELECT b.bookid, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book b WHERE b.book_status=?");
    $stmt1->bind_param('s', $book_status);
    $stmt1->execute();
    $stmt1->bind_result($bookid, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            $stmt2 = $mysqli->prepare("SELECT r.bookid FROM system_book_reserved r LEFT JOIN system_book_loaned l ON r.bookid=l.bookid WHERE r.bookid=? AND ((r.isCollected='0' AND r.reservation_status='pending') OR (l.isReturned = '0' AND l.loan_status='ongoing') OR (l.isRequested = '0'))");
            $stmt2->bind_param('i', $bookid);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($db_reserved_bookid);
            $stmt2->fetch();

            $stmt3 = $mysqli->prepare("SELECT bookid FROM system_book_loaned WHERE bookid=? AND isReturned='0' AND isRequested='0' AND loan_status='ongoing' AND NOT userid = '$session_userid'");
            $stmt3->bind_param('i', $bookid);
            $stmt3->execute();
            $stmt3->store_result();
            $stmt3->bind_result($db_loaned_bookid);
            $stmt3->fetch();

            echo
           '<tr>
			<td data-title="Book"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Reserve">'.($stmt2->num_rows == 0 ? "<a class=\"btn btn-primary btn-md btn-load\" href=\"../library/reserve-book?id=$bookid\">Reserve</a>" : "<a class=\"btn btn-primary btn-md disabled\" href=\"../library/reserve-book?id=$bookid\">Reserve</a>").'</td>
            <td data-title="Request">'.($stmt3->num_rows == 1 ? "<a class=\"btn btn-primary btn-md btn-load\" href=\"../library/request-book?id=$bookid\">Request</a>" : "<a class=\"btn btn-primary btn-md disabled\" href=\"../library/request-book?id=$bookid\">Request</a>").'
            
            <div id="view-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->
            
            </td>
			</tr>';
        }
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Your reservations</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Your reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Book</th>
	<th>Author</th>
	<th>Reserved on</th>
	<th>To collect by</th>
    <th>Collected on</th>
    <th>Collected</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->prepare("SELECT r.bookid, DATE_FORMAT(r.created_on,'%d %b %y') as created_on, DATE_FORMAT(r.tocollect_on,'%d %b %y') as tocollect_on, DATE_FORMAT(r.collected_on,'%d %b %y') as collected_on, r.isCollected, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.userid = '$session_userid'");
    $stmt2->bind_param('s', $book_status);
    $stmt2->execute();
    $stmt2->bind_result($bookid, $created_on, $tocollect_on, $collected_on, $isCollected, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            echo

           '<tr>
			<td data-title="Book"><a href="#view-reserved-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Reserved on">'.$created_on.'</td>
			<td data-title="To collect by">'.$tocollect_on.'</td>
			<td data-title="Collected on">'.(empty($collected_on) ? "Not yet" : "$collected_on").'</td>
			<td data-title="Collected">'.($isCollected === 0 ? "No" : "Yes").'

			<div id="view-reserved-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			</td>
			</tr>';
        }
    }

	$stmt2->close();
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Your loans</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Your loans -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Book</th>
	<th>Author</th>
	<th>Loaned on</th>
	<th>To return by</th>
    <th>Returned on</th>
    <th>Returned</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->prepare("SELECT l.bookid, DATE_FORMAT(l.created_on,'%d %b %y') as created_on, DATE_FORMAT(l.toreturn_on,'%d %b %y') as toreturn_on, DATE_FORMAT(l.returned_on,'%d %b %y') as returned_on, l.isReturned, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_loaned l LEFT JOIN system_book b ON l.bookid=b.bookid WHERE l.userid=?");
    $stmt3->bind_param('i', $session_userid);
    $stmt3->execute();
    $stmt3->bind_result($bookid, $created_on, $toreturn_on, $returned_on, $isReturned, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt3->store_result();

    if ($stmt3->num_rows > 0) {

        while ($stmt3->fetch()) {

            echo
           '<tr>
			<td data-title="Name"><a href="#view-loaned-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Loaned on">'.$created_on.'</td>
			<td data-title="To return by">'.$toreturn_on.'</td>
			<td data-title="Returned on">'.(empty($returned_on) ? "Not yet" : "$returned_on").'</td>
			<td data-title="Returned">'.($isReturned === 0 ? "No" : "Yes").'</td>
            <td data-title="Action">'.($isReturned == 0 ? "<a id=\"book-$bookid\" class=\"btn btn-primary btn-md btn-renew-book btn-load\">Renew</a>" : "<a id=\"book-$bookid.'\" class=\"btn btn-primary btn-md disabled btn-renew-book btn-load\">Renew</a>").'

            <div id="view-loaned-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			</td>
			</tr>

            </td>
			</tr>';
        }
    }

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Your requests</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Your requests -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
    <th>Book</th>
    <th>Author</th>
    <th>Requested on</th>
    <th>Read</th>
    <th>Approved</th>
	</tr>
	</thead>

	<tbody>
    <?php
    $stmt4 = $mysqli->prepare("SELECT r.bookid, DATE_FORMAT(r.created_on,'%d %b %y') as created_on, r.isRead, r.isApproved, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_requested r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.userid=?");
    $stmt4->bind_param('i', $session_userid);
    $stmt4->execute();
    $stmt4->bind_result($bookid, $created_on, $toreturn_on, $returned_on, $isReturned, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt4->store_result();

    if ($stmt4->num_rows > 0) {

        while ($stmt4->fetch()) {

            echo
           '<tr>
			<td data-title="Book"><a href="#view-requested-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Requested on">'.$created_on.'</td>
			<td data-title="Read">'.($isRead == 0 ? "No" : "Yes").'</td>
			<td data-title="Approved">'.($isApproved == 0 ? "No" : "Yes").'

			<div id="view-requested-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
			<div class="view-close text-center">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			</td>
			</tr>

			</td>
			</tr>';
        }
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

	<div class="panel-group panel-custom calendar-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div id="calendar-content" class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingThree">
	<h4 class="panel-title">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Returns - Calendar</a>
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

    <div id="error-modal" class="modal fade modal-custom modal-error" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
    <div class="form-logo text-center">
    <i class="fa fa-exclamation"></i>
    </div>
    </div>

    <div class="modal-body">
    <p class="text-center"></p>
    </div>

    <div class="modal-footer">
    <div class="view-close text-center">
    <a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

	<?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>
	$(document).ready(function () {
        //Book view/Calendar view toggle
        $("#calendar-content").hide();
        $(".book-tile").addClass("tile-selected");
        $(".book-tile p").addClass("tile-text-selected");
        $(".book-tile i").addClass("tile-text-selected");
    });

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
    $('.table-custom').dataTable(settings);

    //Renew book
    $("body").on("click", ".btn-renew-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToRenewCheck = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToRenewCheck='+ bookToRenewCheck,
	success:function(error_msg){
        if (error_msg) {

            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(error_msg);
            $('#error-modal').modal('show');

            buttonReset();

        } else {
            window.location.replace("https://student-portal.co.uk/library/renew-book?id=" + bookToRenewCheck);
        }
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	    buttonReset();
    }
	});
    });

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
	</script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="library-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../home/">Home</a></li>
    <li class="active">Library</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin btn-load" href="../admin/create-book/">Create book</a>

    <div class="panel-group panel-custom book-view" id="accordion" role="tablist" aria-multiselectable="true">

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
	<table class="table table-condensed table-custom table-active-book">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-book">
	<?php
    echo $active_book;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-book">

	<thead>
	<tr>
	<th>Book</th>
	<th>Author</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-book">
    <?php
    echo $inactive_book;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Reserved books</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-reserved-book">

	<thead>
	<tr>
    <th>Reserved by</th>
	<th>Book</th>
	<th>Author</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $isReserved = 1;
    $isCollected = 0;

	$stmt3 = $mysqli->prepare("SELECT r.bookid, r.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_reserved r LEFT JOIN user_detail d ON r.userid=d.userid LEFT JOIN system_book b ON r.bookid=b.bookid WHERE b.isReserved=? AND r.isCollected=?");
    $stmt3->bind_param('ii', $isReserved, $isCollected);
    $stmt3->execute();
    $stmt3->bind_result($bookid, $userid, $firstname, $surname, $gender, $dateofbirth, $nationality, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt3->store_result();

    if ($stmt3->num_rows > 0) {

        while ($stmt3->fetch()) {

            echo
            '<tr>
            <td data-title="Reserved by"><a href="#view-reserved-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Name"><a href="#view-reserved-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a href="#collect-'.$bookid.'" class="btn btn-primary btn-md" data-toggle="modal">Mark collected</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a></li>
            </ul>
            </div>
            </td>
			</tr>

            <div id="view-reserved-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.ucfirst($gender).'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-reserved-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#collect-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-md">Mark collected</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="collect-'.$bookid.'" class="modal fade modal-custom modal-success" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Mark "'.$book_name.'" as collected?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to mark "'.$book_name.'" collected?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="collect-'.$bookid.'" class="btn btn-primary btn-lg btn-collect-book btn-load">Mark collected</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
        }
    }

	$stmt3->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Loaned books</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Loaned books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-loaned-book">

	<thead>
	<tr>
    <th>Loaned by</th>
	<th>Book</th>
	<th>Author</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $isReserved = 1;
    $isCollected = 1;
    $isLoaned = 1;
    $isReturned = 0;

	$stmt4 = $mysqli->prepare("SELECT DISTINCT l.bookid, l.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_loaned l LEFT JOIN system_book_reserved r ON l.bookid=r.bookid LEFT JOIN user_detail d ON l.userid=d.userid LEFT JOIN system_book b ON l.bookid=b.bookid WHERE b.isReserved=? AND r.isCollected=? AND b.isLoaned=? AND l.isReturned=?");
    $stmt4->bind_param('iiii', $isReserved, $isCollected, $isLoaned, $isReturned);
    $stmt4->execute();
    $stmt4->bind_result($bookid, $userid, $firstname, $surname, $gender, $dateofbirth, $nationality, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt4->store_result();

    if ($stmt4->num_rows > 0) {

        while ($stmt4->fetch()) {

            echo
           '<tr>
            <td data-title="Loaned by"><a href="#view-loaned-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Book"><a href="#view-loaned-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a href="#return-'.$bookid.'" class="btn btn-primary btn-md" data-toggle="modal">Mark returned</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a></li>
            </ul>
            </div>

            <div id="view-loaned-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.ucfirst($gender).'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-loaned-book-'.$bookid.'" class="modal fade modal-custom modal-info tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#return-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-md" >Mark returned</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="return-'.$bookid.'" class="modal fade modal-custom modal-success" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Mark "'.$book_name.'" as returned?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to mark "'.$book_name.'" as returned?</p><br>
			<p><b>Note:</b> The system will also check to see if there are any requests pending on the book. If there are, the system will automatically create a reservation for the user that requested the book.</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="return-'.$bookid.'" class="btn btn-primary btn-lg btn-return-book btn-load">Mark returned</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            </td>
			</tr>';
        }
    }

	$stmt4->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFive">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive"> Requested books</a>
  	</h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Requested books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-requested-book">

	<thead>
	<tr>
    <th>Requested by</th>
	<th>Name</th>
	<th>Author</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $isApproved = 0;

	$stmt5 = $mysqli->prepare("SELECT r.requestid, r.bookid, r.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_location, b.book_publisher, b.book_publish_date, b.book_publish_place, b.book_page_amount, b.book_barcode, b.book_discipline, b.book_language, b.book_status, b.created_on, b.updated_on FROM system_book_requested r LEFT JOIN system_book b ON r.bookid=b.bookid LEFT JOIN user_detail d ON r.userid=d.userid WHERE r.isApproved = '0'");
    $stmt5->bind_param('i', $isApproved);
    $stmt5->execute();
    $stmt5->bind_result($requestid, $bookid, $userid, $firstname, $surname, $gender, $dateofbirth, $nationality, $book_name, $book_author, $book_notes, $book_copy_no, $book_location, $book_publisher, $book_publish_date, $book_publish_place, $book_page_amount, $book_barcode, $book_discipline, $book_language,  $book_status, $created_on, $updated_on);
    $stmt5->store_result();

    if ($stmt5->num_rows > 0) {

        while ($stmt5->fetch()) {

            echo
           '<tr>
            <td data-title="Requested by"><a id="book-'.$requestid.'" class="request-read-trigger" href="#view-requested-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Name"><a id="request-'.$requestid.'" class="request-read-trigger" href="#view-requested-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
            <td data-title="Action"><a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a></td>
			</tr>

            <div id="view-requested-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.ucfirst($gender).'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md" >Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-requested-book-'.$bookid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number:</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			<p><b>Location:</b> '.(empty($book_location) ? "-" : "$book_location").'</p>
			<p><b>Publisher:</b> '.(empty($book_publisher) ? "-" : "$book_publisher").'</p>
			<p><b>Publish date:</b> '.(empty($book_publish_date) ? "-" : "$book_publish_date").'</p>
			<p><b>Publish place:</b> '.(empty($book_publish_place) ? "-" : "$book_publish_place").'</p>
			<p><b>Pages:</b> '.(empty($book_page_amount) ? "-" : "$book_page_amount").'</p>
			<p><b>Barcode:</b> '.(empty($book_barcode) ? "-" : "$book_barcode").'</p>
			<p><b>Descipline:</b> '.(empty($book_discipline) ? "-" : "$book_discipline").'</p>
			<p><b>Language:</b> '.(empty($book_language) ? "-" : "$book_language").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-md">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
        }
    }

	$stmt5->close();
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

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<script>

	//DataTables
    $('.table-active-book').dataTable(settings);
    $('.table-inactive-book').dataTable(settings);
    $('.table-reserved-book').dataTable(settings);
    $('.table-loaned-book').dataTable(settings);
    $('.table-requested-book').dataTable(settings);


    $(".request-read-trigger").click(function (e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var requestToRead = clickedID[1];

    jQuery.ajax({
    type: "POST",
    url: "https://student-portal.co.uk/includes/processes.php",
    data:'requestToRead=' + requestToRead,
    success:function() {
    },
    error:function (xhr, ajaxOptions, thrownError) {
    }
    });
    });

    //Collect book
    $("body").on("click", ".btn-collect-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToCollect = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToCollect='+ bookToCollect,
	success:function(){

            $('.modal-custom').modal("hide");
            location.reload();

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Return book
    $("body").on("click", ".btn-return-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToReturn = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToReturn='+ bookToReturn,
	success:function(){

        $('.modal-custom').modal("hide");
        location.reload();

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Deactivate book
    $("body").on("click", ".btn-deactivate-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToDeactivate = clickedID[1];

    togglePreloader();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'bookToDeactivate='+ bookToDeactivate,
	success:function(html){

        togglePreloader();

        $('#content-active-book').empty();
        $(".table-active-book").dataTable().fnDestroy();
        $('#content-active-book').html(html.active_book);
        $(".table-active-book").dataTable(settings);

        $('#content-inactive-book').empty();
        $(".table-inactive-book").dataTable().fnDestroy();
        $('#content-inactive-book').html(html.inactive_book);
        $(".table-inactive-book").dataTable(settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
        togglePreloader();
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate
    $("body").on("click", ".btn-reactivate-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToReactivate = clickedID[1];

    togglePreloader();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'bookToReactivate='+ bookToReactivate,
	success:function(html){

        togglePreloader();

        $('#content-inactive-book').empty();
        $(".table-inactive-book").dataTable().fnDestroy();
        $('#content-inactive-book').html(html.inactive_book);
        $(".table-inactive-book").dataTable(settings);

        $('#content-active-book').empty();
        $(".table-active-book").dataTable().fnDestroy();
        $('#content-active-book').html(html.active_book);
        $(".table-active-book").dataTable(settings);
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete book
    $("body").on("click", ".btn-delete-book", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToDelete = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'bookToDelete='+ bookToDelete,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {

            $('#content-active-book').empty();
            $(".table-active-book").dataTable().fnDestroy();
            $('#content-active-book').html(html.active_book);
            $(".table-active-book").dataTable(settings);

            $('#content-inactive-book').empty();
            $(".table-inactive-book").dataTable().fnDestroy();
            $('#content-inactive-book').html(html.inactive_book);
            $(".table-inactive-book").dataTable(settings);

        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });
	</script>

    <?php endif; ?>

	<?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

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

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

</body>
</html>
