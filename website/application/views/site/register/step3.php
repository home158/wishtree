<link href="/_css/bootstrap-formhelpers.min.css" rel="stylesheet">
<script src="/_js/bootstrap-formhelpers.min.js"></script>
<div id="content">    
    <div class="ct clearfix">
        <div class="msg">
            <p class="hd">{register_step3}</p>
            <p></p>
        </div>
        <div class="login_gp">
            <div class="login_type borR register ">
                
                <div class="well well-lg  msg clearfix blk-reg">
                    <form name="register" action="/register/step_3" method="post">
                        <p class="redF hd ">{register_under_review_cannot_post}</p>
                        <p class="hd">{register_part1}</p>
                        <div>
                            <span class="item">{grid_column_Role}</span>
                            {register_gender}
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

                            <!-- timezoneoffset -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_TimezoneOffset}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('timezoneoffset'); ?>" data-name="timezoneoffset" >
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
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('dst' , '0'); ?>" data-name="dst" >
                                <div data-value="1">{dst_on}</div>
                                <div data-value="0">{dst_off}</div> 
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('dst'); ?><br>


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
                            <!-- National Code-->
                            <span class="item"  style="margin-top:10px;position: absolute;">{grid_column_NationalCode}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox bfh-countries" data-country="<?= set_value('national_code','TW'); ?>" data-flags="true" data-blank="false" data-name="national_code" >
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('national_code'); ?><br>

                            <!-- City -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_City}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('city'); ?>" data-name="city" >
                                <div data-value="">{city_please_select}</div>
                                <div data-value="KL">{city_KL}</div>
                                <div data-value="TP">{city_TP}</div>
                                <div data-value="NTP">{city_NTP}</div>
                                <div data-value="ILC">{city_ILC}</div>
                                <div data-value="HC">{city_HC}</div>
                                <div data-value="HCC">{city_HCC}</div>
                                <div data-value="TY">{city_TY}</div>
                                <div data-value="MLC">{city_MLC}</div>
                                <div data-value="TC">{city_TC}</div>
                                <div data-value="CHC">{city_CHC}</div>
                                <div data-value="NTC">{city_NTC}</div>
                                <div data-value="CI">{city_CI}</div>
                                <div data-value="CIC">{city_CIC}</div>
                                <div data-value="YLC">{city_YLC}</div>
                                <div data-value="TN">{city_TN}</div>
                                <div data-value="KH">{city_KH}</div>
                                <div data-value="PTC">{city_PTC}</div>
                                <div data-value="TTC">{city_TTC}</div>
                                <div data-value="HLC">{city_HLC}</div>
                                <div data-value="KMC">{city_KMC}</div>
                                <div data-value="LCL">{city_LCL}</div>
                                <div data-value="PHC">{city_PHC}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('city'); ?><br>


                            <!-- Langugae -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Language}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('language'); ?>" data-name="language" >
                                <div data-value="">{language_please_select}</div>
                                <div data-value="english">{language_english}</div>
                                <div data-value="chinese">{language_chinese}</div>
                                <div data-value="cantonese">{language_cantonese}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('language'); ?><br>


                            <!-- Income -->
                            <div class="male_only">
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Income}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('income'); ?>" data-name="income" >
                                <div data-value="">{income_please_select}</div>
                                <div data-value="50000_below">{income_50000_below}</div>
                                <div data-value="50001_75000">{income_50001_75000}</div>
                                <div data-value="75001_125000">{income_75001_125000}</div>
                                <div data-value="125001_150000">{income_125001_150000}</div>
                                <div data-value="125001_150000">{income_125001_150000}</div>
                                <div data-value="150001_175000">{income_150001_175000}</div>
                                <div data-value="175001_200000">{income_175001_200000}</div>
                                <div data-value="200001_250000">{income_200001_250000}</div>
                                <div data-value="250001_300000">{income_250001_300000}</div>
                                <div data-value="300001_400000">{income_300001_400000}</div>
                                <div data-value="400001_500000">{income_400001_500000}</div>
                                <div data-value="500001_1000000">{income_500001_1000000}</div>
                                <div data-value="1000000_up">{income_1000000_up}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('income'); ?><br>
                            </div>


                            <!-- Property -->
                            <div class="male_only">
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Property}</span>
                            <div style="display: inline-block;width: 100%" class="bfh-selectbox" data-value="<?= set_value('property'); ?>" data-name="property" >
                                <div data-value="">{property_please_select}</div>
                                <div data-value="100_thousand_bellow">{property_100_thousand_bellow}</div>
                                <div data-value="100_thousand_250_thousand">{property_100_thousand_250_thousand}</div>
                                <div data-value="250_thousand_500_thousand">{property_250_thousand_500_thousand}</div>
                                <div data-value="500_thousand_750_thousand">{property_500_thousand_750_thousand}</div>
                                <div data-value="750_thousand_1_million">{property_750_thousand_1_million}</div>
                                <div data-value="1_million_2_million">{property_1_million_2_million}</div>
                                <div data-value="2_million_5_million">{property_2_million_5_million}</div>
                                <div data-value="5_million_10_million">{property_5_million_10_million}</div>
                                <div data-value="10_million_50_million">{property_10_million_50_million}</div>
                                <div data-value="50_million_100_million">{property_50_million_100_million}</div>
                                <div data-value="100_million_up">{property_100_million_up}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('property'); ?><br>
                            </div>


                            <!-- Birthday -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Birthday}</span>
                            <div style="display: inline-block;width: 33%;" class="bfh-selectbox" data-value="<?= set_value('birthday_date'); ?>" data-name="birthday_date" >
                                {birthday_date_options}
                            </div>
                            <div style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_month'); ?>" data-name="birthday_month" >
                                {birthday_month_options}
                            </div>
                            <div style="display: inline-block;width: 32.5%;" class="bfh-selectbox" data-value="<?= set_value('birthday_year'); ?>" data-name="birthday_year" >
                                {birthday_year_options}
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('birthday_date'); ?> <?= form_error('birthday_month'); ?> <?= form_error('birthday_year'); ?><br>

                            <!--  Height  -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Height}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('height'); ?>" data-name="height" >
                                <div data-value="">{height_please_select}</div>
                                <div data-value="140_below">{height_140_below}</div>
                                <div data-value="141_145">141-145 {height_cm}</div>
                                <div data-value="146_150">146-150 {height_cm}</div>
                                <div data-value="151_155">151-155 {height_cm}</div>
                                <div data-value="156_160">156-160 {height_cm}</div>
                                <div data-value="161_165">161-165 {height_cm}</div>
                                <div data-value="166_170">166-170 {height_cm}</div>
                                <div data-value="171_175">171-175 {height_cm}</div>
                                <div data-value="176_180">176-180 {height_cm}</div>
                                <div data-value="181_185">181-185 {height_cm}</div>
                                <div data-value="186_190">186-190 {height_cm}</div>
                                <div data-value="191_195">191-195 {height_cm}</div>
                                <div data-value="196_200">196-200 {height_cm}</div>
                                <div data-value="201_205">201-205 {height_cm}</div>
                                <div data-value="206_210">206-210 {height_cm}</div>
                                <div data-value="210_up">{height_210_up}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('height'); ?><br>

                        
                            <!-- Body type -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Bodytype}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('bodytype'); ?>" data-name="bodytype" >
                                <div data-value="">{bodytype_please_select}</div>
                                <div data-value="slim">{bodytype_slim}</div>
                                <div data-value="athletic">{bodytype_athletic}</div>
                                <div data-value="average">{bodytype_average}</div>
                                <div data-value="few_extra_pounds">{bodytype_few_extra_pounds}</div>
                                <div data-value="overweight">{bodytype_overweight}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('bodytype'); ?><br>


                            <!-- Race -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Race}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('race'); ?>" data-name="race" >
                                <div data-value="">{race_please_select}</div>
                                <div data-value="aian">{race_aian}</div>
                                <div data-value="black">{race_black}</div>
                                <div data-value="hispanic">{race_hispanic}</div>
                                <div data-value="caucasian">{race_caucasian}</div>
                                <div data-value="eastern">{race_middle_eastern}</div>
                                <div data-value="mixed">{race_mixed}</div>
                                <div data-value="other">{race_other}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('race'); ?><br>


                            <!-- Education -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Education}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('education'); ?>" data-name="education" >
                                <div data-value="">{education_please_select}</div>
                                <div data-value="phd">{education_phd}</div>
                                <div data-value="graduate">{education_graduate}</div>
                                <div data-value="bachelors">{education_bachelors}</div>
                                <div data-value="senior">{education_senior}</div>
                                <div data-value="junior">{education_junior}</div>
                                <div data-value="elementary">{education_elementary}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('education'); ?><br>


                            <!-- Maritalstatus -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Maritalstatus}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('maritalstatus'); ?>" data-name="maritalstatus" >
                                <div data-value="">{maritalstatus_please_select}</div>
                                <div data-value="single">{maritalstatus_single}</div>
                                <div data-value="divorced">{maritalstatus_divorced}</div>
                                <div data-value="separated">{maritalstatus_separated}</div>
                                <div data-value="married">{maritalstatus_married}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('maritalstatus'); ?><br>


                            <!-- Smoking -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Smoking}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('smoking'); ?>" data-name="smoking" >
                                <div data-value="">{smoking_please_select}</div>
                                <div data-value="none">{smoking_none}</div>
                                <div data-value="light">{smoking_light}</div>
                                <div data-value="heavy">{smoking_heavy}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('maritalstatus'); ?><br>


                            <!-- Drinking -->
                            <span class="item" style="margin-top:10px;position: absolute;">{grid_column_Drinking}</span>
                            <div style="display: inline-block;width: 100%;" class="bfh-selectbox" data-value="<?= set_value('drinking'); ?>" data-name="drinking" >
                                <div data-value="">{drinking_please_select}</div>
                                <div data-value="none">{drinking_none}</div>
                                <div data-value="light">{drinking_light}</div>
                                <div data-value="social">{drinking_social}</div>
                                <div data-value="heavy">{drinking_hravy}</div>
                            </div>
                            <em class="note"></em><br>
                            <?= form_error('maritalstatus'); ?><br>

                        </div>

                        <p class="section"></p>
                        <p class="hd">{register_part4}</p>
                        <div>
                            <span class="item" style="position: absolute;">{grid_column_IdealDesc}</span>
                                <textarea name="ideal_desc" ><?= set_value('ideal_desc'); ?></textarea>
                            <em class="note"></em><br>
                            <?= form_error('ideal_desc'); ?><br>
                            

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
    if( $.cookie("WG_role") != 'male'){
        $('.male_only').hide();
    }
});
</script>