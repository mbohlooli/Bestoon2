<?php

function authentication_required(){
    return true;
}

function get_title(){
    return 'نمودار';
}

function get_content(){
    
    $income_sum = Income::get_incomes_sum();
    $expense_sum = Expense::get_expenses_sum();

    if(!$income_sum && !$expense_sum){
        echo '<div class="alert alert-info" role="alert">هنوز دخل و خرجی ثبت نشده است.</div>';
    } else {
        $result = $income_sum - $expense_sum;
?>
        <div id="chartContainer"></div>
        <?php
            $dataPoints = array(
                array("y" => $income_sum, "label" => "درآمد"),
                array("y" => $expense_sum, "label" => "خرج"),
                array("y" => $result, "label" => "موجودی"),
            );
        ?>
        <script type="text/javascript">

            $(function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "theme1",
                    animationEnabled: true,
                    title: {
                        text: "نمودار درآمد ها و خرج  ها"
                    },
                    data: [
                        {
                            type: "column",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }
                    ]
                });
                chart.render();
            });
        </script>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="<?php echo APP_URL ?>chart2" class="btn btn-outline-warning" style="float: right !important;"><span class=" glyphicon glyphicon-arrow-right"></span> مشاهده نمودار بعدی </a>
        <br><br>
<?php
    }
}
