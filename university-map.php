<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/datatables-css-path.php'; ?>
    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | University Map</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'lecturer')) : ?>

	<?php include 'includes/menus/portal_menu.php'; ?>

	<div id="university-map-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">University Map</li>
    </ol>

	<div class="row mb10">

    <a href="../university-map/location-overview/">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="tile">
	<i class="fa fa-university"></i>
	<p class="tile-text">See all locations</p>
    </div>
	</div>
    </a>

    <a href="../university-map/location-search/">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	<div class="tile">
    <i class="fa fa-search-plus"></i>
	<p class="tile-text">Search for a location</p>
    </div>
	</div>
    </a>

	</div><!-- /row -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

	<?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

	<ol class="breadcrumb breadcrumb-admin breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
    <li class="active">University map</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin" href="../admin/create-location/"><span class="ladda-label">Create location</span></a>

    <div class="panel-group panel-custom book-view" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Active locations</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Locations -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Location</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
	<th>Created on</th>
    <th>Updated on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_marker WHERE marker_status='active'");

	while($row = $stmt1->fetch_assoc()) {

	$markerid = $row["markerid"];
    $marker_name = $row["marker_name"];
    $marker_lat = $row["marker_lat"];
    $marker_long = $row["marker_long"];
    $marker_category = ucfirst($row["marker_category"]);
    $created_on = $row["created_on"];
    $updated_on = $row["updated_on"];


	echo '<tr id="location-'.$markerid.'">

			<td data-title="Location">'.$marker_name.'</td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.$marker_category.'</td>
			<td data-title="Created on">'.$created_on.'</td>
			<td data-title="Updated on">'.(empty($updated_on) ? "-" : "$updated_on").'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../admin/update-location/?id='.$markerid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#deactivate-'.$markerid.'" data-toggle="modal">Deactivate</a></li>
            <li><a href="#delete-'.$markerid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div class="modal modal-custom fade" id="deactivate-'.$markerid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-minus-square-o"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="text-center feedback-sad">Are you sure you want to deactivate '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="deactivate-hide">
			<div class="pull-left">
			<a id="deactivate-'.$markerid.'" class="btn btn-danger btn-lg deactivate-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="deactivate-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="delete-'.$markerid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to delete '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$markerid.'" class="btn btn-danger btn-lg delete-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive locations</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive locations -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Location</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
	<th>Created on</th>
    <th>Updated on</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_marker WHERE marker_status='inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$markerid = $row["markerid"];
    $marker_name = $row["marker_name"];
    $marker_lat = $row["marker_lat"];
    $marker_long = $row["marker_long"];
    $marker_category = ucfirst($row["marker_category"]);
    $created_on = $row["created_on"];
    $updated_on = $row["updated_on"];


	echo '<tr id="location-'.$markerid.'">

			<td data-title="Location">'.$marker_name.'</td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.$marker_category.'</td>
			<td data-title="Created on">'.$created_on.'</td>
			<td data-title="Updated on">'.(empty($updated_on) ? "-" : "$updated_on").'</td>
			<td data-title="Action">
			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#reactivate-'.$markerid.'" data-toggle="modal">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$markerid.'" data-toggle="modal" data-dismiss="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div class="modal modal-custom fade" id="reactivate-'.$markerid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-plus-square-o"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to reactivate '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="reactivate-hide">
			<div class="pull-left">
			<a id="reactivate-'.$markerid.'" class="btn btn-danger btn-lg reactivate-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="reactivate-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="delete-'.$markerid.'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to delete '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$markerid.'" class="btn btn-danger btn-lg delete-button" >Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="delete-success-button" class="btn btn-primary btn-lg" style="display: none;" >Continue</a>
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

    <?php endif; ?>

    <?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg" href="/"><span class="ladda-label">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/datatables-js-path.php'; ?>

    <script>

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

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

    //Deactivate location
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'locationToDeactivate='+ locationToDeactivate,
	success:function(){
		$('#location-'+locationToDeactivate).hide();
        $('.form-logo i').removeClass('fa-minus-square-o');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been deactivated successfully.');
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

    //Reactivate location
    $("body").on("click", ".reactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'locationToReactivate='+ locationToReactivate,
	success:function(){
		$('#location-'+locationToReactivate).hide();
        $('.form-logo i').removeClass('fa-plus-square-o');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been reactivated successfully.');
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

    //Delete location
    $("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'locationToDelete='+ locationToDelete,
	success:function(){
		$('#location-'+locationToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been deleted successfully.');
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

    </script>

</body>
</html>
