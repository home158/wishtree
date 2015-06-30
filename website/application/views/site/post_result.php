<div class="container">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-member-modify-center.png"/>
    </div>
    <div class="content block blk-reg">
        <div class="inside">
            {post_result_content_msg}
        </div>
        <br><br>
        <div class="pane-footer">
            <input id="confirmBtn" type="submit" class="btn-calm-m" value="{button_ok}"/>        
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>

</div>
<script>
    $(function () {
        $('#confirmBtn').bind('click', function () {
            document.location.href = '/member';
        });
    });
</script>