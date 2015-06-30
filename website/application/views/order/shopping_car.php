<script src="/_script/jquery.twzipcode.min.js"></script>
<script src="/_script/jquery.validate.min.js"></script>
<script src="/_script/additional-methods.min.js"></script>

<style>
    #step_2,
    #step_3{
        display: none;
    }
    table{
        width: 100%;
        font-size:16px;
    }

    .order_process{
        background-image: url(/_images/ubg.png);
        background-repeat:no-repeat;
        margin-bottom: 40px;
        text-align: center;
    }
    #step_1 .order_process{
        background-position: 90px -0px;
    }
    #step_2 .order_process{
         background-position: 318px -0px;
    }
    #step_3 .order_process{
         background-position: 546px -0px;
    }
    .delete_detail{
        display:inline-block;
        *display:inline;
        *zoom:1;
        width: 17px;
        height: 17px;
        background-image: url(/_images/delete_order.png);
        background-repeat:no-repeat;
        margin:0px; padding:0px; 
        border:none;
    }
    table.order_info{
        margin-left: 20px;
        margin-right: 20px;
        margin-bottom: 30px;
    }
    table.order_info td{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    em.col_note{
        text-align: justify;
        text-justify:inter-ideograph;
        color: #93bf32;
    }
    em.col_1{
        text-align: justify;
        text-justify:inter-ideograph;
        display:inline-block;
        *display:inline;
        *zoom:1;
        color: #3e420d;
    }
    em.col_2{
        text-align: justify;
        text-justify:inter-ideograph;
        display:inline-block;
        *display:inline;
        *zoom:1;
        color: #3e420d;
    }
    .blk-reg input.receive_name,
    .blk-reg input.receive_mobile,
    .blk-reg input.receive_tel,
    .blk-reg input.order_name,
    .blk-reg input.order_mobile,
    .blk-reg input.order_tel{
        width: 210px;
    }
    .blk-reg input.receive_bank_account{
        width: 185px;
    }
    .blk-reg select.receive_time{
        width: 222px;
    }
    .blk-reg input[name=order_zipcode]{
        width: 50px;
    }
    .blk-reg select[name=order_county]{
        width: 80px;
        padding: 2px;
    }
    .blk-reg select[name=order_district]{
        width: 100px;
        padding: 2px;
    }
    .blk-reg input.receive_address{
        width: 365px;
    }
    #twzipcode{
        display:inline-block;
        *display:inline;
        *zoom:1;
    }
    #twzipcode > div{
        display:inline-block;
        *display:inline;
        *zoom:1;
    }
    .next_btn{
        text-align: center;
    }
    .next_btn a{
        display:inline-block;
        *display:inline;
        *zoom:1;
    
    }
    .blk-reg form {
        padding-left: 0em; 
    }
	label.error {
		display: inline;
	}
	label.error {
        color:  #f00;
		display: block;
		margin-left: 1em;
		width: auto;
	}
    #form_for_confirm,
    #form_for_bank{
        text-align:  center;
    }
    #form_for_confirm p,
    #form_for_bank pp{
        line-height: 2em;
        font-size:16px;
    }
    
    table.order_detail_confirm{
        margin-left: 20px;
        margin-right: 20px;
        margin-bottom: 30px;
    }
    table.order_detail_confirm td{
        padding-top: 7px;
        padding-bottom: 7px;
        text-align: left;
    }


