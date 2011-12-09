/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function DataDisplayer(basicInfoArray, electInfoArray, tmpInfoArray, electDataSets, tmpDataSets){
   // properties
    DataDisplayer.prototype.dataSummaryDivPrefix = "dataSummaryDiv";
    DataDisplayer.prototype.graphDivPrefix = "graphDiv";
    DataDisplayer.prototype.dataSummaryDivNum = 0;
    DataDisplayer.prototype.graphDivNum = 0;
    DataDisplayer.prototype.basicInfo = basicInfoArray // keys: name, address, begin_time, end_time
    DataDisplayer.prototype.electInfo = electInfoArray // keys: sum, avg, unit, dataPairSet((name1,amount1), (name2,amount2), ...)
    DataDisplayer.prototype.tmpInfo = tmpInfoArray // max, min, dataSet (v1, v2, v3, ...)
    DataDisplayer.prototype.elctGraphDataSets = electDataSets
    DataDisplayer.prototype.tmpGraphDataSets = tmpDataSets    
        
    // methods
    DataDisplayer.prototype.carryOut = carryOut
    DataDisplayer.prototype.plotGraph = plotGraph
    DataDisplayer.prototype.plotGraphAux = plotGraphAux
}

function carryOut(parentDiv){
    var root = document.getElementById(parentDiv);    
    if (root.getAttribute("class")!=null){
        root.removeAttribute("class");
    }
    root.setAttribute("class", "dataDisplayContainer");
    
    var curNode = document.createElement("div");
    var myId = DataDisplayer.prototype.dataSummaryDivPrefix + 
                DataDisplayer.prototype.dataSummaryDivNum;
    DataDisplayer.prototype.dataSummaryDivNum ++;
    curNode.setAttribute("id", myId);
    root.appendChild(curNode);
    
    var ds = new DataSummary(DataDisplayer.prototype.basicInfo, 
            DataDisplayer.prototype.electInfo, 
            DataDisplayer.prototype.tmpInfo);
    ds.generateSummary(myId);
    

    if (DataDisplayer.prototype.elctGraphDataSets!=null){
        
        root.appendChild(document.createElement("br"));
        root.appendChild(document.createElement("hr"));
        curNode = document.createElement("h2");
        curNode.appendChild(document.createTextNode("Electricity Data"));
        root.appendChild(curNode);
        
        curNode = document.createElement("div");
        myId = DataDisplayer.prototype.graphDivPrefix + 
                    DataDisplayer.prototype.graphDivNum;
        DataDisplayer.prototype.graphDivNum ++;
        curNode.setAttribute("id", myId);
        root.appendChild(curNode);
        plotGraph(myId, DataDisplayer.prototype.elctGraphDataSets); 
    }


    if (DataDisplayer.prototype.tmpGraphDataSets!=null){
        
        root.appendChild(document.createElement("br"));
        root.appendChild(document.createElement("hr"));
        curNode = document.createElement("h2");
        curNode.appendChild(document.createTextNode("Temperature Data"));
        root.appendChild(curNode);
        
        curNode = document.createElement("div");
        myId = DataDisplayer.prototype.graphDivPrefix + 
                    DataDisplayer.prototype.graphDivNum;
        DataDisplayer.prototype.graphDivNum ++;
        curNode.setAttribute("id", myId);
        root.appendChild(curNode);
        plotGraph(myId, DataDisplayer.prototype.tmpGraphDataSets); 
    }
   
}




function plotGraph(parentId, dataSet){
    

    
    var parent = document.getElementById(parentId);
    if (parent.getAttribute("class")!=null){
        parent.removeAttribute("class");
    }
    parent.setAttribute("class", "graphContainer");
    
    var curNode = document.createElement("div");
    var graphId = "flotGraph"+DataDisplayer.prototype.graphDivNum;
    curNode.setAttribute("class", "flotGraph")
    curNode.setAttribute("id", graphId);
    parent.appendChild(curNode);

    curNode = document.createElement("p");
    var sidebarId = "flotGraphChoices"+DataDisplayer.prototype.graphDivNum;
    curNode.setAttribute("id", sidebarId);
    curNode.setAttribute("class", "flotGraphChoices")
    curNode.appendChild( document.createTextNode("Show:") );
    parent.appendChild(curNode);
 
    DataDisplayer.prototype.graphDivNum += 1;
    
    plotGraphAux(graphId, sidebarId, dataSet);
}

function plotGraphAux(graphDiv, sidebarDiv, dataSets){
    var choiceId = "#"+sidebarDiv;
    var graphId = "#"+graphDiv;
    
    $(function () {
        var datasets = dataSets;

        // hard-code color indices to prevent them from shifting as
        // countries are turned on/off
        var i = 0;
        $.each(datasets, function(key, val) {
            val.color = i;
            ++i;
        });

        // insert checkboxes 
        var choiceContainer = $(choiceId);
        $.each(datasets, function(key, val) {
            choiceContainer.append('<br/><input type="checkbox" name="' + key +
                                   '" checked="checked" id="id' + key + '">' +
                                   '<label for="id' + key + '">'
                                    + val.label + '</label>');
        });
        choiceContainer.find("input").click(plotAccordingToChoices);


        function plotAccordingToChoices() {
            var data = [];

            choiceContainer.find("input:checked").each(function () {
                var key = $(this).attr("name");
                if (key && datasets[key])
                    data.push(datasets[key]);
            });

            if (data.length > 0)
                $.plot($(graphId), data, {
                    yaxis: {min: 0},
                      xaxis: {
                        mode: "time",
                        timeformat: "%y/%m/%d"
                      }
                });
        }

        plotAccordingToChoices();
    });
}