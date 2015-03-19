<?php
include 'includes/session.php';

global $mysqli;

$stmt2 = $mysqli->prepare("SELECT feedback_from, module_staff FROM user_feedback_sent WHERE feedbackid = ?");
$stmt2->bind_param('i', $feedbackToApprove);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($feedback_from, $module_staff);
$stmt2->fetch();

echo $feedback_from;
echo $module_staff;