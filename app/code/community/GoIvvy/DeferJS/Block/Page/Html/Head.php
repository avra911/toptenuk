<?php
class GoIvvy_DeferJS_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null)
    {
        if(!Mage::helper('goivvy_deferjs')->isEnabled() || preg_match('@std>@',$format))
            return parent::_prepareStaticAndSkinElements($format, $staticItems, $skinItems, $mergeCallback);
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }

        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
            }
        }

        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                    : $designPackage->getSkinUrl($name, array());
            }
        }

        $html = '';
        $_count = 0;
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
                if(preg_match('@type="text/javascript"@',$format) && $params != ' std'){
                  $format = '<script type="text/javascript" >
function loadScript'.++$_count.' (){

    var callback = function(){if(typeof(getA) == "function" && (typeof(getacalled) == "undefined" || !getacalled)) getA();};
    var url = "%s";
    var script = document.createElement("script");
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    parentGuest = document.getElementsByTagName("body")[0];
    if (parentGuest.nextSibling) {
       parentGuest.parentNode.insertBefore(script, parentGuest.nextSibling);
    }
    else {
       parentGuest.parentNode.appendChild(script);
    }
}

 if (window.addEventListener)
 window.addEventListener("load", loadScript'.$_count.', false);
 else if (window.attachEvent)
 window.attachEvent("onload", loadScript'.$_count.');
 else window.onload = loadScript'.$_count.';
</script>' . "\n";
                }
                elseif(preg_match('@type="text/javascript"@',$format) && $params == ' std'){
                   $format = '<script type="text/javascript" src="%s"%s></script>';
                } 
                $html .= sprintf($format, $mergedUrl, $params);
            } else {
                foreach ($rows as $src) {
                if(preg_match('@type="text/javascript"@',$format) && $params != ' std'){
                  $format = '<script type="text/javascript" >
function loadScript'.++$_count.' (){

    '.($_count== count($rows) ? 'var callback = function(){if(typeof(getA) == "function" && (typeof(getacalled) == "undefined" || !getacalled)) getA();};' : ' var callback = function(){};').'
    var url = "%s";
    var script = document.createElement("script");
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    parentGuest = document.getElementsByTagName("body")[0];
    if (parentGuest.nextSibling) {
       parentGuest.parentNode.insertBefore(script, parentGuest.nextSibling);
    }
    else {
       parentGuest.parentNode.appendChild(script);
    }
}

 if (window.addEventListener)
 window.addEventListener("load", loadScript'.$_count.', false);
 else if (window.attachEvent)
 window.attachEvent("onload", loadScript'.$_count.');
 else window.onload = loadScript'.$_count.';
</script>' . "\n";
                }
                elseif(preg_match('@type="text/javascript"@',$format) && $params == ' std'){
                   $format = '<script type="text/javascript" src="%s"%s></script>';
                } 
                    $html .= sprintf($format, $src, $params);
                }
            }
        }
        return $html;
    }

    public function isAdmin()
    {  
        if(Mage::app()->getStore()->isAdmin())
        {  
            return true;
        }

        if(Mage::getDesign()->getArea() == 'adminhtml')
        {  
            return true;
        }

        return false;
    }
}
