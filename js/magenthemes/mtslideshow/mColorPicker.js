/*
  mColorPicker
  Version: 1.0 r39
  
  Copyright (c) 2010 Meta100 LLC.
  http://www.meta100.com/
  
  Licensed under the MIT license 
  http://www.opensource.org/licenses/mit-license.php 
*/

// After this script loads set:
// jQuery.fn.mColorPicker.init.replace = '.myclass'
// to have this script apply to input.myclass,
// instead of the default input[type=color]
// To turn of automatic operation and run manually set:
// jQuery.fn.mColorPicker.init.replace = false
// To use manually call like any other jQuery plugin
// jQuery('input.foo').mColorPicker({options})
// options:
// imageFolder - Change to move image location.
// swatches - Initial colors in the swatch, must an array of 10 colors.
// init:
// jQuery.fn.mColorPicker.init.enhancedSwatches - Turn of saving and loading of swatch to cookies.
// jQuery.fn.mColorPicker.init.allowTransparency - Turn off transperancy as a color option.
// jQuery.fn.mColorPicker.init.showLogo - Turn on/off the meta100 logo (You don't really want to turn it off, do you?).

(function(jQuery){

  var jQueryo, jQueryi, i, jQueryb,
      div = '<div>',
      img = '<img>',
      span = '<span>',
      jQuerydocument = jQuery(document),
      jQuerymColorPicker = jQuery(div),
      jQuerymColorPickerBg = jQuery(div),
      jQuerymColorPickerTest = jQuery(div),
      jQuerymColorPickerInput = jQuery('<input>'),
      rRGB = /^rgb[a]?\((\d+),\s*(\d+),\s*(\d+)(,\s*(\d+\.\d+)*)?\)/,
      rHEX = /([a-f0-9])([a-f0-9])([a-f0-9])/,
      rHEX3 = /#[a-f0-9]{3}/,
      rHEX6 = /#[a-f0-9]{6}/;

  jQuery.fn.mColorPicker = function(options) {

    var swatches = jQuery.fn.mColorPicker.getCookie('swatches');

    jQueryo = jQuery.extend(jQuery.fn.mColorPicker.defaults, options);
    jQuery.fn.mColorPicker.defaults.swatches.concat(jQueryo.swatches).slice(-10);

    if (jQueryi.enhancedSwatches && swatches) jQueryo.swatches = swatches.split('||').concat(jQueryo.swatches).slice(0, 10) || jQueryo.swatches;

    if (!jQuery("div#mColorPicker").length) jQuery.fn.mColorPicker.drawPicker();
    if (!jQuery('#css_disabled_color_picker').length) jQuery('head').prepend('<meta data-remove-me="true"/><style id="css_disabled_color_picker" type="text/css">.mColorPicker[disabled] + span, .mColorPicker[disabled="disabled"] + span, .mColorPicker[disabled="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;cursor:default;}</style>');
    if (!jQuery('#css_disabled_color_picker').length) jQuery('head').prepend('<meta data-remove-me="true"/><style id="css_disabled_color_picker" type="text/css">.mColorPicker[readonly] + span, .mColorPicker[readonly="readonly"] + span, .mColorPicker[readonly="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;cursor:default;}</style>');
    jQuery('meta[data-remove-me=true]').remove();

    this.each(jQuery.fn.mColorPicker.drawPickerTriggers);

    return this;
  };

  jQuery.fn.mColorPicker.init = {
    replace: '[type=color]',
    index: 0,
    enhancedSwatches: true,
    allowTransparency: true,
    slogan: 'Meta100 - Designing Fun',
    showLogo: true
  };

  jQuery.fn.mColorPicker.defaults = {
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

  jQuery.fn.mColorPicker.start = function() {

    jQuery('input[data-mcolorpicker!="true"]').filter(function() {
  
      return (jQueryi.replace == '[type=color]')? this.getAttribute("type") == 'color': jQuery(this).is(jQueryi.replace);
    }).mColorPicker();
  };

  jQuery.fn.mColorPicker.events = function() {
    jQuery(document).on("click", "#mColorPickerBg", jQuery.fn.mColorPicker.closePicker);
    jQuery(document).on("keyup", ".mColorPicker", function () {
      try {

        jQuery(this).css({
          'background-color': jQuery(this).val()
        }).css({
          'color': jQuery.fn.mColorPicker.textColor(jQuery(this).css('background-color'))
        }).trigger('change');
      } catch (r) {}
    });
    jQuery(document).on("click", ".mColorPickerTrigger", jQuery.fn.mColorPicker.colorShow);
    jQuery(document).on("mousemove", ".mColor, .mPastColor", function(e) {

      if (!jQueryo.changeColor) return false;

      var jQueryt = jQuery(this),
          offset = jQueryt.offset(),
          jQuerye = jQueryo.currentInput,
          hex = jQuerye.attr('data-hex') || jQuerye.attr('hex');

      jQueryo.color = jQueryt.css("background-color");

      if (jQueryt.hasClass('mPastColor')) jQueryo.color = jQuery.fn.mColorPicker.setColor(jQueryo.color, hex);
      else if (jQueryt.hasClass('mColorTransparent')) jQueryo.color = 'transparent';
      else if (!jQueryt.hasClass('mPastColor')) jQueryo.color = jQuery.fn.mColorPicker.whichColor(e.pageX - offset.left, e.pageY - offset.top, hex);

      jQueryo.currentInput.mSetInputColor(jQueryo.color);
    });
    jQuery(document).on("click", ".mColor, .mPastColor", jQuery.fn.mColorPicker.colorPicked);
    jQuery(document).on("keyup", "#mColorPickerInput", function (e) {

      try {

        jQueryo.color = jQuery(this).val();
        jQueryo.currentInput.mSetInputColor(jQueryo.color);

        if (e.which == 13) jQuery.fn.mColorPicker.colorPicked();
      } catch (r) {}

    }).on('blur', function () {

      jQueryo.currentInput.mSetInputColor(jQueryo.color);
    });
    jQuery(document).on("mouseleave", "#mColorPickerWrapper", function () {

      if (!jQueryo.changeColor) return false;

      var jQuerye = jQueryo.currentInput;

      jQueryo.currentInput.mSetInputColor(jQuery.fn.mColorPicker.setColor(jQueryo.currentColor, (jQuerye.attr('data-hex') || jQuerye.attr('hex'))));
    });
  };

  jQuery.fn.mColorPicker.drawPickerTriggers = function () {

    var jQueryt = jQuery(this),
        id = jQueryt.attr('id') || 'color_' + jQueryi.index++,
        hidden = jQueryt.attr('text') == 'hidden' || jQueryt.attr('data-text') == 'hidden'? true: false,
        color = jQuery.fn.mColorPicker.setColor(jQueryt.val(), (jQueryt.attr('data-hex') || jQueryt.attr('hex'))),
        width = jQueryt.width(),
        height = jQueryt.height(),
        flt = jQueryt.css('float'),
        jQueryc = jQuery(span),
        jQuerytrigger = jQuery(span),
        colorPicker = '',
        jQuerye;

    jQueryc.attr({
      'id': 'color_work_area',
      'class': 'mColorPickerInput'
    }).appendTo(jQueryb)

    jQuerytrigger.attr({
      'id': 'mcp_' + id,
      'class': 'mColorPickerTrigger'
    }).css({
      'display': 'inline-block',
      'cursor': 'pointer'
    }).insertAfter(jQueryt)
    jQuery(img).attr({
      'src': jQueryo.imageFolder + 'color.png'
    }).css({
      'border': 0,
      'margin': '0 0 0 3px',
      'vertical-align': 'text-bottom'
    }).appendTo(jQuerytrigger);

    jQueryc.append(jQueryt);
    colorPicker = jQueryc.html().replace(/type=[^a-z ]*color[^a-z //>]*/gi, 'type="' + (hidden? 'hidden': 'text') + '"');
    jQueryc.html('').remove();
    jQuerye = jQuery(colorPicker).attr('id', id).addClass('mColorPicker').val(color).insertBefore(jQuerytrigger);

    if (hidden) jQuerytrigger.css({
      'border': '1px solid black',
      'float': flt,
      'width': width,
      'height': height
    }).addClass(jQuerye.attr('class')).html('&nbsp;');

    jQuerye.mSetInputColor(color);

    return jQuerye;
  };

  jQuery.fn.mColorPicker.drawPicker = function () {

    var jQuerys = jQuery(div),
        jQueryl = jQuery('<a>'),
        jQueryf = jQuery(div),
        jQueryw = jQuery(div);

    jQuerymColorPickerBg.attr({
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
    }).appendTo(jQueryb);

    jQuerymColorPicker.attr({
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
    }).appendTo(jQueryb);

    jQuerymColorPickerTest.attr({
      'id': 'mColorPickerTest'
    }).css({
      'display': 'none'
    }).appendTo(jQueryb);

    jQueryw.attr({
      'id': 'mColorPickerWrapper'
    }).css({
      'position':'relative',
      'border':'solid 1px gray'
    }).appendTo(jQuerymColorPicker);
    jQuery(div).attr({
      'id': 'mColorPickerImg',
      'class': 'mColor'
    }).css({
      'height': '136px',
      'width': '192px',
      'border': 0,
      'cursor': 'crosshair'
    }).appendTo(jQueryw);

    jQuerys.attr({
      'id': 'mColorPickerSwatches'
    }).css({
      'border-right':'1px solid #000'
    }).appendTo(jQueryw);

    jQuery(div).addClass(
      'mClear'
    ).css({
      'clear': 'both'
    }).appendTo(jQuerys);

    for (i = 9; i > -1; i--) {

      jQuery(div).attr({
        'id': 'cell' + i,
        'class': "mPastColor" + ((i > 0)? ' mNoLeftBorder': '')
      }).css({
        'background-color': jQueryo.swatches[i].toLowerCase(),
        'height':'18px',
        'width':'18px',
        'border':'1px solid #000',
        'float':'left'
      }).html(
        '&nbsp;'
      ).prependTo(jQuerys);
    }

    jQueryf.attr({
      'id': 'mColorPickerFooter'
    }).css({
      'background-image': 'url(' + jQueryo.imageFolder + 'grid.gif)',
      'position': 'relative',
      'height': '26px'
    }).appendTo(jQueryw);

    jQuerymColorPickerInput.attr({
      'id': 'mColorPickerInput',
      'type': 'text'
    }).css({
      'border': 'solid 1px gray',
      'font-size': '10pt',
      'margin': '3px',
      'width': '80px'
    }).appendTo(jQueryf);

    if (jQueryi.allowTransparency) jQuery(span).attr({
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
    ).appendTo(jQueryf);

    if (jQueryi.showLogo) jQueryl.attr({
      'href': 'http://meta100.com/',
      'title': jQueryi.slogan,
      'alt': jQueryi.slogan,
      'target': '_blank'
    }).css({
      'float': 'right'
    }).appendTo(jQueryf);

    jQuery('.mNoLeftBorder').css({
      'border-left':0
    });
  };

  jQuery.fn.mColorPicker.closePicker = function () {

    jQuerymColorPickerBg.hide();
    jQuerymColorPicker.fadeOut()
  };

  jQuery.fn.mColorPicker.colorShow = function () {

    var jQueryt = jQuery(this),
        id = jQueryt.attr('id').replace('mcp_', ''),
        pos = jQueryt.offset(),
        jQueryi = jQuery("#" + id),
        pickerTop = pos.top + jQueryt.outerHeight(),
        pickerLeft = pos.left;

    if (jQueryi.attr('disabled')) return false;
    if (jQueryi.attr('readonly')) return false;

    jQueryo.currentColor = jQueryi.css('background-color')
    jQueryo.changeColor = true;
    jQueryo.currentInput = jQueryi;
    jQueryo.currentId = id;

    // KEEP COLOR PICKER IN VIEWPORT
    if (pickerTop + jQuerymColorPicker.height() > jQuerydocument.height()) pickerTop = pos.top - jQuerymColorPicker.height();
    if (pickerLeft + jQuerymColorPicker.width() > jQuerydocument.width()) pickerLeft = pos.left - jQuerymColorPicker.width() + jQueryt.outerWidth();

    jQuerymColorPicker.css({
      'top':(pickerTop) + "px",
      'left':(pickerLeft) + "px"
    }).fadeIn("fast");

    jQuerymColorPickerBg.show();

    if (jQuery('#' + id).attr('data-text')) jQueryo.color = jQueryt.css('background-color');
    else jQueryo.color = jQueryi.css('background-color');

    jQueryo.color = jQuery.fn.mColorPicker.setColor(jQueryo.color, jQueryi.attr('data-hex') || jQueryi.attr('hex'));

    jQuerymColorPickerInput.val(jQueryo.color);
  };

  jQuery.fn.mColorPicker.setInputColor = function (id, color) {

    jQuery('#' + id).mSetInputColor(color);
  };

  jQuery.fn.mSetInputColor = function (color) {

    var jQueryt = jQuery(this),
        css = {
          'background-color': color,
          'background-image': (color == 'transparent')? "url('" + jQueryo.imageFolder + "grid.gif')": '',
          'color': jQuery.fn.mColorPicker.textColor(color)
        };

    if (jQueryt.attr('data-text') || jQueryt.attr('text')) jQueryt.next().css(css);

    jQueryt.val(color).css(css).trigger('change');

    jQuerymColorPickerInput.val(color);
  };

  jQuery.fn.mColorPicker.textColor = function (val) {

    val = jQuery.fn.mColorPicker.RGBtoHex(val);

    if (typeof val == 'undefined' || val == 'transparent') return "black";

    return (parseInt(val.substr(1, 2), 16) + parseInt(val.substr(3, 2), 16) + parseInt(val.substr(5, 2), 16) < 400)? 'white': 'black';
  };

  jQuery.fn.mColorPicker.setCookie = function (name, value, days) {

    var cookie_string = name + "=" + escape(value),
      expires = new Date();
      expires.setDate(expires.getDate() + days);
    cookie_string += "; expires=" + expires.toGMTString();

    document.cookie = cookie_string;
  };

  jQuery.fn.mColorPicker.getCookie = function (name) {

    var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|jQuery)' );

    if (results) return (unescape(results[2]));
    else return null;
  };

  jQuery.fn.mColorPicker.colorPicked = function () {

    jQueryo.changeColor = false;

    jQuery.fn.mColorPicker.closePicker();
    jQuery.fn.mColorPicker.addToSwatch();

    jQueryo.currentInput.trigger('colorpicked');
  };

  jQuery.fn.mColorPicker.addToSwatch = function (color) {

    if (!jQueryi.enhancedSwatches) return false;

    var swatch = []
        i = 0;

    if (typeof color == 'string') jQueryo.color = color;
    if (jQueryo.color != 'transparent') swatch[0] = jQuery.fn.mColorPicker.hexToRGB(jQueryo.color);

    jQuery('.mPastColor').each(function() {

      var jQueryt = jQuery(this);

      jQueryo.color = jQuery.fn.mColorPicker.hexToRGB(jQueryt.css('background-color'));

      if (jQueryo.color != swatch[0] && swatch.length < 10) swatch[swatch.length] = jQueryo.color;

      jQueryt.css('background-color', swatch[i++])
    });

    if (jQueryi.enhancedSwatches) jQuery.fn.mColorPicker.setCookie('swatches', swatch.join('||'), 365);
  };

  jQuery.fn.mColorPicker.whichColor = function (x, y, hex) {

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

      if (hex == 'true') color[n] = jQuery.fn.mColorPicker.decToHex(color[n]);
    }

    if (hex == 'true') return "#" + color.join('');

    return "rgb(" + color.join(', ') + ')';
  };

  jQuery.fn.mColorPicker.setColor = function (color, hex) {

    if (hex == 'true') return jQuery.fn.mColorPicker.RGBtoHex(color);

    return jQuery.fn.mColorPicker.hexToRGB(color);
  }

  jQuery.fn.mColorPicker.colorTest = function (color) {

    jQuerymColorPickerTest.css('background-color', color);

    return jQuerymColorPickerTest.css('background-color');
  }

  jQuery.fn.mColorPicker.decToHex = function (color) {

    var hex_char = "0123456789ABCDEF";

    color = parseInt(color);

    return String(hex_char.charAt(Math.floor(color / 16))) + String(hex_char.charAt(color - (Math.floor(color / 16) * 16)));
  }

  jQuery.fn.mColorPicker.RGBtoHex = function (color) {

    var decToHex = "#",
        rgb;

    color = color? color.toLowerCase(): false;

    if (!color) return '';
    if (rHEX6.test(color)) return color.substr(0, 7);
    if (rHEX3.test(color)) return color.replace(rHEX, "jQuery1jQuery1jQuery2jQuery2jQuery3jQuery3").substr(0, 7);

    if (rgb = color.match(rRGB)) {

      for (var n = 1; n < 4; n++) decToHex += jQuery.fn.mColorPicker.decToHex(rgb[n]);

      return decToHex;
    }

    return jQuery.fn.mColorPicker.colorTest(color);
  };

  jQuery.fn.mColorPicker.hexToRGB = function (color) {

    color = color? color.toLowerCase(): false;

    if (!color) return '';
    if (rRGB.test(color)) return color;

    if (rHEX3.test(color)) {

      if (!rHEX6.test(color)) color = color.replace(rHEX, "jQuery1jQuery1jQuery2jQuery2jQuery3jQuery3");

      return 'rgb(' + parseInt(color.substr(1, 2), 16) + ', ' + parseInt(color.substr(3, 2), 16) + ', ' + parseInt(color.substr(5, 2), 16) + ')';
    }

    return jQuery.fn.mColorPicker.colorTest(color);
  };

  jQueryi = jQuery.fn.mColorPicker.init;

  jQuerydocument.ready(function () {

    jQueryb = jQuery('body');

    jQuery.fn.mColorPicker.events();

    if (jQueryi.replace) {

      if (typeof jQuery.fn.mDOMupdate == "function") {

        jQuery('input').mDOMupdate(jQuery.fn.mColorPicker.start);
      } else if (typeof jQuery.fn.livequery == "function") {

        jQuery('input').livequery(jQuery.fn.mColorPicker.start);
      } else {

        jQuery.fn.mColorPicker.start();
        jQuerydocument.one('ajaxSuccess.mColorPicker', jQuery.fn.mColorPicker.start);
      }
    }
  });
})(jQuery);
