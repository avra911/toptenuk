<?php
class MagenThemes_MTColinusAdmin_Block_Filter_Mainslider extends Mage_Core_Block_Template
{

    public function IsRssCatalogEnable()
    {
        return Mage::getStoreConfig('rss/catalog/category');
    }

    public function IsTopCategory()
    {
        return $this->getCurrentCategory()->getLevel()==2;
    }
	public function getCurrentCategory()
    {	 
        if (!$this->hasData('current_category')) { 
            $this->setData('current_category', Mage::registry('current_category'));
        }
        return $this->getData('current_category');
    }
	public function getRssLink()
    {
        return Mage::getUrl('rss/catalog/category',array('cid' => $this->getCurrentCategory()->getId(), 'store_id' => Mage::app()->getStore()->getId()));
    }
	
}