<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

	<?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | University Map</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'lecturer')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="events-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">University Map</li>
    </ol>

	<div class="row mb10">

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
    <a href="../university-map/overview/">
    <div class="tile">
	<i class="fa fa-university"></i>
	<p class="tile-text">See all locations</p>
    </div>
    </a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
    <a href="../university-map/search/">
	<div class="tile">
    <i class="fa fa-search-plus"></i>
	<p class="tile-text">Search for a location</p>
    </div>
    </a>
	</div>

	</div><!-- /row -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

	<?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Events</li>
    </ol>

    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="../admin/create-event/"><span class="ladda-label">Create location</span></a>

    <div class="panel-group book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Locations</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Locations -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom event-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>From</th>
	<th>To</th>
	<th>Price</th>
	<th>Tickets</th>
	<th>Category</th>
	<th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT eventid, event_name, DATE_FORMAT(event_from,'%d %b %y %H:%i') as event_from, DATE_FORMAT(event_to,'%d %b %y %H:%i') as event_to, event_amount, event_ticket_no, event_category FROM system_events WHERE event_status = 'active'");

	while($row = $stmt1->fetch_assoc()) {

	$eventid = $row["eventid"];
	$event_name = $row["event_name"];
	$event_from = $row["event_from"];
	$event_to = $row["event_to"];
	$event_amount = $row["event_amount"];
	$event_ticket_no = $row["event_ticket_no"];
	$event_category = ucfirst($row["event_category"]);

	echo '<tr id="event-'.$row["eventid"].'">

			<td data-title="Name">'.$event_name.'</td>
			<td data-title="From">'.$event_from.'</td>
			<td data-title="To">'.$event_to.'</td>
			<td data-title="Price">'.$event_amount.'</td>
			<td data-title="Tickets">'.($event_ticket_no === '0' ? "Sold Out" : "$event_ticket_no").'</td>
			<td data-title="Category">'.$event_category.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../admin/update-event/?id='.$eventid.'" data-style="slide-up"><span class="ladda-label">Update</span></a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button delete-trigger" href="#modal-'.$eventid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Delete</span></a></td>
			</tr>

			<div class="modal modal-custom fade" id="modal-'.$eventid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="text-center feedback-sad">Are you sure you want to delete this account?</p>
			</div>

			<div class="modal-footer">
			<div id="hide">
			<div class="pull-left">
			<a id="delete-'.$eventid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.location-table').dataTable({
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no locations to display."
        }
    });

    </script>

</body>
</html>
