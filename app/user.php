<?php


class User extends Database_object
{
    public static $table_name = 'users';
    public static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email', 'last_access', 'created_at', 'updated_at');

    public $id, $username, $password, $first_name, $last_name, $email, $last_access, $created_at, $updated_at;
}