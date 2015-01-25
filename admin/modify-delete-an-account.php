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

    <title>Student Portal | Modify/Delete an account</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<div class="container">

    <?php include '../includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
	<li class="active">Modify/Delete an account</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

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

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Change an account's password</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
	<th>Delete</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt2 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt2->fetch_assoc()) {

	echo '<tr>

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$row["account_type"].'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Delete"><a id="change-'.$row["userid"].'" class="change-button" href="#modal-help" data-toggle="modal"><i class="fa fa-lock"></i></a></td>
			</tr>';
	}

	$stmt2->close();
	?>
	</tbody>

	</table>
	</section>

	<!-- Change an acount's password modal -->
    <div class="modal fade" id="modal-help" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
    <h4 class="modal-title" id="modal-custom-label">Need help?</h4>
    </div>

    <div class="modal-body">

	<form class="form-custom" style="max-width: 700px; padding-top: 0px;" name="changepassword_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

    <div class="form-group">

	<div class="col-xs-6 col-sm-6 full-width">
    <label>New password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="New password">
    </div>

    <div class="col-xs-6 col-sm-6 full-width">
    <label>New password confirmation</label>
    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" placeholder="Confirm new password">
    </div>
    </div>

	<div class="modal-footer">
	<div class="text-right">
	<button id="FormSubmit" class="btn btn-custom btn-lg ladda-button mt10 mr5" data-style="slide-up" data-spinner-color="#FFA500"><span class="ladda-label">Change</span></button>
	</div>

	</form>
    </div>

	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Change an acount's password modal -->

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

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

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Update an account</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
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
	<th>Delete</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt4 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_details.updated_on,'%d %b %y %H:%i') as updated_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt4->fetch_assoc()) {

	echo '<tr>

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$row["account_type"].'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Updated on">'.$row["updated_on"].'</td>
			<td data-title="Delete"><a id="update-'.$row["userid"].'" class="update-button"><i class="fa fa-refresh"></i></a></td>
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

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid'");

	while($row = $stmt1->fetch_assoc()) {

	echo '<tr id="user-'.$row["userid"].'">

			<td data-title="User ID">'.$row["userid"].'</td>
			<td data-title="First name">'.$row["firstname"].'</td>
			<td data-title="Surname">'.$row["surname"].'</td>
			<td data-title="Email address">'.$row["email"].'</td>
			<td data-title="Account type">'.$row["account_type"].'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Delete"><a id="delete-'.$row["userid"].'" class="delete-button"><i class="fa fa-close"></i></a></td>
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

	<script type="text/javascript" class="init">
    $(document).ready(function () {
    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no users to display."
		}
	});
    });
	</script>

	<script>

	$(document).ready(function() {

	$("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-account-form-" + DbNumberID).submit();

	});


	$("body").on("click", ".delete-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];
    var myData = 'recordToDelete='+ DbNumberID;

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/adminaccount_process.php",
	dataType:"text",
	data:myData,
	success:function(response){
		$('#user-'+DbNumberID).fadeOut();
		setTimeout(function(){
			location.reload();
		}, 1000);
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

	});

	</script>

</body>
</html>
