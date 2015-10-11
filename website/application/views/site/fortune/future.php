<link href="/_css/bootstrap-formhelpers.min.css" rel="stylesheet">
<script src="/_js/bootstrap-formhelpers.min.js"></script>
<div id="content">
    <div class="fortune_set clearfix">
        <div class="block-wrapper clearfix">
            <ul class="tabs general" >
                <li class="active">
                    <a data-load="main_content" href="/fortune/request" class="ctrl">{fortune_request}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune" class="ctrl">{fortune_teller_info}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/pending" class="ctrl">{fortune_services}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/reject" class="ctrl">{fortune_message_to_fortune_teller}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/expire" class="ctrl">{fortune_sharing}</a>
                </li>
                <li>
                    <a data-load="main_content" href="/fortune/history" class="ctrl">{fortune_history}</a>
                </li>
            </ul>
        </div>
        <div class="login_gp">
            <div class="login_type borR register ">
                <div class="well well-lg  msg clearfix blk-reg">
                    <form id="form" action="/fortune/future" method="POST">
                        <div>
                            <!-- Services -->
                            <span class="item" style="margin-top:0px;position: absolute;">{fortune_services}</span>
                            <div style="display: inline-block;width: 100%;">
                                <span class="hd">{fortune_services_future}</span>
                                <input name="services" type="hidden" value="0" />
                            </div>
                            <br><br>
                            
                            <!-- Realname -->
                            <span class="item" >{grid_column_Nickname_or_Real}</span>
                            <input name="nickname" type="text" value="<?= set_value('nickname','{Nickname}'); ?>" />
                            <em class="note"></em><br>
                            <?= form_error('nickname'); ?><br>

                            <!-- Role -->
                            <span class="item" style="margin-top:5px;position: absolute;">{grid_column_Gender}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('role','{Role}'); ?>" data-name="role" >
                                <div data-value="female">{role_gender_female}</div>
                                <div data-value="male">{role_gender_male}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('role'); ?><br>


                            <!-- pblm_tel -->
                            <span class="item" >{grid_column_pblm_tel}</span>
                            <input name="pblm_tel" type="text" value="<?= set_value('pblm_tel'); ?>" />
                            <em class="note">範例: line:wendy787; 手機:0912345678</em><br>
                            <?= form_error('pblm_tel'); ?><br>


                            <!-- Birthday -->
                            <span class="item" style="margin-top:5px;position: absolute;">{birthday_please_select_general_calender}</span>
                            <div id="birthday_year" style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_year','{birthday_year_db}'); ?>" data-name="birthday_year" >
                                {birthday_year_options}
                            </div>
                            <div id="birthday_month" style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_month','{birthday_month_db}'); ?>" data-name="birthday_month" >
                                {birthday_month_options}
                            </div>
                            <div id="birthday_date" style="display: inline-block;width: 33%;" class="bfh-selectbox" data-value="<?= set_value('birthday_date','{birthday_day_db}'); ?>" data-name="birthday_date" >
                                {birthday_date_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_date'); ?> <?= form_error('birthday_month'); ?> <?= form_error('birthday_year'); ?><br>

                            <!-- Lunar Birthday -->
                            <span class="item" style="margin-top:0px;position: absolute;">{birthday_lunar_calender}</span>
                            <div style="display: inline-block;width: 100%;">
                                <span id="nongli"></span>
                                <input name="lunar" type="hidden" value="" />
                            </div>
                            <br><br>

                            <!-- Birthday time -->
                            <span class="item" style="margin-top:5px;position: absolute;">{birthday_hour_s}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('birthday_hour'); ?>" data-name="birthday_hour" >
                                {birthday_hour_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_hour'); ?><br>

                            <!-- Maritalstatus -->
                            <span class="item" style="margin-top:5px;position: absolute;">{grid_column_Maritalstatus}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('maritalstatus','{Maritalstatus}'); ?>" data-name="maritalstatus" >
                                <div data-value="">{maritalstatus_please_select}</div>
                                <div data-value="single">{maritalstatus_single}</div>
                                <div data-value="divorced">{maritalstatus_divorced}</div>
                                <div data-value="separated">{maritalstatus_separated}</div>
                                <div data-value="married">{maritalstatus_married}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('maritalstatus'); ?><br>

                            
                            <!-- Consultation 
                            <span class="item" style="margin-top:0px;position: absolute;">{grid_column_Consultation}</span>

                            <div style="display: inline-block;width: 100%;">
                                <input type="radio" name="consultation" id="fortune_consultation_text" /><label for="fortune_consultation_text">{fortune_consultation_text}</label>

                                <div style="width: 100%;">
                                    <div class="input-group" >
                                        <span class="input-group-addon" style="background-color:transparent;color:#000;padding-left: 0px; border: 0px;">
                                            <input name="consultation" id="fortune_consultation_comm" type="radio" ><label style="margin-bottom: 0px;" for="fortune_consultation_comm">{fortune_consultation_comm}</label>
                                        </span>

                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <span id="consultation_comm">Line</span>
                                                  <span class="caret"></span></button>
                                                  <ul class="dropdown-menu dropdown-menu-left">
                                                    <li><a >Line</a></li>
                                                    <li><a >Skype</a></li>
                                                    <li><a >Google plus</a></li>
                                                  </ul>
                                            </div>
                                        <input type="text" class="form-control" placeholder="{fortune_comm_account}">
                                    </div>
                                </div>
                                
                                <input type="radio" name="consultation" id="fortune_consultation_face_to_face" /><label for="fortune_consultation_face_to_face">{fortune_consultation_face_to_face}</label>

                            </div>
                            <em class="note"></em><br>
                            <?= form_error('consultation'); ?><br>
                            -->
                            <!-- pblm_code -->
                            <span class="item" style="margin-top:5px;position: absolute;">{grid_column_fortune_pblm_code}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('pblm_code'); ?>" data-name="pblm_code" >
                                <div data-value="">{fortune_pblm_plesae_select}</div>
                                {fortune_pblm}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('pblm_code'); ?><br>



                            <!-- Question -->
                            <span class="item" style="position: absolute;">{grid_column_fortune_pblm_s}</span>
                                <textarea name="fortune_message" placeholder="{fortune_question_placeholder}"><?= set_value('fortune_message'); ?></textarea>
                            <em class="note"></em><br>
                            <?= form_error('fortune_message'); ?><br>

                            <!-- Agreement -->
                            <span class="item" style="margin-top:0px;position: absolute;"></span>
                            <div style="display: inline-block;width: 100%;">
                                <input type="checkbox" name="agree" id="agree" /><label for="agree">{fortune_aggrement}</label>
                            </div>
                            <br><br>
                            <p class="redF hd">{fortune_need_pay}</p>
	                        <p class="tc">
                              <input id="submit" type="submit" class="btn-xl btn-ele" value="{btn_submit}">
                            </p>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        
        

    </div>
</div>

<script src="/_js/lunar_calendar.js"></script>

<script type="text/javascript">

function lunar_date_display(yy , mm , dd){
    var option_year = $('#birthday_year').find('.bfh-selectbox-option');
    option_year.text( yy + ' {birthday_year_s}');
    var option_month = $('#birthday_month').find('.bfh-selectbox-option');
    option_month.text( mm + ' {birthday_month_s}');
    var option_date = $('#birthday_date').find('.bfh-selectbox-option');
    option_date.text( dd+ ' {birthday_date_s}');

    var D=new Date(); 
    var ww=D.getDay(); 
    var ss=parseInt(D.getTime() / 1000); 
    if (yy<100) yy="19"+yy; 
    $("#nongli").html(GetLunarDay(yy,mm,dd));
}
function lunar_change(){
    
    var yy = $('#birthday_year').val();
    var mm = $('#birthday_month').val();
    var dd = $('#birthday_date').val();
    lunar_date_display(yy , mm , dd);
}
$(document).ready(function(){
    lunar_date_display($('#birthday_year').val() , $('#birthday_month').val() ,$('#birthday_date').val());

    $("#form").submit(function(e) {
         $('input[name=lunar]').val($("#nongli").text());

         if(!$('#agree').is(':checked')){
            alert('s');
            return false; 
         }
    });
});
$('#birthday_year').on('change.bfhselectbox', lunar_change);
$('#birthday_month').on('change.bfhselectbox', lunar_change);
$('#birthday_date').on('change.bfhselectbox', lunar_change);
</script>
