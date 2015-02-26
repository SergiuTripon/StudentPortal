<?php
include '../../includes/session.php';
?>

	<tbody>
	<?php

	$stmt3 = $mysqli->query("SELECT system_tutorials.tutorial_name, system_tutorials.tutorial_assistant, system_tutorials.tutorial_day, DATE_FORMAT(system_tutorials.tutorial_from_time,'%H:%i') as tutorial_from_time, DATE_FORMAT(system_tutorials.tutorial_to_time,'%H:%i') as tutorial_to_time, system_tutorials.tutorial_location, system_tutorials.tutorial_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid WHERE user_timetable.userid='$session_userid' AND system_tutorials.tutorial_status ='active' LIMIT 1");

	while($row = $stmt3->fetch_assoc()) {

	$tutorial_name = $row["tutorial_name"];
	$tutorial_assistant = $row["tutorial_assistant"];
	$tutorial_day = $row["tutorial_day"];
	$tutorial_from_time = $row["tutorial_from_time"];
	$tutorial_to_time = $row["tutorial_to_time"];
	$tutorial_location = $row["tutorial_location"];
	$tutorial_capacity = $row["tutorial_capacity"];

	$stmt4 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt4->bind_param('i', $tutorial_assistant);
	$stmt4->execute();
	$stmt4->store_result();
	$stmt4->bind_result($firstname, $surname);
	$stmt4->fetch();

	echo '<tr>

			<td data-title="Name">'.$tutorial_name.'</td>
			<td data-title="Notes">'.$firstname.' '.$surname.'</td>
			<td data-title="Notes">'.$tutorial_day.'</td>
			<td data-title="From">'.$tutorial_from_time.'</td>
			<td data-title="To">'.$tutorial_to_time.'</td>
			<td data-title="Location">'.$tutorial_location.'</td>
			<td data-title="Capacity">'.$tutorial_capacity.'</td>
			</tr>';
	}

	$stmt3->close();
	?>
	</tbody>