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

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_details.firstname, user_details.surname, user_signin.email, user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_details.updated_on,'%d %b %y %H:%i') as updated_on FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE NOT user_signin.userid = '$userid' AND user_signin.isSignedIn = '1'");

	while($row = $stmt1->fetch_assoc()) {

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

    <script>
	$(document).ready(function () {

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

    </script>

</body>
</html>
