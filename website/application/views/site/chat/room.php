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
    <link rel="stylesheet" href="/_css/scrollbar-dynamic.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/_js/jquery.cookie.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.3/angular.min.js"></script>
    <script src="/_js/sprintf.min.js"></script>
    <script src="/_js/angular-sprintf.min.js"></script>
    <script src="/_js/jquery.scrollbar.js"></script>
</head>
<body>
<div id="widget">
    <div class="widget_left scrollbar-container">
        <ul id="message_list_all" class="scrollbar-dynamic"></ul>
        <ul id="message_list_private" class="scrollbar-dynamic"></ul>
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
            <div>
                <input type="checkbox" id="chat_visibile" > <label for="chat_visibile">{chat_to_private}</label> 
                <input type="checkbox" id="chat_coming" > <label for="chat_coming">{chat_client_coming_info}</label> 
                <input type="checkbox" id="chat_double_window" > <label for="chat_double_window">{chat_double_window}</label> 
                <input type="checkbox" id="chat_private_window" > <label for="chat_private_window">{chat_private_window}</label> 
                <input type="checkbox" id="chat_scrolling" > <label for="chat_scrolling">{chat_scrolling}</label> 
                
            </div>
    </div>
</div>
<script src="/socket.io/socket.io.js"></script>
<script>
    
var socket = io();

$(function() {

    socket.emit("join-chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}',
       // Thumb : '{Thumb}',
        tracker:[]
    });

});
socket.on("client-join",function(data){
    console.log(data);
});
</script>
</body>
</html>