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
    $stmt2->bind_param('ii', $db_userid, $moduleToAssign);
    $stmt2->execute();

    $test = 'Yes, it\'s 0';
    $test1 = 'No, it\'s not 0';

    $stmt2->num_rows === 0 ? $test : $test1;

	echo '<tr id="assign-'.$userid.'">

			<td data-title="First name">'.$stmt2->num_rows.'</td>
			<td data-title="Surname">'.$surname.'</td>
			<td data-title="Email address">'.$test.'</td>
			<td data-title="Action">'.$test1.'</td>
			<td data-title="Action">test</td>
			</tr>';
	$stmt2->close();
    }
	$stmt1->close();
	?>