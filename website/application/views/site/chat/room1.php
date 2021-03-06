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
    var socket = io.connect('http://wishpool.azurewebsites.net:80', {
        query: 'guid={GUID}'
    });
    socket.on("client_duplicated",function(){
       console.log('重覆guid不得進入'); 
    });
    socket.on("send_message", function(data){
        console.log(data)
    });

    socket.on('client_joined', function (data) {
        console.log('除了自己');
        console.log(data);
    });

    socket.on('login_welcome', function (data) {
        console.log('只有自己');
        console.log(data);
    });    
    socket.on('client_left', function (data) {
        console.log('有人離開了');
        console.log(data);
    });    
    
    socket.emit("join_chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}'
    });
    $('#private').on('click',function(){
        alert('s');
        socket.emit("send_message", {
            targetGUID: $('#targetGUID').val(),
            message: 'Hello private message from {Nickname}'
        });
    });
});


  </script>
</body>
</html>