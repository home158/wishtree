
<div id="footer">
  <div class="ft clearfix">
    <div class="language">
      <p class="hd">{footer_select_lang}</p>
        <span><a class="lang_choose" lang_code="en-us">English</a></span>
        <span><a class="lang_choose" lang_code="zh-tw">{footer_lang_zh_tw}</a></span>
        <span><a class="lang_choose" lang_code="zh-cn">{footer_lang_zh_cn}</a></span>
    </div>
    <!--language end-->

    <div class="tool">
      <p class="hd">{footer_slogan}</p>
      <ul>
        <li><a href="http://www.asugardating.com/register_1.html">{footer_register_free}</a></li>
      </ul>
    </div>
    <!--tool end-->
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

        $.cookie("WG_lang", $(this).attr('lang_code') , {
           expires : 30,           

           path    : '/'
        });
        window.location.reload();
    });
});
    
</script>

    </body>
</html>
