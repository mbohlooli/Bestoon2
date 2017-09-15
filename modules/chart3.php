    <?php

    function authentication_required(){
        return true;
    }

    function get_title(){
        return 'نمودار';
    }

    function get_content(){
        global $db;

        $row = $db->query("
            SELECT * FROM income_categories 
        ");
    ?>
        <div id="chartContainer1"></div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <hr>
        <div id="chartContainer2"></div>
        <?php
            $income_points = array();
            while($res = $row->fetch_assoc()){
                $array_object = Income::order_by_cat($res['id']);
                if($array_object){
                    array_push($income_points, array("y" => $array_object, "label" => $res['title']));
                }
            }

            $row = $db->query("
                SELECT * FROM expense_categories 
            ");

            $expense_points = array();
            while($res = $row->fetch_assoc()){
                $array_object = Expense::order_by_cat($res['id']);
                if($array_object){
                    array_push($expense_points, array("y" => $array_object, "label" => $res['title']));
                }
            }
        ?>
        <script type="text/javascript">

            $(function () {
                CanvasJS.addColorSet("bootstrap",
                    [
                        "#28a745",
                        "#17a2b8",
                        "#ffc107",
                        "#dc3545",
                        "#886aea"
                    ]);
               var incomes_chart = new CanvasJS.Chart("chartContainer1", {
                   colorSet : "bootstrap",
                    animationEnabled: true,
                    title: {
                        text: "دسته بندی درآمد ها"
                    },
                    data: [
                        {
                            type: "pie",
                            dataPoints: <?php echo json_encode($income_points, JSON_NUMERIC_CHECK); ?>
                        }
                    ]
                });
                incomes_chart.render();
                var expenses_chart = new CanvasJS.Chart("chartContainer2", {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "دسته بندی خرج ها"
                    },
                    data: [
                        {
                            type: "pie",
                            dataPoints: <?php echo json_encode($expense_points, JSON_NUMERIC_CHECK); ?>
                        }
                    ]
                });
                expenses_chart.render();
            });
        </script>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="<?php echo APP_URL ?>chart2" class="btn btn-outline-royal" style="float: left !important;">مشاهده نمودار قبلی <span class=" glyphicon glyphicon-arrow-left"></span></a>
        <br><br>
    <?php }
