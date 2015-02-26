<?php
include '../../includes/session.php';
?>

<table class="table table-condensed table-custom module-table">

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

    <tbody id="loadModules-table">
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
            <td data-title="Action"><a class="btn btn-primary btn-md assign-button" href="/admin/assign-timetable?id='.$moduleid.'" data-style="slide-up"><span class="ladda-label">Assign</span></a></a></td>
			<td data-title="Action"><a class="btn btn-primary btn-md update-button" href="/admin/update-timetable?id='.$moduleid.'" data-style="slide-up"><span class="ladda-label">Update</span></a></a></td>
            <td data-title="Action"><a id="cancel-'.$moduleid.'" class="btn btn-primary btn-md cancel-button" data-style="slide-up"><span class="ladda-label">Cancel</span></a></a></td>
			</tr>';
    }

    $stmt3->close();
    ?>
    </tbody>

</table>