</style>
<div class="container market">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-shopping-car-center.png"/>
    </div>
    <div id="step_1" class="content block blk-reg">
        <div class="inside">
           <div class="order_process">
                <img src="/_images/u1.png"/>
           </div>
           <form method="post"  id="form_for_checkout" action=""> 
                <table class="order_info" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <input type="checkbox" id="same_as_first_time"><label for="same_as_first_time"><em class="col_note">{orders_same_as_first_time}</em></label>
                            </td>
                        </tr>
                        <tr>
                            <td ><em class="col_1">*{gird_column_OrderName}：</em></td>
                            <td colspan="3"><input class="order_name" name="order_name" type="text"  /></td>
                        </tr>
                        <tr>
                            <td><em class="col_1">*{gird_column_OrderTel}：</em></td>
                            <td colspan="3"><input class="order_tel fill_order_one" name="order_tel" type="text" />
                                <em class="col_note">{orders_note_tel_mobile}</em></td>
                        </tr>
                        <tr>
                            <td><em class="col_1">*{gird_column_OrderMobile}：</em></td>
                            <td colspan="3"><input class="order_mobile fill_order_one" name="order_mobile" type="text" />
                                <em class="col_note">{orders_note_tel_mobile}</em></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="checkbox" id="same_as_contact"><label for="same_as_contact">
                                <em class="col_note">{orders_same_as_contact}</em></label>
                            </td>
                        </tr>
                        <tr>
                            <td ><em class="col_1">*{gird_column_ReceiveName}：</em></td>
                            <td colspan="3"><input class="receive_name" name="receive_name" type="text"  /></td>
                        </tr>
                        <tr>
                            <td><em class="col_1">*{gird_column_ReceiveTel}：</em></td>
                            <td colspan="3"><input class="receive_tel fill_receive_one" name="receive_tel" type="text" />
                                <em class="col_note">{orders_note_tel_mobile}</em></td>
                        </tr>
                        <tr>
                            <td><em class="col_1">*{gird_column_ReceiveMobile}：</em></td>
                            <td colspan="3"><input class="receive_mobile fill_receive_one" name="receive_mobile" type="text" />
                                <em class="col_note">{orders_note_tel_mobile}</em></td>
                        </tr>
                        <tr>
                            <td><em class="col_2">*{gird_column_ReceiveTime}：</em></td>
                            <td>
                                <select class="receive_time" name="receive_time" >
                                     <option value="">{orders_receive_time_select_one}</option>
                                     <option value="{orders_receive_time_AM09PM12}">{orders_receive_time_AM09PM12}</option>
                                     <option value="{orders_receive_time_PM12PM18}">{orders_receive_time_PM12PM18}</option>
                                     <option value="{orders_receive_time_PM18PM21}">{orders_receive_time_PM18PM21}</option>
                                </select>
                            </td>
                            <td><em class="col_2">*{gird_column_ReceiveBankAccount}：</em></td>
                            <td><input class="receive_bank_account" name="receive_bank_account" type="text" /></td>

                        </tr>
                        <tr>
                            <td ><em class="col_1">*{gird_column_ReceiveAddress}：</em></td>
                            <td colspan="3">
                                 <div id="twzipcode">
                                     <div data-role="zipcode"></div>
                                     <div data-role="county"></div>
                                     <div data-role="district"></div>
                                 </div>
                                 <input class="receive_address" name="receive_address" type="text"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="error"></div>
                <table class="order_detail" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="2">{gird_column_ProductTitle}</th>
                            <th>{gird_column_PriceSpecial}</th>
                            <th>{gird_column_OrderCounts}</th>
                            <th class="product_stock">{gird_column_Stock}</th>
                            <th class="product_remove">{contextmenu_delete}</th>
                        <tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td  colspan="6" style="height: 0px;"></td>
                        </tr>
                        {order_data}
                        <tr>
                            <td class="product_thumb"><img width="122px" height="91px" src="{CoverImageThumbURLPath}"/></td>
                            <td class="product_title">{Title}</td>
                            <td class="product_price_special" targetGUID="{O_GUID}">$<span class="amount">{PriceSpecial}</amount></td>
                            <td class="product_order_counts" style="display: none;">{OrderCounts}</td>

                            <td class="product_order_counts_fake" ><select targetGUID="{O_GUID}" id="product_order_counts_{SerialNo}"></select></td>
                            <td class="product_stock">{Stock}</td>
                            <td class="product_remove"><a class="delete_detail" targetGUID="{O_GUID}" href="#remove"></a></td>
                        </tr>
                        {/order_data}
                        <tr>
                            <td  colspan="6" style="height: 0px;"></td>
                        </tr>
                    </tbody>
                </table>
               <!--
                <select class="shipping_type" name="shipping_fare" >
                    <option value="">{gird_column_ShippingType}</option>
                    <option value="1">{gird_column_ShippingType_normal}</option>
                    <option value="2">{gird_column_ShippingType_cool}</option>
                </select>
               -->
                <div style="text-align: center;">
                    <!--
                    <div class="shipping_fare" >
                        {orders_total_shipping_fare}
                        <span id="total_shipping_amount"></span>
                    </div>
                    -->
                    <div class="total_amount">
                        {orders_total_merchandise_fare} 
                        <span id="total_merchandise_amount"></span>
                    </div>
                </div>
                <div class="next_btn">
                    <a class="btn_checkout" id="btn_checkout" href="#"><img src="/_images/btn_checkout.png"/></a>
                </div>
            </form>
        </div>
    </div>
    <div id="step_2" class="content block blk-reg">
        <div class="inside">
           <div class="order_process">
                <img src="/_images/u1.png"/>
           </div>
           <div id="form_for_confirm">
                <table class="order_detail_confirm">
                    <tr>
                        <td width="125px">{gird_column_OrderName}:</td>
                        <td><span id="order_name"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_OrderTel}:</td>
                        <td><span id="order_tel"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_OrderMobile}:</td>
                        <td><span id="order_mobile"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveName}:</td>
                        <td><span id="receive_name"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveTel}:</td>
                        <td><span id="receive_tel"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveMobile}:</td>
                        <td><span id="receive_mobile"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveAddress}:</td>
                        <td><span id="receive_address"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveBankAccount}:</td>
                        <td><span id="receive_bank_account"></span></td>
                    </tr>
                    <tr>
                        <td>{gird_column_ReceiveTime}:</td>
                        <td><span id="receive_time"></span><input name="receive_time" type="hidden" value=""/></td>
                    </tr>
                </table>
                <div id="confirm_order_detail"></div>
                <div class="shipping_fare" >
                    {orders_total_shipping_fare}
                    <span id="confirm_shipping_fare"></span>
                </div>
                <div class="total_amount">
                    {orders_total_amount} 
                    <span id="confirm_total_amount" ></span>
                </div>
                <div class="next_btn">
                    <a class="btn_checkout" id="btn_prev" href="#"><img src="/_images/btn_prev.png"/></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn_checkout" id="btn_confirm" href="#"><img src="/_images/btn_confirm.png"/></a>
                </div>
            </div>
        </div>
    </div>
    <div id="step_3" class="content block blk-reg">
        <div class="inside">
           <div class="order_process">
                <img src="/_images/u1.png"/>
           </div>
           <div id="form_for_bank">
                <img src="/_images/bank_account.png"/>
                <br/>
                <div id="order_receive_info"></div>
                <div id="bank_order_detail"></div>
                <div id="bank_shipping_fare"></div>
                <div id="bank_total_amount"></div>
                <div class="next_btn">
                    <a class="btn_cagetory" id="btn_cagetory" href="#"><img src="/_images/btn_cagetory.png"/></a>
                </div>

           </div>
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>
<script>
    Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
    var cacl_fare = function(){
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/order/cacl_fare',
                dataType: 'json',
                type: 'POST',
                data: {},
                success: function(r) {
                    $('#total_merchandise_amount').text( r.total_merchandise_amount.formatMoney(0, '.', ',') );
                    $('#confirm_shipping_fare').text( r.total_shippount_amount.formatMoney(0, '.', ',') );
                    $('#confirm_total_amount').text( r.total_amount.formatMoney(0, '.', ',') );
                    
                    $.isLoading( "hide" );
               },
                complete : function(){
                }
            });
        };
    $(function () {
        $.isLoading({ text: "Loading" });
        cacl_fare();
        var latest_info = {
            'ReceiveName' : '{ReceiveName}',
            'ReceiveTel' : '{ReceiveTel}',
            'ReceiveMobile' : '{ReceiveMobile}',
            'ReceiveAddress' : '{ReceiveAddress}',
            'ReceiveZipCode' : '{ReceiveZipCode}',
            'ReceiveBankAccount' : '{ReceiveBankAccount}',
            'ReceiveTime' : '{ReceiveTime}',
            'OrderName' : '{OrderName}',
            'OrderTel' : '{OrderTel}',
            'OrderMobile' : '{OrderMobile}'
            };
        var submit_data = {
            receive_name: null,
            receive_tel: null,
            receive_mobile: null,
            order_name: null,
            order_tel: null,
            order_mobile: null,
            receive_bank_account:null,
            receive_time: null,
            receive_address : null,
            shipping_fare_note : null,
            //shipping_fare: 0,
            product_guid:null,
            //total_amount:0,
            receive_address_user: null,
            receive_zip_code: null
        };
        $('#twzipcode').twzipcode({
            countyName : 'order_county',
            districtName : 'order_district',
            zipcodeName : 'order_zipcode',
            readonly:true
        });

        var validate =$("#form_for_checkout").validate({
            errorLabelContainer: $("#form_for_checkout div.error"),
            submitHandler : function(form){
                
                $('#step_1').hide();
                $('#step_2').show();
                var $receive_name = $('input[name=receive_name]' , form).val();
                $('#receive_name' , '#form_for_confirm').text($receive_name);
                submit_data.receive_name = $receive_name;

                var $receive_tel = $('input[name=receive_tel]' , form).val();
                $('#receive_tel' , '#form_for_confirm').text($receive_tel);
                submit_data.receive_tel = $receive_tel;

                var $receive_mobile = $('input[name=receive_mobile]' , form).val();
                $('#receive_mobile' , '#form_for_confirm').text($receive_mobile);
                submit_data.receive_mobile = $receive_mobile;
                /*********************************************/
                var $order_name = $('input[name=order_name]' , form).val();
                $('#order_name' , '#form_for_confirm').text($order_name);
                submit_data.order_name = $order_name;

                var $order_tel = $('input[name=order_tel]' , form).val();
                $('#order_tel' , '#form_for_confirm').text($order_tel);
                submit_data.order_tel = $order_tel;

                var $order_mobile = $('input[name=order_mobile]' , form).val();
                $('#order_mobile' , '#form_for_confirm').text($order_mobile);
                submit_data.order_mobile = $order_mobile;

                var $receive_bank_account = $('input[name=receive_bank_account]' , form).val();
                $('#receive_bank_account' , '#form_for_confirm').text($receive_bank_account);
                submit_data.receive_bank_account = $receive_bank_account;

                var $receive_time = $('select[name=receive_time]' , form).val();
                $('#receive_time' , '#form_for_confirm').text($receive_time);
                submit_data.receive_time = $receive_time;

                var $receive_address = $('input[name=order_zipcode]' , form).val() + 
                                        ' '+ 
                                        $('select[name=order_county]' , form).val() + 
                                        $('select[name=order_district]' , form).val() +
                                        $('input[name=receive_address]' , form).val() ;
                $('#receive_address' , '#form_for_confirm').text($receive_address);
                submit_data.receive_address = $receive_address;
                submit_data.receive_address_user = $('input[name=receive_address]' , form).val();
                submit_data.receive_zip_code = $('input[name=order_zipcode]' , form).val();
                /*********************************************************************/
                $('#confirm_order_detail').empty().html( $('table.order_detail').clone() );
                $('#confirm_order_detail .product_stock').remove();
                $('#confirm_order_detail .product_remove').remove();
                $('#confirm_order_detail .product_order_counts_fake').remove();
                $('#confirm_order_detail .product_order_counts').show();

                var arr_guid = [];
                $('.product_price_special' , form).each(function(){
                   arr_guid.push( "'"+$(this).attr('targetGUID')+"'" );
                });
                submit_data.product_guid = arr_guid.join();

            },
			rules: {
				receive_name: {
					required: true,
					maxlength: 50
				},
                
				receive_tel: {
					require_from_group: [1,".fill_receive_one"],
                    maxlength:20
				},
				receive_mobile: {
					require_from_group: [1,".fill_receive_one"],
                    maxlength:20
				},

				order_name: {
					required: true,
					maxlength: 50
				},
				order_tel: {
					require_from_group: [1,".fill_order_one"],
                    maxlength:20
				},
				order_mobile: {
					require_from_group: [1,".fill_order_one"],
                    maxlength:20
				},
				receive_bank_account: {
					required: true,
					minlength: 5,
					maxlength: 5,
                    number: true
				},
                order_county:{
					required: true
                },
                receive_time:{
					required: true
                },
                /*
                shipping_fare:{
					required: true
                },
                */
                receive_address:{
					required: true,
                    maxlength:150
                }
			},
			messages: {
				receive_name: {
					required: '{gird_column_ReceiveName} 必須填寫。',
                    maxlength: "{gird_column_ReceiveName} 不能超過 50 個字。"
				},
                
                receive_tel:{
                    require_from_group: "{gird_column_ReceiveTel}、{gird_column_ReceiveMobile} 必須擇一填寫。",
                    maxlength: "{gird_column_ReceiveTel} 不能超過 20 個字。"
                },
                receive_mobile:{
                    require_from_group: "{gird_column_ReceiveTel}、{gird_column_ReceiveMobile} 必須擇一填寫。",
                    maxlength: "{gird_column_ReceiveMobile} 不能超過 20 個字。"
                },
                
				order_name: {
					required: '{gird_column_OrderName} 必須填寫。',
                    maxlength: "{gird_column_OrderName} 不能超過 50 個字。"
				},
                order_tel:{
                    require_from_group: "{gird_column_OrderTel}、{gird_column_OrderMobile} 必須擇一填寫。",
                    maxlength: "{gird_column_OrderTel} 不能超過 20 個字。"
                },
                order_mobile:{
                    require_from_group: "{gird_column_OrderTel}、{gird_column_OrderMobile} 必須擇一填寫。",
                    maxlength: "{gird_column_OrderMobile} 不能超過 20 個字。"
                },
                receive_bank_account:{
                    required: "{gird_column_ReceiveBankAccount}  必須填寫。",
                    number: "{gird_column_ReceiveBankAccount} 只能包含數字。",
                    minlength: "{gird_column_ReceiveBankAccount} 必須剛好 5 個字。",
                    maxlength: "{gird_column_ReceiveBankAccount} 必須剛好 5 個字。"
                },
                order_county:{
                    required: "縣市 必須選擇。"

                },
                /*
                shipping_fare:{
                    required: "{gird_column_ShippingType} 必須選擇。"

                },
                */
                receive_address:{
                    required: "{gird_column_ReceiveAddress}  必須填寫。",
                    maxlength: "{gird_column_ReceiveAddress} 不能超過 150 個字。"
                },
                receive_time:{
                    required: "{gird_column_ReceiveTime} 必須一個時段。"
                }
			}
		});
        $('#same_as_contact').bind('change',function(){
            var $receive_name           = $('input[name=receive_name]'),
                $receive_tel            = $('input[name=receive_tel]'),
                $receive_mobile         = $('input[name=receive_mobile]'),
                $order_name             = $('input[name=order_name]'),
                $order_tel              = $('input[name=order_tel]'),
                $order_mobile           = $('input[name=order_mobile]');
            if($(this).is(':checked')){
                $receive_name.val($order_name.val());
                $receive_tel.val($order_tel.val());
                $receive_mobile.val($order_mobile.val());
            }else{
                $receive_name.val('');
                $receive_tel.val('');
                $receive_mobile.val('');
            }
        });
        $('#same_as_first_time').bind('change',function(){
            var $receive_name           = $('input[name=receive_name]'),
                $receive_tel            = $('input[name=receive_tel]'),
                $receive_mobile         = $('input[name=receive_mobile]'),
                $receive_address        = $('input[name=receive_address]'),
                $receive_bank_account   = $('input[name=receive_bank_account]'),
                $receive_time           = $('select[name=receive_time]'),
                $order_name             = $('input[name=order_name]'),
                $order_tel              = $('input[name=order_tel]'),
                $order_mobile           = $('input[name=order_mobile]'),
                $twzipcode              = $('#twzipcode');
            if($(this).is(':checked')){
                $receive_name.val(latest_info.ReceiveName);
                $receive_tel.val(latest_info.ReceiveTel);
                $receive_mobile.val(latest_info.ReceiveMobile);
                $receive_address.val(latest_info.ReceiveAddress);
                $receive_bank_account.val(latest_info.ReceiveBankAccount);
                $receive_time.val(latest_info.ReceiveTime);
                $order_name.val(latest_info.OrderName);
                $order_tel.val(latest_info.OrderTel);
                $order_mobile.val(latest_info.OrderMobile);
                $('#twzipcode').twzipcode('destroy'); 
                $('#twzipcode').html('<div data-role="zipcode"></div>&nbsp;<div data-role="county"></div>&nbsp;<div data-role="district"></div>');
                $('#twzipcode').twzipcode({
                    zipcodeSel  : latest_info.ReceiveZipCode,
                    countyName : 'order_county',
                    districtName : 'order_district',
                    zipcodeName : 'order_zipcode',
                    readonly:true
                });
            }else{
                $receive_name.val("");
                $receive_tel.val("");
                $receive_mobile.val("");
                $receive_address.val("");
                $receive_bank_account.val("");
                $receive_time.val($receive_time.find('option').first().val());
                $order_name.val("");
                $order_tel.val("");
                $order_mobile.val("");
                $('#twzipcode').twzipcode('reset'); 

            }
        });
        $('#btn_checkout').bind('click',function(){
            $("#form_for_checkout").submit();
        });
        $('#btn_prev').bind('click',function(){
                $('#step_1').show();
                $('#step_2').hide();
        });
        $('#btn_cagetory').bind('click',function(){
            location.href = '/market/category'
        });

        $('#btn_confirm').bind('click',function(e){
            $.isLoading({ text: "Loading" });
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/order/subscribe',
                dataType: 'json',
                type: 'POST',
                data: submit_data,
                success: function(r) {
                    $('#step_2').hide();
                    $('#step_3').show();
                    $('#bank_order_detail').html( $('table.order_detail:last').clone() );
                    $('#order_receive_info').html( $('table.order_detail_confirm:last').clone() );
                    $('#bank_shipping_fare').html( $('.shipping_fare:last').clone() );
                    $('#bank_total_amount').html( $('.total_amount:last').clone() );

                },
                complete : function(){
                    $.isLoading( "hide" );
                }
            });
        });
        $('a.delete_detail').bind('click',function(){
            var $tr = $(this).parents('tr');
            $.isLoading({ text: "Loading" });
            var data = {GUID:$(this).attr('targetGUID') };
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/order/delete_detail',
                dataType: 'json',
                type: 'POST',
                data: data,
                success: function(r) {
                    $tr.remove();
                    cacl_fare();
                    

                    if(r.content.order_num_rows == 0 ){
                        alert("購物車沒有東西按確定回「線上綠市集」。");
                        location.href = '/market/category'
                    }
                },
                complete : function(){
                    $.isLoading( "hide" );
                }
            });
        });
function populate($selector,OrderCounts , Stock) {
    for($i = 1 ; $i <= Stock ; $i++){
        $selector.append('<option value="'+$i+'">'+$i+'</option>');
    }
    $selector.val(OrderCounts).bind('change',function(){
        $selector.parent().parent().find('.product_order_counts').text($(this).val());
        
        $.isLoading({ text: "Loading" });
        var data = {
                GUID:$(this).attr('targetGUID'),
                OrderCounts: $(this).val()
        };
        $.ajax({
            //must to set synchronous, otherwise your need good design concept
            url: '/order/change_order_count',
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function(r) {
                cacl_fare();
            },
            complete : function(){
                $.isLoading( "hide" );
            }
        });
        
    });

}

    
{order_data2}
    populate( $('#product_order_counts_{SerialNo}') , {OrderCounts} , {Stock});

{/order_data2}

    });
</script>
