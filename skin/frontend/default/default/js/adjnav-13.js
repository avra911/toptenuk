// checking if IE: this variable will be understood by IE: isIE = !false
isIE = /*@cc_on!@*/false;

Control.Slider.prototype.setDisabled = function()
{
    this.disabled = true;
    
    if (!isIE)
    {
        this.track.parentNode.className = this.track.parentNode.className + ' disabled';
    }
};




function adv_nav_hide_products()
{
    var items = $('narrow-by-list').select('a', 'input');
    n = items.length;
    for (i=0; i<n; ++i){
        items[i].addClassName('adv-nav-disabled');
    }
    
    if (typeof(adv_slider) != 'undefined')
        adv_slider.setDisabled();
    
    var divs = $$('div.adv-nav-progress');
    for (var i=0; i<divs.length; ++i)
        divs[i].show();
}

function adv_nav_show_products(transport)
{
    var resp = {} ;
    if (transport && transport.responseText){
        try {
            resp = eval('(' + transport.responseText + ')');
        }
        catch (e) {
            resp = {};
        }
    }
    
    if (resp.products){
        var el = $('adv-nav-container');
        var ajaxUrl = $('adv-nav-ajax').value;
        
        el.update(resp.products.gsub(ajaxUrl, $('adv-nav-url').value));
        adv_nav_toolbar_init(); // reinit listeners
                
        $('adv-nav-navigation').update(resp.layer.gsub(ajaxUrl, $('adv-nav-url').value));
        
        $('adv-nav-ajax').value = ajaxUrl;  
    }
    
    var items = $('narrow-by-list').select('a','input');
    n = items.length;
    for (i=0; i<n; ++i){
        items[i].removeClassName('adv-nav-disabled');
    }
    if (typeof(adv_slider) != 'undefined')
        adv_slider.setEnabled();
}

function adv_nav_add_params(k, v, isSingleVal)
{
    var el = $('adv-nav-params');
    var params = el.value.parseQuery();
    
    var strVal = params[k];
    if (typeof strVal == 'undefined' || !strVal.length){
        params[k] = v;
    }
    else if('clear' == v ){
        params[k] = 'clear';
    }
    else {
        if (k == 'price')
            var values = strVal.split(',');
        else
            var values = strVal.split('-');
        
//        var values = strVal.split('-');
        if (-1 == values.indexOf(v)){
            if (isSingleVal)
                values = [v];
            else 
                values.push(v);
        } 
        else {
            values = values.without(v);
        }
                
        params[k] = values.join('-');
    } 
    
   el.value = Object.toQueryString(params).gsub('%2B', '+');
}



function adv_nav_make_request()
{
    adv_nav_hide_products();
    
// tmp aitoc    
    var params = $('adv-nav-params').value.parseQuery();
    
    if (!params['dir'])
    {
        $('adv-nav-params').value += '&dir=' + 'desc';
    }
// tmp aitoc    
    
    new Ajax.Request($('adv-nav-ajax').value + '?' + $('adv-nav-params').value, 
        {method: 'get', onSuccess: adv_nav_show_products}
    );
}


function adv_update_links(evt, className, isSingleVal)
{
    var link = Event.findElement(evt, 'A'),
        sel = className + '-selected';
    
    if (link.hasClassName(sel))
        link.removeClassName(sel);    
    else
        link.addClassName(sel);
    
    //only one  price-range can be selected
    if (isSingleVal){
        var items = $('narrow-by-list').getElementsByClassName(className);
        var i, n = items.length;
        for (i=0; i<n; ++i){
            if (items[i].hasClassName(sel) && items[i].id != link.id)
                items[i].removeClassName(sel);   
        }
    }

    adv_nav_add_params(link.id.split('-')[0], link.id.split('-')[1], isSingleVal);
    
    adv_nav_make_request();    
    
    Event.stop(evt);    
}


function adv_nav_attribute_listener(evt)
{
    adv_nav_add_params('p', 'clear', 1);
    adv_update_links(evt, 'adv-nav-attribute', 0);
}

function adv_nav_icon_listener(evt)
{
    adv_nav_add_params('p', 'clear', 1);
    adv_update_links(evt, 'adv-nav-icon', 0);
}

function adv_nav_price_listener(evt)
{
    adv_nav_add_params('p', 'clear', 1);
    adv_update_links(evt, 'adv-nav-price', 1);
}

function adv_nav_clear_listener(evt)
{
    var link = Event.findElement(evt, 'A'),
        varName = link.id.split('-')[0];
    
    adv_nav_add_params('p', 'clear', 1);
    adv_nav_add_params(varName, 'clear', 1);
    
    if ('price' == varName){
        var from =  $('adv-nav-price-from'),
            to   = $('adv-nav-price-to');
          
        if (Object.isElement(from)){
            from.value = from.name;
            to.value   = to.name;
        }
    }
    
    adv_nav_make_request();    
    
    Event.stop(evt);  
}


