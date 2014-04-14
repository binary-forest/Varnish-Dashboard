
var websiteCheck = function (){  
	var self = this;
	var request = require('request');
	var websiteStatus = new Array();
	var sitesToCheck = {"http://localhost":0};
	self.checkSite = function (io){
		for (website in sitesToCheck) {
			request(website, function (error, response, body ) {
				//console.log(this.uri.host + ' status ' + error + ' response ' + response.statusCode);
				// console.log(this.uri.host);
			  if (error || response.statusCode != 200) {
			    // console.log(request.initParams);
			    // console.log(response);
			    if (websiteStatus[this.uri.host] != "DOWN") {
			    	io.sockets.emit('VarnishAlert', '{"errorSeverity":  "CRITICAL", "errorMessage": "Website '+this.uri.host+' is not available status code '+ response.statusCode +'"}');
			    }
			    websiteStatus[this.uri.host] = "DOWN";
			    
			  } else {
			  	if (websiteStatus[this.uri.host] == "DOWN") {
			    	io.sockets.emit('VarnishAlert', '{"errorSeverity":  "HARMLESS", "errorMessage": "Website '+this.uri.host+' is now available status code '+ response.statusCode +'"}');
			    }
			  	websiteStatus[this.uri.host] = "UP";
			  }
			})	
		}
	};

	self.resetStatus = function() {
		for (var prop in websiteStatus) {
		    if (websiteStatus.hasOwnProperty(prop)) {
		        delete websiteStatus[prop];
		    }
		}

	}

};

module.exports = websiteCheck;
