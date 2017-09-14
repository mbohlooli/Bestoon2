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
                array("y" => $income_sum, "label" => "دخل"),
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
                        text: "نمودار دخل ها و خرج  ها"
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
<?php
    }
}
