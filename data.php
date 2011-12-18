<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
require_once("./parts/header.php");
require_once("./parts/include.php"); 
?>
</head>

<body>

<div class="container_12">

<?php 
require_once ("./parts/global_navigation.php"); 
require_once ("./parts/title.php"); 
?>



<div id="nav_container">
<?php require_once ("./parts/navigation.php"); ?>
<hr />
</div> <!-- end nav_container -->


<div id="main_content">

</div> <!-- end main_content -->
<div id="showData"></div>
<?php
	$manager = new DataManager();
	$manager->showData("showData");
?>
<br />
<hr />
</div> <!-- end container_12 -->

<?php require_once ("./parts/footer.php"); ?>

</body>
</html>
