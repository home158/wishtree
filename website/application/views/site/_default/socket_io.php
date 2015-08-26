<script src="/socket.io/socket.io.js"></script>
<script>
var socket = io.connect('http://wishpool.azurewebsites.net:80', {
    query: 'guid={GUID}'
});
socket.on("client-join", function(data){
    console.log(data);
    console.log('coming');
});
socket.on("client-left", function(data){
    console.log(data);
    console.log('left');
});
socket.on("client-list", function(data){
        console.log("client-list");
        console.log(data);
    if(data){
        $.each(data,function( i, r ) {
            console.log('each');
            console.log(r);
            $('*[name=status_'+r.UserGUID+']').removeClass('offline').addClass('online')
                .attr('title','{status_online}')
                .find('.caption').text('{status_online}');
        });
    }
});

$(function() {
    socket.emit("join-chatroom", {
        UserGUID: '{GUID}', 
        Role: '{Role}',
        Nickname: '{Nickname}'
    });
    socket_loading = true;
});
</script>