<?php

if ($_SERVER['HTTPS'] != "on") {
    echo "This is not HTTPS";
} else {
    echo "This is HTTPS";
}


if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

include 'db_connection.php';

?>