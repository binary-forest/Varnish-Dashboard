var snmp = require ("net-snmp");
var session = snmp.createSession ("localhost", "public");

var serverInfo = function (){  
	var self = this;
	self.serverUsage = function (io){
		// console.log('server info');
		var totalMemory = 0;
		var freeMemory = 0;
		var idlCPU = 0;
		var freeDisk = 0;

     //    io.sockets.emit('ServerInfo',
	    //     {'CPU': Math.floor((Math.random()*100)+1),
	    //      'Memory': Math.floor((Math.random()*100)+1),
	    //      'Disk': Math.floor((Math.random()*100)+1)
		   //  }
	    // );

var oids = ["1.3.6.1.4.1.2021.4.5.0", "1.3.6.1.4.1.2021.4.11.0", "1.3.6.1.4.1.2021.11.11.0", "1.3.6.1.4.1.2021.9.1.9.1"];

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
            		case "1.3.6.1.4.1.2021.4.11.0":
            			freeMemory = varbinds[i].value;
            			// console.log('Free memory: ' + varbinds[i].value);
            			break;
            		case "1.3.6.1.4.1.2021.11.11.0":
            			idlCPU = varbinds[i].value;
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
	        'Memory': freeMemPct,
	        'Disk': freeDisk
	    	}
	    );
    }
});




	};
};

module.exports = serverInfo;
