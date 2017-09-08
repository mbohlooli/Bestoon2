<?php


class User_privilege extends Database_object
{
    protected static $table_name = 'user_privileges';
    protected static $db_fields = Array('id', 'user_id', 'privilege_id');
    public $user_id;
    public $privilege_id;

    public function __construct ()
    {
        $this->id = $this->insert_id()+1;
    }
}