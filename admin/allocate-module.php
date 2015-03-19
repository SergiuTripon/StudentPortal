<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $moduleToAllocate = $_GET['id'];

} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Allocate timetable</title>

    <?php include '../assets/css-paths/datatables-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
		<li><a href="../../overview/">Overview</a></li>
        <li><a href="../../timetable/">Timetable</a></li>
		<li class="active">Allocate timetable</li>
	</ol>

    <div id="moduleid" style="display: none !important;"><?php echo $moduleToAllocate; ?></div>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Unallocated students</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Allocated students -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Student number</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid NOT IN (SELECT DISTINCT(user_module.userid) FROM user_module WHERE user_module.moduleid = '$moduleToAllocate') AND user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
    $studentno = $row["studentno"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="user-'.$userid.'">

			<td data-title="Full name">'.$firstname.' '.$surname.'</td>
			<td data-title="Student number">'.$studentno.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#allocate-'.$userid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Allocate</span></a></td>
			</tr>

			<div id="allocate-'.$userid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-user-plus"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="allocate-question" class="text-center feedback-sad">Are you sure you want to allocate '.$firstname.' '.$surname.' to this module?</p>
            <p id="allocate-confirmation" style="display: none;" class="text-center feedback-happy">'.$firstname.' '.$surname.' has been allocated to this module successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="allocate-hide">
			<div class="pull-left">
			<a id="allocate-'.$userid.'" class="btn btn-danger btn-lg allocate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="allocate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Allocated students</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Unallocated students -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Student number</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt2 = $mysqli->query("SELECT user_signin.userid, user_details.studentno, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid IN (SELECT DISTINCT(user_module.userid) FROM user_module WHERE user_module.moduleid = '$moduleToAllocate') AND user_signin.account_type = 'student'");

	while($row = $stmt2->fetch_assoc()) {

	$userid = $row["userid"];
    $studentno = $row["studentno"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="user-'.$userid.'">

			<td data-title="First name">'.$firstname.' '.$surname.'</td>
			<td data-title="Student number">'.$studentno.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="#deallocate-'.$userid.'" data-toggle="modal" data-style="slide-up"><span class="ladda-label">Deallocate</span></a></td>
			</tr>

			<div id="deallocate-'.$userid.'" class="modal fade modal-custom" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-user-times"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="deallocate-question" class="text-center feedback-sad">Are you sure you want to deallocate '.$firstname.' '.$surname.' to this module?</p>
            <p id="deallocate-confirmation" style="display: none;" class="text-center feedback-happy">'.$firstname.' '.$surname.' has been deallocated from this module successfully.</p>
			</div>

			<div class="modal-footer">
			<div id="deallocate-hide">
			<div class="pull-left">
			<a id="deallocate-'.$userid.'" class="btn btn-danger btn-lg deallocate-button ladda-button" data-style="slide-up">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-success btn-lg ladda-button" data-style="slide-up" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="deallocate-success-button" class="btn btn-primary btn-lg ladda-button" style="display: none;" data-style="slide-up">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
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

    </div><!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

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

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/tilejs-js-path.php'; ?>
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>

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
			"emptyTable": "There are no users to display."
		}
	});

    //Allocate module
	$("body").on("click", ".allocate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToAllocate = clickedID[1];
    var moduleToAllocate = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToAllocate='+ userToAllocate + '&moduleToAllocate='+ moduleToAllocate,
	success:function(){
        $('#user-'+userToAllocate).hide();
        $('.form-logo i').removeClass('fa-user-plus');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#allocate-question').hide();
        $('#allocate-confirmation').show();
        $('#allocate-hide').hide();
        $('#allocate-success-button').show();
        $("#allocate-success-button").click(function () {
            location.reload();
        });
    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

    //Deallocate module
    $("body").on("click", ".deallocate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToDeallocate = clickedID[1];
    var moduleToDeallocate = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToDeallocate='+ userToDeallocate + '&moduleToDeallocate='+ moduleToDeallocate,
	success:function(){
        $('#user-'+userToDeallocate).hide();
        $('.form-logo i').removeClass('fa-user-times');
        $('.form-logo i').addClass('fa-check-square-o');
        $('#deallocate-question').hide();
        $('#deallocate-confirmation').show();
        $('#deallocate-hide').hide();
        $('#deallocate-success-button').show();
        $("#deallocate-success-button").click(function () {
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
