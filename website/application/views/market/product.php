
<style>
    .inside{
        
    }
    .product_header > div{
        float: left;
    }
    .product_sub_image_0{
        width: 317px;
        height: 317px;
        border: 0px dotted #c3c3c3;
        display:inline-block;
        *display:inline;
        *zoom:1;
    }
    .product_sub_image_1_2{
        width: 154px;
        height: 317px;
        border: 0px dotted #c3c3c3;
        margin-left: 17px;
        margin-right: 17px;
    }
    .product_sub_image_1,
    .product_sub_image_2{
        height: 150px;
    }
    .product_sub_image_1{
        margin-bottom: 17px;
    }
    .product_title_shortdesc{
        width: 284px;
        height: 317px;
        border: 0px dotted #c3c3c3;
        position:  relative;
    }
    .product_title{
        position:relative;
        font-size:40px;
        line-height:40px;
        color: #93bf32;
        font-weight: 600;
        
        width: 100%;
        height:120px;
        border: 0px solid blue;
        text-overflow: ellipsis;
        overflow:hidden;
    }
 
    .product_shortdesc{
        position: absolute;
        top:  120px;
        font-size:19px;
        line-height:30px;
        color: #3e420d;
        height: 120px;
        width: 100%;
        
        border: 0px solid blue;
    }
     
    .product_price_buy_count{
        border:  0px solid red;
        position: absolute;
        bottom:  0;
        width:  100%;
        height:40px;
    }
    .product_price{
        font-size:40px;
        line-height: 40px;
        color: #93bf32;
        float: left;
    }
    .product_buy{
        margin-top: 5px;
        float: right;
        margin-right: 2px;
    }
    .product_count{
        margin-top: 3px;
        margin-right: 9px;
        float: right;

    }
    select.buy_count{
        width: 60px;
        height: 29px;
        padding: 0 0 0 10px;
    }
    .buy_notify{
        position: absolute;
        bottom:  40px;
        display :none;
        height: 27px;
        right: 0px;
    }
    .product_tab_line{
        height: 1px;
        width: 100%;
        background-color: #abd10f;         
        margin-bottom: 41px;
    }
    .product_header{
        position: relative;
        margin-bottom: 47px;
    }
    .product_content{
        position: relative;
        //margin-bottom: 47px;
    }
    .product_tabs > a{
        width: 136px;
        height: 33px;
        float: left;
        line-height: 33px;
        text-align: center;
        font-size: 18px;
        color: #93bf32;
    }
    .product_tabs > a.highlight,
    .product_tabs > a.on_view{
        background-image: url(/_images/tag_bg.png);
        color: #FFF;
    }
    .product_checkout{
        position: absolute;
        right: 0;
        top: 5px;
        width: 92px;
        height: 18px;
    }
    .product_checkout_img{
        display:inline-block;
        *display:inline;
        *zoom:1;
        width: 92px;
        height: 18px;
        background-image: url(/_images/chcekout_0.png);
    }
    .product_checkout_img:hover{
        background-image: url(/_images/chcekout_1.png);
    }
    .set_default_hidden{
        position: absolute;
        visibility: hidden;
        display: block;
        width:  100%;
    }
</style>
<!-- ui-dialog -->
<div id="notify_dialog" title="{products_available_notify_title}">
    <p>E-mail: <input type="text" name="notify_email" value="{notify_email}" /></p>
    <input type="hidden" name="product_GUID" value="{product_GUID}"/>
    <p class="error_msg" style="display: none;" ><em>{products_available_notify_email_error}</em></p>
</div>

<div class="container market">
    <div class="content block blk-reg clr" id="{GUID}">
        <div class="inside">
            <div class="product_header  clr">
                <div class="product_sub_image_0" style="background-image: url('{SubImage0URLPath}');background-position: {SubImage0BackgroundPosition};">
                </div>
                <div class="product_sub_image_1_2">
                    <div class="product_sub_image_1" style="background-image: url('{SubImage1URLPath}');background-position: {SubImage1BackgroundPosition};"></div>
                    <div class="product_sub_image_2" style="background-image: url('{SubImage2URLPath}');background-position: {SubImage2BackgroundPosition};"></div>
                </div>
                <div class="product_title_shortdesc">
                    <div class="product_title">{Title}</div>
                    <div class="product_shortdesc">{ShortDesc}</div>
                    
                    <div class="buy_notify">
                    </div>
                    <div class="product_price_buy_count">
                        <div class="product_price">${PriceSpecial}</div>

                        <div class="product_buy">
                            
                        </div>
                        <div class="product_count">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_content">
                <div class="product_checkout">
                    <a class="product_checkout_img" href="/order/shopping_car"></a>
                </div>
                <div class="product_tabs clr">
                    <a class="product_tab_details on_view" tab="product_tab_details" href="#tab_details">{gird_column_Details}</a>
                    <a class="product_tab_recipe" tab="product_tab_recipe" href="#recipe">{gird_column_Recipe}</a>
                    <a class="product_tab_order_note" tab="product_tab_order_note" href="#order_note">{gird_column_OrderNote}</a>
                </div>
                <div class="product_tab_line"></div>
                <div class="product_tabs_content">
                    <div id="product_tab_details">
                        <iframe id="iframe_product_details" src='/market/iframe_product_details/{GUID}' frameborder="0" style="overflow:hidden;" width="100%" scrolling="no"></iframe>
                    </div>
                    <div id="product_tab_recipe" class="set_default_hidden">
                        <iframe id="iframe_product_recipe" src='/market/iframe_product_recipe/{GUID}' frameborder="0" style="overflow:hidden;" width="100%" scrolling="no"></iframe>
                    </div>
                    <div id="product_tab_order_note" class="set_default_hidden">
                        <iframe id="iframe_product_order_note" src='/market/iframe_product_order_note/{GUID}' frameborder="0" style="overflow:hidden;" width="100%" scrolling="no"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>

