<script>
    
// format: (id | name | beginTime | endTime)
bldArray = Array(
    Array(0, "CS Building", 10, 10),
    Array(1, "Union South", 10, 10),
    Array(2, "Discovery", 10, 0)
)

// format: (id | name | beginTime | endTime)
dpmtArray = Array(
    Array(0, "CS Department", 10, 10),
    Array(1, "Wendt Library", 10, 10),
    Array(2, "DoIT", 10, 10)
)

// format: (bldID | dpmtID | srvID | name | beginTime | endTime)
srvArray = Array(
    Array(0, 0, 0, "lab1", 10, 10),
    Array(0, 0, 1, "lab2", 10, 10),
    Array(0, 2, 2, "data center", 10, 10)
)
    
bldArray1 = Array(
    {"bld_id": 0,
     "bld_name": "CS Building",
     "begin_time": 10,
     "end_time": 10},

    {"bld_id": 1,
     "bld_name": "Union South",
     "begin_time": 10,
     "end_time": 10},

    {"bld_id": 2,
     "bld_name": "Discovery",
     "begin_time": 10,
     "end_time": 10}
)

dpmtArray1 = Array(
    {"dpmt_id": 0,
     "dpmt_name": "CS Department",
     "begin_time": 10,
     "end_time": 10},

    {"dpmt_id": 1,
     "dpmt_name": "Wendt Library",
     "begin_time": 10,
     "end_time": 10},
 
     {"dpmt_id": 2,
     "dpmt_name": "DoIT",
     "begin_time": 10,
     "end_time": 10}
)

srvArray1 = Array(
    {"srv_id": 0,
     "srv_name": "lab1",
     "begin_time": 10,
     "end_time": 10},
 
     {"srv_id": 1,
     "srv_name": "lab2",
     "begin_time": 10,
     "end_time": 10},
     
     
    {"srv_id": 0,
     "srv_name": "data center",
     "begin_time": 10,
     "end_time": 10}
)
    
basicInfoArray = {
    "name": "Wisconsin Institutes For Discovery",
    "address": "1210 W Dayton St",
    "begin_time": 1323211124,
    "end_time": 1323211124
} 



electInfoArray = {
    "sum" : 195432,
    "avg" : 15432,
    "unit" : "Kilowatt",
    "dataPairSet" : Array(
        {
            "name" : "rack+1",
            "amount": 60
        },

        {
            "name" : "rack+2",
            "amount": 60
        },
        
        {
            "name" : "rack+3",
            "amount" : 100
        }
    )

}

tmpInfoArray = {
    // max, min, array (v1, v2, v3, ...)
    "max" : 89,
    "min" : 60,
    "dataSet" : Array(78, 60, 85, 65, 89, 77)
}


edatasets = {
    "Rack 1": {
        label: "Rack 1",
        data: [[599616000*1000, 483994], [915148800*1000, 479060]]
    },        
    "Rack 2": {
        label: "Rack 2",
        data: [[599616000*1000, 218000], [915148800*1000, 203000]]
    }
}


tdatasets = {
    "TS 1": {
        label: "TS 1",
        data: [[599616000*1000, 483994], [915148800*1000, 47906]]
    },        
    "Rack 2": {
        label: "Rack 2",
        data: [[599616000*1000, 218000], [915148800*1000, 203000]]
    }
}

</script>