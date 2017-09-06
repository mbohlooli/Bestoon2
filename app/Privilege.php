<?php

class Privilege extends Database_object
{
	protected static $table_name = 'privileges';
	protected static $db_fields = array('id', 'description', 'created_at', 'updated_at');

	public static $privileges = array(
		'اضافه کردن، مشاهده، ویرایش، و حذف مدیران و دسترسی ها',
		'اضافه کردن، مشاهده، ویرایش، و حذف اخبار',
		'اضافه کردن، مشاهده، ویرایش و حذف کاربران و صفحات',
		'اضافه کردن، مشاهده، ویرایش و حذف دخل و خرج',
	);

	public static function add_default_prvileges()
	{
		global $db;
		$rows = $db->query("
			SELECT * FROM `bestoon`.`privileges`
		");

		if($db->num_rows($rows) == 0){
				// Adding privileges into database
			foreach (self::$privileges as $privilege) {
				$now = date("Y-m-d H:i:s");
				$db->query("
					INSERT INTO `bestoon`.`privileges` (description, created_at) VALUES
					('{$privilege}', '{$now}')
				");
			}
		}	
	}
}