<?php

require_once ("/parts/include.php");

class DBConn{

    // properties
    private $link;
       
    // methods
    private function processQuery($query){
        $result = mysql_query($query);
        if (!$result) die ("Database access failed: " . mysql_error());
        
        $retval = array();
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $retval[] = $line;
        }
        
        return $retval;        
    }
    

    public function getChildrenIds($parentType, $parentId){
        if ($parentType===null||$parentId===null){
            die("DBConn::getChildrenIds() - invalid parement");
        }
        $query = "SELECT " . OBJECT_RELATIONS_ATTRIBUTE_CHILD_ID . 
                " FROM " . OBJECT_RELATIONS . " WHERE " . 
                OBJECT_RELATIONS_ATTRIBUTE_PARENT_TYPE . "=\"" . $parentType ."\" AND " .
                OBJECT_RELATIONS_ATTRIBUTE_PARENT_ID . "=" . $parentId;
                
        $results = $this->processQuery($query);
        $retval = array();
        foreach($results as $row){
            $retval[] = $row[OBJECT_RELATIONS_ATTRIBUTE_CHILD_ID];
        }
        return $retval;
    }

    public function getStats($table, $duration, $beginTime, $endTime){
        if ($table===null||$duration===null||$beginTime===null||$endTime===null){
            die("DBConn::getStats() - invalid parameter");
        }
        $query = "SELECT SUM(" . DATA_ATTRIBUTE_AMOUNT . ") AS " . DATA_STAT_SUM .
                    ", AVG(" . DATA_ATTRIBUTE_AMOUNT . ") AS " . DATA_STAT_AVG .
                    ", MAX(" . DATA_ATTRIBUTE_AMOUNT . ") AS " . DATA_STAT_MAX .
                    ", MIN(" . DATA_ATTRIBUTE_AMOUNT . ") AS " . DATA_STAT_MIN .
                    " FROM " . DATA_TABLE . " WHERE " . DATA_ATTRIBUTE_TABLE . "=\"$table\" AND " .
                    DATA_ATTRIBUTE_BEGIN_TIME . ">=" . $beginTime . " AND " .
                    DATA_ATTRIBUTE_BEGIN_TIME . "+$duration" . "<=" . $endTime;

        $retval = $this->processQuery($query);
//        echo "sum: " . $result[0][DATA_STAT_SUM] . "<br />";
//        echo "avg: " . $result[0][DATA_STAT_AVG] . "<br />";
//        echo "max: " . $result[0][DATA_STAT_MAX] . "<br />";
//        echo "min: " . $result[0][DATA_STAT_MIN] . "<br />";
        
        if (count($retval)===1){
            return $retval[0];
        } else {
            die ("DBConn::getStats - Getting incorrect number of rows in result: " . count($retval));
        }        
    }
     
    public function getData($table, $duration, $beginTime, $endTime){
        if ($table===null||$duration===null||$beginTime===null||$endTime===null){
            die("DBConn::getData() - invalid parameter");
        }
        $query = "SELECT " . DATA_ATTRIBUTE_BEGIN_TIME . ", " . DATA_ATTRIBUTE_AMOUNT .
                    " FROM " . DATA_TABLE . " WHERE " . DATA_ATTRIBUTE_TABLE . "=\"$table\" AND " .
                    DATA_ATTRIBUTE_BEGIN_TIME . ">=" . $beginTime . " AND " .
                    DATA_ATTRIBUTE_BEGIN_TIME . "+$duration" . "<=" . $endTime;

        return $this->processQuery($query);
    }
    
    
    public function getObjectTables($type, $id, $attributes){
        
        if ($type===null||$id===null||$attributes===null){
            die("DBConn::getObjectTables() - invalid parameter");
        }
    
        $attributestring = " ";
        for($j=0; $j<count($attributes)-1; $j++){
            $attributestring .= $attributes[$j] . ", ";
        }
        $attributestring .= $attributes[count($attributes)-1] . " ";
        
        $query = "SELECT $attributestring FROM " . DATA_MASTER_TABLE;
        $query .= " WHERE " . DM_ATTRIBUTE_OBJECT_TYPE . "= \"" . $type . "\" AND " . 
                    DM_ATTRIBUTE_OBJECT_ID . "=" . $id;
        
        return $this->processQuery($query);
    }
    
    // if $id is null, returns all rows.
    public function getObjectInfo($type, $attributes, $id){
        if ($type===null||$attributes===null){
            die("DBConn::getObjectInfo() - invalid parameter.");
        }
        
        $table = '';
        switch($type){
            case OBJECT_TYPE_BLD: $table=OBJECT_TABLE_BLDS; break;
            case OBJECT_TYPE_DPM: $table=OBJECT_TABLE_DPMTS; break;
            case OBJECT_TYPE_SRV: $table=OBJECT_TABLE_SRVS; break;
            case OBJECT_TYPE_SNS: $table=OBJECT_TABLE_SNS; break;
            default: die("DBConn::getObjectInfo() - invalid object type: : $type");
        }
        
        $attributestring = " ";
        for($j=0; $j<count($attributes)-1; $j++){
            $attributestring .= $attributes[$j] . ", ";
        }
        $attributestring .= $attributes[count($attributes)-1] . " ";
        
        
        $query = "SELECT $attributestring FROM " . $table;
        if ($id!==null) $query .= " WHERE " . OBJECT_ATTRIBUTE_ID . "=" . $id;
        
        $retval = $this->processQuery($query);
        
        if ($id===null) return $retval;
        else if (count($retval)===1){
            return $retval[0];
        } else if (count($retval)===0){
            die ("No record has this id: $id");
        } else {
            die ("Getting incorrect number of rows while fetching data from Object table: " . count($retval));
        }
        
    }

    public function __construct() {
        $this->link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        if (!$this->link) die ("Unable to connect to MySQL:" . mysql_error());
        
        mysql_select_db(DB_DATABASE)
            or die("Unable to select database: " . mysql_error());
            
    }
    
    public function __destruct() {
        mysql_close($this->link);
    }
    
}


?>
