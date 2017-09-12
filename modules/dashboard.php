<?php

function authentication_required(){
	return true;
}

function get_title(){
	return 'پیشخوان';
}

function get_content(){ 
	global $current_user;
    global $db;
?>
	<h1><?php echo $current_user->full_name() ?></h1>
    <br><br>
    <a href="<?php echo APP_URL ?>submit-income" class="btn btn-outline-success" style="margin-left: 10px;">ثبت درآمد</a>
    <a href="<?php echo APP_URL ?>submit-expense" class="btn btn-outline-danger">ثبت خرج</a>
    <br><br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php Income::show_table(); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php Expense::show_table(); ?>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                $sum_income = $db->fetch_array($db->query("SELECT SUM(amount) FROM incomes WHERE user_id = '{$_SESSION['user_id']}';"))['SUM(amount)'];
                $sum_expense = $db->fetch_array($db->query("SELECT SUM(amount) FROM expenses WHERE user_id = '{$_SESSION['user_id']}';"))['SUM(amount)'];
            ?>
            <h3>برآیند: </h3><h3 style="direction: ltr !important;text-align: right;"><?php echo $sum_income-$sum_expense ?></h3>
        </div>
    </div>
    <br><br>
	دسترسی ها:&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	echo Privilege::show_privileges();
}