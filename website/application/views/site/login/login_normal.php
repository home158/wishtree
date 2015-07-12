<div id="content">

    <div class="clearfix">
        
        <div class="contentl fl">

            <!-- Login content -->


            <div class="login-intro">
                <h2>「我的願望，最有力量!」</h2>
                <p> 芸芸眾生中普通的一員，一個真實而平凡的人，卻有著自己的願望，自己的性格和追求。<br>
                </p>
            </div>
        </div>
        <!-- sidebar -->

            <!-- login -->
            <div class="wrap-box login-box fr">
                    <div class="wrap-inner blk-login">
                        <h3>{login_form_title}</h3>
                        <form action="/login" method="POST">
                            <div class="field">
                                <label>{login_email}</label>
                                <div><input type="email" name="email" value="" title="{login_email_require}" required="required" class="l" tabindex="1" id="searchterm" autofocus="autofocus" accesskey="s"></div>
                                <?= form_error('email'); ?>
                            </div>
    
                            <div class="field">
                                <label>{login_password}</label>
                                <div><input type="password" name="password" title="{login_password_require}" tabindex="2" required="required" class="l"></div>
                                <input type="hidden" name="password_encrypt"  >
                                <?= form_error('password'); ?>
                            </div>
                        
                            <div class="func">
                                <label><input type="submit" value="{btn_login}" class="btn-relax btn-m"></label>
                                <label for="remember_me" class="keepin"><input name="remember_me" type="checkbox" id="remember_me" value="1" checked>{login_remember_me}</label>
                            </div>
                            <em class="form_error">{return_msg}</em>
                        </form>
    
                        <div class="help "><a href="/login/forgot_passwd.php">{login_forgot_password}</a>｜<a href="/register">{login_register}</a></div>
                    </div>
            </div>
        
    </div>
 </div>

<script>
$(function() {
    $('input[name=email]').val($.cookie("WG_email"));
    $('input[name=password]').val($.cookie("WG_password")).change(function(){
        $('input[name=password_encrypt]').val('');
    });
    $('input[name=password_encrypt]').val($.cookie("WG_password"));
});
    
</script>