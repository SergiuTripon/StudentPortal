<?php
include 'includes/session.php';
include 'includes/functions.php';

global $mysqli;
global $session_userid;

global $active_exam;
global $inactive_exam;

AdminTimetableUpdate();

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Exams</title>

    <?php include 'assets/css-paths/datatables-css-path.php'; ?>
    <?php include 'assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="exams-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Exams</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Exams</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Exams -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Name</th>
	<th>Date</th>
    <th>Time</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT e.exam_name, DATE_FORMAT(e.exam_date,'%d %b %y') as exam_date, DATE_FORMAT(e.exam_time,'%H:%i') as exam_time, e.exam_location, e.exam_capacity FROM user_exam u LEFT JOIN system_exam e ON u.examid=e.examid WHERE e.exam_status='active' AND u.userid = '$session_userid'");

	while($row = $stmt1->fetch_assoc()) {

    $exam_name = $row["exam_name"];
    $exam_date = $row["exam_date"];
    $exam_time = $row["exam_time"];
    $exam_location = $row["exam_location"];
    $exam_capacity = $row["exam_capacity"];


	echo '<tr>

			<td data-title="Name">'.$exam_name.'</td>
			<td data-title="Date">'.$exam_date.'</td>
			<td data-title="Time">'.$exam_time.'</td>
			<td data-title="Location">'.$exam_location.'</td>
			<td data-title="Capacity">'.$exam_capacity.'</td>
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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom breadcrumb-admin">
    <li><a href="../home/">Home</a></li>
	<li class="active">Exams</li>
    </ol>

    <a class="btn btn-success btn-lg btn-admin" href="/admin/create-exam/">Create exam</span></a>


    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Active exams</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Active exams -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-active-exam">

	<thead>
	<tr>
	<th>Name</th>
	<th>Date</th>
    <th>Time</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-active-exam">
	<?php
    echo $active_exam;
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Inactive exams</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Inactive exams -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom table-inactive-exam">

	<thead>
	<tr>
	<th>Name</th>
	<th>Date</th>
    <th>Time</th>
    <th>Location</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="content-inactive-exam">
	<?php
    echo $inactive_exam;
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

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

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>

	<script>



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

    //Deactivate module
    $("body").on("click", ".deactivate-exam-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var examToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'examToDeactivate='+ examToDeactivate,
	success:function(){
		$('#exam-'+examToDeactivate).hide();
        $('.form-logo i').removeClass('fa-plus-square-o');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#deactivate-exam-question').hide();
        $('#deactivate-exam-confirmation').show();
        $('#deactivate-exam-hide').hide();
        $('#deactivate-exam-success-button').show();
        $("#deactivate-exam-success-button").click(function () {
            location.reload();
        });
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Reactivate module
    $("body").on("click", ".reactivate-exam-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var examToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'examToReactivate='+ examToReactivate,
	success:function(errormsg){
        if (errormsg) {
            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(errormsg);
            $('#error-modal').modal('show');
        } else {
            $('#exam-' + examToReactivate).hide();
            $('.form-logo i').removeClass('fa-minus-square-o');
            $('.form-logo i').addClass('fa-check-square-o');
            $('#reactivate-exam-question').hide();
            $('#reactivate-exam-confirmation').show();
            $('#reactivate-exam-hide').hide();
            $('#reactivate-exam-success-button').show();
            $("#reactivate-exam-success-button").click(function () {
                location.reload();
            });
        }
	},
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Delete module
    $("body").on("click", ".delete-exam-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var examToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'examToDelete='+ examToDelete,
	success:function(){
		$('#exam-'+examToDelete).hide();
        $('.form-logo i').removeClass('fa-trash');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#delete-exam-question').hide();
        $('#delete-exam-confirmation').show();
        $('#delete-exam-hide').hide();
        $('#delete-exam-success-button').show();
        $("#delete-exam-success-button").click(function () {
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
