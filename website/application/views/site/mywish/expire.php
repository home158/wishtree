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
                    <li>
                        <a data-load="main_content" href="/mywish/pending" class="ctrl">{mywish_wish_pending}</a>
                    </li>
                    <li>
                        <a data-load="main_content" href="/mywish/reject" class="ctrl">{mywish_wish_reject}</a>
                    </li>
                    <li class="active">
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
                    <div class="expire_date"><span class="label label-{DateExpireClass}">{DateExpire}</span></div>
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
                            <a data-load="main_content" href="/mywish/view/{db_GUID}">[{WishCategory}] {WishTitle}</a>
                        </div>
                        <div class="wish_content">
                            {WishContent}
                        </div>
                    </div>
                    <div class="wish_ctrl">

                        
                    </div>
                </div>

            </div>
            {/mywish_list}
    </div>
</div>
