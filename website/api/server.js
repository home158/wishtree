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


/*
    socket.emit 只有自己
    socket.broadcast.emit 除了自己
    io.emit 包含自己
*/
io.sockets.on('connection', function (socket) {
    socket.on('join_chatroom', function (data) {

        socket.emit('login_welcome', {
            numUsers: 5
        });
        socket.broadcast.emit('client_joined', {
            username: data.Nickname,
            numUsers: 15
        });

    });

    // when the client emits 'new message', this listens and executes
    socket.on('send_message', function (data) {
        io.to(data.targetGUID).emit('send_message', 'hello');
    });




    // when the user disconnects.. perform this
    socket.on('disconnect', function () {

    });
});