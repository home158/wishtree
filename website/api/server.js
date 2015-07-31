// Setup basic express server
var express = require('express');
var app = express();
var server = require('http').createServer(app);
// var io = require('../..')(server);
// New:
var io = require('socket.io')(server);
var port = process.env.PORT || 3000;
var clients = {};
var my_socket_id;
server.listen(port, function () {
    console.log('Server listening at port %d', port);
});
var nsp_notification = io.of('/notification');
nsp_notification.on('connection', function (socket) {

    //User connect create 
    console.log('User connection');
    socket.on('add-client', function(data){
        if(!clients[data.UserGUID]){
            clients[data.UserGUID] = {
                "socket": socket.id
            };
            my_socket_id = socket.id;
            console.log('[add-client] => UserGUID = ' + data.UserGUID + '; socket id = ' + socket.id + ';');

        }
        if(data.tracker.length > 0){
            var trackerGUID;
            for(var i in data.tracker){ 
                trackerGUID =  data.tracker[i];
                console.log('[login-notify] => ready to emit message to trackerGUID = ' + trackerGUID);
                if(clients[trackerGUID]){
                    console.log('[login-notify] => trackerGUID = ' + trackerGUID);
                    nsp_notification.connected[clients[trackerGUID].socket].emit("login-notify", data);
                }
            }
        }

    });

    socket.on('private-message', function(data){
        console.log("Sending: " + data.content + " to " + data.username);

        if (clients[data.username]){
            console.log('Get username = ' + clients[data.username]);
            nsp_notification.connected[clients[data.username].socket].emit("add-message", data);
        } else {
            console.log("User does not exist: " + data.username); 
        }
    });

    socket.on('user-list',function(data){
        
        nsp_notification.connected[my_socket_id].emit("user-list", clients);
    });
});