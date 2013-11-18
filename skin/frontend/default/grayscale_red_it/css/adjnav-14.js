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






function adj_nav_hide_products()
{
    var items = $('narrow-by-list').select('a', 'input');
    n = items.length;
    for (i=0; i<n; ++i){
        items[i].addClassName('adj-nav-disabled');
    }
    
    if (typeof(adj_slider) != 'undefined')
        adj_slider.setDisabled();
    
    var divs = $$('div.adj-nav-progress');
    for (var i=0; i<divs.length; ++i)
        divs[i].show();
}

function adj_nav_show_products(transport)
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
        var el = $('adj-nav-container');
        var ajaxUrl = $('adj-nav-ajax').value;
        
        el.update(resp.products.gsub(ajaxUrl, $('adj-nav-url').value));
        adv_nav_toolbar_init(); // reinit listeners
                
        $('adj-nav-navigation').update(resp.layer.gsub(ajaxUrl, $('adj-nav-url').value));
        
        $('adj-nav-ajax').value = ajaxUrl;  
    }
    
    var items = $('narrow-by-list').select('a','input');
    n = items.length;
    for (i=0; i<n; ++i){
        items[i].removeClassName('adj-nav-disabled');
    }
    if (typeof(adj_slider) != 'undefined')
        adj_slider.setEnabled();
}

function adj_nav_add_params(k, v, isSingleVal)
{
    var el = $('adj-nav-params');
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



function adj_nav_make_request()
{
    adj_nav_hide_products();
    
// tmp aitoc    
    var params = $('adj-nav-params').value.parseQuery();
    
    if (!params['dir'])
    {
        $('adj-nav-params').value += '&dir=' + 'desc';
    }
// tmp aitoc    
    
    new Ajax.Request($('adj-nav-ajax').value + '?' + $('adj-nav-params').value, 
        {method: 'get', onSuccess: adj_nav_show_products}
    );
}


function adj_update_links(evt, className, isSingleVal)
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

    adj_nav_add_params(link.id.split('-')[0], link.id.split('-')[1], isSingleVal);
    
    adj_nav_make_request();    
    
    Event.stop(evt);    
}


function adj_nav_attribute_listener(evt)
{
    adj_nav_add_params('p', 'clear', 1);
    adj_update_links(evt, 'adj-nav-attribute', 0);
}

function adj_nav_icon_listener(evt)
{
    adj_nav_add_params('p', 'clear', 1);
    adj_update_links(evt, 'adj-nav-icon', 0);
}

function adj_nav_price_listener(evt)
{
    adj_nav_add_params('p', 'clear', 1);
    adj_update_links(evt, 'adj-nav-price', 1);
}

function adj_nav_clear_listener(evt)
{
    var link = Event.findElement(evt, 'A'),
        varName = link.id.split('-')[0];
    
    adj_nav_add_params('p', 'clear', 1);
    adj_nav_add_params(varName, 'clear', 1);
    
    if ('price' == varName){
        var from =  $('adj-nav-price-from'),
            to   = $('adj-nav-price-to');
          
        if (Object.isElement(from)){
            from.value = from.name;
            to.value   = to.name;
        }
    }
    
    adj_nav_make_request();    
    
    Event.stop(evt);  
}


function adj_nav_round(num){
    num = parseFloat(num);
    if (isNaN(num))
        num = 0;
        
    return Math.round(num);
}

function adj_nav_price_input_listener(evt){
    if (evt.type == 'keypress' && 13 != evt.keyCode)
        return;
        
    if (evt.type == 'keypress')
    {
        var inpObj = Event.findElement(evt, 'INPUT');
    }
    else 
    {
        var inpObj = Event.findElement(evt, 'BUTTON');
    }
        
    var sKey = inpObj.id.split('---')[1];
        
    var numFrom = adj_nav_round($('adj-nav-price-from---' + sKey).value),
        numTo   = adj_nav_round($('adj-nav-price-to---' + sKey).value);
 
    if ((numFrom<0.01 && numTo<0.01) || numFrom<0 || numTo<0)   
        return;

    adj_nav_add_params('p', 'clear', 1);
//    adj_nav_add_params('price', numFrom + ',' + numTo, true);
    adj_nav_add_params(sKey, numFrom + ',' + numTo, true);
    adj_nav_make_request();         
}

