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
    var userGUID = socket.handshake.query.guid;

    socket.on('join-chatroom', function(data){
        if(!clients[userGUID]){
            clients[userGUID] = {
                "Thumb" : data.Thumb,
                "Nickname" : data.Nickname,
                "Role" : data.Role,
                "UserGUID" : data.UserGUID,
                "socket": socket.id
            };
            
            
            //console.log('[join-chatroom] => UserGUID = ' + data.UserGUID + ' Nickname = ' + data.Nickname + '; socket id = ' + socket.id + ';');
            io.emit("client-join", clients[data.UserGUID]);

        }
        if(data.tracker.length > 0){
            var trackerGUID;
            for(var i in data.tracker){ 
                trackerGUID =  data.tracker[i];
                console.log('[login-notify] => ready to emit message to trackerGUID = ' + trackerGUID);
                if(clients[trackerGUID]){
                    console.log('[login-notify] => trackerGUID = ' + trackerGUID);
                    nsp_chatroom.connected[clients[trackerGUID].socket].emit("login-notify", data);
                }
            }
        }
        addedUser = true;

    });
    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
        delete clients[userGUID];
        socket.broadcast.emit('client_left', clients);
    });
});