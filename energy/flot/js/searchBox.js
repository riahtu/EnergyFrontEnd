// JavaScript Document

// Search Box Class
function SearchBox(bldArray, dpmtArray, srvArray){
            
    // properties
    SearchBox.prototype.timepickerLength = 30;
    SearchBox.prototype.invalidID = -1; // invalid slected id
    SearchBox.prototype.invalidTime = "";
    SearchBox.prototype.invalidUnixtime = -1;
    SearchBox.prototype.url = "./data.php";
    SearchBox.prototype.bldArrayNames = {
        "name": "name",
        "id": "id",
        "begin": "begin_time",
        "end": "emd_time"
    };
    SearchBox.prototype.dpmtArrayNames = {
        "name": "name",
        "id": "id",
        "begin": "begin_time",
        "end": "emd_time"
    };
    SearchBox.prototype.srvArrayNames = {
        "name": "name",
        "id": "id",
        "begin": "begin_time",
        "end": "emd_time"
    };

    SearchBox.prototype.bldArray = bldArray  // format: (id | name)
    SearchBox.prototype.dpmtArray = dpmtArray  // format: (id | name)
    SearchBox.prototype.srvArray = srvArray  // format: (id | name)
							
    SearchBox.prototype.bldID = null
    SearchBox.prototype.dpmtID = null
    SearchBox.prototype.srvID = null
    SearchBox.prototype.beginTimeID = null
    SearchBox.prototype.endTimeID = null
    SearchBox.prototype.submitID = null
    
    // methods
    SearchBox.prototype.draw = draw
    SearchBox.prototype.generateDropDown = generateDropDown
    SearchBox.prototype.generateTimepicker = generateTimepicker
    SearchBox.prototype.generateSubmitButton = generateSubmitButton
    SearchBox.prototype.validate = validate
    SearchBox.prototype.validateAux = validateAux
    SearchBox.prototype.end = end
}



function draw(searchDiv){
    var root = document.getElementById(searchDiv);
    if (root.getAttribute("class")!=null){
        root.removeAttribute("class");
    }
    root.setAttribute("class", "searchBox");
    var curNode, childNode;

    for (var j=0; j<4; j++){
        curNode = document.createElement("div");
        curNode.setAttribute("class", "searchBoxRowContainer");  
        root.appendChild(curNode);
        for (var t=0; t<2; t++){
            childNode = document.createElement("div");
            childNode.setAttribute("class", "searchBoxWidgetContainer");
            childNode.setAttribute("id", "sbdc"+j+t);  
            curNode.appendChild(childNode);               
        }
    }

    SearchBox.prototype.bldID = generateDropDown(SearchBox.prototype.bldArray, 
            SearchBox.prototype.bldArrayNames["name"], 
            SearchBox.prototype.bldArrayNames["id"], 
            "sbdc00", "Buildings");
    SearchBox.prototype.dpmtID = generateDropDown(this.dpmtArray, 
            SearchBox.prototype.dpmtArrayNames["name"], 
            SearchBox.prototype.dpmtArrayNames["id"], 
            "sbdc01", "Departments");
    SearchBox.prototype.srvID = generateDropDown(this.srvArray, 
            SearchBox.prototype.srvArrayNames["name"], 
            SearchBox.prototype.srvArrayNames["id"], 
            "sbdc10", "Services");
    SearchBox.prototype.beginTimeID = generateTimepicker("sbdc20", "Begin Time", 
            SearchBox.prototype.timepickerLength);
    SearchBox.prototype.endTimeID = generateTimepicker("sbdc21", "End Time", 
            SearchBox.prototype.timepickerLength);
    SearchBox.prototype.submitID = generateSubmitButton("sbdc30", "Sumbit Query");

//    SearchBox.prototype.submitNode = generateSubmitButton("sbdc30", "Sumbit Query", SearchBox.prototype.bldddID);
        

}


function generateDropDown(matrix, NameIndex, IdIndex, parentID, myName) {
    var parent = document.getElementById(parentID);
    var curNode = document.createElement("select");
    var myID = "dropdown" + myName;
    curNode.setAttribute("id", myID);
    var desc = document.createElement("p");
    desc.appendChild(document.createTextNode(myName));
    parent.appendChild(desc);
    //parent.appendChild(document.createElement("br"));
    parent.appendChild(curNode);
    parent = curNode;

    /* set the first row as an invalid choice */
    curNode = document.createElement("option")
    curNode.setAttribute("selected", true);  
    curNode.setAttribute("value", SearchBox.prototype.invalidID);
    curNode.appendChild(document.createTextNode("-- Please Choose A " + myName.substring(0, myName.length-1) + " --"));
    parent.appendChild(curNode);
    
    for (var j=0; j<matrix.length; j++) {
        curNode = document.createElement("option")
        curNode.setAttribute("value", matrix[j][IdIndex]);
        parent.appendChild(curNode);
        curNode.appendChild(document.createTextNode(matrix[j][NameIndex]))       
    }
    
    createDropDown(myID, myID+"Target", parentID, true);
    
    return myID;
}

