<?php


class Database
{
    private $connection;
    private $last_query;
    private $magic_quotes_active;
    private $real_escape_string_exists;

    function __construct(){
        // Sets the current active configuration setting of magic_quotes_runtime in object
        $this->magic_quotes_active = get_magic_quotes_gpc();
        // Turn escaping special characters on
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
        // connecting to database
        $this->open_connection();
        // creating tables
        $this->create_default_tables();
    }

    public function open_connection()
    {
        // opens connection with mysql
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // Sets the charset
        $this->connection->set_charset("utf8");
        // Exception hadling while connecting to database
        if (mysqli_connect_errno()){
            die("Database selection failed: " .
                mysqli_connect_error() .
                " (" . mysqli_connect_errno() . ")"
            );
        }
    }

    public function close_connection()
    {
        // Cheaks if connection is established
        if(isset($this->connection)){
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    /**
    * @param String $query
    * @return mysqli_result
    */
    public function query($sql)
    {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }
    /**
    * @param string $value
    * @return string
    */
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
        // secures result to Xss
        return htmlspecialchars($value);
    }

    /**
     * @param string $value
     * @return string
     */
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

    /**
     * @param string $value
     * @return string
     */
    public function escape_value_xss($value)
    {
        return htmlspecialchars($value);
    }

    // "database-neutral" methods
    /**
     * @param mysqli_result $result_set
     * @return array|null
     */
    public function fetch_array($result_set)
    {
        return mysqli_fetch_assoc($result_set);
    }

    /**
     * @param mysqli_result $result_set
     * @return int
     */
    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }


    // Returns the rows that had been affected by last query
    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

    /**
     * @param $result
     * Cheaks query if is correct & doesn't have any errors
     */
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

    /**
     * Creates database tables
     */
    private function create_default_tables()
    {
        $this->query("
            CREATE TABLE IF NOT EXISTS `bestoon`.`users` (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(35) NOT NULL,
                password TEXT NOT NULL,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(255) NOT NULL,
                last_access DATETIME NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL,
                UNIQUE (`username`),
                UNIQUE (`email`)
            );
        ");

        $this->query("
            CREATE TABLE IF NOT EXISTS `bestoon`.`privileges` (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                description TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL
            );
        ");

    }
}