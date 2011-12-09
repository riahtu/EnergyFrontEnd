<?php
// object tables
define("OBJECT_TABLE_BLDS", "buildings");
define("OBJECT_TABLE_DPMTS", "departments");
define("OBJECT_TABLE_SRVS", "services");
define("OBJECT_TABLE_SNS", "sensors");

// object table attributes
define("OBJECT_ATTRIBUTE_ID", "id");
define("OBJECT_ATTRIBUTE_NAME", "name");
define("OBJECT_ATTRIBUTE_ADDRESS", "address");
define("OBJECT_ATTRIBUTE_BEGIN_TIME", "begin_time");
define("OBJECT_ATTRIBUTE_END_TIME", "end_time");

// object types
define("OBJECT_TYPE_BLD", "bld");
define("OBJECT_TYPE_DPM", "dpm");
define("OBJECT_TYPE_SRV", "srv");
define("OBJECT_TYPE_SNS", "sns");


// data master table/attributes
define("DATA_MASTER_TABLE", "data_master");

define("DM_ATTRIBUTE_OBJECT_TYPE", "object_type");
define("DM_ATTRIBUTE_OBJECT_ID", "object_id");
define("DM_ATTRIBUTE_DATA_TYPE", "data_type");
define("DM_ATTRIBUTE_DATA_DURATION", "data_duration");
define("DM_ATTRIBUTE_DATA_UNIT", "data_unit");
define("DM_ATTRIBUTE_TABLE", "table_name");


// data table attributes
define("DATA_ATTRIBUTE_BEGIN_TIME", "begin_time");
define("DATA_ATTRIBUTE_AMOUNT", "amount");


// relation table/attributes
define("OBJECT_RELATIONS", "relations");
define("OBJECT_RELATIONS_ATTRIBUTE_PARENT_TYPE", "parent_type");
define("OBJECT_RELATIONS_ATTRIBUTE_PARENT_ID", "parent_id");
define("OBJECT_RELATIONS_ATTRIBUTE_CHILD_TYPE", "child_type");
define("OBJECT_RELATIONS_ATTRIBUTE_CHILD_ID", "child_id");


// data statistics
define("DATA_STAT_SUM", "sum");
define("DATA_STAT_AVG", "avg");
define("DATA_STAT_MAX", "max");
define("DATA_STAT_MIN", "min");

?>
