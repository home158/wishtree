<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.drag.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.drop.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/jQuery/jquery.event.scroll.start-stop.js"></script>
<script type="text/javascript" src="/_js/commonUI/lib/json/json.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendGrid/jquery.trendGrid.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendTree/jquery.trendTree.js"></script>
<script type="text/javascript" src="/_js/commonUI/plugin/trendContextMenu/jquery.trendContextMenu.js"></script>
<script type="text/javascript" src="/_js/jquery.popupwindow.js"></script>
<script type="text/javascript" src="/_js/is-loading/jquery.isloading.js"></script>
<script type="text/javascript" src="/_js/ekko-lightbox.min.js"></script>


<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendGrid/trendGrid.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendContextMenu/trendContextMenu.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendContextMenu/trendContextMenu.button.css">
<link rel="stylesheet" type="text/css" href="/_js/commonUI/plugin/trendTree/trendTree.css">
<link rel="stylesheet" type="text/css" href="/_css/ekko-lightbox.min.css">

<div class="pand-console">
    <div class="pane-header">
        <h1 id="myHeader" class="trend-header">{menu_admin_wish}</h1>
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

<script type="text/javascript">
var O_PARENT = {
    tree : {
        CURRENT_GUID: '{GUID}',
        $myTree : $('#myTree'),
        root : {
            NAME: "{photo_view_all}",
            GUID: '00000000-0000-0000-0000-000000000000',
            REVIEW_STATUS: '0,1,2',
            DELETE_STATUS : '0,1',
            MOTHBALL_STATUS : '0,1',
            EXPIRE: '0',
            ICON:'/_images/friends-16.png',
            CHILD: [
                        {
                            NAME:'{mywish_wish_pending}',
                            GUID: '3359a0b5-1e32-430e-8d21-e3728a619387',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '0',
                            DELETE_STATUS : '0',
                            MOTHBALL_STATUS : '0',
                            EXPIRE: '0'
                        },
                        {
                            NAME:'{mywish_wish_online}',
                            GUID: '5de4b16d-6acc-4264-8312-8c5ebbe94864',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '2',
                            DELETE_STATUS : '0',
                            MOTHBALL_STATUS : '0',
                            EXPIRE: '0'
                        },
                        {
                            NAME:'{mywish_wish_reject}',
                            GUID: '6a928d1f-eb98-4d78-a792-f8b35b03e166',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '1',
                            DELETE_STATUS : '0',
                            MOTHBALL_STATUS : '0',
                            EXPIRE: '0'
                        },
                        {
                            NAME:'{mywish_wish_delete}',
                            GUID: '29A067E7-F98B-4FDD-AAB5-7A87FB439838',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '0,1,2',
                            DELETE_STATUS : '1',
                            MOTHBALL_STATUS : '0',
                            EXPIRE: '0'
                        },
                        {
                            NAME:'{mywish_wish_mothball}',
                            GUID: 'B9F61346-AC2F-4F46-9594-71F87F3DE7BA',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '0,1,2',
                            DELETE_STATUS : '0,1',
                            MOTHBALL_STATUS : '1',
                            EXPIRE: '0'
                        },
                        {
                            NAME:'{mywish_wish_expire}',
                            GUID: 'B9F61346-AC2F-4F46-9594-71F87F3DE7BA',
                            HAS_EXPAND_COLLAPSE_ICON : false,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '2',
                            DELETE_STATUS : '0',
                            MOTHBALL_STATUS : '0',
                            EXPIRE: '1'
                        }
                    ]
        },
        getSubDomain: function(GUID){

        },
        init: function(GUID){
            this.$myTree.trendTree(
                {
                    getSubDomain: this.getSubDomain,
                    data: this.root,
                    expand: function(ui) {
                        //$('#myTree').trendTree('renderNode', ui, this.getSubDomain(ui.data.GUID));
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
                    TEXT: '{contextmenu_show_photo}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -96],
                        GRAYOUT: [-0, -120]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelectedInfo', function(r){
        

                        });
                    }
                },
                {
                    TEXT: '{contextmenu_profile_review_pass}',
                    GROUP: 0,
                    DISABLED : true,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -144],
                        GRAYOUT: [-0, -168]
                    },
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_wish_review_pass(GUID,r[0] , 2);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_profile_review_no_pass}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -48],
                        GRAYOUT: [-0, -72]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_wish_review_pass(GUID,r[0] , 1);
                        });
                    }
                },
                {
                    TEXT: '{contextmenu_rollback_profile_review_process}',
                    GROUP: 0,
                    BACKGROUND_POSITION: {
                        DEFAULT: [-0, -0],
                        GRAYOUT: [-0, -24]
                    },
                    DISABLED : true,
                    ONCLICK: function(e) {
                        $('#myGrid').trendGrid('getSelected', function(r){
                            var GUID = O_PARENT.grid.GUID_list[r];
                            O_PARENT.menu.ajax_wish_review_pass(GUID,r[0] , 0);
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
        ajax_wish_review_pass: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/wish/review',
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

                    //WishReviewStatus 
                    if(r[0].WishReviewStatus == 0){
                        CLIENT_MENU.menu[3].DISABLED = true;
                    }else{
                        CLIENT_MENU.menu[1].DISABLED = true;
                        CLIENT_MENU.menu[2].DISABLED = true;
                        CLIENT_MENU.menu[3].DISABLED = false;
                    }

                    $myMenu.contextMenu('reload', CLIENT_MENU);

                }else{
                    CLIENT_MENU.menu[0].DISABLED = true;
                    CLIENT_MENU.menu[1].DISABLED = true;
                    CLIENT_MENU.menu[2].DISABLED = true;
                    CLIENT_MENU.menu[3].DISABLED = true;
                    $myMenu.contextMenu('reload', CLIENT_MENU);
                }
            });
        },
        init : function(){
            this.$myMenu.contextMenu(this.CLIENT_MENU);
        }
    },
    grid : {
        $myGrid: $('#myGrid'),
        data : {grid_data}, // PHP Parse data
        GUID_list: {GUID_list},
        post_data:{
            top:0,
            bottom:37,
            SORT_COLUMN_ID: 'WishID',
            ORDER_METHOD: 'ASC',
            REVIEW_STATUS: '0,1,2',
            DELETE_STATUS : '0,1',
            MOTHBALL_STATUS : '0,1',
            EXPIRE: '0'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "WishID",
                        name: '{grid_column_WishID}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "Nickname",
                        name: '{grid_column_Nickname}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "Email",
                        name: '{grid_column_Email}',
                        width: 200,
                        sortAsc: true
                    },
                    
                    {
                        id: "Role",
                        name: '{grid_column_Role}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "WishTitle",
                        name: '{grid_column_WishTitle}',
                        width: 100,
                        sortAsc: true
                    },
                    {
                        id: "WishContent",
                        name: '{grid_column_WishContent}',
                        width: 100,
                        sortAsc: true
                    },

                    
                    {
                        id: "WishReviewStatus",
                        name: '{grid_column_WishReviewStatus}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "WishReviewDate",
                        name: '{grid_column_WishReviewDate}',
                        width: 130,
                        sortAsc: true
                    },
                    
                    {
                        id: "DeleteStatus",
                        name: '{grid_column_DeleteStatus}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "DeleteDate",
                        name: '{grid_column_DeleteDate}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "MothballStatus",
                        name: '{grid_column_MothballStatus}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "MothballDate",
                        name: '{grid_column_MothballDate}',
                        width: 130,
                        sortAsc: true
                    },
                    
                    {
                        id: "DateExpire",
                        name: '{grid_column_DateExpire}',
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
                    WishID : function(o){
                        o.$cell.css('text-align','center');
                        return o.text;
                    },
                    Role: function(o){
                        switch(o.text){
                            case 'male':
                                return '{role_male}';
                            break;
                            case 'female':
                                return '{role_female}';
                            break;
                        }
                    },
                    WishReviewStatus: function(o){
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '{mywish_wish_pending}';
                            break;
                            case 1:
                                return '{mywish_wish_reject}';
                            break;
                            case 2:
                                return '{mywish_wish_pass}';
                            break;
                        }
                    },
                    DeleteStatus: function(o){
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
                    MothballStatus: function(o){
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
                url: '/admin/wish/retrieve_list',
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
                url: '/admin/wish/retrieve_list',
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
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    }); 
});
</script>
