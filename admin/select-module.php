<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $userToCreateResults = $_GET['id'];

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
		<li><a href="../../overview/">Home</a></li>
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
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../create-result/?userid='.$userid.'&moduleid='.$moduleid.'" data-style="slide-up"><span class="ladda-label">Select</span></a></td>
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
	<table class="table table-condensed table-custom results-table">

	<thead>
	<tr>
	<th>Name</th>
    <th>Coursework mark</th>
    <th>Exam mark</th>
    <th>Overall mark</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid = '$userToCreateResults' AND user_result.result_status='active'");

	while($row = $stmt1->fetch_assoc()) {

	$resultid = $row["resultid"];
    $module_name = $row["module_name"];
    $result_coursework_mark = $row["result_coursework_mark"];
    $result_exam_mark = $row["result_exam_mark"];
    $result_overall_mark = $row["result_overall_mark"];

	echo '<tr id="result-'.$resultid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="../update-result/?id='.$resultid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#deactivate-'.$resultid.'" data-toggle="modal" data-toggle="modal" data-toggle="modal">Deactivate</a></li>
            <li><a href="#delete-'.$resultid.'" data-toggle="modal" data-toggle="modal" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div class="modal modal-custom fade" id="deactivate-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-minus-square-o"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="deactivate-question" class="text-center feedback-sad">Are you sure you want to deactivate this result for '.$module_name.'?</p>
            <p id="deactivate-confirmation" style="display: none;" class="text-center feedback-happy">The result for '.$module_name.' has been deactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="deactivate-hide">
			<div class="pull-left">
			<a id="deactivate-'.$resultid.'" class="btn btn-danger btn-lg deactivate-button ladda-button" data-style="slide-up">Yes</a>
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

            <div class="modal modal-custom fade" id="delete-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete this result for '.$module_name.'?</p>
            <p id="delete-confirmation" style="display: none;" class="text-center feedback-happy">The result for '.$module_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$resultid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Inactive results</a>
    </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Inactive results -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom results-table">

	<thead>
	<tr>
	<th>Name</th>
    <th>Coursework mark</th>
    <th>Exam mark</th>
    <th>Overall mark</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid = '$userToCreateResults' AND user_result.result_status='inactive'");

	while($row = $stmt1->fetch_assoc()) {

	$resultid = $row["resultid"];
    $module_name = $row["module_name"];
    $result_coursework_mark = $row["result_coursework_mark"];
    $result_exam_mark = $row["result_exam_mark"];
    $result_overall_mark = $row["result_overall_mark"];

	echo '<tr id="result-'.$resultid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
			<td data-title="Action">

			<div class="btn-group btn-action">
            <a class="btn btn-primary" href="#reactivate-'.$resultid.'" data-toggle="modal">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$resultid.'" data-toggle="modal" data-toggle="modal" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div class="modal modal-custom fade" id="reactivate-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-plus-square-o"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="reactivate-question" class="text-center feedback-sad">Are you sure you want to reactivate this result for '.$module_name.'?</p>
            <p id="reactivate-confirmation" style="display: none;" class="text-center feedback-happy">The result for '.$module_name.' has been reactivated successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="reactivate-hide">
			<div class="pull-left">
			<a id="reactivate-'.$resultid.'" class="btn btn-danger btn-lg reactivate-button ladda-button" data-style="slide-up">Yes</a>
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

			<div class="modal modal-custom fade" id="delete-'.$resultid.'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="delete-question" class="text-center feedback-sad">Are you sure you want to delete this result for '.$module_name.'?</p>
            <p id="delete-confirmation" style="display: none;" class="text-center feedback-happy">The result for '.$module_name.' has been deleted successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="delete-hide">
			<div class="pull-left">
			<a id="delete-'.$resultid.'" class="btn btn-danger btn-lg delete-button ladda-button" data-style="slide-up">Yes</a>
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
    <a class="btn btn-danger btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">Close</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

	<?php include '../includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

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
	<a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/tilejs-js-path.php'; ?>
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>

	<script>

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.module-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no modules to display."
		}
	});

    $('.results-table').dataTable({
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no results to display."
        }
    });

    //Deactivate result
    $("body").on("click", ".deactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'resultToDeactivate='+ resultToDeactivate,
	success:function(){
        $('#result-'+resultToDeactivate).hide();
        $('.form-logo i').removeClass('fa-minus-square-o');
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

    //Reactivate result
    $("body").on("click", ".reactivate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'resultToReactivate='+ resultToReactivate,
	success:function(errormsg){
        if (errormsg) {
            $('.modal-custom').modal('hide');
            $('#error-modal .modal-body p').empty().append(errormsg);
            $('#error-modal').modal('show');
        } else {
            $('#result-' + resultToReactivate).hide();
            $('.form-logo i').removeClass('fa-plus-square-o');
            $('.form-logo i').addClass('fa-check-square-o');
            $('#reactivate-question').hide();
            $('#reactivate-confirmation').show();
            $('#reactivate-hide').hide();
            $('#reactivate-success-button').show();
            $("#reactivate-success-button").click(function () {
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

    //Delete result
    $("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var resultToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'resultToDelete='+ resultToDelete,
	success:function(){
		$('#result-'+resultToDelete).hide();
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
	</script>

</body>
</html>
