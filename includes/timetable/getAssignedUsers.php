<?php
include '../../includes/session.php';
?>

    <?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid NOT IN (SELECT DISTINCT(user_timetable.userid) FROM user_timetable WHERE user_timetable.moduleid = '$moduleToAssign') AND user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

	$userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

	echo '<tr id="assign-'.$userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action"><a id="assign-'.$userid.'" class="btn btn-primary btn-md assign-button">Assign</a></td>
			</tr>';
    }
	$stmt1->close();
	?>