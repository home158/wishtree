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
            <form id="yw0" action="/register" method="POST">&nbsp;或使用 E-mail 註冊<br>
                <span class="item">{gird_column_Email}</span>
                <input name="email" id="Member_email" type="text" value="<?php echo set_value('email'); ?>" /><br> 
                <em class="note">{members_email_no_changed}</em><br>
                <?php echo form_error('email'); ?><br>

                <span class="item">{gird_column_Password}</span>
                <input name="password" id="Member_name" type="password" value="" /><br>
                <em class="note">{member_passworld_8_20_length}</em><br> 
                <?php echo form_error('password'); ?><br>

                <span class="item">{gird_column_PasswordEncrypt}</span>
                <input name="password_chk" id="Member_name" type="password" value="" /><br>
                <?php echo form_error('password_chk'); ?><br>

                <span class="item">{gird_column_Name}</span>
                <input name="name" id="Member_name" type="text" value="<?php echo set_value('name'); ?>" />      
                <input id="ytMember_gender" type="hidden" value="" name="Member[gender]" />
                      <span id="Member_gender">
                          <input id="Member_gender_0" value="0" checked="checked" type="radio" name="gender" /> 
                          <label for="Member_gender_0">{gender_male}</label>
                          <input id="Member_gender_1" value="1" type="radio" name="gender" /> 
                          <label for="Member_gender_1">{gender_female}</label>
                      </span><br>
                <em class="note">{member_name_must_real}</em><br>
                <?php echo form_error('name'); ?><br>


                <span class="item">{gird_column_City}</span>
                <select name="city" id="City_region">
                      <option value="0" <?php echo set_select('city', '0', TRUE); ?>>請選擇居住縣市</option>
                      <option value="1" <?php echo set_select('city', '1'); ?>>基隆市</option>
                      <option value="2" <?php echo set_select('city', '2'); ?>>台北市</option>
                      <option value="3" <?php echo set_select('city', '3'); ?>>新北市</option>
                      <option value="4" <?php echo set_select('city', '4'); ?>>桃園縣</option>
                      <option value="5" <?php echo set_select('city', '5'); ?>>新竹市</option>
                      <option value="6" <?php echo set_select('city', '6'); ?>>新竹縣</option>
                      <option value="7" <?php echo set_select('city', '7'); ?>>苗栗縣</option>
                      <option value="8" <?php echo set_select('city', '8'); ?>>台中市</option>
                      <option value="9" <?php echo set_select('city', '9'); ?>>彰化縣</option>
                      <option value="10" <?php echo set_select('city', '10'); ?>>南投縣</option>
                      <option value="11" <?php echo set_select('city', '11'); ?>>雲林縣</option>
                      <option value="12" <?php echo set_select('city', '12'); ?>>嘉義市</option>
                      <option value="13" <?php echo set_select('city', '13'); ?>>嘉義縣</option>
                      <option value="14" <?php echo set_select('city', '14'); ?>>台南市</option>
                      <option value="15" <?php echo set_select('city', '15'); ?>>高雄市</option>
                      <option value="16" <?php echo set_select('city', '16'); ?>>屏東縣</option>
                      <option value="17" <?php echo set_select('city', '17'); ?>>台東縣</option>
                      <option value="18" <?php echo set_select('city', '18'); ?>>花蓮縣</option>
                      <option value="19" <?php echo set_select('city', '19'); ?>>宜蘭縣</option>
                      <option value="20" <?php echo set_select('city', '20'); ?>>澎湖縣</option>
                      <option value="21" <?php echo set_select('city', '21'); ?>>金門縣</option>
                      <option value="22" <?php echo set_select('city', '22'); ?>>連江縣</option>
                </select><br>
                <em class="hidden-head" id="Client_region_note">{member_city_must_select}</em><br>
                <?php echo form_error('city'); ?>
                <br>
                <br>    


                
                      <input type="submit" class="btn-calm-m" value="{button_register}" />

            </form>

        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>

