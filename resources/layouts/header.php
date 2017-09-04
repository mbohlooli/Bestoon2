<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>
            <?php
                echo function_exists('get_title') ? get_title() : APP_TITLE;
            ?>
        </title>

        <!-- Bootstrap -->
        <link href="<?php echo APP_URL ?>resources/assets/bootstrap/css/bootstrap-rtl.css" rel="stylesheet">
        <link href="<?php echo APP_URL ?>resources/assets/bootstrap/css/bootstrap-rtl-theme.css" rel="stylesheet">
        <link href="<?php echo APP_URL ?>resources/assets/Css/app.css" rel="stylesheet">
    </head>
    <body>
