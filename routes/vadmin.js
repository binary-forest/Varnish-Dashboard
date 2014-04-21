var config = require('../config');
var serverInfo = config.varnishServer.connection;




exports.vclGetVCL = function(req, res, next) {
	var childProcess = require('child_process');
	var vclName = req.param('vclName');

	var vclGetCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' vcl.show ' + vclName , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: 'success', vclDetails: stdout});
		}
	});
};



exports.vclDeleteVCL = function(req, res, next) {
	var childProcess = require('child_process');
	var vclName = req.param('vclName');

	var vclDeleteCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' vcl.discard '+ vclName , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: "deleted " + vclName});
		}
	});
};

exports.vclUpdateVCL = function(req, res, next) {
	var childProcess = require('child_process');
	var vclName = req.param('vclName');

	var vclDetails = req.body.vclDetails;

	res.send({status: "updated " + vclName});
};

exports.vclActivate = function(req, res, next) {
	var childProcess = require('child_process');
	var vclName = req.param('vclName');
	var vclActivateCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' vcl.use ' + vclName, function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: "success"});
		}
	});
};

exports.banList = function(req, res, next) {
	var childProcess = require('child_process');
	var banListCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' ban.list', function (error, stdout, stderr) {
		if (error) {
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			var banDetails = stdout.split(/\n/);
			var banOutput = "[ ";
			var bansPresent = false;

			// console.log(banOutput);
			for (var i=0; i<banDetails.length;i++) {
				if (banDetails[i].match(/^\d+\.\d/)) {
					bansPresent = true;
					var banInfo = banDetails[i].match(/(\d+\.\d+)\s+([\dG]+)\s+(.+)/);
					var timestampSeconds = banInfo[1].split(/\./,1);
					var formattedDate = new Date(timestampSeconds*1000).toJSON();
					banOutput += '{"Timestamp": "'+ formattedDate + '", "banCount": "'+ banInfo[2]+'", "banRegex": "'+ banInfo[3] + '"},';
				}
			}
			// var banDetails = banDetails.split(/(\d+\.\d+)\s+([\dG])+\s+(.+?)\n/g);
			// console.log(banDetails);

			banOutput = banOutput.replace(/,$/,'');
			banOutput += ' ]';
			res.set('content-type', 'application/json');

			if (bansPresent) {
				res.send(banOutput);
			} else {
				res.send('{"Timestamp": "'+ 0 + '", "banCount": "0", "banRegex": ""}');
			}
		}
	});
};

exports.banAdd = function(req, res, next) {
	var childProcess = require('child_process');
	var banString = req.body.banRegex;
	var banAddCmd = childProcess.exec("/usr/bin/varnishadm -T " + serverInfo + " ban " + "'" + banString + "'", function (error, stdout, stderr) {
		if (error) {
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			res.send({status: 'success', banString: banString});
		}
	});
};

exports.varnishStatus = function(req, res, next) {
	var childProcess = require('child_process');

	var varnishStatusCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' status' , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: stdout});
		}
	});
};

exports.varnishStop = function(req, res, next) {
	var childProcess = require('child_process');

	var varnishStopCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' stop' , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: 'success'});
		}
	});
};

exports.varnishStart = function(req, res, next) {
	var childProcess = require('child_process');

	var varnishStartCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' start' , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			res.send({status: 'success'});
		}
	});
};

exports.backendsStatus = function(req, res, next) {
	var childProcess = require('child_process');

	var backendCheck = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' debug.health' , function (error, stdout, stderr) {
		if (error) {
			res.send({status: 'fail', errorDetails: stdout});
		} else {
			var backendDetails = stdout.split(/\n/g);
			var backends = {};
			for (var i=0; i < backendDetails.length; i++) {
				if (backendDetails[i].match(/^Backend\s+\S+\s+is\s+\S+/)) {
					var backendStatus = backendDetails[i].match(/^Backend\s+(\S+)\s+is\s+(\S+)/);
					backends[backendStatus[1]] = backendStatus[2];
				}
			}
			res.send({status: 'success', backends: [backends]});
		}
	});
};



