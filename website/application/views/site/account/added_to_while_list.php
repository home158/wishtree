<div id="content">
    <div class="action_set clearfix">
        <div class="block-wrapper clearfix">
                <ul class="tabs general" >
                    <li>
                        <a href="/account/favorite" class="ctrl">{account_my_favorite_s}</a>
                    </li>
                    <li>
                        <a href="/account/blocked" class="ctrl">{account_my_blocked_list_s}</a>
                    </li>
                    <li class="active">
                        <a href="/account/added_to_while_list" class="ctrl">{account_has_been_added_to_white_list_s}</a>
                    </li>
                </ul>
        </div>

        <ul>
            {added_list}
            <li class="user clearfix">
                <div class="avatar">
                    <a href="/view/{UserGUID}"><img src="{ThumbBasename}"></a>
                </div>
                <div class="message-info">
                    <div class="identity">
                        <div class="identity-content">
                            <a href="/view/{UserGUID}">{db_Nickname}</a>,
                            <strong>{YearsOld}</strong> {view_years_old},
                            {City}                              
                        </div>
                    </div>
                </div>
                      
            </li>
            {/added_list}
        </ul>
    </div>
 </div>

<script>
$(function() {



});
</script>