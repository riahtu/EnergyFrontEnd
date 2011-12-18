<?php

/* ------------ Types ------------- */

// object types
define("OBJECT_TYPE_BLD", "bld");
define("OBJECT_TYPE_DPM", "dpm");
define("OBJECT_TYPE_SRV", "srv");
define("OBJECT_TYPE_SNS", "sns");

// data types
define("DATA_TYPE_ELCT", "elct");
define("DATA_TYPE_TMP", "tmp");

// data durations in second
define("DATA_DURATION_RAW", 60);
define("DATA_DURATION_ONE_MIN", 60);
define("DATA_DURATION_ONE_HR", 3600);
define("DATA_DURATION_ONE_DAY", 86400);

// data table selection standards
define("DATA_TIME_ZERO", 0); 
define("DATA_TIME_1_DAY", 86400); // 1 day = 24 hr = 1440 min = 86400 sec
define("DATA_TIME_30_0DAY", 2592000); // 30 day = 720 hr = 2592000 sec


/* ------ DB Tables / Attributes ----- */

// object tables
define("OBJECT_TABLE_BLDS", "buildings");
define("OBJECT_TABLE_DPMTS", "departments");
define("OBJECT_TABLE_SRVS", "services");
define("OBJECT_TABLE_SNS", "sensors");

// object table attributes
define("OBJECT_ATTRIBUTE_ID", "id");
define("OBJECT_ATTRIBUTE_NAME", "name");
define("OBJECT_ATTRIBUTE_ADDRESS", "address");

// sensor table unique attributes
define("OBJECT_SENSOR_ATTRIBUTE_DATA_TYPE", "data_type");
define("OBJECT_SENSOR_ATTRIBUTE_DATA_UNIT", "data_unit");


// object relation table and its attributes
define("OBJECT_RELATIONS", "relations");
define("OBJECT_RELATIONS_ATTRIBUTE_PARENT_ID", "parent_id");
define("OBJECT_RELATIONS_ATTRIBUTE_CHILD_ID", "child_id");


// data tables
define("DATA_TABLE_RAW", "raw_data");
define("DATA_TABLE_1MIN", "aggr_data_1min");
define("DATA_TABLE_1HOUR", "aggr_data_1hour");
define("DATA_TABLE_1DAY", "aggr_data_1day");

// data table attributes
define("DATA_ATTRIBUTE_ID", "id");
define("DATA_ATTRIBUTE_TIME", "time");
define("DATA_ATTRIBUTE_VALUE", "value");


/* ---------- Statistics ------------- */

// data statistics AND mysql aggr functions
define("DATA_STAT_SUM", "sum");
define("DATA_STAT_AVG", "avg");
define("DATA_STAT_MAX", "max");
define("DATA_STAT_MIN", "min");

/* --------- Sum and Default Max/Min ------------ */
define("DATA_VALUE_MAX", 0);
define("DATA_VALUE_MIN", 9999999);
?>
