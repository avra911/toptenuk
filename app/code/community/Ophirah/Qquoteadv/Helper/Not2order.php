<?php //00451
// Cart2Quote is a commercial software module for Magento.
// Unpaid usage of our licensed functionalities is prohibited.
// See www.cart2quote.com for more details.
class Ophirah_Qquoteadv_Helper_Not2order extends Mage_Core_Helper_Data {

    function getShowPrice( $_product ) { 
         
        try {
            if (@class_exists('Ophirah_Not2Order_Helper_Data', true)) {
                return Mage::helper('not2order')->getShowPrice( $_product );
            } else {
                // No helper, no price toggle.. always show
                return true;
            }
        } catch(Exception $e) {
            return true;
        }        
    }
}