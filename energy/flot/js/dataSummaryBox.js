/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function DataSummary(basicInfoArray, electInfoArray, tmpInfoArray){
    
    // properties
    DataSummary.prototype.basicInfo = basicInfoArray // keys: name, address, begin_time, end_time
    DataSummary.prototype.electInfo = electInfoArray // keys: sum, avg, unit, dataPairSet((name1,amount1), (name2,amount2), ...)
    DataSummary.prototype.tmpInfo = tmpInfoArray // max, min, dataSet (v1, v2, v3, ...)
    DataSummary.prototype.ELECTINFOTITLE = "Electricity Usage"
    DataSummary.prototype.TMPINFOTITLE = "Temperature"
    DataSummary.prototype.ELECT_NOTE_SUM = "https://chart.googleapis.com/chart?chst=d_fnote_title&chld=pinned_c|1|004400|l|SUM|" // add "amount|unit"
    DataSummary.prototype.ELECT_NOTE_AVG = "https://chart.googleapis.com/chart?chst=d_fnote_title&chld=pinned_c|1|004400|l|AVG|" // add "amount|unit"
    DataSummary.prototype.TMP_NOTE_MAX = "https://chart.googleapis.com/chart?chst=d_weather&chld=taped_y|sunny|Max.+Temp.|" // add "amount in fahrenheit| amount in celsius"
    DataSummary.prototype.TMP_NOTE_MIN = "https://chart.googleapis.com/chart?chst=d_weather&chld=taped_y|snowflake|Min.+Temp.|" // add "amount in fahrenheit| amount in celsius"
    DataSummary.prototype.TMP_FAHRENHEIT = "°F"
    DataSummary.prototype.TMP_CELSIUS ="°C"
    DataSummary.prototype.ELECT_PIE = "https://chart.googleapis.com/chart?chs=250x100&cht=p3&" // add data & label
    DataSummary.prototype.ELECT_PIE_DATA_NAME = "chd=t:"
    DataSummary.prototype.ELECT_PIE_LABEL_NAME = "chl"
    DataSummary.prototype.TMP_CHART = "http://chart.apis.google.com/chart?chxl=1:|Start|End|3:|Low|High&chxt=x,x,y,y&chs=300x110&cht=lc&chco=76A4FB&chls=2&chma=40,20,20,30&chd=t:"
    DataSummary.prototype.NOT_FOUND = "https://chart.googleapis.com/chart?chst=d_bubble_icon_texts_big&chld=caution|bb|C6EF2C|000000|Oops!|The data is not available."
    DataSummary.prototype.NOT_FOUND_FUN1 = "./images/road_not_found_small.jpg"
    DataSummary.prototype.NOT_FOUND_FUN2 = "./images/face-crying-md_small.png"

    // methods
    DataSummary.prototype.generateSummary =  generateSummary
    DataSummary.prototype.generateBasicInfo = generateBasicInfo
    DataSummary.prototype.generateElectInfo = generateElectInfo
    DataSummary.prototype.generateTmpInfo = generateTmpInfo

}

function generateSummary(div){
    var root = document.getElementById(div);
    if (root.getAttribute("class")!=null){
        root.removeAttribute("class");
    }
    root.setAttribute("class", "dataSummary");
    var curNode;

    for (var j=0; j<3; j++){
        curNode = document.createElement("div");
        if (j<2){
            curNode.setAttribute("class", "dataSummaryCell1");
        } else {
            curNode.setAttribute("class", "dataSummaryCell2");
        }
        curNode.setAttribute("id", "dsc"+j);
        root.appendChild(curNode);
    }
    
    generateBasicInfo("dsc0");
    generateElectInfo("dsc1");
    generateTmpInfo("dsc2");
}

function generateBasicInfo(parentId){
    
    if (DataSummary.prototype.basicInfo==null) {
        generateNotFoundNotice(parentId, 1);
        return;
    }
    
    var parent = document.getElementById(parentId);
    var curNode = document.createElement("div");
    curNode.setAttribute("class", "basicInfoBox");
    parent.appendChild(curNode);
    
    var childNode = document.createElement("p");
    childNode.setAttribute("class", "name");
    childNode.appendChild(document.createTextNode(DataSummary.prototype.basicInfo["name"]));
    curNode.appendChild(childNode);

    childNode = document.createElement("p");
    childNode.setAttribute("class", "address");
    childNode.appendChild(document.createTextNode(DataSummary.prototype.basicInfo["address"]));
    curNode.appendChild(childNode);

    childNode = document.createElement("p");
    childNode.setAttribute("class", "time");
    var tmp = unixtimeToStr( DataSummary.prototype.basicInfo["begin_time"]);
    childNode.appendChild( document.createTextNode("Start:" + tmp) );
    curNode.appendChild(childNode);
    
    childNode = document.createElement("p");
    childNode.setAttribute("class", "time");
    tmp = unixtimeToStr( DataSummary.prototype.basicInfo["end_time"] );
    childNode.appendChild( document.createTextNode("End: " + tmp) );
    curNode.appendChild(childNode);
}


