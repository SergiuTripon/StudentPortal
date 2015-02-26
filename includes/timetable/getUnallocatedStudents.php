<?php
include '../../includes/session.php';


function getUnallocatedStudents () {

    global $mysqli;

    $stmt2 = $mysqli->query("SELECT user_signin.userid, user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid IN (SELECT DISTINCT(user_timetable.userid) FROM user_timetable WHERE user_timetable.moduleid = '$timetableToAssign') AND user_signin.account_type = 'student'");
    while ($row = $stmt2->fetch_assoc()) {
        $userid = $row["userid"];
        $email = $row["email"];
        $firstname = $row["firstname"];
        $surname = $row["surname"];
        echo '<tr id="unassign-' . $userid . '">
        <td data-title="First name">' . $firstname . '</td>
        <td data-title="Surname">' . $surname . '</td>
        <td data-title="Email address">' . $email . '</td>
        <td data-title="Action"><a id="unassign-' . $userid . '" class="btn btn-primary btn-md ladda-button unassign-button" data-style="slide-up"><span class="ladda-label">Unassign</span></a></td>
        </tr>';
    }
    $stmt2->close();
}