/*
 *
 * Depends:
 *      jquery-1.8.0.js
 *      jquery.event.drag-2.2.js
 *      jquery.event.drop-2.2.js
 *      json2.js
 *      scroll-startstop.events.jquery.js
 *      trend-tree.css
 * Example:
 *
 * Copyright (c) 1989-2013 Trend Micro Incorporated, All Rights Reserved
*/
(function($) {
    var PLUGIN_NAME = "trendTree";
    $.fn[PLUGIN_NAME] = function(methodOrOptions) {
        if (typeof methodOrOptions == "string") {
            var publicMethods = $.fn[PLUGIN_NAME].publicMethods[methodOrOptions];
            if (publicMethods) {
                var args = Array.prototype.slice.call(arguments, 1);
                return this.each(function() {
                    publicMethods(this, args);
                });
            } else {
                $.error("Method '" + methodOrOptions + "' doesn't exist for " + PLUGIN_NAME + " plugin.");
                return true;
            }
        }
        methodOrOptions = methodOrOptions || {};
        return this.each(function() {
            var Internal = $.data(this, PLUGIN_NAME);
            if (Internal) {
                $.extend(true , {} , Internal.options, methodOrOptions);
            } else {
                var o = {
                    options: $.extend(true, {}, $.fn[PLUGIN_NAME].defaults, methodOrOptions)
                };
                var p = $.extend(true , {} , $.fn[PLUGIN_NAME].base , o);
                $.data(this, PLUGIN_NAME, p );
            }
            $.fn[PLUGIN_NAME].internalMethods.init(this);
        });
    };
    $.fn[PLUGIN_NAME].internalMethods = {
        /**
         *  Initialises the plugin.
         *
        **/
        init : function(elem){
            var that = this;
                base = that.getData(elem),
                base.$elem = $(elem),
                base.elemId = base.$elem.attr('id');
            /**********************************************/
            if(base.options.elemHeight != null ){
                base.$elem.height(base.options.elemHeight);
            }
            this.ajaxLoading(elem);
            this.preventContextMenu(elem);
            this.prepareElements(elem);
            this.setupDefaultProperty(elem);
            base.$contentScrollerWrap.bind('scroll', {
                elem : elem,
                that : this
            }, this.contentScrollingHandle);
            base.$contentScrollerWrap.bind('scrollstop', {
                elem : elem,
                that : this
            }, this.contentScrollStopHandle);
            this.renderContent(elem);
            this.getMaxGridWidth(elem);
            this.ajaxLoadingComplete(elem);
        },
        /**
         *  Returns the data for relevant for this plugin
         *
        **/
        getData : function(elem){
            return $.data(elem, PLUGIN_NAME) || {};
        },
        /**
         *
         *
        **/
        preventContextMenu : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.$elem.unbind('contextmenu').bind('contextmenu', function(e) {
                e.preventDefault(e);
                return false;
            });
        },
        prepareElements : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            // TODO: Set default data plugin variables.
            //insert content
            base.$contentScrollerWrap = $('<div />').addClass("contentScrollerWrap").appendTo(base.$elem);
            base.$content = $('<div />').addClass("content").appendTo(base.$contentScrollerWrap);

            //Disable text selection
            this.disableSelection(elem , [base.$header,base.$content,base.$contentScrollerWrap]);
        },
        /**
         *
         *
        **/
        setupDefaultProperty : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            //setup default value
            base.perPageRows = Math.ceil(this.getContentHeight(elem)/base.options.rowHeight);
            this.setupDefaultRange(elem);

            if(base.options.setRootHighLight === true){
                base.highLightGUID = base.options.rootGUID;
            }
            this.createGridData(elem);
            base.expandGUID = ['00000000-0000-0000-0000-000000000000'];
        },
        /**
         *  Returns the height of content
         *
        **/
        getContentHeight : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            return parseFloat($.css(base.$elem[0], "height", true));
        },
        /**
         *  Setup rows range
         *
        **/
        setupDefaultRange : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            //reset renderRange
            if(base.options.scrollRowsBuffer == null){
                base.options.scrollRowsBuffer = Math.ceil(base.perPageRows/2);
            }
            base.renderRange = {
                top : 0,
                bottom:base.perPageRows + base.options.scrollRowsBuffer
            };
        },
        /**
         *
         *
        **/
        createGridData : function(elem){
            var that = this,
                base = that.getData(elem),
                root = base.options.data,
                GridData,
                onCount = 0,
                offCount = 0;
            /**********************************************/
            base.GridData = new Array();
            GridData = base.GridData;

            GridData[0] = $.extend(true,{},{
                //STATUS : 0,
                NAME : root.NAME,
                GUID : root.GUID,
                ICON : root.ICON,
                DEEP : 0,
                GRID_DATA : [],
                CHILD: root.CHILD,
                CHILD_COUNT : root.CHILD.length,
                IS_EXPAND : true,
                NODE_DATA:root
            });
            $.each(root.CHILD , function(i,o){
                var n = $.extend({},base.defaultChild,{
                    NAME:o.NAME,
                    GUID:o.GUID,
                    ICON : o.ICON,
                    DEEP:1,
                    PARENT : base.options.rootGUID,
                    HAS_EXPAND_COLLAPSE_ICON:o.HAS_EXPAND_COLLAPSE_ICON,
                    STATUS : o.STATUS || 0,
                    NODE_DATA:o
                });
                //$.extend(o,n);
                GridData.push(n);
                base.nodeData[o.GUID] = n;
                GridData[0].GRID_DATA.push(n);
                if(n.STATUS == 0)offCount++;
                if(n.STATUS == 2)onCount++;
            });
            GridData[0].STATUS = 1;
            if(onCount == root.CHILD.length)  GridData[0].STATUS = 2;
            if(offCount == root.CHILD.length) GridData[0].STATUS = 0;

            base.options.data = $.extend({},GridData[0]);
            base.nodeData[base.options.rootGUID] = base.options.data;
        },
        /**
         *
         *
        **/
        removeContent : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/

            base.$content.empty();
        },
        /**
         *
         *
        **/
        renderContent : function(elem){
            var that = this,
                base = that.getData(elem),
                range,
                i ,
                o ,
                GridData = base.GridData;
            /**********************************************/

            base.$content.height(GridData.length*base.options.rowHeight);
            base.contentHeight = this.getContentHeight(elem);
            range = that.getRenderRange(elem);
            if(range.bottom > base.GridData.length){
                range.bottom = base.GridData.length;
            }
            this.createRows(elem);
        },
        /**
         *
         *
        **/
        createRows : function(elem){
            var that = this,
                base = that.getData(elem),
                $img,
                $obj = {
                    icon : {},
                    checkBox : {},
                    text :{}
                };
            /**********************************************/
            function selectRowsHandleMouseDown(e){
                if(e.button != 2) return false;
                var $target = e.data.$nodeDiv;

                if(base.options.fakeContextMenu){
                    $target.addClass(base.options.classUIselectedFake).siblings().removeClass(base.options.classUIselectedFake);
                }
                base.highLightGUIDTmp = base.highLightGUID;
                base.highLightGUID = e.data.o.GUID;

                base.options.onContextMenu(base.highLightGUID);
            }
            var range = base.renderRange,
                GridData = base.GridData,
                o,
                bindContextMenu = function(e){
                    if(e.button === 2){ // right click event
                        $(e.currentTarget).contextMenu( $.extend(true , {} , base.options.contextMenu, e.data)).off(e);
                    }
                },
                topOffset = base.options.isShowRoot === false ? 1 : 0,
                cellsFormatContent;

            if(range.bottom < base.perPageRows){
                range.bottom = base.perPageRows;
            }
            var hasNodeIcon = ($.inArray('icon',base.options.containerNode) != -1);
            for(var i = range.top ; i < range.bottom ; i++){
                if($('> div[node='+i+']' , base.$content).length >0) continue;
                o = GridData[i];

                if(!o) continue;
                var $nodeDiv = $('<div class="node"/>').attr({node:i,GUID:o.GUID}).css({top:(base.options.rowHeight*(i-topOffset))});
                if(base.highLightGUID == o.GUID){
                    $nodeDiv.addClass(base.options.classUIselected)
                }
                var $indent = $('<span/>').addClass('node-indent').appendTo($nodeDiv);
                var $nodeIconsText = $('<span/>').addClass('node-icons-text');
                $obj.text = $('<span/>').addClass('text').text(o.NAME);
                if($.inArray('checkBox',base.options.containerNode) != -1){
                    $obj.checkBox = this.checkBoxForNode(elem,o);
                }
                if(o.GUID == base.options.rootGUID){
                    if(hasNodeIcon){
                        $obj.icon = $('<span/>').addClass('icons').addClass('icons-root').attr('border','0');
                        if(typeof o.ICON != 'undefined'){
                            $obj.icon.css({'background-image': 'url('+o.ICON+')'});
                        }
                    }
                    if( base.options.isShowRoot === false){
                        $nodeDiv.hide();
                    }
                }else{
                    for(var j = 0 ; j < o.DEEP ; j++){
                        $dotLine = $('<span class="dot-line dot-middle"/>').appendTo($indent);
                    }
                    if(o.HAS_EXPAND_COLLAPSE_ICON && o.CHILD_COUNT != 0){
                        if(o.IS_EXPAND){
                            $img = $('<span style="float:left;"/>')
                                .addClass(base.options.classExpandCollapse)
                                .addClass(base.options.classIconExpand)
                                .data('is_expand',true)
                                .appendTo($dotLine);
                        }else{
                            $img = $('<span style="float:left;"/>')
                                .addClass(base.options.classExpandCollapse)
                                .addClass(base.options.classIconCollapse)
                                .data('is_expand',false)
                                .appendTo($dotLine);
                        }
                        this.nodeExpand(elem,o,i,$img);
                    }
                    if(hasNodeIcon){
                        $obj.icon = $('<span/>').addClass('icons').addClass('icons-node').attr('border','0');
                        if(typeof o.ICON != 'undefined'){
                            $obj.icon.css({'background-image': 'url('+o.ICON+')'});
                        }
                        
                    }
                    cellsFormatContent = base.options.cellsFormat($obj.icon,o, $nodeDiv);
                }
                $.each(base.options.containerNode , function(i,o){
                    if(o){
                        $nodeIconsText.append($obj[o]);
                    }
                });

                if( typeof cellsFormatContent != 'undefined' ){
                    $nodeIconsText.append(cellsFormatContent);
                }else{
                    $nodeIconsText.append($obj.text);
                }
                $nodeIconsText.appendTo($nodeDiv);
                $nodeDiv.appendTo(base.$content);
                this.nodeEvent(elem,$nodeDiv,o);

                if(base.options.contextMenu){
                    $nodeDiv.filter(function(){
                        if(base.options.searchResultDisableContextMenu === true){
                            return ($(this).attr('guid') != base.searchResultGUID);
                        }else{
                            return true;
                        }
                    })
                    .on('mousedown', {
                        exclude:[$indent],
                        hideContextMenu: function(){
                            if(base.options.fakeContextMenu){
                                base.$content.children('div.node').each(function(index,node){
                                    node = $(node);
                                    if( node.attr('guid') == base.highLightGUID ){
                                        node.removeClass(base.options.classUIselectedFake);
                                        return false;
                                    }
                                });
                            }

                            base.options.unContextMenu(base.highLightGUID);
                            base.highLightGUID = base.highLightGUIDTmp;
                        }
                    }, bindContextMenu );

                    $nodeDiv.on('mouseup',{$nodeDiv:$nodeDiv,o:o},selectRowsHandleMouseDown)
                }else{
                }
                that.setupNodeWidth(elem, o);
            }
            this.ajaxLoadingComplete(elem,{delay:0});
        },
        /**
         *
         *
        **/
        checkBoxForNode : function(elem,o){
            var that = this,
                base = that.getData(elem),
                $checkBox;
            /**********************************************/
            $checkBox = $('<span/>').addClass('icons').attr('border','0').addClass('icons-checkbox');
            //apply checked status to child
            if(o.PARENT != undefined){
                if(base.nodeData[o.PARENT].STATUS === 2){
                    o.STATUS = 2;
                }
                if(base.nodeData[o.PARENT].STATUS === 0){
                    o.STATUS = 0;
                }

            }
            this.setCheckBoxIcon(elem,$checkBox,o.STATUS);
            //prevent click icons-checkbox
            $checkBox.on('click',{o:o},function(e){
                var $this = $(this);

                if( $this.hasClass('off') ){
                    e.data.o.STATUS = 2;
                    base.nodeData[e.data.o.GUID].STATUS = 2;

                    that.setCheckBoxIcon(elem,$this,2);
                    base.options.onChecked(base.nodeData[e.data.o.GUID]);
                }else{
                    e.data.o.STATUS = 0;
                    base.nodeData[e.data.o.GUID].STATUS = 0;
                    that.setCheckBoxIcon(elem,$this,0);
                    base.options.unChecked(base.nodeData[e.data.o.GUID]);
                }
                that.applyCheckedStatusToChild(elem,e.data.o);
                e.preventDefault(e);
                return false;
            });
            return $checkBox;
        },
        /**
         *
         *
        **/
        applyCheckedStatusToChild : function(elem,o){
            var that = this,
                base = that.getData(elem),
                CHILD_COUNT;
            /**********************************************/
            if(o.GUID == base.options.rootGUID){
                CHILD_COUNT = base.GridData.length-1;
            }else{
                CHILD_COUNT = o.CHILD_COUNT;
            }
            var i = 0 ;
            for(i ; i<base.GridData.length ; i++){
                if(o.GUID == base.GridData[i].GUID){
                    break;
                }
            }
            i+=1;
            if(o.IS_EXPAND === true){
                var end = i+CHILD_COUNT;
                for(i ; i< end ; i++){

                    var $checkBox = $('> div[node='+i+']' , base.$content).find('.icons-checkbox');
                    this.setCheckBoxIcon(elem,$checkBox,o.STATUS);
                    base.GridData[i].STATUS = o.STATUS;
                    base.nodeData[base.GridData[i].GUID].STATUS = o.STATUS;
                }
            }

            if(o.PARENT != undefined){
                this.applyCheckedStatusToParent(elem,o.PARENT);
            }
        },
        /**
        *
        *
        **/
        applyCheckedStatusToParent : function(elem,GUID){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var i = 0 ;
            if(GUID != undefined){
                for(i ; i<base.GridData.length ; i++){
                    if(GUID == base.GridData[i].GUID){
                        break;
                    }
                }
            }

            var $checkBox = $('> div[node='+i+']' , base.$content).find('.icons-checkbox');

            this.setCheckBoxIcon(elem,$checkBox,1);
            base.GridData[i].STATUS = 1;
            base.nodeData[base.GridData[i].GUID].STATUS = 1;

            var STATUS = this.testParentStatus(elem,base.nodeData[GUID].CHILD);
            base.nodeData[base.GridData[i].GUID].STATUS = STATUS;
            base.GridData[i].STATUS = STATUS;
            this.setCheckBoxIcon(elem,$checkBox,STATUS);
            if(GUID != base.options.rootGUID){
                this.applyCheckedStatusToParent(elem,base.nodeData[GUID].PARENT);
            }
        },
        /**
         *
         *
        **/
        testParentStatus : function(elem,CHILD){
            var that = this,
                base = that.getData(elem),
                i = 0,
                offCount = 0,
                halfCount = 0,
                onCount = 0;
            /**********************************************/

            for( i ; i < CHILD.length ; i++){
                if( base.nodeData[CHILD[i].GUID].STATUS == 0){
                    offCount++;
                }
                if( base.nodeData[CHILD[i].GUID].STATUS == 1){
                    halfCount++;
                }
                if( base.nodeData[CHILD[i].GUID].STATUS == 2){
                    onCount++;
                }
            }
            if(offCount == CHILD.length){
                return 0;
            }else if(onCount == CHILD.length){
                return 2;
            }else{
                return 1;
            }
        },
        /**
         *
         *
        **/
        setCheckBoxIcon : function(elem,$checkBox,STATUS){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            $checkBox.removeClass('off').removeClass('on').removeClass('half');
            switch(STATUS){
                case 0 :
                    $checkBox.addClass('off');
					break;
                case 1 :
                    $checkBox.addClass('half');
					break;
                case 2 :
                    $checkBox.addClass('on');
					break;
				default:
					break;
            }
        },
        /**
         *
         *
        **/
        nodeEvent : function(elem,$elem,o){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            $elem.on('mouseover' , function(){
                $(this).addClass(base.options.classUIHover);
            });
            $elem.on('mouseout' , function(){
                $(this).removeClass(base.options.classUIHover);
            });

            $elem.on('click', {$content:base.$content,o:o}, function(e){
                var _this = this;
                $(this).addClass(base.options.classUIselected)
                    .siblings().removeClass(base.options.classUIselected);

                base.highLightGUID = e.data.o.GUID;

                var queueFunc = [
                    function(){
                        var $this = $(this);
                        if($('span.'+base.options.classExpandCollapse , _this).length > 0){
                            $('span.'+base.options.classExpandCollapse , _this).trigger('click',[function(){
                                base.options.selected({base:base,$node:$this,data:o});
                            }]);
                        }else{
                            base.options.selected({base:base,$node:$this,data:o});
                        }
                        setTimeout(function(){
                            $this.dequeue();
                        });
                    }
                ];

                if(o.IS_EXPAND === false){
                    //e.button is used to check whether click event is triggered by user or code
                    if((e.button !== undefined && base.options.triggerExpandAsSelected === true) ||
                            (e.button === undefined && base.options.expandAndSelect === true)){
                        $(this).queue(queueFunc);
                    }else{
                        base.options.selected({base:base,$node:$(this),data:o});
                    }
                }else{
                    if(o.CHILD_COUNT != -1){
                        base.options.selected({base:base,$node:$(this),data:o});
                    }
                }
                e.preventDefault(e);
                return false;
            });
        },
        /**
         *
         *
        **/
        nodeExpand : function(elem,o,i,$elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            $elem.on('click' ,{o:o,i:i,that:this},function(e,selected){
                var o = e.data.o,
                    i = e.data.i,
                    $this = $(this),
                    that = e.data.that,
                    isSelected = $.isFunction(selected);
                if(o.CHILD === undefined){
                    if(!base.nodeData[o.GUID].CHILD){
                        var rtnExpand = base.options.expand({
                            data:o,
                            i:i,
                            expandOnly: !isSelected
                        });
                        if(rtnExpand === false){
                            $(this).remove();
                            if(isSelected){
                                selected();
                            }
                            return false;
                        }
                    }
                }
                if($this.data('is_expand')===true){
                    $this.data('is_expand',false).addClass(base.options.classIconCollapse).removeClass(base.options.classIconExpand);
                    o.IS_EXPAND = false;
                    that.removeGridDataToParent(elem,base.nodeData[o.GUID] , base.nodeData[o.GUID].CHILD_COUNT);
                    that.collapseNode(elem , (i+1));

                }else{
                    $this.data('is_expand',true).addClass(base.options.classIconExpand).removeClass(base.options.classIconCollapse);
                    o.IS_EXPAND = true;

                    if(base.nodeData[o.GUID].HIDE_CHILD.length > 0){
                        var GridData = base.GridData;
                        var HIDE_CHILD = base.nodeData[o.GUID].HIDE_CHILD;
                        var arr_left = GridData.slice(0,i+1);
                        var arr_right = GridData.slice(i+1);
                        base.GridData = arr_left.concat(HIDE_CHILD).concat(arr_right);
                        base.$content.empty();
                        that.increaseGridDataChildCount(elem,base.nodeData[o.GUID] , HIDE_CHILD.length);
                        that.expandNode(elem,i+1+HIDE_CHILD.length);
                    }
                    if(isSelected){
                        selected();
                    }
                    //fix expand subchild checkbox status
                    if(o.CHILD){
                        for(var i = 0 ; i < o.CHILD.length ; i++){
                            if(o.STATUS === 2){
                                base.nodeData[o.CHILD[i].GUID].STATUS = 2;
                            }
                            if(o.STATUS === 0){
                                base.nodeData[o.CHILD[i].GUID].STATUS = 0;
                            }
                        }
                    }
                }
                that.getMaxGridWidth(elem);
                that.syncExpandGUID(elem);
                e.preventDefault(e);
                return false;
            });
        },
        /**
         *
         *
        **/
        syncExpandGUID : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.expandGUID = new Array();
            $.each(base.GridData,function(i,o){
                if(o.IS_EXPAND === true){
                    base.expandGUID.push(o.GUID);
                }
            });
        },
        /**
         *
         *
        **/
        getExpandGUID : function(elem,fn){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            fn(base.expandGUID);
        },
        /**
         *
         *
        **/
        renderNode : function(elem,ui,data){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var GridData = base.GridData,
                CHILD_LEN = ui.data.CHILD_COUNT = data.CHILD.length || 0;
            if(CHILD_LEN > 0){
                var index = ui.i+1;
                var arr_left = GridData.slice(0,index);
                var arr_right = GridData.slice(index);
                var GRID_DATA = this.setDefaultNodeProperty(elem,ui,data.CHILD);
                base.GridData = arr_left.concat(GRID_DATA).concat(arr_right);
                this.expandNode(elem,index);
                base.nodeData[ui.data.GUID].CHILD = data.CHILD;
                base.nodeData[ui.data.GUID].GRID_DATA = GRID_DATA;
                this.insertGridDataToParent(elem,base.nodeData[ui.data.GUID] , GRID_DATA.length);
            }
            this.getMaxGridWidth(elem);
            //remove icon if there are no any child in this domain.
            if( !base.nodeData[ui.data.GUID].CHILD ) {
                //base.$content.find('div.node[guid='+ui.data.GUID+']').find('span.'+base.options.classExpandCollapse).remove();
                base.$content.children('div.node').each(function(index,node){
                    node = $(node);
                    if( node.attr('guid') == ui.data.GUID ){
                        node.find('span.'+base.options.classExpandCollapse).remove();
                        return false;
                    }
                });
            }
        },
        getMaxGridWidth : function(elem , w){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(w){
                if(w < 0 ) return false;
                base.$elem.width(parseInt(w,10));
            }else{
                base.$elem.width(parseInt( base.$elem.parent().width() , 10));
            }

            base.maxWidth = base.$contentScrollerWrap[0].clientWidth;
            $.each(base.GridData,function(i,o){
                if(o.width > base.maxWidth ){
                    base.maxWidth = o.width;
                }
            });
            if(base.maxWidth < 0 ) return false;
            base.$content.width(base.maxWidth);
        },
        /**
         *
         *
        **/
        setDefaultNodeProperty : function(elem,ui,CHILD){
            var that = this,
                base = that.getData(elem),
                arr = [],
                childDeep = ui.data.DEEP + 1;
            /**********************************************/
            $.each(CHILD , function(i,o){
                var n = $.extend({} , base.defaultChild, {
                    NAME:o.NAME,
                    GUID:o.GUID,
                    ICON : o.ICON,
                    DEEP : childDeep,
                    PARENT : ui.data.GUID,
                    HAS_EXPAND_COLLAPSE_ICON:o.HAS_EXPAND_COLLAPSE_ICON,
                    STATUS : o.STATUS,
                    NODE_DATA:o
                });
                arr.push(n);
                base.nodeData[o.GUID] = n;
            });
            return arr;
        },
        /**
         *
         *
        **/
        expandNode : function(elem,index){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            this.removeAfterRows(elem,index);
            this.renderContent(elem);
        },
        /**
         *
         *
        **/
        removeAfterRows : function(elem,index){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            for(var i = index ; i < base.renderRange.bottom ; i++){
                $('> div[node='+i+']' , base.$content).remove();
            }
        },
        /**
         *
         *
        **/
        insertGridDataToParent : function(elem , node , insertChildCount){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            //stop update GridData to deep == 1
            if(!node.PARENT ) return false;
            this.insertGridDataPositionWithParent(elem , node , insertChildCount);
            this.insertGridDataToParent(elem , base.nodeData[node.PARENT] , insertChildCount);
        },
        /**
         *
         *
        **/
        insertGridDataPositionWithParent : function(elem , o , insertChildCount){
            var that = this,
                base = that.getData(elem),
                PARENT = o.PARENT,
                GUID = o.GUID,
                GRID_DATA = base.nodeData[PARENT].GRID_DATA,
                pos = 0;
            /**********************************************/
            for(var i = 0 ; i<GRID_DATA.length ; i++){
                if(GRID_DATA[i].GUID == GUID){
                    pos = i;
                    break;
                }
            }
            var arr_left = GRID_DATA.slice(0,i+1);
            var arr_right = GRID_DATA.slice(i+1+insertChildCount);
            var n_GRID_DATA = o.GRID_DATA;
            base.nodeData[PARENT].CHILD_COUNT += insertChildCount;
        },
        /**
         *
         *
        **/
        removeGridDataToParent : function(elem , node , removeChildCount){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            //stop update GridData to deep == 1
            if(!node.PARENT ) return false;
            /*
            *
            *   update node childCount
            *
            *
            *
            */
            this.reduceGridDataChildCount(elem , node , removeChildCount);
            this.removeGridDataPositionWithParent(elem , node , removeChildCount);
        },
        /**
         *
         *
        **/
        reduceGridDataChildCount : function(elem , node , removeChildCount){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(!node.PARENT ) return false;
            var PARENT = node.PARENT;
            base.nodeData[PARENT].CHILD_COUNT -= removeChildCount;
            this.reduceGridDataChildCount(elem , base.nodeData[node.PARENT] , removeChildCount);
        },
        /**
         *
         *
        **/
        removeGridDataPositionWithParent : function(elem , o , removeChildCount){
            var that = this,
                base = that.getData(elem),
                PARENT = o.PARENT,
                GUID = o.GUID,
                GRID_DATA = base.GridData,
                pos = 0,
                HIDE_CHILD = [];
            /**********************************************/

            for(var i = 0 ; i<GRID_DATA.length ; i++){
                if(GRID_DATA[i].GUID == GUID){
                    pos = i;
                    break;
                }
            }
            var loop = i+removeChildCount;
            while (pos < loop){
                pos++;
                HIDE_CHILD.push(GRID_DATA[pos]);
            }
            var arr_left = GRID_DATA.slice(0,i+1);
            var arr_right = GRID_DATA.slice(i+1+removeChildCount);
            base.GridData = arr_left.concat(arr_right);
            base.nodeData[GUID].HIDE_CHILD = HIDE_CHILD;
        },
        /**
         *
         *
        **/
        collapseNode : function(elem,index){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            this.removeAfterRows(elem,index);
            this.renderContent(elem);
            this.getMaxGridWidth(elem);
        },
        /**
         *
         *
        **/
        increaseGridDataChildCount : function(elem , node , insertChildCount){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(!node.PARENT ) return false;
            var PARENT = node.PARENT;
            base.nodeData[PARENT].CHILD_COUNT += insertChildCount;
            this.increaseGridDataChildCount(elem,base.nodeData[node.PARENT] , insertChildCount);
        },
        /**
         *
         *
        **/
        contentScrollingHandle : function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData(elem),
                vDiff,
                hDiff;
            /**********************************************/
            base.scrollTop = this.scrollTop;
            base.scrollLeft = this.scrollLeft;
            base.clientWidth = this.clientWidth;
            //vertical properties
            if (base.scrollTop !== base.prevScrollTop) {
				//scroll to close menu
                that.removeContextMenu(elem);
                base.vDiff = base.scrollTop - base.prevScrollTop;
                base.absScrollDiff = Math.abs(base.vDiff);
                that.dynamicRequestLoading(elem);
            }
        },
        /**
         *
         *
        **/
        contentScrollStopHandle : function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData(elem),
                vDiff;
            /**********************************************/
            base.scrollTop = this.scrollTop;
            base.scrollLeft = this.scrollLeft;
            //The vertical scrollbar scroled , render more rows
            if (base.scrollTop !== base.prevScrollTop){
                base.vDiff = base.scrollTop - base.prevScrollTop;
                base.absTopPosition += base.vDiff;
                setTimeout(function(){
                    that.appendRow(elem);
                    that.getMaxGridWidth(elem);
                }, base.scrollRenderRowsTimeout);
                base.prevScrollTop = base.scrollTop;
            }
            //The vertical scrollbar scroled , render more rows
            if (base.scrollTop !== base.prevScrollTop){
                base.prevScrollLeft = base.scrollLeft;
            }
        },
        /**
         *
         *
        **/
        appendRow : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var range = this.getRenderRange(elem);
            if(range){
                this.createRows(elem);
                base.absScrollDiff = 0;
            }
        },
        /**
         *
         *
        **/
        getRenderRange : function(elem){
            var that = this,
                base = that.getData(elem),
                top ,
                bottom ,
                maxBottomLength ,
                GridData = base.GridData;
            /**********************************************/

            base.perPageRows =  Math.ceil(base.contentHeight/base.options.rowHeight);
            if(base.absScrollDiff < base.rowHeight) return false;
            if (base.absScrollDiff > base.contentHeight){
                base.$content.empty();
            }
            top = Math.floor((base.absTopPosition)/base.options.rowHeight)-base.options.scrollRowsBuffer;
            if(top <0) top = 0;

            bottom = Math.ceil((base.absTopPosition+base.contentHeight)/base.options.rowHeight)+base.options.scrollRowsBuffer;
            maxBottomLength = GridData.length;
            if (bottom >= maxBottomLength){
                bottom = maxBottomLength;
			}
            base.renderRange = {
                top : top,
                bottom : bottom
            };
            //remove sibling rows
            if(base.absScrollDiff < base.contentHeight){
                this.removeSiblingRows(elem);
            }
            return base.renderRange;
        },
        /**
         *
         *
        **/
        removeSiblingRows : function(elem){
            var that = this,
                base = that.getData(elem),
                top = base.renderRange.top,
                bottom = base.renderRange.bottom,
                checkpointTop = top-base.perPageRows,
                checkpointBottom = bottom+base.perPageRows;
            /**********************************************/
            for(var i = checkpointTop ; i < top ; i++){
                $('> div[node='+i+']' , base.$content).remove();
            }
            for(var i = bottom ; i < checkpointBottom ; i++){
                $('> div[node='+i+']' , base.$content).remove();
            }
        },
        /**
         *
         *
        **/
        setupNodeWidth : function(elem, node){
            var that = this,
                base = that.getData(elem),
                $nodeElements,
                nodeWidth;
            /**********************************************/

            if(node){
                nodeWidth = 0;

                base.$content.children('div.node').each(function(index, elem){
                    elem = $(elem);
                    if( elem.attr('guid') == node.GUID ){
                        $nodeElements = elem.children();
                        $nodeElements.each(function(j, m){
                            nodeWidth += $(m).outerWidth();
                        });
                        return false;
                    }
                });

                node.width = nodeWidth;
                base.nodeData[node.GUID].width = nodeWidth;
            }
        },
        /**
         *
         *
        **/
        ajaxLoading : function(elem,options){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.$elem = $(elem);

            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            var $ajaxLoading = $('<div />').addClass('ajax-loading').appendTo(base.$elem);
            var $message = $('<div />').addClass('message').appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            $message.css(
                {
                    left: ($ajaxLoading.width()-$message.width())/2,
                    top : ($ajaxLoading.height()-$message.height())/2
                }
            );
        },
        /**
         *
         *
        **/
        ajaxLoadingComplete : function(elem,options){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var timeout = base.ajaxLoadingRemoveTimeout;
            if(options && options.delay){
                timeout = options.delay;
            }
            setTimeout(function(){
                base.$elem.find('div.ajax-loading').remove();
            }, timeout);
        },
        /**
         *
         *
        **/
        getSelectedGUID : function(elem , func){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            func(base.highLightGUID);
        },
        /**
         *
         *
        **/
        adjHeight : function(elem,h){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(h < 0) return false;
            if(!h){
                h = parseInt( base.$elem.height() , 10);
            }else{
                base.$elem.height(h);
            }

            base.$contentScrollerWrap.height(h);
            base.contentHeight = h;
            base.absScrollDiff = h;

            this.appendRow(elem);

            this.getMaxGridWidth(elem);
        },
        /**
         *
         *
        **/
        triggerExpand : function(elem , options){
            var that = this,
                base = that.getData(elem),
                targetNodeData,
                i = 0;
            /**********************************************/

            options = $.extend(true,{},{expandAndSelect: false, offset:2},options);
            base.options.expandAndSelect = options.expandAndSelect;

            for(i ; i < base.GridData.length ; i++){
                if (base.GridData[i].GUID == options.GUID){
                    targetNodeData = base.GridData[i];
                    break;
                }
            }
            i -= options.offset;
            if(base.options.fakeContextMenu){
                base.$contentScrollerWrap[0].scrollTop = i*base.options.rowHeight;
            }
            var oStart = new Date().getTime();

            var expandElem = function(){
                var $targetExpandIcon,
                    $targetNode,
                    $target,
                    timeInterval,
                    retryMaxTime = 1000;

                base.$content.children('div.node').each(function(index,node){
                    node = $(node);
                    if( node.attr('guid') == options.GUID ){
                        $target = node;
                        return false;
                    }
                });

                if( !$target ){
                    timeInterval = new Date().getTime() - oStart;
                    if( timeInterval > retryMaxTime ){
                        return;
                    }
                }else{
                    $targetExpandIcon = $target.find('span.' + base.options.classExpandCollapse);
                    timeInterval = new Date().getTime() - oStart ;
                    if(options.expandAndSelect === true){
                        $targetNode = $target.find('span.node-icons-text');
                        if($targetNode.length > 0 || timeInterval > retryMaxTime){
                            $targetNode.trigger('click');
                            return;
                        }
                    }else{
                        if( $targetExpandIcon.length > 0 || timeInterval > retryMaxTime){
                            if(targetNodeData.IS_EXPAND === false){
                                $targetExpandIcon.trigger('click');
                            }
                            return;
                        }
                    }
                }
                setTimeout( arguments.callee, 300 );    //retry
            };

            expandElem();   //execute immediately
        },
        triggerSelect : function(elem , options){
            var that = this,
                base = that.getData(elem),
                i = 0;
            /**********************************************/

            options = $.extend(true,{},{expandAndSelect: false, offset:2},options);
            base.options.expandAndSelect = options.expandAndSelect;

            for(i ; i < base.GridData.length ; i++){
                if (base.GridData[i].GUID == options.GUID){
                    break;
                }
            }
            i -= options.offset;
            if(base.options.fakeContextMenu){
                base.$contentScrollerWrap[0].scrollTop = i*base.options.rowHeight;
            }
            var oStart = new Date().getTime();

            var selectElem = function(){
                var $targetNode,
                    $target,
                    timeInterval,
                    retryMaxTime = 1000;

                base.$content.children('div.node').each(function(index,node){
                    node = $(node);
                    if( node.attr('guid') == options.GUID ){
                        $target = node;
                        return false;
                    }
                });

                if( !$target ){
                    timeInterval = new Date().getTime() - oStart;
                    if( timeInterval > retryMaxTime ){
                        return;
                    }
                }else{
                    $targetNode = $target.find('span.node-icons-text');
                    timeInterval = new Date().getTime() - oStart ;
                    if($targetNode.length > 0 || timeInterval > retryMaxTime){
                        $targetNode.trigger('click');
                        return;
                    }
                }
                setTimeout( arguments.callee, 300 );    //retry
            };

            selectElem();   //execute immediately
        },
        /**
         *
         *
        **/
        renderSearchResultNode : function(elem , options){
            var that = this,
                base = that.getData(elem),
                searchResultData = options.searchResult.data,
                i = 0;
            /**********************************************/
            base.searchResultGUID = options.searchResult.data.GUID;
            if(options.searchResultDisableContextMenu === false){
                base.options.searchResultDisableContextMenu = options.searchResultDisableContextMenu;
            }
            var n = $.extend({} , base.defaultChild ,{
                NAME: searchResultData.NAME,
                GUID: searchResultData.GUID,
                DEEP: 1,
                PARENT : base.options.rootGUID,
                HAS_EXPAND_COLLAPSE_ICON: false,
                STATUS : searchResultData.STATUS || 0,
                NODE_DATA: searchResultData
            });

            if(base.GridData[base.GridData.length-1].GUID !=  base.options.searchResult.data.GUID){
                base.GridData.push(n);
                base.nodeData[base.searchResultGUID] = n;
                this.renderContent(elem);
            }
            this.triggerSelect(elem,{GUID:base.options.searchResult.data.GUID});
            base.$contentScrollerWrap[0].scrollLeft = 0;
        },
        /**
         *
         *
        **/
        setHighLightGUID : function(elem,highLightGUID){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.highLightGUID = highLightGUID;
        },
        /**
         *
         *
        **/
        refresh : function(elem,data){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(data){
                this.rebuildGridData(elem,data);
                this.removeContent(elem);
                this.renderContent(elem);
            }else{
                this.removeContent(elem);
                this.renderContent(elem);
            }
        },
        /**
         *
         *
        **/
        disableSelection : function(elem , target ){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            $.each(target,function(i,o) {
                $(o)
                    .attr('unselectable', 'on')
                    .css({
                        '-moz-user-select':'none',
                        '-o-user-select':'none',
                        '-khtml-user-select':'none',
                        '-webkit-user-select':'none',
                        '-ms-user-select':'none',
                        'user-select':'none'
                    })
                    .attr('unselectable','on')
                    .on('selectstart',function(){
                        return false;
                    });
            });
        },
        /**
         *
         *
        **/
        rebuildGridData : function(elem,newNodeData){
            var that = this,
                base = that.getData(elem),
                root = base.options.data;
            /**********************************************/
            for(key in newNodeData){
                if(newNodeData[key].CHILD){
                    delete(base.nodeData[key].CHILD);
                }
            }
            $.extend(true,base.nodeData,newNodeData);
            base.GridData = new Array();
            GridData = base.GridData;
            GridData[0] = $.extend(true,{},base.nodeData[base.options.rootGUID]);
            this.rebuildChildGridData(elem,GridData,base.nodeData[base.options.rootGUID]);
            if(base.searchResultGUID != ''){
                base.GridData.push(base.nodeData[base.searchResultGUID]);
            }
        },
        /**
         *
         *
        **/
        rebuildChildGridData : function(elem , GridData ,node){
            var that = this,
                base = that.getData(elem),
                root = base.options.data;
            /**********************************************/
            if(node){
                node.HIDE_CHILD = [];
                if(node.CHILD){
                    $.each(node.CHILD,function(i,o){
                        if(!base.nodeData[o.GUID]){
                            $.extend(true,o,base.defaultChild,{DEEP:(node.DEEP+1),PARENT:node.GUID});
                            base.nodeData[o.GUID] = o;
                        }
                        $.extend(true , base.nodeData[o.GUID] , o);
                        base.nodeData[o.GUID].HIDE_CHILD = new Array();
                        if(base.nodeData[o.GUID].IS_EXPAND === true){
                            base.nodeData[o.GUID].CHILD_COUNT = 0;
                        }else{
                            base.nodeData[o.GUID].CHILD_COUNT = -1;
                            delete(base.nodeData[o.GUID].CHILD);
                        }
                        that.rebuildChildCount(elem , base.nodeData[o.GUID]);
                        GridData.push(base.nodeData[o.GUID]);
                        if(base.nodeData[o.GUID].IS_EXPAND === true){
                            that.rebuildChildGridData(elem,GridData,base.nodeData[o.GUID]);
                        }
                    });
                }
            }
        },
        /**
         *
         *
        **/
        rebuildChildCount : function(elem , node){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            if(node.PARENT){
                base.nodeData[node.PARENT].CHILD_COUNT += 1;
                that.rebuildChildCount(elem,base.nodeData[node.PARENT]);
            }
        },
        /**
         *
         *
        **/
        scrollTo : function(elem,options){
            var that = this,
                base = that.getData(elem),
                opts = $.extend({} , {x:false,y:false} , options);
            /**********************************************/

            if(opts.x !== false){
                base.$contentScrollerWrap[0].scrollLeft = opts.x;
            }
            if(opts.y !== false){
                base.$contentScrollerWrap[0].scrollTop = opts.y;
                if(opts.y === 0){
                    this.setupDefaultRange(elem);
                }
            }
        },
        /**
         *
         *
        **/
        dynamicRequestLoading : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var bufferHeight = base.options.scrollRowsBuffer * base.options.rowHeight;
            if(base.vDiff >= bufferHeight){
                this.ajaxLoadingAsScrollingDown(elem);
            }
            if(base.vDiff <= -1*bufferHeight){
                this.ajaxLoadingAsScrollingUp(elem);
            }
        },
        /**
         *
         *
        **/
        ajaxLoadingAsScrollingUp : function(elem , $topElem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.$elem = $(elem);
            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            var $ajaxLoading = $('<div />').addClass('ajax-loading').css('background-image','none').appendTo(base.$elem);
            var $message = $('<div />').addClass('message').appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            var top = 0;
            var height = $message.height()*2;
            $ajaxLoading.css({
                top : top,
                height : height,
                width : base.$contentScrollerWrap[0].clientWidth
            });
            if(height > 0){
                $message.css(
                    {
                        left:($ajaxLoading.width()-$message.width())/2,
                        top : ($ajaxLoading.height()-$message.height())/2
                    }
                );
            }
            $ajaxLoading.css('width','0px');
        },
        /**
         *
         *
        **/
        ajaxLoadingAsScrollingDown : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.$elem = $(elem);
            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            var $ajaxLoading = $('<div />').addClass('ajax-loading').css('background-image','none').appendTo(base.$elem);
            var $message = $('<div />').addClass('message').appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            var height = $message.height()*2;
            var top = base.$contentScrollerWrap[0].clientHeight - height;
            $ajaxLoading.css({
                top : top,
                height : height,
                width : base.$contentScrollerWrap[0].clientWidth
            });
            if(height > 0){
                $message.css(
                    {
                        left:($ajaxLoading.width()-$message.width())/2,
                        top : ($ajaxLoading.height()-$message.height())/2
                    }
                );
            }
            $ajaxLoading.css('width','0px');
        },
        /**
         *
         *
        **/
        getSelectedNode : function(elem , fn){
            var that = this,
                base = that.getData(elem),
                i = 0,
                root = base.nodeData[base.options.rootGUID],
                CHILD = root.CHILD;
            /**********************************************/
            base.selectedStatus.OFF = [];
            base.selectedStatus.HALF = [];
            base.selectedStatus.ON = [];

            this.setSelectedStatusProperty(elem,root);
            //recursive for CHILD
            if(root.STATUS == 1){
                this.setChildSelectedNode(elem,root);
            }

            if($.isFunction(fn)){
                fn(base.selectedStatus);
            }
        },
        setChildSelectedNode : function(elem,node){
            var that = this,
                base = that.getData(elem),
                STATUS = node.STATUS,
                CHILD = node.CHILD,
                childNode,
                i = 0;
            /**********************************************/
            if(node.CHILD_COUNT != -1){
                for(i ; i < CHILD.length ; i++){
                    childNode = base.nodeData[CHILD[i].GUID];
                    this.setSelectedStatusProperty(elem,childNode);
                    if(childNode.STATUS == 1){
                        this.setChildSelectedNode(elem,childNode);
                    }
                }
            }
        },
        /**
         *
         *
        */
        setSelectedStatusProperty : function(elem,node){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            switch(node.STATUS){
                case 0:
                    base.selectedStatus.OFF.push(node.GUID);
					break;
                case 1:
                    base.selectedStatus.HALF.push(node.GUID);
					break;
                case 2:
                    base.selectedStatus.ON.push(node.GUID);
					break;
				default:
					break;
            }
        },
        removeContextMenu: function(elem){
            $(document).trigger('closeContextMenu');
        }
    };
    $.fn[PLUGIN_NAME].publicMethods = {
        /**
         *
         *
        **/
        renderNode : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.renderNode(elem , args[0] , args[1] );
        },
        /**
         *
         *
        **/
        ajaxLoading : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.ajaxLoading(elem,args[0]);
        },
        /**
         *
         *
        **/
        ajaxLoadingComplete : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.ajaxLoadingComplete(elem,args[0]);
        },
        /**
         *
         *
        **/
        getSelectedGUID : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getSelectedGUID(elem,args[0]);
        },
        /**
         *
         *
        **/
        adjHeight : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.adjHeight(elem , args[0]);
        },
        /**
         *
         *
        **/
        adjWidth : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getMaxGridWidth(elem , args[0]);
        },
        triggerExpand : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.triggerExpand(elem , args[0]);
        },
        /**
         *
         *
        **/
        triggerSelect : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.triggerSelect(elem , args[0]);
        },
        /**
         *
         *
        **/
        renderSearchResultNode : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.renderSearchResultNode(elem , args[0]);
        },
        /**
         *
         *
        **/
        refresh : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.refresh(elem , args[0]);
        },
        /**
         *
         *
        **/
        getExpandGUID : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getExpandGUID(elem , args[0]);
        },
        /**
         *
         *
        **/
        setHighLightGUID : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.setHighLightGUID(elem , args[0]);
        },
        /**
         *
         *
        **/
        scrollTo : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.scrollTo(elem , args[0]);
        },
        /**
         *
         *
        **/
        getSelectedNode : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getSelectedNode(elem , args[0]);
        },
        removeContextMenu : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.removeContextMenu(elem , args[0]);
        }
    };
    $.fn[PLUGIN_NAME].defaults = $.extend({}, {
        // TODO: Default options for plugin.
        classIconCollapse : "icon-collapse",
        classIconExpand : "icon-expand",
        classExpandCollapse : "expand-collapse",
        classUIHover : "ui-hover",
        classUIselected : "ui-selected",
        fakeContextMenu : true,
        classUIselectedFake : "ui-selected-fake",
        scrollRowsBuffer: 50,
        rowHeight : 20,
        rootGUID : '00000000-0000-0000-0000-000000000000',
        isShowRoot: true,
        setRootHighLight : true,
        triggerExpandAsSelected : false,
        selected : function(base){
        },
        expand : function(base){
            return false;
        },
        searchResult:{
            data:{
                NAME : 'Search result',
                GUID : 'search-result'
            }
        },
        onContextMenu : function(GUID){
            return true;
        },
        unContextMenu : function(GUID){
            return true;
        },
        searchResultDisableContextMenu : true,
        elemHeight : null,
        containerNode : ['icon'], //['checkBox','icon']
        onChecked : function(node){
            return true;
        },
        unChecked : function(node){
            return true;
        },
        cellsFormat: function(nodeIcon, o, nodeDiv){
        }
    });
    $.fn[PLUGIN_NAME].base = $.extend({}, {
        scrollTop : 0,
        prevScrollTop : 0,
        scrollLeft : 0,
        prevScrollLeft : 0,
        absScrollDiff : 0,
        scrollRenderRowsTimeout : 100,
        absTopPosition : 0,
        renderRange: {
            top: 0,
            bottom: 20
        },
        perPageRows : '',
        highLightGUID : null,
        GridData : [],
        nodeData : {},
        maxWidth : 0,
        ajaxLoadingRemoveTimeout : 500,
        expandGUID : [],
        selectedStatus : {
            OFF : [],
            HALF : [],
            ON : []
        },
        defaultChild :{
            STATUS : 0,
            IS_EXPAND : false,
            HAS_EXPAND_COLLAPSE_ICON : true,
            CHILD_COUNT : -1,
            GRID_DATA : [],
            HIDE_CHILD : []
        },
        searchResultGUID : ''
    });
})(jQuery);