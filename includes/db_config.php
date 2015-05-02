<?php

//Database information to be used for connection (MySQLi)
define("HOST", "localhost");
define("USER", "username");
define("PASSWORD", "password");
define("DATABASE", "database name");
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

//Database information to be used for connection (PDO)
$dsn = 'mysql:host=localhost;dbname=database name';
$username = 'username';
$password = 'password';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);


