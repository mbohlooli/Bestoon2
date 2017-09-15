<?php

function authentication_required(){
    return true;
}

function get_title(){
    return 'نمودار';
}

function get_content(){

    $has_income = Income::not_is_empty();
    $has_expense = Expense::not_is_empty();

    if(!$has_income && !$has_expense){
        echo '<div class="alert alert-info" role="alert">هنوز دخلی یا خرجی ثبت نشده است.</div>';
    }else{
        $incomes = Income::order_by_date();
        $expenses = Expense::order_by_date();
?>
        <div id="chartContainer"></div>

        <?php
            $income_points = array();
            while( $res = $incomes->fetch_assoc() )
            {
                $date = $res['date'][0].$res['date'][1].$res['date'][2].$res['date'][3].$res['date'][4].$res['date'][5].$res['date'][6];
                array_push($income_points,array("y" => $res['SUM(amount)'], "label" => $date));
            }
            $expense_points = array();
            while( $res = $expenses->fetch_assoc() )
            {
                $date = $res['date'][0].$res['date'][1].$res['date'][2].$res['date'][3].$res['date'][4].$res['date'][5].$res['date'][6];
                array_push($expense_points,array("y" => $res['SUM(amount)'], "label" => $date));
            }
        ?>

        <script type="text/javascript">

            $(function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "theme1",
                    animationEnabled: true,
                    title: {
                        text: "نمودار درآمد ها و خرج ها"
                    },
                    data: [
                        {
                            type: "line",
                            showInLegend: true,
                            name: "درآمد ها",
                            color: "#20B2AA",
                            lineThickness: 3,
                            dataPoints: <?php echo json_encode($income_points, JSON_NUMERIC_CHECK); ?>
                        },
                        {
                            type: "line",
                            showInLegend: true,
                            color: "#F08080",
                            name: "خرج ها",
                            markerType: "square",
                            lineThickness: 3,
                            dataPoints: <?php echo json_encode($expense_points, JSON_NUMERIC_CHECK); ?>
                        }
                    ]
                });
                chart.render();
            });
        </script>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php } ?>
    <a href="<?php echo APP_URL ?>chart1" class="btn btn-outline-royal" style="float: left !important;">مشاهده نمودار قبلی <span class=" glyphicon glyphicon-arrow-left"></span></a>
    <a href="<?php echo APP_URL ?>chart3" class="btn btn-outline-warning" style="float: right !important;"><span class=" glyphicon glyphicon-arrow-right"></span> مشاهده نمودار بعدی </a>
    <br><br>
<?php }