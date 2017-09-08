<?php

function authentication_required(){
	return true;
}

function get_title(){
	return 'پیشخوان';
}

function get_content(){ 
	global $current_user;
	
	echo "<h1>{$current_user->full_name()}</h1>";

	echo 'دسترسی ها:&nbsp;&nbsp;&nbsp;&nbsp;';
	echo Privilege::show_privileges();

}