function adj_nav_category_listener(evt){
    var link = Event.findElement(evt, 'A');
    var catId = link.id.split('-')[1];
    
    var reg = /cat-/;
    if (reg.test(link.id)){ //is search
        adj_nav_add_params('cat', catId, 1);
        adj_nav_add_params('p', 'clear', 1);
        adj_nav_make_request(); 
        Event.stop(evt);  
    }
    //do not stop event
}

function adj_nav_toolbar_listener(evt){
    adj_nav_toolbar_make_request(Event.findElement(evt, 'A').href);
    Event.stop(evt); 
}

function adj_nav_toolbar_make_request(href)
{
    var pos = href.indexOf('?');
    if (pos > -1){
        $('adj-nav-params').value = href.substring(pos+1, href.length);
    }
    adj_nav_make_request();
}


function adv_nav_toolbar_init()
{
//    var items = $('adj-nav-container').select('.pages a', '.view-by a');
    var items = $('adj-nav-container').select('.pages a', '.view-mode a', '.sort-by a');
    var i, n = items.length;
    for (i=0; i<n; ++i){
        Event.observe(items[i], 'click', adj_nav_toolbar_listener);
    }
}

function adj_nav_dt_listener(evt){
    var e = Event.findElement(evt, 'DT');
    e.nextSiblings()[0].toggle();
    e.toggleClassName('adj-nav-dt-selected');
}

function adj_nav_clearall_listener(evt)
{
    var params = $('adj-nav-params').value.parseQuery();
    $('adj-nav-params').value = 'adjclear=true';
    if (params['q'])
    {
        $('adj-nav-params').value += '&q=' + params['q'];
    }
    adj_nav_make_request();
    Event.stop(evt); 
}

function adj_nav_init()
{
    var items, i, j, n, 
        classes = ['category', 'attribute', 'icon', 'price', 'clear', 'dt', 'clearall'];
    
    for (j=0; j<classes.length; ++j){
        items = $('narrow-by-list').select('.adj-nav-' + classes[j]);
        n = items.length;
        for (i=0; i<n; ++i){
            Event.observe(items[i], 'click', eval('adj_nav_' + classes[j] + '_listener'));
        }
    }

// start new fix code    
    items = $('narrow-by-list').select('.adj-nav-price-input-id');
    
    n = items.length;
    
    var btn = $('adj-nav-price-go');
    
    for (i=0; i<n; ++i)
    {
        btn = $('adj-nav-price-go---' + items[i].value);
        if (Object.isElement(btn)){
            Event.observe(btn, 'click', adj_nav_price_input_listener);
            Event.observe($('adj-nav-price-from---' + items[i].value), 'keypress', adj_nav_price_input_listener);
            Event.observe($('adj-nav-price-to---' + items[i].value), 'keypress', adj_nav_price_input_listener);
        }
    }
// finish new fix code    
}
  
function adj_nav_create_slider(width, from, to, min_price, max_price, sKey) 
{
    var price_slider = $('adj-nav-price-slider' + sKey);

    return new Control.Slider(price_slider.select('.handle'), price_slider, {
      range: $R(0, width),
      sliderValue: [from, to],
      restricted: true,
      
      onChange: function (values){
//        var f = adj_nav_round(max_price*values[0]/width),
//            t = adj_nav_round(max_price*values[1]/width);
        var f = adj_nav_calculate(width, from, to, min_price, max_price, values[0]),
            t = adj_nav_calculate(width, from, to, min_price, max_price, values[1]);
           
//        adj_nav_add_params('price', f + ',' + t, true);
        adj_nav_add_params(sKey, f + ',' + t, true);
        
        // we can change values without sliding  
        $('adj-nav-range-from' + sKey).update(f); 
        $('adj-nav-range-to' + sKey).update(t);
            
        adj_nav_make_request();  
      },
      onSlide: function(values) { 
//          $('adj-nav-range-from' + sKey).update(adj_nav_round(max_price*values[0]/width));
//          $('adj-nav-range-to' + sKey).update(adj_nav_round(max_price*values[1]/width));
          $('adj-nav-range-from' + sKey).update(adj_nav_calculate(width, from, to, min_price, max_price, values[0]));
          $('adj-nav-range-to' + sKey).update(adj_nav_calculate(width, from, to, min_price, max_price, values[1]));
      }
    });
}

function adj_nav_calculate(width, from, to, min_price, max_price, value)
{
    var calculated = adj_nav_round(((max_price-min_price)*value/width) + min_price);
    
    return calculated;
}
