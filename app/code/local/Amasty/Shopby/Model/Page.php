<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2008-2012 Amasty (http://www.amasty.com)
* @package Amasty_Shopby
*/
class Amasty_Shopby_Model_Page extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('amshopby/page');
    }
    
    public function getAllFilters($addEmpty=false)
    {
        $collection = Mage::getModel('amshopby/filter')->getResourceCollection()
            ->addTitles();
            
        $values = array();
        if ($addEmpty){
            $values[''] = '';
        }
        foreach ($collection as $row){
            $values[$row->getAttributeCode()] = $row->getFrontendLabel();
        } 
        return $values;
    }
    
    public function match()
    {
        if (intval($this->getStoreId()) > 0 && 
                Mage::app()->getStore()->getId() != $this->getStoreId()) {
            return false; 
        }
        
        $cond = $this->getCond();
        
        if (!$cond) {
            return false;            
        }
        
        $cats = $this->getCats();
        if ($cats) {
            $cat = Mage::registry('current_category');
            if (!$cat){
                return false;
            }
            
            if (!in_array($cat->getId(), explode(',', $cats))) {
                return false;
            }
        }
        
        $cond = unserialize($cond);
        foreach ($cond as $k => $v) {
            if (!$v){ // multiselect can be empty
                continue;
            }
            
            /*
             * Multiple attributes fix
             */
            if (is_array($v) && is_numeric($k)) {
                $k = $v['attribute_code'];
                $v = $v['attribute_value'];
            }
            
            $vals = Mage::helper('amshopby')->getRequestValues($k);
            if (is_array($v)) {
                if (array_diff($v, $vals)) {
                    return false;
                }
            } 
            elseif (!in_array($v, $vals)) {
                return false;
            }
        }
        return true;
    }
    
    public function getFrontendInput($attributeCode)
    {
        $attributes = Mage::getModel('amshopby/filter')->getResourceCollection()->addFrontendInput($attributeCode);
        return $attributes->getFirstItem();
    }
        
    public function getOptionsForFilter($attributeCode, $frontendInput)
    {
        $filters = Mage::getModel('amshopby/filter')->getResourceCollection()->addFrontendInput($attributeCode);
        $filterId = $filters->getFirstItem()->getFilterId();
        
        $options = Mage::getModel('amshopby/value')->getResourceCollection()->addFilter('filter_id', $filterId);
            
        $values = array();
        foreach ($options as $option) {
            if ('select' == $frontendInput) {
                $values[$option->getOptionId()] = $option->getTitle();
            } elseif ('multiselect' == $frontendInput) {
                $values[] = array(
                    'value' => $option->getOptionId(),
                    'label' => $option->getTitle(),
                );
            }
        } 
        return $values;
    }
}