<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Socket.IO Chat Example</title>
</head>
<body>
  <ul class="pages">
    <li class="chat page">
      <div class="chatArea">
        <ul class="messages"></ul>
      </div>
      <input class="inputMessage" placeholder="Type here..."/>
    </li>
    <li class="login page">
      <div class="form">
        <h3 class="title">What's your nickname?</h3>
        <input class="usernameInput" type="text" maxlength="14" />
      </div>
    </li>
  </ul>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="/socket.io/socket.io.js"></script>
  <script>
$(function() {
    var connected = false;
    var socket = io();

    socket.on('send_message', function (data) {
        console.log('包含自己');
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
});


  </script>
</body>
</html>