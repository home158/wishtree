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
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{contextmenu_arrvival}</h1>
    </div>
    <div class="pane-menu">
        <div id="myMenu" class="trend-menu"></div>
    </div>

    <div class="pane-grid">
        <div id="myGrid" class="trend-grid"></div>
    </div>
    <div class="pane-status">
        <div id="myrtatus" class="trend-status">{status_total_rows}</div><!-- PHP Parse data-->
    </div>
</div>
<!-- ui-dialog -->
<div id="sending_mail_dialog" title="{notify_popup_sending_mail_title}">
    <p>{notify_popup_sending_mail_msg}</p>
</div>

<script type="text/javascript">
var O_PARENT = {
    menu : {
        $myMenu : $('#myMenu'),
        $creat_account_dialog : $("#creat_account_dialog"),
        CLIENT_MENU : {
            buttonMode: true,
            theme: 'osce-button',
            menu: [
                {
                    TEXT: '{contextmenu_email_notify}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -240],
                        GRAYOUT: [-0, -264]
                    },
                    ONCLICK: function(e) {
                        $( "#sending_mail_dialog" ).dialog( "open" );


                    }
                },
                {
                    TEXT: '{contextmenu_reload}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -192],
                        GRAYOUT: [-0, -216]
                    },
                    DISABLED : false,
                    ONCLICK: function(e) {
                        O_PARENT.grid.reload();
                    }
                }
            ]
        },
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
                    
                    $('#sending_mail_dialog_loading').remove();
                    O_PARENT.grid.reload();
                }
            });            
        },
       sending_mail_dialog: function(){
            //Delete function
            $( "#sending_mail_dialog" ).dialog({
                autoOpen: false,
                width: 400,
                buttons: [
                    {
                        text: "{button_ok}",
                        click: function() {  
                            $("#sending_mail_dialog").parent().append('<div id="sending_mail_dialog_loading" style="position: absolute;top: 0;width: 100%;height: 100%;"><img src="/_images/bar-loading.gif" style="  padding-bottom: 1em;padding-left: 1em;bottom: 0;position: absolute;"/></div>');
               
                            $('#myGrid').trendGrid('getSelected', function(r){
                                var GUID = "'";
                                GUID += r.map(function(elem){return O_PARENT.grid.GUID_list[elem];}).join("','");
                                GUID += "'";
                               var callback = function(){
                                   $( "#sending_mail_dialog" ).dialog( "close" );
                               };

                                O_PARENT.menu.ajax_sending_mail(GUID,callback);
                            });

                        }
                    },
                    {
                        text: "{button_cancel}",
                        click: function() {
                            $( this ).dialog( "close" );
                            $('#delete_dialog_loading').remove();

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
        toggle_contextmenu: function(r){
            O_PARENT.grid.$myGrid.trendGrid('getSelectedInfo', function(r){
                var CLIENT_MENU = O_PARENT.menu.CLIENT_MENU;
                var $myMenu = O_PARENT.menu.$myMenu;
                //
                if(r.length >= 1){
                    CLIENT_MENU.menu[0].DISABLED = false;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }else{
                    CLIENT_MENU.menu[0].DISABLED = true;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }

                

            });
        },
        init : function(){
            this.$myMenu.contextMenu(this.CLIENT_MENU);
            this.sending_mail_dialog();
        }
    },
    grid : {
        $myGrid: $('#myGrid'),
        data : {grid_data}, // PHP Parse data
        GUID_list : {GUID_list}, // PHP pare data
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
                        id: "NotifyID",
                        name: '{gird_column_NotifyID}',
                        width: 55,
                        sortAsc: false
                    },
                    {
                        id: "GUID",
                        name: 'GUID',
                        width: 140,
                        sortAsc: true
                    },
                    {
                        id: "ProductTitle",
                        name: '{gird_column_ProductTitle}',
                        width: 85,
                        sortAsc: true
                    },
                    {
                        id: "Name",
                        name: '{gird_column_Name}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "Email",
                        name: '{gird_column_Email}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "NotifyTimes",
                        name: '{gird_column_NotifyTimes}',
                        width: 50,
                        sortAsc: true
                    },
                    {
                        id: "LastNotifyDate",
                        name: '{gird_column_LastNotifyDate}',
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
                dragSelect:{
                    dragColumnId : 'NotifyID',
                    stop: O_PARENT.menu.toggle_contextmenu
                },
                cellsFormat: {
                    NotifyID : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    NotifyTimes : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    }
                }
            });
        },
        getSelectedInfo: function(_callback){
            $('#myGrid').trendGrid('getSelectedInfo', function(r){
                _callback(r);
            });
        },
        reload: function(){
            var go_position = {x:0,y:0};
            var callback = function(r){
                    O_PARENT.grid.GUID_list = r.GUID_list;
                };
            O_PARENT.grid.render_grid({},go_position,callback);
        },
        request : function(base){
            var top = base.requestRange.top,
                bottom = base.requestRange.bottom,
                r_data = [];
                O_PARENT.grid.post_data.top = top;
                O_PARENT.grid.post_data.bottom = bottom;
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/notify/retrieve_list',
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
    }
};
 
$(function() {
    O_PARENT.init();
});
</script>
