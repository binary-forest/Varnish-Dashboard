

var varnishBan = function (){  
	var self = this;
	var lastbanTime = 0;

	self.banList = function (io){
		var childProcess = require('child_process');
		var banlistCmd = childProcess.exec('/usr/bin/varnishadm ban.list', function (error, stdout, stderr) {
			if (error) {
				console.log(error.stack);
				console.log('Ban List -> Error code: '+error.code);
				console.log('Ban List -> Signal received: '+error.signal);
			}
			var banDetails = stdout.split(/\n/);
			var banOutput = "[ ";
			var newBans = false;

			// console.log(banOutput);
			for (var i=0; i<banDetails.length;i++) {
				if (banDetails[i].match(/^\d+\.\d/)) {
					// console.log(banDetails[i]);
					var banInfo = banDetails[i].match(/(\d+\.\d+)\s+([\dG]+)\s+(.+)/);
					var timestampSeconds = banInfo[1].split(/\./,1);
					if (lastbanTime < timestampSeconds) {
						lastbanTime = timestampSeconds
						newBans = true;
						console.log('new bans : ' + timestampSeconds);
					// console.log('Timestamp: ' + banInfo[1] + ' : ' + banInfo[2] + ' : ' + banInfo[3]);
					}
					banOutput += '{"Timestamp": "'+ timestampSeconds + '", "banCount": "'+ banInfo[2]+'", "banRegex": "'+ banInfo[3] + '"},';
				}
			}
			// var banDetails = banDetails.split(/(\d+\.\d+)\s+([\dG])+\s+(.+?)\n/g);
			// console.log(banDetails);
			banOutput = banOutput.replace(/,$/,'');
			banOutput += ' ]';
			if (newBans) {
				io.sockets.emit('BANList', banOutput);
			}
		});

		banlistCmd.on('exit', function (code) {
			// console.log('Ban List -> Child process exited with exit code '+code);
		});
	};
};

module.exports = varnishBan;