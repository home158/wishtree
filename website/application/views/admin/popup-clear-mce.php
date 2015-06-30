<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{popup_header_text}</h1>
    </div>
    <div class="mce_area">
        <textarea name="textarea"  style="height:300px"></textarea>
        <br/>
        <div style="text-align:right;">
            <input name="mce_submit" type="submit" class="btn-relax" value="&nbsp;&nbsp;送出&nbsp;&nbsp;">
            <input name="mce_cancel" type="button" class="btn-relax" value="&nbsp;&nbsp;取消&nbsp;&nbsp;">
    </div>
</div>
<style>
.mce-content-body {
  padding: 5px;
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 44px;
  color: #336699;
}
</style>
<script>
    $(function () {
        var parent_input = window.opener.document.getElementById('{parent_input_name}');
        $('textarea[name=textarea]').html(parent_input.value);

        

        //tinyMCE init
        tinyMCE.init({                    'selector' : "textarea",
                    'theme' : "modern",
                    'language' : 'zh_TW',
                    'width' : '100%',
                    'height' : '100%',
                    'toolbar1' : "insertfile undo redo| preview | forecolor backcolor",
                    'plugins' : [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "paste textcolor colorpicker textpattern autoresize"
                    ],
                    menubar : false,
                    setup : function(ed)
                    {
                        ed.on('init', function() 
                        {
                            this.getDoc().body.style.fontSize = '19px';
                            this.getDoc().body.style.fontFamily = 'Helvetica, Arial, "微軟正黑體", sans-serif;';
                        });
                    }
                    
        });

        $('input[name=mce_submit]').bind('click', function () {
            parent_input.value = tinyMCE.activeEditor.getContent();
            window.close();
        });

        
        $('input[name=mce_cancel]').bind('click', function () {
            if (confirm('{popup_mce_confirm_msg}')) {
                window.close(); 
            }else{
                return false;
            }
            
        });
    });
</script>
