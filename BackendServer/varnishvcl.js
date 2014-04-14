

var varnishVCL = function (){  
	var self = this;
	self.vclList = function (io){
		var childProcess = require('child_process');
		var vcllistCmd = childProcess.exec('/usr/bin/varnishadm vcl.list', function (error, stdout, stderr) {
			if (error) {
				console.log(error.stack);
				console.log('VCL List -> Error code: '+error.code);
				console.log('VCL List -> Signal received: '+error.signal);
			}
			// console.log('VCL List -> Child Process STDOUT: '+stdout);
			// console.log('VCL List -> Child Process STDERR: '+stderr);

			var vclDetails = stdout.split(/(\S+)\s+(\d+)\s+(\S+)\n/g);
			var vclOutput = "[ ";

			for (var i=1; i<vclDetails.length; i=i+4 ){
				vclOutput += '{"vclName": "'+ vclDetails[i+2] + '", "vclID": "'+ vclDetails[i+1]+'", "vclState": "'+ vclDetails[i] + '"},';
			}

			vclOutput = vclOutput.replace(/,$/,'');
			vclOutput += ' ]';
			// console.log(vclOutput);
			io.sockets.emit('VCLList', vclOutput);
		});

		vcllistCmd.on('exit', function (code) {
			// console.log('VCL List -> Child process exited with exit code '+code);
		});
	};
};

module.exports = varnishVCL;