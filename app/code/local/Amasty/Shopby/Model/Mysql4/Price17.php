<?php

class Amasty_Shopby_Model_Mysql4_Price17 extends Mage_Catalog_Model_Resource_Layer_Filter_Price
{

    public $_maxMinPrice = null;
    
    protected  function _construct()
    {
        parent::_construct();
    }
    
    /**
     * Retrieve clean select with joined price index table
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return Varien_Db_Select
     */
    protected function _getSelect($filter)
    {
        if (!Mage::helper('amshopby')->landingNewFilter()) {
            return parent::_getSelect($filter);
        }
        
        $collection = $filter->getLayer()->getProductCollection();
        $collection->addPriceData($filter->getCustomerGroupId(), $filter->getWebsiteId());

        if (!is_null($collection->getCatalogPreparedSelect())) {
            $select = clone $collection->getCatalogPreparedSelect();
        } else {
            $select = clone $collection->getSelect();
        }

        // reset columns, order and limitation conditions
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);

        // remove join with main table
        $fromPart = $select->getPart(Zend_Db_Select::FROM);
        if (!isset($fromPart[Mage_Catalog_Model_Resource_Product_Collection::INDEX_TABLE_ALIAS])
            || !isset($fromPart[Mage_Catalog_Model_Resource_Product_Collection::MAIN_TABLE_ALIAS])
        ) {
            return $select;
        }

        $select->where($this->_getPriceExpression($filter, $select) . ' IS NOT NULL');
        
        return $select;
            
    }
    
    protected function _getPriceExpression($filter, $select, $replaceAlias = true)
    {
        if (Mage::helper('amshopby')->landingNewFilter()) {
            $replaceAlias = false;
        }
        return parent::_getPriceExpression($filter, $select, $replaceAlias);
    }
    

    /**
     * Retrieve minimal and maximal prices
     * 
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return array (max, min)
     */
    public function _getMaxMinPrice($filter)
    {
        if (!$this->_maxMinPrice) {
            $select = clone $filter->getLayer()->getProductCollection()->getSelect();
    
            $select->reset(Zend_Db_Select::LIMIT_OFFSET);
            $select->reset(Zend_Db_Select::COLUMNS);
            $select->reset(Zend_Db_Select::LIMIT_COUNT);
            $select->reset(Zend_Db_Select::ORDER);
            
            /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
            $collection = Mage::getResourceModel('catalog/product_collection');
                  
            $priceExpression = $collection->getPriceExpression($select) . ' ' . $collection->getAdditionalPriceExpression($select);
            
            $select = $this->_removePriceFromSelect($select, $priceExpression);
            
            $sqlEndPart = ') * ' . $collection->getCurrencyRate() . ')';
            $select->columns('CEIL(MAX(' . $priceExpression . $sqlEndPart . ' as max_price');
            $select->columns('FLOOR(MIN(' . $priceExpression . $sqlEndPart . ' as min_price');
            $select->where($collection->getPriceExpression($select) . ' IS NOT NULL');
            
            $this->_maxMinPrice = $collection->getConnection()->fetchRow($select, array(), Zend_Db::FETCH_NUM); 
        }
        return $this->_maxMinPrice;
    }
    

    /**
     * Retrieve maximal price
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMaxPrice($filter)
    {
        $prices = $this->_getMaxMinPrice($filter);
        return $prices[0];
    }
    
    /**
     * Retrieve maximal price
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMinPrice($filter)
    {
        $prices = $this->_getMaxMinPrice($filter);
        return $prices[1];
    }
    
    /**
     * Remove price records from where query
     * 
     * @param Varien_Db_Select $select
     * @param string $priceExpression
     * @return Varien_Db_Select
     */
    public function _removePriceFromSelect($select, $priceExpression)
    {
        $oldWhere = $select->getPart(Varien_Db_Select::WHERE);        
        $newWhere = array();
        foreach ($oldWhere as $cond) {
            if (false === strpos($cond, $priceExpression)) {
                   $newWhere[] = $cond;
            }
        }
        if ($newWhere && substr($newWhere[0], 0, 3) == 'AND') {
            $newWhere[0] = substr($newWhere[0], 3); 
        }                      
        $select->setPart(Varien_Db_Select::WHERE, $newWhere); 
        return $select; 
    }
    
    /**
     * Enter description here ...
     * @param Varien_Db_Select $select
     * @return string
     */
    public function getPriceExpression($select) 
    {
        $collection = Mage::getResourceModel('catalog/product_collection');      
        $priceExpression = $collection->getPriceExpression($select) . ' ' . $collection->getAdditionalPriceExpression($select);
        return  $priceExpression;
    }
    
    /**
     * Retrieve array with products counts per price range
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @param array $ranges (23=>array(1,100), 24=>101-200)
     * @return array
     */
    public function getFromToCount($filter, $ranges)
    {
        $select = $this->_getSelect($filter);
        $countExpr  = new Zend_Db_Expr("COUNT(*)"); // may be add distinct ???
        $collection = Mage::getResourceModel('catalog/product_collection');
      
        $priceExpression = $this->getPriceExpression($select);
        
        $rangeExpr  = "CASE ";
        $price = $priceExpression;
        
        foreach($ranges as $n => $r) {
            $rangeExpr .= "WHEN ($price >= {$r[0]} AND $price < {$r[1]}) THEN $n ";
        }
        
        $rangeExpr .= " END";
        $rangeExpr = new Zend_Db_Expr($rangeExpr);

        $select->columns(array(
            'range' => $rangeExpr,
            'count' => $countExpr
        ));

        $select->group('range');
        
        return $this->_getReadAdapter()->fetchPairs($select);
    }
}
