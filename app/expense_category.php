<?php


class Expense_category extends Database_object
{
    protected static $table_name = 'expense_categories';
    protected static $db_fields = Array('id', 'title');
    public static $categories = array(
        'خرید',
        'اجاره',
        'خودرو',
        'رفت و آمد',
        'غذا',
        'قبوض',
        'درمانی',
        'بدهی',
        'سرگرمی',
        'آموزش',
        'ضرر'
    );
    public $id;
    public $title;
    public $created_at;
    public $updated_at;

    public static function add_default_categories()
    {
        global $db;
        $rows = $db->query("
			SELECT * FROM `bestoon`.`expense_categories`
		");

        if($db->num_rows($rows) == 0){
            // Adding privileges into database
            foreach (self::$categories as $category) {
                $now = date("Y-m-d H:i:s");
                $db->query("
					INSERT INTO `bestoon`.`expense_categories` (title, created_at) VALUES
					('{$category}', '{$now}')
				");
            }
        }
    }

}