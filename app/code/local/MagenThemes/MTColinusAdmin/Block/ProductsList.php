<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2012 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
-------------------------------------------------------------------------*/
class MagenThemes_MTColinusAdmin_Block_ProductsList extends Mage_Catalog_Block_Product_Abstract
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getMtProducts()
    {
        if (!$this->hasData('mtproductslist')) {
            $this->setData('mtproductslist', Mage::registry('mtproductslist'));
        }
        return $this->getData('mtproductslist');

    }
    public function getListCategory(){
        $storeId    = Mage::app()->getStore()->getId();
        $cateids = $this->getConfig('catsid');
        $arrCat = explode(',', $cateids);
        $category = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('entity_id', array('in' => $arrCat));
        return $category;
    }
    public function getListProducts($catsid)
    {
        $products = null;
        $products = $this->getProductByCategory($catsid);
        return $products;
    }

    function getProductByCategory($catsid){
        $mode=$this->getConfig('mode');
        $storeId    = Mage::app()->getStore()->getId();
        $return = array();
        $pids = array();
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
        $category = Mage::getModel('catalog/category')->load($catsid);
        $category->setIsAnchor(1);
        $products = Mage::getResourceModel ( 'catalog/product_collection')
            ->addCategoryFilter($category)
            ->addAttributeToSelect('*')
            ->setStoreId($storeId)
            ->addStoreFilter($storeId);
        if($mode=="mostviewed"){
            $products->addViewsCount();
        }
        if($mode=="featured"){
            $products->addAttributeToFilter("featured", 1);
        }
        if($mode=="new"){
            $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
            $products->addAttributeToFilter('news_from_date', array('date'=>true, 'to'=> $todayDate))
                ->addAttributeToFilter(array(array('attribute'=>'news_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'news_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
                ->addAttributeToSort('news_from_date','desc');
        }
        if($mode=="latest" || $mode=="bestseller"){
            $products->setOrder ($fieldorder,$order);
        }
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products);
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);

        return $products;
    }
    public function getConfig($att)
    {
        $config = Mage::getStoreConfig('mtcolinusadmin');
        if (isset($config['productslist']) ) {
            $value = $config['productslist'][$att];
            return $value;
        } else {
            throw new Exception($att.' value not set');
        }
    }
}