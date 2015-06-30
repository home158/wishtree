<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drag.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.drop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/jQuery/jquery.event.scroll.start-stop.js"></script>
<script type="text/javascript" src="/_script/commonUI/lib/json/json.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendGrid/jquery.trendGrid.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendTree/jquery.trendTree.js"></script>
<script type="text/javascript" src="/_script/commonUI/plugin/trendContextMenu/jquery.trendContextMenu.js"></script>
<script type="text/javascript" src="/_script/jquery.popupwindow.js"></script>


<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendGrid/trendGrid.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendContextMenu/trendContextMenu.button.css">
<link rel="stylesheet" type="text/css" href="/_script/commonUI/plugin/trendTree/trendTree.css">


<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_procucts}</h1>
    </div>
    <div class="pane-search">
        {products_search_account}
        <input id="emailNameText" placeholder="{products_search_hint}" name="email" type="text" value=""/>&nbsp;&nbsp;<input id="searchBtn" type="submit" class="btn-calm" value="&nbsp;&nbsp;{products_search_btn}&nbsp;&nbsp;"/>
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
        <div id="myrtatus" class="trend-status">{products_total_rows}</div><!-- PHP Parse data-->
    </div>
</div>
<!-- ui-dialog -->
<div id="delete_dialog" title="{products_popup_delete_title}">
    <p>{products_popup_delete_msg}</p>
