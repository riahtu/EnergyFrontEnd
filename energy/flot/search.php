<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
require_once("/parts/header.php");
require_once("/parts/include.php"); 
?>
</head>

<body>

<div class="container_12">

<div id="header">
	<div class="grid_4" id="hd_padding"></div>
    <div class="grid_8" id="nav_tertiary">
        <a href="http://www.wisc.edu/">UW-Madison</a> 
        <a href="http://www.cs.wisc.edu/">Computer Sciences</a>  
        <a href="http://www.wisc.edu/search/search.php">Search</a>
    </div>
    <div class="clear">&nbsp;</div>
</div> <!--end header-->

<div id="title">
<h1>Energy Consumption Monitoring System</h1> <hr />
<h2>The University of Wisconsin - Madison</h2>
</div> <!-- end title -->

<div id="nav_container">
<?php require_once ("/parts/navigation.php"); ?>
<hr />
</div> <!-- end nav_container -->


<div id="main_content">

</div> <!-- end main_content -->

<div id="goSearch"></div>
<?php 
$manager = new DataManager();
$manager->createSearchBox("goSearch", "sBox");
?>
<br />
<hr />
</div> <!-- end container_12 -->

<?php require_once ("/parts/footer.php"); ?>

</body>
</html>
