<?php

require_once 'dbLogin.php';
require_once 'dbTables.php';

class DBConn{

    // properties
    private $link;
       
    // methods
    public function __construct() {
        $this->link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        if (!$this->link) die ("Unable to connect to MySQL:" . mysql_error());
        
        mysql_select_db(DB_DATABASE)
            or die("Unable to select database: " . mysql_error());
            
    }
    
    public function __destruct() {
        mysql_close($this->link);
    }
    
    public function getSearchInfoArray($type){
        $table = '';
        switch($type){
            case 'bld': $table=BLDS; break;
            case 'dpmt': $table=DPMTS; break;
            case 'srv': $table=SRVS; break;
            default: die("Invalid search info type.");
        }
        
        $query = "SELECT * FROM " . $table;
        $result = mysql_query($query);
        if (!$result) die ("Database access failed: " . mysql_error());
        
        $retval = array();
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $retval[] = $line;
        }

        return $retval;
    }
}


?>
