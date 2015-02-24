<?php
include '../includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/datatables-css-path.php'; ?>
	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Update/Delete an account</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<div class="container">

    <?php include '../includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
	<li class="active">Update/Delete an account</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

	<?php
    //Update an account
	$stmt1 = $mysqli->query("SELECT user_signin.userid FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");
	while($row = $stmt1->fetch_assoc()) {
		echo '<form id="update-account-form-'.$row["userid"].'" style="display: none;" action="../update-an-account/" method="POST">
		<input type="hidden" name="userToUpdate" id="userToUpdate" value="'.$row["userid"].'"/>
		</form>';
	}
	$stmt1->close();
	?>

    <?php
    //Change an account's password
	$stmt2 = $mysqli->query("SELECT user_signin.userid FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");
	while($row = $stmt2->fetch_assoc()) {
		echo '<form id="change-password-form-'.$row["userid"].'" style="display: none;" action="../change-account-password/" method="POST">
		<input type="hidden" name="userToChangePassword" id="userToChangePassword" value="'.$row["userid"].'"/>
		</form>';
	}
	$stmt2->close();
	?>

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Users</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Update an account -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>User ID</th>
	<th>Full name</th>
	<th>Account type</th>
    <th>Created on</th>
	<th>Updated on</th>
	<th>Action</th>
    <th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt4 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_details.updated_on,'%d %b %y %H:%i') as updated_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt4->fetch_assoc()) {

	$account_type = ucfirst($row["account_type"]);

	echo '<tr id="user-'.$row["userid"].'">

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="Full name">'.$row["firstname"].' '.$row["surname"].'</td>
			<td data-title="Account type">'.$account_type.'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
            <td data-title="Updated on">'.$row["updated_on"].'</td>
			<td data-title="Update"><a id="update-'.$row["userid"].'" class="btn btn-primary btn-md update-button">Update</a></td>
            <td data-title="Change"><a id="change-'.$row["userid"].'" class="btn btn-primary btn-md change-button">Change</a></td>
            <td data-title="Delete"><a class="btn btn-primary btn-md delete-button" href="#modal-'.$row["userid"].'" data-toggle="modal">Delete</a></td>
			</tr>

			<!-- Delete an account modal -->
    		<div class="modal fade modal-custom" id="modal-'.$row["userid"].'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="form-logo text-center">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="feedback-custom text-center">Are you sure you want to delete this account?</p>
			</div>

			<div class="modal-footer">
			<div id="hide">
			<div class="pull-left">
			<a id="delete-'.$row["userid"].'" class="btn btn-danger btn-lg delete-button1 ladda-button" data-style="slide-up">Yes</a>
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
			</div><!-- /modal-content -->
			<!-- End of Delete an account modal -->';
	}

	$stmt4->close();
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

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

	<?php endif; ?>
	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

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

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>

	<script>
	$(document).ready(function () {

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

	//Change account password form submit
	$("body").on("click", ".change-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#change-password-form-" + DbNumberID).submit();

	});

	//Update an account form submit
	$("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-account-form-" + DbNumberID).submit();

	});

	//Delete an account ajax call
	$("body").on("click", ".delete-button1", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var userToDelete = clickedID[1];
    var myData = 'userToDelete='+ userToDelete;

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:myData,
	success:function(){
		$('#user-'+userToDelete).fadeOut();
		$('#hide').hide();
		$('.form-logo i').removeClass('fa-trash');
		$('.form-logo i').addClass('fa-check-square-o');
		$('.modal-body p').removeClass('feedback-custom');
		$('.modal-body p').addClass('feedback-happy');
		$('#success').empty().append('The account has been deleted successfully.');
		$('#success-button').show();
		$("#success-button").click(function () {
			location.reload();
		});
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

	});

	</script>

</body>
</html>
