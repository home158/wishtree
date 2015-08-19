// Setup basic express server
var express = require('express');
var app = express();
var server = require('http').createServer(app);
// var io = require('../..')(server);
// New:
var io = require('socket.io')(server);
var port = process.env.PORT || 3000;
var clients = {};
var arr_socket = {};
var my_socket_id;
server.listen(port, function () {
    console.log('Server listening at port %d', port);
});
//var nsp_chatroom = io.of('/chatroom');
var nsp_chatroom = io;
nsp_chatroom.on('connection', function (socket) {
    var addedUser = false;
        my_socket_id = socket.id;
    //User connect create 
    console.log('[connection] =>'+ 'socket id = ' + socket.id + ';');
    socket.on('join-chatroom', function(data){
        if(!clients[data.UserGUID]){
            clients[data.UserGUID] = {
                "Thumb" : data.Thumb,
                "Nickname" : data.Nickname,
                "Role" : data.Role,
                "UserGUID" : data.UserGUID,
                "socket": socket.id
            };
            
            arr_socket[my_socket_id] = data.UserGUID;
            console.log('[join-chatroom] => UserGUID = ' + data.UserGUID + ' Nickname = ' + data.Nickname + '; socket id = ' + socket.id + ';');
            nsp_chatroom.emit("client-join", clients[data.UserGUID]);

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
    
    socket.on('private-message', function(data){
        console.log("Sending: " + data.content + " to " + data.username);

        if (clients[data.username]){
            console.log('Get username = ' + clients[data.username]);
            nsp_chatroom.connected[clients[data.username].socket].emit("add-message", data);
        } else {
            console.log("User does not exist: " + data.username); 
        }
    });

    socket.on('client-list',function(GUID){
        console.log('[client-list] = ' );
        nsp_chatroom.connected[clients[GUID].socket].emit("client-list", clients);
        
    });
    socket.on('send-message',function(data){
        console.log('[send-message] = ' );
        if(data.visibile == 'public'){
            nsp_chatroom.emit("new-message", data);
        }
        if(data.visibile == 'private'){
            nsp_chatroom.connected[clients[data.receive].socket].emit("new-message", data);
            nsp_chatroom.connected[clients[data.from].socket].emit("new-message", data);
        }

        
      
    });
    // when the user disconnects.. perform this
    socket.on('disconnect', function () {
        // remove the username from global usernames list
        if (addedUser) {
            var GUID = arr_socket[my_socket_id];
            nsp_chatroom.emit("client-disconnect", clients[GUID]);
            delete clients[GUID];
        }

    });
});