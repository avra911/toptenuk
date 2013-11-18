<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
-------------------------------------------------------------------------*/
?>
<?php

class MagenThemes_MTColinusAdmin_Block_Bestseller extends Mage_Catalog_Block_Product_Abstract
{
    public function __construct()
    {
        parent::__construct();

        $storeId    = Mage::app()->getStore()->getId();
        $config = Mage::getStoreConfig('mtcolinusadmin/product');
        $qty = $config['product_bestseller_numb'];
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect('*')
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc');

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

        $products->setPageSize($qty)->setCurPage(1);

        $this->setProductCollection($products);
    }
}

?>