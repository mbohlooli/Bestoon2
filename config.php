<?php

define('APP_TITLE', 'بستون');
define('APP_URL', 'http://localhost/bestoon/');
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

define('DB_NAME', 'bestoon');
define('DB_HOST', 'localhost');
define('DB_USER', 'mehrab');
define('DB_PASS', '1234');

// Admin user info
define('ADMIN_USERNAME', 'mehrab');
define('ADMIN_PASSWORD', 'p@s$wd12');
define('ADMIN_FIRSTNAME', 'مهراب');
define('ADMIN_LASTNAME', 'بهلولی');
define('ADMIN_EMAIL', 'bohlool82@gmail.com');

// session expiration time
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

// Adding incomes categories
Income_category::add_default_categories();

// Adding expenses categories
Expense_category::add_default_categories();

// Adding session
$session = new Session();

// Adding admin user
$user = new User();
$user->username = ADMIN_USERNAME;
$user->password = generate_hash(ADMIN_PASSWORD);
$user->first_name = ADMIN_FIRSTNAME;
$user->last_name = ADMIN_LASTNAME;
$user->email = ADMIN_EMAIL;
$user->last_access = date("0000-00-00 00:00:00");
$user->created_at = date("Y-m-d H:i:s");
$user->updated_at = "0000-00-00 00:00:00";
$user->save([1,2,3,4]);


if($session->is_logged_in())
{
	global $current_user;
	$current_user = User::find_by_sql("SELECT * FROM users WHERE id = '{$_SESSION['user_id']}' LIMIT 1;", false)[0];
}