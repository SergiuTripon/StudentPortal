<?php

//Database information to be used for connection (MySQLi)
define("HOST", "localhost");
define("USER", "sergiutripon");
define("PASSWORD", "MJvmJRG4XGdV8Wv"); 
define("DATABASE", "student_portal");
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

//Database information to be used for connection (PDO)
$dsn = 'mysql:host=localhost;dbname=student_portal';
$username = 'sergiutripon';
$password = 'MJvmJRG4XGdV8Wv';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

