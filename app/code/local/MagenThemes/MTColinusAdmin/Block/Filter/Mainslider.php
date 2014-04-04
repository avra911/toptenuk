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
    public function isContentMode()
    {
        $category = $this->getCurrentCategory();
        $res = false;
        if ($category->getDisplayMode()==Mage_Catalog_Model_Category::DM_PAGE) {
            $res = true;
            if ($category->getIsAnchor()) {
                $state = Mage::getSingleton('catalog/layer')->getState();
                if ($state && $state->getFilters()) {
                    $res = false;
                }
            }
        }
        return $res;
    }

    public function getCmsBlockHtml()
    {
        if (!$this->getData('cms_block_html')) {
            $html = $this->getLayout()->createBlock('cms/block')
                ->setBlockId($this->getCurrentCategory()->getLandingPage())
                ->toHtml();
            $this->setData('cms_block_html', $html);
        }
        return $this->getData('cms_block_html');
    }
    public function isProductMode()
    {
        return $this->getCurrentCategory()->getDisplayMode()==Mage_Catalog_Model_Category::DM_PRODUCT;
    }
    public function isMixedMode()
    {
        return $this->getCurrentCategory()->getDisplayMode()==Mage_Catalog_Model_Category::DM_MIXED;
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('content');
    }
	
}