<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drag.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.scroll.start-stop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/json/json.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendGrid/jquery.trendGrid.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendTree/jquery.trendTree.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendContextMenu/jquery.trendContextMenu.js"></script>
<script type="text/javascript" src="/_script/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_script/is-loading/jquery.isloading.js"></script>


<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendGrid/trendGrid.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.button.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendTree/trendTree.css">


<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_orders}</h1>
    </div>
    <div class="pane-search">
        {orders_search}
        <input id="emailNameText" placeholder="{orders_search_hint}" name="email" type="text" value=""/>&nbsp;&nbsp;<input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{button_search}&nbsp;&nbsp;"/>
    </div>
    <div class="pane-menu">
        <div id="myMenu" class="trend-menu"></div>
    </div>
    <div class="pane-tree">
        <div id="myTree" class="trend-tree"></div>
    </div>
    <div class="pane-grid">

        <div id="myGrid" class="trend-grid"></div>
    </div>
    <div class="pane-status">
        <div id="myrtatus" class="trend-status">{status_total_rows}</div><!-- PHP Parse data-->
    </div>
</div>
<!-- ui-dialog -->
<div id="delete_dialog" title="{orders_popup_delete_title}">
    <p>{orders_popup_delete_msg}</p>
</div>
<script type="text/javascript">
var O_PARENT = {
    tree : {
        CURRENT_GUID: '{Category}',
        $myTree : $('#myTree'),
        root : {
            NAME: "{menu_view_all}",
            GUID: '00000000-0000-0000-0000-000000000000',
            CATEGORY: '00000000-0000-0000-0000-000000000000',
            IsShipping : "0,1,2",
            IsSubscribe : "0,1",
            IsPayment : "0,1",
            ShippingType : "0,1",
            ICON:'/_images/sealed-wood-box-16.png',
            CHILD: [
                        {
                            NAME:'{orders_deliver_not_yet}',
                            GUID: 'CD081E64-8314-4C4F-B010-EF734BCE6FB1',
                            CATEGORY: 'CD081E64-8314-4C4F-B010-EF734BCE6FB1',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsShipping : "0",
                            IsSubscribe : "1",
                            IsPayment : "0,1",
                            ShippingType : "0,1"
                        },
                        /*
                        {
                            NAME:'{orders_deliver_partial}',
                            GUID: '9AF999A6-550F-4FCD-93AF-24222D79EB31',
                            CATEGORY: '9AF999A6-550F-4FCD-93AF-24222D79EB31',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsShipping : "1",
                            IsSubscribe : "1",
                            IsPayment : "1",
                            ShippingType : "0,1"
                        },
                        */
                        {
                            NAME:'{orders_deliver_already}',
                            GUID: '3D06BDFD-B2FB-41DA-A472-E7DB9854D8B4',
                            CATEGORY: '3D06BDFD-B2FB-41DA-A472-E7DB9854D8B4',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsShipping : "1 ",
                            IsSubscribe : "1",
                            IsPayment : "1",
                            ShippingType : "0,1"
                        }
                        /*,
                        {
                            NAME:'{orders_subscribe_not_yet}',
                            GUID: 'E958C208-C0DE-4A19-8E4D-F37896D86C1D',
                            CATEGORY: 'E958C208-C0DE-4A19-8E4D-F37896D86C1D',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsShipping : "0",
                            IsSubscribe : "0",
                            IsPayment : "0",
                            ShippingType : "0,1"
                        }
                        */
                    ]
        },
        getSubDomain: function(GUID){
            var d1 = {};
            switch(GUID) {
                case 'CD081E64-8314-4C4F-B010-EF734BCE6FB1'://orders_deliver_not_yet
                    d1 = {
                        CHILD:[
                            {
                                NAME:'{orders_payment_not_yet}',
                                GUID: O_PARENT.tree.createGUID(),
                                CATEGORY: GUID,
                                HAS_EXPAND_COLLAPSE_ICON : false,
                                ICON:'/_images/sealed-wood-box-16.png',
                                IsShipping : "0",
                                IsSubscribe : "1",
                                IsPayment : "0",
                                ShippingType : "0,1"
                            },
                            {
                                NAME:'{orders_payment_already}',
                                GUID: O_PARENT.tree.createGUID(),
                                CATEGORY: GUID,
                                HAS_EXPAND_COLLAPSE_ICON : false,
                                ICON:'/_images/sealed-wood-box-16.png',
                                IsShipping : "0",
                                IsSubscribe : "1",
                                IsPayment : "1",
                                ShippingType : "0,1"
                            }
                        ]
                    };
                    break;
                case '9AF999A6-550F-4FCD-93AF-24222D79EB31'://orders_deliver_partial
                    d1 = {
                        CHILD:[
                            {
                                NAME:'{orders_shipping_type_single}',
                                GUID: O_PARENT.tree.createGUID(),
                                CATEGORY: GUID,
                                HAS_EXPAND_COLLAPSE_ICON : false,
                                ICON:'/_images/sealed-wood-box-16.png',
                                IsShipping : "1",
                                IsSubscribe : "1",
                                IsPayment : "1",
                                ShippingType : "0"
                            },
                            {
                                NAME:'{orders_shipping_type_multi}',
                                GUID: O_PARENT.tree.createGUID(),
                                CATEGORY: GUID,
                                HAS_EXPAND_COLLAPSE_ICON : false,
                                ICON:'/_images/sealed-wood-box-16.png',
                                IsShipping : "1",
                                IsSubscribe : "1",
                                IsPayment : "1",
                                ShippingType : "1"
                            }
                        ]
                    };
                    break;
           }   

            return d1;
        },
        createGUID : function () {
          function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
              .toString(16)
              .substring(1);
          }
          return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
        },
        init: function(GUID){
            this.$myTree.trendTree(
                {
                    getSubDomain: this.getSubDomain,
                    data: this.root,
                    expand: function(ui) {
                        //if (ui.data.GUID == '6A928D1F-EB98-4D78-A792-F8B35B03E166') {
                            $('#myTree').trendTree('renderNode', ui, this.getSubDomain(ui.data.GUID));
                        //} else {
                            //$('#myTree').trendTree('renderNode', ui, {
                              //  CHILD: []
                            //});
                        //}
                    },
                    selected: function(ui) {
                        O_PARENT.tree.CURRENT_GUID = ui.data.GUID;
                        if(O_PARENT.firstTriggerSelect)
                            return false;
                        if(ui.data.GUID == 'search-result'){
                            O_PARENT.grid.search_mode = true;
                        }else{
                            O_PARENT.grid.search_mode = false;
                        }
                        
                        O_PARENT.grid.render_grid(ui.data.NODE_DATA);
                    },
                    droppable : {
                        disabled : false,
                        drop : function( ev, ui ){
                            if( typeof console != 'undefined' ){
                                //console.log( $(ui).attr('guid') );
                            }
                        }
                    }
                }
            );
            $('#myTree').trendTree('triggerSelect',{
                GUID: GUID, 
                expandAndSelect:true 
            });

        }
    },
    menu : {
        $myMenu : $('#myMenu'),
        $creat_account_dialog : $("#creat_account_dialog"),
        CLIENT_MENU : {
            buttonMode: true,
            theme: 'osce-button',
            menu: [
                {
                    TEXT: '{contextmenu_order_edit}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -48],
                        GRAYOUT: [-0, -64]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
                            
                            //var GUID = r.map(function(elem){return elem.GUID;}).join(",");
                            var GUID = r[0].GUID;
                            $.popupWindow('/admin/orders/edit/'+GUID, { 
                                height: 800, 
                                width: 960,
                                createNew: true,
                                onUnload: function(){
                                }
                            });
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_shipping}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -384],
                        GRAYOUT: [-0, -408]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
                            
                            //var GUID = r.map(function(elem){return elem.GUID;}).join(",");
                            var GUID = r[0].GUID;
                            $.popupWindow('/admin/orders/details/'+GUID, { 
                                height: 800, 
                                width: 960,
                                createNew: true,
                                onUnload: function(){
                                }
                            });
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_order_flow}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -432],
                        GRAYOUT: [-0, -456]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
                            
                            //var GUID = r.map(function(elem){return elem.GUID;}).join(",");
                            var GUID = r[0].GUID;
                            $.popupWindow('/admin/orders/flow/'+GUID, { 
                                height: 600, 
                                width: 800,
                                createNew: true,
                                onUnload: function(){
                                }
                            });
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_delete}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -336],
                        GRAYOUT: [-0, -360  ]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
    
                        $( "#delete_dialog" ).dialog( "open" );
                        event.preventDefault();
                    }
                },
                {
                    TEXT: '{contextmenu_palyment_confirm}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -480],
                        GRAYOUT: [-0, -504]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_palyment_confirm(GUID,r[0]);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_palyment_cancel}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -528],
                        GRAYOUT: [-0, -552]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_palyment_cancel(GUID,r[0]);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_shipping_confirm}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -576],
                        GRAYOUT: [-0, -600]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_shipping_confirm(GUID,r[0]);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_shipping_cancel}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -624],
                        GRAYOUT: [-0, -648]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_shipping_cancel(GUID,r[0]);
                        });
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
        delete_dialog: function(){
            //Delete function
            $( "#delete_dialog" ).dialog({
                autoOpen: false,
                width: 400,
                buttons: [
                    {
                        text: "{button_ok}",
                        click: function() {  
                            $("#delete_dialog").parent().append('<div id="delete_dialog_loading" style="position: absolute;top: 0;width: 100%;height: 100%;"><img src="/_images/bar-loading.gif" style="  padding-bottom: 1em;padding-left: 1em;bottom: 0;position: absolute;"/></div>');
                            //$('<img src="/_images/ajax-loader.gif" style=""/>').insertBefore("#delete_dialog");
                            $('#myGrid').trendGrid('getSelected', function(r){
                                var GUID = "'";
                                GUID += r.map(function(elem){return O_PARENT.grid.GUID_list[elem];}).join("','");
                                GUID += "'";
                                console.log(GUID);
                                var callback = function(){
                                   $( "#delete_dialog" ).dialog( "close" );
                                   $('#delete_dialog_loading').remove();
                                };

                                O_PARENT.menu.ajax_delete_process(GUID,callback);
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
        ajax_palyment_cancel: function(GUID , top){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/palyment_cancel',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    console.log(top);
                    if(r.error_code == 0){
                        console.log(r);
                        $('#myGrid').trendGrid('registerRowsData', {
                            data: [
                                    r.content
                            ],
                            top: top
                        });
                        $('#myGrid').trendGrid('renderContent');
                        O_PARENT.menu.toggle_contextmenu([]);
                        $.isLoading( "hide" );
                    }
                }
            });
        },
        ajax_order_unsubscribe: function(GUID , top){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/unsubscribe',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    console.log(top);
                    if(r.error_code == 0){
                        console.log(r);
                        $('#myGrid').trendGrid('registerRowsData', {
                            data: [
                                    r.content
                            ],
                            top: top
                        });
                        $('#myGrid').trendGrid('renderContent');
                        O_PARENT.menu.toggle_contextmenu([]);
                        $.isLoading( "hide" );
                    }
                }
            });
        },
        ajax_palyment_confirm: function(GUID , top){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/palyment_confirm',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    console.log(top);
                    if(r.error_code == 0){
                        console.log(r);
                        $('#myGrid').trendGrid('registerRowsData', {
                            data: [
                                    r.content
                            ],
                            top: top
                        });
                        $('#myGrid').trendGrid('renderContent');
                        O_PARENT.menu.toggle_contextmenu([]);
                        $.isLoading( "hide" );
                    }
                }
            });
        },
        ajax_shipping_confirm: function(GUID , top){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/shipping_confirm',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    console.log(top);
                    if(r.error_code == 0){
                        console.log(r);
                        $('#myGrid').trendGrid('registerRowsData', {
                            data: [
                                    r.content
                            ],
                            top: top
                        });
                        $('#myGrid').trendGrid('renderContent');
                        O_PARENT.menu.toggle_contextmenu([]);
                        $.isLoading( "hide" );
                    }
                }
            });
        },
        ajax_shipping_cancel: function(GUID , top){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/shipping_cancel',
                dataType: 'json',
                type: 'POST',
                data: {
                    GUID:GUID
                },
                success: function(r) {
                    console.log(top);
                    if(r.error_code == 0){
                        console.log(r);
                        $('#myGrid').trendGrid('registerRowsData', {
                            data: [
                                    r.content
                            ],
                            top: top
                        });
                        $('#myGrid').trendGrid('renderContent');
                        O_PARENT.menu.toggle_contextmenu([]);
                        $.isLoading( "hide" );
                    }
                }
            });
        },
        ajax_delete_process: function(GUID,close_dialog){
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/delete',
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
                //Status button
                if(r.length == 1){
                    CLIENT_MENU.menu[0].DISABLED = false;
                    CLIENT_MENU.menu[1].DISABLED = false;
                    CLIENT_MENU.menu[2].DISABLED = false;
                }else{
                    CLIENT_MENU.menu[0].DISABLED = true;
                    CLIENT_MENU.menu[1].DISABLED = true;
                    CLIENT_MENU.menu[2].DISABLED = true;
                }
                //Delete button
                if(r.length >= 1){
                    CLIENT_MENU.menu[3].DISABLED = false;
                }else{
                    CLIENT_MENU.menu[3].DISABLED = true;
                }
                
                if(r.length == 1){


                    //IsPayment Confirm
                    if(r[0].IsPayment == 0){
                        CLIENT_MENU.menu[4].DISABLED = false;
                    }else{
                        CLIENT_MENU.menu[4].DISABLED = true;
                    }
                    //IsPayment Cancel
                    if(r.length == 1){
                        if(r[0].IsPayment == 1 && r[0].IsShipping == 0){
                            CLIENT_MENU.menu[5].DISABLED = false;
                        }else{
                            CLIENT_MENU.menu[5].DISABLED = true;
                        }
                    }
                    //IsShipping Confirm
                    if(r.length == 1){
                        if(r[0].IsShipping == 0 && r[0].IsPayment == 1){
                            CLIENT_MENU.menu[6].DISABLED = false;
                        }else{
                            CLIENT_MENU.menu[6].DISABLED = true;
                        }
                    }
                    //IsShipping Cancel
                    if(r.length == 1){
                        if(r[0].IsShipping == 1 && r[0].IsPayment == 1){
                            CLIENT_MENU.menu[7].DISABLED = false;
                        }else{
                            CLIENT_MENU.menu[7].DISABLED = true;
                        }
                    }
                }else{
                    CLIENT_MENU.menu[4].DISABLED = true;
                    CLIENT_MENU.menu[5].DISABLED = true;
                    CLIENT_MENU.menu[6].DISABLED = true;
                    CLIENT_MENU.menu[7].DISABLED = true;
                }

                $myMenu.contextMenu('reload', CLIENT_MENU);
                

            });
        },
        init : function(){
            this.$myMenu.contextMenu(this.CLIENT_MENU);
            this.delete_dialog();
        }
    },
    grid: {
        $myGrid: $('#myGrid'),
        data : {grid_data}, // PHP Parse data
        GUID_list : {GUID_list}, // PHP pare data
        post_data:{
            top:0,
            bottom:37,
            IsShipping : "0,1,2",
            IsSubscribe : "0,1",
            IsPayment : "0,1",
            ShippingType : "0,1",
            SORT_COLUMN_ID: 'OrderID',
            ORDER_METHOD: 'ASC'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "OrderID",
                        name: '{gird_column_OrderID}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "Name",
                        name: '{gird_column_Name}',
                        width: 85,
                        sortAsc: true
                    },
                    {
                        id: "GUID",
                        name: 'GUID',
                        width: 140,
                        sortAsc: true
                    },
                    {
                        id: "TotalPayment",
                        name: '{gird_column_TotalPayment}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "TotalMerchandiseAmount",
                        name: '{gird_column_TotalMerchandiseAmount}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "ShippingFare",
                        name: '{gird_column_ShippingFare}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "OtherFare",
                        name: '{gird_column_OtherFare}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "IsSubscribe",
                        name: '{gird_column_IsSubscribe}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "DateSubscribe",
                        name: '{gird_column_DateSubscribe}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "IsPayment",
                        name: '{gird_column_IsPayment}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "DatePayment",
                        name: '{gird_column_DatePayment}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "IsShipping",
                        name: '{gird_column_IsShipping}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "ShippingActualDate",
                        name: '{gird_column_ShippingActualDate}',
                        width: 155,
                        sortAsc: true
                    },
                    /*
                    {
                        id: "ShippingExpectNextDate",
                        name: '{gird_column_ShippingExpectNextDate}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "ShippingArrivalAssignDates",
                        name: '{gird_column_ShippingArrivalAssignDates}',
                        width: 155,
                        sortAsc: true
                    },
                    */
                    {
                        id: "ShippingFareNote",
                        name: '{gird_column_ShippingFareNote}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "customerNote",
                        name: '{gird_column_customerNote}',
                        width: 155,
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
                    dragColumnId : "Name",
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
                    dragColumnId : 'OrderID',
                    stop: O_PARENT.menu.toggle_contextmenu
                },
                cellsFormat: {
                    OrderID : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    IsSubscribe: function(o){
                        o.$cell.css('text-align','center');
                        switch(o.text) {
                            case 0:
                                return "N";
                                break;
                            case 1:
                                return "Y";
                                break;
                            default:
                                return o.text;
                                break;
                        }                     
                    },
                    IsPayment : function(o){
                        o.$cell.css('text-align','center');
                        switch(o.text) {
                            case 0:
                                return "N";
                                break;
                            case 1:
                                return "Y";
                                break;
                            default:
                                return o.text;
                                break;
                        }                     
                    },
                    IsShipping: function(o){
                        o.$cell.css('text-align','center');
                         switch(o.text) {
                             case 0:
                                return "N";
                                break;
                            case 1:
                                return "Y";
                                break;
                            default:
                                return o.text;
                                break;
                        }                     
                    },
                    TotalPayment: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    TotalMerchandiseAmount: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    ShippingFare: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    OtherFare: function(o){
                        o.$cell.css('text-align','right');
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
            $('#myTree').trendTree('triggerSelect',{
                GUID: O_PARENT.tree.CURRENT_GUID, 
                expandAndSelect:false 
            });
        },
        request : function(base){
            var top = base.requestRange.top,
                bottom = base.requestRange.bottom,
                r_data = [];
                O_PARENT.grid.post_data.top = top;
                O_PARENT.grid.post_data.bottom = bottom;
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/retrieve_list',
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
        render_grid : function(NODE_DATA,go_position){
            if(this.search_mode === false){
                delete O_PARENT.grid.post_data.SEARCH_TXT;
                $.extend(true , O_PARENT.grid.post_data, NODE_DATA);
            }else{
                $.extend(true , O_PARENT.grid.post_data, NODE_DATA, this.searchData);
            }
            O_PARENT.grid.post_data.bottom = 37;
            O_PARENT.grid.post_data.top = 0;
            delete O_PARENT.grid.post_data.HAS_EXPAND_COLLAPSE_ICON;
            delete O_PARENT.grid.post_data.CHILD;
           
            
            $('#myGrid').trendGrid('cancelRowSelected'); 
            O_PARENT.menu.toggle_contextmenu([]);
            this.$myGrid.trendGrid('ajaxLoading');
            $('#myTree').trendTree('ajaxLoading');
            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/orders/retrieve_list',
                dataType: 'json',
                type: 'POST',
                data: O_PARENT.grid.post_data,
                success: function(r) {
                    
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
                        $('#myTree').trendTree('ajaxLoadingComplete');
                        
                    }else{
                        $('#num_rows').html(r.num_rows);
                        $('#myGrid').trendGrid('setOptions', { rowRecords: r.num_rows});
                        $('#myGrid').trendGrid('registerRowsData', { empty: true, top:0, data: r.grid_data});
                        $('#myGrid').trendGrid('renderContent');
                        $('#myGrid').trendGrid('ajaxLoadingComplete');
                        $('#myTree').trendTree('ajaxLoadingComplete');
                    }

                    O_PARENT.grid.GUID_list = r.GUID_list;
                    
                }
            });
        }
    },
    search: {
    },
    init : function(){
        O_PARENT.menu.init();
        O_PARENT.grid.init();
        
        O_PARENT.tree.init('{Category}');
        O_PARENT.firstTriggerSelect = false;
        //O_PARENT.search.init();
    }
};
 
$(function() {
    O_PARENT.init();
});
</script>
