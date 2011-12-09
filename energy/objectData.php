<?php

require_once 'dbConn.php';
require_once 'dbTables.php';

Class DataSet{
    public $dataType;
    public $dataDuration;
    public $dataUnit;
    public $dataPairs;
    public $dataStats; // sum, ave, max, min.
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
        else $this->myChildrenIds = $this->_db->getChildrenIds($this->myType, $this->myId);
    }
    
    private function getDataSets(){
        $attributes = Array(DM_ATTRIBUTE_DATA_TYPE, DM_ATTRIBUTE_DATA_DURATION, 
                DM_ATTRIBUTE_DATA_UNIT, DM_ATTRIBUTE_TABLE);
        $dataInfo = $this->_db->getObjectTables($this->myType, $this->myId, $attributes);
        $this->myDataSets = array();
        foreach($dataInfo as $row){
//            echo "data_type: " . $row[DM_ATTRIBUTE_DATA_TYPE] . "<br />";
//            echo "data_duration: " . $row[DM_ATTRIBUTE_DATA_DURATION] . "<br />";
//            echo "data_unit: " . $row[DM_ATTRIBUTE_DATA_UNIT] . "<br />";
//            echo "data_table: " . $row[DM_ATTRIBUTE_TABLE] . "<br />";
            $curDataSet = new DataSet();
            $curDataSet->dataType = $row[DM_ATTRIBUTE_DATA_TYPE];
            $curDataSet->dataDuration = $row[DM_ATTRIBUTE_DATA_DURATION];
            $curDataSet->dataUnit = $row[DM_ATTRIBUTE_DATA_UNIT];
            $curDataSet->dataPairs = $this->_db->getData($row[DM_ATTRIBUTE_TABLE], 
                        $row[DM_ATTRIBUTE_DATA_DURATION], $this->beginTime, $this->endTime);
            $curDataSet->dataStats = $this->_db->getStats($row[DM_ATTRIBUTE_TABLE],  
                        $row[DM_ATTRIBUTE_DATA_DURATION], $this->beginTime, $this->endTime);
//            foreach($curDataSet->dataPairs as $pair){
//                echo "time: " . $pair[DATA_ATTRIBUTE_BEGIN_TIME] . "<br />";
//                echo "amount: " . $pair[DATA_ATTRIBUTE_AMOUNT] . "<br />";
//            }
            $this->myDataSets[] = $curDataSet;
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
        $this->getDataSets();
        $this->getChildrenType();
        $this->getChildrenIds();
    }
    
//    public function __destruct() {
//        $this->_db->__destruct();
//    }
}
?>
