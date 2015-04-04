<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Results</title>

    <?php include 'assets/css-paths/datatables-css-path.php'; ?>
    <?php include 'assets/css-paths/common-css-paths.php'; ?>
    <?php include 'assets/css-paths/calendar-css-path.php'; ?>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
	<li class="active">Results</li>
    </ol>

	<div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Results</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Results -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom result-table">

	<thead>
	<tr>
	<th>Module</th>
	<th>Coursework mark</th>
	<th>Exam mark</th>
	<th>Overall mark</th>
    <th>Created on</th>
    <th>Updated on</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$stmt1 = $mysqli->query("SELECT user_result.resultid, system_module.module_name, user_result.result_coursework_mark, user_result.result_exam_mark, user_result.result_overall_mark, DATE_FORMAT(user_result.created_on,'%d %b %y %H:%i') as created_on, DATE_FORMAT(user_result.updated_on,'%d %b %y %H:%i') as updated_on FROM user_result LEFT JOIN system_module ON user_result.moduleid=system_module.moduleid WHERE user_result.userid = '$session_userid' AND system_module.module_status='active'");

	while($row = $stmt1->fetch_assoc()) {

    $resultid = $row["resultid"];
    $module_name = $row["module_name"];
    $result_coursework_mark = $row["result_coursework_mark"];
    $result_exam_mark = $row["result_exam_mark"];
    $result_overall_mark = $row["result_overall_mark"];
    $result_created_on = $row["created_on"];
    $result_updated_on = $row["updated_on"];

	echo '<tr>

			<td data-title="Module">'.$module_name.'</td>
			<td data-title="Coursework mark">'.$result_coursework_mark.'</td>
			<td data-title="Exam mark">'.$result_exam_mark.'</td>
			<td data-title="Overall mark">'.$result_overall_mark.'</td>
            <td data-title="Added on">'.(empty($result_created_on) ? "-" : "$result_created_on").'</td>
            <td data-title="Added on">'.(empty($result_updated_on) ? "-" : "$result_updated_on").'</td>
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

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'academic staff' || $_SESSION['account_type'] == 'administrator')) : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div class="container">

	<ol class="breadcrumb breadcrumb-custom">
    <li><a href="../home/">Home</a></li>
    <li class="active">Results</li>
    </ol>

    <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Students</a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Students -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom module-table">

	<thead>
	<tr>
	<th>Full name</th>
	<th>Student number</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT user_signin.userid, user_detail.firstname, user_detail.surname, user_detail.studentno FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE account_type = 'student'");

	while($row = $stmt3->fetch_assoc()) {

    $userid = $row["userid"];
	$firstname = $row["firstname"];
	$surname = $row["surname"];
	$studentno = $row["studentno"];

	echo '<tr id="assign-'.$userid.'">

			<td data-title="Name">'.$firstname.' '.$surname.'</td>
            <td data-title="Student number">'.$studentno.'</td>
            <td data-title="Action"><a class="btn btn-primary btn-md assign-button" href="/admin/select-module?id='.$userid.'" >Select</span></a></a></td>
			</tr>';
	}

	$stmt3->close();
	?>
	</tbody>

	</table>
	</section>

  	</div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

    </div><!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

	<!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php else : ?>

	<?php include 'includes/menus/menu.php'; ?>

    <div class="container">

	<form class="form-horizontal form-custom">

    <div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>

    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>

    <hr>

    <div class="text-center">
	<a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
    </div>

    </form>

	</div>

	<?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include 'assets/js-paths/common-js-paths.php'; ?>
	<?php include 'assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'assets/js-paths/datatables-js-path.php'; ?>
	<?php include 'assets/js-paths/calendar-js-path.php'; ?>

	<script>



	//DataTables
    $('.result-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "You have no results to display."
		}
	});

    $('.module-table').dataTable({
        "iDisplayLength": 10,
		"paging": true,
		"ordering": true,
		"info": false,
		"language": {
			"emptyTable": "There are no modules to display."
		}
	});
	</script>

</body>
</html>
