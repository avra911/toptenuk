<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2008-2012 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/
class MagenThemes_MTColinusAdmin_Block_Request_Products extends MagenThemes_MTColinusAdmin_Block_Request
{
    protected function _prepareCollection() {
        $collection = parent::_prepareCollection();
        $mode=$this->getConfig('mode');
        switch ($mode) {
            case 'latest' :
                $fieldorder = 'updated_at';
                $order = 'desc';
                break;
            case 'bestseller' :
                $fieldorder = 'ordered_qty';
                $order = 'desc';
                break;
        }
        $category = Mage::getModel('catalog/category')->load($this->getIndex());
        $category->setIsAnchor(1);
        $collection->addCategoryFilter($category);
        $collection->joinField('stock_status','cataloginventory/stock_status','stock_status',
        'product_id=entity_id', array(
          'stock_status' => Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK,
          'website_id' => Mage::app()->getWebsite()->getWebsiteId(),
        ));
        if($mode=="mostviewed"){
            $collection->addViewsCount();
        }
        if($mode=="featured"){
            $collection->addAttributeToFilter("featured", 1);
        }
        if($mode=="new"){
            $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
            $collection->addAttributeToFilter('news_from_date', array('date'=>true, 'to'=> $todayDate))
                ->addAttributeToFilter(array(array('attribute'=>'news_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'news_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
                ->addAttributeToSort('news_from_date','desc');
        }
        if($mode=="latest" || $mode=="bestseller"){
            $collection->setOrder ($fieldorder,$order);
        }
        $collection->setPageSize($this->getConfig('qty'))->setCurPage(1);
        return $collection;
    }
}