<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'includes/assets/meta-tags.php'; ?>

	<?php include 'includes/assets/css-paths/datatables-css-path.php'; ?>
	<?php include 'includes/assets/css-paths/common-css-paths.php'; ?>
	<?php include 'includes/assets/css-paths/calendar-css-path.php'; ?>

    <title>Student Portal | Timetable</title>

</head>

<body>
<div class="preloader"></div>

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

	<div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
	<li class="active">Timetable</li>
    </ol>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Lectures</a>
    <a id="loadLectures" class="pull-right"><i class="fa fa-refresh"></i></a>
    </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div id="student-lectures" class="panel-body">
    </div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Tutorials</a>
    <a id="loadTutorials" class="pull-right"><i class="fa fa-refresh"></i></a>
    </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
  	<div id="student-tutorials" class="panel-body">
    <!-- Update timetable -->
    <?php
	$stmt1 = $mysqli->query("SELECT moduleid FROM system_modules WHERE module_status = 'active'");
	while($row = $stmt1->fetch_assoc()) {
	  echo '<form id="update-timetable-form-'.$row["moduleid"].'" style="display: none;" action="/admin/update-timetable/" method="POST">
			<input type="hidden" name="timetableToUpdate" id="timetableToUpdate" value="'.$row["moduleid"].'"/>
			</form>';
	}
	$stmt1->close();
	?>

    <!-- Assign timetable -->
    <?php
    $stmt2 = $mysqli->query("SELECT moduleid FROM system_modules WHERE module_status = 'active'");
    while($row = $stmt2->fetch_assoc()) {
        echo '<form id="assign-timetable-form-'.$row["moduleid"].'" style="display: none;" action="/admin/assign-timetable/" method="POST">
        <input type="hidden" name="timetableToAssign" id="timetableToAssign" value="'.$row["moduleid"].'"/>
        </form>';
    }
    $stmt2->close();
    ?>

	<!-- Modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom admin-modules-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>URL</th>
	<th>Action</th>
    <th>Action</th>
    <th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT moduleid, module_name, module_notes, module_url FROM system_modules WHERE module_status = 'active'");

	while($row = $stmt3->fetch_assoc()) {

    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
	$module_notes = $row["module_notes"];
	$module_url = $row["module_url"];

	echo '<tr id="cancel-'.$moduleid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Notes">'.($module_notes === '' ? "No notes" : "$module_notes").'</td>
            <td data-title="URL">'.($module_url === '' ? "No link" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Action"><a id="assign-'.$moduleid.'" class="btn btn-primary btn-md ladda-button assign-button" data-style="slide-up"><span class="ladda-label">Assign</span></a></td>
			<td data-title="Action"><a id="update-'.$moduleid.'" class="btn btn-primary btn-md ladda-button update-button ladda-button" data-style="slide-up"><span class="ladda-label">Update</span></a></td>
            <td data-title="Action"><a id="cancel-'.$moduleid.'" class="btn btn-primary btn-md ladda-button cancel-button ladda-button" data-style="slide-up"><span class="ladda-label">Cancel</span></a></td>
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
    <script src="../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'lecturer') : ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

    <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="timetable-portal" class="container">

	<ol class="breadcrumb">
    <li><a href="../overview/">Overview</a></li>
    <li class="active">Timetable</li>
    </ol>

    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="/admin/create-timetable/"><span class="ladda-label">Create timetable</span></a>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Timetables</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div id="admin-modules" class="panel-body">

    </div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
	</div><!-- /panel-default -->

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
  	<h4 class="panel-title">
	<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">  Cancelled timetables</a>
  	</h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
  	<div id="admin-cancelled-modules" class="panel-body">

    </div><!-- /panel-body -->
    </div><!-- /panel-collapse -->
  	</div><!-- /panel-default -->

	</div><!-- /.panel-group -->

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

	<?php include 'includes/assets/js-paths/common-js-paths.php'; ?>
	<?php include 'includes/assets/js-paths/tilejs-js-path.php'; ?>
	<?php include 'includes/assets/js-paths/datatables-js-path.php'; ?>
	<?php include 'includes/assets/js-paths/calendar-js-path.php'; ?>

    <script>
    $(document).ready(function () {

    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.admin-modules-table').dataTable({
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no timetables to display."
        }
    });

    $('#student-lectures').load('https://student-portal.co.uk/includes/timetable/getLectures.php');
    $('#student-tutorials').load('https://student-portal.co.uk/includes/timetable/getTutorials.php');
    $('#admin-cancelled-modules').load('https://student-portal.co.uk/includes/timetable/getCancelledModules.php');

    });

    $("#loadLectures").click(function() {
        $('#student-lectures').load('https://student-portal.co.uk/includes/timetable/getLectures.php');
    });

    $("#loadTutorials").click(function() {
        $('#student-tutorials').load('https://student-portal.co.uk/includes/timetable/getTutorials.php');
    });

    </script>

</body>
</html>
