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
        <h1 id="myHeader" class="trend-header">{menu_admin_photo}</h1>
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
            IS_PRIVATE: '0,1',
            ICON:'/_images/friends-16.png',
            CHILD: [
                        {
                            NAME:'{photo_review_pending}',
                            GUID: '3359a0b5-1e32-430e-8d21-e3728a619387',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '0',
                            IS_PRIVATE: '0,1'
                        },
                        {
                            NAME:'{photo_review_pass}',
                            GUID: '5de4b16d-6acc-4264-8312-8c5ebbe94864',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '2',
                            IS_PRIVATE: '0,1'
                        },
                        {
                            NAME:'{photo_review_reject}',
                            GUID: '6a928d1f-eb98-4d78-a792-f8b35b03e166',
                            HAS_EXPAND_COLLAPSE_ICON : true,
                            ICON:'/_images/people-16.png',
                            REVIEW_STATUS: '1',
                            IS_PRIVATE: '0,1'
                        }
                    ]
        },
        getSubDomain: function(GUID){
            console.log(GUID);
            switch(GUID){
                case '3359a0b5-1e32-430e-8d21-e3728a619387':
                    var REVIEW_STATUS = '0';
                break;
                case '5de4b16d-6acc-4264-8312-8c5ebbe94864':
                    var REVIEW_STATUS = '2';
                break;
                case '6a928d1f-eb98-4d78-a792-f8b35b03e166':
                    var REVIEW_STATUS = '1';
                break;
            }
            var d1 = {
                CHILD:[
                    {
                        NAME:'{photo_public}',
                        GUID: '1F12F18F-60B8-4734-A2EF-B1AB138EA139',
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        ICON:'/_images/people-16.png',
                        REVIEW_STATUS : REVIEW_STATUS,
                        IS_PRIVATE: '0'
                    },
                    {
                        NAME:'{photo_private}',
                        GUID: 'C3142A73-3D24-495A-B4C2-1EF6CA54CB9C',
                        HAS_EXPAND_COLLAPSE_ICON : false,
                        ICON:'/_images/people-16.png',
                        REVIEW_STATUS : REVIEW_STATUS,
                        IS_PRIVATE: '1'
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
                        $('#myTree').trendTree('renderNode', ui, this.getSubDomain(ui.data.GUID));
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
                            O_PARENT.menu.ajax_photo_review_pass(GUID,r[0] , 2);
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
                            O_PARENT.menu.ajax_photo_review_pass(GUID,r[0] , 1);
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
                            O_PARENT.menu.ajax_photo_review_pass(GUID,r[0] , 0);
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
        ajax_photo_review_pass: function(GUID , top , status){
            $.isLoading({
                    text: "Loading" ,
                    position:   "overlay"
            });

            $.ajax({
                //must to set synchronous, otherwise your need good design concept
                url: '/admin/photo/review',
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

                    //ProfileReviewStatus 
                    if(r[0].ReviewStatus == 0){
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
            SORT_COLUMN_ID: 'PhotoID',
            ORDER_METHOD: 'ASC',
            REVIEW_STATUS: '0,1,2',
            IS_PRIVATE: '0,1'
        },
        init: function(){
            this.$myGrid.trendGrid({
                columns: [
                    {
                        id: "MessageID",
                        name: '{grid_column_MessageID}',
                        width: 55,
                        sortAsc: true
                    },
                    {
                        id: "FromUserNickname",
                        name: '{grid_column_FromUserNickname}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "FromUserEmail",
                        name: '{grid_column_FromUserEmail}',
                        width: 200,
                        sortAsc: true
                    },
                    
                    {
                        id: "FromUserRole",
                        name: '{grid_column_FromUserRole}',
                        width: 80,
                        sortAsc: true
                    },
                    {
                        id: "MessageContent",
                        name: '{grid_column_MessageContent}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "MessageReviewStatus",
                        name: '{grid_column_ReviewStatus}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "MessageReviewDate",
                        name: '{grid_column_ReviewDate}',
                        width: 130,
                        sortAsc: true
                    },
                    {
                        id: "TargetUserNickname",
                        name: '{grid_column_TargetUserNickname}',
                        width: 155,
                        sortAsc: true
                    },
                    {
                        id: "TargetUserEmail",
                        name: '{grid_column_TargetUserEmail}',
                        width: 200,
                        sortAsc: true
                    },
                    {
                        id: "TargetUserRole",
                        name: '{grid_column_TargetUserRole}',
                        width: 80,
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
                    MessageID : function(o){
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
                    MessageReviewStatus: function(o){
                        switch(parseInt(o.text,10)){
                            case 0:
                                return '{photo_review_pending}';
                            break;
                            case 1:
                                return '{photo_review_reject}';
                            break;
                            case 2:
                                return '{photo_review_pass}';
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
                url: '/admin/photo/retrieve_list',
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
                url: '/admin/photo/retrieve_list',
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