function generateTimepicker(parentID, myName, size){
    var parent = document.getElementById(parentID);
    var curNode = document.createElement("input");
    var myID = "timepicker" + myName;
    curNode.setAttribute("id", myID);
    curNode.setAttribute("type", "text");
    curNode.setAttribute("size", size);
//    curNode.setAttribute("value", null);
    curNode.setAttribute("class", "searchBoxTimepicker");
    var desc = document.createElement("p");
    desc.appendChild(document.createTextNode(myName));
    parent.appendChild(desc);
    //parent.appendChild(document.createElement("br"));
    parent.appendChild(curNode);
 
    AnyTime.picker( myID, {format: "%Y/%m/%d %H:%i:%s %#", 
                            formatUtcOffset: "%: (%@)", 
                            baseYear: 2000,
                            earliest: new Date(2010,0,1,0,0,0),
                            latest: new Date(2019,11,31,23,59,59)} );

    return myID;
}


function generateSubmitButton(parentID, myName){
    
    var parent = document.getElementById(parentID);
    var curNode = document.createElement("button");
    var myID = "submitbotton" + myName;
    curNode.setAttribute("id", myID);
    curNode.appendChild(document.createTextNode(myName));
    parent.appendChild(curNode);
      
    return myID;
}

function validate(){
    var curNode = document.getElementById(SearchBox.prototype.submitID);
    curNode.setAttribute("onclick", "return validateAux()");

}

function validateAux(){
    var bldNode = document.getElementById(SearchBox.prototype.bldID);
    var dpmtNode = document.getElementById(SearchBox.prototype.dpmtID);
    var srvNode = document.getElementById(SearchBox.prototype.srvID);

    var bld = bldNode.options[bldNode.selectedIndex].value;
    var dpmt = dpmtNode.options[dpmtNode.selectedIndex].value;
    var srv = srvNode.options[srvNode.selectedIndex].value;
    var btm = document.getElementById(SearchBox.prototype.beginTimeID).value;
    var etm = document.getElementById(SearchBox.prototype.endTimeID).value;
    
    var txt = "Selected Bld: " + bld + "; ";
    txt +=  "Selected Dpmt: " + dpmt + "; ";
    txt +=  "Selected Srv: " + srv + "; ";
    txt +=  "Selected Begin Time: " + btm + "; ";
    txt +=  "Selected BEnd Time: " + etm + ". ";
    
//    if (btm==null || btm==SearchBox.prototype.invalidTime){
//          alert(txt);
//    }

    if ( (bld==null || bld==SearchBox.prototype.invalidID)
            && (dpmt==null || dpmt==SearchBox.prototype.invalidID)
            && (srv==null || srv==SearchBox.prototype.invalidID) ){
        alert("Oops!  \nPlease choose a Building, Department or Service.");
        return;
    }
    
    if ( (btm==null || btm==SearchBox.prototype.invalidTime) ){
        alert("Oops!  \nPlease choose a Begin Time and End Time.");
        return;           
    }

    var url = SearchBox.prototype.url;
    url += "?bld=" + bld + "&";
    url += "dpmt=" + dpmt + "&";
    url += "srv=" + srv + "&";
    url += "btm=" + strToUnixTime(btm) + "&";
    url += "etm=" + strToUnixTime(etm);
    
    window.location = url;
}


function end(){
    
}

// string format: "%Y/%m/%d %H:%i:%s %(timezone offset in minutes)"
// ie. 2011/12/21 22:01:10 -360
function strToUnixTime(str){
    if (str==null || str==SearchBox.prototype.invalidTime) return SearchBox.prototype.invalidUnixtime;
    
    var year = parseInt( str.substring(0, 4) );
    var month = parseInt( str.substring(5, 7) );
    var date = parseInt( str.substring(8, 10) );
    var hours = parseInt( str.substring(11, 12) )*10 + parseInt( str.substring(12, 13) );
    var minutes = parseInt( str.substring(14, 15) )*10 + parseInt( str.substring(15, 16) )
    var seconds = parseInt( str.substring(17, 18) )*10 + parseInt( str.substring(18, 19) );
    var offset = (parseInt( str.substring(20) )); // (UTC-current), timezone offset in minutes 
    
    var d = new Date();

    d.setFullYear(year, month-1, date);
    d.setHours(hours, minutes, seconds, 0);
    offset = (-d.getTimezoneOffset() - offset)*60; 
    var unixtime = d.getTime()/1000 + offset;

    return unixtime;
//    return d.getUTCFullYear() + "/" + (d.getUTCMonth()+1) + "/" + d.getUTCDate() + " " 
//        + d.getUTCHours() + ":" + d.getUTCMinutes() + ":" + d.getUTCSeconds() + " " + offset;

}