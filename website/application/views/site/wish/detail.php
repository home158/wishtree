<script src="/_js/jquery.scrollbar.js"></script>
<script src="/_js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" href="/_css/scrollbar-macosx.css">
<link rel="stylesheet" href="/_css/bootstrap-switch.min.css">

<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
            <div class="wish_avatar fl">
                <a data-load="main_content" href="/view/{UserGUID}"><img class="crop" src="{CropBasename}"></a>
            </div>
            <div class="wish_card wish_message clearfix fr">
                <div class=" identity-content ">
                    <div class="expire_date"><span class="label label-{DateExpireClass}">{DateExpire}</span></div>
                    <div>
                        <a href="/view/{UserGUID}">{db_Nickname}</a>,
                        <strong>{YearsOld}</strong> {view_years_old},
                        {City}
                    </div>
                    <div class="read_model">

                        <div class="wish_title">
                            [{WishCategory}] {WishTitle}
                        </div>
                        <div class="wish_content">
                            {WishContent}
                        </div>
                    </div>
                </div>
            </div>

            <div class="wish_reply wish_message fr" style="{reply_content_element_style}">
                <div class="identity-content">
                    <p class="hd">{wish_reply}</p>
                    <div style="{reply_wish_element_style}">
                        <input id="wishGUID" type="hidden" value="{db_GUID}"/>
                        <textarea name="message_content" ></textarea>
                        <em class="note"></em><br>
                
                        <div class="tr clearfix" style="margin-top: 10px;">
                            <div class="fl" style="{document_element_style}">
                                {message_approve_for_private_photo} <input type="checkbox" name="private_photo" data-value="{UserGUID}">
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
</div>
<script>
    $('.scrollbar-macosx').scrollbar();
    $("[name='private_photo']").bootstrapSwitch({
        onText: '{message_approve}',
        offText: '{message_reject}',
        state : ('{Privilege}' == '2')?true:false,
        disabled : false,
        onSwitchChange:function(event, state){
            $.ajax({
                url: '/action/set_privilege',
                dataType: 'json',
                type: 'POST',
                data: {
                    privilege : state?2:1,
                    trackUserGUID : $(this).attr('data-value')
                },
                success: function(r) {
               
                }
            });
        }
    });
    $('#send_message').on('click',function(){
        var $message_content = $('textarea[name=message_content]');
        if(!$.trim($message_content.val())){
            alert("{wish_reply_content_request}");
            $message_content.focus();

        }else{
            $.ajax({
                url: '/wish/reply',
                dataType: 'html',
                type: 'POST',
                data: {
                    wish_GUID : $('#wishGUID').val(),
                    wish_content : $.trim($message_content.val())
                },
                success: function(r) {
                    $message_content.val('');
                    alert('{message_send_success}');
                    $('#message_history').html(r);
                },
                complete : function(){
                    
                }
            });
        }
    });
    $.ajax({
        url: '/wish/get_reply',
        dataType: 'html',
        type: 'POST',
        data: {
            wishGUID : $('#wishGUID').val()
        },
        success: function(r) {
            $('#message_history').html(r);
    
        },
        complete : function(){
            
        }
    });
</script>
