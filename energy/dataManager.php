<?php

require_once 'dbConn.php';
require_once 'dbTables.php';
require_once 'objectData.php';



class DataManager{
    
    // properties
    private $_db;
    static private $_isDisplayPrefix = "displayer";
    static private $_jsDisplayCount = 0;

 
    
    // methods
    private function generateDataSetsAux($dataPairs){
        $str = "";
        foreach($dataPairs as $dataPair){
            $str .= "[" . $dataPair[DATA_ATTRIBUTE_BEGIN_TIME] . DISPLAY_DATA_SETS_TIME_MULTIPLIER . "," . 
                    $dataPair[DATA_ATTRIBUTE_AMOUNT] . "],";
        }
        if ($str!=="") return "[" . substr($str, 0, strlen($str)-1) . "]";
        else return "null";        
    }

    private function generateDataSets($datasetName, $dtType, $myObjectData){
        // generate "datasets"
        $ids = $myObjectData->myChildrenIds;
        $objType = $myObjectData->myChildrenType;
        $btime = $myObjectData->beginTime;
        $etime = $myObjectData->endTime;
        $str = "";
        foreach($ids as $id){
            $objctDtStr = "";
            $curObjDt = new ObjectData($objType, $id, $btime, $etime, $this->_db);
            foreach ($curObjDt->myDataSets as $curDtSt){
                if ($curDtSt->dataType===$dtType){
                    $curDataPairs = $this->generateDataSetsAux($curDtSt->dataPairs);
                    if ($curDataPairs !== "null"){
                        $objctDtStr .= "\"" . $curObjDt->myName . "\":{" .
                                DISPLAY_DATA_SETS_KEY_LABEL . ":\"" . $curObjDt->myName . "\"," .
                                DISPLAY_DATA_SETS_KEY_DATA . ":" . $curDataPairs . "},";                        
                    }
                    break;
                }
            }
            $str .= $objctDtStr;
        }
        if ($str!=="") return $datasetName . "={" . substr($str, 0, strlen($str)-1) . "}";
        else return $datasetName . "=null";
    }

        

    
    private function generateJSTmpInfoArrayAux($dataPairs){
        $str = "";
        foreach($dataPairs as $dataPair){
            $str .= $dataPair[DATA_ATTRIBUTE_AMOUNT] . ",";
        }
        if ($str!=="") return "Array(" . substr($str, 0, strlen($str)-1) . ")";
        else return "null";
    }

    private function generateJSTmpInfoArray($myObjectData){
        // generate "tmpInfoArray"
        $str = "";
        $datatype = DATA_TYPE_TMP;
        foreach($myObjectData->myDataSets as $dataSet){
            if ($dataSet->dataType === $datatype){
                $str .= DISPLAY_TMP_INFO_ARRAY . "={" . 
                        "\"" . DISPLAY_TMP_INFO_ARRAY_KEY_MAX . "\":" . $dataSet->dataStats[DATA_STAT_MAX] . "," .
                        "\"" . DISPLAY_TMP_INFO_ARRAY_KEY_MIN . "\":" . $dataSet->dataStats[DATA_STAT_MIN] . "," .
                        "\"" . DISPLAY_TMP_INFO_ARRAY_KEY_DSET . "\":" . $this->generateJSTmpInfoArrayAux($dataSet->dataPairs) . "}";
                break;  // found target data type.                          
            }
        }
        if ($str!=="") return $str;
        else return DISPLAY_TMP_INFO_ARRAY . "=null";
    }
    
    
    static private function strSpcToPlus($str){
        return str_replace(" ", "+", $str);
    }
    
