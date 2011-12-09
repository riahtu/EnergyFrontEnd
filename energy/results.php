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
//            echo "this is the result page. =]\n";
//        
            require_once 'dataManager.php';
            $manager = new DataManager();
            $manager->showData();
        ?>
<!--        <div id="summary1"></div>
        <div id="graph1"></div>-->

        <div id="dp1"></div>

        <script> 

//            ds = new DataSummary(basicInfoArray, electInfoArray, tmpInfoArray);
//              ds.generateSummary("summary1");
        
//            da = new DataDisplayer(basicInfoArray, electInfoArray, tmpInfoArray, edatasets, tdatasets);
//            da.carryOut("dp1");


        </script>
    </body>
</html>
