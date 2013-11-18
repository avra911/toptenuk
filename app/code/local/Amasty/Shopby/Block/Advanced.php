<?php
class Amasty_Shopby_Block_Advanced extends Mage_Catalog_Block_Navigation
{
    public function drawOpenCategoryItem($category, $level = 0)
    {
        if(!$category->getIsActive() || !$category->getIncludeInMenu() || $category->getProductCount() == 0) {
            return '';
        }
        

        $cssClass = array(
            'amshopby-cat',
            'level' . $level
        );
        
        if ($this->_isCurrentCategory($category)) {
            $cssClass[] = 'active';
        }
        
        if ($this->isCategoryActive($category)) {
            $cssClass[] = 'parent';
        }

        if($category->hasChildren()) {
            $cssClass[] = 'has-child';
        }


        $productCount = '';
        if ($this->showProductCount()) {
            $productCount = $category->getProductCount();
            if ($productCount > 0) {
                $productCount = '(' . $productCount . ')';
            } else {
                $productCount = '';
            }
        }
        
        $html = array();
        $html[1] = '<a href="' . $this->getCategoryUrl($category) . '">' . $this->htmlEscape($category->getName()) . '</a>' . $productCount;
        
        $showAll   = Mage::getStoreConfig('amshopby/advanced_categories/show_all_categories');
        $showDepth = Mage::getStoreConfig('amshopby/advanced_categories/show_all_categories_depth');

        if (in_array($category->getId(), $this->getCurrentCategoryPath()) || ($showAll && $showDepth == 0) || ($showAll && $showDepth > $level + 1)) {
                
            $children = $this->_getCategoryCollection()->addIdFilter($category->getChildren());
            Mage::getSingleton('catalog/layer')->getProductCollection()
                ->addCountToCategories($children);
            $children = $this->asArray($children);
            
            $hasChild = false;
            
            if ($children && count($children) > 0) {
                $hasChild = true;
                $childCount = count($children);
            }
            if ($hasChild) {
                
                $children = $this->asArray($children);
                
                $htmlChildren = '';                
                foreach($children as $i => $child) {
                    $htmlChildren .= $this->drawOpenCategoryItem($child, $level + 1);
                }

                if($htmlChildren != '') {
                    $cssClass[] = 'expanded';
                    $html[2] = '<ul>' . $htmlChildren . '</ul>';
                }
            }
        }

        $html[0] = sprintf('<li class="%s">', implode(" ", $cssClass));
        $html[3] = '</li>';

        ksort($html);
        return implode('', $html);
    }

    /**
     * I need an array with the index being continunig numbers, so
     * it's possible to check for the previous/next category
     *
     * @param mixed $collection
     *
     * @return array
     */
    public function asArray($collection)
    {
        $array = array();
        foreach ($collection as $item) {
            $array[] = $item;
        }
        return $array;
    }


    protected function _isCurrentCategory($category)
    {
        $cat = $this->getCurrentCategory();
        if ($cat) {
            return ($cat->getId() == $category->getId());
        }
        return false;
    }


    /**
     * Get catagories of current store, using the max depth setting for the vertical navigation
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection
     */
    public function getCategories()
    {
        /* @var $category Mage_Catalog_Model_Category */
        $category = Mage::getModel('catalog/category');
        $parent = Mage::registry('current_category');
        
        $startFrom = Mage::getStoreConfig('amshopby/advanced_categories/start_category');
        
        switch($startFrom) {            
            case Amasty_Shopby_Model_Source_Category_Start::START_CHILDREN:
                break;
            case Amasty_Shopby_Model_Source_Category_Start::START_CURRENT:
                if ($parent) {
                    $parent = $parent->getParentCategory();
                }
                break;
            case Amasty_Shopby_Model_Source_Category_Start::START_ROOT:
                $parent = $category->load(Mage::app()->getStore()->getRootCategoryId());
                break;
            default:
                $parent = $category->load(Mage::app()->getStore()->getRootCategoryId());
        }
        
        if (!$parent) {
            $parent = $category->load(Mage::app()->getStore()->getRootCategoryId());
        }
        $storeCategories = $this->_getCategoryCollection()->addIdFilter($parent->getChildren());
        return $storeCategories;
    }

    protected function _getCategoryCollection()
    {
        $collection = Mage::getResourceModel('catalog/category_collection');
        
        $collection
            ->addAttributeToSelect('url_key')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('all_children')
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToFilter('include_in_menu', 1)
            ->setOrder('position', 'asc')
            ->joinUrlRewrite();
        
        if( $this->showProductCount() ) {
            $collection->setLoadProductCount(true);
        }
        
        return $collection;
    }

    public function showProductCount()
    {
        return Mage::getStoreConfigFlag('amshopby/advanced_categories/display_product_count');
    }
    
    protected function _toHtml()
    {
        $html = '';
        $cats = $this->getCategories();
        Mage::getSingleton('catalog/layer')->getProductCollection()
            ->addCountToCategories($cats);
        
        $store_categories = $this->asArray($cats);
        
        if (count($store_categories) > 0) {
             foreach ($store_categories as $i => $_category) {  
                 $html .= $this->drawOpenCategoryItem($_category, 0);
             } 
        }
        return $html;
    }
}
