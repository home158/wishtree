<div id="content">
    <div class="message_set bg clearfix">
        <div class="well well-lg clearfix">
            <div class="home_left fl ">
                <p>{home_welcome} </p>
                <div class="catwalk  clearfix">
                    <p class="title">{role_random_title}！</p>
                    <ul>
                        {random_user}
                        <li class="user_list">
                            <a href="/view/{UserGUID}"><img src="{ThumbBasename}"></a>
                            <span name="status_{UserGUID}" class="status-wrapper offline" title="Online now">
                                <span class="icon"></span>
                            </span>
                        </li>
                        {/random_user}
                    <ul>
                </div>
                <div class="catwalk clearfix">
                    <p class="title">新進會員！</p>
                    <ul>
                        {newcomer_user}
                        <li class="user_list"><a href="/view/{UserGUID}"><img src="{ThumbBasename}"></a></li>
                        {/newcomer_user}
                    <ul>
                </div>
            </div>
            <div class="home_right fr ">a
            </div>
        </div>
    </div>
</div>
