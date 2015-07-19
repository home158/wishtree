<script src="/_js/jquery.scrollbar.js"></script>
<link rel="stylesheet" href="/_css/scrollbar-macosx.css">


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
                                
                                        </div>
                                        <ul class="text fl">
                                            <li>{Bodytype}</li>
                                            <li>{City}</li>
                                            <li>{DateModify}</li>
                                        </ul>
                                    </div>
                                    <p>{Nickname}, {NationalCode}</p>
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
                <form action="" method="POST" id="message_content">
                    <textarea name="message_content" ></textarea>
                    <em class="note"></em><br>
                    
                    <div class="tr">
                    <input type="submit" class="btn-xl btn-emp" value="{btn_submit}">
                    </div>
                </form>
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
                console.log(r);
                $('#message_history').html(r);
            },
            complete : function(){
                
            }
        });

    });
});   
</script>