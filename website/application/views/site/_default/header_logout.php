<div id="header">
    <div class="hd">
        <h1 class="">
        <a href="http://www.asugardating.com/">Wish Tree</a></h1>
        <ul class="header-link">
      	
            <li><a href="">升級 VIP</a></li>
            <li>
                <a href="javascript:;"><img src="/_images/1437392466_1302-speech-bubbles.png"><span class="badge">{message_of_count}</span></a>

            </li>
            
            <li><a href="/logout">登出</a></li>				
        </ul>
    </div>
</div>
<script src="/socket.io/socket.io.js"></script>
<script>
var socket = io.connect('http://wishpool.azurewebsites.net:8000', {
    query: 'guid={GUID}'
});
socket.on("client-join", function(data){
    console.log(data.Nickname + 'coming');
});
socket.on("client-left", function(data){
    console.log(data.Nickname + 'left');
});
$(function() {
    socket.emit("join-chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}'
    });
});
</script>