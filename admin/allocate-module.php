<?php
include '../includes/session.php';

global $mysqli;
global $moduleToAllocate;

//If URL parameter is set, do the following
if (isset($_GET['id'])) {

    $moduleToAllocate = $_GET['id'];

//If URL parameter is not set, do the following
} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Allocate module</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb breadcrumb-custom">
		<li><a href="../../home/">Home</a></li>
        <li><a href="../../timetable/">Timetable</a></li>
		<li class="active">Allocate module</li>
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

	<!-- Unnalocated students -->
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

    //Get unnalocated students to the module selected
    $account_type = 'student';

	$stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_detail.studentno, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid NOT IN (SELECT DISTINCT(user_module.userid) FROM user_module WHERE user_module.moduleid=?) AND user_signin.account_type=?");
    $stmt1->bind_param('is', $moduleToAllocate, $account_type);
    $stmt1->execute();
    $stmt1->bind_result($userid, $studentno, $firstname, $surname);
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {

        while ($stmt1->fetch()) {

            echo
                
           '<tr>
			<td data-title="Full name">'.$firstname.' '.$surname.'</td>
			<td data-title="Student number">'.$studentno.'</td>
			<td data-title="Action"><a id="allocate-'.$userid.'" class="btn btn-primary btn-md btn-allocate-module btn-load">Allocate</a></td>
			</tr>';
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

    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Allocated students</a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
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

    //Get allocated students to the module selected
    $account_type = 'student';

	$stmt2 = $mysqli->prepare("SELECT user_signin.userid, user_detail.studentno, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid IN (SELECT DISTINCT(user_module.userid) FROM user_module WHERE user_module.moduleid=?) AND user_signin.account_type=?");
    $stmt2->bind_param('is', $moduleToAllocate, $account_type);
    $stmt2->execute();
    $stmt2->bind_result($userid, $studentno, $firstname, $surname);
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {

        while ($stmt2->fetch()) {
            echo

           '<tr>
			<td data-title="First name">' . $firstname . ' ' . $surname . '</td>
			<td data-title="Student number">' . $studentno . '</td>
			<td data-title="Action"><a id="deallocate-' . $userid . '" class="btn btn-primary btn-md btn-deallocate-module btn-load">Deallocate</a></td>
			</tr>';
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

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Initialize dataTables
    $('.table-custom').dataTable(settings);

    //Allocate module process
	$("body").on("click", ".btn-allocate-module", function(e) {
    e.preventDefault();

    //Get clicked ID
    var clickedID = this.id.split('-');
    var userToAllocate = clickedID[1];
    var moduleToAllocate = $("#moduleid").html();

    //Initialize Ajax call
	jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",

    //Data posted
	data:'userToAllocate='+ userToAllocate + '&moduleToAllocate='+ moduleToAllocate,

    //If action completed, do the following
    success:function(){
        location.reload();
    },

    //If action failed, do the following
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}
	});
    });

    //Deallocate module process
    $("body").on("click", ".btn-deallocate-module", function(e) {
    e.preventDefault();

    //Get clicked ID
    var clickedID = this.id.split('-');
    var userToDeallocate = clickedID[1];
    var moduleToDeallocate = $("#moduleid").html();

    //Initialize Ajax call
	jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",

    //Data posted
    data:'userToDeallocate='+ userToDeallocate + '&moduleToDeallocate='+ moduleToDeallocate,

    //If action completed, do the following
    success:function(){
        location.reload();
    },

    //If action failed, do the following
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});
    });
	</script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/home/">Home</a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg btn-load" href="/">Sign in</a>
    </div>

    </form>

	</div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>

</body>
</html>
