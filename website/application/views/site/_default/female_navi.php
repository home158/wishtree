<div id="navi">
    <ul>
        <li><a id="home" href="/home">首頁</a></li>
        <li><a id="wish" href="/wish">許願池</a></li>
        <li><a id="message" href="/message">留言板</a></li>
        <li><a id="chat" href="/chat">聊天室</a></li>
        <li><a href="#">誰看過我</a></li>
        <li><a id="mywish" href="/mywish">我的願望</a></li>
        <li><a href="#">搜索</a></li>
        <li><a id="photo" href="/photo">照片</a></li>
        <li><a id="account" href="/account">帳號</a></li>
    </ul>
</div>
<div id="bs_alert">
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div id="alert_content">{alert_content}</div>
    </div>
</div>
<script>
$(function() {
    $('a#{highlight_navi}').addClass('highlight');
    if( $('#alert_content').text() != ''){
        $('#bs_alert').fadeIn();
    }
});
</script>