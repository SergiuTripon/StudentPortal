<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
}

if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

include 'db_connection.php';
