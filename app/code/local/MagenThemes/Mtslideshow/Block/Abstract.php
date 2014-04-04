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
class MagenThemes_Mtslideshow_Block_Abstract extends Mage_Core_Block_Template
{
    protected $collection;
    protected $_position = null;

    public function getDataSlide()
    {
	$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
	
	if($this->_position == null)
	    return null;
	    
	if ($this->collection) {
	    return $this->collection;
	}
	    
	$this->collection = Mage::getModel('mtslideshow/mtslideshow')
		    ->getCollection()
		    ->addFieldToFilter('position',$this->_position)
		    ->addFieldToFilter('status', MagenThemes_Mtslideshow_Model_Status::STATUS_ENABLED);
	if (!Mage::app()->isSingleStoreMode()) {
	    $this->collection->addStoreFilter(Mage::app()->getStore());
	}
	    
	if (Mage::registry('current_category')) {
	    $_categoryId = Mage::registry('current_category')->getId();
	    $this->collection->addCategoryFilter($_categoryId);
	} elseif (Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms') {
	    $_pageId = Mage::getBlockSingleton('cms/page')->getPage()->getPageId();
	    $this->collection->addPageFilter($_pageId);
	}
	    
	$this->collection->setOrder('sort_order', 'ASC');
	    
	return $this->collection;
    }
}