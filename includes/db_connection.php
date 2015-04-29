<?php
include_once 'db_config.php';

//Database connection (MySQLi)
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

//Database connection (PDO)
$pdo = new PDO($dsn, $username, $password, $options);
