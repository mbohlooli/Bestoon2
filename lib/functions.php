<?php

// get the value if not exists returns a default one
function get_value($param,$default = null) {
    if (isset($_POST[$param])) {
        $value = $_POST[$param];
    } else {
        $value = $default;
    }
    return $value;
}

/**
 * @param null $path
 * @return string
 * the home page url of app
 */
function home_url($path = null) {
    if(!$path || $path == '/') {
        return APP_URL;
    }
    return APP_URL . $path;
}

/**
 * @param $url
 * @return bool
 * cheaks if the url is valid or not
 */
function is_valid_url($url) {
    if(empty($url)) {
        return false;
    }

    return (filter_var($url, FILTER_VALIDATE_URL) !== false);
}

/**
 * @param string $url
 * redirects to a url
 */
function redirect_to($url) {
    if(!is_valid_url($url)) {
        return;
    }
    header("Location: $url");
    die();
}

/**
 * @param $string
 * @return string
 * secures to xss & sql injections
 */
function prepare_input($string){
    $result =  htmlspecialchars(stripslashes($string));

    str_replace("'", '"', $result);

    return $result;
}


function print_var($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}