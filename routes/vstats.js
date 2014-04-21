var config = require('../config');
var serverInfo = config.varnishServer.connection;


exports.getStats = function(req, res, next) {
	var childProcess = require('child_process');

	var statsCmd = childProcess.exec('/usr/bin/varnishstat -j' , function (error, stdout, stderr) {
		if (error) {
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			res.set('content-type', 'application/json');
			res.send(stdout);
		}
	});
};

exports.getStat = function(req, res, next) {
	var childProcess = require('child_process');
	var statRequest = req.param('stat');

	var statCmd = childProcess.exec('/usr/bin/varnishstat -j -f ' + statRequest , function (error, stdout, stderr) {
		if (error) {
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			res.set('content-type', 'application/json');
			res.send(stdout);
		}
	});
};

exports.pushVstats = function(io) {
	var childProcess = require('child_process');

	var statsCmd = childProcess.exec('/usr/bin/varnishstat -j' , function (error, stdout, stderr) {
		if (error) {
			return([{status: 'fail', errorDetails: stdout}]);
		} else {
			io.sockets.emit('VarnishStats', stdout);
		}
	});
};