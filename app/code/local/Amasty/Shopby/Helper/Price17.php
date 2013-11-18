<?php

class Amasty_Shopby_Helper_Price17 extends Mage_Core_Helper_Abstract
{
    public function _getMaxMinPrice($filter, $ref)
    {
        if (!$ref->_maxMinPrice) {
            $select = clone $filter->getLayer()->getProductCollection()->getSelect();
    
            $select->reset(Zend_Db_Select::LIMIT_OFFSET);
            $select->reset(Zend_Db_Select::COLUMNS);
            $select->reset(Zend_Db_Select::LIMIT_COUNT);
            $select->reset(Zend_Db_Select::ORDER);
            
            /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
            $collection = Mage::getResourceModel('catalog/product_collection');
                  
            $priceExpression = $collection->getPriceExpression($select) . ' ' . $collection->getAdditionalPriceExpression($select);
            
            $select = $ref->_removePriceFromSelect($select, $priceExpression);
            
            $sqlEndPart = ') * ' . $collection->getCurrencyRate() . ')';
            $select->columns('CEIL(MAX(' . $priceExpression . $sqlEndPart . ' as max_price');
            $select->columns('FLOOR(MIN(' . $priceExpression . $sqlEndPart . ' as min_price');
            $select->where($collection->getPriceExpression($select) . ' IS NOT NULL');
            
            $ref->_maxMinPrice = $collection->getConnection()->fetchRow($select, array(), Zend_Db::FETCH_NUM); 
        }
        return $ref->_maxMinPrice;
    }
    
    /**
     * Retrieve maximal price
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMaxPrice($filter, $ref)
    {
        $prices = $ref->_getMaxMinPrice($filter);
        return $prices[0];
    }
    
    /**
     * Retrieve maximal price
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMinPrice($filter, $ref)
    {
        $prices = $ref->_getMaxMinPrice($filter);
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
    public function getFromToCount($filter, $ranges, $ref)
    {
        $select = $ref->_getSelect($filter);
        $countExpr  = new Zend_Db_Expr("COUNT(*)"); // may be add distinct ???
        $collection = Mage::getResourceModel('catalog/product_collection');
      
        $priceExpression = $ref->getPriceExpression($select);
        
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
        

        return $ref->_getReadAdapter()->fetchPairs($select);
    }
}
