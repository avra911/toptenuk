/*
  mColorPicker
  Version: 1.0 r39
  
  Copyright (c) 2010 Meta100 LLC.
  http://www.meta100.com/
  
  Licensed under the MIT license 
  http://www.opensource.org/licenses/mit-license.php 
*/

// After this script loads set:
// $mtkb.fn.mColorPicker.init.replace = '.myclass'
// to have this script apply to input.myclass,
// instead of the default input[type=color]
// To turn of automatic operation and run manually set:
// $mtkb.fn.mColorPicker.init.replace = false
// To use manually call like any other jQuery plugin
// $mtkb('input.foo').mColorPicker({options})
// options:
// imageFolder - Change to move image location.
// swatches - Initial colors in the swatch, must an array of 10 colors.
// init:
// $mtkb.fn.mColorPicker.init.enhancedSwatches - Turn of saving and loading of swatch to cookies.
// $mtkb.fn.mColorPicker.init.allowTransparency - Turn off transperancy as a color option.
// $mtkb.fn.mColorPicker.init.showLogo - Turn on/off the meta100 logo (You don't really want to turn it off, do you?).

(function($mtkb){

  var $mtkbo, $mtkbi, i, $mtkbb,
      div = '<div>',
      img = '<img>',
      span = '<span>',
      $mtkbdocument = $mtkb(document),
      $mtkbmColorPicker = $mtkb(div),
      $mtkbmColorPickerBg = $mtkb(div),
      $mtkbmColorPickerTest = $mtkb(div),
      $mtkbmColorPickerInput = $mtkb('<input>'),
      rRGB = /^rgb[a]?\((\d+),\s*(\d+),\s*(\d+)(,\s*(\d+\.\d+)*)?\)/,
      rHEX = /([a-f0-9])([a-f0-9])([a-f0-9])/,
      rHEX3 = /#[a-f0-9]{3}/,
      rHEX6 = /#[a-f0-9]{6}/;

  $mtkb.fn.mColorPicker = function(options) {

    var swatches = $mtkb.fn.mColorPicker.getCookie('swatches');

    $mtkbo = $mtkb.extend($mtkb.fn.mColorPicker.defaults, options);
    $mtkb.fn.mColorPicker.defaults.swatches.concat($mtkbo.swatches).slice(-10);

    if ($mtkbi.enhancedSwatches && swatches) $mtkbo.swatches = swatches.split('||').concat($mtkbo.swatches).slice(0, 10) || $mtkbo.swatches;

    if (!$mtkb("div#mColorPicker").length) $mtkb.fn.mColorPicker.drawPicker();
    if (!$mtkb('#css_disabled_color_picker').length) $mtkb('head').prepend('<meta data-remove-me="true"/><style id="css_disabled_color_picker" type="text/css">.mColorPicker[disabled] + span, .mColorPicker[disabled="disabled"] + span, .mColorPicker[disabled="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;cursor:default;}</style>');
    if (!$mtkb('#css_disabled_color_picker').length) $mtkb('head').prepend('<meta data-remove-me="true"/><style id="css_disabled_color_picker" type="text/css">.mColorPicker[readonly] + span, .mColorPicker[readonly="readonly"] + span, .mColorPicker[readonly="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;cursor:default;}</style>');
    $mtkb('meta[data-remove-me=true]').remove();

    this.each($mtkb.fn.mColorPicker.drawPickerTriggers);

    return this;
  };

  $mtkb.fn.mColorPicker.init = {
    replace: '[type=color]',
    index: 0,
    enhancedSwatches: true,
    allowTransparency: true,
    slogan: 'Meta100 - Designing Fun',
    showLogo: true
  };

  $mtkb.fn.mColorPicker.defaults = {
    currentId: false,
    currentInput: false,
    currentColor: false,
    changeColor: false,
    color: false,
    imageFolder: 'images/',
    swatches: [
      "#ffffff",
      "#ffff00",
      "#00ff00",
      "#00ffff",
      "#0000ff",
      "#ff00ff",
      "#ff0000",
      "#4c2b11",
      "#3b3b3b",
      "#000000"
    ]
  };

  $mtkb.fn.mColorPicker.start = function() {

    $mtkb('input[data-mcolorpicker!="true"]').filter(function() {
  
      return ($mtkbi.replace == '[type=color]')? this.getAttribute("type") == 'color': $mtkb(this).is($mtkbi.replace);
    }).mColorPicker();
  };

  $mtkb.fn.mColorPicker.events = function() {

    $mtkb("#mColorPickerBg").live('click', $mtkb.fn.mColorPicker.closePicker);

    $mtkb('.mColorPicker').live('keyup', function () {

      try {
  
        $mtkb(this).css({
          'background-color': $mtkb(this).val()
        }).css({
          'color': $mtkb.fn.mColorPicker.textColor($mtkb(this).css('background-color'))
        }).trigger('change');
      } catch (r) {}
    });

    $mtkb('.mColorPickerTrigger').live('click', $mtkb.fn.mColorPicker.colorShow);
  
    $mtkb('.mColor, .mPastColor').live('mousemove', function(e) {

      if (!$mtkbo.changeColor) return false;
  
      var $mtkbt = $mtkb(this),
          offset = $mtkbt.offset(),
          $mtkbe = $mtkbo.currentInput,
          hex = $mtkbe.attr('data-hex') || $mtkbe.attr('hex');

      $mtkbo.color = $mtkbt.css("background-color");

      if ($mtkbt.hasClass('mPastColor')) $mtkbo.color = $mtkb.fn.mColorPicker.setColor($mtkbo.color, hex);
      else if ($mtkbt.hasClass('mColorTransparent')) $mtkbo.color = 'transparent';
      else if (!$mtkbt.hasClass('mPastColor')) $mtkbo.color = $mtkb.fn.mColorPicker.whichColor(e.pageX - offset.left, e.pageY - offset.top, hex);

      $mtkbo.currentInput.mSetInputColor($mtkbo.color);
    }).live('click', $mtkb.fn.mColorPicker.colorPicked);
  
    $mtkb('#mColorPickerInput').live('keyup', function (e) {
  
      try {
  
        $mtkbo.color = $mtkb(this).val();
        $mtkbo.currentInput.mSetInputColor($mtkbo.color);
    
        if (e.which == 13) $mtkb.fn.mColorPicker.colorPicked();
      } catch (r) {}

    }).live('blur', function () {
  
      $mtkbo.currentInput.mSetInputColor($mtkbo.color);
    });
  
    $mtkb('#mColorPickerWrapper').live('mouseleave', function () {
  
      if (!$mtkbo.changeColor) return false;

      var $mtkbe = $mtkbo.currentInput; 

      $mtkbo.currentInput.mSetInputColor($mtkb.fn.mColorPicker.setColor($mtkbo.currentColor, ($mtkbe.attr('data-hex') || $mtkbe.attr('hex'))));
    });
  };

  $mtkb.fn.mColorPicker.drawPickerTriggers = function () {

    var $mtkbt = $mtkb(this),
        id = $mtkbt.attr('id') || 'color_' + $mtkbi.index++,
        hidden = $mtkbt.attr('text') == 'hidden' || $mtkbt.attr('data-text') == 'hidden'? true: false,
        color = $mtkb.fn.mColorPicker.setColor($mtkbt.val(), ($mtkbt.attr('data-hex') || $mtkbt.attr('hex'))),
        width = $mtkbt.width(),
        height = $mtkbt.height(),
        flt = $mtkbt.css('float'),
        $mtkbc = $mtkb(span),
        $mtkbtrigger = $mtkb(span),
        colorPicker = '',
        $mtkbe;

    $mtkbc.attr({
      'id': 'color_work_area',
      'class': 'mColorPickerInput'
    }).appendTo($mtkbb)

    $mtkbtrigger.attr({
      'id': 'mcp_' + id,
      'class': 'mColorPickerTrigger'
    }).css({
      'display': 'inline-block',
      'cursor': 'pointer'
    }).insertAfter($mtkbt)
    
    $mtkb(img).attr({
      'src': $mtkbo.imageFolder + 'color.png'
    }).css({
      'border': 0,
      'margin': '0 0 0 3px',
      'vertical-align': 'text-bottom'
    }).appendTo($mtkbtrigger);

    $mtkbc.append($mtkbt);
    colorPicker = $mtkbc.html().replace(/type=[^a-z ]*color[^a-z //>]*/gi, 'type="' + (hidden? 'hidden': 'text') + '"');
    $mtkbc.html('').remove();
    $mtkbe = $mtkb(colorPicker).attr('id', id).addClass('mColorPicker').val(color).insertBefore($mtkbtrigger);

    if (hidden) $mtkbtrigger.css({
      'border': '1px solid black',
      'float': flt,
      'width': width,
      'height': height
    }).addClass($mtkbe.attr('class')).html('&nbsp;');

    $mtkbe.mSetInputColor(color);

    return $mtkbe;
  };

  $mtkb.fn.mColorPicker.drawPicker = function () {
  
    var $mtkbs = $mtkb(div),
        $mtkbl = $mtkb('<a>'),
        $mtkbf = $mtkb(div),
        $mtkbw = $mtkb(div);

    $mtkbmColorPickerBg.attr({
      'id': 'mColorPickerBg'
    }).css({
      'display': 'none',
      'background':'black',
      'opacity': .01,
      'position':'absolute',
      'top':0,
      'right':0,
      'bottom':0,
      'left':0
    }).appendTo($mtkbb);

    $mtkbmColorPicker.attr({
      'id': 'mColorPicker',
      'data-mcolorpicker': true
    }).css({
      'position':'absolute',
      'border':'1px solid #ccc',
      'color':'#fff',
      'width':'194px',
      'height':'184px',
      'font-size':'12px',
      'font-family':'times',
      'display': 'none'
    }).appendTo($mtkbb);

    $mtkbmColorPickerTest.attr({
      'id': 'mColorPickerTest'
    }).css({
      'display': 'none'
    }).appendTo($mtkbb);

    $mtkbw.attr({
      'id': 'mColorPickerWrapper'
    }).css({
      'position':'relative',
      'border':'solid 1px gray'
    }).appendTo($mtkbmColorPicker);

    $mtkb(div).attr({
      'id': 'mColorPickerImg',
      'class': 'mColor'
    }).css({
      'height': '136px',
      'width': '192px',
      'border': 0,
      'cursor': 'crosshair',
      'background-image': 'url(' + $mtkbo.imageFolder + 'picker.png)'
    }).appendTo($mtkbw);

    $mtkbs.attr({
      'id': 'mColorPickerSwatches'
    }).css({
      'border-right':'1px solid #000'
    }).appendTo($mtkbw);

    $mtkb(div).addClass(
      'mClear'
    ).css({
      'clear': 'both'
    }).appendTo($mtkbs);

    for (i = 9; i > -1; i--) {

      $mtkb(div).attr({
        'id': 'cell' + i,
        'class': "mPastColor" + ((i > 0)? ' mNoLeftBorder': '')
      }).css({
        'background-color': $mtkbo.swatches[i].toLowerCase(),
        'height':'18px',
        'width':'18px',
        'border':'1px solid #000',
        'float':'left'
      }).html(
        '&nbsp;'
      ).prependTo($mtkbs);
    }

    $mtkbf.attr({
      'id': 'mColorPickerFooter'
    }).css({
      'background-image': 'url(' + $mtkbo.imageFolder + 'grid.gif)',
      'position': 'relative',
      'height': '26px'
    }).appendTo($mtkbw);

    $mtkbmColorPickerInput.attr({
      'id': 'mColorPickerInput',
      'type': 'text'
    }).css({
      'border': 'solid 1px gray',
      'font-size': '10pt',
      'margin': '3px',
      'width': '80px'
    }).appendTo($mtkbf);

    if ($mtkbi.allowTransparency) $mtkb(span).attr({
      'id': 'mColorPickerTransparent',
      'class': 'mColor mColorTransparent'
    }).css({
      'font-size': '16px',
      'color': '#000',
      'padding-right': '30px',
      'padding-top': '3px',
      'cursor': 'pointer',
      'overflow': 'hidden',
      'float': 'right'
    }).text(
      'transparent'
    ).appendTo($mtkbf);

    if ($mtkbi.showLogo) $mtkbl.attr({
      'href': 'http://meta100.com/',
      'title': $mtkbi.slogan,
      'alt': $mtkbi.slogan,
      'target': '_blank'
    }).css({
      'float': 'right'
    }).appendTo($mtkbf);
    
    $mtkb(img).attr({
      'src': $mtkbo.imageFolder + 'meta100.png',
      'title': $mtkbi.slogan,
      'alt': $mtkbi.slogan
    }).css({
      'border': 0,
      'border-left': '1px solid #aaa',
      'right': 0,
      'position': 'absolute'
    }).appendTo($mtkbl);

    $mtkb('.mNoLeftBorder').css({
      'border-left':0
    });
  };

  $mtkb.fn.mColorPicker.closePicker = function () {

    $mtkbmColorPickerBg.hide();
    $mtkbmColorPicker.fadeOut()
  };

  $mtkb.fn.mColorPicker.colorShow = function () {

    var $mtkbt = $mtkb(this),
        id = $mtkbt.attr('id').replace('mcp_', ''),
        pos = $mtkbt.offset(),
        $mtkbi = $mtkb("#" + id),
        pickerTop = pos.top + $mtkbt.outerHeight(),
        pickerLeft = pos.left;

    if ($mtkbi.attr('disabled')) return false;
    if ($mtkbi.attr('readonly')) return false;

    $mtkbo.currentColor = $mtkbi.css('background-color')
    $mtkbo.changeColor = true;
    $mtkbo.currentInput = $mtkbi;
    $mtkbo.currentId = id;

    // KEEP COLOR PICKER IN VIEWPORT
    if (pickerTop + $mtkbmColorPicker.height() > $mtkbdocument.height()) pickerTop = pos.top - $mtkbmColorPicker.height();
    if (pickerLeft + $mtkbmColorPicker.width() > $mtkbdocument.width()) pickerLeft = pos.left - $mtkbmColorPicker.width() + $mtkbt.outerWidth();
  
    $mtkbmColorPicker.css({
      'top':(pickerTop) + "px",
      'left':(pickerLeft) + "px"
    }).fadeIn("fast");
  
    $mtkbmColorPickerBg.show();
  
    if ($mtkb('#' + id).attr('data-text')) $mtkbo.color = $mtkbt.css('background-color');
    else $mtkbo.color = $mtkbi.css('background-color');

    $mtkbo.color = $mtkb.fn.mColorPicker.setColor($mtkbo.color, $mtkbi.attr('data-hex') || $mtkbi.attr('hex'));

    $mtkbmColorPickerInput.val($mtkbo.color);
  };

  $mtkb.fn.mColorPicker.setInputColor = function (id, color) {

    $mtkb('#' + id).mSetInputColor(color);
  };

  $mtkb.fn.mSetInputColor = function (color) {
  
    var $mtkbt = $mtkb(this),
        css = {
          'background-color': color,
          'background-image': (color == 'transparent')? "url('" + $mtkbo.imageFolder + "grid.gif')": '',
          'color': $mtkb.fn.mColorPicker.textColor(color)
        };
  
    if ($mtkbt.attr('data-text') || $mtkbt.attr('text')) $mtkbt.next().css(css);

    $mtkbt.val(color).css(css).trigger('change');

    $mtkbmColorPickerInput.val(color);
  };

  $mtkb.fn.mColorPicker.textColor = function (val) {

    val = $mtkb.fn.mColorPicker.RGBtoHex(val);

    if (typeof val == 'undefined' || val == 'transparent') return "black";

    return (parseInt(val.substr(1, 2), 16) + parseInt(val.substr(3, 2), 16) + parseInt(val.substr(5, 2), 16) < 400)? 'white': 'black';
  };

  $mtkb.fn.mColorPicker.setCookie = function (name, value, days) {
  
    var cookie_string = name + "=" + escape(value),
      expires = new Date();
      expires.setDate(expires.getDate() + days);
    cookie_string += "; expires=" + expires.toGMTString();
   
    document.cookie = cookie_string;
  };

  $mtkb.fn.mColorPicker.getCookie = function (name) {
  
    var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$mtkb)' );
  
    if (results) return (unescape(results[2]));
    else return null;
  };

  $mtkb.fn.mColorPicker.colorPicked = function () {

    $mtkbo.changeColor = false;
  
    $mtkb.fn.mColorPicker.closePicker();
    $mtkb.fn.mColorPicker.addToSwatch();
  
    $mtkbo.currentInput.trigger('colorpicked');
  };

  $mtkb.fn.mColorPicker.addToSwatch = function (color) {
  
    if (!$mtkbi.enhancedSwatches) return false;

    var swatch = []
        i = 0;
 
    if (typeof color == 'string') $mtkbo.color = color;
    if ($mtkbo.color != 'transparent') swatch[0] = $mtkb.fn.mColorPicker.hexToRGB($mtkbo.color);
  
    $mtkb('.mPastColor').each(function() {
  
      var $mtkbt = $mtkb(this);

      $mtkbo.color = $mtkb.fn.mColorPicker.hexToRGB($mtkbt.css('background-color'));

      if ($mtkbo.color != swatch[0] && swatch.length < 10) swatch[swatch.length] = $mtkbo.color;
  
      $mtkbt.css('background-color', swatch[i++])
    });

    if ($mtkbi.enhancedSwatches) $mtkb.fn.mColorPicker.setCookie('swatches', swatch.join('||'), 365);
  };

  $mtkb.fn.mColorPicker.whichColor = function (x, y, hex) {

    var color = [255, 255, 255];

    if (x < 32) {
  
      color[1] = x * 8;
      color[2] = 0;
    } else if (x < 64) {
  
      color[0] = 256 - (x - 32 ) * 8;
      color[2] = 0;
    } else if (x < 96) {
  
      color[0] = 0;
      color[2] = (x - 64) * 8;
    } else if (x < 128) {
  
      color[0] = 0;
      color[1] = 256 - (x - 96) * 8;
    } else if (x < 160) {
  
      color[0] = (x - 128) * 8;
      color[1] = 0;
    } else {
  
      color[1] = 0;
      color[2] = 256 - (x - 160) * 8;
    }

    for (var n = 0; n < 3; n++) {

      if (y < 64) color[n] += (256 - color[n]) * (64 - y) / 64;
      else if (y <= 128) color[n] -= color[n] * (y - 64) / 64;
      else if (y > 128) color[n] = 256 - ( x / 192 * 256 );
  
      color[n] = Math.round(Math.min(color[n], 255));

      if (hex == 'true') color[n] = $mtkb.fn.mColorPicker.decToHex(color[n]);
    }

    if (hex == 'true') return "#" + color.join('');
    
    return "rgb(" + color.join(', ') + ')';
  };

  $mtkb.fn.mColorPicker.setColor = function (color, hex) {

    if (hex == 'true') return $mtkb.fn.mColorPicker.RGBtoHex(color);

    return $mtkb.fn.mColorPicker.hexToRGB(color);
  }

  $mtkb.fn.mColorPicker.colorTest = function (color) {

    $mtkbmColorPickerTest.css('background-color', color);

    return $mtkbmColorPickerTest.css('background-color');
  }

  $mtkb.fn.mColorPicker.decToHex = function (color) {

    var hex_char = "0123456789ABCDEF";

    color = parseInt(color);

    return String(hex_char.charAt(Math.floor(color / 16))) + String(hex_char.charAt(color - (Math.floor(color / 16) * 16)));
  }

  $mtkb.fn.mColorPicker.RGBtoHex = function (color) {

    var decToHex = "#",
        rgb;

    color = color? color.toLowerCase(): false;

    if (!color) return '';
    if (rHEX6.test(color)) return color.substr(0, 7);
    if (rHEX3.test(color)) return color.replace(rHEX, "$mtkb1$mtkb1$mtkb2$mtkb2$mtkb3$mtkb3").substr(0, 7);

    if (rgb = color.match(rRGB)) {

      for (var n = 1; n < 4; n++) decToHex += $mtkb.fn.mColorPicker.decToHex(rgb[n]);
    
      return decToHex;
    }

    return $mtkb.fn.mColorPicker.colorTest(color);
  };

  $mtkb.fn.mColorPicker.hexToRGB = function (color) {

    color = color? color.toLowerCase(): false;

    if (!color) return '';
    if (rRGB.test(color)) return color;

    if (rHEX3.test(color)) {

      if (!rHEX6.test(color)) color = color.replace(rHEX, "$mtkb1$mtkb1$mtkb2$mtkb2$mtkb3$mtkb3");
  
      return 'rgb(' + parseInt(color.substr(1, 2), 16) + ', ' + parseInt(color.substr(3, 2), 16) + ', ' + parseInt(color.substr(5, 2), 16) + ')';
    }

    return $mtkb.fn.mColorPicker.colorTest(color);
  };

  $mtkbi = $mtkb.fn.mColorPicker.init;

  $mtkbdocument.ready(function () {

    $mtkbb = $mtkb('body');

    $mtkb.fn.mColorPicker.events();

    if ($mtkbi.replace) {

      if (typeof $mtkb.fn.mDOMupdate == "function") {
  
        $mtkb('input').mDOMupdate($mtkb.fn.mColorPicker.start);
      } else if (typeof $mtkb.fn.livequery == "function") {
  
        $mtkb('input').livequery($mtkb.fn.mColorPicker.start);
      } else {
  
        $mtkb.fn.mColorPicker.start();
        $mtkbdocument.live('ajaxSuccess.mColorPicker', $mtkb.fn.mColorPicker.start);
      }
    }
  });
})($mtkb);
