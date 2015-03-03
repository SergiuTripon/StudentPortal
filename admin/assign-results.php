<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $userToAssignResults = $_GET['id'];

} else {
    header('Location: ../../results/');
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

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

	<ol class="breadcrumb">
		<li><a href="../../overview/">Overview</a></li>
        <li><a href="../../results/">Results</a></li>
		<li class="active">Assign results</li>
	</ol>

    <div id="moduleid" style="display: none !important;"><?php echo $timetableToAssign; ?></div>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Modules</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Name</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
    <?php

	$stmt1 = $mysqli->query("SELECT user_timetable.userid, user_timetable.moduleid, system_modules.module_name FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN user_results ON user_timetable.moduleid=user_results.moduleid WHERE NOT user_results.userid = '$userToAssignResults'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
    $moduleid = $row["moduleid"];
    $module_name = $row["module_name"];

	echo '<tr id="allocate-'.$userid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Action"><a class="btn btn-primary btn-md ladda-button" href="../create-results/?userid='.$userid.'&moduleid='.$moduleid.'" data-style="slide-up"><span class="ladda-label">Assign</span></a></td>
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

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.module-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no modules to display."
		}
	});

    //Assign timetable
	$("body").on("click", ".allocate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToAllocate = clickedID[1];
    var timetableToAllocate = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToAllocate='+ userToAllocate + '&timetableToAllocate='+ timetableToAllocate,
	success:function(){
        $('#allocate-'+userToAllocate).hide();
        location.reload();
    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

    //Unassign timetable
    $("body").on("click", ".deallocate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var userToDeallocate = clickedID[1];
    var timetableToDeallocate = $("#moduleid").html();

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'userToDeallocate='+ userToDeallocate + '&timetableToDeallocate='+ timetableToDeallocate,
	success:function(){
        $('#deallocate-'+userToDeallocate).hide();
        location.reload();
    },
	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });

	</script>

</body>
</html>
