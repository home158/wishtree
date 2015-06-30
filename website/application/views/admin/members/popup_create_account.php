<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{members_create}</h1>
    </div>

    <form enctype="multipart/form-data" id="signup-form" action="/admin/members/create" method="post">
        <div class="container block blk-reg">
            <div class="inside">

                <span class="item">{gird_column_Rank} : </span>
                <select name="rank" id="Rank">
                    <option value="1" <?php echo set_select('rank', '1', TRUE); ?>>{rank_normal_confirmed}</option>
                    <option value="0" <?php echo set_select('rank', '0'); ?>>{rank_forbidden}</option>
                    <option value="255" <?php echo set_select('rank', '255'); ?>>{rank_admin}</option>
                </select><br><br>

                <span class="item">{gird_column_Email} : </span>
                <input name="email" id="Member_email" type="text" value="<?php echo set_value('email'); ?>" /><br> 
                <em class="note">{members_email_no_changed}</em><br>
                <?php echo form_error('email'); ?><br>

                <span class="item">{gird_column_Passeord} : </span>
                <input name="password" id="Member_name" type="password" value="" /><br>
                <em class="note">{member_passworld_8_20_length}</em><br> 
                <?php echo form_error('password'); ?><br>

                <span class="item">{gird_column_PasswordEncrypt} : </span>
                <input name="password_chk" id="Member_name" type="password" value="" /><br>
                <?php echo form_error('password_chk'); ?><br>

                <span class="item">{gird_column_Name} : </span>
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


                <span class="item">{gird_column_City} : </span>
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
                <?php echo form_error('city'); ?>
                <br>
                <br>
        </div>
    </div>
    <div class="pane-footer">
        <input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;"/>        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_cancel}&nbsp;&nbsp;"/>
    </div>
   </form>  
</div>

<script>
    $(function () {
        var CURRENT_CATEGORY = 1;
        if( typeof(window.opener.O_PARENT.tree.getCurrentRank) != 'undefined' ){
            CURRENT_CATEGORY = window.opener.O_PARENT.tree.getCurrentRank();
        }
        console.log(CURRENT_CATEGORY);

        $("select[name=rank] option")
            .each(function() { this.selected = (this.value == CURRENT_CATEGORY); });
 
    });

</script>