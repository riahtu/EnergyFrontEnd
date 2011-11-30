<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
        include("styles.php");
        include("scripts.php");
        include("inputs.php");
?>

</head>

<body>

    
<div id="searchBox" class="searchBox_full">


    
</div>

<!--    English: <input type="text" id="field1" size="20"
            value="Sunday, July 30th in the Year 1967 CE" /><br/>
    
    <input type="button" id="rangeDemoToday" value="today" />
-->    <button id="confirmInfo">confirm</button>

<script> 
try {

        box = new SearchBox("full", "init", bldArray, dpmtArray, srvArray, -1, -1, -1, -1, -1); 
        box.draw("searchBox")
	
//AnyTime.picker( "field1", { format: "%Y-%m-%d %H:%i:%s %E %#", formatUtcOffset: "%: (%@)", firstDOW: 1 } );
//
//  $("#rangeDemoToday").click( function(e) {
//      $("#field1").val(rangeDemoConv.format(new Date())).change(); } );
//
//        var inputValue = document.getElementById("field1");
//        document.writeln(inputValue.getAttribute("value"))
//        
//        
//        var confirmDiv = document.getElementById("confirmInfo")
//        
//        confirmDiv.setAttribute("onclick", "var txt = document.getElementById('field1').value; window.location = 'http://www.yourdomain.com?' + txt")

    $("#confirmInfo").click(function() {
      alert('Handler for .click() called.');
    });
} catch (e) {
	alert('An error has occurred: '+e.message)
}
</script>
</body>
</html>