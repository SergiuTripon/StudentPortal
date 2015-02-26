<?php
include '../../includes/session.php';
?>

    <?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

    $userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

    $stmt2 = $mysqli->prepare("SELECT userid FROM user_timetable WHERE userid = ? AND moduleid = ?");
    $stmt2->bind_param('ii', $userid, $moduleToAssign);
    $stmt2->execute();

    $assignment_check = $stmt2->num_rows === 0 ? '<a id="assign-'.$userid.'" class="btn btn-primary btn-md assign-button">Assign</a>' : '<a id="unnasign-'.$userid.'" class="btn btn-primary btn-md unassign-button">Unassign</a>';

	echo '<tr id="assign-'.$userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action">'.$assignment_check.'</td>
			</tr>';
	$stmt2->close();
    }
	$stmt1->close();
	?>