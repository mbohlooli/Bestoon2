<?php

define('APP_TITLE', 'بستون');
define('APP_URL', 'http://192.168.1.5/bestoon/');
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

define('DB_NAME', 'bestoon');
define('DB_HOST', 'localhost');
define('DB_USER', 'mehrab');
define('DB_PASS', '1234');

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
global $added;
$added = false;
Privilege::add_default_prvileges();