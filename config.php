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

// Include models
foreach (glob('app/*.php') as $class){
    include_once $class;
}

//Database Instance
$db = new Database();

// Sets the default timezone to Tehran
date_default_timezone_set("Asia/Tehran");

// Privileges
$privileges = array(
	'اضافه کردن، مشاهده، ویرایش، و حذف مدیران و دسترسی ها',
	'اضافه کردن، مشاهده، ویرایش و حذف کاربران و صفحات',
	'اضافه کردن، مشاهده، ویرایش و حذف دخل و خرج',
);

// Adding privileges into database
foreach ($privileges as $privilege) {
	$now = date("Y-m-d H:i:s");
	$db->query("
		INSERT INTO `bestoon`.`privileges` (description, created_at) VALUES
		('{$privilege}', '{$now}')
	");
}
