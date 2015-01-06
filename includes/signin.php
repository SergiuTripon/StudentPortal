<?php
if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

include 'db_connection.php';
?>
