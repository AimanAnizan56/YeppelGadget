<?php
// singleton class
class Database {
    // variable for database initialization
    private static $instance = null;
    private const HOST = 'localhost';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const DATABASE = 'yeppel gadget';

    // constructor -- to initialize database connection
    private function __construct() { 
        $conn = new mysqli(
            self::HOST, // localhost
            self::USERNAME, // root
            self::PASSWORD, // none
            self::DATABASE // yeppel gadget
        );
        // check error for database connection
        if($conn -> connect_errno) {
            // print formatted string
            printf(
                "<h1>%s</h1> <did>%s</did>",
                "ERROR! CANNOT CONNECT TO THE DATABASE",
                "Error: ".$conn -> connect_error
            );  
            exit; // print error and terminate program 
        }   
        self::$instance = $conn; // assign $conn to $instance if no error
    }

    // static method -- return mysql database
    public static function getInstance(): MySQLi {
        if(self::$instance === null){ 
            // call constructor -- $instance will be initialize
            new static();
        } 
        return self::$instance; // return static variable -- $instance
    }

    public static function getRows(string $sql) : array {
        $rows = array();
        $result = self::getInstance() -> query($sql);
        while($row = $result -> fetch_object()){
            $rows[] = $row;
        }
        return $rows;
    }
}
// close database connection
function close_connection(){
    Database::getInstance() -> close(); // close mysqli connection
}
// -- execute function at the end of file
register_shutdown_function('close_connection');
?>