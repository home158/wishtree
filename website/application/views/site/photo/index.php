<script src="/_js/jquery.popupwindow.js"></script>
<div id="content">
    <div class="bg photo_set clearfix">
        <div class="msg deal_msg">
            <p class="hd"></p>
        </div>
        <div class="well well-lg">
            <p class="redF hd "></p>  
            <div class="block-wrapper clearfix">
                    <ul class="tabs general" >
                        <li class="{active_public}">
                            <a href="/photo/public" class="ctrl" data-load="main_content">{photo_upload_public}</a>
                        </li>
                        <li class="{active_private}">
                            <a href="/photo/private" class="ctrl" data-load="main_content">{photo_upload_private}</a>
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
            <p class="">根據我們的經驗。附有照片的個人資料，將比沒有照片的個人資料接收多達10倍以上的關注度，所以我們強烈建議您上傳一張照片。</p>
            
            <div class="tc">
                <span class="btn btn-success" id="upload_photo">
                    <span>{btn_upload_photo}</span>
                </span>
            </div>

        </div>
    </div>
</div>
<script>
$(function(){
    $('img.update_image').bind('click',function(){
        var $GUID = $(this).attr('data-GUID');
        $.popupWindow('/photo/update/{type}/'+$GUID, { 
            height: 620, 
            width: 820,
            createNew: true,
            onUnload: function(){
            }
        });
    });

    $('#upload_photo').bind('click',function(){
        $.popupWindow('/photo/upload/{type}', { 
            height: 620, 
            width: 820,
            createNew: true,
            onUnload: function(){
            }
        });
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