<?php
/**
 * @copyright   Copyright (c) 2010 Amasty (http://www.amasty.com)
 */  
class Amasty_Shopby_Model_Catalog_Layer_Filter_Price_Price14ce extends Mage_Catalog_Model_Layer_Filter_Price
{
    
    private $_rangeSeparator = ',';
    private $_fromToSeparator = '-';
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieves resource instance
     */
    protected function _getResource()
    {
        if (is_null($this->_resource)) {
            if (Mage::helper('amshopby')->isVersionLessThan(1, 4)){
                
                if ($this->getRequestVar() != 'price'){
                     $this->_resource = Mage::getSingleton('catalogindex/price');    
                }
                else {
                    $this->_resource = Mage::getSingleton('amshopby/mysql4_price13');
                }
                $this->_resource->setCustomerGroupId(Mage::getSingleton('customer/session')->getCustomerGroupId());
                $this->_resource->setRate(Mage::app()->getStore()->getCurrentCurrencyRate());
                $this->_resource->setStoreId(Mage::app()->getStore()->getId());
            }
            else {
                $this->_resource = Mage::getModel('amshopby/mysql4_price');
            }
        }
        
        return $this->_resource;        
    }

    /**
     * Prepare text of item label
     */
    protected function _renderFromToItemLabel($from, $to)
    {
        $store      = Mage::app()->getStore();
        $fromPrice  = $store->formatPrice($from);
        $toPrice    = $store->formatPrice($to);
        if (empty($to)) {
            return Mage::helper('catalog')->__('from %s', $fromPrice);
        } else {
            return Mage::helper('catalog')->__('%s - %s', $fromPrice, $toPrice);    
        }
        
    }

    /**
     * Get data for build price filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if ($this->getRequestVar() != 'price' && Mage::helper('amshopby')->isVersionLessThan(1, 4)){
            return parent::_getItemsData(); 
        }
        
        if (!Mage::getStoreConfig('amshopby/general/use_custom_ranges')){
            return parent::_getItemsData();
        }
            
        $key = $this->_getCacheKey();

        $data = $this->getLayer()->getAggregator()->getCacheData($key);
        if ($data === null) {
            $ranges = $this->_getCustomRanges();
            $counts = $this->_getResource()->getFromToCount($this, $ranges);
            $data = array();
            
            foreach ($counts as $index => $count) {
                if (!$index) // index may be NULL if some products has price out of all ranges
                    continue;
                    
                $from  = $ranges[$index][0];
                $to    = $ranges[$index][1];
                $data[] = array(
                    'label' => $this->_renderFromToItemLabel($from, $to),
                    'value' => $from . ',' . $to,
                    'count' => $count,
                    'pos'   => $from,
                );
            }
            usort($data, array($this, '_srt')); 

            $tags = array(
                Mage_Catalog_Model_Product_Type_Price::CACHE_TAG,
            );
            $tags = $this->getLayer()->getStateTags($tags);
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }

    /**
     * Apply price range filter to collection
     *
     * @return Mage_Catalog_Model_Layer_Filter_Price
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        if ($this->getRequestVar() != 'price' && Mage::helper('amshopby')->isVersionLessThan(1, 4)){
            return parent::apply($request, $filterBlock);
        }
        
        if (!$this->calculateRanges()){
            $this->_items = array($this->_createItem('', 0, 0)); 
        }        
        
        $filterBlock->setValueFrom(Mage::helper('amshopby')->__('From'));
        $filterBlock->setValueTo(Mage::helper('amshopby')->__('To'));
        
        $filter = $request->getParam($this->getRequestVar());
        if (!$filter) {
            return $this;
        }
        
        $isFromTo = false;
        if (Mage::getStoreConfig('amshopby/general/use_custom_ranges')){
            $isFromTo = true;
        }
        
        $prices = array();
        /*
         * Try range
         */
        $prices = explode($this->_rangeSeparator, $filter);
        if (count($prices) != 2) {
             /*
              * Try from to
              */
             $prices = explode($this->_fromToSeparator, $filter);             
             if (count($prices) == 2) {
                 $isFromTo = true;
             } else {
                 return $this;
             }
        } 

        list ($from, $to) = $prices;
        $from  = floatval($from);
        $to    = floatval($to);

        if ($from || $to) {
            if (!$isFromTo){
                $index = $from;
                $range = $to;
                $from  = ($index-1)*$range;
                $to    = $index*$range;
            }   
            
            $filterBlock->setValueFrom($from > 0.01 ? $from : '');
            $filterBlock->setValueTo($to > 0.01 ? $to : '');
            
            $this->_getResource()->applyFromToFilter($this, $from, $to);
            
            $this->getLayer()->getState()->addFilter(
                $this->_createItem($this->_renderFromToItemLabel($from, $to), $filter)
            );
            if ($this->hideAfterSelection()){
                 $this->_items = array();
            } 
            elseif ($this->calculateRanges()){
                $this->_items = array($this->_createItem('', 0, 0));
            }
        }
        return $this;
    }

    
    /**
     * Get minimal price
     * @return number
     */
    public function getMinValue()
    {
        return floor($this->_getRequiredPrice(true));      
    }
    
    /**
     * Get maximal price
     * @return number
     */
    public function getMaxValue()
    {
        return ceil($this->_getRequiredPrice(false));
    }
    
    /**
     * Get required price
     * @param bool $minimal - set to true to retrieve minimal, to false - to retrieve maximal
     * @return number
     */
    protected function _getRequiredPrice($minimal = true)
    {
        $priceType = (int)$minimal;
        if (!Mage::helper('amshopby')->isVersionLessThan(1, 4)) {
            
            $prices = $this->getData('max_min_price_int');
            if (is_null($prices)) {
                $prices = $this->_getResource()->getMaxMinPrice($this);
                $this->setData('max_min_price_int', $prices);
            }
            
            $price = $prices[$priceType];
            return $price;            
        }
        
        // I LOVE 1.3 :)
        $prices = $this->getData('max_min_price_int');
        if (is_null($prices)) {
            $prices = $this->_getResource()->getMaxMinPrice(
                $this->getAttributeModel(),
                $this->_getBaseCollectionSql()
            );
            $this->setData('max_min_price_int', $prices);
        }
        $price = $prices[$priceType];
        
        return $price;       
    }
     
    /**
     * For 1.3 ONLY. I LOVE 1.3 :)
     */
    public function getRangeItemCounts($range)
    {
        if (!Mage::helper('amshopby')->isVersionLessThan(1, 4)){
            return parent::getRangeItemCounts($range);
        }
        $items = $this->getData('range_item_counts_'.$range);
        if (is_null($items)) {
            // logic is the same, but we need to pass different params.
            $items = $this->_getResource()->getCount(
                $this->getAttributeModel(),
                $range,
                $this->_getBaseCollectionSql()
            );
            $this->setData('range_item_counts_'.$range, $items);
        }
        return $items;
    }
    
}