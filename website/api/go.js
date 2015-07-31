// Setup basic express server
var express = require('express');
var app = express();
var server = require('http').createServer(app);
// var io = require('../..')(server);
// New:
var io = require('socket.io')(server);
var port = process.env.PORT || 3000;
var clients = {};
var client_list = [];
var my_cocket_id;
server.listen(port, function () {
    console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {
    console.log('User connection');
    socket.on('add-user', function(data){
        console.log('add-user =>' + data.username + '====>' + socket.id);
        clients[data.username] = {
            "socket": socket.id
        };
        my_cocket_id = socket.id;
        client_list.push(socket.id);
    });

    socket.on('private-message', function(data){
        console.log("Sending: " + data.content + " to " + data.username);

        if (clients[data.username]){
            io.sockets.connected[clients[data.username].socket].emit("add-message", data);
        } else {
            console.log("User does not exist: " + data.username); 
        }
    });

    socket.on('user-list',function(data){
        
        io.sockets.connected[my_cocket_id].emit("user-list", clients);
    });
});