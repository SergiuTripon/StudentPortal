<?php
include '../includes/signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
	$stmt3 = $mysqli->query("SELECT user_signin.userid FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");
	while($row = $stmt3->fetch_assoc()) {
		echo '<form id="update-account-form-'.$row["userid"].'" style="display: none;" action="../update-an-account/" method="POST">
		<input type="hidden" name="recordToUpdate" id="recordToUpdate" value="'.$row["userid"].'"/>
		</form>';
	}
	$stmt3->close();
	?>

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Update an account</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Update an account -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>User ID</th>
	<th>First name</th>
	<th>Surname</th>
	<th>Email address</th>
	<th>Account type</th>
	<th>Created on</th>
	<th>Updated on</th>
	<th>Update</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt4 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_details.updated_on,'%d %b %y %H:%i') as updated_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt4->fetch_assoc()) {

	$account_type = ucfirst($row["account_type"]);

	echo '<tr>

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$account_type.'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Updated on">'.$row["updated_on"].'</td>
			<td data-title="Update"><a id="update-'.$row["userid"].'" class="update-button"><i class="fa fa-refresh"></i></a></td>
			</tr>';
	}

	$stmt4->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	<div class="panel panel-default">

	<?php
	$stmt1 = $mysqli->query("SELECT user_signin.userid FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");
	while($row = $stmt1->fetch_assoc()) {
		echo '<form id="change-password-form-'.$row["userid"].'" style="display: none;" action="../change-account-password/" method="POST">
		<input type="hidden" name="recordToChange" id="recordToChange" value="'.$row["userid"].'"/>
		</form>';
	}
	$stmt1->close();
	?>

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Change an account's password</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Change an account's password -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>User ID</th>
	<th>First name</th>
	<th>Surname</th>
	<th>Email address</th>
	<th>Account type</th>
	<th>Created on</th>
	<th>Change</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt2->fetch_assoc()) {

	$account_type = ucfirst($row["account_type"]);

	echo '<tr>

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$account_type.'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Change"><a id="change-'.$row["userid"].'" class="change-button" href="#modal-help" data-toggle="modal"><i class="fa fa-lock"></i></a></td>
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

	<?php
	$stmt5 = $mysqli->query("SELECT user_signin.userid FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");
	while($row = $stmt5->fetch_assoc()) {
		echo '<form id="delete-account-form-'.$row["userid"].'" style="display: none;" action="../delete-an-account/" method="POST">
		<input type="hidden" name="recordToDelete" id="recordToDelete" value="'.$row["userid"].'"/>
		</form>';
	}
	$stmt5->close();
	?>

    <div class="panel-heading" role="tab" id="headingThree">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Delete an account</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Delete an account -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>User ID</th>
	<th>First name</th>
	<th>Surname</th>
	<th>Email address</th>
	<th>Account type</th>
	<th>Created on</th>
	<th>Delete</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt6 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt6->fetch_assoc()) {

	$account_type = ucfirst($row["account_type"]);

	echo '<tr id="user-'.$row["userid"].'">

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$account_type.'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Delete"><a href="#modal-'.$row["userid"].'" data-toggle="modal"><i class="fa fa-close"></i></a></td>
			</tr>

			<!-- Delete an account modal -->
    		<div class="modal fade modal-custom" id="modal-'.$row["userid"].'" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
			<div class="logo-custom">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">
			<p id="success" class="feedback-custom text-center">Are you sure you want to delete this account?</p>
			</div>

			<div class="modal-footer">
			<div id="hide">
			<div class="pull-left">
			<a id="delete-'.$row["userid"].'" class="btn btn-custom btn-lg delete-button ladda-button" data-style="slide-up" data-spinner-color="#FFA500">Yes</a>
			</div>
			<div class="text-right">
			<button type="button" class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" data-dismiss="modal">No</button>
			</div>
			</div>
			<div class="text-center">
			<a id="success-button" class="btn btn-custom btn-lg ladda-button" style="display: none;" data-style="slide-up" data-spinner-color="#FFA500">Continue</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->
			<!-- End of Delete an account modal -->';
	}

	$stmt6->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /panel-group -->

    </div><!-- /container -->

	<?php include '../includes/footers/portal_footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

	<?php else : ?>

	<style>
	html, body {
		height: 100% !important;
	}
	</style>

    <header class="intro">
    <div class="intro-body">
    <form class="form-custom orange-form">

	<div class="logo-custom animated fadeIn delay1">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>

	</div><!-- /intro-body -->
    </header>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

	<?php endif; ?>
	<?php else : ?>

	<style>
    html, body {
		height: 100% !important;
    }
    </style>

    <header class="intro">
    <div class="intro-body">

	<form class="form-custom">

    <div class="logo-custom">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>

    <hr class="hr-custom">

    <div class="text-center">
	<a class="btn btn-custom btn-lg ladda-button" data-style="slide-up" data-spinner-color="#FFA500" href="/"><span class="ladda-label">Sign In</span></a>
    </div>

    </form>

	</div><!-- /intro-body -->
    </header>

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
	$("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];
    var myData = 'recordToDelete='+ DbNumberID;

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:myData,
	success:function(){
		$('#user-'+DbNumberID).fadeOut();
		$('#hide').hide();
		$('.logo-custom i').removeClass('fa-trash');
		$('.logo-custom i').addClass('fa-check-square-o');
		$('.modal-body p').removeClass('feedback-custom');
		$('.modal-body p').addClass('feedback-happy');
		$('#success').show();
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
