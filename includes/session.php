<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
}

include 'db_connection.php';

global $mysqli;

if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

if (isset($_SESSION['session_userid'])) {
    $session_userid = $_SESSION['session_userid'];
} else {
    $session_userid = '';
}

$stmt1 = $mysqli->prepare("SELECT firstname, surname FROM user_detail WHERE userid = ? LIMIT 1");
$stmt1->bind_param('i', $session_userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($session_firstname, $session_surname);
$stmt1->fetch();

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");
$updated_on = date("Y-m-d G:i:s");
$completed_on = date("Y-m-d G:i:s");
$cancelled_on = date("Y-m-d G:i:s");
$now = date('H:i');
