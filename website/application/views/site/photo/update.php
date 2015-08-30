<script src="/_js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/_css/jquery.Jcrop.min.css" type="text/css" />
<div class="upload_image">
    <form action="{form_update_action}" method="post" id="upload_image">
    <input type="hidden" id="x" name="x" />
    <input type="hidden" id="y" name="y" />
    <input type="hidden" id="w" name="w" />
    <input type="hidden" id="h" name="h" />
    <input type="hidden" id="GUID" name="GUID" />
    <div class="photo_update  clearfix">
        <div class="fl tc">
            <div id="preview" style="max-width: 500px; max-height: 500px;">
                <img src="/_images/null_face.jpg" id="target" />
            </div>
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>{btn_add_photo}</span>
        <input type="file" id="uploadImage" name="userfile" multiple="">
    </span>
            <?php echo $error;?>
        </div>

        <div class="fr tc">
            <div id="crop-pane">
              <div class="crop-container">
                    <img src="/_images/null_face.jpg" class="jcrop-preview" alt="Preview" />
              </div>
            </div>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>{btn_start_upload}</span>
            </button>
            <br>

        </div>
    </div>
    </form>
</div>
<script>
$(function(){
    // The variable jcrop_api will hold a reference to the
    // Jcrop API once Jcrop is instantiated.
    var jcrop_api,
        boundx,
        boundy,
        // Grab some information about the preview pane
        $preview = $('#crop-pane'),
        $pcnt = $('#crop-pane .crop-container'),
        $pimg = $('#crop-pane .crop-container img'),
        xsize = $pcnt.width(),
        ysize = $pcnt.height();

    // In this example, since Jcrop may be attached or detached
    // at the whim of the user, I've wrapped the call into a function
    //initJcrop();
    
    // The function is pretty simple
    function initJcrop()//{{{
    {
      // Hide any interface elements that require Jcrop
      // (This is for the local user interface portion.)
      $('.requiresjcrop').hide();

      // Invoke Jcrop in typical fashion
      $('#target').Jcrop({
        onChange: updatePreview,
        onSelect: updateCoords,
        allowSelect: true,
        //setSelect: [ 0, 0, 200, 240 ],
        aspectRatio: xsize / ysize
      },function(){
      // Use the API to get the real image size
          var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];

        jcrop_api = this;
        $pimg = $('#crop-pane .crop-container img');
        jcrop_api.setSelect([ 10, 10, 210, 250 ]);
      });
    }
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    function updatePreview(c)
    {
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
    }
    // This function is bound to the onRelease handler...
    // In certain circumstances (such as if you set minSize
    // and aspectRatio together), you can inadvertently lose
    // the selection. This callback re-enables creating selections
    // in such a case. Although the need to do this is based on a
    // buggy behavior, it's recommended that you in some way trap
    // the onRelease callback if you use allowSelect: false
    function releaseCheck()
    {
        jcrop_api.setOptions({ allowSelect: true });
    };
    $('#uploadImage').change(function(){
        
        $('#upload_image').attr('action' , '{form_action}');

        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
    
        oFReader.onload = function(oFREvent) {
            if(jcrop_api){
                 $('#target').attr('style', ''); 
                jcrop_api.destroy();
            }
            
            //$('#target').attr('src' , oFREvent.target.result);
            $('#preview').html('<img id="target" src="'+oFREvent.target.result+'">');
            $pcnt.html('<img src="'+oFREvent.target.result+'" class="jcrop-preview" >');
            setTimeout(function(){
                initJcrop();
            });
        };
    });
    if(jcrop_api){
         $('#target').attr('style', ''); 
        jcrop_api.destroy();
    }
    $full_image_url = '{full_image_url}';
    $('#target').attr('src' , $full_image_url );
    // $('#preview').html('<img id="target" src="'+oFREvent.target.result+'">');
    $pcnt.html('<img src="'+$full_image_url+'" class="jcrop-preview" >');
    initJcrop();
});
	
</script>