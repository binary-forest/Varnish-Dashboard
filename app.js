var express = require('express');
var path = require('path');
var favicon = require('static-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');


var vadmin = require('./routes/vadmin'),
    vstats = require('./routes/vstats'),
    sinfo  = require('./routes/serverinfo'),
    verrors= require('./routes/verrors'),
    vcledit= require('./routes/vcl'),
    config = require('./config');


var app = express();


app.use(favicon());
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());
app.use(cookieParser());


app.use(function(req, res, next) {
    res.set('Access-Control-Allow-Origin', '*');
    res.set('Access-Control-Allow-Methods', 'POST,GET,PUT,DELETE,OPTIONS');
    res.set('Access-Control-Allow-Headers', "Content-Type");
    next();
})

app.route('/vcl')
.get(vcledit.vclList)

app.route('/vcl/static')
.get(vcledit.getStaticVCL)

app.route('/vcl/static/:vclName')
.get(vcledit.getStaticVCLcontent)
.put(vcledit.loadStaticVCL)
.delete(vcledit.deleteStaticVCL)

app.route('/vcl/snippet')
.get(vcledit.getSnippets)

app.route('/vcl/:vclName')
.post(vcledit.vclSaveVCL)
.get(vadmin.vclGetVCL)
.put(vadmin.vclUpdateVCL)
.delete(vadmin.vclDeleteVCL)

app.route('/vcl/:vclName/activate')
.put(vadmin.vclActivate)



app.route('/vcl/snippet/:snippetname')
.get(vcledit.getSnippet)

app.route('/ban')
.get(vadmin.banList)
.post(vadmin.banAdd)

app.route('/status')
.get(vadmin.varnishStatus)

app.route('/stop')
.post(vadmin.varnishStop)

app.route('/start')
.post(vadmin.varnishStart)

app.route('/stats')
.get(vstats.getStats)

app.route('/stat/:stat')
.get(vstats.getStat)

app.route('/backends')
.get(vadmin.backendsStatus)

app.route('/event')
.post(verrors.errorEvent)


app.use('/html', express.static(path.join(__dirname, 'public')));


/// catch 404 and forwarding to error handler
app.use(function(req, res, next) {
    var err = new Error('Not Found');
    err.status = 404;
    next(err);
});

/// error handlers

// development error handler
// will print stacktrace
if (app.get('env') === 'development') {
    app.use(function(err, req, res, next) {
        res.status(err.status || 500);
        res.render('error', {
            message: err.message,
            error: err
        });
    });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
        message: err.message,
        error: {}
    });
});


module.exports = app;

io = require('socket.io').listen(3001);

//turn off debug
io.set('log level', 1);
io.sockets.on('connection', function(socket){
});


verrors.setIO(io);


setInterval(function(){
    verrors.monitorErrors(io);
    vstats.pushVstats(io);
    verrors.pushBackendError(io);
    sinfo.pushServerStats(io);
}, config.dashboard.updateRate);

