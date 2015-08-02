<script type="text/javascript" src="/_js/jquery.popupwindow.js"></script>
<div id="content">
    <div class="message_set bg clearfix">
        <div class="well well-lg clearfix">
                <h1>聊天室守則</h1>
                <div class="tc">
                    <span id="chat_open"class="btn btn-primary start">
                        <i class="glyphicon glyphicon-ok"></i>
                        <span>{char_open_up}</span>
                    </span>        
                </div>
    </div>
</div>
<script>
$(function() {
    $('#chat_open').bind('click',function(){
        $.popupWindow('/chat/room/', { 
            height: 600, 
            width: 800,
            createNew: false,
            onUnload: function(){
            }
        });
    });
});
</script>
                            