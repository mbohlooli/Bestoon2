<?php


class Expense extends Database_object
{
    protected static $table_name = 'expenses';
    protected static $db_fields = array('id', 'title', 'amount', 'date', 'user_id');
    public $id;
    public $title;
    public $amount;
    public $date;
    protected $user_id;

    public function __construct()
    {
        global $current_user;
        $this->id = $this->insert_id()+1;
        $this->user_id = $current_user->id;
    }

    public static function show_table()
    {
        $expenses = self::find_by_sql("SELECT * FROM ". self::$table_name ." WHERE user_id = {$_SESSION['user_id']}");
        if(empty($expenses))
        {
            echo "<div class='alert alert-info'>هنوز خرجی ثبت نشده است.</div>";
            return;
        }
        $i = 1;
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<tr class='bg-warning'><th colspan='4'><div align='center'>خرج ها</div></th></tr>";
        echo
        "<tr class='bg-info'>
            <th><div align='center'>ردیف</div></th>
            <th><div align='center'>موضوع</div></th>
            <th><div align='center'>میزان</div></th>
            <th><div align='center'>تاریخ</div></th>
        </tr>";
        foreach ($expenses as $expense)
        {
            echo
            "<tr style='background-color: lightgrey;'>
                <td><div align='center'>$i</div></td>
                <td><div align='center'>$expense[title]</div></td>
                <td><div align='center'>$expense[amount]</div></td>
                <td><div align='center'>$expense[date]</div></td>
            </tr>";
            $i++;
        }
        echo "</table>";
        echo "</div>";
    }
}