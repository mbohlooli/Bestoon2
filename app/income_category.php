<?php


class Income_category extends Database_object
{
    protected static $table_name = 'income_categories';
    protected static $db_fields = Array('id', 'title');
    public static $categories = array(
        'حقوق',
        'اجاره',
        'فروش',
        'طلب',
        'یارانه',
        'سود'
    );
    public $id;
    public $title;
    public $created_at;
    public $updated_at;

    public static function add_default_categories()
    {
        global $db;
        $rows = $db->query("
			SELECT * FROM `bestoon`.`income_categories`
		");

        if($db->num_rows($rows) == 0){
            // Adding privileges into database
            foreach (self::$categories as $category) {
                $now = date("Y-m-d H:i:s");
                $db->query("
					INSERT INTO `bestoon`.`income_categories` (title, created_at) VALUES
					('{$category}', '{$now}')
				");
            }
        }
    }

    public static function show_combobx()
    {
        $options = self::find_all();
        echo "<select class='form-control' name='category' id='category'>";
        foreach ($options as $option){
            echo "<option value='$option[id]'>$option[title]</option>";
        }
        echo "</select>";
    }

}