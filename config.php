<?php

define('APP_TITLE', 'بستون');
define('APP_URL', 'http://localhost/bestoon/');
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

define('DB_NAME', 'bestoon');
define('DB_HOST', 'localhost');
define('DB_USER', 'mehrab');
define('DB_PASS', '1234');

//session expiration time
define("SESSION_EXPIRATION_TIME", 3600*60);

// Include functions
foreach (glob('lib/*.php') as $lib){
    include_once $lib;
}

// Include essential classes first
require_once "app/database.php";
require_once "app/database_object.php";

// Include models
foreach (glob('app/*.php') as $class){
    include_once $class;
}

//Database Instance
global $db;
$db = new Database();

// Sets the default timezone to Tehran
date_default_timezone_set("Asia/Tehran");

// Adding Privileges
Privilege::add_default_prvileges();

// Adding session
$session = new Session();