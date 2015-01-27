<?php
include 'includes/signin.php';

session_unset();
session_destroy();
header('Location: /');
?>
