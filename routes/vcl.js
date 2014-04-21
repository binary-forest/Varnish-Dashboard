var fs = require('fs');
var config = require('../config');
var serverInfo = config.varnishServer.connection;

exports.getSnippets = function(req, res, next) {
	fs.readdir(__dirname + '/../resources/vcl/snippets', function (err, files) {
		if (err) throw err;
		// console.log("snippet files: " + files);
		res.json(JSON.stringify(files));
	});

};


exports.getSnippet = function(req, res, next) {
	var snippetName = req.param('snippetname');

	fs.readFile(__dirname + '/../resources/vcl/snippets/' + snippetName, 'utf8', function (err,data) {
	  if (err) {
	    return console.log(err);
	  }
	  res.json(JSON.stringify(data));
	});
};



exports.vclSaveVCL = function(req, res, next) {
	var childProcess = require('child_process');
	var vclName = req.param('vclName');
	var vclContent = req.body.vclContent;

	fs.writeFile(__dirname + '/../resources/vcl/full/' + vclName, vclContent, function(err) {
	    if(err) {
	    	res.send({status: "fail", errorDetails: err});
	    } else {
	        res.send({status: "success"});
	    }
	}); 
};

exports.vclList = function(req, res, next) {
	var childProcess = require('child_process');

	var vcllistCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' vcl.list', function (error, stdout, stderr) {
		if (error) {
			console.log(error);
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			var vclDetails = stdout.split(/(\S+)\s+(\d+)\s+(\S+)\n/g);
			var vclOutput = "[ ";

			for (var i=1; i<vclDetails.length; i=i+4 ){
				vclOutput += '{"vclName": "'+ vclDetails[i+2] + '", "vclID": "'+ vclDetails[i+1]+'", "vclState": "'+ vclDetails[i] + '"},';
			}
			vclOutput = vclOutput.replace(/,$/,'');
			vclOutput += ' ]';
			res.set('content-type', 'application/json');
			res.send(vclOutput);
		}
	});
};

exports.getStaticVCL = function(req, res, next) {
	fs.readdir(__dirname + '/../resources/vcl/full', function (err, files) {
		if (err) throw err;
		var staticVCLs = "";
		for (var i = 0 ; i < files.length; i++) {
			staticVCLs += '{"vclName": "'+ files[i] + '", "vclID": "0", "vclState": "file"},';
		}
		// console.log('static >> ' + staticVCLs);
		res.set('content-type', 'application/json');
		staticVCLs = staticVCLs.replace(/,$/,'');
		staticVCLs = '[ ' + staticVCLs + ' ]';
		res.send(staticVCLs);
	});
}

exports.getStaticVCLcontent = function(req, res, next) {
	var vclName = req.param('vclName');

	fs.readFile(__dirname + '/../resources/vcl/full/' + vclName, 'utf8', function (err,data) {
	  if (err) {
	    return console.log(err);
	  }
	  res.json({status: 'success', vclDetails: data});
	});
};

exports.loadStaticVCL = function(req, res, next) {
	var vclName = req.param('vclName');

	var loadFile = __dirname + '/../resources/vcl/full/' + vclName;

	var childProcess = require('child_process');

	var formattedDate = new Date().toJSON();
	console.log(formattedDate);

	var vcllistCmd = childProcess.exec('/usr/bin/varnishadm -T ' + serverInfo + ' vcl.load ' + vclName+'_'+formattedDate + ' ' + loadFile, function (error, stdout, stderr) {
		if (error) {
			console.log(error);
			res.send([{status: 'fail', errorDetails: stdout}]);
		} else {
			res.send({status: "success"});
		}
	});
};
exports.deleteStaticVCL = function(req, res, next) {
	var vclName = req.param('vclName');

	console.log('deleting : ' + vclName);

	fs.unlink(__dirname + '/../resources/vcl/full/' + vclName , function (err) {
      if (err) {
      	console.log(error);
		res.send([{status: 'fail', errorDetails: stdout}]);
      }
      res.send({status: "success"});
    });
};
