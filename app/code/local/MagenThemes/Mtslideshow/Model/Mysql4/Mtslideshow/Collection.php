<?php
/******************************************************
 * @package MT Slideshow module for Magento 1.4.x.x, Magento 1.5.x.x and Magento 1.6.x.x
 * @version 2.0.0
 * @author http://www.magentheme.com
 * @copyright (C) 2011- MagenTheme.Com
 * @license PHP files are GNU/GPL
*******************************************************/
?>
<?php
class MagenThemes_Mtslideshow_Model_Mysql4_Mtslideshow_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mtslideshow/mtslideshow');
    }
    
    public function addStoreFilter($store) {
        if (!Mage::app()->isSingleStoreMode()) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            $this->getSelect()->join(
                    array('store_table' => $this->getTable('mtslideshow/store')),
                    'main_table.slide_id = store_table.slide_id',
                    array()
                    )
                    ->where('store_table.store_id in (?)', array(0, $store));
            return $this;
        }
        return $this;
    }
    
    public function addCategoryFilter($categoryId) {
        $this->getSelect()->join(
                array('category_table' => $this->getTable('mtslideshow/category')),
                'main_table.slide_id = category_table.slide_id',
                array()
                )
                ->where('category_table.category_id = ?', $categoryId);
        return $this;
    }
    
    public function addPageFilter($pageId) {
        $this->getSelect()->join(
                array('page_table' => $this->getTable('mtslideshow/page')),
                'main_table.slide_id = page_table.slide_id',
                array()
                )
                ->where('page_table.page_id = ?', $pageId);
        return $this;
    }
}