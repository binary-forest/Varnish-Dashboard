var fs = require('fs');
const process = require('child_process');

var varnishStats = function (){  
	var self = this;
	var varnishlog;
	self.currentStats = function (io){

		varnishlog = process.spawn("/usr/bin/varnishstat", ["-j", "-w 1", "-f n_objwrite -f client_req -f s_hdrbytes -f s_bodybytes -f uptime -f cache_hit -f cache_hitpass -f cache_miss -f s_sess -f s_req -f s_pipe -f s_pass -f s_fetch -f s_error -f backend_conn -f backend_unhealthy -f backend_busy -f backend_fail -f backend_reuse -f backend_toolate -f backend_recycle"]);
		
		console.log("Started query of varnishstat");

		varnishlog.stdout.on("data", function (data) {
			var dataOut = JSON.parse(data);
			io.sockets.emit('VarnishStats', JSON.stringify(dataOut));
		});

	};

	self.stopStats = function() {
		varnishlog.kill('SIGTERM');
	}
};

module.exports = varnishStats;