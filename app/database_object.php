<?php


class Database_object
{
    // Table name in database
    protected static $table_name;
    // table columns
    protected static $db_fields;

    public $id;

    public function __construct()
    {
        $this->id = $this->insert_id()+1;
    }

    /**
     * @param string $sql
     * @param bool $convert_to_array
     * @return array
     * runs a query on database & gives the rusult in an costum array or an array of objects
     */
    public static function find_by_sql($sql = "", $convert_to_array = true)
    {
        global $db;
        $result_set = $db->query($sql);
        if($convert_to_array){
            $result_array = array();
            while($row = $db->fetch_array($result_set)){
                $result_array[] = static::array_instantiate($row);
            }
            return $result_array;
        } else {
            $object_array = array();
            while($row = $db->fetch_array($result_set)){
                $object_array[] = static::instantiate($row);
            }
            return $object_array;
        }
    }

    /**
     * @param $record
     * @return mixed
     */
    private static function instantiate($record)
    {
        // Could chedck that $record exists and is a array
        // Simple, long-form approach
        $class_name = get_called_class();
        $object = new $class_name;
        // Old mehtod
        //$object->id = $record['id'];
        //$object->username = $record['username'];
        //$object->password = $record['password'];
        //$object->first_name = $record['first_name'];
        //$object->last_name = $record['last_name'];

        //More dynamic, short-form approach:
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    /**
     * @param $record
     * @return array
     */
    private static function array_instantiate($record)
    {
        $class_name = get_called_class();
        $object = new $class_name;
        $result_in_array = array();
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $result_in_array["$attribute"] = $value;
            }
        }
        return $result_in_array;
    }

    /**
     * @param $attribute
     * @return bool
     */
    private function has_attribute($attribute)
    {
        // get object vars returns an associative array with all attributes
        // (including private ones!) as the keys and their current values as the value
        $object_vars = $this->attributes();
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $object_vars);
    }

    /**
     * @return array
     * returns an array of object attributes
     */
    protected function attributes()
    {
        $attributes = array();
        foreach (static::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    /**
     * @return array
     * secures app to sql injection
     */
    protected function sanitized_attribute(){
        global $db;
        $clean_attributes = array();
        foreach ($this->attributes() as $key => $value){
            $clean_attributes[$key] = $db->escape_value_sql($value);
        }
        return $clean_attributes;
    }

    /**
     * @return array
     * gets all of the table
     */
    public static function find_all()
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name);
    }

    /**
     * @return mixed
     * @internal param string $name
     */
    public function insert_id()
    {
        global $db;
        $id = $db->query("SELECT MAX(id) FROM ".static::$table_name);
        $res = $id->fetch_assoc();
        // get the last id inserted over the current db connection
        //return mysqli_insert_id($this->connection);
        return $res['MAX(id)'];
    }

    /**
     * @param int $id
     * @param bool $in_array
     * @return bool|mixed
     * finds a row that matches given id
     */
    public static function find_by_id($id = 0, $in_array = false)
    {
        global $db;
        $id = $db->escape_value_both($id);
        $result_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE id='{$id}' LIMIT 1", $in_array);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $in_array
     * @return bool|mixed
     * finds a row that the colname of it matches the given value
     */
    public static function find_by_colname($name = "", $value = "", $in_array = true)
    {
        $result_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE $name='{$value}' LIMIT 1", $in_array);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * @return bool|void
     * create if not exists, update if exists
     */
    public function save()
    {
        return static::find_by_id($this->id) ? $this->update() : $this->create();
    }

    /**
     * @return bool
     * insert a row in database based on current object attribnutes
     */
    protected function create()
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
        /*$sql.= $db->escape_value_both($this->username) . "' , '";
        if(self::user_exists($this->username)){
            add_message('این کاربر قبلا ثبت شده است!', 'warning');
            return;
        }
        $sql.= $db->escape_value_both(generate_hash($this->password)) . "' , '";
        $sql.= $db->escape_value_both($this->first_name) . "' , '";
        $sql.= $db->escape_value_both($this->last_name) . "');";*/
        if($db->query($sql)){
            $this->id = static::insert_id();
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
            $attribute_pairs[] = "{$db->escape_value_sql($key)}='{$db->escape_value_sql($value)}'";
        }
        $sql = "Update ".static::$table_name." SET ";
        $sql.= join(', ', $attribute_pairs);
        $sql.= " WHERE id=".$db->escape_value_both($this->id);
        $db->query($sql);
    }

    public function delete()
    {
        global $db;
        $sql = "DELETE FROM ". static::$table_name;
        $sql.= " WHERE id=".$db->escape_value_both($this->id);
        $sql.= " LIMIT 1";
        $db->query($sql);
    }

    public static function row_exists($col_name, $value)
    {
        $row_exists = self::find_by_colname($col_name, $value);
        return $row_exists ? true : false;
    }

    public static function not_is_empty()
    {
        global $db;
        $table = $db->query("
            SELECT * FROM ". static::$table_name ."
        ");
        if($table->num_rows == 0){
            return false;
        }
        return true;
    }
}