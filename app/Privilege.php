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

    public $id;
    public $description;
    public $created_at;
    public $updated_at;
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

	public static function show_privileges()
	{
		global $session;
		if(!$session->is_logged_in())
		{
			return;
		}
		$privileges = User::get_privileges();
		while($privilege = $privileges->fetch_assoc())
		{
			switch($privilege['privilege_id'])
			{
				case 1:
					echo '<button class="btn btn-success" style="margin-bottom: 20px;margin-top: 40px">';
					echo 'مدیر مدیران';
					echo '</button>';
					echo '&nbsp;';
					break;
				case 2:
					echo '<button class="btn btn-warning" style="margin-bottom: 20px;margin-top: 40px">';
					echo 'نویسنده';
					echo '</button>';
					echo '&nbsp;';
					break;
				case 3:
					echo '<button class="btn btn-primary" style="margin-bottom: 20px;margin-top: 40px">';
					echo 'مدیر';
					echo '</button>';
					echo '&nbsp;';
					break;
				case 4:
					echo '<button class="btn btn-info" style="margin-bottom: 20px;margin-top: 40px">';
					echo 'کاربر';
					echo '</button>';
					echo '&nbsp;';
					break;
			}
		}
	}
}