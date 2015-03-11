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

	<ol class="breadcrumb breadcrumb-custom">
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

	<div class="panel-group panel-custom book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Available books</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Available books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_books.bookid, system_books.book_name, system_books.book_author, system_books.book_notes, system_books.book_copy_no, system_books.book_status FROM system_books LEFT JOIN system_books_reserved ON system_books.bookid=system_books_reserved.bookid LEFT JOIN system_books_requested ON system_books.bookid=system_books_requested.bookid WHERE system_books.book_status = 'active'");

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
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Action">'.($book_status === 'Reserved' ? "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/request-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Request</span></a>" : "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/reserve-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Reserve</span></a>").'</td>
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Available books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_books.bookid, system_books.book_name, system_books.book_author, system_books.book_notes, system_books.book_copy_no, system_books.book_status FROM system_books LEFT JOIN system_books_reserved ON system_books.bookid=system_books_reserved.bookid LEFT JOIN system_books_requested ON system_books.bookid=system_books_requested.bookid WHERE system_books.book_status = 'active'");

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
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Action">'.($book_status === 'Reserved' ? "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/request-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Request</span></a>" : "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/reserve-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Reserve</span></a>").'</td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Your reserved books</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Your reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Booked on</th>
	<th>Return on</th>
    <th>Returned on</th>
    <th>Returned</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT system_books_reserved.bookid, DATE_FORMAT(system_books_reserved.reserved_on,'%d %b %y') as reserved_on, DATE_FORMAT(system_books_reserved.toreturn_on,'%d %b %y') as toreturn_on, DATE_FORMAT(system_books_reserved.returned_on,'%d %b %y') as returned_on, system_books_reserved.isReturned, system_books.book_name, system_books.book_author, system_books.book_notes, system_books.book_status FROM system_books_reserved LEFT JOIN system_books ON system_books_reserved.bookid=system_books.bookid WHERE system_books_reserved.userid = '$session_userid'");

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
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Booked on">'.$reserved_on.'</td>
			<td data-title="Return on">'.$toreturn_on.'</td>
			<td data-title="Returned on">'.(empty($returned_on) ? "Not yet" : "$returned_on").'</td>
			<td data-title="Returned">'.($isReturned === '0' ? "No" : "Yes").'</td>
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

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Your requested books</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Requested books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
    <th>Name</th>
    <th>Author</th>
    <th>Notes</th>
    <th>Requested on</th>
    <th>Read</th>
    <th>Approved</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

    $stmt2 = $mysqli->query("SELECT system_books_requested.bookid, DATE_FORMAT(system_books_requested.requested_on,'%d %b %y') as requested_on, system_books_requested.isRead, system_books_requested.isApproved, system_books.book_name, system_books.book_author, system_books.book_notes, system_books.book_status FROM system_books_requested LEFT JOIN system_books ON system_books_requested.bookid=system_books.bookid  WHERE system_books_requested.userid = '$session_userid'");

    while($row = $stmt2->fetch_assoc()) {

        $bookid = $row["bookid"];
        $book_name = $row["book_name"];
        $book_author = $row["book_author"];
        $book_notes = $row["book_notes"];
        $requested_on = $row["requested_on"];
        $isRead = $row["isRead"];
        $isApproved = $row["isApproved"];
        $book_status = $row["book_status"];
        $book_status = ucfirst($book_status);

        echo '<tr>

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Requested on">'.$requested_on.'</td>
			<td data-title="Read">'.($isRead === '0' ? "No" : "Yes").'</td>
			<td data-title="Approved">'.($isApproved === '0' ? "No" : "Yes").'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../library/reserve-book?id='.$bookid.'" data-style="slide-up"><span class="ladda-label">Reserve</span></a></td>
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

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="library-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Library</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin ladda-button" data-style="slide-up" href="../admin/create-book/"><span class="ladda-label">Create book</span></a>

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
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
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

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td>
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-book?id='.$bookid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#deactivate-'.$bookid.'" data-toggle="modal">Deactivate</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div class="modal modal-custom fade" id="deactivate-'.$bookid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="deactivate-question" class="text-center feedback-sad">Are you sure you want to deactivate '.$book_name.'?</p>
			<p id="deactivate-confirmation" class="text-center feedback-happy" style="display: none;">'.$book_name.' has been deactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="deactivate-hide">
			<div class="pull-left">
			<a id="deactivate-'.$bookid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="deactivate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Notes</th>
	<th>Copy no.</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
		<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_books WHERE book_status = 'inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Notes">'.(empty($book_notes) ? "-" : "$book_notes").'</td>
			<td data-title="Copy no.">'.$book_copy_no.'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#reactivate-'.$bookid.'" data-toggle="modal">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$bookid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>

			</tr>

			<div class="modal modal-custom fade" id="reactivate-'.$bookid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="reactivate-question" class="text-center feedback-sad">Are you sure you want to reactivate '.$book_name.'?</p>
			<p id="reactivate-confirmation" class="text-center feedback-happy" style="display: none;">'.$book_name.' has been reactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="reactivate-hide">
			<div class="pull-left">
			<a id="reactivate-'.$bookid.'" class="btn btn-danger btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="reactivate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete '.$book_name.'?</p>
			<p id="delete-confirmation" class="text-center feedback-happy" style="display: none;">'.$book_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$bookid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Reserved books</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Reserved books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
    <th>Reserved by</th>
	<th>Name</th>
	<th>Author</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_books_reserved.bookid, system_books_reserved.userid, user_details.firstname, user_details.surname, system_books.book_name, system_books.book_author, system_books.book_status FROM system_books_reserved LEFT JOIN user_details ON system_books_reserved.userid=user_details.userid LEFT JOIN system_books ON system_books_reserved.bookid=system_books.bookid WHERE system_books.book_status = 'reserved'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
    $userid = $row["userid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];

	echo '<tr id="book-'.$bookid.'">

            <td data-title="Reserved by">'.$firstname.' '.$surname.'</td>
			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../messenger/message-user?id='.$userid.'" data-style="slide-up"><span class="ladda-label">Message</span></a></td>
            <td data-title="Action"><a id="return-'.$bookid.'" class="btn btn-primary btn-md return-button ladda-button" data-style="slide-up"><span class="ladda-label">Return</span></a></td>
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

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a id="request-read-trigger" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Requested books</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Requested books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom book-table">

	<thead>
	<tr>
    <th>Requested by</th>
	<th>Name</th>
	<th>Author</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_books_requested.requestid, system_books_requested.bookid, system_books_requested.userid, system_books_requested.isApproved, user_details.firstname, user_details.surname, system_books.book_name, system_books.book_author, system_books.book_status FROM system_books_requested LEFT JOIN user_details ON system_books_requested.userid=user_details.userid LEFT JOIN system_books ON system_books_requested.bookid=system_books.bookid WHERE system_books_requested.isApproved = '0'");

	while($row = $stmt1->fetch_assoc()) {

    $requestid = $row["requestid"];
	$bookid = $row["bookid"];
    $userid = $row["userid"];
    $isApproved = $row["isApproved"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];

	echo '<tr id="book-'.$requestid.'">

            <td data-title="Requested by">'.$firstname.' '.$surname.'</td>
			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../messenger/message-user?id='.$userid.'" data-style="slide-up"><span class="ladda-label">Message</span></a></td>
            <td data-title="Action"><a id="approve-'.$requestid.'" class="btn btn-primary btn-md ladda-button approve-button" data-style="slide-up"><span class="ladda-label">Approve request</span></a></td>
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
        //Event view/Calendar view toggle
        $("#calendar-content").hide();
        $(".book-tile").addClass("tile-selected");
        $(".book-tile p").addClass("tile-text-selected");
        $(".book-tile i").addClass("tile-text-selected");
    });

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
    $('.book-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no books to display."
		}
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
		$('#book-'+bookToReturn).fadeOut();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    var request_read;
    request_read = '1';

    $("#request-read-trigger").click(function (e) {
        e.preventDefault();

        jQuery.ajax({
            type: "POST",
            url: "https://student-portal.co.uk/includes/processes.php",
            data:'request_read=' + request_read,
            success:function() {
            },
            error:function (xhr, ajaxOptions, thrownError) {
            }
        });
    });

    $("body").on("click", ".approve-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var requestToApprove = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'requestToApprove='+ requestToApprove,
	success:function(){
		$('#book-'+requestToApprove).hide();
        location.reload();
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Deactivate book ajax call
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToDeactivate='+ bookToDeactivate,
	success:function(){
		$('#book-'+bookToDeactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#deactivate-question').hide();
        $('#deactivate-confirmation').show();
        $('#deactivate-hide').hide();
        $('#deactivate-success-button').show();
        $("#deactivate-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate book ajax call
    $("body").on("click", ".reactivate-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToReactivate='+ bookToReactivate,
	success:function(){
		$('#book-'+bookToReactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#reactivate-question').hide();
        $('#reactivate-confirmation').show();
        $('#reactivate-hide').hide();
        $('#reactivate-success-button').show();
        $("#reactivate-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete book ajax call
    $("body").on("click", ".delete-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToDelete = clickedID[1];
	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToDelete='+ bookToDelete,
	success:function(){
		$('#book-'+bookToDelete).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-question').hide();
        $('#delete-confirmation').show();
        $('#delete-hide').hide();
        $('#delete-success-button').show();
        $("#delete-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
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

</body>
</html>
