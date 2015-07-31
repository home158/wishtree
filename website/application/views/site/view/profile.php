<div id="content">
    <div class="profile_set bg clearfix">
        <div class="well well-lg clearfix">
            <div class="profile_left fl ">
                <img src="{CropBasename}" >
            </div>
            <div class="profile_right fr ">
                <div class="submenu">
                    <ul>
                        <li>
                            <a href="/message/write/{UserGUID}">{view_send_message}</a>
                        </li>
                        <li>
                            <a id="my_favor" href="javascript:;" data-tracker="{UserGUID}">{view_add_favor}</a>
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
    $('#my_favor').bind('click',function(){
        var trackUserGUID = $(this).attr('data-tracker');

        $.ajax({
            url: '/favor/add',
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
});
    
</script>
