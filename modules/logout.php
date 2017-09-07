<?php

function process_inputs(){
    if(!isset($_SESSION['user_id']))
    {
        redirect_to(home_url('404'));
    }
    $current_user = User::find_by_id($_SESSION['user_id']);
    $current_user->last_access = date("Y-m-d H:i:s");
    $current_user->save();
    global $session;
    $session->logout();
    redirect_to(home_url('home'));
}