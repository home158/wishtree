<link href="/_css/bootstrap-formhelpers.min.css" rel="stylesheet">
<script src="/_js/bootstrap-formhelpers.min.js"></script>
<div class="wrap account_set">
    <div class="panel panel-warning">
      <div class="panel-heading"><strong>{account_settings_timezone}</strong></div>
      <div class="panel-body">
                <div class="clearfix blk-reg">
                    <form name="register" action="/admin/account/settings" method="post">
                        <div>
                            <!-- timezoneoffset -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_TimezoneOffset}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('timezoneoffset' ,'{TimezoneOffset}'); ?>" data-name="timezoneoffset" >
                                <div data-value="">{timezoneoffset_please_select}</div>
                                <div data-value="-12:00">{timezoneoffset__12}</div> 
                                <div data-value="-11:00">{timezoneoffset__11}</div> 
                                <div data-value="-10:00">{timezoneoffset__10}</div> 
                                <div data-value="-09:00">{timezoneoffset__9}</div>  
                                <div data-value="-08:00">{timezoneoffset__8}</div>  
                                <div data-value="-07:00">{timezoneoffset__7}</div>  
                                <div data-value="-06:00">{timezoneoffset__6}</div>  
                                <div data-value="-05:00">{timezoneoffset__5}</div>  
                                <div data-value="-04:30">{timezoneoffset__4.5}</div>
                                <div data-value="-04:00">{timezoneoffset__4}</div>  
                                <div data-value="-03:30">{timezoneoffset__3.5}</div>
                                <div data-value="-03:00">{timezoneoffset__3}</div>  
                                <div data-value="-02:00">{timezoneoffset__2}</div>  
                                <div data-value="-01:00">{timezoneoffset__1}</div>  
                                <div data-value="+00:00">{timezoneoffset_0}</div>   
                                <div data-value="+01:00">{timezoneoffset_1}</div>   
                                <div data-value="+02:00">{timezoneoffset_2}</div>   
                                <div data-value="+03:00">{timezoneoffset_3}</div>   
                                <div data-value="+03:30">{timezoneoffset_3.5}</div> 
                                <div data-value="+04:00">{timezoneoffset_4}</div>   
                                <div data-value="+04:30">{timezoneoffset_4.5}</div> 
                                <div data-value="+05:00">{timezoneoffset_5}</div>   
                                <div data-value="+05:30">{timezoneoffset_5.5}</div> 
                                <div data-value="+05:45">{timezoneoffset_5.75}</div>
                                <div data-value="+06:00">{timezoneoffset_6}</div>   
                                <div data-value="+06:30">{timezoneoffset_6.5}</div> 
                                <div data-value="+07:00">{timezoneoffset_7}</div>   
                                <div data-value="+08:00">{timezoneoffset_8}</div>   
                                <div data-value="+09:00">{timezoneoffset_9}</div>   
                                <div data-value="+09:30">{timezoneoffset_9.5}</div> 
                                <div data-value="+10:00">{timezoneoffset_10}</div>  
                                <div data-value="+11:00">{timezoneoffset_11}</div>  
                                <div data-value="+12:00">{timezoneoffset_12}</div>    
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('timezoneoffset'); ?><br>


                            <!-- DST -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_DST}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('dst' , '{DST}'); ?>" data-name="dst" >
                                <div data-value="1">{dst_on}</div>
                                <div data-value="0">{dst_off}</div> 
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('dst'); ?><br>
                            <input type="submit" value="{btn_submit}" class="btn-relax btn-x">
                        </div>
                    </form>
                </div>
      </div>
    </div>
</div>