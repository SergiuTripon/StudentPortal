<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
}

include 'db_connection.php';

if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

date_default_timezone_set('Europe/London');
$created_on = date("Y-m-d G:i:s");
$updated_on = date("Y-m-d G:i:s");
$completed_on = date("Y-m-d G:i:s");
$cancelled_on = date("Y-m-d G:i:s");
