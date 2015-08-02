<!DOCTYPE html>
<html lang="tw">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    
    <link rel="stylesheet" href="/_css/index.css">
    <link rel="stylesheet" href="/_css/chat_room.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/_js/jquery.cookie.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.3/angular.min.js"></script>
    <script src="/_js/sprintf.min.js"></script>
    <script src="/_js/angular-sprintf.min.js"></script>
</head>
<body>
<div id="widget">
    <div class="widget_left">
        <ul id="message_list"></ul>
    </div>
    <div  class="widget_right">
        <ul id="client_list"></ul>
    </div>
    <div class="tc widget_control">
        <a href="javascript:;" id="get_client_list">Refresh</a>
    </div>
    <div class="widget_talk">
            <div>
                {chat_type_message} <input id="type_message" class="type_message" type="text">
                <span id="submit_message" class="delete_image btn btn-success delete btn-xs " data-GUID="{GUID}" >
                    <i class=""></i>
                    <span>{btn_submit}</span>
                </span>
                <span id="clear_message" class="delete_image btn btn-success delete btn-xs " data-GUID="{GUID}" >
                    <i class=""></i>
                    <span>{btn_clear}</span>
                </span>
            </div>
            <div>
                {chat_target} 
                <select id="receive_GUID" class="target_GUID" >
                    <option value=""></option>
                </select>
            </div>
    </div>
</div>
<script src="/socket.io/socket.io.js"></script>
<script>

var socket = io("localhost:8000/chatroom");
var O_PARENT = {
    user: {
    },
    system :{
        client_coming : '{chat_client_coming}',
        public_message : '{chat_public_message}'
    },
    message:{
        send:function(){
            var data = {
                    type: 'public',
                    receive : 'b61ff661-6531-4660-b0e1-77c5fd0cc66e',
                    from: 'edd79b0d-5ac4-422f-b910-0a254570065e',
                    message : $('#type_message').val()
                };
            console.log(data);
            socket.emit("public-message" , data);
        },
        append:function(data){

            $('<li>'+O_PARENT.message.line(data)+'</li>').appendTo( $('#message_list') );
        },
        line: function(data){
            var user = O_PARENT.user;
            var from = '<a class="'+user[data.from].Role+'" href="javascript:;" data-guid="'+user[data.from].UserGUID+'" data-toggle="private">'+user[data.from].Nickname+'</a>';

            var receive = '<a class="'+user[data.receive].Role+'" href="javascript:;" data-guid="'+user[data.receive].UserGUID+'" data-toggle="private">'+user[data.receive].Nickname+'</a>';

            return sprintf( O_PARENT.system.public_message ,from , receive , data.message );
        },
        nickname: function(data)
        {
            return '<a class="'+data.Role+'" href="javascript:;" data-guid="'+data.UserGUID+'" data-toggle="private">'+data.Nickname+'</a>';
        },
        init: function(){
            $('#submit_message').on('click',O_PARENT.message.send);

            $(document).delegate('*[data-toggle="private"]', 'click', function(event) {
                event.preventDefault();
                var receive_GUID = $(this).attr('data-guid');
                var receive_nickname = O_PARENT.user[receive_GUID].Nickname;
                $('<option value="'+receive_GUID+'">'+receive_nickname+'</option>').appendTo($('#receive_GUID'));
                $('#receive_GUID').val(receive_GUID);
            }); 
        }
    },
    client :{
        nickname: function(data)
        {
            return '<a class="'+data.Role+'" href="javascript:;" data-guid="'+data.UserGUID+'" data-toggle="private">'+data.Nickname+'</a>';
        },
        join: function(data){
            console.log(data);
            O_PARENT.user[data.UserGUID] = data;
            $('<li>'+O_PARENT.client.nickname(data)+'</li>').appendTo( $('#client_list') );
            $('<li>'+sprintf( O_PARENT.system.client_coming, O_PARENT.message.nickname(data) )+'</li>').appendTo( $('#message_list') );

        },
        refresh: function(data){
            delete O_PARENT.user;
            O_PARENT.user = {};
            $('#client_list').empty();
            console.log(data);
            $.each(data , function(i,e){
                $('<li id="'+e.UserGUID+'">'+O_PARENT.client.nickname(e)+'</li>').appendTo( $('#client_list') );
                O_PARENT.user[e.UserGUID] = e;
            });
        },
        init:function(){
            $('#get_client_list').bind('click',function(){
                socket.emit("client-list" , '{GUID}');
            });
        }

    },
    utility: {
    }
};
var $type_message = $('#type_message');
var $submit_message = $('#submit_message');
var $target_GUID = $('#target_GUID');
var send_message = function(){

};
$(function() {
    $type_message.focus().on('submit',function(){
        alert('go');
    });
    
    socket.emit("join-chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}',
        Thumb : '{Thumb}',
        tracker:[]
    });
    //Call server retrieve client-list
    socket.emit("client-list" , '{GUID}');
    O_PARENT.client.init();
    O_PARENT.message.init();
});

socket.on("login-notify", function(data){
    alert(data.UserGUID +' online');

});
    
socket.on("client-join", O_PARENT.client.join );
socket.on("client-list", O_PARENT.client.refresh);
socket.on("new-message", O_PARENT.message.append);

</script>
</body>
</html>