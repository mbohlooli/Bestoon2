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
    } else {
        redirect_to(home_url('404'));
    }
    if(!$obj->belongs_to($_SESSION['user_id'])){
        redirect_to(home_url('404'));
    }
    $obj->delete();
    redirect_to(home_url('dashboard'));
}
