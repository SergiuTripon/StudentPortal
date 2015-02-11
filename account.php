<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/js-paths/pacejs-js-path.php'; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Account</title>

</head>

<body>
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
    <a href="/account/update-account/">
    <div class="tile">
    <i class="fa fa-pencil"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a href="/account/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change Password</p>
    </div>
    </a>
	</div>
				
	<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
	<a href="/account/pay-course-fees/">
    <div class="tile">
    <i class="fa fa-gbp"></i>
	<p class="tile-text">Pay course fees</p>
    </div>
	</a>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
	<a href="/account/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->
	
    </div><!-- /container -->
	
	<?php include 'includes/footers/footer.php'; ?>
		
	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	
	<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">

    <a href="/account/update-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<a href="/account/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change Password</p>
    </div>
    </a>
	</div>

    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a href="/account/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
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

	<div id="account-admin-portal" class="container">
			
	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <a href="/account/update-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/account/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change password</p>
	</div>
    </a>
	</div>

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a href="/account/delete-account/">
    <div class="tile">
    <i class="fa fa-trash"></i>
	<p class="tile-text">Delete account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->

    <h4>Perform actions against other accounts</h4>
    <hr>

    <div class="row">

	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
    <a href="/admin/create-an-account/">
    <div class="tile">
    <i class="fa fa-user-plus"></i>
	<p class="tile-text">Create an account</p>
    </div>
    </a>
	</div>

    <!--<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
    <a href="/create-multiple-accounts/">
    <div class="tile">
    <i class="fa fa-users"></i>
    <p class="tile-text">Create multiple accounts</p>
    </div>
    </a>
    </div>-->
	
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<a href="/admin/update-delete-an-account/">
    <div class="tile">
    <i class="fa fa-wrench"></i>
	<p class="tile-text">Update/Delete an account</p>
	</div>
    </a>
	</div>

    </div><!-- /row -->

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
			<td data-title="Delete"><a class="delete-button" href="#modal-'.$row["userid"].'" data-toggle="modal"><i class="fa fa-close"></i></a></td>
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
	
	<?php include 'includes/footers/footer.php'; ?>
		
    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

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

</body>
</html>
