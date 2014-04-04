<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/
?>
<?php

class MagenThemes_MTColinusAdmin_Block_Bestseller extends Mage_Catalog_Block_Product_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $config = Mage::getStoreConfig('mtcolinusadmin/product');
        $qty = $config['product_bestseller_numb'];
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('*');
        $orderItems = $this->getTableName('sales/order_item');
        $orderMain = $this->getTableName('sales/order');
        $collection->getSelect()
            ->join(array('items'=>$orderItems), "items.product_id = e.entity_id", array('count'=>'SUM(items.qty_ordered)'))
            ->join(array('trus'=>$orderMain),"items.order_id = trus.entity_id",array())
            ->where('trus.status = ?', 'complete')
            ->group('e.entity_id')
            ->order('count DESC');
        $collection->setPageSize($qty)->setCurPage(1);
        $this->setProductCollection($collection);
    }
    public function getTableName($modelEntity)
    {
        try {
            $table = Mage::getSingleton('core/resource')->getTableName($modelEntity);
        } catch (Exception $e){
            Mage::throwException($e->getMessage());
        }
        return $table;
    }
}

?>