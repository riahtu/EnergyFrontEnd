// JavaScript Document

// Search Box Class
function SearchBox(type, status, bldArray, dpmtArray, srvArray,
        bldID, dpmtID, srvID, beginTime, endTime){
            
    // properties
    this.type = type   // type of search box. Values:
                       // "full" - search all info
                       // "time" - search time only 
                       //      and other info have been pre-selected.
    this.status = status   // status of the search. Values:
                           // "init" - no properties set
                           // "bldSelected"
                           // "dpmtSelected"
                           // "srvSelected"
                           // "beginTimeSelected"
                           // "endTimeSelected"
							
    this.bldID = bldID   // set to -1 if not selected
    this.dpmtID = dpmtID // set to -1 if not selected
    this.srvID = srvID   // set to -1 if not selected
    this.beginTime = beginTime	// set to -1 if not selected
    this.endTime = endTime   // set to -1 if not selected
    
    SearchBox.prototype.bldArray = bldArray  // format: (id | name | beginTime | endTime)
    SearchBox.prototype.dpmtArray = dpmtArray  // format: (id | name | beginTime | endTime)
    SearchBox.prototype.srvArray = srvArray  // format: (bldID | dpmtID | srvID | name | beginTime | endTime)

    // methods
    this.draw = draw
    this.generateDropDown = generateDropDown
    this.generateTimepicker = generateTimepicker
    this.generateSubmitButton = generateSubmitButton

    // check initial values
    if (this.type!="full" && this.type!="time"){
        printError("SEARCHBOX_INCORRECT_TYPE")
    } else if ( this.type=="full" && this.status!="init" ){
        printError("SEARCHBOX_INCORRECT_STATUS")
    } else if (this.type=="time" && (this.status!="bldSelected" && 
            this.status!="dpmtSelected" && this.status!="srvSelected") ) {
        printError("SEARCHBOX_INCORRECT_STATUS")     
    } else if (this.type=="time" && this.status=="bldSelected" && 
            (this.bldID==undefined||this.bldID<0)) {
        printError("SEARCHBOX_INCORRECT_ID")
    } else if (this.type=="time" && this.status=="dpmtSelected" && 
            (this.dpmtID==undefined||this.dpmtID<0)) {
        printError("SEARCHBOX_INCORRECT_ID")
    } else if (this.type=="time" && this.status=="srvSelected" && 
            (this.dpmtID==undefined||this.srvID<0)) {
        printError("SEARCHBOX_INCORRECT_ID")
    }
	
}

function draw(searchDiv){
    var root = document.getElementById(searchDiv);
    var curNode;
    if (this.type=="full"){
        for (var j=0; j<4; j++){
            curNode = document.createElement("div");
            curNode.setAttribute("class", "searchBoxRowContainer");  
            root.appendChild(curNode);
        }

        for (j=0; j<4; j++){
            for (var t=0; t<2; t++){
                curNode = document.createElement("div");
                curNode.setAttribute("class", "searchBoxDropdownContainer");
                curNode.setAttribute("id", "sbdc"+j+t);  
                root.children[j].appendChild(curNode);               
            }
        }
        
        this.bldddID = generateDropDown(this.bldArray, 1, 0, "sbdc00", "Buildings");
        this.dpmtNode = generateDropDown(this.dpmtArray, 1, 0, "sbdc01", "Departments");
        this.srvNode = generateDropDown(this.srvArray, 3, 2, "sbdc10", "Services");
        
        this.beginTimeNode = generateTimepicker("sbdc20", "Begin Time", 30);
        this.endTimeNode = generateTimepicker("sbdc21", "End Time", 30);
        
        this.submitNode = generateSubmitButton("sbdc30", "Sumbit Query", this.bldddID);
        
    } else if (this.type=="time"){
       
    } else {
        printError("SEARCHBOX_INCORRECT_TYPE")
    }
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


    curNode = document.createElement("option")
    curNode.setAttribute("selected", true);
    
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
    curNode.setAttribute("class", "searchBoxTimepicker");
    var desc = document.createElement("p");
    desc.appendChild(document.createTextNode(myName));
    parent.appendChild(desc);
    //parent.appendChild(document.createElement("br"));
    parent.appendChild(curNode);
 
    AnyTime.picker( myID, {format: "%Y-%m-%d %H:%i:%s %E %#", formatUtcOffset: "%: (%@)", firstDOW: 1} );
        
    return myID;
}


function generateSubmitButton(parentID, myName, bldddID){
    

    
    var parent = document.getElementById(parentID);
    var curNode = document.createElement("button");
    var myID = "submitbotton" + myName;
    curNode.setAttribute("id", myID);
    curNode.appendChild(document.createTextNode(myName));
    parent.appendChild(curNode);

    
//    alert(bldNode.options[bldNode.selectedIndex].value);

//    var myIDjq = "#" + myID;
//    $(myIDjq).click(function() {
//      alert('Handler for .click() called.');
//    });
    
    curNode.setAttribute("onclick", "return check()");
    
}

function check(bldddID){
    var bldNode = document.getElementById(this.bldddID);
    var value = bldNode.options[bldNode.selectedIndex].value;
    alert(value);
}