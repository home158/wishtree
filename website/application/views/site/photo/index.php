<script src="/_js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/_css/jquery.Jcrop.min.css" type="text/css" />
<div id="content">
    <div class="bg photo_set clearfix">
        <div class="msg deal_msg">
            <p class="hd">{account_update_profile}</p>
        </div>
        <div class="well well-lg">
            <p class="redF hd "></p>  
            <div class="block-wrapper clearfix">
                    <ul class="tabs general" >
                        <li class="{active_public}">
                            <a href="/photo/public" class="ctrl">{photo_upload_public}</a>
                        </li>
                        <li class="{active_private}">
                            <a href="/photo/private" class="ctrl">{photo_upload_private}</a>
                        </li>
                    </ul>
            </div>

            <div class="photo_list">
                <ul class="clearfix">
                {my_photos}
                    <li >
                        <label class="redF">{review_status}</label>
                        <div class="image-box image-box-{IsCover}"><img class="update_image" src="{thumb_image_url}" data-GUID="{db_GUID}" data-full="{full_image_url}" data-crop="{crop_image_url}"/><div class="btn-clickboard" data-GUID="{db_GUID}" >{photo_cover}</div>
                        </div>
                        <span type="button" class="delete_image btn btn-danger delete btn-sm " data-GUID="{db_GUID}" >
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>{btn_delete}</span>
                        </span>
                    
                    </li>
                {/my_photos}
                </ul>
            </div>
            <div>
                <?= form_open_multipart(base_url().'../{form_action}',array('id' => 'upload_image'));?>
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
            
           
            <p class="">根據我們的經驗。附有照片的個人資料，將比沒有照片的個人資料接收多達10倍以上的關注度，所以我們強烈建議您上傳一張照片。</p>
            
            
        </div>
    </div>
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

    $('img.update_image').bind('click',function(){
            if(jcrop_api){
                 $('#target').attr('style', ''); 
                jcrop_api.destroy();
            }
            $full_image_url = $(this).attr('data-full');
            $('#target').attr('src' , $full_image_url );
           // $('#preview').html('<img id="target" src="'+oFREvent.target.result+'">');
            $pcnt.html('<img src="'+$full_image_url+'" class="jcrop-preview" >');
            initJcrop();

            $('#upload_image').attr('action' , '{form_update_action}');
            //pull remote files
            var $GUID = $(this).attr('data-GUID');
            $('input[name="GUID"]').val($GUID);
    });
    $('button.delete_image').bind('click',function(){
        var $this = $(this);
        $this.parent().fadeOut();
        
        $.ajax({
            url: '/photo/delete',
            dataType: 'json',
            type: 'POST',
            data: {
                GUID : $this.attr('data-GUID')
            },
            success: function(r) {
                $('#upload_image').attr('action' , '/photo');
            },
            complete : function(){
                
            }
        });
        
    });
    //btn-clickboard
    $('.image-box-off').hover(function(){
        $('.btn-clickboard' , $(this)).show();
    },function(){
        $('.btn-clickboard', $(this)).hide();
    });
    $('.btn-clickboard').hover(function(){
        $(this).addClass('btn-clickboard-hover');
    },function(){
        $(this).removeClass('btn-clickboard-hover');
    }).bind('click',function(){
        
        var $this = $(this);
        $('.image-box-on').removeClass('image-box-on').addClass('image-box-off');
        $this.parent().removeClass('image-box-off').addClass('image-box-on').unbind('mouseenter mouseleave');
        $('.image-box-off .btn-clickboard').hide();

        $('.image-box-off').hover(function(){
            $('.btn-clickboard' , $(this)).show();
        },function(){
            $('.btn-clickboard', $(this)).hide();
        });
        $.ajax({
            url: '/photo/set_top',
            dataType: 'json',
            type: 'POST',
            data: {
                GUID : $this.attr('data-GUID')
            },
            success: function(r) {
                
            },
            complete : function(){
                
            }
        });
    });
});
	
</script>