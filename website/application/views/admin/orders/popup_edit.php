<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drag.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.scroll.start-stop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/json/json.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendGrid/jquery.trendGrid.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendContextMenu/jquery.trendContextMenu.js"></script>
<script type="text/javascript" src="/_script/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_script/jquery-ui-1.9.2/js/jquery-ui-1.9.2.custom.min.js"></script>



<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendGrid/trendGrid.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.button.css">
<link rel="stylesheet" type="text/css" href="/_script/jquery-ui-1.9.2/css/blitzer/jquery-ui-1.9.2.custom.min.css" />


<div class="pand-console">
    <form name="order_details" method="post" action="/admin/orders/edit/{order_GUID}">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{contextmenu_order_edit}</h1>
    </div>
    <div class="pane-order-info">
        <table cellpadding="10"  cellspacing="50%">
                <tr>
                    <td>
                        {gird_column_Email}： 
                    </td>
                    <td>
                        <?=$order_data['Email'] ?>
                    </td>
                    <td>
                        {gird_column_OrderNumber}： 
                    </td>
                    <td>
                        <?=$order_data['OrderID'] ?>
                    </td>

                </tr>
                <tr>
                    <td style="width:12%;">
                        {gird_column_OrderName}：
                    </td>
                    <td style="width:38%;">
                        <input name="OrderName" id="OrderName" type="text" value="<?= set_value('OrderName',$order_data['OrderName']); ?>" />
                        <?= form_error('OrderName'); ?>
                    </td>
                    <td style="width:12%;">
                        {gird_column_TotalMerchandiseAmount}：
                    </td>
                    <td style="width:38%;">
                        <input style="text-align: right;" name="TotalMerchandiseAmount_NUMERIC" id="TotalMerchandiseAmount_NUMERIC" type="text" value="<?= set_value('TotalMerchandiseAmount_NUMERIC',$order_data['TotalMerchandiseAmount_NUMERIC']); ?>" />
                        <?= form_error('TotalMerchandiseAmount_NUMERIC'); ?>

                    </td>
                </tr>
                <tr>
                    <td style="width:12%;">
                        {gird_column_OrderTel}：
                    </td>
                    <td style="width:38%;">
                        <input name="OrderTel" id="OrderTel" type="text" value="<?= set_value('OrderTel',$order_data['OrderTel']); ?>" />
                        <?= form_error('OrderTel'); ?>
                    </td>
                    <td>
                        {gird_column_ShippingFare}：
                    </td>
                    <td>
                        <input style="text-align: right;" name="ShippingFare_NUMERIC" id="ShippingFare_NUMERIC" type="text" value="<?= set_value('ShippingFare_NUMERIC',$order_data['ShippingFare_NUMERIC']); ?>" />
                        <?= form_error('ShippingFare_NUMERIC'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:12%;">
                        {gird_column_OrderMobile}：
                    </td>
                    <td style="width:38%;">
                        <input name="OrderMobile" id="OrderMobile" type="text" value="<?= set_value('OrderMobile',$order_data['OrderMobile']); ?>" />
                        <?= form_error('OrderMobile'); ?>
                    </td>
                    <td>
                        {gird_column_OtherFare}：
                    </td>
                    <td>
                        <input style="text-align: right;" name="OtherFare_NUMERIC" id="OtherFare_NUMERIC" type="text" value="<?= set_value('OtherFare_NUMERIC',$order_data['OtherFare_NUMERIC']); ?>" />
                        <?= form_error('OtherFare_NUMERIC'); ?>
                    </td>                

                </tr>

                <tr>
                    <td style="width:12%;">
                        {gird_column_ReceiveName}：
                    </td>
                    <td style="width:38%;">
                        <input name="ReceiveName" id="ReceiveName" type="text" value="<?= set_value('ReceiveName',$order_data['ReceiveName']); ?>" />
                        <?= form_error('ReceiveName'); ?>
                    </td>
                    <td>
                        {gird_column_TotalPayment}：
                    </td>
                    <td>
                        <input style="text-align: right;" name="TotalPayment_NUMERIC" id="TotalPayment_NUMERIC" type="text" value="<?= set_value('TotalPayment_NUMERIC',$order_data['TotalPayment_NUMERIC']); ?>" />
                        <?= form_error('TotalPayment_NUMERIC'); ?>
                    </td>

                </tr>

                <tr>
                    <td>
                        {gird_column_ReceiveTel}：
                    </td>
                    <td>
                        <input name="ReceiveTel" id="ReceiveTel" type="text" value="<?= set_value('ReceiveTel',$order_data['ReceiveTel']); ?>" />
                        <?= form_error('ReceiveTel'); ?>
                    </td>
                    <td>
                        {gird_column_ReceiveTime}：
                    </td>
                    <td>
                        <select name="ReceiveTime" id="ReceiveTime" >
                             <option value="{orders_receive_time_AM09PM12}">{orders_receive_time_AM09PM12}</option>
                             <option value="{orders_receive_time_PM12PM18}">{orders_receive_time_PM12PM18}</option>
                             <option value="{orders_receive_time_PM18PM21}">{orders_receive_time_PM18PM21}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        {gird_column_ReceiveMobile}：
                    </td>
                    <td>
                        <input name="ReceiveMobile" id="ReceiveMobile" type="text" value="<?= set_value('ReceiveMobile',$order_data['ReceiveMobile']); ?>" />
                        <?= form_error('ReceiveMobile'); ?>
                    </td>
                    <td>
                        {gird_column_ShippingFareNote}：
                    </td>
                    <td>
                        <input name="ShippingFareNote" id="ShippingFareNote" type="text" value="<?= set_value('ShippingFareNote',$order_data['ShippingFareNote']); ?>" />
                        <?= form_error('ShippingFareNote'); ?>
                    </td>
                </tr>
                <tr>

                    <td>
                        {gird_column_OrderCreateTime}：
                    </td>
                    <td>
                        <?=$order_data['DateCreate'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        {gird_column_ReceiveAddress}：
                    </td>
                    <td colspan="3">
                        <input name="ReceiveAddress" style="width: 340px;" id="ReceiveAddress" type="text" value="<?= set_value('ReceiveAddress',$order_data['ReceiveAddress']); ?>" />
                        <?= form_error('ReceiveAddress'); ?>
                    </td>
                </tr>

        </table>

    </div>

<p><?= form_error('UpdateToShippingCountsThisTime[]'); ?></p>
<p><?= form_error('UpdateToShippingCountsLastTime[]'); ?></p>
<p><?= form_error('UpdateToShippingCounts[]'); ?></p>
<p><?= form_error('UpdateToOrderCounts[]'); ?></p>
<p><?= form_error('UpdateToPriceActual[]'); ?></p>
    
    <div class="pane-grid">
        <div id="myGrid" class="trend-grid"></div>
    </div>
    <div class="pane-status">
        <div id="myrtatus" class="trend-status">{status_total_rows}</div><!-- PHP Parse data-->
    </div>
    <br/>
    <div class="pane-footer">
        <input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_submit}&nbsp;&nbsp;"/>        <input id="cancelBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_cancel}&nbsp;&nbsp;"/>
    </div>
    </form>

