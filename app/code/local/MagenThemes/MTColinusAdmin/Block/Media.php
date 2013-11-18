<?php
class MagenThemes_MTColinusAdmin_Block_Media extends Mage_Catalog_Block_Product_View_Media
{
	
	 public function _prepareLayout()
     {
		return parent::_prepareLayout();
     } 
     
     public function getThumbnailscroller()     
     { 
        if (!$this->hasData('thumbnailscroller')) {
            $this->setData('thumbnailscroller', Mage::registry('thumbnailscroller'));
        }
        return $this->getData('thumbnailscroller'); 
    } 
    
}