<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">儲存成功</h1>
    </div>
    <div class="mce_area">
       
            <div style="text-align:left;">
                <input name="mce_close" type="button" class="btn-relax" value="{btn_close}">
            </div>
    </div>
</div>
     
</div>
<script>
$(function () {
    var parent_window = window.opener.window;
    parent_window.location.reload();;
    $('input[name=mce_close]').on('click',function(){
       window.close(); 
    });
});
</script>