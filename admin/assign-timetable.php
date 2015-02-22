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

    <title>Student Portal | Timetable</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
    <li><a href="../../timetable/">Timetable</a></li>
    <li><a href="../updated-assign-timetable/">Update/Assign timetable</a></li>
	<li class="active">Assign timetable</li>
    </ol>

    <div id="idToAssign" style="display: none !important;"><?php echo $idToAssign; ?></div>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Modules</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Users -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>First name</th>
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

	echo '<tr>

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

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

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
	<?php include '../assets/js-paths/tilejs-js-path.php'; ?>
	<?php include '../assets/js-paths/datatables-js-path.php'; ?>
	<?php include '../assets/js-paths/calendar-js-path.php'; ?>

	<script type="text/javascript" class="init">
    $(document).ready(function () {

	//DataTables
    $('.module-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "You have no lectures on this day."
		}
	});

	$("body").on("click", ".assign-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var recordToAssign = clickedID[1];
    var idToAssign = $("#idToAssign").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'recordToAssign='+ recordToAssign + '&idToAssign=' + task_notes +,
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
