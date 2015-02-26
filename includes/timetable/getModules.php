<?php
include '../../includes/session.php';
?>

    <?php
	$stmt1 = $mysqli->query("SELECT moduleid FROM system_modules WHERE module_status = 'active'");
	while($row = $stmt1->fetch_assoc()) {
	  echo '<form id="update-timetable-form-'.$row["moduleid"].'" style="display: none;" action="/admin/update-timetable/" method="POST">
			<input type="hidden" name="recordToUpdate" id="recordToUpdate" value="'.$row["moduleid"].'"/>
			</form>';
	}
	$stmt1->close();
	?>

    <?php
    $stmt2 = $mysqli->query("SELECT moduleid FROM system_modules WHERE module_status = 'active'");
    while($row = $stmt2->fetch_assoc()) {
        echo '<form id="assign-timetable-form-'.$row["moduleid"].'" style="display: none;" action="/admin/assign-timetable/" method="POST">
        <input type="hidden" name="recordToAssign" id="recordToAssign" value="'.$row["moduleid"].'"/>
        </form>';
    }
    $stmt2->close();
    ?>


    <div class="panel-heading" role="tab" id="headingOne">
  	<h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Timetables</a>
  	</h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
  	<div class="panel-body">

	<!-- Modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom modules-table">

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

	echo '<tr id="activate-'.$moduleid.'">

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

    <script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.modules-table').dataTable({
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
    var DbNumberID = clickedID[1];

	$("#assign-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".cancel-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToCancel = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToCancel='+ timetableToCancel,
	success:function(){
		$('#cancel-'+timetableToCancel).fadeOut();
        $('#modules').load('https://student-portal.co.uk/includes/timetable/getModules.php');
        $('#cancelled-modules').load('https://student-portal.co.uk/includes/timetable/getCancelledModules.php');
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });
    </script>