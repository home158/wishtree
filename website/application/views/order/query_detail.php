<style>
    table{
        width: 100%;
        font-size:16px;
    }
    .button_query{
        display:inline-block;
        *display:inline;
        *zoom:1;
        width: 93px;
        height: 23px;
        background: url(/_images/q_bg.png) no-repeat 0px 0px;
        line-height: 23px;
        color: #FFF;
    }
    .button_query:hover{
        color: #FFFF00;
    }
    .order_detail_confirm{
        font-size: 16px;
        text-align: left;
        margin-bottom: 20px;
    }
    .order_detail_confirm td{
        padding-top: 5pt;
        padding-bottom: 5pt;        
    }
</style>
<div class="container market">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-order-query-center.png"/>
    </div>
    <div class="content block">
        <div class="inside" style="text-align: center;">
            <div class="welcome_msg">
                {orders_query_welcome_msg}
            </div>
            <div class="order_detail_confirm">
                <table>
                    <tr>
                        <td width="50%">*{gird_column_OrderNumber}： <?=$order_info['OrderID']?></td>
                        <td width="50%">*{gird_column_ReceiveAddress}： <?=$order_info['ReceiveAddress']?></td>
                    <tr>
                    <tr>
                        <td>*{gird_column_ReceiveBankAccount}： <?=$order_info['ReceiveBankAccount']?></td>
                        <td>*{gird_column_ReceiveTime}： <?=$order_info['ReceiveTime']?></td>
                    <tr>
                    <tr>
                        <td>*{gird_column_OrderName}： <?=$order_info['OrderName']?></td>
                        <td>*{gird_column_ReceiveName}： <?=$order_info['ReceiveName']?></td>
                    <tr>
                    <tr>
                        <td>*{gird_column_OrderTel}： <?=$order_info['OrderTel']?></td>
                        <td>*{gird_column_ReceiveTel}： <?=$order_info['ReceiveTel']?></td>
                    <tr>
                    <tr>
                        <td>*{gird_column_OrderMobile}： <?=$order_info['OrderMobile']?></td>
                        <td>*{gird_column_ReceiveMobile}： <?=$order_info['ReceiveMobile']?></td>
                    <tr>
                </table>            </div>
            <div>
                <table class="order_detail" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="2">{gird_column_ProductTitle}</th>
                            <th>{gird_column_PriceSpecial}</th>
                            <th>{gird_column_OrderCounts}</th>
                        <tr>
                    </thead>
                    <tdoby>
                        <tr>
                            <td  colspan="4" style="height: 0px;"></td>
                        </tr>
                        {order_datail}
                        <tr>
                            <td class="product_thumb"><img width="122px" height="91px" src="{CoverImageThumbURLPath}"/></td>
                            <td class="product_title">{Title}</td>
                            <td class="product_price_actual">${PriceActual}</td>
                            
                            <td class="product_order_counts">{OrderCounts}</td>
                        </tr>
                        {/order_datail}
                        <tr>
                            <td colspan="4" style="height: 0px;"></td>
                        </tr>
                    </tdoby>
                </table>
            </div>
            <div class="shipping_fare"><?=$order_info['ShippingFareNote']?></div>
            <div class="total_amount">{orders_total_amount} <?=$order_info['TotalPayment']?></div>
            <div class="next_btn">
                <a class="btn_cagetory" href="/market/category"><img src="/_images/btn_cagetory.png"/></a>
            </div>
            <br>
            <br>
            <br>
            <div>
                <table class="order_history"  border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{gird_column_OrderNumber}</th>
                            <th>{gird_column_DateModify}</th>
                            <th>{gird_column_OrderStatus}</th>
                            <th>{gird_column_ShippingActualDate}</th>
                            <th>{gird_column_TotalPayment}</th>
                            <th>{contextmenu_details}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {order_data}
                        <tr>
                            <td>{OrderID}</td>
                            <td>{DateModify}</td>
                            <td>{Status}</td>
                            <td>{ShippingActualDate}</td>
                            <td>${TotalPayment}</td>
                            <td><a href="/order/query_detail/{OrderGUID}" class="button_query">{button_query}</a></td>
                        </tr>
                        {/order_data}
                    </thead>
                </table>
            </div>
            <div>
                <img src="/_images/banner-query.png" />
            </div>
        </div>
    </div>
    <div class="footer">
        <a data-scroll data-options='{ "easing": "easeOutCubic" }' class="go_top" href="#"></a>
    </div>
</div>
