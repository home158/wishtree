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
</style>
<div class="container market">
    <div class="banner-label banner-label-member">
        <img src="/_images/banner-label-order-query-center.png"/>
    </div>
    <div class="content block">
        <div class="inside" style="text-align: center;">
            <div class="welcome_msg" >
                {orders_query_welcome_msg}
            </div>
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
