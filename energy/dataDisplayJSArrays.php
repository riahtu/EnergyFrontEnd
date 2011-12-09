<?php

define("DISPLAY_BASIC_INFO_ARRAY", "basicInfoArray");
define("DISPLAY_BASIC_INFO_ARRAY_KEY_NAME", "name");
define("DISPLAY_BASIC_INFO_ARRAY_KEY_ADDRESS", "address");
define("DISPLAY_BASIC_INFO_ARRAY_KEY_BTIME", "begin_time");
define("DISPLAY_BASIC_INFO_ARRAY_KEY_ETIME", "end_time");
//ie.
//basicInfoArray = {
//    "name": "Wisconsin Institutes For Discovery",
//    "address": "1210 W Dayton St",
//    "begin_time": 1323211124,
//    "end_time": 1323211124
//} 

define("DISPLAY_ELECT_INFO_ARRAY", "electInfoArray");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_SUM", "sum");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_AVG", "avg");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_UNIT", "unit");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET", "dataPairSet");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET_NAME", "name");
define("DISPLAY_ELECT_INFO_ARRAY_KEY_DPSET_AMT", "amount");
//ie.
//electInfoArray = {
//    "sum" : 195432,
//    "avg" : 15432,
//    "unit" : "Kilowatt",
//    "dataPairSet" : Array(
//        {
//            "name" : "rack+1",
//            "amount": 60
//        },
//
//        {
//            "name" : "rack+2",
//            "amount": 60
//        },
//        
//        {
//            "name" : "rack+3",
//            "amount" : 100
//        }
//    )
//
//}

define("DISPLAY_TMP_INFO_ARRAY", "tmpInfoArray");
define("DISPLAY_TMP_INFO_ARRAY_KEY_MAX", "max");
define("DISPLAY_TMP_INFO_ARRAY_KEY_MIN", "min");
define("DISPLAY_TMP_INFO_ARRAY_KEY_DSET", "dataSet");
//ie.
//tmpInfoArray = {
//    // max, min, array (v1, v2, v3, ...)
//    "max" : 89,
//    "min" : 60,
//    "dataSet" : Array(78, 60, 85, 65, 89, 77)
//}


// these two keys are the same for edatasets and tdatasets
define("DISPLAY_DATA_SETS_KEY_LABEL", "label"); 
define("DISPLAY_DATA_SETS_KEY_DATA", "data");
define("DISPLAY_DATA_SETS_TIME_MULTIPLIER", "000"); // data fetched from db is string.

define("DISPLAY_ELECT_DATA_SETS", "edatasets");
//ie.
//edatasets = {
//    "Rack 1": {
//        label: "Rack 1",
//        data: [[599616000*1000, 483994], [915148800*1000, 479060]]
//    },        
//    "Rack 2": {
//        label: "Rack 2",
//        data: [[599616000*1000, 218000], [915148800*1000, 203000]]
//    }
//}

define("DISPLAY_TMP_DATA_SETS", "tdatasets");
//ie.
//tdatasets = {
//    "TS 1": {
//        label: "TS 1",
//        data: [[599616000*1000, 483994], [915148800*1000, 47906]]
//    },        
//    "Rack 2": {
//        label: "Rack 2",
//        data: [[599616000*1000, 218000], [915148800*1000, 203000]]
//    }
//}
?>
