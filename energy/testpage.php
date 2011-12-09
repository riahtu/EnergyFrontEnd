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
        <div id="searchBox" class="searchBox"></div>
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

    $manager = new DataManager();
    $manager->createSearchBox("searchBox", "sBox");
    ?>
    </body>
</html>
