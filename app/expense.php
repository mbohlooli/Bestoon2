<?php


class Expense extends Database_object
{
    protected static $table_name = 'expenses';
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
        $url = 'http://localhost/bestoon';
        $expenses = self::find_by_sql("SELECT * FROM ". self::$table_name ." WHERE user_id = {$_SESSION['user_id']}");
        if(empty($expenses))
        {
            echo "<div class='alert alert-info'>هنوز خرجی ثبت نشده است.</div>";
            return;
        }
        $i = 1;
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<tr class='bg-warning'><th colspan='7'><div align='center'>خرج ها</div></th></tr>";
        echo
        "<tr class='bg-info'>
            <th><div align='center'>ردیف</div></th>
            <th><div align='center'>موضوع</div></th>
            <th><div align='center'>میزان</div></th>
            <th><div align='center'>تاریخ</div></th>
            <th><div align='center'>دسته بندی</div></th>
            <th colspan='2'><div align='center'>عملیات</div></th>
        </tr>";
        $sum = 0;
        foreach ($expenses as $expense)
        {
            $cat_title = $db->fetch_array($db->query("SELECT title FROM expense_categories WHERE id = $expense[cat_id]"))['title'];
            echo
            "<tr style='background-color: #d4d4d4;'>
                <td><div align='center'>$i</div></td>
                <td><div align='center'>$expense[title]</div></td>
                <td><div align='center'>$expense[amount]</div></td>
                <td><div align='center'>$expense[date]</div></td>
                <td><div align='center'>$cat_title</div></td>
                <td><div align='center'><a href='$url/delete?id=$expense[id]&name=expense' class='btn btn-danger'>حذف</a></div></td>
                <td><div align='center'><a href='$url/update?id=$expense[id]&name=expense' class='btn btn-primary'>ویرایش</a></div></td>
            </tr>";
            $sum += $expense['amount'];
            $i++;
        }
        echo
        "<tr>
            <td class='bg-warning'><div align='center'>جمع</div></td>
            <td class='bg-success' colspan='6'><div align='center'>$sum</div></td>
        </tr>";
        $avg = $sum/($i-1);
        $avg = number_format((float)$avg, 2, '.', '');
        echo
        "<tr>
            <td class='bg-warning'><div align='center'>میانگین</div></td>
            <td class='bg-success' colspan='6'><div align='center'>$avg</div></td>
        </tr>";
        echo "</table>";
        echo "</div>";
    }

    public static function get_expenses_sum()
    {
        global $session;
        if(!$session->is_logged_in())
        {
            return;
        }
        global $db;
        $expenses = $db->fetch_array($db->query("SELECT SUM(amount) FROM expenses WHERE user_id = '{$_SESSION['user_id']}';"))['SUM(amount)'];
        return $expenses;
    }

    public function belongs_to($user_id)
    {
        return $this->user_id == $user_id ? true : false;
    }

    public static function order_by_date()
    {
        global $db;

        $result = $db->query("
            SELECT date, AVG(amount), SUM(amount), COUNT(date), date
            FROM expenses WHERE user_id = '{$_SESSION['user_id']}'
            GROUP BY MONTH(date);
        ");
        return($result);
    }

    public static function order_by_cat($cat_id){
        global $db;

        $res = $db->query("
            SELECT SUM(amount)
            FROM expenses
            WHERE cat_id = '$cat_id' AND user_id = '$_SESSION[user_id]'
        ");

        $result = $res->fetch_assoc();

        return $result['SUM(amount)'];
    }

    public function show_combobx()
    {
        $options = Expense_category::find_all();
        echo "<select class='form-control' name='category' id='category'>";
        foreach ($options as $option){
            if($option['id'] == $this->cat_id) {
                echo "<option value='$option[id]' selected>$option[title]</option>";
            } else {
                echo "<option value='$option[id]'>$option[title]</option>";
            }
        }
        echo "</select>";
    }

}
