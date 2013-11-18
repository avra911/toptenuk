<?php
/**
* @copyright Amasty.
*/ 
class Amasty_Shopby_Model_Mysql4_Decimal extends Mage_Catalog_Model_Resource_Eav_Mysql4_Layer_Filter_Decimal 
{
    /**
     * Initialize connection and define main table name
     *
     */
    protected function _construct()
    {
        parent::_construct();
    }
    
    /**
     * Apply attribute filter to product collection
     *
     * @param Mage_Catalog_Model_Layer_Filter_Decimal $filter
     * @param float $from
     * @param float $to
     * @return Amasty_Shopby_Model_Mysql4_Decimal
     */
    public function applyFilterToCollection($filter, $from, $to)
    {
        $collection = $filter->getLayer()->getProductCollection();
        $attribute  = $filter->getAttributeModel();
        $connection = $this->_getReadAdapter();
        
        $tableAlias = sprintf('%s_idx', $attribute->getAttributeCode());
        
        $conditions = array(
            "{$tableAlias}.entity_id = e.entity_id",
            $connection->quoteInto("{$tableAlias}.attribute_id = ?", $attribute->getAttributeId()),
            $connection->quoteInto("{$tableAlias}.store_id = ?", $collection->getStoreId()),
        );
        
        
        $collection->getSelect()->join(
            array($tableAlias => $this->getMainTable()),
            implode(' AND ', $conditions),
            array()
        );
        
        // bundle items has 2 records if single item has special price 
        if (Mage::getStoreConfig('amshopby/general/bundle')){
            $collection->getSelect()->distinct(true);
        }
        
        $minMax = $this->getMinMax($filter);
        
        $toSign = '<'; 
        if ($minMax[1] == $to) {
            $toSign = '<=';
        } 

        $collection->getSelect()
            ->where("{$tableAlias}.value >= ?", $from);
            
        if ($to > 0) {
            $collection->getSelect()->where("{$tableAlias}.value {$toSign} ?", $to);
        }
        
        return $this;
    }
    
    
    /**
     * Retrieve clean select with joined index table
     * Joined table has index
     *
     * @param Mage_Catalog_Model_Layer_Filter_Decimal $filter
     * @return Varien_Db_Select
     */
    protected function _getSelect($filter)
    {
        $collection = $filter->getLayer()->getProductCollection();
        
        // clone select from collection with filters
        $select = clone $collection->getSelect();
        // reset columns, order and limitation conditions
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);
        
        $attributeId = $filter->getAttributeModel()->getId();
        $storeId     = $collection->getStoreId();

        $select->join(
            array('decimal_index' => $this->getMainTable()),
            'e.entity_id = decimal_index.entity_id'.
            ' AND ' . $this->_getReadAdapter()->quoteInto('decimal_index.attribute_id = ?', $attributeId) .
            ' AND ' . $this->_getReadAdapter()->quoteInto('decimal_index.store_id = ?', $storeId),
            array()
        );
        
        $code = $filter->getAttributeModel()->getAttributeCode();
        
        $field = $code . "_idx.value";
        
        /*
         * Reset where condition of current filter
         */
        $oldWhere = $select->getPart(Varien_Db_Select::WHERE);
        $newWhere = array();
        
        foreach ($oldWhere as $cond) {
            if (false === strpos($cond, $field)) {
                $newWhere[] = $cond;
            }
        }
        if ($newWhere && substr($newWhere[0], 0, 3) == 'AND') {
            $newWhere[0] = substr($newWhere[0], 3); 
        }
                      
        $select->setPart(Varien_Db_Select::WHERE, $newWhere); 
        return $select;
    }
}