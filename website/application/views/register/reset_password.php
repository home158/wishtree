<div class="container">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-member-modify-center.png"/>
    </div>
    <div class="content block blk-reg">
        <div class="inside">
            <form enctype="multipart/form-data" id="signup-form" action="" method="post">
            
                <span class="item">{gird_column_Email} : </span>
                {Email}
                <input name="email" id="Member_email" type="hidden" value="{Email}" />
                <em class="note"></em><br>
                <br>
                      
                <span class="item">{gird_column_PasswordReset} : </span>
                <input name="password" id="Member_name" type="password" value="" /><br>
                <em class="note">{member_passworld_8_20_length}</em><br>
                <?php echo form_error('password'); ?><br>
            
                <span class="item">{gird_column_PasswordEncrypt} : </span>
                <input name="password_chk" id="Member_name" type="password" value="" /><br>
                <?php echo form_error('password_chk'); ?><br>
            
                <br>
                <br><br>
                <div class="pane-footer">
                    <input id="searchBtn" type="submit" class="btn-calm-m" value="{button_submit}"/>                    <input id="cancelBtn" type="reset" class="btn-calm-m" value="{button_reset}"/>            
                </div>
            </form>  

        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>

</div>
<script>
    $(function () {
        $('#Member_gender_'+{Gender}).prop("checked", true);
        $('#City_region').val({City});
    });
</script>