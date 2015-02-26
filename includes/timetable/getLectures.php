<?php
include '../../includes/session.php';
?>

    <!-- Lectures -->
	<section id="no-more-tables">
	<table class="table table-condensed table-custom lecture-table">

	<thead>
	<tr>
	<th>Name</th>
	<th>Lecturer</th>
	<th>Day</th>
	<th>From</th>
    <th>To</th>
    <th>Location</th>
    <th>Capacity</th>
	</tr>
	</thead>

	<tbody>
	<?php

	$stmt1 = $mysqli->query("SELECT system_lectures.lecture_name, system_lectures.lecture_lecturer, system_lectures.lecture_day, DATE_FORMAT(system_lectures.lecture_from_time,'%H:%i') as lecture_from_time, DATE_FORMAT(system_lectures.lecture_to_time,'%H:%i') as lecture_to_time, system_lectures.lecture_location, system_lectures.lecture_capacity FROM user_timetable LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid WHERE user_timetable.userid='$session_userid' AND system_lectures.lecture_status='active' LIMIT 1");

	while($row = $stmt1->fetch_assoc()) {

	$lecture_name = $row["lecture_name"];
	$lecture_lecturer = $row["lecture_lecturer"];
	$lecture_day = $row["lecture_day"];
	$lecture_from_time = $row["lecture_from_time"];
	$lecture_to_time = $row["lecture_to_time"];
	$lecture_location = $row["lecture_location"];
	$lecture_capacity = $row["lecture_capacity"];

	$stmt2 = $mysqli->prepare("SELECT firstname, surname FROM user_details WHERE userid = ? LIMIT 1");
	$stmt2->bind_param('i', $lecture_lecturer);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($firstname, $surname);
	$stmt2->fetch();

	echo '<tr>

			<td data-title="Name">'.$lecture_name.'</td>
			<td data-title="Lecturer">'.$firstname.' '.$surname.'</td>
			<td data-title="From">'.$lecture_day.'</td>
			<td data-title="From">'.$lecture_from_time.'</td>
			<td data-title="To">'.$lecture_to_time.'</td>
			<td data-title="Location">'.$lecture_location.'</td>
			<td data-title="Capacity">'.$lecture_capacity.'</td>
			</tr>';
	}

	$stmt1->close();
	?>
	</tbody>

	</table>
	</section>
    <!-- End of Lectures -->
