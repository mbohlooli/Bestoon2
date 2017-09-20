<?php


class User extends Database_object
{
    protected static $table_name = 'users';
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email', 'last_access', 'created_at', 'updated_at');
    public $id, $username, $password, $first_name, $last_name, $email, $last_access, $created_at, $updated_at;

    public function __construct()
    {
        $this->id = $this->insert_id()+1; 
    }

    public function full_name()
    {
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public function save($privileges = array(4))
    {
        return self::row_exists('username', $this->username) ? $this->update() : $this->create($privileges);
    }

    protected function create($privileges = array(4))
    {
        global $db;

        $attribute = $this->attributes();

        foreach ($attribute as $k=>$v){
            $attribute[$k] = $db->escape_value_sql($v);
        }

        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql.= join(', ', array_keys($attribute));
        $sql.= ") VALUES ('";
        $sql.= join("', '", array_values($attribute));
        $sql.= "');";
        if($db->query($sql)){
            $this->id = static::insert_id();
            foreach($privileges as $privilege_id)
            {
                $privilege = new User_privilege();
                $privilege->user_id = $this->id;
                $privilege->privilege_id = $privilege_id;
                $privilege->save();
            }
            return true;
        } else {
            return false;
        }
    }

    protected function update()
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

    public static function get_privileges()
    {
        global $session;
        global $db;
        if(!$session->is_logged_in()){
            return;
        }
        $privileges = $db->query("SELECT * FROM user_privileges WHERE user_id = {$_SESSION['user_id']}");
        return $privileges; 
    }

    public function has_privilege($privilege_id)
    {
        if(!$privilege_id || !is_numeric($privilege_id))
        {
            return;
        }
        global $db;
        $privileges = $db->query("
            SELECT * FROM user_privileges
            WHERE user_id = '{$this->id}';
        ");
        while($privilege = $privileges->fetch_assoc())
        {
            if($privilege['privilege_id'] == $privilege_id)
            {
                return true;
            }
        }
        return false;
    }
}