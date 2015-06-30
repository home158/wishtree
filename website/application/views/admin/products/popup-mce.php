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
                    'toolbar1' : "responsivefilemanager insertfile undo redo | styleselect  | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor",
                    'plugins' : [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "paste textcolor colorpicker textpattern autoresize"
                    ],
                    "fontsize_formats" : "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                    'image_advtab' : true,
   
                    'external_filemanager_path':"/filemanager/",
                    'filemanager_title':"Responsive Filemanager" ,
                    'external_plugins': { 
                            "filemanager" : "/filemanager/plugin.min.js"
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
