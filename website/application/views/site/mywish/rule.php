<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li>
                        <a data-load="main_content" href="/mywish/make" class="ctrl">{mywish_make_a_wish}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish" class="ctrl">{mywish_wish_online}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/pending" class="ctrl">{mywish_wish_pending}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/reject" class="ctrl">{mywish_wish_reject}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/expire" class="ctrl">{mywish_wish_expire}</a>
                    </li>
                    <li >
                        <a data-load="main_content" href="/mywish/removed" class="ctrl">{mywish_wish_delete}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/mothball" class="ctrl">{mywish_wish_mothball}</a>
                    </li>
                    <li class="active">
                        <a data-load="main_content" href="/mywish/rule" class="ctrl">{mywish_wish_rule}</a>
                    </li>
                </ul>
        </div>
        <p class="hd">{mywish_wish_rule}</p>
        <ol>
            <li>
                {mywish_rule1}
            </li>
            <li>
                {mywish_rule2}
            </li>
            <li>
                {mywish_rule3}
            </li>
            <li>
                {mywish_rule4}
            </li>
            <li>
                {mywish_rule5}
            </li>
            <li>
                {mywish_rule6}
            </li>
            <li>
                {mywish_rule7}
            </li>
        </ol>
        <p class="hd">{mywish_review_principle}</p>
        <ol>
            <li>
                {mywish_review_principle1}
            </li>
            <li>
                {mywish_review_principle2}
            </li>
            <li>
                {mywish_review_principle3}
            </li>
            <li>
                {mywish_review_principle4}
            </li>
            <li>
                {mywish_review_principle5}
            </li>
            <li>
                {mywish_review_principle6}
            </li>
        </ol>
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
