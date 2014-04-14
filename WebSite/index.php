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


                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="Website Status">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-primary btn-sm refresh-btn" id='website-status-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-globe"></i>
                            <h3 class="box-title">Website Status </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <div class="row"  id="website-status-container">

                            </div><!-- /.websitestatus -->

                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->


            <div class="row">

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="Current Varnish Server Server Status">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-primary btn-sm refresh-btn" id='hitratio-current-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-tachometer"></i>
                            <h3 class="box-title">Varnish Server Stats</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body text-center">
                            <input type="text" id='hitratio-current-knob' class="knob" data-thickness="0.2" data-readonly="true" data-width="195" data-height="195" data-fgColor="green"/>
                            <div class="knob-label">Varnish Hit Ratio %</div>
                        </div><!-- /.box-body-->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <input type="text" id='server-info-cpu-knob' class="knob server-info-knob" data-readonly="true" value="0" data-width="60" data-height="60" />
                                    <div class="knob-label">CPU</div>
                                </div><!-- ./col -->
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <input type="text" id='server-info-disk-knob' class="knob server-info-knob" data-readonly="true" value="0" data-width="60" data-height="60" />
                                    <div class="knob-label">Disk</div>
                                </div><!-- ./col -->
                                <div class="col-xs-4 text-center">
                                    <input type="text" id='server-info-memory-knob' class="knob server-info-knob" data-readonly="true" value="0" data-width="60" data-height="60" />
                                    <div class="knob-label">RAM</div>
                                </div><!-- ./col -->
                            </div><!-- /.row -->
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-primary btn-sm refresh-btn" id='varnishstat-current-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-tachometer"></i>
                            <h3 class="box-title">Varnishstats <small></small></h3>
                        </div><!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="varnishStatTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id='varnishStatTableBody'>
                                        <tr><td>MAIN.uptime</td><td></td></tr>
                                        <tr><td>MAIN.cache_hit</td><td></td></tr>
                                        <tr><td>MAIN.cache_hitpass</td><td></td></tr>
                                        <tr><td>MAIN.cache_miss</td><td></td></tr>
                                        <tr><td>MAIN.s_sess</td><td></td></tr>
                                        <tr><td>MAIN.s_req</td><td></td></tr>
                                        <tr><td>MAIN.s_pipe</td><td></td></tr>
                                        <tr><td>MAIN.s_pass</td><td></td></tr>
                                        <tr><td>MAIN.s_fetch</td><td></td></tr>
                                        <tr><td>MAIN.s_error</td><td></td></tr>
                                        <tr><td>MAIN.backend_conn</td><td></td></tr>
                                        <tr><td>MAIN.backend_unhealthy</td><td></td></tr>
                                        <tr><td>MAIN.backend_busy</td><td></td></tr>
                                        <tr><td>MAIN.backend_fail</td><td></td></tr>
                                        <tr><td>MAIN.backend_reuse</td><td></td></tr>
                                        <tr><td>MAIN.backend_toolate</td><td></td></tr>
                                        <tr><td>MAIN.backend_recycle</td><td></td></tr>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->


            </div><!-- /.row -->


            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="Historical Cache Hit Rate Last Hour">
                            <!-- tools box -->
                            <div class="pull-right box-tools"><span>Realtime</span>
                                <div class="btn-group" id="hitratio-realtime" data-toggle="btn-toggle">
                                    <button type="button" class="btn btn-primary btn-sm active" data-toggle="on">On</button>                                            
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="off">Off</button>
                                </div>

                                <button class="btn btn-primary btn-sm refresh-btn" id='hitratio-historical-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                                                                <button class="btn btn-default" id="daterange-btn">
                                    <i class="fa fa-calendar"></i> Date range picker
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div><!-- /. tools -->
                            <i class="fa fa-bar-chart-o"></i>
                            <h3 class="box-title">Historical Cache Hits <small>last hour</small></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="hitratio-historic-div" style="height: 300px;"></div>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->
            <div id="hitratio-historic-tooltip"></div>




        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php include("scripts.php"); ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/0.9.16/socket.io.min.js"></script>

