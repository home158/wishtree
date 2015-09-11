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
                            <!-- Realname -->
                            <span class="item" >{grid_column_Nickname_or_Real}</span>
                            <input name="nickname" type="text" value="<?= set_value('nickname','{Nickname}'); ?>" />
                            <em class="note"></em><br>
                            <?= form_error('nickname'); ?><br>

                            <!-- Birthday -->
                            <span class="item" style="margin-top:10px;position: absolute;">{birthday_please_select_general_calender}</span>
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
                            <span class="item" style="margin-top:10px;position: absolute;">{birthday_lunar_calender}</span>
                            <div style="display: inline-block;width: 100%;">
                                <span id="nongli">ss</span>
                            </div>
                            <br><br>

                            <!-- Birthday time -->
                            <span class="item" style="margin-top:10px;position: absolute;">{birthday_please_select_hour}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('birthday_hour'); ?>" data-name="birthday_hour" >
                                {birthday_hour_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_time'); ?><br>

                            <!-- Maritalstatus -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Maritalstatus}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('maritalstatus','{Maritalstatus}'); ?>" data-name="maritalstatus" >
                                <div data-value="">{maritalstatus_please_select}</div>
                                <div data-value="single">{maritalstatus_single}</div>
                                <div data-value="divorced">{maritalstatus_divorced}</div>
                                <div data-value="separated">{maritalstatus_separated}</div>
                                <div data-value="married">{maritalstatus_married}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('maritalstatus'); ?><br>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        我已詳細閱讀注意事項，並同意接受
        今天的农历时间是：<span id="nongli"></span>

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