</div>
<script type="text/javascript">
var O_PARENT = {
    tree : {
        CURRENT_GUID: '{Category}',
        $myTree : $('#myTree'),
        root : {
            NAME: "{products_view_all}",
            GUID: '00000000-0000-0000-0000-000000000000',
            CATEGORY: '00000000-0000-0000-0000-000000000000',
            IsOnShelves : "0,1",
            ICON:'/_images/sealed-wood-box-16.png',
            CHILD: [
                        {
                            NAME:'{593E7A26-6822-4DD7-ACDE-D6FAF5259417}',
                            GUID: '593E7A26-6822-4DD7-ACDE-D6FAF5259417',
                            CATEGORY: '593E7A26-6822-4DD7-ACDE-D6FAF5259417',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{923B5DD9-F43B-49B6-A9E9-49823BC36B0A}',
                            GUID: '923B5DD9-F43B-49B6-A9E9-49823BC36B0A',
                            CATEGORY: '923B5DD9-F43B-49B6-A9E9-49823BC36B0A',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{09C449E9-8D6D-40BF-95D3-12A488A3FE82}',
                            GUID: '09C449E9-8D6D-40BF-95D3-12A488A3FE82',
                            CATEGORY: '09C449E9-8D6D-40BF-95D3-12A488A3FE82',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8}',
                            GUID: 'CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8',
                            CATEGORY: 'CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{39258F85-E582-4C79-84CE-406FD1ECB49C}',
                            GUID: '39258F85-E582-4C79-84CE-406FD1ECB49C',
                            CATEGORY: '39258F85-E582-4C79-84CE-406FD1ECB49C',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{7823C577-4A0C-452F-9ACF-7CFC7A555CB2}',
                            GUID: '7823C577-4A0C-452F-9ACF-7CFC7A555CB2',
                            CATEGORY: '7823C577-4A0C-452F-9ACF-7CFC7A555CB2',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{ECBA4E56-7E73-431E-9851-8507327027F4}',
                            GUID: 'ECBA4E56-7E73-431E-9851-8507327027F4',
                            CATEGORY: 'ECBA4E56-7E73-431E-9851-8507327027F4',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{ACC8B2B5-612F-445C-A342-BDE3B22E95E0}',
                            GUID: 'ACC8B2B5-612F-445C-A342-BDE3B22E95E0',
                            CATEGORY: 'ACC8B2B5-612F-445C-A342-BDE3B22E95E0',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{CB3FB523-7CE9-401E-9EC9-1C51BB2E570A}',
                            GUID: 'CB3FB523-7CE9-401E-9EC9-1C51BB2E570A',
                            CATEGORY: 'CB3FB523-7CE9-401E-9EC9-1C51BB2E570A',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        },
                        {
                            NAME:'{D73162C2-ADA4-432F-923B-415FE39A7888}',
                            GUID: 'D73162C2-ADA4-432F-923B-415FE39A7888',
                            CATEGORY: 'D73162C2-ADA4-432F-923B-415FE39A7888',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/sealed-wood-box-16.png',
                            IsOnShelves : "0,1"
                        }
                    ]
        },
        getSubDomain: function(CATEGORY){
            var d1 = {
                CHILD:[
                    {
                        NAME:'{product_on_shelves}',
                        GUID: O_PARENT.tree.createGUID(),
                        CATEGORY: CATEGORY,
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        ICON:'/_images/sealed-wood-box-16.png',
                        IsOnShelves : "1"
                    },
                    {
                        NAME:'{product_off_shelves}',
                        GUID: O_PARENT.tree.createGUID(),
                        CATEGORY: CATEGORY,
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        ICON:'/_images/sealed-wood-box-16.png',
                        IsOnShelves : "0"
                    }
                ]
            };
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
            /*
                {
                    TEXT: '{contextmenu_details}',
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
                            $.popupWindow('/admin/members/details/'+GUID, { 
                                height: 600, 
                                width: 800,
                                createNew: true,
                                onUnload: function(){
                                }
                            });
                        });
                    }
                },
                */
                {
                    TEXT: '{contextmenu_create}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -288],
                        GRAYOUT: [-0, -312]
                    },
                    ONCLICK: function(e) {
                        $.popupWindow('/admin/products/create', { 
                            height: 700, 
                            width: 800,
                            createNew: false,
                            resizable:   true,
                            scrollbars:  true,
                            onUnload: function(){
                                
                            }
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_edit}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -48],
                        GRAYOUT: [-0, -72]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
                            var GUID = r.map(function(elem){return elem.GUID;}).join(",");
                            $.popupWindow('/admin/products/edit/'+GUID, { 
                                height: 700, 
                                width: 800,
                                createNew: false,
                                resizable:   true,
                                scrollbars:  true,
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
                        GRAYOUT: [-0, -360]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
    
                        $( "#delete_dialog" ).dialog( "open" );
                        event.preventDefault();
                    }
                },
                {
                    TEXT: '{contextmenu_arrvival}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -240],
                        GRAYOUT: [-0, -264]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $.popupWindow('/admin/products/transition_arrival', { 
                            height: 700, 
                            width: 800,
                            createNew: false,
                            onUnload: function(){
                                
                            }
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
                        text: "{button_close}",
                        click: function() {  
                            $("#delete_dialog").parent().append('<div id="delete_dialog_loading" style="position: absolute;top: 0;width: 100%;height: 100%;"><img src="/_images/bar-loading.gif" style="  padding-bottom: 1em;padding-left: 1em;bottom: 0;position: absolute;"/></div>');
                            //$('<img src="/_images/ajax-loader.gif" style=""/>').insertBefore("#delete_dialog");
                            $('#myGrid').trendGrid('getSelectedInfo', function(r){
                                var delete_GUID = r.map(function(elem){return "'"+elem.GUID+"'";}).join(",");
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

                //Edit button
                if(r.length == 1){
                    CLIENT_MENU.menu[1].DISABLED = false;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }else{
                    CLIENT_MENU.menu[1].DISABLED = true;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }
                //Delete button
                //Arrivals
                if(r.length >= 1){
                    CLIENT_MENU.menu[2].DISABLED = false;
                    CLIENT_MENU.menu[3].DISABLED = false;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }else{
                    CLIENT_MENU.menu[2].DISABLED = true;
                    CLIENT_MENU.menu[3].DISABLED = true;
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
        post_data:{
            top:0,
            bottom:37,
            IsOnShelves: "0,1",
            SORT_COLUMN_ID: 'ProductID',
            ORDER_METHOD: 'ASC'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "ProductID",
                        name: '{gird_column_ProductID}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "Title",
                        name: '{gird_column_ProductTitle}',
                        width: 85,
                        sortAsc: true
                    },
                    {
                        id: "GUID",
                        name: 'GUID',
                        width: 140,
                        sortAsc: true
                    },
                    /*
                    {
                        id: "ShortDesc",
                        name: '{gird_column_ShortDesc}',
                        width: 115,
                        sortAsc: true
                    },
                    */
                    {
                        id: "PriceMSRP",
                        name: '{gird_column_PriceMSRP}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "PriceSpecial",
                        name: '{gird_column_PriceSpecial}',
                        width: 180,
                        sortAsc: true
                    },
                    {
                        id: "Stock",
                        name: '{gird_column_Stock}',
                        width: 60,
                        sortAsc: true
                    },
                    {
                        id: "Soldout",
                        name: '{gird_column_Soldout}',
                        width: 180,
                        sortAsc: true
                    },
                    {
                        id: "Hits",
                        name: '{gird_column_Hits}',
                        width: 180,
                        sortAsc: true
                    },
                    {
                        id: "IsOnShelves",
                        name: '{gird_column_IsOnShelves}',
                        width: 180,
                        sortAsc: true
                    },
                    {
                        id: "OnShelfTime",
                        name: '{gird_column_OnShelfTime}',
                        width: 155,
                        sortAsc: true
                    },
                    /*
                    {
                        id: "OffShelfTime",
                        name: '{gird_column_OffShelfTime}',
                        width: 155,
                        sortAsc: true
                    },
                    */
                    {
                        id: "LastViewTime",
                        name: '{gird_column_LastViewTime}',
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
                    dragColumnId : 'ProductID',
                    stop: O_PARENT.menu.toggle_contextmenu
                },
                cellsFormat: {
                    ProductID : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    PriceMSRP: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    PriceSpecial: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    Soldout: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    Hits: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    Stock: function(o){
                        o.$cell.css('text-align','right');
                        return o.text;
                    },
                    IsOnShelves : function(o){
                        switch(o.text) {
                            case 0:
                                
                                return "{product_off_shelves}";
                                break;
                            case 1:
                                return "{product_on_shelves}";
                                break;
                            default:
                                return o.text;
                                break;
                        }                     
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
                url: '/admin/products/retrieve_list',
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
                url: '/admin/products/retrieve_list',
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
                    alert("{product_search_alert_msg}");
                }else{
                    var searchData = {
                        SEARCH_TXT : search_txt,
                        IsOnShelves : "1"
                    };
                    O_PARENT.grid.searchData = searchData;
                    var searchResultNode = {
                                    NAME : '{products_tree_search_result}',
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
        
        O_PARENT.tree.init('{Category}');
        O_PARENT.firstTriggerSelect = false;
        O_PARENT.search.init();
    }
};
 
$(function() {
    O_PARENT.init();
});
</script>
