<div id="content">
    <div class="mywish_set clearfix">
        <div class="block-wrapper clearfix">
            {wish_list}
            <div class="wish_card fl clearfix">
                <div class="fl">
                    <a data-load="main_content" href="/wish/view/{db_GUID}"><img src="{ThumbBasename}"></a>
                </div>
                <div class="fl identity-content ">
                    <div class="expire_date"><span class="label label-{DateExpireClass}">{DateExpire}</span></div>
                    <div>
                        <a data-load="main_content" href="/view/{UserGUID}">{db_Nickname}</a>,
                        <strong>{YearsOld}</strong> {view_years_old},
                        {City}
                    </div>
                    <div class="read_model">

                        <div class="wish_title">
                            <a data-load="main_content" href="/wish/view/{db_GUID}">[{WishCategory}] {WishTitle}</a>
                        </div>
                        <div class="wish_content">
                            {WishContent}
                        </div>
                    </div>
                </div>
            </div>
            {/wish_list}
        </div>

    </div>
</div>
<script>


</script>
