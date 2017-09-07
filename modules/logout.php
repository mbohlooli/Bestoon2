<?php

function process_inputs(){
    if(!isset($_SESSION['user_id']))
    {
        // TODO: fix the bug of invalid redirecting
        redirect_to(home_url('404'));
    }
    global $session;
    $session->logout();
    redirect_to(home_url('home'));
}