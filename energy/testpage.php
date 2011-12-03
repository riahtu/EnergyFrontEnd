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
            include("styles.php");
            include("scripts.php");
            include("inputs.php");
        ?>
    </head>
    <body>
        <div id="searchBox" class="searchBox_full">
<!-- test searchBox.js begin-->
<!--        
        <script> 
            box = new SearchBox(bldArray1, dpmtArray1, srvArray1); 
            box.draw("searchBox");
            box.validate();
            box.end();
           
        </script>-->
<!--test searchBox.js end -->

    <?php 
    require_once 'dataManager.php';
    $manager = new DataManager();
    $manager->createSearchBox("searchBox", "sBox");
    ?>
    </body>
</html>
