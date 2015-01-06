<?php
include 'includes/signin.php';

session_destroy();
header('Location: locked-out');
?>
