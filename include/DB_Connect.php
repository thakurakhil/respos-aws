<?php
class DB_Connect {

    // constructor
    function __construct() {
        
    }

    // destructor
    function __destruct() {
        // $this->close();
    }

    // Connecting to database
    public function connect() {
        require_once(__DIR__.'/config.php');
 
        // connecting to mysql
        $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('MySQL Not found // Could Not Connect.');
        // selecting database
        mysql_select_db(DB_DATABASE) or die ("No Database found.");

//$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        // return database handler
        return $con;
    }

    // Closing database connection
    public function close() {
        mysqli_close();
    }

}

?>
