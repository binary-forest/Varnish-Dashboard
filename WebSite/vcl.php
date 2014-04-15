<?php include("header.php"); ?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">                
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Varnish Dashboard <small>Current</small></h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">VCL</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="VCL Editor">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <!-- <button class="btn btn-primary btn-sm refresh-btn" id='vcl-list-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button> -->
                                <button class="btn btn-primary btn-sm" id='vcl-delete-entry' data-toggle="tooltip" title="Delete VCL File"><i class="fa fa-unlink"></i></button>
                                <button class="btn btn-primary btn-sm" id='vcl-new-entry'  data-toggle="modal"  data-target="#myModal" title="New VCL File"><i class="fa fa-save"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-globe"></i>
                            <h3 class="box-title">VCL Editor </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="vcl-textarea" name="my-xml-editor" data-editor="vcl" rows="0" cols="0">
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="list-group" id="snippet-list">
<!--                                         <a href="#" data-snippet='default' class="snippet-item list-group-item active">Default VCL</a>
                                        <a href="#" data-snippet='hotlinks' class="snippet-item list-group-item">Hot links</a>
                                        <a href="#" data-snippet='normaliseurl' class="snippet-item list-group-item">Normalise URLs</a>
                                        <a href="#" data-snippet='virtualhost' class="snippet-item list-group-item">Virtual Host</a>
                                        <a href="#" data-snippet='backend' class="snippet-item list-group-item">Backend</a> -->
                                    </div>
                                </div>
                                <div class="col-md-8"><div id="vcl-snippet" name="my-xml-editor" data-editor="vcl" rows="0" cols="0">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body-->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="VCL configuration files">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-primary btn-sm refresh-btn" id='vcl-list-refresh' data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                
                                <button class="btn btn-primary btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-file-o"></i>
                            <h3 class="box-title">VCL <small></small></h3>
                        </div><!-- /.box-header -->


                        <div class="panel-group" id="vcl-accordion">
                        </div>


                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Create New VCL Entry</h4>
      </div>
      <div class="modal-body">
            <form role="form" id='newVCLForm' >
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">VCL Name</label>
                        <input type="text" class="form-control" id="inputVCLName" placeholder="VCL Name">
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" id='vclCreate' class="btn btn-primary" data-dismiss="modal">Create VCL</button>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include("scripts.php"); ?>


<script src="js/ace/ace.js"></script>
<!-- jquery section -->
<script>
    var editor;
    var snippet;
    var editorDefaultHeight = "500px";
    var editVCLName = "";
    var fileContent = "";

    var snippetPage = '<?php echo PAGE_VCL_SNIPPET; ?>';
    var snippetsPage = '<?php echo PAGE_VCL_SNIPPETS; ?>';
    var vclPage = '<?php echo PAGE_VCL; ?>';
    var vclList = '<?php echo PAGE_VCLS; ?>';
    var vclPageDelete = '<?php echo PAGE_VCLDELETE; ?>';

    function getVCL(vclName) {
        console.log('update editor for vcl : ' + vclName );
        $.getJSON( vclList, function( data ) {
            editor.setValue("");
            $.each( data, function( key, val ) {
                if (val[2] == vclName) {
                    editor.insert(val[3]);
                    editor.scrollToLine(0,false,false);
                }
            });
            console.log( ">>vcl finish");
        })
        .fail(function() {
            console.log( ">>>vcl fail" );
        })
        .always(function() {
            console.log( ">>>vcl always" );
        });

    }

    $('#vcl-list-refresh').click(function() {
        console.log('Refreshing vcl');
        getVCL();
    })

    function getSnippets() {
        $.getJSON( snippetsPage, function( data ) {
            $('#snippet-list').empty();
            $.each( data, function( key, val ) {
                console.log(">>>>>> " + key + " >>>>> " + val + " <<<<<<");
                $('#snippet-list').append('<a href="#" data-snippet="'+val+'" class="snippet-item list-group-item">'+val+'</a>');
            });
            console.log( ">>snippet finish");
        })
        .fail(function() {
            console.log( ">>>snippet fail" );
        })
        .always(function() {
            console.log( ">>>snippet always" );
        });

    }

    getSnippets();
    getVCLs();


    $('#snippet-list').click(function() {
        var snippetClicked = $(this).data('snippet');
        $('#snippet-list').children('a').each(function () {
            $(this).removeClass('active');
        });

        console.log('snippet cliced on : ' + event.target.text + ':' + snippetPage + snippetClicked);
        event.target.className += " active";
        $.getJSON( snippetPage + event.target.text, function( data ) {
            snippet.setValue("");
            // console.log('data: ' + data);
            snippet.insert(data);
            snippet.scrollToLine(0,false,false);
            console.log( ">>vcl finish");
        })
        .fail(function() {
            console.log( ">>>vcl fail" );
        })
        .always(function() {
            console.log( ">>>vcl always" );
        });
    })

    $(function () {
            editor = ace.edit('vcl-textarea');
            editor.renderer.setShowGutter(true);
            editor.getSession().setValue('');
            editor.setPrintMarginColumn(false);

            editor.setTheme("ace/theme/monokai");
            editor.getSession().setMode("ace/mode/vcl");

            editor.session.setUseWrapMode(true);
            editor.session.setWrapLimitRange(null, null);

            // console.log(editor);
            // // copy back to textarea on form submit...
            // textarea.closest('form').submit(function () {
            //     textarea.val(editor.getSession().getValue());
            // })

            snippet = ace.edit('vcl-snippet');
            snippet.renderer.setShowGutter(true);
            snippet.getSession().setValue('');
            snippet.setPrintMarginColumn(false);

            snippet.setTheme("ace/theme/monokai");
            snippet.getSession().setMode("ace/mode/vcl");

            snippet.session.setUseWrapMode(true);
            snippet.session.setWrapLimitRange(null, null);

            // console.log(snippet);
    });

