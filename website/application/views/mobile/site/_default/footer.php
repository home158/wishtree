
<div id="footer">
  <div class="ft clearfix">


    <div class="language tc">
        <p class="hd">{footer_select_lang}
            <span class="item"><a class="lang_choose" lang_code="en-us">English</a></span>
            <span class="item"><a class="lang_choose" lang_code="zh-tw">{footer_lang_zh_tw}</a></span>
            <span class="item"><a class="lang_choose" lang_code="zh-cn">{footer_lang_zh_cn}</a></span>
        </p>
    </div>
    <!--language end-->

    <div class="footer-links">
        <a href="/privacy.html">{footer_privacy}</a>
        <span>|</span>
        <a href="/about.html">{footer_about}</a>    
        <span>|</span>
        <a href="/terms.html">{footer_terms}</a>
        <span>|</span>
        <a href="mailto:home158@gmail.com">{footer_contact}</a>
    </div>
    <!--footer-links end-->
  </div>
  <!--ft end-->
</div>
<!--footer end-->
</div>
<!--wrap end-->
<script>

$(function() {
    $('#footer a.lang_choose').bind('click',function(){
        var lang_code = $(this).attr('lang_code');
        $.ajax({
            url: '/action/save_lang',
            dataType: 'json',
            type: 'POST',
            data: {
                lang : lang_code
            },
            complete:function(){
                $.cookie("WG_lang", lang_code , {
                   expires : 30,

                   path    : '/'
                });
                window.location.reload();
            }
        });
    });
});
    
</script>

    </body>
</html>
