<?php

define('APP_TITLE', 'بستون');
define('APP_URL', 'http://localhost/bestoon/');
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

// Include functions
foreach (glob('lib/*.php') as $lib){
    include_once $lib;
}