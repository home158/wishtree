<script type="text/javascript" src="/_script/tinymce/tinymce.min.js"></script>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=big5">

<style>
.page-preview {
    width: 801px;
}
.mce_area {
    width: 801px;
    position: relative;
    display: none;
}
.page-content{
    width: 789px;
    margin-bottom: 20px;
    border: 1px dotted #ccc;
    position: relative;
}
.mce_edit_btn{
    position: absolute;
    top: -50px;
    right: 0;
}
.page-preview p{
    margin-top: 11px;
    line-height: 285%;
    Helvetica, Arial, 微軟正黑體, sans-serif;

}
</style>
<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_page_title}</h1>
    </div>
    <div class="page-preview">
        <div class="page-content">
            {Content}
            <div class="mce_edit_btn">
                <input name="mce_edit" type="submit" class="btn-relax" value="&nbsp;&nbsp;{button_edit}&nbsp;&nbsp;">
            </div>       
        </div>       
    </div>
    <div class="mce_area">
        <form enctype="multipart/form-data" id="signup-form" action="/admin/page/edit/{GUID}" method="post">
                <textarea name="Content" >{Content}</textarea>
                <input name="redirect_to" value="{redirect_to}" type="hidden"/>
                <input name="GUID" value="{GUID}" type="hidden"/>
            <div  class="mce_edit_btn">
                <input name="mce_submit" type="submit" class="btn-relax" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;">
                <input name="mce_cancel" type="button" class="btn-relax" value="&nbsp;&nbsp;{button_cancel}&nbsp;&nbsp;">
            </div>
        <form>
    </div>

</div>
<script>
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
                    "fontsize_formats" : "8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt",
                    'image_advtab' : true,
   
                    'external_filemanager_path':"/filemanager/",
                    'filemanager_title':"Responsive Filemanager" ,
                    'external_plugins': { 
                            "filemanager" : "/filemanager/plugin.min.js"
                    },
                    'content_css' : '/_css/tinymce.css',

        });
$(function() {
    $('input[name="mce_cancel"]').bind('click',function(){
        $('div.page-preview').show();
        $('div.mce_area').hide();
    });
    $('input[name="mce_edit"]').bind('click',function(){
        $('div.page-preview').hide();
        $('div.mce_area').show();
    });
});
    
</script>