<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li>
                        <a href="/mywish/make" class="ctrl">{mywish_make_a_wish}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish" class="ctrl">{mywish_wish_online}</a>
                    </li>
                    <li class="active">
                        <a data-load="main_content" href="/mywish/pending" class="ctrl">{mywish_wish_pending}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/reject" class="ctrl">{mywish_wish_reject}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/expire" class="ctrl">{mywish_wish_expire}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/removed" class="ctrl">{mywish_wish_delete}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/mothball" class="ctrl">{mywish_wish_mothball}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/rule" class="ctrl">{mywish_wish_rule}</a>
                    </li>
                </ul>
        </div>
            {mywish_list}
            <div class="wish_card clearfix">
                <div class="fl">
                    <a href="/view/{UserGUID}"><img src="{ThumbBasename}"></a>
                </div>
                <div class="fl identity-content ">
                    <div>
                        <a href="/view/{UserGUID}">{db_Nickname}</a>,
                        <strong>{YearsOld}</strong> {view_years_old},
                        {City}
                    </div>
                    <div class="edit_model">
                        <div class="input-group">
                          <div class="input-group-btn">
                            <span type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span data-value="{db_WishCategory}" class="wish_category">{WishCategory}</span> <span class="caret"></span></span>
                            <ul class="dropdown-menu">
                              <li><a data-value="food" href="javascript:">{mywish_category_food}</a></li>
                              <li><a data-value="shopping" href="javascript:">{mywish_category_shopping}</a></li>
                              <li><a data-value="travel" href="javascript:">{mywish_category_travel}</a></li>
                              <li><a data-value="gift" href="javascript:">{mywish_category_gift}</a></li>
                              <li><a data-value="mind" href="javascript:">{mywish_category_mind}</a></li>
                              <li><a data-value="others" href="javascript:">{mywish_category_others}</a></li>
                            </ul>
                          </div><!-- /btn-group -->
                          <input name="wish_title" class="form-control" type="text" value="{WishTitle}" />
                        </div><!-- /input-group -->
                        
                        <div class="wish_content">
                            <textarea name="wish_content" >{db_WishContent}</textarea>
                            
                        </div>

                    </div>
                    <div class="read_model">

                        <div class="wish_title">
                            [{WishCategory}] {WishTitle}
                        </div>
                        <div class="wish_content">
                            {WishContent}
                        </div>
                    </div>
                    <div class="wish_ctrl">

                        <span class="btn_edit btn btn-success btn-sm " data-guid="{db_GUID}" >
                            <i class="glyphicon glyphicon-edit"></i>
                            <span>{btn_edit}</span>
                        </span><span class="btn_cancel btn btn-warning btn-sm " data-guid="{db_GUID}" >
                            <i class="glyphicon glyphicon-arrow-left"></i>
                            <span>{btn_cancel}</span>
                        </span><span class="btn_submit btn btn-primary btn-sm " data-guid="{db_GUID}" >
                            <i class="glyphicon glyphicon-saved"></i>
                            <span>{btn_submit}</span>
                        </span><span class="btn_delete btn btn-danger btn-sm " data-guid="{db_GUID}" >
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>{btn_delete}</span>
                        </span>
                        
                    </div>
                </div>

            </div>
            {/mywish_list}
    </div>
</div>
<script>
    $('.btn_delete').on('click',function(){
        var $read_model = $(this).parent().parent().find('.read_model');
        var GUID = $(this).attr('data-guid');
        if(confirm('{mywish_delete_comfirm_msg}')){
            $.ajax({
                url: '/mywish/delete',
                dataType:'json',
                type: 'POST',
                data: {
                    GUID : GUID
                },
                success: function(r) {
                    if(r.error_code == 0){
                        $read_model.parent().parent().fadeOut();
                    }else{
                        alert(r.content);
                    }
                }
            });
        }
    });
    $('.btn_edit').on('click',function(){
        $(this).hide();
        $(this).parent().find('.btn_submit').show();
        $(this).parent().find('.btn_cancel').show();
         
        var $read_model = $(this).parent().parent().find('.read_model');
        var h = $read_model.find('.wish_content').height();
        $read_model.hide();

        var $edit_model = $(this).parent().parent().find('.edit_model');
        $edit_model.show();

        console.log(h);
        $edit_model.find('.wish_content').height(h);
    });
    $('.btn_cancel').on('click',function(){
        var $edit_model = $(this).parent().parent().find('.edit_model');
        var $read_model = $(this).parent().parent().find('.read_model');

        $(this).hide();
        $(this).parent().find('.btn_edit').show();
        $(this).parent().find('.btn_cancel').hide();
        $(this).parent().find('.btn_submit').hide();
        $edit_model.hide();
        $read_model.show();
    });
    $('.btn_submit').on('click',function(){
        var $edit_model = $(this).parent().parent().find('.edit_model');
        var $read_model = $(this).parent().parent().find('.read_model');

        var wish_title = $edit_model.find('input[name=wish_title]').val();
        var wish_content = $edit_model.find('textarea[name=wish_content]').val();
        if(!wish_title || !wish_content){
            alert('{mywish_title_content_not_null}');
            return;
        }

        $(this).hide();
        $(this).parent().find('.btn_edit').show();
        $(this).parent().find('.btn_cancel').hide();
        $edit_model.hide();
        $read_model.show();
        $.ajax({
            url: '/mywish/update',
            dataType:'json',
            type: 'POST',
            data: {
                GUID : $(this).attr('data-guid'),
                wish_category :$edit_model.find('.wish_category').attr('data-value'),
                wish_title : wish_title,
                wish_content : wish_content
            },
            success: function(r) {
                if(r.error_code == 0){
                    $read_model.find('.wish_title').text('['+r.content.wish_category+'] '+r.content.wish_title);
                    $read_model.find('.wish_content').html(r.content.wish_content);
                    alert(r.content.result);
                }else{
                    alert(r.content);
                }
            }
        });
    });
    $('.edit_model ul a').on('click',function(){
        $(this).parent().parent().parent().find('.wish_category').text( $(this).text() );
        $(this).parent().parent().parent().find('.wish_category').attr('data-value' , $(this).attr('data-value') );
    });

</script>
