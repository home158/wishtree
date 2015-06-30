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
    <form name="order_details" method="post" action="">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{contextmenu_order_flow}</h1>
    </div>
    <div class="pane-order-info">
        <table>

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
                        <?=$order_data['OrderName'] ?>
                    </td>
                    <td style="width:12%;">
                        {gird_column_TotalMerchandiseAmount}：
                    </td>
                    <td style="width:38%;">
                        <?=$order_data['TotalMerchandiseAmount_NUMERIC'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:12%;">
                        {gird_column_OrderTel}：
                    </td>
                    <td style="width:38%;">
                        <?=$order_data['OrderTel'] ?>
                    </td>
                    <td>
                        {gird_column_ShippingFare}：
                    </td>
                    <td>
                        <?=$order_data['ShippingFare_NUMERIC'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:12%;">
                        {gird_column_OrderMobile}：
                    </td>
                    <td style="width:38%;">
                        <?=$order_data['OrderMobile'] ?>
                    </td>
                    <td>
                        {gird_column_OtherFare}：
                    </td>
                    <td>
                        <?=$order_data['OtherFare_NUMERIC'] ?>
                    </td>                

                </tr>

                <tr>
                    <td style="width:12%;">
                        {gird_column_ReceiveName}：
                    </td>
                    <td style="width:38%;">
                        <?=$order_data['ReceiveName'] ?>
                    </td>
                    <td>
                        {gird_column_TotalPayment}：
                    </td>
                    <td>
                        <?=$order_data['TotalPayment_NUMERIC'] ?>
                    </td>

                </tr>

                <tr>
                    <td>
                        {gird_column_ReceiveTel}：
                    </td>
                    <td>
                        <?=$order_data['ReceiveTel'] ?>
                    </td>
                    <td>
                        {gird_column_ReceiveTime}：
                    </td>
                    <td>
                        <?=$order_data['ReceiveTime'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        {gird_column_ReceiveMobile}：
                    </td>
                    <td>
                        <?=$order_data['ReceiveMobile'] ?>
                    </td>
                    <td>
                        {gird_column_ShippingFareNote}：
                    </td>
                    <td>
                        <?=$order_data['ShippingFareNote'] ?>
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
                        <?=$order_data['ReceiveAddress'] ?>
                    </td>
                </tr>

        </table>

    </div>

    <div class="pane-grid">
        <div id="myGrid" class="trend-grid"></div>
    </div>
    <div class="pane-status">
        <div id="myrtatus" class="trend-status">{status_total_rows}</div><!-- PHP Parse data-->
    </div>
    </form>
</div>

<!-- ui-dialog -->
<div id="shipping_history_dialog" title="{contextmenu_shipping_history_history}">
    <p>{detail_shipping_history_msg}</p>
</div>
<script type="text/javascript">
var O_PARENT = {
    menu : {
        $myMenu : $('#myMenu'),
        $creat_account_dialog : $("#creat_account_dialog"),
        ajax_sending_mail: function(GUID_list,close_dialog){
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/notify/sending_mail',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID_list:GUID_list,
                    ProductGUID: O_PARENT.grid.post_data.ProductGUID
                },
                success: function(r) {
                    if(r.error_code == 0){
                        close_dialog();
                    }
                    
                    $('#delete_dialog_loading').remove();
                    O_PARENT.grid.reload();
                }
            });            
        },
       shipping_history_dialog: function(){
            //Delete function
            $( "#shipping_history_dialog" ).dialog({
                autoOpen: false,
                width: 600,
                height: 400,
                buttons: [
                    {
                        text: "{button_close}",
                        click: function() {  
                            $( this ).dialog( "close" );

                        }
                    }
                ],
                modal: true,
                overlay: {
                    opacity: 0.5,
                    background: "black"
                }
            });
        },
        ajax_delete_process: function(GUID,close_dialog){
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/products/delete',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){
                        close_dialog();
                    }
                    
                    $('#delete_dialog_loading').remove();
                    O_PARENT.grid.reload();
                }
            });
        },

        init : function(){
            this.$myMenu.contextMenu(this.CLIENT_MENU);
            this.shipping_history_dialog();
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
                        id: "SerialNo",
                        name: '{gird_column_FlowID}',
                        width: 35,
                        sortAsc: false
                    },
                    {
                        id: "DateCreate",
                        name: '{gird_column_FlowDateCreate}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "UserEmail",
                        name: '{gird_column_FlowUserEmail}',
                        width: 100,
                        sortAsc: true
                    },
                    {
                        id: "FlowStatu",
                        name: '{gird_column_FlowStatu}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "FlowNote",
                        name: '{gird_column_FlowNote}',
                        width: 200,
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
                    Remain : function(o){
                        var RemainCount  = o.data.OrderCounts - o.data.ShippingCounts - o.data.ShippingCountsThisTime;
                        var html = O_PARENT.grid.createRemainOptions(o.data.GUID , 'AddToShippingCountsThisTime',o.data.ShippingCountsThisTime ,RemainCount);
                        
                        o.$cell.html(html);
                    },
                    PriceActual : function(o){
                        var html = O_PARENT.grid.createInputBox('UpdateToPriceActual',o.data.PriceActual);
                        o.$cell.html(html);
                    },
                    CHECKBOX : function(o){
                        var html = O_PARENT.grid.createCheckBox('save_to_db', (o.data.SerialNo-1));
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
        createInputBox: function(name , value){
            var html = '<input style="padding:0px;height:26px;line-height:25px;width:100%;margin-top:0px;margin-bottom:0px;" type="text" value="'+value+'" name="'+name+'[]"/>';
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
        O_PARENT.menu.init();
        O_PARENT.grid.init();
        
        O_PARENT.firstTriggerSelect = false;
        $( window ).resize(function() {
            $('#myGrid').trendGrid('renderContent');
        });
    }
};
 
$(function() {
    O_PARENT.init();
});
</script>
