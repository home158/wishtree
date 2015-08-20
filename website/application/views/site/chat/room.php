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
var socket = io.connect('http://wishpool.azurewebsites.net:80', {
    query: 'guid={GUID}'
});
var O_PARENT = {
    GUID: '{GUID}',
    user: {
    },
    system :{
        client_coming : '{chat_client_coming}',
        public_message : '{chat_public_message}',
        private_message : '{chat_private_message}'
    },
    message:{
        receiver: {},
        build_receiver: function(default_GUID){
            var $receive_GUID = $('#receive_GUID');
            $receive_GUID.empty();
            $('<option value=""></option>').appendTo($receive_GUID);
            $.each(O_PARENT.message.receiver , function(guid,e){
                $('<option value="'+guid+'">'+e.Nickname+'</option>').appendTo($('#receive_GUID'));
            });
            $receive_GUID.val(default_GUID);

        },
        scrolling: function(){
            if( $('#chat_scrolling').prop('checked') ){
                $('.scrollbar-dynamic').scrollTop(99999999999);
            }
        },
        send:function(){
            var visibile =  $( "#chat_visibile" ).prop('checked')? 'private' : 'public';
            console.log(visibile);
            var data = {
                    type: 'msg',
                    visibile: visibile, 
                    receive : $('#receive_GUID').val(),
                    from: O_PARENT.GUID,
                    message : $('#type_message').val()
                };
            console.log(data);
            socket.emit("send-message" , data);
        },
        append:function(data){
            console.log(data);
            $('<li data-type="'+data.type+'" data-visibile="'+data.visibile+'" >'+O_PARENT.message.line(data)+'</li>').appendTo( $('#message_list_all') );
            if(data.receive == O_PARENT.GUID || data.from ==O_PARENT.GUID){
                $('<li data-type="'+data.type+'" data-visibile="'+data.visibile+'" >'+O_PARENT.message.line(data)+'</li>').appendTo( $('#message_list_private') );
            }
            O_PARENT.message.scrolling();
        },
        line: function(data){
            var user = O_PARENT.user;
            console.log(user);
            var from = '<a class="'+user[data.from].Role+'" href="javascript:;" data-guid="'+user[data.from].UserGUID+'" data-toggle="private">'+user[data.from].Nickname+'</a>';
            var msg;
            var receive = '';
            if(data.receive){
                receive = '<a class="'+user[data.receive].Role+'" href="javascript:;" data-guid="'+user[data.receive].UserGUID+'" data-toggle="private">'+user[data.receive].Nickname+'</a>';
            }
            if(data.visibile == 'public'){
                msg = sprintf( O_PARENT.system.public_message ,from , receive , data.message );
            }else{
                msg = sprintf( O_PARENT.system.private_message ,from , receive , data.message );
            }
            return '<span class="'+data.visibile+'">'+msg+'</span>';
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
                if(O_PARENT.GUID == receive_GUID) return;
                var receive_nickname = O_PARENT.user[receive_GUID].Nickname;
                O_PARENT.message.receiver[receive_GUID] = {Nickname : receive_nickname};
                O_PARENT.message.build_receiver(receive_GUID);
            }); 

            $('#chat_coming').on('click',function(){
                $('li[data-type="coming"]' ).toggle(  );
            });
            $('#chat_double_window').on('click',function(){
                 $('#chat_private_window').attr('checked',false);
                if( $(this).prop('checked') ){
                    $('#message_list_all').parent().css('height','60%').show();
                    $('#message_list_private').parent().css('border-top', '1px dotted gray').css('height','40%').show();
                    $('#message_list_private').show();
                }else{
                    $('#message_list_all').parent().css('height','100%').show();
                    $('#message_list_private').parent().hide();
                }

              
            });
            $('#chat_private_window').on('click',function(){
                 $('#chat_double_window').attr('checked',false);
                if( $(this).prop('checked') ){
                    $('#message_list_all').parent().hide();
                    $('#message_list_private').parent().css('border-top', '1px dotted gray').css('height','100%').show();
                    $('#message_list_private').show();
                }else{
                    $('#message_list_all').parent().css('height','100%').show();
                    $('#message_list_private').parent().hide();
                }
            });
            $('#chat_scrolling').on('click',function(){
                if( $(this).prop('checked') ){
                    $('.scrollbar-dynamic').scrollTop(99999999999);
                }
            });
        }
    },
    client :{
        nickname: function(data)
        {
            return '<a class="'+data.Role+'" href="javascript:;" data-guid="'+data.UserGUID+'" data-toggle="private">'+data.Nickname+'</a>';
        },
        disconnect:function(data){
            console.log(data);
            delete O_PARENT.user[data.UserGUID];
            $('<li data-type="coming">'+O_PARENT.client.nickname(data)+' disconnect</li>').appendTo( $('#message_list_all') );
        },
        join: function(data){
            console.log(data);
            O_PARENT.user[data.UserGUID] = data;
            $('<li>'+O_PARENT.client.nickname(data)+'</li>').appendTo( $('#client_list') );
            $('<li data-type="coming">'+sprintf( O_PARENT.system.client_coming, O_PARENT.message.nickname(data) )+'</li>').appendTo( $('#message_list_all') );
            if(data.UserGUID == O_PARENT.GUID){
                $('<li data-type="coming">'+sprintf( O_PARENT.system.client_coming, O_PARENT.message.nickname(data) )+'</li>').appendTo( $('#message_list_private') );
            }
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
                socket.emit("client-list" , O_PARENT.GUID);
            });
        }

    },
    utility: {
    }
};
$(function() {

    socket.emit("join-chatroom", {
        UserGUID: O_PARENT.GUID, 
        Role: '{Role}',
        Nickname: '{Nickname}',
       // Thumb : '{Thumb}',
        tracker:[]
    });
    socket.emit("client-list" , O_PARENT.GUID);
    O_PARENT.client.init();
    O_PARENT.message.init();
    $('.scrollbar-dynamic').scrollbar();

});
    
socket.on("client_left", O_PARENT.client.disconnect );
socket.on("client-join", O_PARENT.client.join );
socket.on("client-list", O_PARENT.client.refresh);
socket.on("new-message", O_PARENT.message.append);

</script>