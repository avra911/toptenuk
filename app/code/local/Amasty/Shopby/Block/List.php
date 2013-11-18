<?php
/**
* @copyright Amasty.
*/  
class Amasty_Shopby_Block_List extends Mage_Core_Block_Template
{
    private $items = array();
    
    protected function _prepareLayout()
    {
        $entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
        $modelName  = Mage::helper('amshopby')->isVersionLessThan(1, 4) ? 'catalog/entity_attribute' : 'catalog/resource_eav_attribute';
        $attribute  = Mage::getModel($modelName) 
                ->loadByCode($entityTypeId, $this->getAttributeCode());
        
        if (!$attribute->getId()){
            return parent::_prepareLayout();
        }
          
        //1.3 only
        if (!$attribute->getSourceModel()){
            $attribute->setSourceModel('eav/entity_attribute_source_table'); 
        }
        
        $options = $attribute->getFrontend()->getSelectOptions();
        array_shift($options);
        
        $filter = new Varien_Object();
        // important when used at category pages
        $layer = Mage::getModel('catalog/layer')
            ->setCurrentCategory(Mage::app()->getStore()->getRootCategoryId());
        
        $filter->setLayer($layer);
        $filter->setStoreId(Mage::app()->getStore()->getId());
        $filter->setAttributeModel($attribute);
        
        $optionsCount = array();
        if (Mage::helper('amshopby')->isVersionLessThan(1, 4)){
            $category   = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
            $collection = $category->getProductCollection();
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
            
            $optionsCount = Mage::getSingleton('catalogindex/attribute')
                ->getCount($attribute, $collection->getSelect());
        }
        else {
            $optionsCount = Mage::getResourceModel('catalog/layer_filter_attribute')->getCount($filter);
        }
        
        usort($options, array($this, '_sortByName'));
                 
        // add images
        $ids = array();
        foreach ($options as $opt){
            $ids[] = $opt['value']; 
        }
        $collection = Mage::getResourceModel('amshopby/value_collection')
            ->addFieldToFilter('option_id', array('in'=>$ids))
            ->load();
        $images = array();
        foreach ($collection as $value){
            $images[$value->getOptionId()] = $value->getImgBig() ? Mage::getBaseUrl('media') . 'amshopby/' . $value->getImgBig() : ''; 
        }
        // end add images        
            
        $c = 0;
        $letters = array();
        $hlp    = Mage::helper('amshopby/url');
        foreach ($options as $opt){
            if (!empty($optionsCount[$opt['value']])){
                
                $opt['cnt'] = $optionsCount[$opt['value']];
                $opt['url'] = $hlp->getOptionUrl($attribute->getAttributeCode(), $opt['label'], $opt['value']);  
                $opt['img'] = isset($images[$opt['value']]) ? $images[$opt['value']] : '';
                
                //$i = mb_strtoupper(mb_substr($opt['label'], 0, 1, 'UTF-8'));
                $i = strtoupper(substr($opt['label'], 0, 1));
                
                if (!isset($letters[$i]['items'])){
                    $letters[$i]['items'] = array();
                }
                    
                $letters[$i]['items'][] = $opt;
               
                if (!isset($letters[$i]['count'])){
                    $letters[$i]['count'] = 0;
                }
                    
                $letters[$i]['count']++;
                
                ++$c;
            }
        }
        
        if (!$letters){
            return parent::_prepareLayout();
        }
        
        $itemsPerColumn = ceil(($c + sizeof($letters)) / max(1, abs(intVal($this->getColumns()))));

        $col = 0; // current column 
        $num = 0; // current number of items in column
        foreach ($letters as $letter => $items){
            $this->items[$col][$letter] = $items['items'];
            $num += $items['count'];
            $num++;
            if ($num >= $itemsPerColumn){
                $num = 0;
                $col++;
            }
        }
        
        return parent::_prepareLayout();
    }
    
    public function getItems()
    {
        return $this->items;
    }
    
    public function _sortByName($a, $b)
    {
         return strcmp(strtoupper($a['label']), strtoupper($b['label']));
    }

}