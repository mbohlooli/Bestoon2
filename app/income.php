<?php


class Income extends Database_object
{
    protected static $table_name = 'incomes';
    protected static $db_fields = array('id', 'title', 'amount', 'user_id');
    public $id;
    public $title;
    public $amount;
    private $user_id;


}