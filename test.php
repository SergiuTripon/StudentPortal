<?php
include 'includes/session.php';

global $mysqli;

$feedbackToApprove = '2';

$stmt2 = $mysqli->prepare("SELECT feedback_from, module_staff FROM user_feedback_sent WHERE feedbackid = ? ORDER BY feedbackid DESC");
$stmt2->bind_param('i', $feedbackToApprove);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($feedback_from, $module_staff);
$stmt2->fetch();

$stmt2 = $mysqli->prepare("SELECT feedback_from, module_staff FROM user_feedback_sent WHERE feedbackid = ? ORDER BY feedbackid ASC");
$stmt2->bind_param('i', $feedbackToApprove);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($feedback_from1, $module_staff1);
$stmt2->fetch();

echo $feedback_from;
echo $module_staff;
echo $feedback_from1;
echo $module_staff1;