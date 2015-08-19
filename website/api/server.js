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
var clients = {};
var userId;
/*
    socket.emit 只有自己
    socket.broadcast.emit 除了自己
    io.emit 包含自己
*/
io.sockets.on('connection', function (socket) {
    userId = socket.handshake.query.guid;

    socket.on('join_chatroom', function (data) {
        /*
        if(clients[data.UserGUID]){
            socket.emit('GUID_duplicated', data.UserGUID);
        }else{
            clients[data.UserGUID] = {
                socketID : socket.id,
                Nickname : data.Nickname
            };
        }
        */
        socket.emit('login_welcome', userId);
        socket.broadcast.emit('client_joined', userId);

    });

    // when the client emits 'new message', this listens and executes
    socket.on('send_message', function (data) {
        io.sockets.connected[clients[0]].emit('send_message', userId);
    });




    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
        
    });
});