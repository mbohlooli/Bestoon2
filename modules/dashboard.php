<?php

function authentication_required(){
	return true;
}

function get_title(){
	return 'پیشخوان';
}

function get_content(){ 
	global $current_user;

    $url = APP_URL;
	echo "<h1>{$current_user->full_name()}</h1>";
    echo "<br><br>";

    echo "<a href='{$url}submit-income' class='btn btn-default'>ثبت دخل جدید</a>";

    echo "<br><br>";
	echo 'دسترسی ها:&nbsp;&nbsp;&nbsp;&nbsp;';
	echo Privilege::show_privileges();

}