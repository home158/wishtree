</div>
<!--"main-content end-->

<div id="footer">
  <div class="ft clearfix">
    <div class="timezone">
      <p class="hd">{footer_select_timezone}</p>
    </div>
    <!--timezone end-->

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
        <li><a href="/register">{footer_register_free}</a></li>
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
    $(document).delegate('*[data-load="main_content"]', 'click', function(event) {
        var href = $(this).attr("href");
        loadMainContent(href);
	    // HISTORY.PUSHSTATE
	    history.pushState('', 'New URL: '+href, href);
	    event.preventDefault();
    });
    // THIS EVENT MAKES SURE THAT THE BACK/FORWARD BUTTONS WORK AS WELL
    window.onpopstate = function(event) {
    	loadMainContent(location.pathname);
    };
    var loadMainContent = function(href){
        var navi = ['home','wish','message','chat','mywish','photo','account','fortune'];
        var highlight_id = href.replace('/','');
        if( $.inArray(highlight_id , navi) != -1 ){
            $('#navi a').removeClass('highlight');
            $('#navi a#'+highlight_id).addClass('highlight');
        }
        $.ajax({
            url: href,
            dataType: 'html',
            type: 'POST',
            data: {
                ajax : 1
            },
            success: function(r) {
                $('#main_content').html(r);
            },
            complete : function(){
            
            }
        });
    };
});
    
</script>