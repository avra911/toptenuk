<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */
class Amasty_Shopby_Block_Search_Layer extends Amasty_Shopby_Block_Catalog_Layer_View
{
    /**
     * Internal constructor
     */
    protected function _construct()
    {
        parent::_construct();
        Mage::register('current_layer', $this->getLayer(), true);
    } 
    
    /**
     * Get attribute filter block name
     *
     * @return string
     */
    protected function _getAttributeFilterBlockName()
    {
        return 'catalogsearch/layer_filter_attribute';
    }

    /**
     * Get layer object
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        return Mage::getSingleton('catalogsearch/layer');
    }

    
    public function canShowBlock()
    {
        if (version_compare(Mage::getVersion(), '1.4.2', '>=')){
            $allowed = true;
            
            $engine = Mage::helper('catalogsearch')->getEngine();
            // deprecated function name
            if (method_exists($engine, 'isLeyeredNavigationAllowed')){
                $allowed = $engine->isLeyeredNavigationAllowed();
            } 
            // modern version 
            else { 
                $allowed = $engine->isLayeredNavigationAllowed();
            }  
               
            if (!$allowed) {
                return false;
            }
        }
        
        $availableResCount = (int) Mage::app()->getStore()
            ->getConfig(Mage_CatalogSearch_Model_Layer::XML_PATH_DISPLAY_LAYER_COUNT);

        if (!$availableResCount
            || ($availableResCount >= $this->getLayer()->getProductCollection()->getSize())) {
            return parent::canShowBlock();
        }
        
        return false;
    } 
}