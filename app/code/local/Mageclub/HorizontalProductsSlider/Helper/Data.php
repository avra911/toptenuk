<?php
class Mageclub_HorizontalProductsSlider_Helper_Data extends Mage_Core_Helper_Abstract {		
	function get($var, $attributes){
		if(isset($attributes[$var])){
			return $attributes[$var];
		}		
    	return Mage::getStoreConfig("mageclub_horizontalproductsslider/mageclub_horizontalproductsslider/$var");
	}	  
}
?>