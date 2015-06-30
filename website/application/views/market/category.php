<!-- ui-dialog -->
<div id="notify_dialog" title="{products_available_notify_title}">
    <p>E-mail: <input type="text" name="notify_email" value="{notify_email}" /></p>
    <input type="hidden" name="product_GUID" />
    <p class="error_msg" style="display: none;" ><em>{products_available_notify_email_error}</em></p>
</div>

<div class="container market">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-market-center.png"/>
    </div>
    <div class="content block blk-reg">
        <div class="inside" style="text-align: center;">
            {category_navi}
        </div>
        <div class="product_lists">
            {product_lists}
            <div class="product_cell " id="{ProductGUID}">
                <div class="product_img">
                    <a href="/market/product/{ProductGUID}" style="background-repeat: no-repeat; background-image: url('{CoverImageURLPath}');background-position: {CoverImageBackgroundPosition};"></a>
                    <!--<img src="{CoverImageURLPath}" />-->
                </div>
                <div class="product_title_buy clr">
                    <div class="product_shipping_type"></div>
                    <div class="product_title" title="{Title}">{Title}</div>
                    <div class="product_buy">
                        
                    </div>
                </div>
                <div class="product_price_notify">
                    <div class="product_price">${PriceSpecial}</div>
                    <div class="product_notify">
                        
                    </div>
                </div>
            </div>
            {/product_lists}
            <?php
                if($total_rows == 0){
                    echo $products_no_data_in_category;
                }
            ?>
        </div>
            {pagination}
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>
<script>
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
        $(".product_lists .product_cell:nth-child(3n-1)").addClass("middle");
        var $buy_img;
        var $buy_count;
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
        {product_lists_jquery}
            $shipping_type_img = $("#{ProductGUID} .product_shipping_type");
            $buy_img = $("#{ProductGUID} .product_buy");
            $buy_count = $("#{ProductGUID} .product_notify");

                if({Stock} == 0){
                    $('<img/>').attr('src','/_images/sell_0.png').appendTo( $buy_img );
                    //貨到通知我
                    $('<img/>').attr('src','/_images/n0.png').css('cursor','pointer').hover(function(){
                        $(this).attr('src','/_images/n1.png');

                    },function(){
                        $(this).attr('src','/_images/n0.png');
                    }).bind('click',function(){

                        $( "#notify_dialog" ).dialog( "open" );
                        $('input[name=product_GUID]').val('{ProductGUID}');
                    }).appendTo( $buy_count );
                }else{
                    $('<img />').attr('src','/_images/shipping_type_{ShippingType}.png').appendTo($shipping_type_img);
                    $('<img />').attr('src','/_images/sell_6.png').css('cursor','pointer').hover(function(){
                        $(this).attr('src','/_images/sell_7.png');
                    },function(){
                        $(this).attr('src','/_images/sell_6.png');
                    }).appendTo( $buy_img ).bind('click',{GUID:'{ProductGUID}'},function(e){
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
            

        {/product_lists_jquery}
    });
</script>
