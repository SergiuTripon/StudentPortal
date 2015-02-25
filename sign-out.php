<?php
include 'includes/session.php';

$isSignedIn = 0;

$stmt1 = $mysqli->prepare("UPDATE user_signin SET isSignedIn = ? WHERE userid = ? LIMIT 1");
$stmt1->bind_param('ii', $isSignedIn, $session_userid);
$stmt1->execute();
$stmt1->close();

session_unset();
session_destroy();
header('Location: /');

