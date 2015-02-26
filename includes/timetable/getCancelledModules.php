<?php
include '../../includes/session.php';
?>

	<!-- Cancelled modules -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom admin-cancelled-modules-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Notes</th>
	<th>URL</th>
	<th>Action</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT moduleid, module_name, module_notes, module_url FROM system_modules WHERE module_status = 'cancelled'");

	while($row = $stmt3->fetch_assoc()) {

    $moduleid = $row["moduleid"];
	$module_name = $row["module_name"];
	$module_notes = $row["module_notes"];
	$module_url = $row["module_url"];

	echo '<tr id="activate-'.$moduleid.'">

			<td data-title="Name">'.$module_name.'</td>
			<td data-title="Notes">'.($module_notes === '' ? "No notes" : "$module_notes").'</td>
            <td data-title="URL">'.($module_url === '' ? "No link" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$module_url\">Link</a>").'</td>
            <td data-title="Action"><a id="activate-'.$moduleid.'" class="btn btn-primary btn-md ladda-button activate-button" data-style="slide-up"><span class="ladda-label">Activate</span></a></td>
			</tr>';
	}

	$stmt3->close();
	?>
	</tbody>

	</table>
	</section>

    <script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.admin-cancelled-modules-table').dataTable({
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no timetables to display."
        }
    });

    $("body").on("click", ".activate-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToActivate = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToActivate='+ timetableToActivate,
	success:function(){
		$('#activate-'+timetableToActivate).fadeOut();
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