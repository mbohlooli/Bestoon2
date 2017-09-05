<?php


class User extends Database_object
{
    public static $table_name = 'users';
    public static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email', 'last_access', 'created_at', 'updated_at');
    public $id, $username, $password, $first_name, $last_name, $email, $last_access, $created_at, $updated_at;

    public function full_name()
    {
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public function save()
    {
        return self::row_exists('username', $this->username) ? $this->update() : $this->create();
    }

    public function update()
    {
        global $db;
        $attribute = $this->attributes();
        $attribute_pairs = array();
        foreach($attribute as $key => $value){
            $attribute_pairs[] = "{$key}='{$db->escape_value_both($value)}'";
        }
        $sql = "Update ".static::$table_name." SET ";
        $sql.= join(', ', $attribute_pairs);
        $sql.= " WHERE id=".$db->escape_value_both($this->id);
        $db->query($sql);
    }

    public static function authenticate($username = "", $password = "")
    {
        global $db;
        $username = $db->escape_value_both($username);
        $password = $db->escape_value_both($password);
        $user = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE username = '$username' LIMIT 1;");
        if (empty($user)) {
            return false;
        }
        if (validate_pw($password, $user[0]['password'])) {
            return true;
        }
    }
}