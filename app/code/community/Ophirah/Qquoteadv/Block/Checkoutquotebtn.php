<?php
class Ophirah_Qquoteadv_Block_Checkoutquotebtn extends Mage_Core_Block_Template
{
	public function _prepareLayout(){ 
       return parent::_prepareLayout();
    }
	
	/**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }
		if (!Mage::getStoreConfig('qquoteadv/general/enabled')){
			return '';
		}
        
        if (count(Mage::helper('checkout/cart')->getCart()->getItems()) ) {
           $html = $this->renderView();
           return $html;
        }else 
            return '';
    }


}