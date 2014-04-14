var fs = require('fs');

var varnishErrors = function (){  
	var self = this;
	var backendHistory = new Array();
	backendHistory['nginx1'] = "Healthy";
	backendHistory['nginx2'] = "Healthy";

	self.monitorErrors = function (io){
		// console.log('checking ' + __dirname + '/errors');
	    fs.readFile(__dirname + '/errors', function(err, data){
	        if (err){
	            return;
	        }
	        var dataOut = JSON.parse(data);
	        // console.log('VarnishAlert: ' + dataOut);
	        // console.log(dataOut);
	        io.sockets.emit('VarnishAlert', JSON.stringify(dataOut));

	        fs.unlink(__dirname + '/errors', function (err) {
	          if (err) throw err;
	          console.log('successfully deleted '+__dirname + '/errors');
	        });
	    });
	};

	self.monitorBackends = function (io) {
		var childProcess = require('child_process');
		var backendCheck = childProcess.exec('/usr/bin/varnishadm debug.health', function (error, stdout, stderr) {
			if (error) {
				console.log(error.stack);
				console.log('Backend check -> Error code: '+error.code);
				console.log('Backend check -> Signal received: '+error.signal);
			}
			// console.log('Backend check -> Child Process STDOUT: '+stdout);

			var backendDetails = stdout.split(/\n/g);
			for (var i=0; i < backendDetails.length; i++) {
				if (backendDetails[i].match(/^Backend\s+\S+\s+is\s+\S+/)) {
					var backendStatus = backendDetails[i].match(/^Backend\s+(\S+)\s+is\s+(\S+)/);

					if (backendHistory[backendStatus[1]] == backendStatus[2]) {
						// console.log('No change : ' + backendStatus[1]);
					} else {
						console.log('Backend Status change : ' + backendStatus[1] + ' to ' + backendStatus[2]);
						backendHistory[backendStatus[1]] = backendStatus[2];
						var msgSeverity = "CRITICAL";
						if (backendStatus[2] == "Healthy") {
							msgSeverity = "HARMLESS";
						}
						io.sockets.emit('VarnishAlert', '{"errorSeverity":  "'+msgSeverity+'", "errorMessage": "Backend '+backendStatus[1]+' changed to ' + backendStatus[2] + '"}');
					}

					// console.log('prev ' + backendHistory[backendStatus[1]]);
					// console.log('Details: ' + backendStatus[1] + ' : ' + backendStatus[2]);
				}
				
			}

			// console.log('VCL List -> Child Process STDERR: '+stderr);


		});

		backendCheck.on('exit', function (code) {
			// console.log('VCL List -> Child process exited with exit code '+code);
		});
	};

};

module.exports = varnishErrors;
