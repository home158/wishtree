<script type="text/javascript" src="/_js/ekko-lightbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="/_css/ekko-lightbox.min.css">
<div id="content">
    <div class="profile_set bg clearfix">
        <div class="well well-lg clearfix">
            <div class="profile_left fl all_photo">
                <div class="cover_photo" id="cover_photo" >
                    <a href="{FullBasename}" data-title="{view_lightbox_data_title}" data-toggle="lightbox" data-gallery="A0"><img src="{CropBasename}" ></a>
                </div>
                <div class="other_photo clearfix">
                    <ul>
                    {public_photo}
                        <li><img src="{_ThumbBasename}" data-title="{view_lightbox_data_title}" data-crop="{_CropBasename}" data-full="{_FullBasename}" data-remote="{_FullBasename}" data-toggle="lightbox" data-gallery="A{IsCover}"/></li>
                    {/public_photo}
                    </ul>
                </div>
                <p>私人相片</p>
                <div class="other_photo clearfix">
                    <ul>
                    {private_photo}
                        <li><img src="{_ThumbBasename}" data-title="{view_lightbox_data_title}" data-crop="{_CropBasename}" data-full="{_FullBasename}" data-remote="{_FullBasename}" data-toggle="lightbox" data-gallery="A{IsCover}"/></li>
                    {/private_photo}
                    </ul>
                </div>
            </div>
            <div class="profile_right fr ">
                <div class="submenu">
                    <ul>
                        <li>
                            <a href="/message/write/{UserGUID}">{view_send_message}</a>
                        </li>
                        <li>
                            <a id="add_white_list" href="javascript:;" data-tracker="{UserGUID}">{view_add_white_list}</a>
                        </li>
                        <li>
                            <a id="add_blocked_list" href="javascript:;" data-tracker="{UserGUID}">{view_add_black_list}</a>
                        </li>
                    </ul>
                </div>
                <p class="hd">關於我</p>
                <ul>
                    {profile}
                </ul>
            </div>
        </div>
    </div>
</div>

<script>

$(function() {
    $('#add_white_list').bind('click',function(){
        var trackUserGUID = $(this).attr('data-tracker');
        $.ajax({
            url: '/action/white_list_add',
            dataType: 'json',
            type: 'POST',
            data: {
                trackUserGUID : trackUserGUID
            },
            success: function(r) {
                alert(r.content);
            }
        });
    });
    $('#add_blocked_list').bind('click',function(){
        var trackUserGUID = $(this).attr('data-tracker');
        $.ajax({
            url: '/action/blocked_list_add',
            dataType: 'json',
            type: 'POST',
            data: {
                trackUserGUID : trackUserGUID
            },
            success: function(r) {
                alert(r.content);
            }
        });
    });
    var $cover_photo = $('#cover_photo').find('img');
    var $full_link = $('#cover_photo').find('a');
    var cover_crop_path = $cover_photo.attr('src');
    $('.all_photo ul img').on('click',function(){
        var crop_path = $(this).attr('data-crop');
        var full_path = $(this).attr('data-full');
        $cover_photo.attr('src',crop_path);
        $full_link.attr('href',full_path).attr('data-gallery',"photos");
        $('.all_photo ul img').attr('data-gallery',"photos");
        $(this).removeAttr('data-gallery');
        $('#cover_photo a').off('click').on('click', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        }); 
    });
    $('#cover_photo a').off('click').on('click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    }); 

});
    
</script>
