<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php
            require_once("parts/include.php"); 
        ?>
    </head>
    <body>
        <?php
            $od = new ObjectData(OBJECT_TYPE_SRV, 20000, 1314835200, 1322783999, new DBConn());
            echo "<br />";
            echo "type: " . $od->myType . "<br />";
            echo "id: " . $od->myId . "<br />";
            echo "begin time: " . $od->beginTime . "<br />";
            echo "end time: " . $od->endTime . "<br />";
            echo "name: " . $od->myName . "<br />";
            echo "address: " . $od->myAddress . "<br />";
            echo "children type: " . $od->myChildrenType . "<br />";
            echo "children ids: ";
            foreach ($od->myChildrenIds as $id){
                echo "$id, ";
            }
            echo "<br />";
            echo "data sets: " . "<br />";
            foreach ($od->myDataSets as $dataSet){
                echo ">> data type: " . $dataSet->dataType . "<br />";
                echo ">> data unit: " . $dataSet->dataUnit . "<br />";
                echo ">> data pairs: " . "<br />";
                foreach ($dataSet->dataPairs as $dataPair){
                    echo ">>>> (" . $dataPair["time"] . ", " . $dataPair["value"] . ")" . "<br />"; 
                }
                echo ">> data stats:" . "<br />";
                echo ">>>> sum: " . $dataSet->dataStats["sum"] . "<br />";
                echo ">>>> avg: " . $dataSet->dataStats["avg"] . "<br />";
                echo ">>>> max: " . $dataSet->dataStats["max"] . "<br />";
                echo ">>>> min: " . $dataSet->dataStats["min"] . "<br />";
            }
        ?>

    </body>
</html>