function adv_nav_round(num){
    num = parseFloat(num);
    if (isNaN(num))
        num = 0;
        
    return Math.round(num);
}

function adv_nav_price_input_listener(evt){
    if (evt.type == 'keypress' && 13 != evt.keyCode)
        return;
    
    var numFrom = adv_nav_round($('adv-nav-price-from').value),
        numTo   = adv_nav_round($('adv-nav-price-to').value);
  
    if ((numFrom<0.01 && numTo<0.01) || numFrom<0 || numTo<0)   
        return;

    adv_nav_add_params('p', 'clear', 1);
    adv_nav_add_params('price', numFrom + ',' + numTo, true);
    adv_nav_make_request();         
}


function adv_nav_category_listener(evt){
    var link = Event.findElement(evt, 'A');
    var catId = link.id.split('-')[1];
    
    var reg = /cat=/;
    if (reg.test(link.href)){ //is search
        adv_nav_add_params('cat', catId, 1);
        adv_nav_add_params('p', 'clear', 1);
        adv_nav_make_request(); 
        Event.stop(evt);  
    }
    //do not stop event
}

function adv_nav_toolbar_listener(evt){
    adv_nav_toolbar_make_request(Event.findElement(evt, 'A').href);
    Event.stop(evt); 
}

function adv_nav_toolbar_make_request(href)
{
    var pos = href.indexOf('?');
    if (pos > -1){
        $('adv-nav-params').value = href.substring(pos+1, href.length);
    }
    adv_nav_make_request();
}


function adv_nav_toolbar_init()
{
//    var items = $('adv-nav-container').select('.pages a', '.view-by a');
    var items = $('adv-nav-container').select('.pages a', '.view-mode a', '.view-by a', '.sort-by a');
    var i, n = items.length;
    for (i=0; i<n; ++i){
        Event.observe(items[i], 'click', adv_nav_toolbar_listener);
    }
}

function adv_nav_dt_listener(evt){
    var e = Event.findElement(evt, 'DT');
    e.nextSiblings()[0].toggle();
    e.toggleClassName('adv-nav-dt-selected');
}

function adv_nav_clearall_listener(evt)
{
    var params = $('adv-nav-params').value.parseQuery();
    $('adv-nav-params').value = 'advclear=true';
    if (params['q'])
    {
        $('adv-nav-params').value += '&q=' + params['q'];
    }
    adv_nav_make_request();
    Event.stop(evt); 
}

function adv_nav_init()
{
    var items, i, j, n, 
        classes = ['category', 'attribute', 'icon', 'price', 'clear', 'dt', 'clearall'];
    
    for (j=0; j<classes.length; ++j){
        items = $('narrow-by-list').select('.adv-nav-' + classes[j]);
        n = items.length;
        for (i=0; i<n; ++i){
            Event.observe(items[i], 'click', eval('adv_nav_' + classes[j] + '_listener'));
        }
    }

// start new fix code    
    items = $('narrow-by-list').select('.adv-nav-price-input-id');
    
    n = items.length;
    
    var btn = $('adv-nav-price-go');
    if (Object.isElement(btn)){
        Event.observe(btn, 'click', adv_nav_price_input_listener);
        Event.observe($('adv-nav-price-from'), 'keypress', adv_nav_price_input_listener);
        Event.observe($('adv-nav-price-to'), 'keypress', adv_nav_price_input_listener);
    }
// finish new fix code    
}

  
function adv_nav_create_slider(width, from, to, max_price) 
{
    var price_slider = $('adv-nav-price-slider');

    return new Control.Slider(price_slider.select('.handle'), price_slider, {
      range: $R(0, width),
      sliderValue: [from, to],
      restricted: true,
      
      onChange: function (values){
        var f = adv_nav_round(max_price*values[0]/width),
            t = adv_nav_round(max_price*values[1]/width);
            
        adv_nav_add_params('price', f + ',' + t, true);
          
        // we can change values without sliding  
        $('adv-nav-range-from').update(f); 
        $('adv-nav-range-to').update(t);
            
        adv_nav_make_request();  
      },
      onSlide: function(values) { 
          $('adv-nav-range-from').update(adv_nav_round(max_price*values[0]/width));
          $('adv-nav-range-to').update(adv_nav_round(max_price*values[1]/width));
      }
    });
}

function adv_nav_calculate(width, from, to, min_price, max_price, value)
{
    var calculated = adv_nav_round(((max_price-min_price)*value/width) + min_price);
    
    return calculated;
}