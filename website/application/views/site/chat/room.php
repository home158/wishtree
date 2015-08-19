<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Socket.IO Chat Example</title>
</head>
<body>
  
    <input id="targetGUID" type="text" value="" />
    <button id="private">Send</button>
  

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="/socket.io/socket.io.js"></script>
  <script>
$(function() {
    var connected = false;
    var socket = io.connect('http://wishpool.azurewebsites.net/chat/room', {
        query: 'userId={GUID}'
    });

    
    socket.on('client_joined', function (data) {
        console.log('除了自己');
    });

    socket.on('login_welcome', function (data) {
        console.log('只有自己');
    });    

    socket.emit("join_chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}'
    });
    socket.emit("send_message", function(data){
        console.log(data)
    });
    $('#private').on('click',function(){
        socket.emit("send_message", {
            targetGUID: $('#targetGUID').val(),
            message: 'Hello private message from {Nickname}'
        });
    });
});


  </script>
</body>
</html>