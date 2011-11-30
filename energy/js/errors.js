
function printError(err){
    
    var txt = "<error>: "
    switch(err) {
        /* search box errors */
        case "SEARCHBOX_INCORRECT_TYPE": txt+="searchbox - incorrect type"; break;
        case "SEARCHBOX_INCORRECT_STATUS": txt+="searchbox - incorrect status or matched type/status"; break;
        case "SEARCHBOX_INCORRECT_ID": txt+="searchbox - incorrect ID"; break;
       
        default: txt+="undefined"
    }
   
   alert(txt);
}