    private function generateJSNmAmtPairs($ids, $objtType, $bTime, $eTime, $dtType){
        $str = "";
        foreach($ids as $id){
            $pairStr = "";
            $curObjtDt = new ObjectData($objtType, $id, $bTime, $eTime, $this->_db); 
            foreach ($curObjtDt->myDataSets as $curDtSt){
                if($curDtSt->dataType===$dtType){
                    $pairStr .= "{\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET_NAME . "\":\"" . self::strSpcToPlus($curObjtDt->myName) . "\"," .
                                "\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET_AMT . "\":" . $curDtSt->dataStats[DATA_STAT_SUM] . "},";
                    break; // found target data type. 
                }
            }
            $str .= $pairStr;
        }
        if ($str!=="") return "Array(" . substr($str, 0, strlen($str)-1) . ")";
        else return "null";
    }
 

    private function generateJSElctInfoArray($myObjectData){
        // generate "electInfoArray"
        $bTime = $myObjectData->beginTime;
        $eTime = $myObjectData->endTime;
        $str = "";
        $datatype = DATA_TYPE_ELCT;
        foreach($myObjectData->myDataSets as $dataSet){
            if ($dataSet->dataType === $datatype){
                $str .= DISPLAY_ELECT_INFO_ARRAY . "={" . 
                        "\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_SUM . "\":" . $dataSet->dataStats[DATA_STAT_SUM] . "," .
                        "\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_AVG . "\":" . $dataSet->dataStats[DATA_STAT_AVG] . "," .
                        "\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_UNIT . "\":\"" . $dataSet->dataUnit ."\"," .
                        "\"" . DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET . "\":" . $this->generateJSNmAmtPairs($myObjectData->myChildrenIds, 
                                        $myObjectData->myChildrenType, $bTime, $eTime, $datatype) . "}";
                break;  // found target data type.                          
            }
        }
        if ($str!=="") return $str;
        else return DISPLAY_ELECT_INFO_ARRAY . "=null";
    }
                           

    private function generateJSDBasicInfoArray($myObjectData){
        // generate "basicInfoArray"
        $str = DISPLAY_BASIC_INFO_ARRAY . "={" . 
                    "\"" . DISPLAY_BASIC_INFO_ARRAY_KEY_NAME . "\":\"" .$myObjectData->myName . "\"," .
                    "\"" . DISPLAY_BASIC_INFO_ARRAY_KEY_ADDRESS . "\":\"" . $myObjectData->myAddress . "\"," .
                    "\"" . DISPLAY_BASIC_INFO_ARRAY_KEY_BTIME . "\":" . $myObjectData->beginTime . "," .
                    "\"" . DISPLAY_BASIC_INFO_ARRAY_KEY_ETIME . "\":" . $myObjectData->endTime . "}";

        return $str;
    }  
    
    
    public function showData($parentDiv){
        $ids = $this->validateUserSelctions();
        $myObjectData = new ObjectData($ids['type'], $ids['id'], $ids['btm'], $ids['etm'], $this->_db);
        echo "<script>";
        echo $this->generateJSDBasicInfoArray($myObjectData) . "; ";
        echo $this->generateJSElctInfoArray($myObjectData) . "; ";
        echo $this->generateJSTmpInfoArray($myObjectData) . "; ";
        echo $this->generateDataSets(DISPLAY_ELECT_DATA_SETS, DATA_TYPE_ELCT, $myObjectData) . "; ";
        echo $this->generateDataSets(DISPLAY_TMP_DATA_SETS, DATA_TYPE_TMP, $myObjectData) . "; ";
        $jsId = self::$_isDisplayPrefix . self::$_jsDisplayCount;
        self::$_jsDisplayCount = self::$_jsDisplayCount+1;
        echo "var " . $jsId . "=new DataDisplayer(" . 
                DISPLAY_BASIC_INFO_ARRAY . "," .
                DISPLAY_ELECT_INFO_ARRAY . "," .
                DISPLAY_TMP_INFO_ARRAY . "," .
                DISPLAY_ELECT_DATA_SETS . "," .
                DISPLAY_TMP_DATA_SETS . "); ";
        echo $jsId . ".carryOut(\"" . $parentDiv . "\"); ";
        echo "</script>";
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
