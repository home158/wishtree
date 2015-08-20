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
                    io.sockets.connected[clients[trackerGUID].socket].emit("login-notify", data);
                }
            }
        }
        addedUser = true;

    });
    socket.on('private-message', function(data){
        console.log("Sending: " + data.content + " to " + data.username);

        if (clients[data.username]){
            console.log('Get username = ' + clients[data.username]);
            io.sockets.connected[clients[data.username].socket].emit("add-message", data);
        } else {
            console.log("User does not exist: " + data.username); 
        }
    });

    socket.on('client-list',function(GUID){
        console.log('[client-list] = ' );
        socket.emit("client-list", clients);
        
    });
    socket.on('send-message',function(data){
        console.log('[send-message] = ' );
        if(data.visibile == 'public'){
            io.emit("new-message", data);
        }
        if(data.visibile == 'private'){
            io.sockets.connected[clients[data.receive].socket].emit("new-message", data);
            io.sockets.connected[clients[data.from].socket].emit("new-message", data);
        }

        
      
    });

    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
        socket.broadcast.emit('client_left', clients[userGUID]);
        delete clients[userGUID];
    });
});