<div class="container">
    <div class="banner-img banner-img-member">

    </div>
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-member-center.png"/>
    </div>
    <div class="content block blk-reg-forgot">
        <div class="inside" >
            <div class="return_msg">
            <div class="register_email_verification">{member_login_forgot_password}</div>
            <div>
                <form id="yw0" action="/login/forgot_password" method="POST">
                    
                    <span class="item">請填入當初註冊的 E-mail：</span>
                    <input name="email" id="Member_email" type="text" value="<?php echo set_value('email'); ?>" /><br> 
                    <?php echo form_error('email'); ?><br><br>
                      <input type="submit" class="btn-calm-m" value="{button_submit}" />
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>

</div>
