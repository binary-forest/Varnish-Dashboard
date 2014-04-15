<?php include("header.php"); ?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">                
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Varnish Dashboard <small>Current</small></h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="Varnish Alerts">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                    </div><!-- /. tools -->
                                    <i class="fa fa-globe"></i>
                                    <h3 class="box-title">Varnish Alerts </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="box-body" id="varnishAlerts">

                                        </div>
                                    </div><!-- /.websitestatus -->

                                </div><!-- /.box-body-->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="Historical Cache Hit Rate Last Hour">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title">Varnish Stats <small>realtime</small></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div id="varnishStats" style="height: 300px;"></div>
                                </div><!-- /.box-body-->
                            </div><!-- /.box -->
                        <div id="hitratio-historic-tooltip"></div>
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="Historical Cache Hit Rate Last Hour">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title">Server Stats <small>realtime</small></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div id="serverStats" style="height: 300px;"></div>
                                </div><!-- /.box-body-->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="Historical Cache Hit Rate Last Hour">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title">Bytes sent <small>realtime</small></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div id="bytesStats" style="height: 300px;"></div>
                                </div><!-- /.box-body-->
                            </div><!-- /.box -->
                        <div id="hitratio-historic-tooltip"></div>
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="Historical Cache Hit Rate Last Hour">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title">Hit Rate <small>realtime</small></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div id="hitrateStats" style="height: 300px;"></div>
                                </div><!-- /.box-body-->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->




        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php include("scripts.php"); ?>



<!-- jquery section -->

        <script>

                var socket = io.connect('updatetonodeserver', {
                /* Pass the authentication token as a URL parameter */
                    query: $.param({token: 'randomtoken'})
                /* My application is more complicated, so I use jQuery's .param utility to convert the Object to an URL string e.g. 'token=abc&etc=cde' */
                });

            $(function() {

                var runnumber = 0;

                var mpoints_max = 250;

                var hitRateData = [];
                var prevHits = 0;
                var hitRateDataDetails = [
                    {
                        label: "Hit Rate",
                        data: hitRateData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#006600'
                        },
                        color: '#006600'
                    }
                ];

                var hitRateStats_plot = $.plot("#hitrateStats", [hitRateDataDetails], {
                    grid: {
                        borderColor: "#f3f3f3",
                        borderWidth: 1,
                        tickColor: "#f3f3f3",
                        clickable: false,
                        hoverable: true

                    },
                    series: {
                        shadowSize: 0 // Drawing is faster without shadows

                    },
                    yaxis: {
                        min: 0,
                        show: true
                    },
                    xaxis: {
                        mode: "time",
                        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        show: true
                    }
                });

                hitRateStats_plot.setupGrid();


                var prevBBytesSent = 0;
                var prevHBytesSent = 0;
                var bytesSentHData = [];
                var bytesSentBData = [];

                var bytesSentDataDetails = [
                    {
                        label: "KBytes Sent Header",
                        data: bytesSentHData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#006600'
                        },
                        color: '#006600'
                    },
                    {
                        label: "Bytes Sent Body",
                        data: bytesSentBData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#0B0B61'
                        },
                        color: '#0B0B61'
                    }
                ];

                var bytesSentStats_plot = $.plot("#bytesStats", [bytesSentDataDetails], {
                    grid: {
                        borderColor: "#f3f3f3",
                        borderWidth: 1,
                        tickColor: "#f3f3f3",
                        clickable: false,
                        hoverable: true

                    },
                    series: {
                        shadowSize: 0 // Drawing is faster without shadows

                    },
                    yaxis: {
                        min: 0,
                        show: true
                    },
                    xaxis: {
                        mode: "time",
                        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        show: true
                    }
                });

                bytesSentStats_plot.setupGrid();

                var hitRatioData = [];
                var missRatioData = [];

                var hitRatioDataDetails = [
                    {
                        label: "Hit Ratio",
                        data: hitRatioData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#006600'
                        },
                        color: '#006600'
                    },
                    {
                        label: "Miss Ratio",
                        data: missRatioData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#FF0000'
                        },
                        color: '#FF0000'
                    }
                ];

                var hitRatioStats_plot = $.plot("#varnishStats", [hitRatioDataDetails], {
                    grid: {
                        borderColor: "#f3f3f3",
                        borderWidth: 1,
                        tickColor: "#f3f3f3",
                        clickable: false,
                        hoverable: true

                    },
                    series: {
                        shadowSize: 0 // Drawing is faster without shadows

                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        show: true
                    },
                    xaxis: {
                        mode: "time",
                        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        show: true
                    }
                });

                hitRatioStats_plot.setupGrid();


