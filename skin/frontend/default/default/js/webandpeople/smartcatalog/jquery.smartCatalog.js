; // make JS merging easier

// ---------------------
// --- smart columns ---
// ---------------------

(function($){
    var WpSmartColumns = function(element, options) {
        var el = $(element);
        var saveWd = 0;
        var saveWd2 = 0;

        var settings = $.extend({
            columnWidth     : 200,
            oneRow          : false,
            splashClass     : '.smartcolumns-splash',
            loadNextClass   : '.load-next-page-ajax',
            addListCssClass : 'products-grid'
        }, options || {});

        var getColumnsCount = function(width) {
            var c = Math.floor(width / settings.columnWidth);
            return c > 0 ? c : 1;
        }

        var showResult = function() {
            $(settings.splashClass).each(function() {
                $(this).css({'display': 'none'});
            });
        }

        var getViewport = function() {
            var e = window;
            var a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
        };

        var rebuildList = this.rebuildList = function() {
            saveWd = getViewport().width;
            saveWd2 = el.actual('width');
            //console.log(saveWd);
            //console.log(saveWd2);
            var xList = el.find('ul.smart');
            xList.css({'width': '100%', 'padding': 0, 'margin': 0});
            //var xWrapWidth = xList.outerWidth();
            var xWrapWidth = xList.actual('outerWidth');
            //console.log(xWrapWidth);
            var xColCount = getColumnsCount(xWrapWidth);
            var xWidth = Math.floor(xWrapWidth / xColCount);
            var xItems = xList.children('li');
            //console.log(xItems.length);
            var xBlocksCount = Math.max(1, Math.ceil(xItems.length / xColCount));
            //console.log(xBlocksCount);
            var k = 0;
            for (var j = 0; j < xBlocksCount; j++) {
                var xBlock = $('<ul></ul>');
                xBlock.addClass(settings.addListCssClass);
                xBlock.addClass('smart');
                xBlock.width(xWrapWidth);
                xBlock.css({'padding': 0, 'margin': 0});
                if (settings.oneRow && j > 0) {
                    xBlock.css({'display': 'none'});
                }
                for (var i = 0; i < xColCount; i++) {
                    if (typeof xItems[k] == 'undefined') break;
                    var xItem = $(xItems[k]);
                    xItem.width(xWidth);
                    xItem.css({'padding': 0, 'margin': 0});
                    xItem.find('div.item-content div.actions').width(xWidth);
                    xBlock.append(xItem);
                    k++;
                }
                el.append(xBlock);
            }
            xList.remove();
            // --- decorate ---
            el.wpDecorateLists();
            // --- show ---
            showResult();
        }

        $(window).bind('debouncedresize', function(event) {
            if (getViewport().width != saveWd) {
                rebuildList();
            }
        });

        // --- fix: respond.js on IE8 ---
        el.bind('resize', function(event) {
            if (el.actual('width') != saveWd2) {
                rebuildList();
            }
        });
        // jqSmartCatalog(document).trigger('sc-rebuild-list');
        $(document).bind('sc-rebuild-list', function() {
            rebuildList();
        });
        // --- / fix: respond.js on IE8 ---

        rebuildList();
    };

    $.fn.wpSmartColumns = function(options) {
        return this.each(function() {
            var element = $(this);
            if (element.data('wpSmartColumns')) return;
            var wpSmartColumns = new WpSmartColumns(this, options);
            element.data('wpSmartColumns', wpSmartColumns);
        });
    };

})(jqSmartCatalog);


// ----------------------------
// --- some service actions ---
// ----------------------------

(function($){
    $.fn.wpDecorateLists = function(options) {
        options = $.extend({
            type: 'grid'
        }, options);

        var decorate = function() {
            var el = $(this);
            if (options.type == 'list') {
                // --- li only ---
                el.find('>li').removeClass('odd even first last');
                el.find('>li:odd').addClass('odd');
                el.find('>li:even').addClass('even');
                el.find('>li:first-child').addClass('first');
                el.find('>li:last-child').addClass('last');
            } else {
                // --- ul --
                el.find('>ul').removeClass('odd even first last');
                el.find('>ul:odd').addClass('odd');
                el.find('>ul:even').addClass('even');
                el.find('>ul').first().addClass('first');
                el.find('>ul').last().addClass('last');
                // --- li ---
                el.find('>ul>li').removeClass('odd even first last');
                el.find('>ul>li:odd').addClass('odd');
                el.find('>ul>li:even').addClass('even');
                el.find('>ul>li:first-child').addClass('first');
                el.find('>ul>li:last-child').addClass('last');
            }
        };

        return this.each(decorate);
    };
})(jqSmartCatalog);
