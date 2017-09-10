<?php


class Income extends Database_object
{
    protected static $table_name = 'incomes';
    protected static $db_fields = array('id', 'title', 'amount', 'date', 'user_id');
    public $id;
    public $title;
    public $amount;
    public $date;
    protected $user_id;

    public function __construct()
    {
        global $current_user;
        $this->id = $this->insert_id()+1;
        $this->user_id = $current_user->id;
    }

}