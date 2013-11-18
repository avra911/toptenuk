<?php

class Ophirah_Qquoteadv_Block_Sidebar extends Mage_Checkout_Block_Cart_Abstract
{
   
		public function _construct() {
				return parent::_construct();
    }
    
    public function getQuoteQty(){
    	return Mage::helper('qquoteadv')->getTotalQty();
    }
   
   	public function getQuote(){
   		return Mage::helper('qquoteadv')->getQuote();
   	}
   	
   	public function getProduct($productId) {
				return Mage::getModel('catalog/product')->load($productId);
		}


   
}
