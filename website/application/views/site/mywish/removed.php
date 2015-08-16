<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li>
                        <a href="/mywish/make" class="ctrl">{mywish_make_a_wish}</a>
                    </li>
                    <li>
                        <a href="/mywish" class="ctrl">{mywish_wish_online}</a>
                    </li>
                    <li>
                        <a href="/mywish/pending" class="ctrl">{mywish_wish_pending}</a>
                    </li>
                    <li>
                        <a href="/mywish/reject" class="ctrl">{mywish_wish_reject}</a>
                    </li>
                    <li class="active">
                        <a href="/mywish/removed" class="ctrl">{mywish_wish_delete}</a>
                    </li>
                    <li>
                        <a href="/mywish/mothball" class="ctrl">{mywish_wish_mothball}</a>
                    </li>
                    <li>
                        <a href="/mywish/expire" class="ctrl">{mywish_wish_expire}</a>
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
                    <div class="read_model">

                        <div class="wish_title">
                            [{WishCategory}] {WishTitle}
                        </div>
                        <div class="wish_content">
                            {WishContent}
                        </div>
                    </div>
                    <div class="wish_ctrl">

                        <span class="btn_mothball btn btn-danger btn-sm " data-guid="{db_GUID}" >
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>{btn_mothball}</span>
                        </span>
                        
                    </div>
                </div>

            </div>
            {/mywish_list}
    </div>
</div>
<script>
    $('.btn_mothball').on('click',function(){
        var $read_model = $(this).parent().parent().find('.read_model');
        var GUID = $(this).attr('data-guid');
        if(confirm('{mywish_mothball_comfirm_msg}')){
            $.ajax({
                url: '/mywish/action_mothball',
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

</script>
