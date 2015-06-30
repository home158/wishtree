<div class="container">
    <div class="banner-img banner-img-news">

    </div>
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-news-center.png"/>
    </div>
    <div class="content block blk-reg">
        <div class="inside">
            {news_lists}
            <div class="news_lists">
                <div class="news_title">{Title}</div>
                <div class="news_short_desc"><p>{ShortDesc}</p></div>
                <div class="news_more">
                    <a href="/news/more/{NEWS_GUID}"><img src="/_images/more_news.png" /></a>
                </div>
                <div class="news_cover_image" style="background-image:url({CoverImageURLPath});background-position:{CoverImageBackgroundPosition};)"></div>
            </div>
            {/news_lists}
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>
<script>
$(function() {
    $('.news_lists:nth-child(odd)').addClass('oddchild');
    $('.news_lists:nth-child(even)').addClass('evenchild');
});
    
</script>