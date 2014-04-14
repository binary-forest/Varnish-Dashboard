var http = require('http');
var url = require('url');
var fs = require('fs');
const process = require('child_process');
var server;

var varnishStats = require("./varnishstats.js");
var varnishStatsInstance = new varnishStats();
var varnishErrors = require("./varnisherrors.js");
var varnishErrorsInstance = new varnishErrors();
var serverInfo = require("./serverinfo.js");
var serverInfoInstance = new serverInfo();
var varnishVCL = require("./varnishvcl.js");
var varnishVCLInstance = new varnishVCL();
var varnishBan = require("./varnishban.js");
var varnishBanInstance = new varnishBan();
var websiteCheck = require("./webcheck.js");
var websiteCheckInstance = new websiteCheck();

server = http.createServer(function(req, res){
    // your normal server code
    var path = url.parse(req.url).pathname;
}),

send404 = function(res){
    res.writeHead(404);
    res.write('404');
    res.end();
};

server.listen(8001);

// use socket.io
var io = require('socket.io').listen(server);

var tokens = [
  'randometokens',
  'randometokens2'
];
io.set('authorization', function(req, callback) {

  // Some basic validation to make sure a token was passed
  if ( req.query.token === undefined || req.query.token.length === 0 )
  {
    return false;
  }

  // Loop through the valid tokens, to validate the token passed
  var validated = false;
  for ( var key in tokens )
  {
    if ( tokens[key] == req.query.token )
    {
      validated = true;
      break;
    }
  }

  // If valid, continue to callback the next function
  if ( validated )
  {
    return callback(null, true);
  }
  else
  {
    return false;
  }
});

//turn off debug
io.set('log level', 1);

var connectCounter = 0;



function runSubChecks() {
    if (connectCounter > 0) {
      // console.log('running checks 10 sec interval');
      serverInfoInstance.serverUsage(io);
      varnishErrorsInstance.monitorErrors(io);
      varnishErrorsInstance.monitorBackends(io);
      setTimeout(runSubChecks, 10000);
    }
}

function runSubChecks2() {
    if (connectCounter > 0) {
      // console.log('running checks 60 sec interval');
      varnishVCLInstance.vclList(io);
      varnishBanInstance.banList(io);
      websiteCheckInstance.checkSite(io);
      setTimeout(runSubChecks2, 60000);
    }
}


// define interactions with client
io.sockets.on('connection', function(socket){
    //recieve client data
    connectCounter++;
    if (connectCounter == 1) {
      varnishStatsInstance.currentStats(io);
      runSubChecks();
      runSubChecks2();
    }

    console.log('user connected, online count ' + connectCounter);

    socket.on('disconnect', function () {
        connectCounter--;
        console.log('user disconnected, online count ' + connectCounter);
        if (connectCounter == 0) {
          varnishStatsInstance.stopStats();
          websiteCheckInstance.resetStatus();
        }
    });



    socket.on('client_data', function(data){
        process.stdout.write(data.letter);
        socket.broadcast.emit('otherinput', {'otherinput': data.letter});
    });
});

