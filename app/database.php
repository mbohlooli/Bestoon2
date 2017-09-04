<?php


class Database
{
    private $connection;
    private $last_query;
    private $magic_quotes_active;
    private $real_escape_string_exists;

    function __construct(){
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
        $this->open_connection();
    }

    public function open_connection()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->connection->set_charset("utf8");
        if (mysqli_connect_errno()){
            die("Database selection failed: " .
                mysqli_connect_error() .
                " (" . mysqli_connect_errno() . ")"
            );
        }
    }

    public function close_connection()
    {
        if(isset($this->connection)){
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql)
    {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }

    public function escape_value_both($value)
    {
        if($this->real_escape_string_exists){ // PHP v4.3.0 or higher
            // undo any magic quote effects so mysqli_real_escape_string can do the work
            if($this->magic_quotes_active){
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else { // before PHP v4.3.0
            // if magic quote aren't already on then add slashes manually
            if(!$this->magic_quotes_active){
                $value = addslashes($value);
            }
            // if magic quotes are active, then the slashes already exist
        }
        return htmlspecialchars($value);
    }

    public function escape_value_sql($value)
    {
        if($this->real_escape_string_exists){ // PHP v4.3.0 or higher
            // undo any magic quote effects so mysqli_real_escape_string can do the work
            if($this->magic_quotes_active){
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else { // before PHP v4.3.0
            // if magic quote aren't already on then add slashes manually
            if(!$this->magic_quotes_active){
                $value = addslashes($value);
            }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }

    public function escape_value_xss($value)
    {
        return htmlspecialchars($value);
    }

    // "database-neutral" methods
    public function fetch_array($result_set)
    {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }

    public function insert_id($name)
    {
        $id = mysqli_query($this->connection, "SELECT MAX(id) FROM $name");
        $res = mysqli_fetch_assoc($id);
        // get the last id inserted over the current db connection
//        return mysqli_insert_id($this->connection);
        return $res['MAX(id)'];
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

    public function confirm_query($result)
    {
        if(!$result){
            $output = "<div style='margin: 10px;padding: 10px;background-color: #ffdddd;border-left: 6px solid #f44336; direction: ltr !important;'>Database query failed: ";
            $output .= "#" . mysqli_errno($this->connection) . "<br/><br/>";
            $output .= "Last SQL Query: <br/><br><div style='padding-left: 25px;'>" . $this->last_query . "</div>";
            $output .= "<br/>Error: <br/><br/><div style='padding-left: 25px;'>" .mysqli_error($this->connection). "</div></div>";
            die($output);
        }
    }

    private function create_default_tables()
    {

    }
}