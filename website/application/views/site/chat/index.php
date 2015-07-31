  <style>
    .chat-form { display: none; }
  </style>

<form class="username-form" method="post" action="">
  <input type="text" value="{UserGUID}"/>
  <input type="submit" value="Join" />
</form>

<form class="chat-form" method="post" action="">
  <div>Hey there, <span id="username">Guest</span></div>
  <label>To:</label> <input id="recipient" /><br />
  <label>Message: </label><br />
  <textarea id="message"></textarea>
  <input type="submit" value="Send" />

  <ul id="messages">

  </ul>


</form>
    <button id="get_user_list">線上使用者</button>


<script src="/socket.io/socket.io.js"></script>
<script>
var socket = io("localhost:8000/notification");

// Add a username
$(".username-form").on("submit", function(){

    // Tell the server about it
    var username = $(this).children("input").val();
    socket.emit("add-user", {"username": username});

    // Remove this form and show the chat form
    $(this).remove();
    $("#username").text(username);
    chat_form.show();
    return false;
});
//Get user list
$('#get_user_list').on('click',function(){
    //console.log('click user list');
    socket.emit("user-list",{a:'a'});
});

// Chat form
var chat_form = $(".chat-form");
chat_form.on("submit", function(){

   // Send the message to the server
    socket.emit("private-message", {
        "username": $(this).find("input:first").val(),
        "content": $(this).find("textarea").val()
    });

    // Empty the form
    $(this).find("input:first, textarea").val('');
        return false;
});

// Whenever we receieve a message, append it to the <ul>
socket.on("add-message", function(data){
    //console.log(data);
    //console.log(clients);
    $("#messages").append($("<li>", {
        "text": data.content
        })
    );
});
socket.on("user-list", function(data){
    console.log(data);

});
</script>