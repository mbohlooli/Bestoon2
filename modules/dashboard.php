<?php

function authentication_required(){
	return true;
}

function get_title(){
	return 'پیشخوان';
}

function get_content(){ 
	global $current_user;
?>
	<h1><?php echo $current_user->full_name() ?></h1>
    <br><br>
    <a href="<?php echo APP_URL ?>submit-income" class="btn btn-outline-success">ثبت درآمد</a>
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
	دسترسی ها:&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	echo Privilege::show_privileges();
}