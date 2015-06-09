<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aspect Ratio with Preview Pane | Jcrop Demo</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

{{ HTML::script('js/plugins/jcrop/jquery.min.js') }}
{{ HTML::script('js/plugins/jcrop/jquery.Jcrop.js') }}

</script>
{{ HTML::style('test/jcrop/main.css') }}
{{ HTML::style('test/jcrop/demos.css') }}
{{ HTML::style('css/jcrop/jquery.Jcrop.css') }}

<style type="text/css">

/* Apply these styles only when #preview-pane has
   been placed within the Jcrop widget */
.jcrop-holder #preview-pane {
  display: block;
  position: absolute;
  z-index: 2000;
  top: 10px;
  right: -280px;
  padding: 6px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;

  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;

  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}

/* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
#preview-pane .preview-container {
  width: 160px;
  height: 240px;
  overflow: hidden;
}

</style>

</head>
<body>

<div class="container">
  <div class="row">
    <div class="span12">
      <div class="jc-demo-box">

        <img src="test/jcrop/sago.jpg" id="target" class="original" alt="[Jcrop Example]" />

        <div id="preview-pane">
          <div class="preview-container">
            <img src="test/jcrop/sago.jpg" class="jcrop-preview" alt="Preview" />
          </div>
        </div>

      </div>
    </div>
  </div>

  <h2>Avatar Upload</h2>
   
  <form id="upload">
      <p>
          <input type="file" name="mobileImage" class="js-file" />
      </p>
  </form>

  <div class="jc_coords">
    <form action="image/crop" method="post" onsubmit="return checkCoords();">
      <input type="hidden" id="x" name="x" />
      <input type="hidden" id="y" name="y" />
      <input type="hidden" id="w" name="w" />
      <input type="hidden" id="h" name="h" />
      <input type="hidden" name="filename" class="filename" value=""/>
      <input type="submit" value="Crop Image" style="float:left; width: 98px;" />
    </form>
  </div>

</div>

<script type="text/javascript">

$('.js-file').on('change', function() {
    $('#upload').trigger('submit');
});

$( '#upload' ).on('submit', function( e ) {

    $.ajax({
      url: 'image/upload',
      type: 'POST',
      data: new FormData( this ),
      processData: false,
      contentType: false,
      success: function (res) {
        $('.original').attr('src', 'uploads/' + res);
        $('.jcrop-preview').attr('src', 'uploads/' + res);
        $('input.filename').val(res);

        // Create variables (in this scope) to hold the API and image size
        var jcrop_api,
            boundx,
            boundy,

            // Grab some information about the preview pane
            $preview = $('#preview-pane'),
            $pcnt = $('#preview-pane .preview-container'),
            $pimg = $('#preview-pane .preview-container img'),

            xsize = $pcnt.width(),
            ysize = $pcnt.height();

        $('#target').Jcrop({
          onChange: updatePreview,
          onSelect: updatePreview,
          aspectRatio: xsize / ysize,
          boxWidth: 450,
          aspectRatio: 4 / 6
        },function(){
          // Use the API to get the real image size
          var bounds = this.getBounds();
          boundx = bounds[0];
          boundy = bounds[1];
          // Store the API in the jcrop_api variable
          jcrop_api = this;

          // Move the preview into the jcrop container for css positioning
          $preview.appendTo(jcrop_api.ui.holder);
        });

        function updateCoords(c)
        {
          jQuery('#x').val(Math.floor(c.x));
          jQuery('#y').val(Math.floor(c.y));
          jQuery('#w').val(Math.floor(c.w));
          jQuery('#h').val(Math.floor(c.h));
        };

        function updatePreview(c)
        {
          updateCoords(c);

          if (parseInt(c.w) > 0)
          {
            var rx = xsize / c.w;
            var ry = ysize / c.h;

            $pimg.css({
              width: Math.round(rx * boundx) + 'px',
              height: Math.round(ry * boundy) + 'px',
              marginLeft: '-' + Math.round(rx * c.x) + 'px',
              marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
          }
        };

        function checkCoords()
        {
          if (parseInt(jQuery('#w').val())>0) return true;
          alert('Please select a crop region then press submit.');
          return false;
        };

      }
    });

    e.preventDefault();
});
</script>
</body>
</html>

