<script type="text/javascript" src="/_script/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_script/jquery-ui-1.9.2/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="/_script/jquery-ui-1.9.2/js/datepicker-zh-TW.js"></script>
<script type="text/javascript" src="/_script/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/_script/draggable_background.js"></script>
<link rel="stylesheet" type="text/css" href="/_script/jquery-ui-1.9.2/css/blitzer/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="/_script/fancybox/jquery.fancybox-1.3.4.css" />

<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{news_edit}</h1>
    </div>

    <form enctype="multipart/form-data" id="signup-form" action="/admin/news/edit/{GUID}" method="post">
        <div class="container block blk-reg">
            <div class="inside">
                <span class="item">{gird_column_NewsTitle} : </span>
                <input name="news_title" id="news_title" type="text" value="<?= set_value('news_title','{Title}'); ?>" /><br>
                &nbsp;<?= form_error('news_title'); ?><br>

                <span class="item">{gird_column_ShortDesc} : </span>
                <a id="news_short_desc_tinymce" targetURL="short_desc" href="#content">{news_anchor_here_to_edit}</a><br>
                <?= form_error('news_short_desc'); ?><br>
                <textarea name="news_short_desc" id="news_short_desc" style="display:none;" >
                    <?= set_value('news_short_desc','{ShortDesc}'); ?>
                </textarea>

                <span class="item">{news_cover_image} : </span>
                <div class="news_cover_image" style="background-image:url(<?= set_value('news_cover_image','{CoverImageURLPath}'); ?>);background-position:<?= set_value('news_cover_image_position','{CoverImageBackgroundPosition}'); ?>;)">
                    {news_thumb} 
                </div><br>
                &nbsp;<em class="note">1. <input target_field_id="news_cover_image" type="button" class="btn-ele" id="filemanager_news_cover_image" value="{news_image_select}"/>
                2. {news_cover_image_note}</em><br>
                <input id='news_cover_image' name="news_cover_image" type="hidden" value="{CoverImageURLPath}" />
                <input id='news_cover_image_thumb' name="news_cover_image_thumb" type="hidden" value="{CoverImageThumbURLPath}" />
                <input id='news_cover_image_position' name="news_cover_image_position" type="hidden" value="{CoverImageBackgroundPosition}" />
                &nbsp;<?= form_error('news_cover_image'); ?><br>

                <span class="item">{gird_column_NewsContent} : </span>
                <a id="news_content_tinymce" targetURL="content" href="#content">{news_anchor_here_to_edit}</a><br>
                <?= form_error('news_content'); ?><br>
                <textarea name="news_content" id="news_content" style="display:none;" >
                    <?= set_value('news_content','{Content}'); ?>
                </textarea>


                <span class="item">{gird_column_IsShow} : </span>
                <select style="width:160px;" name='news_is_show'>
                      <option value="0" <?= set_select('news_is_show', '0',TRUE); ?>>{news_disappear}</option>
                      <option value="1" <?= set_select('news_is_show', '1'); ?>>{news_appear}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="pane-footer">
        <input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;"/>        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_cancel}&nbsp;&nbsp;"/>
    </div>
   </form>  
</div>


<script>
    function responsive_filemanager_callback(field_id){ 
        var img_url = $('#'+field_id).val() || '';
        var img_thumbs = img_url.replace('/repositories/','/repositories/thumbs/');
        switch(field_id){
            case 'news_cover_image':
                $('#news_cover_image_position').val('0px 0px');
                $('div.news_cover_image').html("&nbsp;").css('background-image','url('+img_url+')').backgroundDraggable({                    done:function(e){                        $('#news_cover_image_position').val($(e).css('backgroundPosition'));                    }                });
                $('#news_cover_image_thumb').val(img_thumbs);
            break;
        }
    }
    $(function () {
        if( '{CoverImageURLPath}' != '' && '{CoverImageURLPath}' != ''){
            $('div.news_cover_image').html("&nbsp;").css({            }).backgroundDraggable({                done:function(e){                    $('#product_cover_image_position').val($(e).css('backgroundPosition'));                }            });
        }
        $('#news_content_tinymce').bind('click', function () {
            $.popupWindow('/admin/news/mce/'+$(this).attr('targetURL'), { 
                height: 600, 
                width: 880,
                createNew: true,
                resizable:   true,
                onUnload: function(){
                    
                }
            });
        })
        $('#news_short_desc_tinymce').bind('click', function () {
            $.popupWindow('/admin/news/clear_mce/'+$(this).attr('targetURL'), { 
                height: 600, 
                width: 880,
                createNew: true,
                resizable:   true,
                onUnload: function(){
                    
                }
            });
        })

        $('select[name=news_is_show]').val('<?= set_value('news_is_show','{IsShow}'); ?>');
        
    });

</script>
