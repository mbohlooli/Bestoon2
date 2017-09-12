<?php


class Income extends Database_object
{
    protected static $table_name = 'incomes';
    protected static $db_fields = array('id', 'title', 'amount', 'date', 'user_id', 'cat_id');
    public $id;
    public $title;
    public $amount;
    public $date;
    protected $user_id;
    public $cat_id;

    public function __construct()
    {
        global $current_user;
        $this->id = $this->insert_id()+1;
        $this->user_id = $current_user->id;
    }

    public static function show_table()
    {
        global $db;
        $incomes = self::find_by_sql("SELECT * FROM ". self::$table_name ." WHERE user_id = {$_SESSION['user_id']}");
        if(empty($incomes))
        {
            echo "<div class='alert alert-info'>هنوز درآمدی ثبت نشده است.</div>";
            return;
        }
        $i = 1;
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<tr class='bg-warning'><th colspan='5'><div align='center'>درآمد ها</div></th></tr>";
        echo
        "<tr class='bg-info'>
            <th><div align='center'>ردیف</div></th>
            <th><div align='center'>موضوع</div></th>
            <th><div align='center'>میزان</div></th>
            <th><div align='center'>تاریخ</div></th>
            <th><div align='center'>دسته بندی</div></th>
        </tr>";
        $sum = 0;
        foreach ($incomes as $income)
        {
            $cat_title = $db->fetch_array($db->query("SELECT title FROM income_categories WHERE id = $income[cat_id]"))['title'];
            echo
            "<tr style='background-color: lightgrey;'>
                <td><div align='center'>$i</div></td>
                <td><div align='center'>$income[title]</div></td>
                <td><div align='center'>$income[amount]</div></td>
                <td><div align='center'>$income[date]</div></td>
                <td><div align='center'>$cat_title</div></td>
            </tr>";
            $sum += $income['amount'];
            $i++;
        }
        echo
        "<tr>
            <td class='bg-primary'><div align='center'>جمع</div></td>
            <td class='bg-success' colspan='4'><div align='center'>$sum</div></td>
        </tr>";
        $avg = $sum/($i-1);
        echo
        "<tr>
            <td class='bg-warning'><div align='center'>میانگین</div></td>
            <td class='bg-info' colspan='4'><div align='center'>$avg</div></td>
        </tr>";
        echo "</table>";
        echo "</div>";
    }
}