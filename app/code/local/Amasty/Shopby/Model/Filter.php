<?php
/**
 * @copyright   Copyright (c) 2010 Amasty (http://www.amasty.com)
 */  
class Amasty_Shopby_Model_Filter extends Mage_Core_Model_Abstract
{
    public function _construct()
    {    
        $this->_init('amshopby/filter');
    }
    
    public function getDisplayTypeString()
    {
        /* @var $helper Amasty_Shopby_Helper_Data */
        $helper = Mage::helper('amshopby');
        $options = array();
        
        if ($this->getBackendType() == 'decimal') {
            $options = $helper->getDecimalDisplayTypes();
        } else {
            $options = $helper->getDisplayTypes();
        }
        
        return $options[$this->getDisplayType()];
    }
}