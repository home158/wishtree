<script>
    $(function () {
        $('#confirmBtn').bind('click', function () {
            if( typeof(window.opener.O_PARENT.grid) != 'undefined'){
                window.opener.O_PARENT.grid.reload();
            }
            window.close();
        });
    });
</script>
<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{post_result_subject_title}</h1>
    </div>

    <div class="container block blk-reg">
        {post_result_content_msg}
    </div>
   
    <div class="pane-footer">
        <input id="confirmBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;確定&nbsp;&nbsp;"/>
    </div>
</div>