/*
                 * Flot Interactive Chart
                 * -----------------------
                 */
                
                var DiskData = [];
                var CPUData = [];
                var MemData = [];
                // var data1month = [];
                var serverStatsDataDetails = [
                    {
                        label: "Disk Stats",
                        data: DiskData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#006600'
                        },
                        color: '#006600'
                    },
                    {
                        label: "Memory Stats",
                        data: MemData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#000066'
                        },
                        color: '#000066'
                     },
                     {
                        label: "CPU Stats",
                        data: CPUData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#660066'
                        },
                        color: '#660066'
                     }
                ];

                var serverStats_plot = $.plot("#serverStats", [serverStatsDataDetails], {
                    grid: {
                        borderColor: "#f3f3f3",
                        borderWidth: 1,
                        tickColor: "#f3f3f3",
                        clickable: false,
                        hoverable: true

                    },
                    series: {
                        shadowSize: 0 // Drawing is faster without shadows

                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        show: true
                    },
                    xaxis: {
                        mode: "time",
                        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        show: true
                    }
                });

                serverStats_plot.setupGrid();

                 

                    function serverStatsShowToolTip(x, y, contents) {
                        $('<div id="serverStats-historic-tooltip">' + contents + '</div>').css({
                            top: y - 45,
                            left: x - 50
                        }).appendTo('body').fadeIn();
                    }

                    function niceDate(timestamp) {
                        var today = new Date(timestamp);
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;//January is 0!
                        var yyyy = today.getFullYear();
                        var hours = today.getHours();
                        var minutes = today.getMinutes();
                        var seconds = today.getSeconds();
                        if(dd<10){dd='0'+dd}
                        if(mm<10){mm='0'+mm}
                        d=dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+':'+seconds
                        return d;
                    }

                    $('#serverStats').bind('plothover', function (event, pos, item) {
                        if (item) {
                            if (previousPoint != item.dataIndex) {
                                previousPoint = item.dataIndex;
                                $('#serverStats-historic-tooltip').remove();
                                var x = item.datapoint[0],
                                    y = item.datapoint[1];

                                serverStatsShowToolTip(item.pageX, item.pageY, item.series.label + ' : ' + y + '% @ ' + niceDate(x));
                            }
                        } else {
                            $('#serverStats-historic-tooltip').remove();
                            previousPoint = null;
                        }
                    });

                /*
                 * END INTERACTIVE CHART
                 */
                 

                socket.on('ServerInfo', function(data){
                    // console.log(data);
                    // console.log(data.CPU);
                    if (CPUData.length > mpoints_max) {
                        DiskData.splice(0, 1);
                        CPUData.splice(0, 1);
                        MemData.splice(0, 1);
                    }

                    DiskData.push([data.Timestamp , data.Disk]);
                    CPUData.push([data.Timestamp , data.CPU]);
                    MemData.push([data.Timestamp , data.Memory]);

                    serverStats_plot.setData(serverStatsDataDetails);

                    // Since the axes change, we need to call plot.setupGrid()
                    serverStats_plot.setupGrid();
                    serverStats_plot.draw();

                });


                var rtime = new Date(1, 1, 2000, 12,00,00);
                var timeout = false;
                var delta = 200;

                $(window).resize(function() {
                    rtime = new Date();
                    if (timeout === false) {
                        timeout = true;
                        setTimeout(resizeend, delta);
                    }
                });

                function resizeend() {
                    if (new Date() - rtime < delta) {
                        setTimeout(resizeend, delta);
                    } else {
                        timeout = false;
                        serverStats_plot.resize();
                        serverStats_plot.setupGrid();
                        serverStats_plot.draw();

                        hitRatioStats_plot.resize();
                        hitRatioStats_plot.setupGrid();
                        hitRatioStats_plot.draw();

                        bytesSentStats_plot.resize();
                        bytesSentStats_plot.setupGrid();
                        bytesSentStats_plot.draw();

                        hitRateStats_plot.resize();
                        hitRateStats_plot.setupGrid();
                        hitRateStats_plot.draw();

                        console.log('Done resizing');
                    }               
                }


                socket.on('VarnishStats', function(dataIn){
                    var data = JSON.parse(dataIn);
                    
                    if (hitRatioData.length > mpoints_max) {
                        hitRatioData.splice(0, 1);
                        missRatioData.splice(0, 1);
                        bytesSentHData.splice(0, 1);
                        bytesSentBData.splice(0, 1);
                        hitRateData.splice(0, 1);
                    }

                    var hitcount = data.cache_hit.value + data.cache_miss.value + data.cache_hitpass.value;
                    var hitRatio = data.cache_hit.value / hitcount * 100;
                    var missRatio = data.cache_miss.value / hitcount * 100;

                    var dateStamp = new Date(data.timestamp);
                    hitRatioData.push([dateStamp.getTime() , hitRatio]);
                    missRatioData.push([dateStamp.getTime() , missRatio]);

                    hitRatioStats_plot.setData(hitRatioDataDetails);
                    hitRatioStats_plot.setupGrid();
                    hitRatioStats_plot.draw();

                    if (prevHBytesSent != 0) {
                        bytesSentHData.push([dateStamp.getTime() ,data.s_hdrbytes.value - prevHBytesSent]);
                        bytesSentBData.push([dateStamp.getTime() ,data.s_bodybytes.value - prevBBytesSent]);
                    }

                    prevBBytesSent = data.s_bodybytes.value;
                    prevHBytesSent = data.s_hdrbytes.value;     
                    
                    bytesSentStats_plot.setData(bytesSentDataDetails);
                    bytesSentStats_plot.setupGrid();
                    bytesSentStats_plot.draw();         


                    // console.log('n_objwrite ' + data.n_objwrite.value);
                    var currentHits = data.n_objwrite.value - prevHits;
                    
                    // console.log('currentHits : ' + currentHits);
                    // console.log('prevHits '+prevHits);
                    
                    prevHits = data.n_objwrite.value;
                    if (runnumber > 0) {
                        hitRateData.push([dateStamp.getTime(), currentHits]);
                    } else {
                        runnumber++;
                    }
                    hitRateStats_plot.setData(hitRateDataDetails);
                    hitRateStats_plot.setupGrid();
                    hitRateStats_plot.draw();     



                    // console.log(data);
                });


                socket.on('VarnishAlert', function(dataIn) {
                    var data = JSON.parse(dataIn);
                    console.log(data);
                    if (data.length > 1) {
                        for (var i=0;i<data.length;i++) {
                            console.log('Alert Severity : ' + data[i].errorSeverity + ' Msg: ' + data[i].errorMessage);
                            if (data[i].errorSeverity == "CRITICAL") {
                                $('#varnishAlerts').append('<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data[i].errorMessage+' \
                                    </div>');
                            } else if (data[i].errorSeverity == "HARMLESS") {
                                    $('#varnishAlerts').append('<div class="alert alert-success  alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data[i].errorMessage+' \
                                    </div>');
                            } else {
                                    $('#varnishAlerts').append('<div class="alert alert-warning  alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data[i].errorMessage+' \
                                    </div>');
                            }

                        }
                    } else {
                        console.log('Alert Severity : ' + data.errorSeverity + ' Msg: ' + data.errorMessage);
                            if (data.errorSeverity == "CRITICAL") {
                                $('#varnishAlerts').append('<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data.errorMessage+' \
                                    </div>');
                            } else if (data.errorSeverity == "HARMLESS") {
                                    $('#varnishAlerts').append('<div class="alert alert-success  alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data.errorMessage+' \
                                    </div>');
                            } else {
                                    $('#varnishAlerts').append('<div class="alert alert-warning  alert-dismissable"><i class="fa fa-ban"></i> \
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                        <b>Alert!</b> '+data.errorMessage+' \
                                    </div>');
                            }
                    }
                });

            });

        </script>

<!-- end jquery section -->

<?php include("footer.php"); ?>
