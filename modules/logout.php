<?php

function process_inputs(){
    if(!isset($_SESSION['user_id']))
    {
        redirect_to(home_url('404'));
    }
    global $session;
    $session->logout();
    redirect_to(home_url('home'));
}