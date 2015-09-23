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
                    <a data-load="main_content" href="/fortune/removed" class="ctrl">{fortune_history}</a>
                </li>
            </ul>
        </div>
        <div class="login_gp">
            <div class="login_type borR register ">
                <div class="well well-lg  msg clearfix blk-reg">
                    <form>
                        <div>
                            <!-- Services -->
                            <!-- Lunar Birthday -->
                            <span class="item" style="margin-top:0px;position: absolute;">{fortune_services}</span>
                            <div style="display: inline-block;width: 100%;">
                                <span class="hd">{fortune_services_year}</span>
                            </div>
                            <br><br>
                            
                            <!-- Realname -->
                            <span class="item" >{grid_column_Nickname_or_Real}</span>
                            <input name="nickname" type="text" value="<?= set_value('nickname','{Nickname}'); ?>" />
                            <em class="note"></em><br>
                            <?= form_error('nickname'); ?><br>

                            <!-- Birthday -->
                            <span class="item" style="margin-top:5px;position: absolute;">{birthday_please_select_general_calender}</span>
                            <div id="birthday_date" style="display: inline-block;width: 33%;" class="bfh-selectbox" data-value="<?= set_value('birthday_date','{birthday_day}'); ?>" data-name="birthday_date" >
                                {birthday_date_options}
                            </div>
                            <div id="birthday_month" style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_month','{birthday_month}'); ?>" data-name="birthday_month" >
                                {birthday_month_options}
                            </div>
                            <div id="birthday_year" style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_year','{birthday_year}'); ?>" data-name="birthday_year" >
                                {birthday_year_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_date'); ?> <?= form_error('birthday_month'); ?> <?= form_error('birthday_year'); ?><br>

                            <!-- Lunar Birthday -->
                            <span class="item" style="margin-top:0px;position: absolute;">{birthday_lunar_calender}</span>
                            <div style="display: inline-block;width: 100%;">
                                <span id="nongli"></span>
                            </div>
                            <br><br>

                            <!-- Birthday time -->
                            <span class="item" style="margin-top:5px;position: absolute;">{birthday_please_select_hour}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('birthday_hour'); ?>" data-name="birthday_hour" >
                                {birthday_hour_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_time'); ?><br>

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
                            <!-- Question -->
                            <span class="item" style="position: absolute;">{grid_column_Question}</span>
                                <textarea name="question" placeholder="{fortune_question_placeholder}"><?= set_value('question'); ?></textarea>
                            <em class="note"></em><br>
                            
                            <!-- Agreement -->
                            <span class="item" style="margin-top:0px;position: absolute;"></span>
                            <div style="display: inline-block;width: 100%;">
                                <input type="checkbox" id="agree" /><label for="agree">我已詳細閱讀注意事項，並同意接受</label>
                            </div>
                            <br><br>
                            <p class="redF hd">{fortune_need_pay}</p>
	                        <p class="tc">
                              <input id="go_step2" type="submit" class="btn-xl btn-ele" value="{register_submit}">
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
    console.log(yy);
    console.log(mm);
    console.log(dd);
    lunar_date_display(yy , mm , dd);
}
$(document).ready(function(){
    lunar_date_display({birthday_year} , {birthday_month} , {birthday_day});
});
$('#birthday_year').on('change.bfhselectbox', lunar_change);
$('#birthday_month').on('change.bfhselectbox', lunar_change);
$('#birthday_date').on('change.bfhselectbox', lunar_change);
</script>
