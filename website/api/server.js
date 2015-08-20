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
var socket_maps = {};
var UserGUID;
/*
    socket.emit 只有自己
    socket.broadcast.emit 除了自己
    io.emit 包含自己
*/
io.sockets.on('connection', function (socket) {

    socket.on('join_chatroom', function (data) {
        UserGUID = data.UserGUID;
        if(clients[UserGUID]){
            socket.emit('client_duplicated', data.UserGUID);
        }else{
            socket_maps[socket.id] = UserGUID;
            clients[UserGUID] = {
                socketID : socket.id,
                Nickname : data.Nickname
            };
            socket.emit('login_welcome', clients);
            socket.broadcast.emit('client_joined', clients);
        }
        
        

    });

    // when the client emits 'new message', this listens and executes
    socket.on('send_message', function (data) {
        io.sockets.connected[clients[data.targetGUID].socketID].emit('send_message', data.message);
    });




    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
        delete clients[socket_maps[socket.id]];
        socket.broadcast.emit('client_left', clients);
    });
});