//

    function getVCLs() {
        $.getJSON( vclList, function( data ) {
            $('#vcl-accordion').empty();
            $.each( data, function( key, val ) {
                console.log(">>>>>> " + key + " >>>>> " + val[2] + " <<<<<<");
                if (val[0] == 'active') { panelclass='success';} else {panelclass='default';}

                if (val[0] == 'available') {
                   var editBox = '<a href="#" data-vcltype="'+val[0]+'" title="Activate" data-vclname="'+val[2]+'"><i class="fa fa-check"></i></a><a href="#" data-vcltype="'+val[0]+'" title="Edit" data-vclname="'+val[2]+'"><i class="fa fa-pencil"></i></a></span>';
                } else {
                    var editBox = '<a href="#" data-vcltype="'+val[0]+'" title="Edit" data-vclname="'+val[2]+'"><i class="fa fa-pencil"></i></a></span>';
                }
                $('#vcl-accordion').append('\
              <div class="panel panel-'+panelclass+'"> \
                <div class="panel-heading"> \
                  <span class="pull-right"> \
                  '+editBox+' \
                  <h4 class="panel-title"> \
                    <a data-toggle="collapse" data-parent="#vcl-accordion" href="#vcl-'+val[2]+'-collapse"> \
                      ' + val[2] + ' <small>' + val[0] + '</small> \
                    </a> \
                  </h4> \
                </div> \
                <div id="vcl-'+val[2]+'-collapse" class="panel-collapse collapse out"> \
                  <div class="panel-body"> \
                    <pre>\
' + val[3] + ' \
                    </pre> \
                  </div> \
                </div> \
              </div> \
                    ')
            });
            console.log( ">>vcl finish");
        })
        .fail(function() {
            console.log( ">>>vcl fail" );
        })
        .always(function() {
            console.log( ">>>vcl always" );
        });

    }

    function activateVCL(vclName) {
        console.log('>>>>Activating ' + vclName);
    }

    $('#vcl-accordion').click(function() {
        var snippetClicked = $(event.target).parent().data('vclname');
        var snippetTypeClicked = $(event.target).parent().data('vcltype');

        
        if ($(event.target).is('i')) {
            editVCLName = [snippetClicked,snippetTypeClicked];
            console.log('edit : ' + snippetClicked + ' : ' + snippetTypeClicked);
            if (event.target.className == 'fa fa-check') {
                if (snippetTypeClicked == 'available') {
                    console.log('>>is available for activation');
                    activateVCL(snippetClicked);
                }
            } else {
                getVCL(snippetClicked);
            }
        }

    })

    $('#vcl-new-entry').click(function(){
        console.log('new VCL file required');


    })

    $('#vclCreate').click(function() {
        console.log( 'data : ' + $('#inputVCLName').val());

        var jqxhr = $.ajax( {
            url: vclPage + $('#inputVCLName').val(),
            type: 'POST',
            data: JSON.stringify({
                "vclName": $('#inputVCLName').val(),
                "vclContent": '' + editor.getSession().getValue()
                }),
            async: true,
            crossDomain: true,
            dataType: "json"
        } )
        .done(function(data) {
            console.log('data: ' + data);

            getVCLs();
        })
        .fail(function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("post failed : " + textStatus + ' : ' + errorThrown)
        })
        .always(function() {
            console.log("post always");
        });

        editVCLName = [$('#inputVCLName').val(), 'file'];
        // http://stats.codeblack.eu:8080/vcl/new/test
        $( '#newVCLForm' ).each(function(){
            this.reset();
        });
    })


    $('#vcl-delete-entry').click(function() {
        console.log('Deleting VCL entry :' + editVCLName[0] + ' type : ' + editVCLName[1]);

        var jqxhr = $.ajax( {
            url: vclPageDelete+editVCLName[0],
            type: 'POST',
            data: JSON.stringify({
                "vclName": editVCLName[0],
                "vclType": editVCLName[1]
                }),
            async: true,
            crossDomain: true,
            dataType: "json"
        } )
        .done(function(data) {
            console.log('data: ' + data);

            getVCLs();
        })
        .fail(function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("post failed : " + textStatus + ' : ' + errorThrown)
        })
        .always(function() {
            console.log("post always");
        });

        editVCLName = [$('#inputVCLName').val(), 'file'];
        // http://stats.codeblack.eu:8080/vcl/new/test
        $( '#newVCLForm' ).each(function(){
            this.reset();
        });

    })


    $('#vcl-list-refresh').click(function() {
        console.log('Refreshing vcl ');
        getVCLs();
    })


</script>

<!-- end jquery section -->

<?php include("footer.php"); ?>