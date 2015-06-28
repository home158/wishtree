
<div id="footer">
  <div class="ft clearfix">
    <div class="language fl">
      <p class="hd">請選擇語系</p>
        <span><a class="lang_choose" lang_code="en-us">English</a></span>
        <span><a class="lang_choose" lang_code="zh-tw">繁中</a></span>
        <span><a class="lang_choose" lang_code="zh-cn">简中</a></span>
		</div>
    <!--language end-->
    <div class="about fl">
      <p class="hd">關於 a SugarDating</p>
      <ul>
        <li><a href="http://www.asugardating.com/pages/privacy.html">隱私政策</a></li>
        <li><a href="http://www.asugardating.com/pages/about_us.html">關於我們</a></li>
        <li><a href="http://www.asugardating.com/pages/terms.html">使用條款</a></li>
        <li><a href="mailto:service@asugardating.com">聯絡我們</a></li>
      </ul>
    </div>
    <!--about end-->
    <div class="tool fr">
      <p class="hd">相約在 a SugarDating</p>
      <ul>
        <li><a href="http://www.asugardating.com/register_1.html">免費註冊</a></li>
      </ul>
    </div>
    <!--tool end-->
  </div>
  <!--ft end-->
</div>
<!--footer end-->
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
