<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.drag.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.drop.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.scroll.start-stop.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/json/json.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendGrid/jquery.trendGrid.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendTree/jquery.trendTree.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendContextMenu/jquery.trendContextMenu.js"></script>
<script type="text/javascript" src="/_js/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_js/is-loading/jquery.isloading.js"></script>


<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendGrid/trendGrid.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendContextMenu/trendContextMenu.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendContextMenu/trendContextMenu.button.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendTree/trendTree.css">


<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_fortune}</h1>
    </div>
    <div class="pane-search">
        {menu_search_account}
        <input id="emailNameText" placeholder="{menu_search_hint}" name="search_text" type="text" value=""/>&nbsp;&nbsp;<input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{btn_search}&nbsp;&nbsp;"/>
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
        <div id="myrtatus" class="trend-status">{menu_total_rows}</div><!-- PHP Parse data-->
    </div>
</div>
<!-- ui-dialog -->
<div id="delete_dialog" title="{members_popup_delete_title}">
    <p>{members_popup_delete_msg}</p>
</div>
<script type="text/javascript">
var O_PARENT = {
    tree : {
        CURRENT_GUID: '{GUID}',
        $myTree : $('#myTree'),
        getCurrentRank : function(){
            switch(this.CURRENT_GUID) {
                case '6A928D1F-EB98-4D78-A792-F8B35B03E166':
                    return 1;
                    break;
                case '8C06A53F-4971-4954-9C6B-D3EC709A3BC9':
                    return 0;
                    break;
                case 'B5F90B86-52AE-4F8B-BDB6-E7C7CC8325FB':
                    return 255;
                    break;
                default:
                    return 1;
                    break;
            }            
 
        },
        root : {
            NAME: "{fortune_view_all}",
            GUID: '00000000-0000-0000-0000-000000000000',
            PAYMENT_STATUS: '0,1,2',
            ST: '0,1',
            MT: '0,1',
            ICON:'/_images/friends-16.png',
            CHILD: [
                        {
                            NAME:'{fortune_payment_already}',
                            GUID: '6A928D1F-EB98-4D78-A792-F8B35B03E166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            PAYMENT_STATUS: '2',
                            ST: '0',
                            MT: '0'
                        },
                        {
                            NAME:'{fortune_payment_vip}',
                            GUID: '6A928D1F-EB98-4D78-A792-F8B35B03E166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            PAYMENT_STATUS: '1',
                            ST: '0',
                            MT: '0'
                        },
                        {
                            NAME:'{fortune_payment_pending}',
                            GUID: '6A928D1F-EB98-4D78-A792-F8B35B03E166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            PAYMENT_STATUS: '0',
                            ST: '0',
                            MT: '0'
                        },
                        {
                            NAME:'{fortune_future_ST}',
                            GUID: '6A928D1F-EB98-4D78-A792-F8B35B03E166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            PAYMENT_STATUS: '0,1,2',
                            ST: '1',
                            MT: '0'
                        },
                        {
                            NAME:'{fortune_future_MT}',
                            GUID: '6A928D1F-EB98-4D78-A792-F8B35B03E166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            PAYMENT_STATUS: '0,1,2',
                            ST: '0,1',
                            MT: '1'
                        }
                    ]
        },
        getSubDomain: function(GUID){
            var d1 = {
                CHILD:[
                    {
                        NAME:'{register_type_google}',
                        GUID: '1F12F18F-60B8-4734-A2EF-B1AB138EA139',
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        RANK_BETWEEN_FROM: 1,
                        RANK_BETWEEN_TO: 254,
                        ICON:'/_images/google-plus-16.png',
                        REGISTER_TYPE : "3"
                    },
                    {
                        NAME:'{register_type_facebook}',
                        GUID: 'C3142A73-3D24-495A-B4C2-1EF6CA54CB9C',
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        RANK_BETWEEN_FROM: 1,
                        RANK_BETWEEN_TO: 254,
                        ICON:'/_images/facebook-16.png',
                        REGISTER_TYPE : "2"
                    },
                    {
                        NAME:'{register_type_normal}',
                        GUID: '3E5B7846-A295-4418-9296-FA384136F83E',
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        RANK_BETWEEN_FROM: 1,
                        RANK_BETWEEN_TO: 254,
                        ICON:'/_images/business-card-16.png',
                        REGISTER_TYPE : "1"
                    }
                ]
            };
            return d1;
        },
        init: function(GUID){
            this.$myTree.trendTree(
                {
                    getSubDomain: this.getSubDomain,
                    data: this.root,
                    expand: function(ui) {
                        if (ui.data.GUID == '6A928D1F-EB98-4D78-A792-F8B35B03E166') {
                            $('#myTree').trendTree('renderNode', ui, this.getSubDomain(ui.data.GUID));
                        } else {
                            $('#myTree').trendTree('renderNode', ui, {
                                CHILD: []
                            });
                        }
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
                                console.log( $(ui).attr('guid') );
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
                    TEXT: '{contextmenu_fortunr_detail}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -96],
                        GRAYOUT: [-0, -120]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
                            
                            //var GUID = r.map(function(elem){return elem.GUID;}).join(",");
                            var GUID = r[0].GUID;
                            $.popupWindow('/admin/fortune/detail/'+GUID, { 
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
                    TEXT: '{contextmenu_payment_pass}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -144],
                        GRAYOUT: [-0, -168]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_payment_pass(GUID,r[0] , 2);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_payment_vip_free}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -144],
                        GRAYOUT: [-0, -168]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_payment_pass(GUID,r[0] , 1);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_payment_padding}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -144],
                        GRAYOUT: [-0, -168]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_payment_pass(GUID,r[0] , 0);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_canceled}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -48],
                        GRAYOUT: [-0, -72]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_cancel_pass(GUID,r[0] , 1);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_canceled_padding}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -0],
                        GRAYOUT: [-0, -24]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_cancel_pass(GUID,r[0] , 0);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_MT}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -0],
                        GRAYOUT: [-0, -24]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_mt_pass(GUID,r[0] , 1);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_MT_padding}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -0],
                        GRAYOUT: [-0, -24]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_mt_pass(GUID,r[0] , 0);
                        });
                    }
                },

                {
                    TEXT: '{contextmenu_reload}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -192],
                        GRAYOUT: [-0, -192]
                    },
                    DISABLED : false,
                    ONCLICK: function(e) {
                        O_PARENT.grid.reload();
                    }
                }
            ]
        },
        ajax_account_delete: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/member/account_delete',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){

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
        ajax_account_forbidden: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/member/account_forbidden',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){

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
        ajax_payment_pass: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/fortune/payment_vaildate',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){

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
        ajax_cancel_pass: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/fortune/cancel',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){

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
        ajax_mt_pass: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/fortune/mt',
                dataType: 'json',
                type: 'POST',
                data: {
                    status: status,
                    GUID:GUID
                },
                success: function(r) {
                    if(r.error_code == 0){

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
        
        delete_dialog: function(){
            //Delete function
            $( "#delete_dialog" ).dialog({
                autoOpen: false,
                width: 400,
                buttons: [
                    {
                        text: "{button_close}",
                        click: function() {  
                            $("#delete_dialog").parent().append('<div id="delete_dialog_loading" style="position: absolute;top: 0;width: 100%;height: 100%;"><img src="/_images/bar-loading.gif" style="  padding-bottom: 1em;padding-left: 1em;bottom: 0;position: absolute;"/></div>');
                            //$('<img src="/_images/ajax-loader.gif" style=""/>').insertBefore("#delete_dialog");
                            $('#myGrid').trendGrid('getSelectedInfo', function(r){
                                var delete_GUID = r.map(function(elem){return "'"+elem.GUID+"'";}).join(",");
                                console.log($(this));
                                var callback = function(){
                                    $( "#delete_dialog" ).dialog( "close" );
                                };
                                O_PARENT.menu.ajax_delete_process(delete_GUID,callback);
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
                url: '/admin/members/delete_members_json',
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
                    CLIENT_MENU.menu[3].DISABLED = false;
                    CLIENT_MENU.menu[4].DISABLED = false;
                    CLIENT_MENU.menu[5].DISABLED = false;
                    CLIENT_MENU.menu[6].DISABLED = false;
                    CLIENT_MENU.menu[7].DISABLED = false;

                    //PaymentStatus 
                    if(r[0].PaymentStatus > 0){
                        CLIENT_MENU.menu[1].DISABLED = true;
                        CLIENT_MENU.menu[2].DISABLED = true;
                        CLIENT_MENU.menu[3].DISABLED = false;
                    }else{
                        CLIENT_MENU.menu[1].DISABLED = false;
                        CLIENT_MENU.menu[2].DISABLED = false;
                        CLIENT_MENU.menu[3].DISABLED = true;
                    }
                    //ST
                    if(r[0].ST == 0){
                        CLIENT_MENU.menu[4].DISABLED = false;
                        CLIENT_MENU.menu[5].DISABLED = true;
                    }else{
                        CLIENT_MENU.menu[4].DISABLED = true;
                        CLIENT_MENU.menu[5].DISABLED = false;
                    }
                    //MT
                    if(r[0].MT == 0){
                        CLIENT_MENU.menu[6].DISABLED = false;
                        CLIENT_MENU.menu[7].DISABLED = true;
                    }else{
                        CLIENT_MENU.menu[6].DISABLED = true;
                        CLIENT_MENU.menu[7].DISABLED = false;
                    }

                    $myMenu.contextMenu('reload', CLIENT_MENU);

                }else{
                    CLIENT_MENU.menu[0].DISABLED = true;
                    CLIENT_MENU.menu[1].DISABLED = true;
                    CLIENT_MENU.menu[2].DISABLED = true;
                    CLIENT_MENU.menu[3].DISABLED = true;
                    CLIENT_MENU.menu[4].DISABLED = true;
                    CLIENT_MENU.menu[5].DISABLED = true;
                    CLIENT_MENU.menu[6].DISABLED = true;
                    CLIENT_MENU.menu[7].DISABLED = true;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }
            });
        },
        init : function(){
            this.$myMenu.contextMenu(this.CLIENT_MENU);
            this.delete_dialog();
        }
    },
    grid : {
        $myGrid: $('#myGrid'),
        data : {grid_data}, // PHP Parse data
        GUID_list: {GUID_list},
        post_data:{
            top:0,
            bottom:37,
            PAYMENT_STATUS: '0,1,2',
            ST: '0,1',
            MT: '0,1',
            SORT_COLUMN_ID: 'FortuneID',
            ORDER_METHOD: 'ASC'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "FortuneID",
                        name: '{grid_column_FortuneID}',
                        width: 55,
                        sortAsc: true
                    },

                    {
                        id: "Nickname",
                        name: '{grid_fortune_column_Nickname}',
                        width: 155,
                        sortAsc: true
                    },
                    
                    {
                        id: "Email",
                        name: '{grid_fortune_column_Email}',
                        width: 110,
                        sortAsc: true
                    },
                    {
                        id: "Role",
                        name: '{grid_fortune_column_Role}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "Lunar",
                        name: '{grid_column_Lunar}',
                        width: 180,
                        sortAsc: true
                    },
                    {
                        id: "Birthday",
                        name: '{grid_column_Birth}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "FortuneStatus",
                        name: '{grid_column_FortuneStatus}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "PaymentStatus",
                        name: '{grid_column_PaymentStatus}',
                        width: 90,
                        sortAsc: true
                    },
                    {
                        id: "DatePayment",
                        name: '{grid_column_DatePayment}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "NotifyPaymentStatus",
                        name: '{grid_column_NotifyPaymentStatus}',
                        width: 95,
                        sortAsc: true
                    },
                    {
                        id: "DateNotifyPayment",
                        name: '{grid_column_DateNotifyPayment}',
                        width: 130,
                        sortAsc: true
                    },
                    

                    {
                        id: "ST",
                        name: '{grid_column_ST}',
                        width: 65,
                        sortAsc: true
                    },
                    {
                        id: "DateST",
                        name: '{grid_column_DateST}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "MT",
                        name: '{grid_column_MT}',
                        width: 65,
                        sortAsc: true
                    },
                    {
                        id: "DateMT",
                        name: '{grid_column_DateMT}',
                        width: 130,
                        sortAsc: true
                    },
                    
                    {
                        id: "LastLoginTime",
                        name: '{grid_column_LastLoginTime}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "DateModify",
                        name: '{grid_column_DateModify}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "DateCreate",
                        name: '{grid_column_DateCreate}',
                        width: 130,
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
                cellsFormat: {
                    FortuneID : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    Validated: function(o){
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '{account_mail_validate_pending_s}';
                            break;
                            case 1:
                                return '{account_mail_validate_pass_s}';
                            break;
                        }
                    },
                    PaymentStatus: function(o){
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '{fortune_payment_pending}';
                            break;
                            case 1:
                                return '{fortune_payment_vip}';
                            break;
                            case 2:
                                return '{fortune_payment_already}';
                            break;
                        }
                    },
                    FortuneStatus: function(o){
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '{fortune_future_pending}';
                            break;
                            case 1:
                                return '{fortune_future_analysing}';
                            break;
                            case 2:
                                return '{fortune_future_already}';
                            break;
                        }
                    },
                    NotifyPaymentStatus: function(o){
                        o.$cell.css('text-align','center');
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '';
                            break;
                            case 1:
                                return 'Y';
                            break;
                        }
                    },
                    ST: function(o){
                        o.$cell.css('text-align','center');
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '';
                            break;
                            case 1:
                                return 'Y';
                            break;
                        }
                    },
                    MT: function(o){
                        o.$cell.css('text-align','center');
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '';
                            break;
                            case 1:
                                return 'Y';
                            break;
                        }
                    }
                }
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
                url: '/admin/fortune/retrieve_list',
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
                url: '/admin/fortune/retrieve_list',
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
        $searchBtn: $('#searchBtn'),
        bind_search_btn: function(){
            this.$searchBtn.bind('click',function(){
                var search_txt = $.trim($('#emailNameText').val());
                $('#emailNameText').val(search_txt);
                if(  search_txt == '' ){
                    alert("{members_search_alert_msg}");
                }else{
                    var searchData = {
                        SEARCH_TXT : search_txt,
                        RANK_BETWEEN_FROM: 0,
                        RANK_BETWEEN_TO: 255,
                        REGISTER_TYPE : "1,2,3"
                    };
                    O_PARENT.grid.searchData = searchData;
                    var searchResultNode = {
                                    NAME : '{members_tree_search_result}',
                                    GUID : 'search-result'
                                };
                    $('#myTree').trendTree('renderSearchResultNode' , {searchResult:{data:searchResultNode}});                        
                }
            });
        },
        init: function(){
            this.bind_search_btn();
        }
    },
    firstTriggerSelect : true,
    init : function(){
        O_PARENT.menu.init();
        O_PARENT.grid.init();
        
        O_PARENT.tree.init('{GUID}');
        O_PARENT.firstTriggerSelect = false;
        O_PARENT.search.init();
    }
};
 
$(function() {
    O_PARENT.init();
});
</script>
