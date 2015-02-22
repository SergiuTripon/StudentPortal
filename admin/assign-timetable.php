<?php
include '../includes/session.php';

if (isset($_POST["recordToAssign"])) {

    $idToAssign = filter_input(INPUT_POST, 'recordToAssign', FILTER_SANITIZE_NUMBER_INT);

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
	<?php include '../assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Calendar</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="calendar-portal" class="container">

	<ol class="breadcrumb">
		<li><a href="../../overview/">Overview</a></li>
        <li><a href="../../timetable/">Timetable</a></li>
        <li><a href="../admin/update-assign-timetable/">Update/Assign timetable</a></li>
		<li class="active">Assign timetable</li>
	</ol>

    <div id="idToAssign" style="display: none !important;"><?php echo $idToAssign; ?></div>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a id="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Users</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Due tasks -->
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

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

	$db_userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="assign-'.$db_userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a id="assign-'.$db_userid.'" class="btn btn-primary btn-md assign-button">Assign</a></td>
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

    $('.table-custom').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no users to display."
		}
	});

	$("body").on("click", ".assign-button", function(e) {
    e.preventDefault();

    var idToAssign = $("#idToAssign").html();
	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'&idToAssign='+ idToAssign + '&recordToAssign='+ DbNumberID,
	success:function(){
		$('#assign-'+DbNumberID).fadeOut();
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
