<?php
include '../includes/session.php';
?>

    <?php

	$stmt1 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.account_type = 'student'");

	while($row = $stmt1->fetch_assoc()) {

	$db_userid = $row["userid"];
	$email = $row["email"];
    $firstname = $row["firstname"];
    $surname = $row["surname"];

    $stmt3 = $mysqli->prepare("SELECT userid FROM user_timetable WHERE userid = ? AND moduleid = ?");
    $stmt3->bind_param('ii', $db_userid, $moduleToAssign);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($db_userid1);
    $stmt3->fetch();

    $assignment_check = $stmt3->num_rows ? 'Already assigned' : '<a id="assign-'.$db_userid.'" class="btn btn-primary btn-md assign-button">Assign</a>';
    $assignment_check1 = $stmt3->num_rows ? '<a id="assign-'.$db_userid.'" class="btn btn-primary btn-md unassign-button">Unassign</a>' : 'Not assigned yet';

	echo '<tr id="assign-'.$db_userid.'">

			<td data-title="First name">'.$firstname.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$email.'</td>
			<td data-title="Action">'.$assignment_check.'</td>
			<td data-title="Action">'.$assignment_check1.'</td>
			</tr>';
	}

	$stmt1->close();
	?>