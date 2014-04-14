<?php include("header.php"); ?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">                
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Varnish Dashboard <small>Current</small></h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">BANs</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="VCL configuration files">
                            <!-- tools box -->
                            <div class="pull-right box-tools">                                
                            </div><!-- /. tools -->
                            <i class="fa fa-exclamation-triangle"></i>
                            <h3 class="box-title">BAN <small>editor</small></h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Ban Details</label>
                                    <div class=" input-group">
                                        <input type="text" class="form-control" id="banRegex" placeholder="Ban expression...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger btn-flat" id="addBan" type="button">Add Ban!</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                            <br />
                            <div class="col-md-12">
                                <div id="addBanBox" class="hide box">
                                    <div class="box-header">
                                        <h3 class="box-title">Ban Status</h3>
                                    </div>
                                    <div class="box-body" id="banResults">
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-info">
                                        <div class="box-header">
                                            <h3 class="box-title">Ban examples</h3>
                                            <div class="box-tools pull-right">
                                                <div class="label bg-aqua">examples</div>
                                                <button class="btn btn-primary btn-xs" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <p>Bans are a way to invalidate content.  Bans are a way of banning certain content from being served from the cache.  You can ban based on any metadata in Varnish.
                                                Bans will only work on objects that are already in the cache.
                                            </p>
                                            <p>Bans that only match against obj.* are also processed by a background worker threads called the ban lurker.</p>
                                            <div class="callout callout-info">
                                                <h4>Ban lurker friendly ban</h4>
                                                <code>obj.http.x-url ~ /articles/</code>
                                            </div>
                                            <div class="callout callout-info">
                                                <h4>Empty the whole cache</h4>
                                                <code>req.http.url ~ /</code>
                                            </div>
                                            <div class="callout callout-info">
                                                <h4>Remove everything below articles/ on any site in the cache</h4>
                                                <code>req.http.url ~ "/articles/"</code>
                                            </div>
                                            <div class="callout callout-info">
                                                <h4>Remove all HTML content underneath a sub-URL on a virtual host</h4>
                                                <code>req.http.host ~ ".^.example.com" && req.http.url ~ "^/articles" && req.http.content-type == "text/html"</code>
                                            </div>
                                            <a href="https://www.varnish-cache.org/docs/3.0/tutorial/purging.html#bans" target="_blank" title="Ban tutorial documentation">Ban documentation</a>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                        </div><!-- /.box-footer-->
                                    </div><!-- /.box -->
                                </div>
                            </div>

                            <div class="row"> <!-- /.ban list row -->

                                <div class="col-xs-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <div class="pull-right box-tools">
                                                <button class="btn btn-primary btn-sm refresh-btn" id='banlist-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                            </div><!-- /. tools -->
                                            <h3 class="box-title">Current Ban List <small><a data-toggle="collapse" data-parent="#ban-list-accordion" href="#ban-list-collapseOne">Show/Hide</a></small></h3>
                                        </div><!-- /.box-header -->

                                        <div class="panel-group" id="ban-list-accordion">

                                          <div class="panel panel-default">
                                            <div id="ban-list-collapseOne" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="box-body table-responsive">
                                                        <table id="banlistTbl" class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Timestamp</th>
                                                                    <th>Matched</th>
                                                                    <th>Ban</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Timestamp</th>
                                                                    <th>Matched</th>
                                                                    <th>Ban</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div><!-- /.box-body -->

                                                </div>
                                            </div>
                                          </div>
                                        </div>

                                    </div><!-- /.box -->
                                </div>

                            </div> <!-- /.ban list row -->

                        </div><!-- /.box-body-->

                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<!-- Modal -->


<?php include("scripts.php"); ?>



<!-- jquery section -->

<script>

    $(function() {
        var bans_page = '<?php echo PAGE_BANLIST; ?>';
        var ban_page = '<?php echo PAGE_BAN; ?>';

        var oTable = initBanTable();
        banListUpdate();

        function initBanTable() {
            return $('#banlistTbl').dataTable({
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

        function banListUpdate() {
            console.log('Ban list start');
            $.getJSON( bans_page, function( data ) {
                console.log('ban list gathered');
                console.log(data);
                oTable.fnClearTable();
                oTable.fnAddData(data);
            })
            .fail(function() {
                console.log('ban list gather failed');
            })
            .always(function( data ) {
                console.log('ban list always');
            });
        }

        $('#banlist-refresh').click(function() {
            console.log('Ban list refresh clicked');
            banListUpdate();
        })

        $('#banRegex').keypress(function(){
            $('#addBanBox').hide("slow");
            $('#banResults').empty();
        })
        $('#banRegex').on('paste', function(){
            $('#addBanBox').hide("slow");
            $('#banResults').empty();
        })

        $('#addBan').click(function() {
            var banDetails = $('#banRegex').val();
            console.log('Adding ban :' + banDetails);

            $('#addBanBox').removeClass("hide");

            
            var jqxhr = $.ajax( {
                url: ban_page,
                type: 'POST',
                data: JSON.stringify({
                    "banRegex": banDetails
                    }),
                async: true,
                crossDomain: true,
                dataType: "json"
            } )
            .done(function(data) {
                //activate good/bad model
                if (data == '') {
                    console.log('Ban added');
                    $('#addBanBox').removeClass('box-danger');
                    $('#addBanBox').addClass('box-success');
                    $('#banResults').append('Ban was added');
                    
                } else {
                    console.log('Ban not added because : ' + data);
                    $('#addBanBox').removeClass('box-success');
                    $('#addBanBox').addClass('box-danger');
                    $('#banResults').append('Ban was not added because ' + data);
                }
                $('#addBanBox').show("slow");
                banListUpdate();
            })
            .fail(function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("post failed : " + textStatus + ' : ' + errorThrown)
            })
            .always(function() {
                console.log("post always");
            });

        })



    });

</script>

<!-- end jquery section -->

<?php include("footer.php"); ?>