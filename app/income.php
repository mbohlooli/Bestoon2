<?php


class Income extends Database_object
{
    protected static $table_name = 'incomes';
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
        $incomes = self::find_by_sql("SELECT * FROM ". self::$table_name ." WHERE user_id = {$_SESSION['user_id']}");
        if(empty($incomes))
        {
            echo "<div class='alert alert-info'>هنوز درآمدی ثبت نشده است.</div>";
            return;
        }
        $i = 1;
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<tr class='bg-warning'><th colspan='4'><div align='center'>درآمد ها</div></th></tr>";
        echo
        "<tr class='bg-info'>
            <th><div align='center'>ردیف</div></th>
            <th><div align='center'>موضوع</div></th>
            <th><div align='center'>میزان</div></th>
            <th><div align='center'>تاریخ</div></th>
        </tr>";
        $sum = 0;
        foreach ($incomes as $income)
        {
            echo
            "<tr style='background-color: lightgrey;'>
                <td><div align='center'>$i</div></td>
                <td><div align='center'>$income[title]</div></td>
                <td><div align='center'>$income[amount]</div></td>
                <td><div align='center'>$income[date]</div></td>
            </tr>";
            $sum += $income['amount'];
            $i++;
        }
        echo
        "<tr>
            <td class='bg-primary'><div align='center'>جمع</div></td>
            <td class='bg-success' colspan='3'><div align='center'>$sum</div></td>
        </tr>";
        $avg = $sum/($i-1);
        echo
        "<tr>
            <td class='bg-warning'><div align='center'>میانگین</div></td>
            <td class='bg-info' colspan='3'><div align='center'>$avg</div></td>
        </tr>";
        echo "</table>";
        echo "</div>";
    }
}