</div>
<script>
    
    function iframeResize(iframe,height){
        document.getElementById(iframe).style.height=height+"px";
        
        //console.log($("#"+iframe).parent().hasClass('set_default_hidden'));
        $("#"+iframe).parent('.set_default_hidden').css({
            'position':'relative',
            'display':'none',
            'visibility':'visible'
         });
    }
    function IsEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
    
    $(function () {
        $( "#notify_dialog" ).dialog({
            autoOpen: false,
            width: 400,
            buttons: [
                {
                    text: "{button_ok}",
                    click: function() { 
                        var notify_email = $('#notify_dialog input[name="notify_email"]').val();
                        var product_GUID = $('#notify_dialog input[name="product_GUID"]').val();
                        
                        if(IsEmail(notify_email)){ 
                            $("#notify_dialog").parent().append('<div id="notify_dialog_loading" style="position: absolute;top: 0;width: 100%;height: 100%;"><img src="/_images/bar-loading.gif" style="  padding-bottom: 1em;padding-left: 1em;bottom: 0;position: absolute;"/></div>');
                            $.ajax({
                                //must to set synchronous, otherwise your need good design concept
                                url: '/market/notify_add',
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    notify_email: notify_email,
                                    product_GUID: product_GUID
                                },
                                success: function(r) {
                                    $('#notify_dialog_loading').remove();
                                    $("#notify_dialog" ).dialog( "close" );
                                    $("#notify_dialog .error_msg").hide();
                                }
                            });
                        }else{
                            $("#notify_dialog .error_msg").show();
                        }
                    }
                },
                {
                    text: "{button_cancel}",
                    click: function() {
                        $( this ).dialog( "close" );
                        $('#notify_dialog_loading').remove();
                        $("#notify_dialog .error_msg").hide();
                    }
                }
            ],
            modal: true,
            overlay: {
                opacity: 0.5,
                background: "black"
            }
        });
        var $buy_title = $("#{GUID} .product_title");
        var $buy_img = $("#{GUID} .product_buy");
        var $buy_count = $("#{GUID} .product_count");
        var $buy_notify = $("#{GUID} .buy_notify");
        var options,number = 10,i;
        var save_to_order_details = function(data){
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/market/add',
                dataType: 'json',
                type: 'POST',
                data: data,
                success: function(r) {

                   // $.isLoading( "hide" );

                },
                complete : function(){
                    $.isLoading( "hide" );
                }
            });
        };
        $('.product_tabs > a').bind('click',function(){
            $(this).addClass('on_view').siblings().removeClass('on_view')
            $('#'+$(this).attr('tab')).show().siblings().hide();

        });
        $('.product_tabs > a').hover(function(){
            $(this).addClass('highlight');
        },function(){
            $(this).removeClass('highlight');

        });
            if({Stock} == 0){
                $('<img/>').attr('src','/_images/sell_3.png').appendTo( $buy_img );
                //貨到通知我
                $('<img/>').attr('src','/_images/n3.png').css('cursor','pointer').hover(function(){
                    $(this).attr('src','/_images/n4.png');
                },function(){
                    $(this).attr('src','/_images/n3.png')
                }).bind('click',function(){

                        $( "#notify_dialog" ).dialog( "open" );
                }).appendTo( $buy_notify );
                $buy_notify.show();
            }else{
                $('<img />').css({'margin-bottom':'5px','margin-left':'2px'}).attr('src','/_images/shipping_type_{ShippingType}.png').appendTo( $buy_title );
                $('<img />').attr('src','/_images/sell_8.png').css('cursor','pointer').hover(function(){
                    $(this).attr('src','/_images/sell_9.png');
                },function(){
                    $(this).attr('src','/_images/sell_8.png');
                }).appendTo( $buy_img ).bind('click',{GUID:'{GUID}'},function(e){
                    $.isLoading({ text: "Loading" });
                    var data = {
                        ProductGUID : e.data.GUID,
                        OrderCounts : $(' select[name=buy_count]' , '#'+e.data.GUID).val()
                    };
                    save_to_order_details(data);
                    //
            
                });
                //購買數量
                options = '';
                $select = $('<select class="buy_count" name="buy_count"></select>');
                if({Stock} < 10){
                    number = {Stock};
                }
                for (i = 1; i <= number; i++) {
                  options += "<option value="+i+'>'+i+'</option>'
                }
                $select.html(options).appendTo($buy_count);
            }

    });
</script>
