// JavaScript Document

// Data Manager Class
function DataManager(bldID, dpmtID, srvID, beginTime, endTime, 
        bldArray, dpmtArray, srvArray)
{
	// properties
	this.bldID = bldID
	this.dpmtID = dpmtID
	this.srvID = srvID
	this.beginTime = beginTime
	this.endTime = endTime
	
	// methods
	DataManager.prototype.getKeys = function ()
	{
		return {"bldID": this.bldID, 
				"dpmtID": this.dpmtID, 
				"srvID" : this.srvID, 
				"beginTime" : this.beginTime, 
				"endTime" : this.endTime};
	}
	
	// DataManager.prototype.
}

