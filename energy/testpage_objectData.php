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
            require_once("include.php");
        ?>
    </head>
    <body>
        <?php
            $od = new ObjectData(OBJECT_TYPE_BLD, 0, 1314835200, 1322783999);
            echo "type: " . $od->myType . "<br />";
            echo "id: " . $od->myId . "<br />";
            echo "begin time: " . $od->beginTime . "<br />";
            echo "end time: " . $od->endTime . "<br />";
            echo "name: " . $od->myName . "<br />";
            echo "address: " . $od->myAddress . "<br />";
            echo "children type: " . $od->myChildrenType . "<br />";
        ?>

    </body>
</html>


    