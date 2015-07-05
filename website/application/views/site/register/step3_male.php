<link href="/_css/bootstrap-formhelpers.min.css" rel="stylesheet">

<script src="/_js/bootstrap-formhelpers.min.js"></script>
<script src="/_js/jquery.twzipcode.min.js"></script>
<div id="content">    
    <div class="ct clearfix">
        <div class="msg">
            <p class="hd">{register_step3}</p>
            <p></p>
        </div>
        <div class="login_gp">
            <div class="login_type borR register ">
                
                <div class="well well-lg  msg clearfix blk-reg">
                    <form name="register" action="/register/male" method="post">
                        <p class="redF hd ">{register_under_review_cannot_post}</p>
                        <p class="hd">{register_part1}</p>
                        <div>
                            <span class="item">{grid_column_Gender}</span>
                            {register_male}
                            <br>
                            <br>
                           <span class="item">{grid_column_Email} : </span>
                            <input name="email" type="text" value="<?= set_value('email'); ?>" />
                            <em class="note"></em><br>
                            <?= form_error('email'); ?><br>
                           

                            <span class="item">{grid_column_Password}</span>
                            <input name="password" type="password" value="" /><br>
                            <em class="note">{member_password_8_20_length}</em><br>
                            <?= form_error('password'); ?><br>
            
                            <span class="item">{grid_column_PasswordCheck}</span>
                            <input name="password_chk" type="password" value="" /><br>
                            <?= form_error('password_chk'); ?><br>
            
                        </div>
                        <p class="section"></p>
                        <p class="hd">{register_part2}</p>
                        <div>
                            <span class="item" >{grid_column_Nickname}</span>
                            <input name="nickname" type="text" value="<?= set_value('nickname'); ?>" />
                            <em class="note"></em><br>
                            <?= form_error('nickname'); ?><br>

                            <span class="item" style="position: absolute;">{grid_column_AboutMe}</span>
                                <textarea name="aboutme" ><?= set_value('aboutme'); ?></textarea>
                            <em class="note"></em><br>
                            <?= form_error('aboutme'); ?><br>
                        </div>
                        <p class="section"></p>
                        <p class="hd">{register_part3}</p>
                        <div>
                            <span class="item"  style="margin-top:10px;position: absolute;">{grid_column_National}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox bfh-countries" data-country="TW" data-flags="true" data-blank="false"></div>
                            <em class="note"></em><br>
                            <?= form_error('nickname'); ?><br>


                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_City}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox bfh-states" data-country="TW" data-blank="false">
                            </div>
                            <?= form_error('city'); ?><br>

                        </div>

                        <p class="section"></p>
                        <p class="hd">{register_part4}</p>
                        <div>
                            <span class="item" style="position: absolute;">{grid_column_IdealMatch}</span>
                                <textarea name="idealMatch" ><?= set_value('idealMatch'); ?></textarea>
                            <em class="note"></em><br>
                            <?= form_error('idealMatch'); ?><br>
                            

                        </div>
                        
                        <p class="redF hd">{register_under_review_cannot_post}</p>
	                    <p class="tc">
                          <input id="go_step2" type="submit" class="btn-xl btn-ele" value="{register_submit}">
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#twzipcode').twzipcode({
        countyName : 'city',
        readonly:true
    });
});
	
</script>