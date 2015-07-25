/*
 *
 * Depends:
 *      jquery-1.8.0.js
 *      jquery.event.drag-2.2.js
 *      jquery.event.drop-2.2.js
 *      json2.js
 *      scroll-startstop.events.jquery.js
 *      trend-grid.css
 * Example:
 *
 * Copyright (c) 1989-2013 Trend Micro Incorporated, All Rights Reserved
*/
(function($) {
    var PLUGIN_NAME = "trendGrid";
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
                $.error("Plugin '" + PLUGIN_NAME + "' can't be triggered twice. Please use other methods to re-render grid.");
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
        init : function( elem ){
            var that = this;
                base = that.getData( elem ),
                base.$elem = $( elem ),
                base.elemId = base.$elem.attr('id');
            /**********************************************/

            if(base.options.elemHeight != null ){
                base.$elem.height(base.options.elemHeight);
            }

            this.ajaxLoading( elem );

            this.preventContextMenu( elem );
            this.prepareElements( elem );

            this.setupDefaultProperty( elem );

            //render header columns
            this.renderHeaderColumns( elem );
            //this.setStyleRule( elem );

            base.$contentScrollerWrap.bind('scroll', {
                elem : elem,
                that : this
            }, this.contentScrollingHandle);
            base.$contentScrollerWrap.on('scrollstop', {
                elem:elem,
                that:this
            } , this.contentScrollStopHandle);
            this.rowSelectable( elem );
            //render content cells
            this.renderContentCells( elem );
            this.ajaxLoadingComplete( elem );

        },
        /**
         *  Returns the data for relevant for this plugin
         *
        **/
        getData : function( elem ){
            return $.data(elem, PLUGIN_NAME) || {};
        },
        /**
         *  Returns the options for settings
         *
        **/
        getOptions : function( elem, func ){
            func(this.getData(elem).options);
        },
        /**
         *
         *
        **/
        preventContextMenu : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.$elem.unbind('contextmenu').bind('contextmenu', function(e) {
                e.preventDefault(e);
                return false;
            });
        },
        /**
         *
         *
        **/
        prepareElements : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            //insert fixed header
            base.$headerScrollerWrap = $('<div/>').addClass('headerScrollerWrap').appendTo(base.$elem);
            base.$header = $('<div/>').addClass('header').appendTo(base.$headerScrollerWrap);
            //Insert content
            base.$contentScrollerWrap = $('<div/>').addClass('contentScrollerWrap').appendTo(base.$elem);
            base.$content = $('<div/>').addClass('content').appendTo(base.$contentScrollerWrap);

            //Disable text selection
            this.disableSelection(elem , [base.$header,base.$content,base.$contentScrollerWrap]);
        },
        /**
         *
         *
        **/
        disableSelection : function(elem , target ){
            var that = this,
                base = that.getData( elem );
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
        setupDefaultProperty : function( elem ){
            var that = this,
                base = that.getData( elem),
                columns = base.options.columns;

            /**********************************************/

            //The minimum width of column should large than base.columnWidthdiff.
            base.options.columnsMinWidth = Math.max( base.columnWidthdiff , base.options.columnsMinWidth );

            //setup default value
            base.prefixID = 'row_' + this.randomString(that, 8) + '_';
            base.scrollRight = base.scrollLeft + base.$contentScrollerWrap.outerWidth();
            base.perPageRows = Math.ceil((this.getContentHeight( elem )-base.headerHeight) / base.options.rowHeight);
            if(base.options.dragSelect.dragColumnId == null){
                base.options.dragSelect.dragColumnId = base.options.columns[0].id;
            }

            if(base.options.columnsType == 2){
                this.adjColumnPercentageWidth(elem);
            }

            this.setupDefaultRange( elem );


            //style node
            this.createStyleNode( elem );

            base.visibleRange.bottom =  Math.min(base.options.rowRecords  , base.perPageRows) -1;

        },
        /**
         *  Returns a random string
         *
        **/
        randomString : function(elem , length){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            var chars = 'abcdefghiklmnopqrstuvwxyz'.split('');
            if (!length) {
                length = Math.floor(Math.random() * chars.length);
            }
            var str = '';
            for (var i = 0; i < length; i++) {
                str += chars[Math.floor(Math.random() * chars.length)];
            }
            return str;
        },
        /**
         *  Returns the height of content
         *
        **/
        getContentHeight : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            return parseFloat($.css(base.$elem[0], "height", true));
        },
        /**
         *
         *
        **/
        getContentScrollerWrapHeight : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            return base.$elem.height() - base.$header.height();
        },
        /**
         *  Setup rows range
         *
        **/
        setupDefaultRange : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            //reset renderRange
            if (base.options.scrollRowsBuffer == null) {
                base.options.scrollRowsBuffer = Math.ceil(base.perPageRows / 2);
            }

            var bottom = base.perPageRows + base.options.scrollRowsBuffer;
            base.renderRange = $.extend(true,{},{
                top : 0,
                bottom : bottom
            });

        },
        /**
         *  Render style node in head element
         *
        **/
        createStyleNode : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
                base.ss1 = document.createElement('style');
                base.ss1.setAttribute("type", "text/css");
                base.ss1.setAttribute('id', base.elemId+'_css');
                var head = document.getElementsByTagName('head')[0];
                head.appendChild(base.ss1);
        },
        /**
         *
         *
        **/
        renderHeaderColumns : function( elem ){
            var that = this,
                base = that.getData( elem ),
                columns = base.options.columns,
                adjColumnWidthDiff = base.columnWidthdiff,
                $lastColumn;
            /**********************************************/
            base.$header.empty();
            base.columnsIdArray = [];
            base.headerTotalWidth = 0;
            $.each(columns, function(i, o) {
                o = columns[i] = $.extend(true, {}, base.options.columnDefaults, columns[i]);
                if(o.width == undefined){
                    o.width = base.options.columnDefaults.width;
                }
                if(o.width < base.options.columnsMinWidth){
                    o.width = base.options.columnsMinWidth;
                }
                $lastColumn = $('<div/>').width(o.width).html("<span class='column-name'>" + o.name + "</span>").attr('name','column_'+i);
                if(base.options.showTip){
                    $lastColumn.attr('title',o.name);
                }
                $lastColumn.addClass('column column-ellipsis').appendTo( base.$header );

                if( base.options.columnSort.disabled === false){
                    $lastColumn.hover(
                        function(){ $( this ).addClass('column-hover') },
                        function(){ $( this ).removeClass('column-hover') }
                    );
                }
                base.headerTotalWidth += o.width;
                base.columnsIdArray.push('column_'+i);
            });
            //Fix IE bug, move horizontal scroll bar to correct position.
            if(base.scrollRight > base.headerTotalWidth){
                var scrollLeftPosition = base.headerTotalWidth - base.$contentScrollerWrap.outerWidth();
                base.$headerScrollerWrap[ 0 ].scrollLeft = scrollLeftPosition;
                base.$contentScrollerWrap[ 0 ].scrollLeft = scrollLeftPosition;
            }
            this.autoFitColumn( elem );
            this.setStyleRule( elem );
            //this.setupContentWidth( elem );
            //this.setupDefaultContentHeight( elem );
            if( base.options.columnResize.disabled === false){
                this.columnResizable( elem );
            }
            if( base.options.columnReorder.disabled === false){
                this.columnReorderable( elem );
            }
            if( base.options.columnSort.disabled === false){
                this.columnSortable( elem );
            }
        },
        /**
         *
         *
        **/
        autoFitColumn : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/

            if (base.options.autoFitColumn == true) {
                var scrollWrapWidth = 0,
                    girdHeight = base.$elem.outerHeight(),
                    headerHeight = base.$header.outerHeight(),
                    contentScrollWrapHeight = girdHeight - headerHeight,
                    lastColumnObj = base.options.columns[base.options.columns.length-1],
                    $lastColumn = base.$header.children().last();

                if (base.options.rowRecords >= base.perPageRows) {
                    base.$contentScrollerWrap.css('height', contentScrollWrapHeight);
                    scrollWrapWidth = base.$elem.width() - this.scrollbarWidth( elem );
                }
                else {
                    scrollWrapWidth = base.$contentScrollerWrap.outerWidth();
                }

                var diff = scrollWrapWidth - base.headerTotalWidth;

                if (diff > 0) {
                    $lastColumn.width(diff + lastColumnObj.width - base.columnWidthdiff);
                    lastColumnObj.width = diff + lastColumnObj.width;
                }
            }
        },
        scrollbarWidth : function( elem ) {
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            var $div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>');
            // Append our div, do our calculation and then remove it
            $div.css('overflow-y', 'scroll');
            $('body').append($div);
            var w1 = $div.width();
            var w2 = $('div', $div).innerWidth();
            $div.remove();
            return (50 - w2);
        },
        /**
         *
         *
        **/
        getVisibleColumnRange : function( elem ){
            var that = this,
                base = that.getData( elem ),
                top = 0,
                bottom,
                totalWidth = 0;
            /**********************************************/
            if(base.scrollLeft == 0) top = 0;
            $.each(base.options.columns,function(i,o){
                if(totalWidth < base.scrollRight){
                    if(totalWidth < base.scrollLeft){
                        top = i;
                    }
                    if(totalWidth < base.scrollRight){
                        bottom = i;
                    }
                }
                totalWidth += o.width;
            });
            base.renderColumnRange.top = top;
            base.renderColumnRange.bottom = bottom;
        },
        /**
         *
         *
        **/
        columnResizable : function( elem ){
            var that = this,
                base = that.getData( elem ),
                adjColumnWidthDiff = 0,
                c,
                minPageX,
                scrollLeft,
                columnElems = base.$header.children(),
                contentAbsLeft = base.$content.offset().left,
                actualMinWidth = base.options.columnsMinWidth,
                $dragLine = $( '<div class="drag-line"/>'),
                targetColumn,
                nextColumn;
            /**********************************************/

            $.each( columnElems, function( targetColumnIndex, element ){
                if(!(base.options.columnsType === 2 && targetColumnIndex === columnElems.length-1)){
                    var $resizableHandle = $( '<div class="resizable-handle column-right"/>' ),
                        dragLineColumnIndex = targetColumnIndex;

                    $resizableHandle
                        .off( 'click' )
                        .on( 'dragstart', function( event, dd ){
                            that.removeContextMenu(elem);
                            $.each( columnElems, function( i, e ) {
                                base.options.columns[ i ].originalWidth = $( e ).outerWidth();
                            });
                            var shrinkLeewayOnLeft = 0;
                            targetColumn = base.options.columns[ targetColumnIndex ];

                            if(base.options.columnsType === 2){
                                nextColumn = base.options.columns[targetColumnIndex+1];
                            }
                            for ( var j = 0; j <= targetColumnIndex; j++ ){
                                c = base.options.columns[ j ];
                                    shrinkLeewayOnLeft += c.originalWidth - base.options.columnsMinWidth;
                            }
                            minPageX = event.pageX - shrinkLeewayOnLeft;
                            contentAbsLeft = base.$content.offset().left;
                            scrollLeft = base.$headerScrollerWrap[ 0 ].scrollLeft;
                            $dragLine.css( 'left' , dd.offsetX - contentAbsLeft + $( this ).width() - scrollLeft ).appendTo( base.$elem );
                        })
                        .on( 'drag', function( ev, dd ){
                                var offsetX,
                                    d = dd.deltaX;
                                if ( d < 0 ) { // decrease column width
                                    if(base.options.columnsType === 1){
                                        if ( d && ( targetColumn.originalWidth + d ) < actualMinWidth ){
                                            targetColumn.width = actualMinWidth + adjColumnWidthDiff;
                                        } else {
                                            targetColumn.width = targetColumn.originalWidth + d + adjColumnWidthDiff;
                                        }
                                    }else{
                                        if ( d && ( targetColumn.originalWidth + d ) < actualMinWidth ){
                                            targetColumn.width = actualMinWidth + adjColumnWidthDiff;
                                            nextColumn.width = nextColumn.originalWidth + (targetColumn.originalWidth - actualMinWidth) + adjColumnWidthDiff;
                                        } else {
                                            targetColumn.width = targetColumn.originalWidth + d + adjColumnWidthDiff;
                                            nextColumn.width = nextColumn.originalWidth - d + adjColumnWidthDiff;
                                        }
                                    }
                                } else { // increase column width
                                    if(base.options.columnsType === 1){
                                        base.options.columns[ targetColumnIndex ].width = targetColumn.originalWidth + d + adjColumnWidthDiff;
                                    }else{
                                        if((nextColumn.originalWidth - d) < actualMinWidth){
                                            nextColumn.width = actualMinWidth + adjColumnWidthDiff;
                                            targetColumn.width = targetColumn.originalWidth + (nextColumn.originalWidth - actualMinWidth) + adjColumnWidthDiff;
                                        }else{
                                            nextColumn.width = nextColumn.originalWidth - d + adjColumnWidthDiff;
                                            targetColumn.width = targetColumn.originalWidth + d + adjColumnWidthDiff;
                                        }
                                    }
                                }
                                //Resizing
                                offsetX = that.setHeaderColumnWidth( elem );
                                $dragLine.css( 'left' , offsetX[ dragLineColumnIndex ] - scrollLeft );
                        })
                        .on( 'dragend', function( ev, dd ){
                            that.setStyleRule( elem );
                            that.setupContentWidth( elem );
                            if(base.options.columnsType === 2){
                                var targetColumnPercentage,
                                    nextColumnPercentage,
                                    totalColumnWidth = targetColumn.width + nextColumn.width,
                                    totalColumnPercentage = parseInt(targetColumn.percentageWidth.replace('%','')) + parseInt(nextColumn.percentageWidth.replace('%',''));

                                targetColumnPercentage = Math.floor((targetColumn.width*totalColumnPercentage)/totalColumnWidth);
                                targetColumn.percentageWidth = targetColumnPercentage+"%";
                                nextColumnPercentage = totalColumnPercentage - targetColumnPercentage;
                                nextColumn.percentageWidth = nextColumnPercentage + "%";
                            }

                            $( this ).css( { left : '' } );
                            base.options.columnResize.stop( base.options );

                            $dragLine.remove();
                            base.triggerMouseUp = false;
                            base.options.autoFitColumn = false;
                            // fix IE resize issue when scroller at the end of right
                            base.$headerScrollerWrap[ 0 ].scrollLeft = base.$contentScrollerWrap[ 0 ].scrollLeft;
                            //render more cells
                            base.scrollLeft = base.$headerScrollerWrap[ 0 ].scrollLeft;
                            base.scrollRight = base.scrollLeft + base.$contentScrollerWrap.outerWidth();

                            that.getVisibleColumnRange( elem );

                            setTimeout( function(){
                                that.createCells( elem );
                            }, base.scrollRenderRowsTimeout );
                        })
                        .appendTo( element );
                }
            });
        },
        /**
         *  content scrolling event
         *
        **/
        contentScrollingHandle : function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData( elem ),
                vDiff,
                hDiff;
            /**********************************************/
            base.scrollCFG = true;//renderRow at the last scrolling action
            base.scrollTop = this.scrollTop;
            base.scrollLeft = this.scrollLeft;
            base.clientWidth = this.clientWidth;
            //To make it synchronized scrolling with header columns
            base.$headerScrollerWrap[0].scrollLeft = base.scrollLeft;
            //vertical properties
            if (base.scrollTop !== base.prevScrollTop) {
                that.removeContextMenu(elem);
                base.vDiff = base.scrollTop - base.prevScrollTop;
                base.absScrollDiff = Math.abs(base.vDiff);

                base.visibleRange.top =  Math.max( Math.ceil( base.scrollTop / base.options.rowHeight ) - 1 , 0) ;
                base.visibleRange.bottom =  Math.min( Math.ceil( (base.scrollTop+base.$contentScrollerWrap.height()) / base.options.rowHeight ) + 1 , base.options.rowRecords);

                that.dynamicRequestLoading( elem );
            }
            //horizon properties
            if (base.scrollLeft !== base.prevScrollLeft) {
                $('.node', base.$content).width(base.scrollLeft + base.clientWidth);
                hDiff = base.scrollLeft - base.prevScrollLeft;
                base.scrollRight = base.scrollLeft + base.$contentScrollerWrap.outerWidth();
            }
        },
        /**
         *  content scroll stop event
         *
        **/
        contentScrollStopHandle : function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData( elem ),
                vDiff,
                hDiff;
            /**********************************************/

            base.scrollCFG = false;
            base.scrollTop = this.scrollTop;
            base.scrollLeft = this.scrollLeft;
                //The horizontal scrollbar scroled , render more cells
                if (base.scrollLeft !== base.prevScrollLeft){
                    that.getVisibleColumnRange( elem );
                    setTimeout(function(){
                        that.createCells( elem );
                    }, base.scrollRenderRowsTimeout);
                    base.prevScrollLeft = base.scrollLeft;
                }
                //The vertical scrollbar scroled , render more rows
                if (base.scrollTop !== base.prevScrollTop){
                    base.vDiff = base.scrollTop - base.prevScrollTop;
                    base.absTopPosition += base.vDiff;
                    setTimeout(function(){
                        //renderRow at the last scrolling action
                        if(base.scrollCFG === true) return false;
                        that.appendRow( elem );
                    }, base.scrollRenderRowsTimeout);
                    base.prevScrollTop = base.scrollTop;
                }
        },
        /**
         *
         *
        **/
        setHeaderColumnWidth : function( elem ){
            var that = this,
                base = that.getData( elem ),
                columnElems = base.$header.children(),
                offset = new Array(),
                startX = 0;
            /**********************************************/
            $.each(base.options.columns , function(i,o){
                startX += o.width;
                offset.push(startX);

                $columnElems = $(columnElems[i]);
                if($columnElems.outerWidth() !== o.width){
                    $columnElems.width(o.width - base.columnWidthdiff);
                }
            });
            return offset;
        },
        /**
         *
         *
        **/
        setupContentWidth : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if(base.$content.width() !== this.getRowWidth( elem )){
                base.$content.width(this.getRowWidth( elem ));
            }else{
                //enforce IE7 redraw content when content width is same
                if(base.$content.hasClass('fake_redraw')){
                    base.$content.removeClass('fake_redraw');
                }else{
                    base.$content.addClass('fake_redraw');
                }
            }
        },
        /**
         *
         *
        **/
        setupDefaultContentHeight : function( elem ){
            var that = this,
                base = that.getData( elem ),
                height = this.getContentScrollerWrapHeight( elem );
            /**********************************************/
            base.$contentScrollerWrap.height(height);
            base.$content.height(height);
            base.contentHeight = height;
        },
        /**
         *
         *
        **/
        getRowWidth : function( elem ){
            var that = this,
                base = that.getData( elem ),
                rowWidth = 0;
            /**********************************************/
            $.each(base.options.columns, function(i, o) {
                rowWidth += (o.width || base.options.columnDefaults.width);
            });
            return rowWidth;
        },
        /**
         *
         *
        **/
        setStyleRule : function( elem ){
            var that = this,
                base = that.getData( elem ),
                pleft = 0,
                pright = this.getRowWidth( elem ),
                columns = base.options.columns,
                styleId = base.elemId,
                styleSheet = base.ss1.styleSheet,
                cssRule = '';
            /**********************************************/

            this.setHeaderColumnsLeftRight( elem );
            $.each(columns, function(i, o) {
                cssRule += '.' + styleId + '_' + o.id + '{left:' + o.left + 'px;right:' + o.right + 'px;}';
            });
            var ss1 = document.getElementsByTagName('head')[0];
            if ($.browser.msie) {// IE
                //Fix IE10
                try{
                    styleSheet = ss1.document.getElementById(base.elemId+'_css').styleSheet;
                    styleSheet.cssText = cssRule;
                }catch(e){
                    $(ss1).find('#'+base.elemId+'_css').empty().text(cssRule);
                }
            } else {//None IE
                $(ss1).find('#'+base.elemId+'_css').empty().text(cssRule);
            }
        },
        /**
         *
         *
        **/
        setHeaderColumnsLeftRight : function( elem ){
            var that = this,
                base = that.getData( elem ),
                pleft = 0,
                pright = this.getRowWidth( elem ),
                columns = base.options.columns;
            /**********************************************/
            $.each(columns, function(i, o) {
                o.left = pleft.toFixed(1);
                pleft += o.width;
                pright -= o.width;
                o.right = pright.toFixed(1);
            });
        },
        /**
         *
         *
        **/
        renderContentCells : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            var range = base.renderRange;
            this.getVisibleColumnRange( elem );
            if(range.bottom > base.options.rowRecords){
                range.bottom = base.options.rowRecords;
            }

            this.renderRows( elem );
        },
        /**
         *
         *
        **/
        renderRows : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.$content.empty();

            //this.setStyleRule( elem );

            this.createRows( elem );
            base.contentHeight = this.getContentScrollerWrapHeight( elem );
            base.$contentScrollerWrap.height(base.contentHeight);
            base.$content.height(base.options.rowRecords*base.options.rowHeight);
            base.$content.width(this.getRowWidth( elem ));
        },
        /**
         *
         *
        **/
        createRows : function( elem ){
            var that = this,
                base = that.getData( elem ),
                o,
                p,
                $row ,
                htmlString ,
                cellFormateFun ,
                tmp_htmlString ,
                isGetData = false ,
                isHoldMouseLeft ,
                range = base.renderRange,
                $emptyContentDescription;
            /**********************************************/
            base.renderRange = $.extend({} ,base.renderRange,range);
            this.setuprowRecords( elem );

            if(base.options.rowRecords === 0){
                $emptyContentDescription = '<div class="emptyContentDescription">'+base.options.emptyContentDescription+'</div>';
                base.$content.html($emptyContentDescription);
            }else{
                //if the row does not exist, we will call external function the get data
                if(base.options.dynamicRequestData.disabled === false && range.bottom <= base.options.rowRecords  ){
                    for(var i = range.top ; i < range.bottom ; i++){
                        if(!base.options.data[i]){
                            base.requestRange.top = i;
                            isGetData = true;
                            break;
                        }
                    }
                    for(var i = range.bottom-1 ; i > range.top ; i--){
                        if(!base.options.data[i]){
                            base.requestRange.bottom = i;
                            isGetData = true;
                            break;
                        }
                    }
                    if(isGetData){
                        base.options.dynamicRequestData.request(base);
                    }else{
                        this.appendRows( elem );
                        this.ajaxLoadingComplete(elem,{delay:0});
                    }
                }else{
                    this.appendRows( elem );
                    if(!isGetData){
                        this.ajaxLoadingComplete(elem,{delay:0});
                    }
                }
            }
        },
        /**
         *
         *
        **/
        dynamicRequestLoading : function( elem ){
            var that = this,
                base = that.getData( elem ),
                bufferHeight = base.options.scrollRowsBuffer * base.options.rowHeight;
            /**********************************************/
            if(base.vDiff >= bufferHeight ){
                this.ajaxLoadingAsScrollingDown( elem );
            }

            if(base.vDiff <= -1*bufferHeight){
                this.ajaxLoadingAsScrollingUp( elem );
            }
        },
        /**
         *
         *
        **/
        setuprowRecords : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if(base.options.rowRecords   < base.perPageRows){
                base.renderRange.bottom = base.perPageRows;
            }
            if(base.options.rowRecords   < base.perPageRows){
                base.$contentScrollerWrap.css('overflow-y','hidden');
            }else{
                base.$contentScrollerWrap.css('overflow-y','auto');
            }
        },
        /**
         *
         *
        **/
        appendRows : function(elem , showVisibleRangeFirst){
            var that = this,
                base = that.getData( elem ),
                arrRowsSelectedLength = base.arrRowsSelected.length,
                isHoldMouseLeft,
                bufferHeight = base.options.scrollRowsBuffer * base.options.rowHeight,
                options = base.options,
                cellFormateFun;
            /**********************************************/
            if(Math.abs(base.vDiff) < Math.abs(bufferHeight) ){
                showVisibleRangeFirst = false;
            }

            function onSelectedRows(e){

                var $e = $(e.elem);

                function switchHighLight(arrIdx , forceHighLight){
                    if(forceHighLight === true || !$e.hasClass(base.classUIselected)){
                        $e.addClass(base.classUIselected).children().filter(function () {
                            return base.classCustomCell.test($( this ).attr('class'));
                        }).addClass(base.classUIselected).addClass(base.classCellhasCustom);
                        base.arrRowsSelected.push(arrIdx);
                    }else{
                        $e.removeClass(base.classUIselected).children().filter(function () {
                            return base.classCustomCell.test($( this ).attr('class'));
                        }).removeClass(base.classUIselected).removeClass(base.classCellhasCustom);
                        base.arrRowsSelected = $.grep(base.arrRowsSelected,function(value){
                            return  value != arrIdx;
                        });
                        base.options.unSelected(base);
                    }
                }
                function switcSelectedData(arrIdx){
                    base.arrRowsSelected.push(arrIdx);
                }
                if(e.isHoldCtrlKey){
                    switchHighLight(e.index);

                }else if(e.isHoldShiftKey){
                    //remove all highlight
                    e.$content.find('div').removeClass(base.classUIselected);
                    //remove all selected data
                    base.arrRowsSelected = [];

                    if(e.end > e.start){
                        if(e.start < base.renderRange.top){
                            for(var i = base.renderRange.top ; i <= e.end ; i++){
                                $e = $('#'+base.prefixID+i , e.$content);
                                if($e){
                                    switchHighLight(i);
								}
                            }
                            for(var i = e.start ; i< base.renderRange.top ;i++){
                                switcSelectedData(i);
                            }
                        }else{
                            for(var i = e.start ; i <= e.end ; i++){
                                $e = $('#'+base.prefixID+i , e.$content);
                                if($e){
                                    switchHighLight(i);
								}
                            }
                        }
                    }else{
                        if(base.renderRange.bottom < e.start){
                            for(var i = base.renderRange.bottom ; i >= e.end ; i--){
                                $e = $('#'+base.prefixID+i , e.$content);
                                if($e){
                                    switchHighLight(i);
								}
                            }
                            for(var i = e.start ; i> base.renderRange.bottom ;i--){
                                switcSelectedData(i);
                            }
                        }else{
                            for(var i = e.end ; i <= e.start ; i++){
                                $e = $('#'+base.prefixID+i , e.$content);
                                if($e){
                                    switchHighLight(i);
								}
                            }
                        }
                    }
                }else{

                    base.arrRowsSelected = [];
                    $e.siblings().removeClass(base.classUIselected).children().filter(function () {
                        return base.classCustomCell.test($( this ).attr('class'));
                    }).removeClass(base.classUIselected).removeClass(base.classCellhasCustom);

                    switchHighLight(e.index , true);
                    /*
                    $e.addClass(base.classUIselected).children().filter(function () {
                        return base.classCustomCell.test($( this ).attr('class'));
                    }).addClass(base.classUIselected).addClass(base.classCellhasCustom);
                    base.arrRowsSelected.push(e.index);
                    */
                }
            }
            //var triggerMouseUp = false;
            function selectRowsHandleMouseUp(e){

                if($( this ).hasClass(base.classUIselected) && base.triggerMouseUp){
                    if(e.ctrlKey){
                        base.firstHitRowIndex = e.data.index;
                        onSelectedRows({elem:this,index:e.data.index,isHoldCtrlKey:true,$content:e.data.$content});
                    }else{
                        base.firstHitRowIndex = e.data.index;
                        onSelectedRows({elem:this,index:e.data.index,$content:e.data.$content});
                        base.options.onSelected(base);
                    }
                }
                base.triggerMouseUp = false;
            }
            function selectRowsHandleMouseDown(e){
                if(e.button === 2){
                    that.removeContextMenu(elem);
                }
                if(!$( this ).hasClass(base.classUIselected)){
                    base.triggerMouseUp = false;
                    if(e.ctrlKey && base.options.multiSelect.disabled === false){
                        base.firstHitRowIndex = e.data.index;
                        onSelectedRows({elem:this,index:e.data.index,isHoldCtrlKey:true,$content:e.data.$content});
                    }else if(e.shiftKey && base.options.multiSelect.disabled === false){

                        onSelectedRows({elem:this,index:e.data.index,$content:e.data.$content});
                        if(base.firstHitRowIndex === null){
                            base.firstHitRowIndex = e.data.index;
                        }else{
                            base.secondHitRowIndex = e.data.index;
                        }
                        if(base.firstHitRowIndex !== base.secondHitRowIndex && base.firstHitRowIndex !== null && base.secondHitRowIndex !== null){

                        onSelectedRows({
                                elem : this,
                                start : base.firstHitRowIndex,
                                end : base.secondHitRowIndex,
                                isHoldShiftKey : true,
                                $content:e.data.$content
                            });
                        }

                    }else{
                        base.firstHitRowIndex = e.data.index;
                        onSelectedRows({elem:this,index:e.data.index,$content:e.data.$content});
                    }
                    base.options.onSelected(base);

                    // right click event
                    if(e.button === 2){
                        e.data.that.contextMenu(elem,e);
                        e.preventDefault(e);
                        e.stopPropagation();
                        return false;
                    }
                }else{
                    if(e.button === 2 && $( this ).hasClass(base.classUIselected)){
                        e.data.that.contextMenu(elem,e);
                        e.preventDefault(e);
                        e.stopPropagation();
                        return false;
                    }
					base.triggerMouseUp = true;
                }
            }
            that.removeSiblingRows( elem );
            if(showVisibleRangeFirst === true){
                var range = base.visibleRange;
            }else{
                var range = base.renderRange;
            }
            $('> div.row-fake' , base.$content).remove();

            var tempResult = document.createElement('div'),
                tempStringArray = [],
                columnsSettings = base.options.columns,
                allData = base.options.data,
                cellTip = '';

                for( var i = range.top; i < range.bottom; i++ ){
                if( $( '#' + base.prefixID + i , base.$content ).length >0) continue;

                $row = '<div class="row" row="' + i + '" id="' + base.prefixID + i + '" style="top:'+ (i*base.options.rowHeight) + 'px;height:'+base.options.rowHeight+'px;line-height:'+base.options.rowHeight+'px">';

                for(var j = base.renderColumnRange.top ; j <= base.renderColumnRange.bottom ; j++){
                    p = columnsSettings[j].id;
                    if(base.options.showTip){
                        if(allData[i] != undefined){
                            cellTip = allData[i][p];
                            if(cellTip == null) cellTip = '';
                            
                        }else{
                            cellTip = '';
                        }
                        $row += '<div class="cell ' + base.elemId+ '_' + p + '" cell="' + j + '" title="'+cellTip+'"></div>';
                    }else{
                        $row += '<div class="cell ' + base.elemId+ '_' + p + '" cell="' + j + '" ></div>';
                    }
                }//End columns loop

                $row += '</div>';
                tempStringArray.push($row)

            }//End rows loop

            tempResult.innerHTML = tempStringArray.join("");

            var fragment = document.createDocumentFragment(),
                onHover = function(){
                    $( this ).filter(function(){
                        if( $( this ).hasClass(base.classUIselected) ){
                            return false;
                        }else if($( this ).hasClass(base.classRowFake)){
                            return false;
                        }else{
                            return true;
                        }
                    }).addClass(base.classUIhover).children().filter(function () {
                            return base.classCustomCell.test($( this ).attr('class'));
                        }).addClass(base.classUIhover);

                },
                unHover = function(){
                    $( this ).removeClass(base.classUIhover).children().filter(function () {
                        return base.classCustomCell.test($( this ).attr('class'));
                    }).removeClass(base.classUIhover);
                },
                bindContextMenu = function(e){
                    if(e.button === 2){ // right click event
                        $(e.currentTarget).contextMenu(base.options.contextMenu).off(e);
                    }
                },
                cellsFormatSettings = base.options.cellsFormat;

            while(tempResult.firstChild){
                $row = tempResult.firstChild;
                if( $row.tagName != 'DIV' ){
                    continue;
                }

                fragment.appendChild($row);
                $row = $($row);
                $row.hover(onHover, unHover);

                var recordIndex = parseInt($row.attr('row'));
                o = allData[recordIndex];

                if(base.options.contextMenu && !$row.hasClass(base.classRowFake)){
                    $row.on('mousedown', bindContextMenu );
                }

                this.setHighLight(elem,{$elem:$row,index: recordIndex,len:arrRowsSelectedLength});

                var $cells = $row.children('div');
                for(var j = base.renderColumnRange.top, k = 0; j <= base.renderColumnRange.bottom; j++, k++){
                    p = columnsSettings[j].id;
                    cellFormateFun = cellsFormatSettings[p];
                    $cell = $($cells[k]);

                    try{
                        if($.isFunction(cellFormateFun)){
                           htmlString = cellFormateFun({data:o,dataID:p,$row:$row,$cell:$cell,text:o[p]});
                        }else{
                           htmlString = o[p];
                        }
                        if( p != base.options.dragSelect.dragColumnId ) $cell.addClass( base.ClassUIdraggable );
                    }catch(e){
                        $row.addClass(base.classRowFake);
                        htmlString = "";
                    }
                    tmp_htmlString = base.options.cellsFormat._GLOBAL({data:o,dataID:p,$row:$row,$cell:$cell,text:htmlString});
                    if( typeof tmp_htmlString == 'string' ){
                        htmlString = tmp_htmlString;
                    }

                    if(p == base.options.dragSelect.dragColumnId && !$row.hasClass(base.classRowFake)){
                        if( typeof htmlString  == 'string' ){
                            htmlString = '<span class="'+base.ClassUIdraggable+'">' +htmlString + '</span>';
                        }else{
                            htmlString = $('<span class="'+base.ClassUIdraggable +'"></span>').append(htmlString);
                        }
                    }

                    if( typeof htmlString  == 'string' ){
                        $cells[k].innerHTML = htmlString;
                        if(base.options.showTip){
                            $cell.attr('title',htmlString)
                        }
                    }else{
                        $cell.html(htmlString);
                    }
                }

                if(base.options.rowSelect.disabled === false){
                    if( !$row.hasClass(base.classRowFake)){
                        if( o.disableSelection === true ){
                            $row.addClass(base.classRowFake);
                        }else{
                            $row.on('mouseup',{index: recordIndex,that:this,$content:base.$content},selectRowsHandleMouseUp)
                                .on('mousedown',{index: recordIndex,that:this,$content:base.$content},selectRowsHandleMouseDown);
                        }
                    }
                }
            }

            base.$content.append(fragment);

            that.ajaxLoadingComplete(elem,{delay:0});
            /*

            var empty_count = 0;
            for( var m = base.visibleRange.top ;  m < base.visibleRange.bottom ;  m++){
                if( $('div.row[row='+m+']' , base.$content).length == 0){
                    empty_count++;
                }
            }

            if(empty_count != 0){
                var scrollDiff = parseInt( base.contentHeight/2 , 10);
                setTimeout(function(){
                    base.absScrollDiff = scrollDiff;
                    that.appendRow( elem );
                },1500);
            }
            //render buffer rows
            if(showVisibleRangeFirst === true){
                setTimeout(function(){
                    that.appendRows( elem );
                },10);
            }
            */
        },
        /**
         *
         *
        **/
        emptyContent : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.arrRowsSelected = [];
            base.$content.empty();
            base.options.data = [];
        },
        /**
         *
         *
        **/
        removeContent : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            try{
                base.$content.height(0);
                base.arrRowsSelected = [];
                base.$content.empty();
            }catch(e){
            }
        },
        /**
         *
         *
        **/
        renderContent : function(elem,options){
            var that = this,
                base = that.getData( elem );
            /**********************************************/

            if(options){

                base.$headerScrollerWrap[0].scrollLeft = 0;
                base.$contentScrollerWrap[0].scrollLeft = 0;
                base.$contentScrollerWrap[0].scrollTop = 0;

                base.options = $.extend(true ,{}, base.options , options);
                if(base.options.rowRecords  < base.perPageRows || options.data.length  < base.perPageRows){
                    base.options.data = [];
                }

                if( options.data && base.options.dynamicRequestData.disabled === false){
                    this.removeContent( elem );
                    base.options.data = [];
                }

                base.options.data = $.extend(true ,[], options.data);
                base.options.rowRecords   = options.rowRecords;
                base.renderRange.top = 0;
                base.renderRange.bottom = Math.ceil((base.absTopPosition+base.contentHeight)/base.options.rowHeight)+base.options.scrollRowsBuffer;

                base.scrollLeft = 0;

                this.setuprowRecords( elem );
                base.scrollLeft = 0;
                this.renderContentCells( elem );
            }else{
                 //only refresh content
                var previousColumnRangeBottom = base.renderColumnRange.bottom;
                var previousColumnRangeTop = base.renderColumnRange.top;
                base.scrollRight = base.scrollLeft + base.$contentScrollerWrap.outerWidth();
                this.getVisibleColumnRange( elem );

                this.renderContentCells( elem );

            }
            this.ajaxLoadingComplete(elem,{delay:0});
        },
        /**
         *
         *
        **/
        removeSiblingRows : function( elem ){
            var that = this,
                base = that.getData( elem ),
                top = base.renderRange.top,
                bottom = base.renderRange.bottom,
                checkpointTop ,
                checkpointBottom;
            /**********************************************/

            if (base.absScrollDiff > (base.contentHeight + base.options.scrollRowsBuffer*base.options.rowHeight) ){
                base.$content.empty();
            }
            if(base.absScrollDiff < base.contentHeight){
                checkpointTop = top-base.perPageRows;
                checkpointBottom = top-base.perPageRows;
                $.each( $('div.row' , base.$content) , function(i,o){
                    if( $(o).attr('row') < top || $(o).attr('row') > bottom ){
                        $(o).remove();
                    }
                });
            }
        },
        /**
         *
         *
        **/
        setHighLight : function(elem,e){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if(e.len !== 0){
                if($.inArray(e.index,base.arrRowsSelected) != -1){
                    e.$elem.addClass(base.classUIselected).children().filter(function () {
                        return base.classCustomCell.test($( this ).attr('class'));
                    }).addClass(base.classUIselected).addClass(base.classCellhasCustom);

                }
            }
        },
        /**
         *
         *
        **/
        contextMenu : function(elem,e){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.options.onContextMenu(base,e);
        },
        /**
         *
         *
        **/
        columnReorderable : function( elem ){
            var that = this,
                base = that.getData( elem ),
                $ghostColumn,
                $placeholder,
                ghostOffsetX,
                headerOffsetLeft = 0;
            /**********************************************/
            base.$header.children()
                .on( "draginit", function( ev, dd ){
                    that.removeContextMenu(elem);
                    if(
                        $( ev.target ).hasClass( 'resizable-handle' )
                    ){
                        return false;
                    }
                    headerOffsetLeft = base.$header.offset().left;

                    //Fix offsetX and offsetY undefined in Firefox.
                    ghostOffsetX = ev.offsetX || ev.pageX - $(this).offset().left;

                    //Not very beautiful solution.
                    $.drop({
                        mode : 'overlap',
                        tolerance: function( event, proxy, target ){
                            var test = event.pageX > ( target.left + target.width / 2 );
                            $.data( target.elem, "drop+reorder", test ? "insertAfter" : "insertBefore" );
                            return this.contains( target, [ event.pageX, event.pageY ] );
                        }
                    });
                })
                .on( "dragstart", function( ev, dd ){
                    var $drag = $( this );
                    $ghostColumn = $drag.clone()
                        .css({
                            position: 'absolute',
                            zIndex: 5
                        })
                        .addClass( 'ui-sortable-helper' )
                        .appendTo( base.$header );
                    $placeholder = $drag.clone().css( 'visibility' , 'hidden' ).addClass( 'placeholder' ).insertAfter( $drag );
                    $drag.css({
                        display: 'none'
                    });
                })
                .on( "drag", function( ev, dd ){
                    $ghostColumn.css({
                        left : ev.clientX - ghostOffsetX - headerOffsetLeft
                    });


                    var drop = dd.drop[ 0 ],
                    method = $.data( drop || {}, "drop+reorder" );
                    if ( drop && ( drop != dd.current || method != dd.method ) ){
                        $placeholder[ method ]( drop );
                        $( this )[ method ]( drop );
                        dd.current = drop;
                        dd.method = method;
                        dd.update();
                    }
                })
                .on( "dragend", function( ev, dd ){
                    $( this ).css({
                        display: 'block'
                    });
                    $placeholder.remove();
                    $ghostColumn.remove();

                    var columns = base.options.columns;
                    var newColumns = [];
                    var columnOrder , $columns = base.$header.children() , newColumnsIdArray = [];

                    $.each( $columns, function( i, o ){
                        columnOrder = $( o ).attr( 'name' );
                        newColumnsIdArray.push( columnOrder );
                    });
                    //if change we will apply it
                    if( JSON.stringify( base.columnsIdArray ) !== JSON.stringify( newColumnsIdArray ) ){
                        base.columnsIdArray = newColumnsIdArray;
                        $.each( newColumnsIdArray , function( i, o ){
                            newColumns.push( columns[ o.replace('column_','') ] );
                        });
                        base.options.columns = newColumns;
                        that.renderHeaderColumns( elem );
                        base.options.columnReorder.stop( base.options );
                    }
                })
                .on( "dropinit", function( ev, dd ){
                    return !( this == dd.drag );
                })
                .on( "dropend", function( ev, dd ){

                });

        },

        /**
         *
         *
        **/
        columnSortable : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if(base.options.sortColumnId === null) base.options.sortColumnId = base.options.columns[0].id;

            var columnElems = base.$header.children() , column;
            $.each(columnElems , function(i,o){

                column = base.options.columns[i];
                //set up indicator images
                if(column.id === base.options.sortColumnId){
                    that.insertIndicatorImages(elem,{o:o,column:column,$header:base.$header});
                }
                $(o).on('click',{o:o,column:column,i:i,$header:base.$header},function(e){
                    if( $(e.target).hasClass('resizable-handle')){
                        return false;
                    }

                    base.options.sortColumnId = e.data.column.id;
                    if(e.data.column.sortAsc){
                        e.data.column.sortAsc = base.options.columns[e.data.i].sortAsc = false;
                    }else{
                        e.data.column.sortAsc = base.options.columns[e.data.i].sortAsc = true;
                    }
                    that.insertIndicatorImages(elem,{o:e.data.o,column:e.data.column,$header:e.data.$header});
                    base.options.columnSort.stop(base.options,e.data.column.sortAsc);
                });
            });
        },
        /**
         *
         *
        **/
        insertIndicatorImages : function(elem , e){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            var classIndicator;
            if(e.column.sortAsc){
                classIndicator = base.classIndicatorAsc;
            }else{
                classIndicator = base.classIndicatorDesc;
            }
            $('.indicator' , e.$header).remove();
            $('<span class="indicator"/>').addClass(classIndicator).insertAfter($(e.o).find('span'));
        },
        /**
         *
         *
        **/
        appendRow : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            this.getRenderAndVisibleRange( elem );
            if(base.renderRange){
                this.createRows( elem );
                base.absScrollDiff = 0;
            }
        },
        /**
         *
         *
        **/
        getRenderAndVisibleRange : function( elem ){
            var that = this,
                base = that.getData( elem ),
                top ,
                bottom ,
                maxBottomLength ;
            /**********************************************/
            base.perPageRows =  Math.ceil(base.contentHeight/base.options.rowHeight);
            if(base.absScrollDiff < base.options.rowHeight){
				return false;
			}
            top = Math.floor((base.absTopPosition)/base.options.rowHeight)-base.options.scrollRowsBuffer;
            if(top <0){
				top = 0;
			}
            bottom = Math.ceil((base.absTopPosition+base.contentHeight)/base.options.rowHeight)+base.options.scrollRowsBuffer;

            maxBottomLength = base.options.rowRecords;
            if (bottom >= maxBottomLength){
                bottom = maxBottomLength;
            }

            base.renderRange = {
                top : top,
                bottom : bottom
            };
            this.getVisibleRange( elem );
        },
        /**
         *
         *
        **/
        getVisibleRange : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.visibleRange.top =  Math.max( Math.ceil( base.scrollTop / base.options.rowHeight ) - 1 , 0) ;
            base.visibleRange.bottom =  Math.min( Math.ceil( (base.scrollTop+base.$contentScrollerWrap.height()) / base.options.rowHeight ) + 1 , base.options.rowRecords);
            return base.visibleRange;
        },
        rowSelectable : function( elem ){
            var that = this,
                base = that.getData( elem ),
                isRowSelectable= false,
                isRowDraggable= false,
                $containment;
            /**********************************************/
            if(
                base.options.rowSelect.disabled === true ||
                base.options.multiSelect.disabled === true ||
                base.options.dragSelect.disabled === true
            ){
                base.$contentScrollerWrap
                    .on('mousedown',function(){
                        return false;
                    });
                return false;
            }

            base.$contentScrollerWrap
                .on('mousedown',function(ev){
                    that.removeContextMenu(elem);
                    if( ev.which != 1 ){
                        return false;
                    }
                })
                .on( "draginit", function( ev , dd ){
                    var $target = $( ev.target );
                    /*
                     *  Prevent click event from scroll bar
                     *  which mousebutton is pressed. (0 = Any Button, 1 = Left Button, 2 = Middle Button, 3 = Right Button)
                    */
                    if( ev.which != 1 ){
                        return false;
                    }
                    //Sets global drop options. Not an excellent solution to cancel tolerance option.
                    $.drop({
                        mode: 'overlap',
                        tolerance: null
                    });
                    if( base.options.rowSelect.disabled === true ) return false;
                    base.$content.children()
                        .off( "dropstart" )
                        .off( "drop" )
                        .off( "dropend" );

                    if(base.triggerMouseUp == true){
                        isRowDraggable = true;
                        if(base.options.dragRows.disabled == true){
                            if( $target.parents().hasClass( base.ClassUIdraggable ) || $target.hasClass( base.ClassUIdraggable )){
                                isRowSelectable = false;
                            }else{
                                isRowSelectable = true;
                            }
                        }else{
                            isRowSelectable = false;
                        }
                    }else{
                        isRowDraggable = false;
                        isRowSelectable = true;

                        if( $target.parents().hasClass( base.ClassUIdraggable ) || $target.hasClass( base.ClassUIdraggable )){
                            isRowDraggable = true;
                            isRowSelectable = false;
                        }
                    }

                    if( $target.hasClass( 'contentScrollerWrap' ) || $target.parents().hasClass( base.classRowFake )){
                        isRowSelectable = true;
                        isRowDraggable = false;
                    }
                    if( $target.hasClass( base.ClassUIdraggable ) &&  !$target.parent().hasClass( base.classRowFake ) ){
                        isRowSelectable = false;
                    }

                    if(base.options.dragRows.disabled == true){
                        isRowDraggable = false;
                    }

                    if(isRowSelectable){
                        //Allow dragged target
                        //fix IE bug. Prohibit click scroll bar to drag.
                        var offsetX = ev.offsetX,
                            offsetY = ev.offsetY;

                        if( typeof ev.offsetX == 'undefined' ){ // it works for Firefox
                            var pos = base.$contentScrollerWrap.offset();
                            offsetX = ev.pageX - pos.left;
                            offsetY = ev.pageY - pos.top;
                        }

                        if( offsetX > $( ev.currentTarget )[ 0 ].clientWidth ){
                            return false;
                        }
                        if( offsetY > $( ev.currentTarget )[ 0 ].clientHeight ){
                            return false;
                        }

                        //Attach dropped targets(rows) for the dd.proxy interaction.
                        that.getVisibleRange( elem );
                        for( var i = base.visibleRange.top; i <= base.visibleRange.bottom; i++ ){
                            $('#'+base.prefixID+i , base.$content).filter(function(){
                                    return !$(this).hasClass(base.classRowFake);
                                })
                                .on( "dropstart", function( ev, dd ){
                                    $( this ).addClass( base.classUIselectedd ).children().filter(function () {
                                        return base.classCustomCell.test( $( this ).attr( 'class' ) );
                                    }).addClass( base.classUIselectedd, base.classCellhasCustom );
                                })
                                .on( "drop", function( ev, dd ){
                                    $( this ).addClass( base.classUIselected ).children().filter(function () {
                                        return base.classCustomCell.test( $( this ).attr( 'class' ) );
                                    }).addClass( base.classUIselected, base.classCellhasCustom );
                                    var rowIndex = parseInt( $( this ).attr( 'row' ), 10 );
                                    if( $.inArray( rowIndex, base.arrRowsSelected ) === -1 ){
                                        base.arrRowsSelected.push( rowIndex );
                                    }
                                })
                                .on( "dropend", function( ev, dd ){
                                    $( this ).removeClass( base.classUIselectedd ).children().removeClass( base.classUIselectedd, base.classCellhasCustom );
                                });
                        }
                        $.drop({ multi: true, mode: 'overlap' });
                    }
                    if(isRowDraggable && !base.options.dropRows.disabled){
                        $(base.options.dropRows.target)
                            .on( "dropstart", function( ev, dd){
                                if( !$(dd.proxy).hasClass( base.options.dragRows.proxyClassName ) ) return false;
                                $( this ).addClass( base.options.dropRows.active );
                            })
                            .on( "drop", function( ev, dd ){
                                base.options.dropRows.drop( ev, $(this) );
                            })
                            .on( "dropend", function(){
                                $( this ).removeClass( base.options.dropRows.active );

                            });
                        $.drop({ multi: false, mode: true});
                    }
                })
                .on( "dragstart", function( ev, dd ){
                    var containment = base.options.dragRows.containment;

                    if(isRowSelectable){
                        if( ev.ctrlKey === false ){
                            base.arrRowsSelected = [];
                            base.$content.children()
                                .removeClass( base.classUIselected )
                                .children()
                                .filter(function(){
                                    return base.classCustomCell.test( $( this ).attr( 'class' ) );
                                })
                                .removeClass( base.classUIselected )
                                .addClass( base.classCellhasCustom );
                        }
                        return $( '<div />' )
                                .addClass( base.options.dragSelect.proxyClassName )
                                .appendTo( 'body' );
                    }

                    if(isRowDraggable){
                        $containment = ( $( containment ).length > 0 ) ? $( containment ) : base.$elem[ containment ]();
                        return $( '<div />' )
                                .addClass( base.options.dragRows.proxyClassName )
                                .html( base.options.dragRows.text( base.arrRowsSelected ) )
                                .appendTo( 'body' );
                    }

                    if(isRowDraggable === false && isRowSelectable === false){
                        base.triggerMouseUp = false;
                    }
                })
                .on( "drag", { distance:base.options.dragRows.distance }, function( ev, dd ){
                    if(isRowSelectable){
                        var $proxy = $( dd.proxy ),
                            _top = $( this ).offset().top,
                            _height = $( this ).height(),
                            _left = $( this ).offset().left,
                            _width = $( this ).width(),
                            proxy_top = Math.min( ev.pageY, dd.startY ),
                            proxy_height = Math.abs( ev.pageY - dd.startY ),
                            proxy_left = Math.min( ev.pageX, dd.startX ),
                            proxy_width = Math.abs( ev.pageX - dd.startX ),
                            adjverticalBorder = parseInt( $proxy.css( 'borderTopWidth' ) ,10 ) + parseInt( $proxy.css( 'borderBottomWidth' ), 10 ),
                            adjHorizontalBorder = parseInt( $proxy.css( 'borderLeftWidth' ) ,10 ) + parseInt( $proxy.css( 'borderRightWidth' ), 10 );
                        //Restrain selection over parent containment vertically.
                        if(
                            ( _top > proxy_top ) ||
                            ( _top + _height ) < ( proxy_top + proxy_height )
                        ){
                            if( _top > proxy_top ){
                                $proxy.css({
                                    top: _top,
                                    height: Math.abs( _top - dd.startY )
                                });
                            }
                            if( ( _top + _height ) < ( proxy_top + proxy_height ) ){
                                $proxy.css({
                                    height: _top + _height - proxy_top - adjverticalBorder
                                });
                            }
                        }else{
                            $proxy.css({
                                top: proxy_top,
                                height: proxy_height
                            });
                        }
                        //Restrain selection over parent containment horizontally.
                        if(
                            ( _left > proxy_left ) ||
                            ( _left + _width ) < ( proxy_left + proxy_width )
                        ){
                            if(_left > proxy_left ){
                                $proxy.css({
                                    left: _left,
                                    width: Math.abs( _left - dd.startX )
                                });
                            }
                            if( ( _left + _width ) < ( proxy_left + proxy_width ) ){
                                $proxy.css({
                                    width: _left + _width - proxy_left - adjHorizontalBorder
                                });
                            }
                        }else{
                            $proxy.css({
                                left: proxy_left,
                                width: proxy_width
                            });
                        }
                    }
                    if(isRowDraggable){
                        var $proxy              = $( dd.proxy ),

                            proxy_top           = ev.pageY,
                            proxy_left          = ev.pageX,
                            proxy_height        = $proxy.outerHeight(),
                            proxy_width         = $proxy.outerWidth(),

                            proxyMarginTop      = parseInt($proxy.css('marginTop'),10),
                            proxyMarginLeft     = parseInt($proxy.css('marginLeft'),10),
                            proxyMarginBottom   = parseInt($proxy.css('marginBottom'),10),
                            proxyMarginRight    = parseInt($proxy.css('marginRight'),10),

                            containmentTop          = $containment.offset().top,
                            containmentLeft         = $containment.offset().left,
                            containmentHeight       = $containment.outerHeight(),
                            containmentWidth        = $containment.outerWidth();
                        //Restrain draggable element over parent containment horizontally.
                        if( proxy_top < ( containmentTop  - proxyMarginTop ) ){
                            proxy_top = containmentTop - proxyMarginTop;
                        }
                        if( proxy_left < ( containmentLeft  - proxyMarginLeft ) ){
                            proxy_left = containmentLeft - proxyMarginLeft;
                        }

                        //Restrain draggable element over parent containment vertically.
                        if( ( proxy_top + proxy_height + proxyMarginBottom ) > ( containmentTop + containmentHeight ) ){
                            proxy_top = containmentTop + containmentHeight - proxy_height - proxyMarginBottom;
                        }
                        if( ( proxy_left + proxy_width + proxyMarginRight ) > ( containmentLeft + containmentWidth ) ){
                            proxy_left = containmentLeft + containmentWidth - proxy_width - proxyMarginRight;
                        }

                        $proxy.css({
                            top: proxy_top,
                            left: proxy_left
                        });
                    }
                })
                .on( "dragend", function( ev, dd ){
                    if(isRowSelectable){
                        //Rrmove the dragged element
                        $( dd.proxy ).remove();
                    }
                    if(isRowDraggable){
                        //Rrmove the dragged element
                        $( dd.proxy ).fadeOut( base.options.dragRows.fadeOutDuration, function(){
                                $( this ).remove();
                        });
                    }
                    //Removes event handlers dropstart, drop, dropend
                    if(isRowSelectable){
                        base.$content.children()
                            .off( "dropstart" )
                            .off( "drop" )
                            .off( "dropend" );
                    }

                    if(isRowDraggable){
                        $(base.options.dropRows.target)
                            .off( "dropstart" )
                            .off( "drop" )
                            .off( "dropend" );
                    }

                    $.drop({ multi: false, mode: 'overlap'});
                    isRowSelectable = false;
                    isRowDraggable = false;

                    base.options.dragSelect.stop( base );
                });
        },
        /**
         *
         *
        **/
        registerRowsData : function(elem,options){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            //  overwrite row offset
            if(options.rowOffset) base.rowOffset = options.rowOffset;
            if(options.empty) base.options.data = [];
            var offset = base.rowOffset;
            if(typeof options.top != 'undefined' && options.top >= 0){
                offset = offset + options.top;
                $.each(options.data, function(i,o){
                    base.options.data[i+offset] = $.extend(true , {},o );
                });
            }
            else {
                $.each(options.data, function(i,o){
                    base.options.data.push(o);
                });
                base.options.rowRecords = base.options.data.length;
            }
        },
        /**
         *
         *
        **/
        adjHeight : function(elem,h){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if(h < 0) return false;
            if(!h){
                // In IE8, base.$elem.height() may get a strange number.
                // If it happened we could use native properties (ex: offsetHeight) to get height.
                h = parseInt( base.$elem.height() , 10);
            }else{
                base.$elem.height(h);
            }
            base.$contentScrollerWrap.height(h- base.headerHeight );
            base.contentHeight = h- base.headerHeight ;

            base.absScrollDiff = h;
            this.appendRow( elem );
            this.getRenderAndVisibleRange( elem );
        },
        /**
         *
         *
        **/
        adjWidth : function(elem,w){
            var that = this,
                base = that.getData( elem),
                columns = base.options.columns;
            /**********************************************/
            if(w< 0) return false;
            if(!w){
                w = parseInt( base.$elem.parent().width() , 10);
            }
            base.$elem.width(w);

            if(base.options.columnsType == 1){
                this.getVisibleColumnRange( elem );
                this.createCells( elem );
            }else{
                this.adjColumnPercentageWidth(elem);
                this.setHeaderColumnWidth( elem );
                this.setStyleRule( elem );
                this.setupContentWidth( elem );
            }
        },
        /**
         *
         *
        **/
        ajaxLoadingAsScrollingUp : function(elem , $topElem){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.$elem = $( elem );
            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            var $ajaxLoading = $('<div/>').addClass('ajax-loading').css('background-image','none').appendTo(base.$elem);
            var $message = $('<div/>').addClass('message').appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            var top = base.$header.height();
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
        ajaxLoadingAsScrollingDown : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.$elem = $( elem );
            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            var $ajaxLoading = $('<div/>').addClass('ajax-loading').css('background-image','none').appendTo(base.$elem);
            var $message = $('<div/>').addClass('message').appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            var height = $message.height()*2;
            var top = base.$contentScrollerWrap[0].clientHeight + base.$header.height() - height;
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
        ajaxLoading : function(elem,options){
            var that = this,
                base = that.getData( elem ),
                text = '';
            /**********************************************/
            

            base.$elem = $( elem );
            if( base.$elem.find('.ajax-loading').length > 0 ){
                return false;
            }
            if(options){
                text = options.text;
            }
            var $ajaxLoading = $('<div/>').addClass('ajax-loading').appendTo(base.$elem);
            var $message = $('<div/>').addClass('message').text(text).appendTo($ajaxLoading);
                this.disableSelection(elem , $ajaxLoading);
            $message.css(
                {
                    left:($ajaxLoading.width()-$message.width())/2,
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
                base = that.getData( elem );
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
        getSelected : function(elem,func){
            var that = this,
                base = that.getData( elem ),
                sortNumber = function(a,b){return a-b;},
                e = base.arrRowsSelected;
            /**********************************************/
            if(e){
                func(e.sort(sortNumber));
            }else{
                func([]);
            }
        },
        /**
         *
         *
        **/
        getSelectedInfo : function(elem,func){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            var sortNumber = function(a,b){return a-b;},
                e = base.arrRowsSelected;
            var clients_info =[];
            $.each(e.sort(sortNumber),function(o,index){
                clients_info.push( base.options.data[index] );
            });
            func(clients_info);
        },
        /**
         *
         *
        **/
        createCells : function( elem ){
            var that = this,
                base = that.getData( elem ),
                columns = base.options.columns ,
                columnsLength = columns.length ,
                o ,
                p ,
                $row ,
                htmlString ,
                cellFormateFun ,
                tmp_htmlString ,
                isHoldMouseLeft;
            /**********************************************/
            if(base.options.rowRecords !== 0){
                for(var i = base.renderRange.top ; i < base.renderRange.bottom ; i++){
                    o = base.options.data[i];
                    $row = $('#'+base.prefixID+i , base.$content);
                    if($row.children().length == columnsLength) continue;
                    for(var j = base.renderColumnRange.top ; j <= base.renderColumnRange.bottom ; j++ ){
                        if( $row.find('> div[cell='+j+']').length != 0 ) continue;
                        p = columns[j];
                        cellFormateFun = base.options.cellsFormat[p.id];
                        $cell = $('<div/>');
                        try{
                            if($.isFunction(cellFormateFun)){
                               htmlString = cellFormateFun({data:o,dataID:p.id,$row:$row,$cell:$cell,text:o[p.id]});
                            }else{
                                htmlString = o[p.id];
                            }
                            if(p.id != base.options.dragSelect.dragColumnId) $cell.addClass(base.ClassUIdraggable);
                        }catch(e){
                            htmlString = "";
                        }
                        tmp_htmlString = base.options.cellsFormat._GLOBAL({data:o,dataID:p.id,$row:$row,$cell:$cell,text:htmlString});
                        if(typeof(tmp_htmlString) === 'string'){
                            htmlString = tmp_htmlString;
                        }
                            
                        $cell
                            .addClass('cell')
                            .attr('cell' , j)
                            .addClass(base.elemId+'_'+p.id)
                            .html(htmlString);
                        if(htmlString != '' && base.options.showTip){
                            $cell.attr('title',htmlString)
                        }
                        $row.append($cell);
                        if(o){
                            if(o.disableSelection === true){
                                $row.addClass(base.classRowFake);
                            }
                        }
                        if(p.id == base.options.dragSelect.dragColumnId ){
                            if( typeof htmlString  === 'string' ){
                                htmlString = '<span class="'+base.ClassUIdraggable+'">' +htmlString + '</span>';
                            }else{
                                htmlString = $('<span class="'+base.ClassUIdraggable +'"></span>').append(htmlString);
                            }

                            $cell.html( htmlString );
                        }
                    }
                    //fix it heightlight
                    $('.'+base.classUIselected,base.$content).children().filter(function () {
                                return base.classCustomCell.test($( this ).attr('class'));
                    }).addClass(base.classUIselected).addClass(base.classCellhasCustom);
                }
            }
        },
        /**
         *
         *
        **/
        scrollTo : function(elem,options){
            var that = this,
                base = that.getData( elem ),
                opts = $.extend({} , {x:false,y:false} , options);
            /**********************************************/

            if(opts.x !== false){
                base.$headerScrollerWrap[0].scrollLeft = opts.x;
                base.$contentScrollerWrap[0].scrollLeft = opts.x;
            }
            if(opts.y !== false){
                base.$contentScrollerWrap[0].scrollTop = opts.y;
                if(opts.y === 0){
                    this.setupDefaultRange( elem );
                }
            }
        },
        /**
         *
         *
        **/
        renderHeader : function(elem,options){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.options.columns = options.columns;
            base.options.sortColumnId = options.sortColumnId;
            base.options.autoFitColumn = options.autoFitColumn;
            if(options.rowRecords){
                base.options.rowRecords = options.rowRecords;
            }
            this.removeHeader( elem );
            this.renderHeaderColumns( elem );

            if( base.options.columnResize.disabled === false){
                //this.columnResizable( elem );
            }
            if( base.options.columnReorder.disabled === false){
                //this.columnReorderable( elem );
            }
            if( base.options.columnSort.disabled === false){
                //this.columnSortable( elem );
            }
        },
        /**
         *
         *
        **/
        removeHeader : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.$header.empty();
        },
        /**
         *
         *
        **/
        refresh : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            if( base.options.dynamicRequestData.disabled === false){
                base.options.data = [];
            }

            var previousColumnRangeBottom = base.renderColumnRange.bottom;
            var previousColumnRangeTop = base.renderColumnRange.top;
            base.scrollRight = base.scrollLeft + base.$contentScrollerWrap.outerWidth();
            this.getVisibleColumnRange( elem );

            this.renderContentCells( elem );

        },
        /**
         *
         *
        **/
        setOptions : function(elem,options){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            $.extend(true , base.options, options);
        },
        /**
         *
         *
        **/
        getRenderRange : function(elem,func){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            this.getRenderAndVisibleRange( elem );
            func(base.renderRange);
        },
        /**
         *
         *
        **/
        removeRegisterRowsData : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.options.data = [];
        },
        /**
         *
         *
        **/
        cancelRowSelected : function( elem ){
            var that = this,
                base = that.getData( elem );
            /**********************************************/
            base.arrRowsSelected = [];
        },
        adjColumnPercentageWidth : function(elem){
            var that = this,
                base = that.getData(elem),
                columns = base.options.columns,
                gridWidth = 0,
                totalPercentageWidth = 0,
                totalWidth = 0,
                hasUndefinedPercentageWidth = false;

            if (base.options.rowRecords >= base.perPageRows) {
                gridWidth = base.$elem.width() - this.scrollbarWidth(elem);
            }else{
                gridWidth = base.$contentScrollerWrap.outerWidth();
            }

             $.each(columns, function(i, o) {
                 if(o.percentageWidth != undefined){
                     var percentageWidth = parseInt(o.percentageWidth.replace('%',''));
                     o.width = Math.floor(gridWidth * percentageWidth / 100);
                     totalPercentageWidth += percentageWidth;
                     totalWidth += o.width;
                 }else{
                     hasUndefinedPercentageWidth = true;
                 }
             });

            if(!hasUndefinedPercentageWidth && totalPercentageWidth == 100){
                if(gridWidth > totalWidth){
                    columns[columns.length - 1].width += (gridWidth - totalWidth);
                }
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
        removeRegisterRowsData : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.removeRegisterRowsData(elem,args[0]);
        },
        /**
         *
         *
        **/
        registerRowsData : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.registerRowsData(elem,args[0]);
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
        appendRows : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.appendRows(elem,args[0]);
        },
        /**
         *
         *
        **/
        adjHeight : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.adjHeight(elem,args[0]);
        },
        /**
         *
         *
        **/
        adjWidth : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.adjWidth(elem,args[0]);
        },
        /**
         *
         *
        **/
        emptyContent : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.emptyContent( elem );
        },
        /**
         *
         *
        **/
        removeContent : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.removeContent( elem );
        },
        /**
         *
         *
        **/
        getSelectedInfo : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getSelectedInfo(elem , args[0]);
        },
        /**
         *
         *
        **/
        getSelected : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getSelected(elem , args[0]);
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
        renderHeader : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.renderHeader(elem , args[0]);
        },
        /**
         *
         *
        **/
        renderContent : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.renderContent(elem , args[0]);
        },
        /**
         *
         *
        **/
        refresh : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.refresh( elem );
        },
        /**
         *
         *
        **/
        setOptions : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.setOptions(elem , args[0] );
        },
        /**
         *
         *
        **/
        getOptions : function(elem, args){
            return $.fn[PLUGIN_NAME].internalMethods.getOptions(elem, args[0]);
        },
        /**
         *
         *
        **/
        getRenderRange : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.getRenderRange(elem , args[0]);
        },
        /**
         *
         *
        **/
        setupDefaultRange : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.setupDefaultRange( elem );
        },
        /**
         *
         *
        **/
        cancelRowSelected : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.cancelRowSelected(elem , args[0]);
        },
        removeContextMenu : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.removeContextMenu(elem);
        }
    };
    $.fn[PLUGIN_NAME].defaults = $.extend( true, {}, {
        // TODO: Default options for plugin.
        onSelected : function(base){},
        onContextMenu : function(base,event){},
        unSelected : function(base){},
        scrollRowsBuffer : 100,
        rowHeight : 24,
        autoFitColumn: false,
        showTip: true,
        emptyContentDescription: '',
        columnReorder : {
            disabled : false,
            stop : function(base){
            }
        },
        columnResize :{
            disabled : false,
            stop : function(base){
            }
        },
        columnSort :{
            disabled : false,
            stop : function(base,o){
            }
        },
        dynamicRequestData : {
            disabled : true,
            request : function(base){
            }
        },
        cellsFormat : {
            _GLOBAL : function(o) {
                return o.text;
            }
        },
        rowSelect:{
            disabled : false
        },
        multiSelect:{
            disabled : false
        },
        dragSelect:{
            disabled : false,
            proxyClassName : 'dd-proxy-selecting',
            dragColumnId : null,
            stop : function(base){
            }
        },
        dragRows : {
            disabled : true,
            proxyClassName : 'dd-proxy-dragging',
            distance : 5,
            fadeOutDuration : 'fast',
            containment : 'parent',
            text : function(r){
                return 'Move '+r.length+' target(s) ';
            }
        },
        dropRows : {
            disabled : true,
            target : 'span.node-icons-text',
            active : 'ui-state-active',
            drop : function( ev, ui ){
            }
        },
        sortColumnId : null,
        elemHeight : null,
        columnsType: 1,    //1: fixed width, 2: percentage width
        columnsMinWidth : 9,
        columnDefaults: {
            width: 80
        }
    });
    $.fn[PLUGIN_NAME].base = $.extend({}, {
        prefixID: '',
        scrollLeft: 0,
        ss1:  null,
        columnsIdArray: [],
        columnWidthdiff : 9,
        scrollTop : 0,
        prevScrollTop : 0,
        prevScrollLeft : 0,
        absScrollDiff : 0,
        scrollRenderRowsTimeout : 150,
        absTopPosition : 0,
        minWidth : 0,
        classCustomCell : /cell-\w+/i,
        classCellhasCustom : 'cell-custom',
        arrRowsSelected : [],
        renderColumnRange : {
            top : '',
            bottom : ''
        },
        requestRange : {
            top:0,
            bottom:0
        },
        visibleRange :{
            top: 0,
            bottom :0
        },
		headerHeight: 25,
        classUIselected : "trend-ui-selected",
        classUIselectedd : "trend-ui-selectedd",
        ClassUIdraggable : 'dd-draggable',
        classUIhover : "trend-ui-hover",
        classRowFake : "row-fake",
        triggerMouseUp : false,
        classIndicatorAsc : "asc",
        classIndicatorDesc : "desc",
        rowOffset : 0,
        ajaxLoadingRemoveTimeout : 100
    });
})(jQuery);