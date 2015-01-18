<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    echo "bad";
} else {
    echo "good";
}

if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

include 'db_connection.php';

?>