</div>


<script type="text/javascript">
var O_PARENT = {
    menu : {
        toggle_contextmenu: function(r){

        }
    },
    grid : {
        $myGrid: $('#myGrid'),
        data : {grid_data}, // PHP Parse data
        post_data:{
            top:0,
            bottom:37,
            ProductGUID: "{ProductGUID}",
            SORT_COLUMN_ID: 'NotifyID',
            ORDER_METHOD: 'DESC'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "CHECKBOX",
                        name: '{contextmenu_checkbox}',
                        width: 35,
                        sortAsc: false
                    },
                    {
                        id: "SerialNo",
                        name: '{gird_column_ItemNo}',
                        width: 35,
                        sortAsc: false
                    },
                    {
                        id: "Title",
                        name: '{gird_column_ProductTitle}',
                        width: 120,
                        sortAsc: true
                    },
                    {
                        id: "CategoryName",
                        name: '{gird_column_Category}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "ShippingCountsThisTime",
                        name: '{gird_column_ShippingCountsThisTime}',
                        width: 100,
                        sortAsc: false
                    },
                    {
                        id: "ShippingCountsLastTime",
                        name: '{gird_column_ShippingCountsLastTime}',
                        width: 100,
                        sortAsc: false
                    },
                    {
                        id: "ShippingCounts",
                        name: '{gird_column_ShippingCounts}',
                        width: 75,
                        sortAsc: true
                    },
                    {
                        id: "OrderCounts",
                        name: '{gird_column_OrderCounts}',
                        width: 65,
                        sortAsc: true
                    },
                    {
                        id: "PriceMSRP",
                        name: '{gird_column_PriceMSRP}',
                        width: 75,
                        sortAsc: true
                    },
                    {
                        id: "PriceSpecial",
                        name: '{gird_column_PriceSpecial}',
                        width: 75,
                        sortAsc: true
                    },
                    {
                        id: "PriceActual",
                        name: '{gird_column_PriceActual}',
                        width: 75,
                        sortAsc: true
                    },

                    {
                        id: "DateModify",
                        name: '{gird_column_DateModify}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "DateCreate",
                        name: '{gird_column_DateCreate}',
                        width: 155,
                        sortAsc: true
                    }
                ],
                data: this.data,
                rowRecords: {num_rows},// PHP Parse data
                scrollRowsBuffer : 20,
                dynamicRequestData: {
                    disabled: false,
                    request: this.request
                },
                onSelected : O_PARENT.menu.toggle_contextmenu,
                unSelected : O_PARENT.menu.toggle_contextmenu,
                dragSelect: {
                    dragColumnId : "NotifyID",
                    stop: O_PARENT.menu.toggle_contextmenu
                },
                emptyContentDescription: 'No data to display.',
                columnSort: {
                    stop: function(ui,sortAsc){
                        var order_method;
                        if(sortAsc == true)
                            order_method = "ASC";
                        else
                            order_method = "DESC";        
                        var data = {
                                    SORT_COLUMN_ID: ui.sortColumnId,
                                    ORDER_METHOD: order_method
                            };
                        var go_position = {y:0};
                        O_PARENT.grid.render_grid(data,go_position);
                         
                         
                    }
                },
                cellsFormat: {
                    SerialNo : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    PriceMSRP:function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    PriceSpecial:function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    ShippingCountsThisTime: function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToShippingCountsThisTime',o.data.ShippingCountsThisTime,'text-align:center;');
                        o.$cell.html(html);
                    },
                    ShippingCountsLastTime: function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToShippingCountsLastTime',o.data.ShippingCountsLastTime,'text-align:center;');
                        o.$cell.html(html);
                    },
                    ShippingCounts: function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToShippingCounts',o.data.ShippingCounts,'text-align:center;');
                        o.$cell.html(html);
                    },
                    OrderCounts: function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToOrderCounts',o.data.OrderCounts,'text-align:center;');
                        o.$cell.html(html);
                    },
                    
                    PriceActual : function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToPriceActual',o.data.PriceActual_NUMERIC,'text-align:right;');
                        o.$cell.html(html);
                    },
                    CHECKBOX : function(o){
                        var html = '<input name="GUID[]" type="hidden" value="'+o.data.GUID+'"/>';
                            html += O_PARENT.grid.createCheckBox('save_to_db', (o.data.SerialNo-1));
                        o.$cell.html(html).css('text-align','center');

                        o.$row.unbind('click').bind('click',function(e){
                            var $checkbox = $(this).find('input[type=checkbox]');
                            if ( $( e.target ).is( 'input:checkbox' )) { 
                                return;
                            }
                            if ( $( e.target ).is( 'select' )) {
                                $checkbox.prop('checked', true);
                                return;
                            }
                            if ( $( e.target ).is( 'input[type=text]' )) {
                                $checkbox.prop('checked', true);
                                return;
                            }
                            if($checkbox.prop('checked')){
                                $checkbox.prop('checked', false);
                            }else{
                                $checkbox.prop('checked', true);
                            }

                        });
                    }
                },
                rowHeight : 30,
                columnSort: {
                    disabled: true
                }
            });
        },
        createCheckBox: function(name,value){
            var html = '<input type="checkbox" class="product-item" name="'+name+'[]" value="'+value.toString()+'"/>';
            return html;
        },
        createInputBox: function(name , value,css){
            var html = '<input style="'+css+'padding:0px;height:26px;line-height:25px;width:100%;margin-top:0px;margin-bottom:0px;" type="text" value="'+value+'" name="'+name+'[]"/>';
            return html;
        },
        createRemainOptions: function(GUID , name , ShippingCountsThisTime , RemainCount){
            var $select = '<input name="GUID[]" type="hidden" value="'+GUID+'"/>';
                $select += '<select name="'+name+'[]" style="height:24px;line-height:23px;width:100%;padding-top:0px;padding-bottom:0px;margin-top:3px;">';
            var i = 0-ShippingCountsThisTime;
            var $selected = "";
           
            while (i <= RemainCount) {
                if(RemainCount == i){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                if(i>=0){
                    ii = '+' + i.toString();
                }else{
                    ii = i.toString();
                }
                 
                $select += '<option value="'+ii+'" '+ $selected+'>'+ii+'</option>';
                i++;
            }
            
            $select += '</select>';
            return $select;
        },
        getSelectedInfo: function(_callback){
            $('#myGrid').trendGrid('getSelectedInfo', function(r){
                _callback(r);
            });
        },
        reload: function(){
            location.reload();
        },
        request : function(base){
            var top = base.requestRange.top,
                bottom = base.requestRange.bottom,
                r_data = [];
                O_PARENT.grid.post_data.top = top;
                O_PARENT.grid.post_data.bottom = bottom;
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/retrieve_details_list',
                dataType: 'json',
                type: 'POST',
                data: O_PARENT.grid.post_data,
                success: function(r) {
                    O_PARENT.grid.$myGrid.trendGrid('registerRowsData', {
                        data: r.grid_data,
                        top: top
                    });
                    O_PARENT.grid.$myGrid.trendGrid('appendRows');
                }
            });        
        },
        search_mode: false,
        searchData : {},
        render_grid : function(NODE_DATA,go_position,callback){
            $.extend(true , O_PARENT.grid.post_data, NODE_DATA);
            O_PARENT.grid.post_data.bottom = 37;
            O_PARENT.grid.post_data.top = 0;
            delete O_PARENT.grid.post_data.HAS_EXPAND_COLLAPSE_ICON;
            delete O_PARENT.grid.post_data.CHILD;
           
            
            $('#myGrid').trendGrid('cancelRowSelected'); 
            O_PARENT.menu.toggle_contextmenu([]);
            this.$myGrid.trendGrid('ajaxLoading');
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/notify/retrieve_list',
                dataType: 'json',
                type: 'POST',
                data: O_PARENT.grid.post_data,
                success: function(r) {
                    if(typeof(callback) != 'undefined'){
                        callback(r);
                    }
                    $('#myGrid').trendGrid('removeRegisterRowsData'); 
                    if(typeof(go_position) != 'undefined'){
                        $('#myGrid').trendGrid('scrollTo',go_position);
                    }else{
                        $('#myGrid').trendGrid('scrollTo',{x:0,y:0});
                    }
                    if(r.num_rows == 0){
                        $('#myGrid').trendGrid('renderContent', {
                            rowRecords: 0,
                            emptyContentDescription: 'No data to display'
                        });
                        $('#myGrid').trendGrid('ajaxLoadingComplete');
                        
                    }else{
                        $('#num_rows').html(r.num_rows);
                        $('#myGrid').trendGrid('setOptions', { rowRecords: r.num_rows});
                        $('#myGrid').trendGrid('registerRowsData', { empty: true, top:0, data: r.grid_data});
                        $('#myGrid').trendGrid('renderContent');
                        $('#myGrid').trendGrid('ajaxLoadingComplete');
                    }
                    
                }
            });
        }
    },
    firstTriggerSelect : true,
    init : function(){
        O_PARENT.grid.init();
        
        O_PARENT.firstTriggerSelect = false;
        $( window ).resize(function() {
            $('#myGrid').trendGrid('renderContent');
        });
    }
};
 
$(function() {
    O_PARENT.init();
    $('select[name=ReceiveTime]').val('<?= set_value('ReceiveTime',$order_data['ReceiveTime']); ?>');
});
</script>
