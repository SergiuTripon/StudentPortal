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
    <li class="active">University map</li>
    </ol>

    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="../admin/create-location/"><span class="ladda-label">Create location</span></a>

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
	<table class="table table-condensed table-custom location-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
	<th>Created on</th>
    <th>Updated on</th>
    <th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_markers WHERE marker_status='active'");

	while($row = $stmt1->fetch_assoc()) {

	$markerid = $row["markerid"];
    $marker_name = $row["marker_name"];
    $marker_lat = $row["marker_lat"];
    $marker_long = $row["marker_long"];
    $marker_category = ucfirst($row["marker_category"]);
    $created_on = $row["created_on"];
    $updated_on = $row["updated_on"];


	echo '<tr id="location-'.$markerid.'">

			<td data-title="Name">'.$marker_name.'</td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.$marker_category.'</td>
			<td data-title="Created on">'.$created_on.'</td>
			<td data-title="Updated on">'.$updated_on.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../admin/update-location/?id='.$markerid.'" data-style="slide-up"><span class="ladda-label">Update</span></a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#deactivate-'.$markerid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Deactivate</span></a></td>
			</tr>

			<div class="modal modal-custom fade" id="deactivate-'.$markerid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="text-center feedback-sad">Are you sure you want to deactivate '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="hide-deactivate">
			<div class="pull-left">
			<a id="deactivate-'.$markerid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-deactivate" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Inactive locations</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Inactive locations -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom location-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
	<th>Created on</th>
    <th>Updated on</th>
    <th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT markerid, marker_name, marker_lat, marker_long, marker_category, DATE_FORMAT(created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM system_map_markers WHERE marker_status='inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$markerid = $row["markerid"];
    $marker_name = $row["marker_name"];
    $marker_lat = $row["marker_lat"];
    $marker_long = $row["marker_long"];
    $marker_category = ucfirst($row["marker_category"]);
    $created_on = $row["created_on"];
    $updated_on = $row["updated_on"];


	echo '<tr id="location-'.$markerid.'">

			<td data-title="Name">'.$marker_name.'</td>
			<td data-title="Latitude">'.$marker_lat.'</td>
			<td data-title="Longitude">'.$marker_long.'</td>
			<td data-title="Category">'.$marker_category.'</td>
			<td data-title="Created on">'.$created_on.'</td>
			<td data-title="Updated on">'.$updated_on.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#reactivate-'.$markerid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Reactivate</span></a></td>
            <td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#delete-'.$markerid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Delete</span></a></td>
			</tr>

			<div class="modal modal-custom fade" id="reactivate-'.$markerid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p class="text-center feedback-sad">Are you sure you want to reactivate '.$marker_name.'?</p>
			</div>

			<div class="modal-footer">
			<div id="hide-reactivate">
			<div class="pull-left">
			<a id="reactivate-'.$markerid.'" class="btn btn-danger btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-reactivate" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div class="modal modal-custom fade" id="delete-'.$markerid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
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
			<div id="hide-delete">
			<div class="pull-left">
			<a id="delete-'.$markerid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button-delete" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
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
		$('#location-'+locationToDeactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been deactivated successfully.');
        $('#hide-deactivate').hide();
        $('#success-button-deactivate').show();
        $("#success-button-deactivate").click(function () {
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
		$('#location-'+locationToReactivate).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been reactivated successfully.');
        $('#hide-reactivate').hide();
        $('#success-button-reactivate').show();
        $("#success-button-reactivate").click(function () {
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
		$('#location-'+locationToDelete).fadeOut();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('.modal-body p').removeClass('feedback-sad');
        $('.modal-body p').addClass('feedback-happy');
        $('.modal-body p').empty().append('The location has been deleted successfully.');
        $('#hide-delete').hide();
        $('#success-button-delete').show();
        $("#success-button-delete").click(function () {
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
