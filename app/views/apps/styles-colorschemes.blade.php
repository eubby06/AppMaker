<div class="color-scheme js-color-scheme-block"> 

    <div class="row schemes js-color-schemes-container">
        <h4>Color Schemes</h4>

        <script id="js-color-scheme-template" type="text/x-handlebars-template">
            @{{#each schemes}}
            <div class="scheme">
                @{{#if this.selected}}
                    <a href="#x" class="thumbnail selected js-scheme" data-id="@{{ this.id }}">
                @{{else}}
                    <a href="#x" class="thumbnail js-scheme" data-id="@{{ this.id }}">
                @{{/if}}
                
                <button disabled data-color="@{{ this.values.background }}" class="btn js-color-box js-background btn-flat"></button>
                <button disabled data-color="@{{ this.values.title }}" class="btn js-color-box js-title btn-flat"></button>
                <button disabled data-color="@{{ this.values.text }}" class="btn js-color-box js-text btn-flat"></button>
                <button disabled data-color="@{{ this.values.accent }}" class="btn js-color-box js-accent btn-flat"></button>
                <button disabled data-color="@{{ this.values.link }}" class="btn js-color-box js-link btn-flat"></button>
                <button disabled data-color="@{{ this.values.border }}" class="btn js-color-box js-border btn-flat"></button>

                </a>
            </div>
            @{{/each}}
        </script>

    </div>
    
    <div class="row colors js-colors-container">
        <h4>Content Colors</h4>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Content backgrounds
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-background"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Titles
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-title"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Main texts
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-text"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Minor texts
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-accent"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Buttons & links
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-link"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

        <div class="col-md-4 color">
            <!-- Color Picker -->
            Borders
            <div class="input-group js-color-picker">
                <input type="text" class="form-control js-border" value="#fff"/>
                <div class="input-group-addon">
                    <i></i> 
                </div>
            </div><!-- /.input group -->
        </div>

    </div>

    <div class="js-modal-container"></div>

    <div class="row background js-backgrounds">

            <div class="col-md-10 js-background-container">
                <h4>Page Background</h4>
                <script id="js-background-template" type="text/x-handlebars-template">
                @{{#each backgrounds}}
                    <div class="col-md-3">
                        <a href="#x" class="thumbnail js-background @{{#if this.selected}} selected @{{/if}}" data-id="@{{ this.id }}">
                            <img src="<?= asset('img/background/{{ this.file }}.png') ?>" alt="Image" style="max-width:100%;" />
                        </a>
                    </div>
                @{{/each}}
                </script> 
            </div>

            <div class="col-md-2">
                <h4>Upload</h4>
                <div class="col-md-3">
                    <a href="#x" class="thumbnail js-uploader-btn background-uploader-btn">
                        <img src="http://spinn.dev/img/background/uploader-btn.png" alt="Image" style="max-width:100%;" />
                    </a>
                </div>
            </div>
    </div>
</div><!--/well-->   

<!-- modal for image upload -->
<div class="modal fade js-background-uploader-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Upload Background Image</h3>
          </div>
          <div class="modal-body">

            <form name="MyUploadForm" action="{{ url('server/uploader.php') }}" method="post" enctype="multipart/form-data" id="MyUploadForm">
                <div class="box box-primary">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8"> For smartphones: </div>
                                <div class="col-md-4"> <div id="container_image_mobile"></div> </div>
                            </div>
                        </div>
                </div>
                <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8"> For tablets: </div>
                                <div class="col-md-4"> <div id="container_image_tablet"></div> </div>
                            </div>
                        </div>

                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
              </div>
          </form>
        </div>
      </div>
</div> 
