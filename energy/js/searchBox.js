// JavaScript Document

// Search Box Class
function SearchBox(bldArray, dpmtArray, srvArray){
            
    // properties
    SearchBox.prototype.timepickerLength = 30;
    SearchBox.prototype.invalidID = -1; // invalid slected id
    SearchBox.prototype.invalidTime = "";
                                        //
    SearchBox.prototype.bldArray = bldArray  // format: (id | name | beginTime | endTime)
    SearchBox.prototype.dpmtArray = dpmtArray  // format: (id | name | beginTime | endTime)
    SearchBox.prototype.srvArray = srvArray  // format: (bldID | dpmtID | srvID | name | beginTime | endTime)
							
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

    SearchBox.prototype.bldID = generateDropDown(SearchBox.prototype.bldArray, 1, 0, "sbdc00", "Buildings");
    SearchBox.prototype.dpmtID = generateDropDown(this.dpmtArray, 1, 0, "sbdc01", "Departments");
    SearchBox.prototype.srvID = generateDropDown(this.srvArray, 3, 2, "sbdc10", "Services");
    SearchBox.prototype.beginTimeID = generateTimepicker("sbdc20", "Begin Time", SearchBox.prototype.timepickerLength);
    SearchBox.prototype.endTimeID = generateTimepicker("sbdc21", "End Time", SearchBox.prototype.timepickerLength);
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
 
    AnyTime.picker( myID, {format: "%Y-%m-%d %H:%i:%s %E %#", formatUtcOffset: "%: (%@)", firstDOW: 1} );
        
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
    
    if (btm==null || btm==SearchBox.prototype.invalidTime){
          alert(txt);
    }

}


function end(){
    
}