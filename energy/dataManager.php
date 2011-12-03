<?php

require_once 'dbConn.php';

class DataManager{
    
    // properties
    private $_db;

    // methods
    
    // Note: all array values will be converted to type int or string.
    static private function getJSArray($phpArray, $jsArray){
       
        $str = $jsArray . "=Array(";       
        $count = Array(
            "row" => 1,
            "cell" => 1
        ); // count the number of rows/cell, used to add coms between elements.
        foreach($phpArray as $row){           
            $str .= "{";
            $count["cell"] = 1;
            foreach($row as $cell){
                // convert str to int if it is actually int.
                $tmp = (int)$cell;
                if ($cell=='0' || $tmp>0) $cell = $tmp;
                
                
                $str .= "\"" . key($row) . "\":";
                if (is_string($cell)){
                    $str .= "\"" . $cell ."\"";
                } else if (is_int($cell)){
                    $str .= $cell;
                } else {
                    die ("php array value is neither string nor integer.");
                }

                if ($count["cell"]<count($row)){
                    $str .= ",";
                }
//                $str .= "<br />";
                ++$count["cell"];
                next($row);
            }
            $str .= "}";
            if ($count["row"]<count($phpArray)){
                $str .= ",";
            }
//            $str .= "<br />";
            ++$count["row"];
        }        
        
       $str .= ");";
       return $str;
        
    }    
    
    public function createSearchBox($inputDiv, $srchObjName){
        $bldArray = $this->_db->getSearchInfoArray('bld');

        $dpmtArray = $this->_db->getSearchInfoArray('dpmt');
        $srvArray = $this->_db->getSearchInfoArray('srv');

        echo "<script>";
        echo self::getJSArray($bldArray, "bldArray");
        echo self::getJSArray($dpmtArray, "dpmtArray");
        echo self::getJSArray($srvArray, "srvArray");
        echo "var $srchObjName = new SearchBox(bldArray, dpmtArray, srvArray);";
        echo "$srchObjName.draw(\"$inputDiv\");";
        echo "$srchObjName.validate();";
        echo "</script>";
    }
    
    
    public function __construct() {
        $this->_db = new DBConn();
    }
    
//    public function __destruct() {
//        $this->_db->__destruct();
//    }
    

    

}
?>
