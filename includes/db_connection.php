<?php
include_once 'db_config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$pdo = new PDO($dsn, $username, $password, $options);
