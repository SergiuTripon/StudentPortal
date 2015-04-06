<?php
include '../includes/session.php';
include '../includes/functions.php';

global $session_userid;
global $mysqli;

global $userToCreateResults;
global $active_result;
global $inactive_result;

if (isset($_GET['id'])) {
    $userToCreateResults = $_GET['id'];

    AdminTimetableUpdate();

} else {
    header('Location: ../../results/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Select module</title>

    <?php include '../assets/css-paths/datatables-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
		<li><a href="../../home/">Home</a></li>
        <li><a href="../../results/">Results</a></li>
		<li class="active">Select modules</li>
	</ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Modules</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Name</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT u.userid, u.moduleid, m.module_name FROM user_module u LEFT JOIN system_module m ON u.moduleid=m.moduleid LEFT JOIN user_result r ON u.moduleid=r.moduleid WHERE u.userid NOT IN (SELECT DISTINCT(r.userid) FROM user_result r WHERE r.userid = '$session_userid' AND r.result_status='active') AND m.module_status='active'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
    $moduleid = $row["moduleid"];
    $module_name = $row["module_name"];

	echo '<tr id="allocate-'.$userid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md" href="../create-result/?userid='.$userid.'&moduleid='.$moduleid.'" >Select</span></a></td>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Active results</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Active results -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-result">

	<thead>
	<tr>
	<th>Name</th>
    <th>Coursework mark</th>
    <th>Exam mark</th>
    <th>Overall mark</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-result">
    <?php
    echo $active_result;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Inactive results</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Inactive results -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-result">

	<thead>
	<tr>
	<th>Name</th>
    <th>Coursework mark</th>
    <th>Exam mark</th>
    <th>Overall mark</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-result">
    <?php
    echo $inactive_result;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

    <div id="error-modal" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
    <div class="form-logo text-center">
    <i class="fa fa-exclamation"></i>
    </div>
    </div>

    <div class="modal-body">
    <p class="text-center feedback-sad"></p>
    </div>

    <div class="modal-footer">
    <div class="view-close text-center">
    <a class="btn btn-danger btn-lg" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

	<?php include '../includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>
    <?php include '../assets/js-paths/tilejs-js-path.php'; ?>
    <?php include '../assets/js-paths/datatables-js-path.php'; ?>

    <script>

    //DataTables
    settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

    $('.table-active-result').dataTable(settings);
    $('.table-inactive-result').dataTable(settings);

    //Deactivate result
    $("body").on("click", ".btn-deactivate-result", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'resultToDeactivate='+ resultToDeactivate,
	success:function(html){

        $(".table-active-result").dataTable().fnDestroy();
        $('#content-active-result').empty();
        $('#content-active-result').html(html.active_result);
        $(".table-active-result").dataTable(settings);

        $(".table-inactive-result").dataTable().fnDestroy();
        $('#content-inactive-result').empty();
        $('#content-inactive-result').html(html.inactive_result);
        $(".table-inactive-result").dataTable(settings);

    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate result
    $("body").on("click", ".btn-reactivate-result", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'resultToReactivate='+ resultToReactivate,
	success:function(html){
        if (html.error_msg) {
            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(html.error_msg);
            $('#error-modal').modal('show');
        } else {
            $(".table-inactive-result").dataTable().fnDestroy();
            $('#content-inactive-result').empty();
            $('#content-inactive-result').html(html.inactive_result);
            $(".table-inactive-result").dataTable(settings);

            $(".table-active-result").dataTable().fnDestroy();
            $('#content-active-result').empty();
            $('#content-active-result').html(html.active_result);
            $(".table-active-result").dataTable(settings);
        }
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete result
    $("body").on("click", ".btn-delete-result", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"json",
	data:'resultToDelete='+ resultToDelete,
	success:function(html){

        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
            $(".table-active-result").dataTable().fnDestroy();
            $('#content-active-result').empty();
            $('#content-active-result').html(html.active_result);
            $(".table-active-result").dataTable(settings);

            $(".table-inactive-result").dataTable().fnDestroy();
            $('#content-inactive-result').empty();
            $('#content-inactive-result').html(html.inactive_result);
            $(".table-inactive-result").dataTable(settings);
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });
	</script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

</body>
</html>