<!-- jquery section -->

        <script>

                var socket = io.connect('', {
                /* Pass the authentication token as a URL parameter */
                    query: $.param({token: 'randomtoken'})
                /* My application is more complicated, so I use jQuery's .param utility to convert the Object to an URL string e.g. 'token=abc&etc=cde' */
                });

          

            $(function() {
                var webSiteArray = <?php echo json_encode($PAGE_CHECK_WEBSITES); ?>;
                var hitratio_current_page = '<?php echo PAGE_HITRATIO_CURRENT; ?>';
                var hitratio_historical_page = '<?php echo PAGE_HITRATIO_HISTORICAL; ?>';
                var serverInfoStats = '<?php echo SERVER_STATS; ?>';
                var websiteChecker = '<?php echo WEBSITE_CHECKER; ?>';
                var varnishstat_page = '<?php echo PAGE_VARNISHSTAT; ?>';
                var vlsList = '<?php echo PAGE_VCLS; ?>';

                var hitRateHistoricalUpdateInterval = 60000; //Fetch data ever x milliseconds
                var hitRateHistoricalRealtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
                var serverStatsRefreshInterval = 60000;
                var serverStatsRealtime = "on"; //If == to on then fetch data every x seconds. else stop fetching

                var oTable = initVarnishStatTable();


                var historyStart = moment().subtract('hour',1);
                var historyEnd = moment();

                $('#daterange-btn').daterangepicker({
                    timePicker: true,
                    startDate: moment().subtract('hour',1),
                    endDate: moment(),
                    ranges: {
                        'Last Hour': [moment().subtract('hour',1), moment()],
                        'Last 30 days': [moment().subtract('days', 29), moment()]
                    }
                },
                function(start, end) {
                    if (moment(start.format('YYYY-MM-DD HH:mm')).fromNow() == 'an hour ago') {
                        console.log('>>>Selected an hour ago');
                        hitratio_historical_page = '<?php echo PAGE_HITRATIO_HISTORICAL; ?>';
                    } else if (moment(start.format('YYYY-MM-DD HH:mm')).fromNow() == 'a month ago') {
                        console.log('>>>Selected an month ago');
                        hitratio_historical_page = '<?php echo PAGE_HITRATIO_HISTORICAL_MONTH; ?>';
                    } else {
                        console.log('>>>Selected custom date');
                    }
                    historyStart = start.format('YYYYMMDD HH:mm');
                    historyEnd = end.format('YYYYMMDD HH:mm');
                    console.log('>>>> from now : ' + moment(start.format('YYYY-MM-DD HH:mm')).fromNow());
                    console.log("You chose: " + start.format('YYYYMMDD HH:mm') + ' - ' + end.format('YYYYMMDD HH:mm'));
                    HitRatioHistoricData()
                });
                $('#daterange-btn').val('');



                // website status checker
                function updateWebsiteStatus() {
                    $.each(webSiteArray, function(websiteNumber, websiteAddr) {

                        var jqxhr = $.ajax( {
                            url: websiteChecker + websiteAddr,
                            type: 'GET',
                            async: true,
                            dataType: "json",
                            beforeSend: function(xhr) {
                                console.log("Web check creating knobs : " + websiteAddr);
                                $("#website-status-container").append('<div class="col-md-4 text-center" style="border-right: 1px solid #f4f4f4"> \
                                    <input type="text" id="website-'+websiteNumber+'" class="knob knobwebstatus" data-thickness="0.3" data-displayInput="false" data-readonly="true" data-width="100" data-height="100" data-fgColor="#CCCC00" value="100"/> \
                                    <div class="knob-label">'+websiteAddr+'</div> \
                                    </div>');
                                $('#website-'+websiteNumber).knob({
                                        'draw' : function () {  this.o.fgColor=$('#website-'+websiteNumber).attr('data-fgColor');}
                                    }
                                );

                            },
                            crossDomain: true
                        } )
                            .done(function(data) {
                                console.log("Web check success : " + websiteAddr + ' : ' + data[0][1]);
                                if (data[0][1] == "available") {
                                    $('#website-'+websiteNumber).attr('data-fgColor', 'green').trigger("change");
                                    console.log('Web Check updating to green for : ' + websiteAddr);
                                } else {
                                    $('#website-'+websiteNumber).attr('data-fgColor', 'red').trigger("change");
                                    console.log('Web Check updating to red for : ' + websiteAddr);
                                }
                            })
                            .fail(function() {
                                console.log("Web check fail : " + websiteAddr);
                            })
                            .always(function() {
                                console.log("Web check always : " + websiteAddr);
                            });
                    });
                };

                $('#website-status-refresh').click(function() {
                    console.log('Website status refresh');
                    $("#website-status-container").empty();
                    updateWebsiteStatus();
                });

                // end website status checker

                // Hit ratio checker


                function UpdateHitRatioCurrent() {
                    console.log('Hit Ratio Current collecting @ ' + hitratio_current_page);
                    $.getJSON( hitratio_current_page, function( data ) {
                        var num = new Number(parseFloat(data[0].CacheHitRatio));
                        var n = num.toPrecision(4);
                        $("#hitratio-current-knob").val(n);
                        $("#hitratio-current-knob").knob();
                        console.log( "Hit Ratio current ( " + data[0].CacheHitRatio + " ) data at " + new Date() );
                    })
                    .fail(function() {
                        console.log( "Hit Ratio current Error obtaining current Hit Ratio data at " + new Date() );
                    })
                    .always(function( data ) {
                        console.log( "Hit Ratio current Collected current Hit Ratio ( " + data[0].CacheHitRatio + " ) data finished at " + new Date() );
                    });
                }

                $('#hitratio-current-refresh').click(function() {
                    console.log('Hit Ratio current refresh');
                    UpdateHitRatioCurrent();
                });

                // Hit ratio checker end


                /*
                 * Flot Interactive Chart
                 * -----------------------
                 */
                
                var hitRatioHistoricData = [];
                // var data1month = [];
                var hitRatioHistoricDataDetails = [
                    {
                        data: hitRatioHistoricData,
                        lines: {
                            show: true,
                            fill: false
                        },
                        points: {
                            show: true,
                            fillColor: '#AA4643'
                        },
                        color: '#AA4643'
                     }
                ];

                function HitRatioHistoricData() {
                    console.log('Collecting from ' + hitratio_historical_page);

                    console.log('>>>>>>>> ' + historyStart + ' >>>>>>>>> ' + historyEnd );
                    $.getJSON( hitratio_historical_page, function( data ) {
                        hitRatioHistoricData.length = 0;
                       
                        $.each( data, function( key, val ) {
                            hitRatioHistoricData.push([val.EntryDate * 1000 , val.CacheHitRatio]);
                            
                        });
                        hitRatioHistorical_plot.setData(hitRatioHistoricDataDetails);
                        // Since the axes change, we need to call plot.setupGrid()
                        hitRatioHistorical_plot.setupGrid();
                        hitRatioHistorical_plot.draw();
                        console.log( "Collected historical Hit Ratio data at " + new Date() );
                    })
                    .fail(function() {
                        console.log( "Error obtaining historical Hit Ratio data at " + new Date() );
                    })
                    .always(function() {
                        console.log( "Collected historical Hit Ratio finished data at " + new Date() );
                    });
                }


                var hitRatioHistorical_plot = $.plot("#hitratio-historic-div", [hitRatioHistoricDataDetails], {
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
                        //min: 0,
                        //max: 100,
                        show: true
                    },
                    xaxis: {
                        mode: "time",
                        show: true
                    }
                });


                function hitRatioHistoricShowToolTip(x, y, contents) {
                    $('<div id="hitratio-historic-tooltip">' + contents + '</div>').css({
                        top: y - 45,
                        left: x - 50
                    }).appendTo('body').fadeIn();
                }
                 
                var previousPoint = null;
                 
                $('#hitratio-historic-div').bind('plothover', function (event, pos, item) {
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;
                            $('#hitratio-historic-tooltip').remove();
                            var x = item.datapoint[0],
                                y = item.datapoint[1];
                            hitRatioHistoricShowToolTip(item.pageX, item.pageY, y + '% Hit ratio @ ' + new Date(x));
                        }
                    } else {
                        $('#hitratio-historic-tooltip').remove();
                        previousPoint = null;
                    }
                });


                

                function hitRatioHistoricalUpdate() {
                    HitRatioHistoricData();
                    if (hitRateHistoricalRealtime === "on") {
                        console.log('realtime button set timer : '  + hitRateHistoricalRealtime);
                        setTimeout(hitRatioHistoricalUpdate, hitRateHistoricalUpdateInterval);
                    }
                }

                //INITIALIZE REALTIME DATA FETCHING
                if (hitRateHistoricalRealtime === "on") {
                    hitRatioHistoricalUpdate();
                }

                //REALTIME TOGGLE
                $("#hitratio-realtime .btn").click(function() {
                    if ($(this).data("toggle") === "on") {
                        hitRateHistoricalRealtime = "on";
                        hitRatioHistoricalUpdate();
                    }
                    else {
                        hitRateHistoricalRealtime = "off";
                    }
                    console.log('realtime button clicked : ' + $(this).data("toggle") + ' now : ' + hitRateHistoricalRealtime);
                });

                $('#hitratio-historical-refresh').click(function() {
                    console.log('Hit Ratio historical refresh');
                    HitRatioHistoricData();
                });

                /*
                 * END INTERACTIVE CHART
                 */

                // setup knobs for Server performance with custom colours
                $('.server-info-knob').knob({
                        'draw' : function (v) {
                            if (this.v >= 80) {
                                this.o.fgColor='red';
                                console.log('Set knob color to Critical');
                            } else if (this.v >= 60) {
                                this.o.fgColor='#FF6600';
                                console.log('Set knob color to Amber');
                            } else {
                                this.o.fgColor='green';
                                console.log('Set knob color to Green');
                            }
                        }
                    }
                );
                // end setup knobs for Server performance with custom colours

                function serverInfoUpdate() {
                    console.log('Collecting server info');
                    $.getJSON( serverInfoStats, function( data ) {
                        $('#server-info-cpu-knob').val(data.CPU).trigger('change');
                        $('#server-info-disk-knob').val(data.Disk).trigger('change');
                        $('#server-info-memory-knob').val(data.Memory).trigger('change');
                        console.log( "Server status info CPU ( " + data.CPU + " ) Memory ( " + data.Memory + " ) Disk ( " + data.Disk + " ) data at " + new Date() );
                    })
                    .fail(function() {
                        console.log( "Server status info Error obtaining current stats " + new Date() );
                    })
                    .always(function( data ) {
                        console.log( "Server status info finished at " + new Date() );
                    });
                }


                function serverStatsHistoricalUpdate() {
                    serverInfoUpdate();
                    if (serverStatsRealtime === "on") {
                        console.log('realtime button set timer : ' + serverStatsRefreshInterval + ' : ' + serverStatsRealtime);
                        setTimeout(serverStatsHistoricalUpdate, serverStatsRefreshInterval);
                    }
                }

                //INITIALIZE REALTIME DATA FETCHING
                if (serverStatsRealtime === "on") {
                   serverStatsHistoricalUpdate();
                }


                function varnishStatUpdate() {
                    console.log('Varnishstat details gather start');
                    $.getJSON( varnishstat_page, function( data ) {
                        console.log('Varnishstat details gathered');
                        oTable.fnUpdate( [data["uptime"].description,                 data["uptime"].value], 0, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["cache_hit"].description,              data["cache_hit"].value ], 1, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["cache_hitpass"].description,          data["cache_hitpass"].value], 2, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["cache_miss"].description,             data["cache_miss"].value], 3, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["s_sess"].description,                 data["s_sess"].value], 4, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["s_req"].description,                  data["s_req"].value], 5, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["s_pipe"].description,                 data["s_pipe"].value], 6, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["s_pass"].description,                 data["s_pass"].value], 7, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["s_fetch"].description,                data["s_fetch"].value], 8, undefined, false, false ); // Row
                        //oTable.fnUpdate( [data["s_error"].description,                data["s_error"].value], 9, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_conn"].description,           data["backend_conn"].value], 10, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_unhealthy"].description,      data["backend_unhealthy"].value], 11, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_busy"].description,           data["backend_busy"].value], 12, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_fail"].description,           data["backend_fail"].value], 13, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_reuse"].description,          data["backend_reuse"].value], 14, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_toolate"].description,        data["backend_toolate"].value], 15, undefined, false, false ); // Row
                        oTable.fnUpdate( [data["backend_recycle"].description,        data["backend_recycle"].value], 16, undefined, false, false ); // Row
                    })
                    .fail(function() {
                        console.log('Varnishstat details gather failed');
                    })
                    .always(function( data ) {
                        // console.log('Varnishstat details gather always');
                    });
                }

                
                $('#varnishstat-current-refresh').click(function() {
                    console.log('Varnish stat refresh clicked');
                    varnishStatUpdate();
                });



                function initVarnishStatTable() {
                        return $('#varnishStatTable').dataTable({
                            "bPaginate": true,
                            "bLengthChange": false,
                            "bFilter": false,
                            "bSort": false,
                            "bInfo": false,
                            "bAutoWidth": false,
                            "bDestroy": true,
                            "bLengthChange": true,
                            "iDisplayLength": 10,
                            "scrollY": 300

                        });
                }








                $(document).ready(function(){
                    updateWebsiteStatus();
                    UpdateHitRatioCurrent();
                    serverInfoUpdate();
                    varnishStatUpdate();

                }); 

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
