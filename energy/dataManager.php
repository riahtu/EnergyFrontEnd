<?php

require_once 'dbConn.php';
require_once 'dbTables.php';
require_once 'objectData.php';

class DataManager{
    
    // properties
    private $_db;

 
    
    // methods
    static private function generateJSDataDisplayArrays($myObjectData){
        // generate "basicInfoArray"
        $str = DISPLAY_BASIC_INFO_ARRAY . "={" . "\"name\":\"" .$myObjectData->myName . "\"," .
                    "\"address\":\"" . $myObjectData->myAddress . "\"," .
                    "\"begin_time\":" . $myObjectData->beginTime . "," .
                    "\"end_time\":" . $myObjectData->endTime . "}";
        
        // generate "electInfoArray"
//        $str += DISPLAY_ELECT_INFO_ARRAY . "={" . "\"sum\":" . 

//define("DISPLAY_ELECT_INFO_ARRAY", "electInfoArray");
////ie.
////electInfoArray = {
////    "sum" : 195432,
////    "avg" : 15432,
////    "unit" : "Kilowatt",
////    "dataPairSet" : Array(
////        {
////            "name" : "rack+1",
////            "amount": 60
////        },
////
////        {
////            "name" : "rack+2",
////            "amount": 60
////        },
////        
////        {
////            "name" : "rack+3",
////            "amount" : 100
////        }
////    )
////
////}                   
                
        // generate "tmpInfoArray"
        
        // generate "edatasets"
        
        // generate "tdatasets"
        echo $str;
    }
    
    public function showData(){
        $ids = $this->validateUserSelctions();
        $myObjectData = new ObjectData($ids['type'], $ids['id'], $ids['btm'], $ids['etm'], $this->_db);
        self::generateJSDataDisplayArrays($myObjectData);
    }
    
    private function validateUserSelctions(){
        $bld = $_GET["bld"];
        $dpmt = $_GET["dpmt"];
        $srv = $_GET["srv"];
        $btm = $_GET["btm"];
        $etm = $_GET["etm"];

        if ($bld>=0 && $dpmt<0 && $srv<0){
            $type = "bld";
            $id = $bld;
        } else if ($dpmt>=0 && $srv<0){
            $type = "dpm";
            $id = $dpmt;
        } else if ($srv>=0){
            $type = "srv";
            $id = $srv;
        } else {
            die("incorrect ids - bld:$bld; dpmt:$dpmt; srv:$srv.");
        }
        
        if ($etm==-1) $etm = time();
        if ($etm<=$btm){
            die("Oops! incorret begin and end time.: begin_time:$btm; end_time:$etm. Please re-select!");
        }
        
        return array('type' => $type,
                     'id' => $id,
                     'btm' => $btm,
                     'etm' => $etm);
    }
    
    
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
                
        $attributes = Array(OBJECT_ATTRIBUTE_ID, OBJECT_ATTRIBUTE_NAME);
        $bldArray = $this->_db->getObjectInfo(OBJECT_TYPE_BLD, $attributes, null);

        $dpmtArray = $this->_db->getObjectInfo(OBJECT_TYPE_DPM, $attributes, null);
        $srvArray = $this->_db->getObjectInfo(OBJECT_TYPE_BLD, $attributes, null);

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
