<script src="/_js/jquery.scrollbar.js"></script>
<script src="/_js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" href="/_css/scrollbar-macosx.css">
<link rel="stylesheet" href="/_css/bootstrap-switch.min.css">


<link rel="stylesheet" href="/_css/jquery.Jcrop.min.css" type="text/css" />
<div id="content">
    <div class="message_set bg clearfix">
        <div class="well well-lg clearfix">
            <div class="message_left fl ">
                <div id="message_box">
                    <div id="message_box_list">
                        <div class="scrollbar-container">
                            <div class="scrollbar-macosx">
                                {message_box}
                                <div class="message_box" data-from="{FromUserGUID}">
                                    <div class="clearfix" >
                                        <div class="fl">
                                            <img src="{ThumbBasename}" style="width:75px;height:84px;">
                                            <span name="status_{FromUserGUID}" class="status-wrapper offline" title="{status_offline}">
                                                <span class="icon"></span>
                                                <span class="caption">{status_offline}</span>
                                            </span>

                                        </div>
                                        <ul class="text fl">
                                            <li>{Bodytype}</li>
                                            <li>{City}</li>
                                            <li>{DateModify}</li>
                                            <div class="new_icon">{new}</div>
                                        </ul>
                                    </div>
                                    <p>{db_Nickname}, {NationalCode}</p>
                                </div>
                                {/message_box}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="message_right fr">


                
                <p><b>注意事項:</b>根據我們的用戶協議,如果您發送垃圾郵件或攻擊性語言,我們將有權停止/刪除您的帳號.</p>
                <p><b>注意事項:</b>如果您不希望收到垃圾郵件,請不要隨意將您的常用 Email 發送給不太認識的人.</p>
                <div>
                    <input id="targetGUID" type="text" value="">
                    <textarea name="message_content" ></textarea>
                    <em class="note"></em><br>
                    
                    <div class="tr clearfix">
                        <div class="fl">
                            {message_approve_for_private_photo} <input type="checkbox" name="private_photo">
                        </div>
                        <div class="fr ">
                            <input id="send_message" type="submit" class="btn-xl btn-emp" value="{btn_submit}">
                        </div>
                    </div>
                </div>
                <div class="scrollbar-container-history">
                    <div class="scrollbar-macosx">
                        <div id="message_history"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('.scrollbar-macosx').scrollbar();
    $('.message_box').bind('click',function(){
        var $this = $(this);
        $.ajax({
            url: '/message/history',
            dataType: 'html',
            type: 'POST',
            data: {
                GUID : $this.attr('data-from')
            },
            success: function(r) {
                $('#message_history').html(r);
                $('.new_icon' , $this).remove();
            },
            complete : function(){
                $('#targetGUID').val($this.attr('data-from'));
            }
        });

    });
    $('#send_message').bind('click',function(){
        if( !$('#targetGUID').val()){
            alert('{message_please_select_target}');
            return false;
        }
        if( !$('textarea[name=message_content]').val()){
            alert('{message_please_set_message_content}');
            return false;
        }
        var $this = $(this);
        $.ajax({
            url: '/message/send',
            dataType: 'html',
            type: 'POST',
            data: {
                targetGUID : $('#targetGUID').val(),
                content : $('textarea[name=message_content]').val()
            },
            success: function(r) {
                alert('{message_send_success}');
                $('#message_history').prepend(r);

            },
            complete : function(){
                
            }
        });

    });
    $("[name='private_photo']").bootstrapSwitch({
        onText: '{message_approve}',
        offText: '{message_reject}',
        state : false,
        disabled : true,
        onSwitchChange:function(event, state){
            $.ajax({
                url: '/action/set_privilege',
                dataType: 'json',
                type: 'POST',
                data: {
                    privilege : state?2:1,
                    trackUserGUID : $('#targetGUID').val()
                },
                success: function(r) {
               
                }
            });
        }
    });
    if(socket_loading){
        socket.emit("update-status");
    }
});   
</script>