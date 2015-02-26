<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $timetableToAssign = $_GET['id'];

} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/datatables-css-path.php'; ?>
	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Assign timetable</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb">
		<li><a href="../../overview/">Overview</a></li>
        <li><a href="../../timetable/">Timetable</a></li>
		<li class="active">Assign timetable</li>
	</ol>

    <div id="moduleid" style="display: none !important;"><?php echo $timetableToAssign; ?></div>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Assigned users</a>
    <a id="loadAssignedUsers" class="pull-right"><i class="fa fa-refresh"></i></a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Assigned users -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>First Name</th>
	<th>Surname</th>
	<th>Email address</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="loadAssignedUsers-table">
    <?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid NOT IN (SELECT DISTINCT(user_timetable.userid) FROM user_timetable WHERE user_timetable.moduleid = '$timetableToAssign') AND user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="assign-'.$userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a id="assign-'.$userid.'" class="btn btn-primary btn-md ladda-button assign-button" data-style="slide-up"><span class="ladda-label">Assign</span></a></td>
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
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Unassigned users</a>
    <a id="loadUnassignedUsers" class="pull-right"><i class="fa fa-refresh"></i></a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div class="panel-body">

	<!-- Unassigned users -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom">

	<thead>
	<tr>
	<th>First Name</th>
	<th>Surname</th>
	<th>Email address</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody id="loadUnassignedUsers-table">
    <?php

	$stmt2 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid IN (SELECT DISTINCT(user_timetable.userid) FROM user_timetable WHERE user_timetable.moduleid = '$timetableToAssign') AND user_signin.account_type = 'student'");

	while($row = $stmt2->fetch_assoc()) {

	$userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="unassign-'.$userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a id="unassign-'.$userid.'" class="btn btn-primary btn-md ladda-button unassign-button" data-style="slide-up"><span class="ladda-label">Unassign</span></a></td>
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
	<?php include '../assets/js-paths/tilejs-js-path.php'; ?>
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

    //Loading buttons
    $("#loadAssignedUsers").click(function() {
        $('#loadAssignedUsers-table').load('https://student-portal.co.uk/includes/timetable/getAssignedUsers.php');
    });

    $("#loadUnassignedUsers").click(function() {
        $('#loadUnassignedUsers-table').load('https://student-portal.co.uk/includes/timetable/getUnassignedUsers.php');
    });

    //Assign timetable
	$("body").on("click", ".assign-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToAssign = clickedID[1];
    var timetableToAssign = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToAssign='+ userToAssign + '&timetableToAssign='+ timetableToAssign,
	success:function(){
        $('#assign-'+userToAssign).hide();
        $('#loadUnassignedUsers-table').load('https://student-portal.co.uk/includes/timetable/getUnassignedUsers.php');
        $('#loadAssignedUsers-table').load('https://student-portal.co.uk/includes/timetable/getAssignedUsers.php');
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

    //Unassign timetable
    $("body").on("click", ".unassign-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToUnassign = clickedID[1];
    var timetableToUnassign = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToUnassign='+ userToUnassign + '&timetableToUnassign='+ timetableToUnassign,
	success:function(){
        $('#unassign-'+userToUnassign).hide();
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
