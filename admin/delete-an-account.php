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

    <title>Student Portal | Delete an account</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<div class="container">

    <?php include '../includes/menus/portal_menu.php'; ?>

	<ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../account/">Account</a></li>
	<li class="active">Delete an account</li>
    </ol>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Users</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Due tasks -->
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
			<td data-title="Delete"><a href="#deleteaccount-modal"><i class="fa fa-close"></i></a></td>
			</tr>

			<div class="modal fade" id="deleteaccount-modal" tabindex="-1" role="dialog" aria-labelledby="deleteaccount-modal-label" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">

			<div class="modal-header">
			<div class="logo-custom animated fadeIn delay1">
			<i class="fa fa-trash"></i>
			</div>
			</div>

			<div class="modal-body">

			<p class="feedback-custom text-center">Are you sure you want to delete this user account?</p>

			</div>

			<div class="modal-footer">

			<div class="pull-left">
    		<a id="delete-'.$row["userid"].'" class="btn btn-custom btn-lg delete-button">Yes</a>
    		</div>

    		<div class="text-right">
    		<a class="btn btn-custom btn-lg" data-dismiss="modal">No</a>
    		</div>

    		</div>

			</div>
			</div>
			</div>

    		';
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