function unixtimeToStr(unixtime){
    var d = new Date( unixtime*1000 );
    var txt = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + " ";
    txt += d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds()
    return txt;
}

function generateElectInfo(parentId){
    var parent = document.getElementById(parentId);
    var curNode = document.createElement("p");
    curNode.setAttribute("class", "ds_title");
    curNode.appendChild(document.createTextNode(DataSummary.prototype.ELECTINFOTITLE));
    parent.appendChild(curNode); 

    if (DataSummary.prototype.electInfo==null) {
        generateNotFoundNotice(parentId, 1);
        return;
    }
    
    curNode = document.createElement("img");
    var url = generateElctNote(DataSummary.prototype.ELECT_NOTE_SUM, 
            DataSummary.prototype.electInfo["sum"], 
            DataSummary.prototype.electInfo["unit"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode); 
    
    curNode = document.createElement("img");
    url = generateElctNote(DataSummary.prototype.ELECT_NOTE_AVG, 
            DataSummary.prototype.electInfo["avg"], 
            DataSummary.prototype.electInfo["unit"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode); 

    curNode = document.createElement("img");
    url = generateElectPie(DataSummary.prototype.electInfo["dataPairSet"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode); 
}



function generateTmpInfo(parentId){
    var parent = document.getElementById(parentId);
    var curNode = document.createElement("p");
    curNode.setAttribute("class", "ds_title");
    curNode.appendChild(document.createTextNode(DataSummary.prototype.TMPINFOTITLE));
    parent.appendChild(curNode); 
    
    if (DataSummary.prototype.tmpInfo==null) {
        generateNotFoundNotice(parentId, 2);
        return;
    }
    
    curNode = document.createElement("img");
    var url = generateTmpNote(DataSummary.prototype.TMP_NOTE_MAX, DataSummary.prototype.tmpInfo["max"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode);
    
    curNode = document.createElement("img");
    url = generateTmpNote(DataSummary.prototype.TMP_NOTE_MIN, DataSummary.prototype.tmpInfo["min"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode); 
    
    curNode = document.createElement("img");
    url = generateTmpChart(DataSummary.prototype.tmpInfo["dataSet"]);
    curNode.setAttribute("src", url);
    parent.appendChild(curNode);     
}

function generateNotFoundNotice(parentId, imgNum){
    var parent = document.getElementById(parentId); 
    var curNode = document.createElement("img");
    curNode.setAttribute("src", DataSummary.prototype.NOT_FOUND);
    parent.appendChild(curNode);
    
    curNode = document.createElement("img");
    if (imgNum==1){
        curNode.setAttribute("src", DataSummary.prototype.NOT_FOUND_FUN1);
    } else {
        curNode.setAttribute("src", DataSummary.prototype.NOT_FOUND_FUN2);        
    }

    parent.appendChild(curNode);
}

function generateTmpNote(prefix, ftmp){
    var ctmp =  Math.round((5.0 / 9.0 * (ftmp - 32)) * 10 ) / 10;  // keep one decimal place
    return prefix + ftmp + DataSummary.prototype.TMP_FAHRENHEIT + "|" +
            ctmp + DataSummary.prototype.TMP_CELSIUS;
}

function generateTmpChart(dataSet){
    if (dataSet==null) return DataSummary.prototype.NOT_FOUND_FUN2;
    var url = DataSummary.prototype.TMP_CHART;
    for(var j=0; j<dataSet.length-1; j++){
        url += dataSet[j] + ",";
    }
    url += dataSet[dataSet.length-1];
    return url;
}

function generateElctNote(prefix, amount, unit){
    return prefix + amount + "|" + unit;
}

function generateElectPie(dataPairs){
    if (dataPairs==null) return DataSummary.prototype.NOT_FOUND_FUN2;
    var url = DataSummary.prototype.ELECT_PIE;
    var data ="";
    var label = "";
    for(var j=0; j<dataPairs.length-1; j++){
        data += dataPairs[j]["amount"] + ",";
        label += dataPairs[j]["name"] + "|";
    }
    data += dataPairs[dataPairs.length-1]["amount"];
    label += dataPairs[dataPairs.length-1]["name"];
    
    return url + DataSummary.prototype.ELECT_PIE_DATA_NAME + data +
            "&" + DataSummary.prototype.ELECT_PIE_LABEL_NAME + "=" + label
}

//// a function to convert all space in a string to a plus (+) sign
//function spcToPlusSign(str){
//    while (str.indexOf(" ")>=0){
//        str.replace(" ", "+");
//    }
//    return str;
//}