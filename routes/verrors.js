var fs = require('fs');
var config = require('../config');

var serverInfo = config.varnishServer.connection;
var io;

exports.setIO = function(ioin) {
	io = ioin;
}


var backendHistory = new Array();

exports.pushBackendError = function(io) {
	var childProcess = require('child_process');
	var backendCheck = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' debug.health', function (error, stdout, stderr) {
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

exports.monitorErrors = function(io) {
    fs.readFile(__dirname + '/../errors', function(err, data){
        if (err){
            return;
        }
        var dataOut = JSON.parse(data);
        io.sockets.emit('VarnishAlert', JSON.stringify(dataOut));

        fs.unlink(__dirname + '/../errors', function (err) {
          if (err) throw err;
        });
    });
};

exports.errorEvent = function(req, res, next) {
	var errorSeverity = req.body.severity;
	var errorMessage = req.body.message;
	io.sockets.emit('VarnishAlert', '{"errorSeverity":  "'+errorSeverity+'", "errorMessage": "'+errorMessage+'"}');
	res.send({status: "success"});
};

	