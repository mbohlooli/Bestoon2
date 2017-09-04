<?php

function get_value($param,$default = null) {
    if (isset($_POST[$param])) {
        $value = $_POST[$param];
    } else {
        $value = $default;
    }
    return $value;
}

function home_url($path = null) {
    if(!$path || $path == '/') {
        return App_URL;
    }
    return App_URL . $path;
}

function is_valid_url($url) {
    if(empty($url)) {
        return false;
    }

    return (filter_var($url, FILTER_VALIDATE_URL) !== false);
}

function redirect_to($url) {
    if(!is_valid_url($url)) {
        return;
    }
    header("Location: $url");
    die();
}

function prepare_input($string){
    $result =  htmlspecialchars(stripslashes($string));

    str_replace("'", '"', $result);

    return $result;
}
