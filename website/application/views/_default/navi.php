<div class="feature-navi clr">
    <div>
    <div class="navi-list">
        <div class="top-line"></div>
        <div class="middle-line">
            <ul>
                <li id="brand" class="brand">
                    <a href="/brand"></a>
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="brand-0">
                                    <a href="/brand/story"></a>
                                </li>
                                <li class="brand-1">
                                    <a href="/brand/spirite"></a>
                                </li>
                                <li class="brand-2">
                                    <a href="/brand/concept"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </li>
                <li id="news" class="news">
                    <a href="/news"></a>
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="news-0">
                                    <a href="/news/more"></a>
                                </li>
                                <li class="news-1">
                                    <a href="/news/promotion"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </li>
                <li id="notepad" class="notepad">
                    <a href="/notepad"></a>
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="notepad-0">
                                    <a href="/notepad/farm_village"></a>
                                </li>
                                <li class="notepad-1">
                                    <a href="/notepad/process"></a>
                                </li>
                                <li class="notepad-2">
                                    <a href="/notepad/growing"></a>
                                </li>
                                <li class="notepad-3">
                                    <a href="/notepad/vegetable"></a>
                                </li>
                                <li class="notepad-4">
                                    <a href="/notepad/farmer"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </li>
                <li id="seasonal" class="seasonal">
                    <a href="/seasonal"></a>
                    <!--
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="seasonal-0">
                                    <a href="/seasonal"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                    -->
                </li>
                <li id="market" class="market">
                    <a href="/market/category"></a>
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="market-0">
                                    <a href="/market/category"></a>
                                </li>
                                <li class="market-1">
                                    <a href="/market/rule"></a>
                                </li>
                                <!--
                                <li class="market-2">
                                    <a href="/market/faq"></a>
                                </li>
                                -->
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </li>
                <li id="member" class="member">
                    <a href="/member"></a>
                    <div class="sub-list">
                        <div class="top-line"></div>
                        <div class="middle-line">
                            <ul class="inner-list">
                                <li class="member-0">
                                    <a href="/member/modify"></a>
                                </li>
                                <li class="member-1">
                                    <a href="/order/history"></a>
                                </li>
                                <li class="member-2">
                                    <a href="/order/query"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-line"></div>
                    </div>
                </li>
                <li id="contact" class="contact">
                    <a href="/contact"></a>
                </li>
            </ul>
            <div class="member_feature">
                <div class="shopping_car">
                    <a href="/order/shopping_car">
                    <span class="img_shopping_car"></span><span class="img_shopping_car_txt"></span>
                    <span class="img_shopping_car_count" >{order_num_rows}</span>
                    </a>
                </div>
                <div class="member_login_weleome session_exist">
                    <a class="member_name" href="#">{Name}</a><span class="img_member_login_weleome"></span>
                </div>
                <div class="member_login_link session_not_exist">
                    <a href="/login/normal" class="img_member_login"></a><span class="img_slash"></span><a href="/register" class="img_register"></a>
                </div>
                <div class="member_logout session_exist">
                    <a href="/logout" class="img_member_logout"></a>
                </div>
                <div class="admin_login_link session_not_exist">
                    <a href="/login/admin" class="img_admin_login"></a>
                </div>
            </div>
        </div>

        <div class="bottom-line"></div>
        <div class="google_fb_login session_not_exist">
            <a href="/register/google_login" class="img_google_login"></a>
            &nbsp;&nbsp;
            <a href="/register/fb_login" class="img_fb_login"></a>
        </div>
        <p class="copyright">Copyright © ShanFarm <br/>2015 all rights reserved.</p>
    </div>
    <a href="/" ><img src="/_images/navi-logo.png"/></a>
    </div>
</div>
<script>
$(window).scroll(function(){
    if( $(window).scrollTop() > 53 ){
        var left = $('.feature-navi').offset().left ;
        $('.feature-navi').css('left',left).addClass('floating');
    }else{
        $('.feature-navi').css('left','auto').removeClass('floating');
    }
});
$(function() {
  $('#{highlight_main_list}').addClass('highlight').find('.sub-list').show().find('ul li:eq({highlight_sub_lsit})').addClass('highlight');
  $('.{session_control}').show();
});
</script>