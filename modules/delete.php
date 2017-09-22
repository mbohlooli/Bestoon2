<?php

function process_inputs(){
    if(!isset($_GET['id']) || !$_GET['id'] || !isset($_GET['name']) || !$_GET['name'])
    {
        redirect_to(home_url('404'));
    }

    if($_GET['name'] == 'income') {
        $obj = Income::find_by_id($_GET['id']);
    } elseif($_GET['name'] == 'expense') {
        $obj = Expense::find_by_id($_GET['id']);
    } elseif($_GET['name'] == 'post') {
        global $current_user;
        if(!$current_user->has_privilege(2)) return;
        $obj = Post::find_by_id($_GET['id']);
    } else {
        redirect_to(home_url('404'));
    }
    if($_GET['name'] != 'post' && !$obj->belongs_to($_SESSION['user_id'])){
        redirect_to(home_url('404'));
    }
    $obj->delete();
    if($_GET['name'] == 'post') redirect_to(home_url());
    else redirect_to(home_url('dashboard'));
}
