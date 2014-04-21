var snmp = require ("net-snmp");

var config = require('../config');
var serverInfo = config.varnishServer.connection;
var session = snmp.createSession ("localhost", config.server.communityName);

exports.pushServerStats = function(io) {
		// console.log('server info');
		var totalMemory = 0;
		var freeMemory = 0;
		var idlCPU = 0;
		var freeDisk = 0;
		var cpuLoad = 0;

		var oids = ["1.3.6.1.4.1.2021.4.5.0", "1.3.6.1.4.1.2021.4.6.0",  "1.3.6.1.4.1.2021.9.1.9.1", "1.3.6.1.4.1.2021.10.1.3.2", "1.3.6.1.4.1.2021.11.11.0"];

		session.get (oids, function (error, varbinds) {
		    if (error) {
		        console.error (error.toString ());
		    } else {
		        for (var i = 0; i < varbinds.length; i++) {
		            if (snmp.isVarbindError (varbinds[i]))
		                console.error (snmp.varbindError (varbinds[i]));
		            else {
		                // console.log (varbinds[i].oid + "|" + varbinds[i].value);
		            	switch(varbinds[i].oid) {
		            		case "1.3.6.1.4.1.2021.4.5.0":
		            			totalMemory = varbinds[i].value;
		            			// console.log('Total memory: ' + varbinds[i].value);
		            			break;
		            		case "1.3.6.1.4.1.2021.4.6.0":
		            			freeMemory = varbinds[i].value;
		            			// console.log('Free memory: ' + varbinds[i].value);
		            			break;
		            		case "1.3.6.1.4.1.2021.11.11.0":
		            			idlCPU = varbinds[i].value;
		            			// console.log('CPU Idle: ' + varbinds[i].value);
		            			break;
		            		case "1.3.6.1.4.1.2021.10.1.3.2":
		            			cpuLoad = varbinds[i].value.toString();
		            			// console.log('CPU Idle: ' + varbinds[i].value);
		            			break;
		            		case "1.3.6.1.4.1.2021.9.1.9.1":
		            			freeDisk = varbinds[i].value;
		            			// console.log('disk used: ' + varbinds[i].value);
		            			break;
		            	}
		            }
		        }
				var freeMemPct = 100 - (freeMemory / totalMemory * 100 );
				var cpuPct = 100 - idlCPU;

		        io.sockets.emit('ServerInfo',{
		        	'Timestamp': Date.now(),
		        	'CPU': cpuPct,
		        	'CPULoad': cpuLoad,
			        'Memory': freeMemPct,
			        'Disk': freeDisk
			    	}
			    );
		    }
		});
};



exports.getServerStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getAll', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	    	// var allStats = JSON.parse(value);
	    	// console.log(allStats.load);
	        res.send(value);
	    }
	});

};

exports.getLoadStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getLoad', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getCPUStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getCpu', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getDiskUsageStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getFs', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getMemoryStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getMem', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getSwapStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getMemSwap', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getNetworkStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getNetwork', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	res.set('content-type', 'application/json');
	        res.send(value);
	    }
	});
};

exports.getGraphStats = function(req, res, next) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getAll', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	var allStats = JSON.parse(value);
	    	res.set('content-type', 'application/json');
	    	res.send(  { load: allStats.load, cpu: allStats.cpu, disk: allStats.fs, memory: allStats.mem, swap: allStats.memswap, network: allStats.network } );

	    }
	});
};

exports.sendServerStats = function(socket) {
	var glances = require('glances');
	var client = glances.createClient({ host: 'localhost' });
	client.call('getAll', function(error, value){
	    if(error) {
	    	res.send({status: 'fail', errorDetails: 'Can not retrieve data'});
	    } else {
	    	var allStats = JSON.parse(value);
	    	socket.emit('ServerInfo', { Timestamp: new Date().getTime(), load: allStats.load, cpu: allStats.cpu, disk: allStats.fs, memory: allStats.mem, swap: allStats.memswap, network: allStats.network });
	    }
	});
};