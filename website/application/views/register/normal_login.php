<div class="container">
    <div class="banner-img banner-img-member">

    </div>
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-member-center.png"/>
    </div>
    <div class="content block blk-reg">
        <div>
            <a href="/register/google_login" class="img_inside_google_login"></a>
            &nbsp;&nbsp;
            <a href="/register/fb_login" class="img_inside_fb_login"></a>
        </div>
        <br>
        <div class="inside">
            <form id="yw0" action="/login/normal" method="POST">&nbsp;或使用 E-mail 登入<br>
                <span class="item">Email</span>
                <input id="emailText" name="email" type="text" value="<?php echo set_value('email'); ?>"/><br>
                <?php echo form_error('email'); ?>
                <br>

                <span class="item">密碼</span>
                <input name="password" id="LoginForm_password" type="password" value="<?php echo set_value('password'); ?>"/>      &nbsp;
                <br>
                <em><?php echo form_error('password'); ?></em>
                <br>
                <br>

                <label><input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]" />
                    <input checked="checked" name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox" /> 記得我</label>
                &nbsp;&nbsp;
                      <input type="submit" class="btn-calm-m" value="登入">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/login/forgot_password">忘記密碼</a>
                <br><br

            </form>

        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>

