<script src="/socket.io/socket.io.js"></script>
<script>
var socket = io("localhost:8000/notification");
$(function() {
    $.ajax({
        url: '/favor/tracker',
        dataType: 'json',
        type: 'POST',
        success: function(r) {
            socket.emit("add-client", {"UserGUID": '{GUID}', 'tracker':r});
            //window.location.href = '/home';
        }
    });
    //Call server add-client
});
</script>