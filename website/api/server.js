// Setup basic express server
var express = require('express');
var app = express();
var server = require('http').createServer(app);
// var io = require('../..')(server);
// New:
var io = require('socket.io')(server);
var port = process.env.PORT || 3000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});

// Routing
app.use(express.static(__dirname + '/public'));

// Chatroom

// usernames which are currently connected to the chat


io.sockets.on('connection', function (socket) {

    // when the client emits 'join-chatroom', this listens and executes
    socket.on('join-chatroom', function (data) {

        // echo globally (all clients) that a person has connected
        socket.broadcast.emit('client-join', data);
    });

    
    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
      // remove the username from global usernames list
    
    });
});