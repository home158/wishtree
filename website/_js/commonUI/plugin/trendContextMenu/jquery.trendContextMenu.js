/*
 *
 * Depends:
 *      jquery-1.8.0.js
 *      jquery.contextMenu.button.css
 *      jquery.contextMenu.css
 * Example:
 *
 * Copyright (c) 1989-2013 Trend Micro Incorporated, All Rights Reserved
*/
(function($) {
    var PLUGIN_NAME = "contextMenu";
    $.fn[PLUGIN_NAME] = function(methodOrOptions) {
        if (typeof methodOrOptions == "string") {
            var publicMethods = $.fn[PLUGIN_NAME].publicMethods[methodOrOptions];
            if (publicMethods) {
                var args = Array.prototype.slice.call(arguments, 1);
                return this.each(function() {
                    publicMethods(this, args);
                });
            } else {
                return this[PLUGIN_NAME](methodOrOptions, args);
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
                base.options.theme="theme-"+base.options.theme,
                elem.contextmenu = this;
            /**********************************************/
            base.$appendTo = $(base.options.appendTo);
            if(base.options.buttonMode === true){
                this.displayContextmenuByDefault(elem);
            }else{
                base.$elem.bind('contextmenu',{elem:elem,that:this},this.showContextmenu);
            }
        },
        /**
         *  Returns the data for relevant for this plugin
         *
        **/
        getData : function(elem){
            return $.data(elem, PLUGIN_NAME);
        },
        /**
         *
         *
        **/
        showContextmenu : function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData(elem),
                theme = base.options.theme,
                buttonMode = base.options.buttonMode;
            /**********************************************/
            base.$menu = that.createMenu(elem,base.options.menu,$(base.options.appendTo),true,base);
            if (base.$menu) {
                that.show(elem,e);
                base.$menu.on('mousedown',function(e){
                    e.preventDefault();
                    return false;
                });

                that.bindCloseContextMenuEvent(elem);
            }
        },
        /**
         *
         *
        **/
        bindCloseContextMenuEvent: function(elem){
            var that = this,
                base = that.getData(elem);
            if(base.options.buttonMode === true){
                $(document).unbind('mousedown', that.hideButtonModeContextMenuHandler).bind('mousedown', {elem:elem, that: that}, that.hideButtonModeContextMenuHandler);
                $(document).unbind('closeContextMenu', that.hideButtonModeContextMenuHandler).bind('closeContextMenu', {elem:elem, that: that}, that.hideButtonModeContextMenuHandler);
            }else{
                $(document).unbind('mousedown', that.hideRightClickContextMenuHandler).one('mousedown', {elem:elem, that: that}, that.hideRightClickContextMenuHandler);
                $(document).unbind('closeContextMenu', that.hideRightClickContextMenuHandler).one('closeContextMenu', {elem:elem, that: that}, that.hideRightClickContextMenuHandler);
            }
        },
        /**
         *
         *
        **/
        unbindCloseContextMenuEvent: function(elem){
            var that = this,
                base = that.getData(elem);
            if(base.options.buttonMode === true){
                $(document).unbind('mousedown', that.hideButtonModeContextMenuHandler);
                $(document).unbind('closeContextMenu', that.hideButtonModeContextMenuHandler);
            }else{
                $(document).unbind('mousedown', that.hideRightClickContextMenuHandler);
                $(document).unbind('closeContextMenu', that.hideRightClickContextMenuHandler);
            }
        },
        /**
         *
         *
        **/
        hideButtonModeContextMenuHandler: function(e){
            var that = e.data.that;
            that.hideContextMenuHandler(e);
        },
        hideRightClickContextMenuHandler: function(e){
            var that = e.data.that;
            that.hideContextMenuHandler(e);
        },
        hideContextMenuHandler: function(e){
            var that = e.data.that,
                elem = e.data.elem,
                base = that.getData(elem);
            that.hide(elem,$(base.options.appendTo));
        },
        /**
         *
         *
        **/
        show : function(elem,e){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var pos = this.getRootMenuPosition(elem,e);
            base.$menu.css( {top:pos.y, left:pos.x , position:"absolute",zIndex:99} );
        },
        /**
         *
         *
        **/
        createMenu : function(elem , menu , $appendTo , isRootMenu , base){
            var that = this,
               // base = this.getData(elem),
                background_position = [],
                $div = $('<div/>'),
                GROUP = menu.length > 0 ? menu[0].GROUP : 0,
                isFirstMenu = true,
                $ul = $('<ul/>').appendTo($div),
                adjustMenuItemWidth = function(subMenuDiv){
                    if (document.all && !document.querySelector){ //IE7 or lower
                        var subMenuWidth = subMenuDiv.outerWidth();
                        subMenuDiv.find('li .menu-item').width(subMenuWidth-23);
                    }
                },
                isDrawVSeparator = (base.options.separator && isRootMenu && base.options.buttonMode === true);
            /**********************************************/
			if(isRootMenu === true){
				if(base.options.buttonMode){
					$div.addClass(base.themePrefix+"-button").addClass(base.options.theme);
				}
				else {
					$div.addClass(base.themePrefix).addClass(base.options.theme);
				}
            }else{
                $div.on('mousedown',function(e){
                    e.preventDefault();
                    return false;
                });
            }
            $div.addClass('sub-menu');

            $.each(menu,function(i,o){
                if( o.RBA_MODEL && $.isFunction(base.options.RBA_MODEL._GLOBAL) ){
                    base.options.RBA_MODEL._GLOBAL(o,base);
                }

                if( o.RBA_MODEL && $.isFunction(base.options.RBA_MODEL[o.RBA_MODEL]) ){
                    base.options.RBA_MODEL[o.RBA_MODEL](o,base);
                }

                if(!o.CHILD)
                    o = $.extend(true,{},base.defaultMenu,o);

                if(o.VISIBLE !== false){
                    var $li = $('<li/>');

                    if( GROUP != o.GROUP ){
                        if( isFirstMenu == false ){
                            $('<li/>').appendTo($ul).on('click',function(e){
                                e.preventDefault();
                                return false;
                            }).append($('<div/>').addClass(base.classSeparator));
                        }
                        GROUP = o.GROUP;
                    }

                    if(o.TEXT){

                        var $text = '<span class="menu-text">'+o.TEXT+'</span>';

                        var $menuItem = $('<div/>').addClass(base.classMenuItem).html($text).appendTo($li);

                        if(o.CHILD){
                            var childVisibleCount = 0;
                            $.each(o.CHILD , function(i,o){
                                if(o.VISIBLE !== false){
                                    childVisibleCount ++;
                                }
                            });
                            if(childVisibleCount != 0 && o.DISABLED !== true){
                                $menuItem.addClass(base.classSubMenuIndicator);
                            }else{
                                $menuItem.addClass(base.classMenuDisabled);
                            }
                        }
                        if(o.BACKGROUND_POSITION){
                            if(o.DISABLED === true){
                                background_position = o.BACKGROUND_POSITION.GRAYOUT;
                            }else{
                                background_position = o.BACKGROUND_POSITION.DEFAULT;
                            }
                            background_position[0] = parseInt(background_position[0],10).toString()+'px';
                            background_position[1] = parseInt(background_position[1],10).toString()+'px';
                            var menuImage = $('<span/>').addClass('menu-image').css({'background-position':background_position.join(' ')}).appendTo($menuItem);
                        }
                        if(o.BACKGROUND_IMG){
                            // in IE7 ssl, dynamic change css with relative path and reload context menu will trigger an insecure warning message(workaround: use absolute image path)
                            var menuImage = $('<span/>').addClass('menu-image').css({'background-position':'0px 0px','background-image':'url('+base.absoluteUrlFolderPath + o.BACKGROUND_IMG+')'}).appendTo($menuItem);
                        }
                            $menuItem.find('span:eq(0)').appendTo($menuItem);
                        if(o.DISABLED === true){
                            $li.find('> div').addClass(base.classMenuDisabled);
                            if(o.CHILD){
                                $menuItem.addClass(base.classSubMenuIndicatorGray);
                            }
                        }else{
                            if($.isFunction(o.ONCLICK)){
                                $li.on('click',{o:o},function(e){
                                    e.data.o.ONCLICK(e.data.o,base);
                                    var $menuDiv = $(this).closest('div.'+base.themePrefix+"."+base.options.theme);
                                    var $menuItemLv1 = $menuDiv.find('> ul > li > div.menu-item');
                                    var $subMenu = $menuDiv.find('li div.sub-menu');
                                    if( $(this).siblings().find(' > div.sub-menu').length == 0){
                                        $menuItemLv1.removeClass(base.classMenuItemHover);
                                    }
                                    if(!e.data.o.CHILD && base.options.buttonMode === true){
                                        if( $(this).siblings().find(' > div.sub-menu').length == 0){
                                            $(this).find(' > div.menu-item').addClass(base.classMenuItemHover);
                                        }
                                        e.preventDefault();
                                        return false;
                                    }
                                });
                            }

                            $li.on('click',{o:o,buttonMode:base.options.buttonMode},function(e){
                                if(e.data.buttonMode === true){
                                    var $menuDiv =  $(this).closest('div.'+base.themePrefix+"-button."+base.options.theme);
                                    var $menuItemLv1 = $menuDiv.find('> ul > li > div.menu-item');
                                    var $subMenu = $menuDiv.find('li div.sub-menu');
                                    if(o.CHILD){
                                        e.preventDefault();
                                        return false;
                                    }
                                    if(!$.isFunction(o.ONCLICK)){
                                        e.preventDefault();
                                        return false;
                                    }
                                    if($menuItemLv1.hasClass(base.classMenuItemHover) && $subMenu.length == 0){
                                        e.preventDefault();
                                        return false;
                                    }
                                    if($subMenu.length > 0){
                                        that.hide(elem, $(base.options.appendTo), $subMenu);
                                        $menuItemLv1.removeClass(base.classMenuItemHover);
                                        e.preventDefault();
                                        return false;
                                    }
                                }
                                else{
                                    //prevent event when click the node
                                    if(o.CHILD){
                                        e.preventDefault();
                                        return false;
                                    }
                                    if(!$.isFunction(o.ONCLICK)){
                                        e.preventDefault();
                                        return false;
                                    }
                                    that.hide(elem, $(base.options.appendTo), $(this));
                                }
                            });
                        }
                    }
                    if(o.DISABLED !== true){
                        $li.hover(function(e){
                            if(base.options.buttonMode === true && isRootMenu === true){
                                $(this).parent().siblings()
                                    .find('div.sub-menu').remove();
                            }
                            $(this).find('> div.menu-item').addClass(base.classMenuItemHover);
                        },function(){
                            $(this).find('> div').removeClass(base.classMenuItemHover);
                            $(this).siblings().find('> div').removeClass(base.classMenuItemHover);
                        });
                        if(o.CHILD){
                            if(base.options.buttonMode !== true || isRootMenu != true){
                                $li.hover(function(e){
                                    var $subDiv = that.createMenu(elem,o.CHILD,$(this),false,base),
                                        pos = that.getSubMenuPosition(elem,e,$(this));
                                    if(base.options.buttonMode === false){
                                        $subDiv.css({left:pos.x,top:pos.y});
                                    }else{
                                        if(isRootMenu !== true)
                                            $subDiv.css({left:pos.x,top:pos.y});
                                    }

                                    adjustMenuItemWidth($subDiv);

                                },function(e){
                                    var $submenu = $(this).find('div.sub-menu');
                                    setTimeout(function(){
                                        $submenu.remove();
                                    },base.options.hoverTimeout);
                                });
                            }
                            if(base.options.buttonMode === true && isRootMenu === true){
                                var $targetSubMenuCount = 0;
                                $li.on('mousedown', function(e){
                                    $targetSubMenuCount = $(this).find('div.sub-menu').length;
                                }).on('click', function(e){
                                    var $menuDiv = $(this).closest('div.'+base.themePrefix+"-button."+base.options.theme);
                                    var $subMenu = $menuDiv.find('li div.sub-menu');
                                    if($subMenu.length == 0 && $targetSubMenuCount === 0){
                                        var $subDiv = that.createMenu(elem,o.CHILD,$(this),false,base);

                                        adjustMenuItemWidth($subDiv);

                                        // adjust context menu's position
                                        var $window = $(window),
                                            windowViewWidth = $window.width(),
                                            windowScrollLeft = $window.scrollLeft(),
                                            subMenuWidth = $subDiv.outerWidth(),
                                            maxRight = windowViewWidth + windowScrollLeft;
                                            $liLeft = $li.position().left;

                                        if( ($liLeft + subMenuWidth) > maxRight){
                                            $subDiv.css({left: maxRight - subMenuWidth - 1 });
                                        }else{
                                            $subDiv.css({left: ($liLeft >= windowScrollLeft ? $liLeft : windowScrollLeft + 1 ) });
                                        }
                                        that.bindCloseContextMenuEvent(elem);
                                    }else{
                                        $menuDiv.find('> ul > li > div.menu-item').removeClass(base.classMenuItemHover);
                                    }
                                });
                            }
                        }
                    }

                    if(isDrawVSeparator && !isFirstMenu ){
                        var $liSeparator = $('<li/>').appendTo($ul),
                            $divSeparator= $('<div/>').addClass('v-separator'),
                            $text = '<span class="menu-text">&nbsp;</span>';

                        $divSeparator.append( $text ).appendTo($liSeparator)
                        $liSeparator.appendTo($ul);
                    }

                    isFirstMenu = false;
                    $li.appendTo($ul);
                }
            });
            $appendTo.append($div);

            if(isRootMenu && base.options.buttonMode !== true){
                adjustMenuItemWidth($div);
            }

            $div
                //.disableSelection()
                .bind('contextmenu',function(e){
                    e.preventDefault();
                });
            return $div;
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
        getRootMenuPosition : function(elem ,e){
            var that = this,
                base = that.getData(elem),
                $target = base.$menu;
            /**********************************************/
            var x = e.pageX,
                y = e.pageY,
                $w = $(window),
                w = $target.width(),
                h = $target.height(),
                ww = $w.width(),
                hh = $w.height(),
                maxRight = x+w-$w.scrollLeft(),
                maxBottom = y+h-$w.scrollTop();
            if (maxRight > ww) {
                x -= (maxRight-ww+5);
            }
            if (maxBottom > hh) {
                y -= (maxBottom-hh+5);
            }
            return {x:x,y:y};
        },
        getSubMenuPosition : function(elem,e,$target){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            var $subMenu = $target.find('div.sub-menu'),
                $menuItem = $subMenu.find('div.menu-item'),
                paddingTopW = parseInt($menuItem.css('paddingTop'),10),
                borderTopW = parseInt($menuItem.css('border-top-width'),10) || 0,  // Because IE7 will get NaN
                x = $target.offset().left,
                ajdHeight = paddingTopW+borderTopW,
                y = $target.offset().top,
                y_rel = $target.position().top-ajdHeight,
                itemW = $subMenu.outerWidth(),
                itemH = $subMenu.outerHeight(),
                w = $target.width(),
                h = $target.height(),
                $w = $(window),
                ww = $w.width(),
                hh = $w.height(),
                maxRight = x+w+itemW-$w.scrollLeft(),
                maxBottom = y+h+itemH-$w.scrollTop();
                if (maxRight > ww) {
                    w = -itemW;
                }
                if (maxBottom - hh > 10) {
                    y = y_rel-(maxBottom-hh)+h-10;
                }else{
                    y = $target.position().top-paddingTopW+borderTopW;
                }
                var diff = parseInt( $target.find('> div.menu-item').css('paddingTop') , 10);
            return {x:w,y:y};
        },
        /**
         *
         *
        **/
        hide : function(elem, $appendTo, menuItem){
            var that = this,
                base = that.getData(elem),
                theme = base.options.theme,
                buttonMode = base.options.buttonMode;

            /**********************************************/
            if( menuItem ){
                if(buttonMode === false){
                    menuItem.closest('div.'+base.themePrefix+"."+base.options.theme).remove();
                }else{
                    menuItem.closest('div.'+base.themePrefix+"-button."+theme).find('> ul > li > div.sub-menu').remove();
                }
            }else{
                if(buttonMode === false){
                    $appendTo.find('div.'+base.themePrefix+"."+theme).remove();
                }else{
                    $appendTo.find('div.'+base.themePrefix+"-button."+theme).find('> ul > li > div.sub-menu').remove();
                }
            }
            that.unbindCloseContextMenuEvent(elem);

            if( $.isFunction(base.options.hideContextMenu)){
                base.options.hideContextMenu();
            }
        },
        /**
         *
         *
        **/
        displayContextmenuByDefault : function(elem){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.$elem.empty();
            base.$menu = that.createMenu(elem,base.options.menu,base.$elem,true,base);
        },
        /**
         *
         *
        **/
        reload : function(elem,options){
            var that = this,
                base = that.getData(elem);
            /**********************************************/
            base.options = $.extend(true,{},base.options,options);
            this.displayContextmenuByDefault(elem);
        }
    };
    $.fn[PLUGIN_NAME].publicMethods = {
        /**
         *
         *
        **/
        reload : function(elem,args){
            $.fn[PLUGIN_NAME].internalMethods.reload(elem , args[0]);
        }
    };
    $.fn[PLUGIN_NAME].defaults = $.extend({}, {
        buttonMode : false,
        appendTo:'body',
        theme : 'tm',
        hoverTimeout : 120,
        RBA_MODEL : {
            _GLOBAL : function(o,base){
            }
        },
        separator : true
    });
    $.fn[PLUGIN_NAME].base = $.extend({}, {
        themePrefix : 'trend-context-menu',
        classMenuItem : 'menu-item',
        classMenuItemHover : 'menu-item-hover',
        classSeparator : 'dot-line-separator',
        classSubMenuIndicator : 'sub-menu-indicator',
        classSubMenuIndicatorGray : 'sub-menu-indicator-gray',
        classImgDefault : 'menu-default',
        classMenuDisabled : 'menu-item-disabled',
        absoluteUrlFolderPath: document.location.protocol + '//' +  document.location.host +  document.location.pathname +'/../',
        defaultMenu : {
            ONCLICK : function(){
            }
        },
        hideContextMenu: function(){
        }
    });
})(jQuery);