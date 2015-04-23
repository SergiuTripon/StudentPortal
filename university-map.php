<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $active_location;
global $inactive_location;

AdminUniversityMapUpdate();

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

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'student' || $_SESSION['account_type'] == 'academic staff')) : ?>

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
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="university-map-portal" class="container">

	<ol class="breadcrumb breadcrumb-admin breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
    <li class="active">University map</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin" href="../admin/create-location/">Create location</a>

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
	<table class="table table-condensed table-custom table-active-location">

	<thead>
	<tr>
	<th>Location</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-location">
	<?php
    echo $active_location;
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
	<table class="table table-condensed table-custom table-inactive-location">

	<thead>
	<tr>
	<th>Location</th>
	<th>Latitude</th>
	<th>Longitude</th>
	<th>Category</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-location">
	<?php
    echo $inactive_location;
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
    $('.table-active-location').dataTable(settings);
    $('.table-inactive-location').dataTable(settings);

    //Deactivate location
    $("body").on("click", ".btn-deactivate-location", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'locationToDeactivate='+ locationToDeactivate,
	success:function(html){

        $(".table-active-location").dataTable().fnDestroy();
        $('#content-active-location').empty();
        $('#content-active-location').html(html.active_location);
        $(".table-active-location").dataTable(settings);

        $(".table-inactive-location").dataTable().fnDestroy();
        $('#content-inactive-location').empty();
        $('#content-inactive-location').html(html.inactive_location);
        $(".table-inactive-location").dataTable(settings);

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate location
    $("body").on("click", ".btn-reactivate-location", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'locationToReactivate='+ locationToReactivate,
	success:function(html){

        $(".table-inactive-location").dataTable().fnDestroy();
        $('#content-inactive-location').empty();
        $('#content-inactive-location').html(html.inactive_location);
        $(".table-inactive-location").dataTable(settings);

        $(".table-active-location").dataTable().fnDestroy();
        $('#content-active-location').empty();
        $('#content-active-location').html(html.active_location);
        $(".table-active-location").dataTable(settings);

	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete location
    $("body").on("click", ".btn-delete-location", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var locationToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'locationToDelete='+ locationToDelete,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $(".table-active-location").dataTable().fnDestroy();
            $('#content-active-location').empty();
            $('#content-active-location').html(html.active_location);
            $(".table-active-location").dataTable(settings);

            $(".table-inactive-location").dataTable().fnDestroy();
            $('#content-inactive-location').empty();
            $('#content-inactive-location').html(html.inactive_location);
            $(".table-inactive-location").dataTable(settings);
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
