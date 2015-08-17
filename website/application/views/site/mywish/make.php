<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li class="active">
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
                    <li>
                        <a href="/mywish/expire" class="ctrl">{mywish_wish_expire}</a>
                    </li>
                    <li>
                        <a href="/mywish/removed" class="ctrl">{mywish_wish_delete}</a>
                    </li>

                    <li>
                        <a href="/mywish/mothball" class="ctrl">{mywish_wish_mothball}</a>
                    </li>
                </ul>
        </div>
        <div>
            <p class="redF hd">您的願望必須經過人工審核，審核通過才能被其它會員瀏覽。</p>
        </div>
            <div class="fl  clearfix blk-wish">


                <form id="make_wish" role="form" action="/mywish/make" method="post">
                    <div>
                        <span class="item" style="position: absolute;">{mywish_category} : </span>

                        <div id="mywish_category" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="wish_category" value="food" <?= set_radio('wish_category', 'food'); ?>>
                                {mywish_category_food} </label>
                            <label class="btn btn-default ">
                                <input type="radio" name="wish_category" value="shopping" <?= set_radio('wish_category', 'shopping'); ?>>
                                {mywish_category_shopping} 
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="wish_category" value="travel" <?= set_radio('wish_category', 'travel'); ?>>
                                {mywish_category_travel} 
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="wish_category"  value="gift" <?= set_radio('wish_category', 'gift'); ?>>
                                {mywish_category_gift} 
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="wish_category" value="mind" <?= set_radio('wish_category', 'mind'); ?>>
                                {mywish_category_mind} 
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="wish_category" value="others" <?= set_radio('wish_category', 'others'); ?>>
                                {mywish_category_others} 
                            </label>
                            <br>
                            <em class="note"></em><br>
                            <?= form_error('wish_category'); ?><br>

                        </div>
                    </div>

                    <div>
                        <span class="item">{mywish_title} : </span>
                        <input name="wish_title" type="text"  value="<?= set_value('wish_title'); ?>" />
                        <em class="note"></em><br>
                        <?= form_error('wish_title'); ?><br>

                    </div>
                    <div>
                        <span class="item" style="position: absolute;">{mywish_write_your_wish} : </span>
                        <textarea name="wish_content" ><?= set_value('wish_content'); ?></textarea>
                        <em class="note"></em><br>
                        <?= form_error('wish_content'); ?><br>

                    </div>


                    <span id="btn_submit" class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-ok"></i>
                        <span>{btn_submit}</span>
                    </span>
                </form>
            </div>
            <div class="fr">
            </div>
        </div>
    </div>
</div>
<script>
    console.log( $('input[name="wish_category"]:checked').val() );
    $('input[name="wish_category"]:checked').parent().addClass('active');
    
    $('#btn_submit').on('click',function(){
        $('form#make_wish').submit();
    });
</script>
