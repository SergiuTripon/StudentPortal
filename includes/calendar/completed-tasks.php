<?php
include '../session.php';


	$stmt2 = $mysqli->query("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%d %b %y %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%d %b %y %H:%i') as task_duedate, task_category, DATE_FORMAT(updated_on,'%d %b %y %H:%i') as updated_on FROM user_tasks where userid = '$session_userid' AND task_status = 'completed'");

	while($row = $stmt2->fetch_assoc()) {

        $taskid = $row["taskid"];
        $task_name = $row["task_name"];
        $task_notes = $row["task_notes"];
        $task_startdate = $row["task_startdate"];
        $task_duedate = $row["task_duedate"];
        $task_url = $row["task_url"];
        $task_category = $row["task_category"];
        $task_category = ucfirst($row["task_category"]);
        $updated_on = $row["updated_on"];

        echo '<tr id="task-'.$taskid.'">

	<td data-title="Name">'.$task_name.'</td>
	<td data-title="Notes">'.($task_notes === '' ? "-" : "$task_notes").'</td>
    <td data-title="URL">'.($task_url === '' ? "-" : "<a class=\"btn btn-primary btn-md\" target=\"_blank\" href=\"//$task_url\">Link</a>").'</td>
	<td data-title="Start date">'.$task_startdate.'</td>
	<td data-title="Due date">'.$task_duedate.'</td>
	<td data-title="Category">'.$task_category.'</td>
	<td data-title="Completed on">'.$updated_on.'</td>
	</tr>';
    }

	$stmt2->close();