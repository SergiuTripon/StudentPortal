<?php
if (session_status() == PHP_SESSION_NONE) {
	session_cache_limiter('none');
    session_start();
}

include 'db_connection.php';


<!-- Bootstrap CSS -->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">

?>
