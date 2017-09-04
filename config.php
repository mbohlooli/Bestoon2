<?php

define('APP_TITLE', 'بستون');
define('APP_URL', 'http://localhost/bestoon/');
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

define('DB_NAME', 'bestoon');
define('DB_HOST', 'localhost');
define('DB_USER', 'mehrab');
define('DB_PASS', '1234');

// Include functions
foreach (glob('lib/*.php') as $lib){
    include_once $lib;
}

// Include models
foreach (glob('app/*.php') as $class){
    include_once $class;
}

//Database Instance
$db = new Database();