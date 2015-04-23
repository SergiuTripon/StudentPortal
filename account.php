<?php
include 'includes/session.php';

global $mysqli;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Account</title>

</head>

<body>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>
	
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
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
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
	
	<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'academic staff') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
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
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="account-admin-portal" class="container">
			
	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Account</li>
    </ol>
			
    <div class="row">

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <a href="/account/update-account/">
    <div class="tile">
    <i class="fa fa-refresh"></i>
	<p class="tile-text">Update account</p>
    </div>
    </a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	<a href="/account/change-password/">
    <div class="tile">
    <i class="fa fa-key"></i>
	<p class="tile-text">Change password</p>
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

    <h4 class="title-separator">Perform actions against other accounts</h4>
    <hr class="hr-separator">

    <a class="btn btn-success btn-lg btn-admin btn-load" href="/admin/create-account/">Create account</a>

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Users online now</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Users online now -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Account type</th>
	<th>Created on</th>
	<th>Updated on</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT user_signin.account_type, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_detail.updated_on,'%d %b %y %H:%i') as updated_on, user_detail.surname, user_detail.firstname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE NOT user_signin.userid = '$session_userid' AND user_signin.isSignedIn = '1'");

	while($row = $stmt1->fetch_assoc()) {

    $account_type = ucfirst($row["account_type"]);
    $created_on = $row["created_on"];
    $updated_on = $row["updated_on"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr>

			<td data-title="Full name">'.$row["firstname"].' '.$row["surname"].'</td>
			<td data-title="Account type">'.$account_type.'</td>
			<td data-title="Created on">'.$row["created_on"].'</td>
			<td data-title="Updated on">'.$row["updated_on"].'</td>
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Active users</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Active users-->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Account type</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $user_status = 'active';

	$stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_signin.account_type, user_signin.email, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_detail.updated_on,'%d %b %y %H:%i') as updated_on, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE NOT user_signin.userid=? AND user_detail.user_status=?");
    $stmt1->bind_param('is', $session_userid, $user_status);
    $stmt1->execute();
    $stmt1->bind_result($userid, $account_type, $email, $created_on, $updated_on, $firstname, $surname);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            echo
           '<tr>
			<td data-title="Full name">'.$firstname.' '.$surname.'</td>
			<td data-title="Account type">'.ucfirst($account_type).'</td>
            <td data-title="Action">
            <div class="btn-group btn-action">
            <a class="btn btn-primary" href="/admin/update-account?id='.$userid.'">Update</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/change-password?id='.$userid.'">Change password</a></li>
            <li><a id="#deactivate-'.$userid.'" class="btn-deactivate-account">Deactivate</a></li>
            <li><a href="#delete-'.$userid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div id="delete-'.$userid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete account?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$firstname.' '.$surname.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$userid.'" class="btn btn-primary btn-lg btn-delete-account btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
        }
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
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"> Inactive users</a>
  	</h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
  	<div class="panel-body">

	<!-- Inactive user -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Account type</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

    $user_status = 'inactive';

	$stmt2 = $mysqli->prepare("SELECT user_signin.userid, user_signin.account_type, user_signin.email, DATE_FORMAT(user_signin.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_detail.updated_on,'%d %b %y %H:%i') as updated_on, user_detail.firstname, user_detail.surname, user_detail.gender, user_detail.nationality, user_detail.dateofbirth FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE NOT user_signin.userid=? AND user_detail.user_status=?");
    $stmt2->bind_param('is', $session_userid, $user_status);
    $stmt2->execute();
    $stmt2->bind_result($userid, $account_type, $email, $created_on, $updated_on, $firstname, $surname, $gender, $nationality, $dateofbirth);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {

            echo
           '<tr>
			<td data-title="Full name"><a href="#view-user-'.$userid.'" data-toggle="modal">'.$firstname.' '.$surname.'</a></td>
			<td data-title="Account type">'.ucfirst($account_type).'</td>
            <td data-title="Action">
			<div class="btn-group btn-action">
            <a id="#reactivate-'.$userid.'" class="btn btn-primary btn-reactivate-account">Reactivate</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-caret-down"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#delete-'.$userid.'" data-toggle="modal">Delete</a></li>
            </ul>
            </div>
            </td>
			</tr>

			<div id="view-user-'.$userid.'" class="modal fade modal-custom modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close"><i class="fa fa-user"></i></div>
            <h4 class="modal-title" id="modal-custom-label">'.$firstname.' '.$surname.'</h4>
			</div>

			<div class="modal-body">
			<p><b>Gender:</b> '.(empty($gender) ? "-" : "$gender").'</p>
			<p><b>Nationality:</b> '.(empty($nationality) ? "-" : "$nationality").'</p>
			<p><b>Date of Birth:</b> '.(empty($dateofbirth) ? "-" : "$dateofbirth").'</p>
			<p><b>Created on:</b> '.(empty($created_on) ? "-" : "$created_on").'</p>
			<p><b>Updated on:</b> '.(empty($updated_on) ? "-" : "$updated_on").'</p>
			</div>

			<div class="modal-footer">
            <div class="view-action pull-left">
            <a href="/admin/update-account?id='.$userid.'" class="btn btn-primary btn-md">Update</a>
            <a href="/admin/change-password?id='.$userid.'" class="btn btn-primary btn-md">Change Password</a>
            <a id="deactivate-'.$userid.'" class="btn btn-primary btn-md btn-deactivate-book">Deactivate</a>
            <a href="#delete-'.$userid.'" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal">Delete</a>
			</div>
			<div class="view-close pull-right">
			<a class="btn btn-danger btn-md" data-dismiss="modal">Close</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->

			<div id="delete-'.$userid.'" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    		<div class="modal-dialog">
    		<div class="modal-content">

			<div class="modal-header">
            <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
            <h4 class="modal-title" id="modal-custom-label">Delete account?</h4>
            </div>

			<div class="modal-body">
			<p class="text-left">Are you sure you want to delete "'.$firstname.' '.$surname.'"?</p>
			</div>

			<div class="modal-footer">
			<div class="text-right">
            <a id="delete-'.$userid.'" class="btn btn-primary btn-lg btn-delete-account btn-load">Delete</a>
			<a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
			</div>
			</div>

			</div><!-- /modal -->
			</div><!-- /modal-dialog -->
			</div><!-- /modal-content -->';
        }
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
	
	<?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>

    <script>

	//DataTables
    $('.table-custom').dataTable(settings);

	//Deactivate account
	$("body").on("click", ".btn-deactivate-account", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var userToDeactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToDeactivate='+ userToDeactivate,
	success:function(){
        location.reload();
    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});
    });

    //Reactivate account
	$("body").on("click", ".btn-reactivate-account", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var userToReactivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToReactivate='+ userToReactivate,
	success:function(){
        location.reload();
    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});
    });

    //Delete account
	$("body").on("click", ".btn-delete-account", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var userToDelete = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToDelete='+ userToDelete,
	success:function(){
        $('.modal-custom').modal('hide');

        $('.modal-custom').on('hidden.bs.modal', function () {
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
    </script>

    <?php endif; ?>
	
	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div class="container">
    
	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg" href="/">Sign in</a>
    </div>

    </form>
     
	</div>

    <?php include 'includes/footers/footer.php'; ?>
    <?php include 'assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>

</body>
</html>
