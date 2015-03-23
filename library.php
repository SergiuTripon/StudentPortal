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

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'lecturer')) : ?>

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

	$stmt1 = $mysqli->query("SELECT b.bookid, b.book_name, b.book_author, b.book_notes, b.book_copy_no, b.book_status FROM system_book b WHERE b.book_status='active'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);
    $isLoaned = $row["isLoaned"];

    $stmt2 = $mysqli->prepare("SELECT bookid FROM system_book_reserved WHERE userid=? AND bookid=? AND isCollected='0' AND reservation_status='active'");
    $stmt2->bind_param('ii', $session_userid, $bookid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($db_reserved_bookid);
    $stmt2->fetch();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("SELECT bookid FROM system_book_loaned WHERE userid=? AND bookid=? AND isReturned='0' AND loan_status='active'");
    $stmt3->bind_param('ii', $session_userid, $bookid);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($db_loaned_bookid);
    $stmt3->fetch();
    $stmt3->close();

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Book">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Reserve">'.($stmt2->num_rows == 0 ? "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/reserve-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Reserve</span></a>" : "Reserved by you").'</td>
            <td data-title="Request">'.($stmt3->num_rows == 0 ? "<a class=\"btn btn-primary btn-md ladda-button\" href=\"../library/request-book?id=$bookid\" data-style=\"slide-up\"><span class=\"ladda-label\">Reserve</span></a>" : "Requested by you").'</td>
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
	<th>Name</th>
	<th>Author</th>
	<th>Reserved on</th>
	<th>To collect by</th>
    <th>Collected on</th>
    <th>Collected</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT r.bookid, DATE_FORMAT(r.created_on,'%d %b %y') as created_on, DATE_FORMAT(r.tocollect_on,'%d %b %y') as tocollect_on, DATE_FORMAT(r.collected_on,'%d %b %y') as collected_on, r.isCollected, b.book_name, b.book_author, b.book_notes, b.book_status FROM system_book_reserved r LEFT JOIN system_book b ON r.bookid=b.bookid WHERE r.userid = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $book_name = $row["book_name"];
    $book_author = $row["book_author"];
    $book_notes = $row["book_notes"];
    $created_on = $row["created_on"];
    $tocollect_on = $row["tocollect_on"];
    $collected_on = $row["collected_on"];
	$book_status = $row["book_status"];
    $isCollected = $row["isCollected"];

	$book_status = ucfirst($book_status);

	echo '<tr>

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Reserved on">'.$created_on.'</td>
			<td data-title="To collect by">'.$tocollect_on.'</td>
			<td data-title="Collected on">'.(empty($collected_on) ? "Not yet" : "$collected_on").'</td>
			<td data-title="Collected">'.($isCollected === '0' ? "No" : "Yes").'</td>
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
	<th>Name</th>
	<th>Author</th>
	<th>Loaned on</th>
	<th>To return by</th>
    <th>Returned on</th>
    <th>Returned</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT l.bookid, DATE_FORMAT(l.created_on,'%d %b %y') as created_on, DATE_FORMAT(l.toreturn_on,'%d %b %y') as toreturn_on, DATE_FORMAT(l.returned_on,'%d %b %y') as returned_on, l.isReturned, b.book_name, b.book_author, b.book_notes, b.book_status FROM system_book_loaned l LEFT JOIN system_book b ON l.bookid=b.bookid WHERE l.userid = '$session_userid'");

	while($row = $stmt2->fetch_assoc()) {

    $book_name = $row["book_name"];
    $book_author = $row["book_author"];
    $book_notes = $row["book_notes"];
    $book_status = $row["book_status"];
    $created_on = $row["created_on"];
    $toreturn_on = $row["toreturn_on"];
    $returned_on = $row["returned_on"];
    $isReturned = $row["isReturned"];

	$book_status = ucfirst($book_status);

	echo '<tr>

			<td data-title="Name">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Loaned on">'.$created_on.'</td>
			<td data-title="To return by">'.$toreturn_on.'</td>
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
    $stmt1 = $mysqli->query("SELECT r.bookid, DATE_FORMAT(r.created_on,'%d %b %y') as created_on, r.isRead, r.isApproved, b.book_name, b.book_author, b.book_notes, b.book_status FROM system_book_requested r LEFT JOIN system_book b ON r.bookid=b.bookid  WHERE r.userid = '$session_userid'");

    while($row = $stmt1->fetch_assoc()) {

        $bookid = $row["bookid"];
        $book_name = $row["book_name"];
        $book_author = $row["book_author"];
        $book_notes = $row["book_notes"];
        $created_on = $row["created_on"];
        $isRead = $row["isRead"];
        $isApproved = $row["isApproved"];

        echo '<tr>

			<td data-title="Book">'.$book_name.'</td>
			<td data-title="Author">'.$book_author.'</td>
			<td data-title="Requested on">'.$created_on.'</td>
			<td data-title="Read">'.($isRead === '0' ? "No" : "Yes").'</td>
			<td data-title="Approved">'.($isApproved === '0' ? "No" : "Yes").'</td>
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
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_book WHERE book_status = 'active' OR book_status='reserved' OR book_status='requested'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];
	$book_status = $row["book_status"];
	$book_status = ucfirst($book_status);

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Name"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
			<td>
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-book?id='.$bookid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#deactivate-'.$bookid.'" data-toggle="modal">Deactivate</a></li>
            <li><a href="#delete-'.$bookid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div id="view-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$book_name.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$book_author.'</p>
			<p><b>Description:</b> '.(empty($book_notes) ? "-" : "$book_notes").'</p>
			<p><b>Copy number</b> '.(empty($book_copy_no) ? "-" : "$book_copy_no").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-book?id='.$bookid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Update</a>
            <a href="#deactivate-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Deactivate</a>
            <a href="#delete-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="deactivate-'.$bookid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div><!-- /modal-content -->

			<div id="delete-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive books</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Name</th>
	<th>Author</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT bookid, book_name, book_author, book_notes, book_copy_no, book_status FROM system_book WHERE book_status = 'inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
	$book_notes = $row["book_notes"];
	$book_copy_no = $row["book_copy_no"];

	echo '<tr id="book-'.$bookid.'">

			<td data-title="Name"><a href="#view-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
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

            <div id="view-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#reactivate-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Reactivate</a>
            <a href="#delete-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="reactivate-'.$bookid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			<a id="reactivate-'.$bookid.'" class="btn btn-success btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="reactivate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="delete-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			<a id="delete-'.$bookid.'" class="btn btn-success btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
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
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
    <th>Reserved by</th>
	<th>Name</th>
	<th>Author</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT r.bookid, r.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_notes, b.book_copy_no FROM system_book_reserved r LEFT JOIN user_detail d ON r.userid=d.userid LEFT JOIN system_book b ON r.bookid=b.bookid WHERE b.isReserved = '1' AND r.isCollected = '0'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
    $userid = $row["userid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);
    $dateofbirth = $row["dateofbirth"];
    $nationality = $row["nationality"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
    $book_notes = $row["book_notes"];
    $book_copy_no = $row["book_copy_no"];

	echo '<tr id="book-'.$bookid.'">

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

            <div id="view-reserved-user-'.$userid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$gender.'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-reserved-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#collect-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Mark collected</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="collect-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="collect-question" class="text-center feedback-sad">Are you sure you want to mark '.$book_name.' collected?</p>
            <p id="collect-confirmation" style="display: none;" class="text-center feedback-happy">'.$book_name.' has been marked collected successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="collect-hide">
			<div class="pull-left">
			<a id="collect-'.$bookid.'" class="btn btn-success btn-lg collect-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="collect-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

    <div class="panel-heading" role="tab" id="headingFour">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Loaned books</a>
  	</h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
  	<div class="panel-body">

	<!-- Loaned books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

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

	$stmt1 = $mysqli->query("SELECT DISTINCT l.bookid, l.userid, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_notes, b.book_copy_no FROM system_book_loaned l LEFT JOIN system_book_reserved r ON l.bookid=r.bookid LEFT JOIN user_detail d ON l.userid=d.userid LEFT JOIN system_book b ON l.bookid=b.bookid WHERE b.isReserved = '1' AND r.isCollected = '1' AND b.isLoaned = '1' AND l.isReturned='0'");

	while($row = $stmt1->fetch_assoc()) {

	$bookid = $row["bookid"];
    $userid = $row["userid"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);
    $dateofbirth = $row["dateofbirth"];
    $nationality = $row["nationality"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];
    $book_notes = $row["book_notes"];
    $book_copy_no = $row["book_copy_no"];

	echo '<tr id="book-'.$bookid.'">

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
            </td>
			</tr>

            <div id="view-loaned-user-'.$userid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$gender.'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-loaned-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#return-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Mark returned</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="return-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="return-question" class="text-center feedback-sad">Are you sure you want to mark '.$book_name.' returned?</p>
            <p id="return-confirmation" style="display: none;" class="text-center feedback-happy">'.$book_name.' has been marked returned successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="return-hide">
			<div class="pull-left">
			<a id="return-'.$bookid.'" class="btn btn-success btn-lg return-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="return-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

    <div class="panel-heading" role="tab" id="headingFive">
  	<h4 class="panel-title">
	<a id="request-read-trigger" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive"> Requested books</a>
  	</h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
  	<div class="panel-body">

	<!-- Requested books -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

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

	$stmt1 = $mysqli->query("SELECT r.requestid, r.bookid, r.userid, r.isApproved, d.firstname, d.surname, d.gender, d.dateofbirth, d.nationality, b.book_name, b.book_author, b.book_status FROM system_book_requested r LEFT JOIN system_book b ON r.bookid=b.bookid LEFT JOIN user_detail d ON r.userid=d.userid WHERE r.isApproved = '0'");

	while($row = $stmt1->fetch_assoc()) {

    $requestid = $row["requestid"];
	$bookid = $row["bookid"];
    $userid = $row["userid"];
    $isApproved = $row["isApproved"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];
    $gender = $row["gender"];
    $gender = ucfirst($gender);
    $dateofbirth = $row["dateofbirth"];
    $nationality = $row["nationality"];
	$book_name = $row["book_name"];
	$book_author = $row["book_author"];

	echo '<tr id="book-'.$requestid.'">

            <td data-title="Requested by"><a href="#view-requested-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Name"><a href="#view-requested-book-'.$bookid.'" data-toggle="modal">'.$book_name.'</a></td>
			<td data-title="Author">'.$book_author.'</td>
            <td data-title="Action">
			<div class="btn-group btn-action">
            <a href="#approve-'.$requestid.'" class="btn btn-primary btn-md" data-toggle="modal">Approve request</a>
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

            <div id="view-requested-user-'.$userid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-book"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Author:</b> '.$gender.'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="../messenger/message-user?id='.$userid.'" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Message user</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="view-requested-book-'.$bookid.'" class="modal fade modal-custom" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="#return-'.$bookid.'" data-toggle="modal" data-dismiss="modal" class="btn btn-primary btn-sm ladda-button" data-style="slide-up">Return book</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-sm ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="return-'.$bookid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="return-question" class="text-center feedback-sad">Are you sure you want to return '.$book_name.'?</p>
            <p id="return-confirmation" style="display: none;" class="text-center feedback-happy">'.$book_name.' has been returned successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="return-hide">
			<div class="pull-left">
			<a id="return-'.$bookid.'" class="btn btn-success btn-lg return-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="return-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

            <div id="approve-'.$requestid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="approve-question" class="text-center feedback-sad">Are you sure you want to approve a request for '.$book_name.'?</p>
            <p id="approve-confirmation" style="display: none;" class="text-center feedback-happy">The request for '.$book_name.' has been approved successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="approve-hide">
			<div class="pull-left">
			<a id="approve-'.$requestid.'" class="btn btn-success btn-lg approve-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="approve-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
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
    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no records to display."
		}
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

    //Collect book
    $("body").on("click", ".collect-button", function(e) {
    e.preventDefault();
    var clickedID = this.id.split('-');
    var bookToCollect = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'bookToCollect='+ bookToCollect,
	success:function(){
        $('#book-'+bookToCollect).fadeOut();
        $('.form-logo i').removeClass('fa-book');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#collect-question').hide();
        $('#collect-confirmation').show();
        $('#collect-hide').hide();
        $('#collect-success-button').show();
        $("#collect-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Return book
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
        $('.form-logo i').removeClass('fa-book');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#return-question').hide();
        $('#return-confirmation').show();
        $('#return-hide').hide();
        $('#return-success-button').show();
        $("#return-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
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
        $('#book-'+requestToApprove).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#approve-question').hide();
        $('#approve-confirmation').show();
        $('#approve-hide').hide();
        $('#approve-success-button').show();
        $("#approve-success-button").click(function () {
            location.reload();
        });
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
