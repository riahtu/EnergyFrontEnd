<?php

require_once ("parts/include.php");

Class SensorInfo {
    public $dataType;
    public $dataUnit;
    public $sensorIds;
}

Class DataSet{
    public $dataType;
    public $dataDuration;
    public $dataUnit;
    public $dataPairs;
    public $dataStats; // array, keys: sum, avg, max, min.
}

Class ObjectData{
    // properties
    private $_db;
    
    public $beginTime;
    public $endTime;
    public $myType;
    public $myId;
    public $myName;
    public $myAddress;
    public $myDataSets; // format:( DataSet1, DataSet2, DataSet3, ... )
    public $myChildrenType;
    public $myChildrenIds; // format: (cid1, cid2, cid3, ...)
    
        
    // methods
    private function getChildrenIds(){
        if ($this->myChildrenType===null) $this->myChildrenIds = null;
        else $this->myChildrenIds = $this->_db->getChildrenIds($this->myId);
    }

// function used before changing the db.    
//    private function getDataSets(){
//        $attributes = Array(OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE, DM_ATTRIBUTE_DATA_DURATION, 
//                OBJECT_SENSOR_ATTRIBUTE_DATA_UNIT, DM_ATTRIBUTE_TABLE);
//        $dataInfo = $this->_db->getObjectTables($this->myType, $this->myId, $attributes);
//        $this->myDataSets = array();
//        foreach($dataInfo as $row){
////            echo "data_type: " . $row[DM_ATTRIBUTE_DATA_TYPE] . "<br />";
////            echo "data_duration: " . $row[DM_ATTRIBUTE_DATA_DURATION] . "<br />";
////            echo "data_unit: " . $row[DM_ATTRIBUTE_DATA_UNIT] . "<br />";
////            echo "data_table: " . $row[DM_ATTRIBUTE_TABLE] . "<br />";
//            $curDataSet = new DataSet();
//            $curDataSet->dataType = $row[OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE];
//            $curDataSet->dataDuration = $row[DM_ATTRIBUTE_DATA_DURATION];
//            $curDataSet->dataUnit = $row[OBJECT_SENSOR_ATTRIBUTE_DATA_UNIT];
//            $curDataSet->dataPairs = $this->_db->getData($row[DM_ATTRIBUTE_TABLE], 
//                        $row[DM_ATTRIBUTE_DATA_DURATION], $this->beginTime, $this->endTime);
//            $curDataSet->dataStats = $this->_db->getStats($row[DM_ATTRIBUTE_TABLE],  
//                        $row[DM_ATTRIBUTE_DATA_DURATION], $this->beginTime, $this->endTime);
////            foreach($curDataSet->dataPairs as $pair){
////                echo "time: " . $pair[DATA_ATTRIBUTE_BEGIN_TIME] . "<br />";
////                echo "amount: " . $pair[DATA_ATTRIBUTE_AMOUNT] . "<br />";
////            }
//            $this->myDataSets[] = $curDataSet;
//        }
//        
//    }

    private function getSensorInfos(){
        // return sensor info of the current object grouped by dataType
        $snsRecords = $this->_db->getSensorTypes($this->myId, $this->myType);
        $curElctSensorInfo = new SensorInfo();
        $curElctSensorInfo->sensorIds = array();
        $curTmpSensorInfo = new SensorInfo();
        $curTmpSensorInfo->sensorIds = array();
        foreach ($snsRecords as $record){
            if ($record[OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE]===DATA_TYPE_ELCT){
                $curElctSensorInfo->dataType = DATA_TYPE_ELCT;
                $curElctSensorInfo->dataUnit = $record[OBJECT_SENSOR_ATTRIBUTE_DATA_UNIT];
                $curElctSensorInfo->sensorIds[] = $record[OBJECT_ATTRIBUTE_ID];
            } else if ($record[OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE]===DATA_TYPE_TMP){
                $curTmpSensorInfo->dataType = DATA_TYPE_TMP;
                $curTmpSensorInfo->dataUnit = $record[OBJECT_SENSOR_ATTRIBUTE_DATA_UNIT];
                $curTmpSensorInfo->sensorIds[] = $record[OBJECT_ATTRIBUTE_ID];
            } else {
                die("ObjectData::getSensorInfos() - undefined data type: $record[OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE]");
            }
        }
        $mySensorInfos = array();
        if ( count($curElctSensorInfo->sensorIds)>0 ){
            $mySensorInfos[] = $curElctSensorInfo;
        }
        if ( count($curTmpSensorInfo->sensorIds)>0 ){
            $mySensorInfos[] = $curTmpSensorInfo;
        }
        
        if (count($mySensorInfos)===0) return null;
        else return $mySensorInfos;
    }
    
    private function getDataStats($dataPairs){
        if ( count($dataPairs)<= 0 ) die ("ObjectData::getDataStats - invalid dataPair num: " . count($dataPairs) );
        $sum = 0;
        $count = 0;
        $max = DATA_VALUE_MAX;
        $min = DATA_VALUE_MIN;
        for($i=0; $i<count($dataPairs); $i++){
            $sum = $sum + $dataPairs[$i][DATA_ATTRIBUTE_VALUE];
            $count = $count + 1;
            if ($dataPairs[$i][DATA_ATTRIBUTE_VALUE]>$max) $max = $dataPairs[$i][DATA_ATTRIBUTE_VALUE];
            if ($dataPairs[$i][DATA_ATTRIBUTE_VALUE]<$min) $min = $dataPairs[$i][DATA_ATTRIBUTE_VALUE];
        }
        
        return array(
            DATA_STAT_SUM => $sum,
            DATA_STAT_AVG => $sum/$count,
            DATA_STAT_MAX => $max,
            DATA_STAT_MIN => $min
        );
    }

    private function getDataDuration(){
        $timeDif = $this->endTime - $this->beginTime;
        if ($timeDif>DATA_TIME_30_0DAY) return DATA_DURATION_ONE_DAY;
        else if ($timeDif>DATA_TIME_1_DAY) return DATA_DURATION_ONE_HR;
        else if ($timeDif>DATA_TIME_ZERO) return DATA_DURATION_ONE_MIN;
        else die("DBConn::getData() - begin time is lnot earlier than end time");
    }
    
    private function getDataSets() {
        $this->myDataSets = array();
        $mySensorInfos = $this->getSensorInfos();
        foreach($mySensorInfos as $curSensorInfo){
            $curDataSet = new DataSet();
            if ($curSensorInfo->dataType===DATA_TYPE_ELCT) $aggrFn = DATA_STAT_SUM;
            else if ($curSensorInfo->dataType===DATA_TYPE_TMP) $aggrFn = DATA_STAT_AVG;
            else die("ObjectData::getDataSets() - invalid data type: $curSensorInfo");
            $curDataSet->dataPairs = $this->_db->getData($curSensorInfo->sensorIds, $aggrFn, $this->beginTime, $this->endTime);
            if ( count($curDataSet->dataPairs)>0 ){
                $curDataSet->dataType = $curSensorInfo->dataType;
                $curDataSet->dataUnit = $curSensorInfo->dataUnit; 
                $curDataSet->dataStats = $this->getDataStats($curDataSet->dataPairs);
                $curDataSet->dataDuration = $this->getDataDuration();
                $this->myDataSets[] = $curDataSet;
            }  
        }
    }
    
    private function getObjectInfo() {
        $attributes = Array(OBJECT_ATTRIBUTE_NAME, OBJECT_ATTRIBUTE_ADDRESS);
        if ($this->myId===null) die("ObjectData::myId = null");
        $attributes = $this->_db->getObjectInfo($this->myType, $attributes, $this->myId);
        $this->myName = $attributes[OBJECT_ATTRIBUTE_NAME];
        $this->myAddress = $attributes[OBJECT_ATTRIBUTE_ADDRESS];
    }
  
    private function getChildrenType(){
        switch($this->myType){
            case OBJECT_TYPE_BLD: $this->myChildrenType=OBJECT_TYPE_SRV; break;
            case OBJECT_TYPE_DPM: $this->myChildrenType=OBJECT_TYPE_SRV; break;
            case OBJECT_TYPE_SRV: $this->myChildrenType=OBJECT_TYPE_SNS; break;
            case OBJECT_TYPE_SNS: $this->myChildrenType=null; break;
            default: die("Invalid object type.");
        }        
    }

    
    public function __construct($type, $id, $btime, $etime, $dblink) {
        $this->_db = $dblink;
        
        $this->myType = $type;
        $this->myId = $id;
        $this->beginTime = $btime;
        $this->endTime = $etime;
        $this->getObjectInfo();
        $this->getChildrenType();
        $this->getChildrenIds();
        $this->getDataSets();
    }
    
//    public function __destruct() {
//        $this->_db->__destruct();
//    }
}
?>
