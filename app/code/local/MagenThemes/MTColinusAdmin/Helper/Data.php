<?php
class MagenThemes_MTColinusAdmin_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getListPattern($path){ 
		$directory = Mage::getBaseDir('media').DS.'magenthemes'.DS.$path;
		$urlparth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$images = array();
		if (is_dir($directory) && $dh = opendir($directory)) { 
			while (($file = readdir($dh)) !== false) {
				if(is_file($directory.DS.$file)){
					$filetype = substr($file, -3, 3);
					switch ($filetype)
					{ 
						case 'jpg':
						case 'png':
						case 'gif':  
							$images[] = $file; 
							break; 
					}
				} 
			}  
		} 
		return $images;
	}
	protected function _loadProduct(Mage_Catalog_Model_Product $product)
    {
        $product->load($product->getId());
    }

    public function getLabel(Mage_Catalog_Model_Product $product)
    {
        if ( 'Mage_Catalog_Model_Product' != get_class($product) )
            return; 
        $html = '';
        if (!Mage::getStoreConfig("mtcolinusadmin/product/product_show_newlabel") &&
            !Mage::getStoreConfig("mtcolinusadmin/product/product_show_salelabel") ) {
            return $html;
        } 
        $this->_loadProduct($product);

        if ( Mage::getStoreConfig("mtcolinusadmin/product/product_show_newlabel") && $this->_checkNew($product) ) {
            $html .= '<div class="product-new-label new-'.Mage::getStoreConfig('mtcolinusadmin/product/product_newlabel_positions').'"></div>';
        }
        if ( Mage::getStoreConfig("mtcolinusadmin/product/product_show_salelabel") && $this->_checkSale($product) ) {
            $html .= '<div class="product-sale-label sale-'.Mage::getStoreConfig('mtcolinusadmin/product/product_salelabel_positions').'"></div>';
        }

        return $html;
    }
	protected function _checkDate($from, $to)
    {
        $today = strtotime(
            Mage::app()->getLocale()->date()
            ->setTime('00:00:00')
            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
        );   
        if ($from && $today < $from) {
            return false;
        }
        if ($to && $today > $to) {
            return false;
        }
        if (!$to && !$from) {
            return false;
        }
        return true;
    }
    protected function _checkNew($product)
    {
        $from = strtotime($product->getData('news_from_date'));
        $to = strtotime($product->getData('news_to_date'));

        return $this->_checkDate($from, $to);
    }

    protected function _checkSale($product)
    {
        $from = strtotime($product->getData('special_from_date')); 
        $to = strtotime($product->getData('special_to_date'));

        return $this->_checkDate($from, $to);
    } 
    
    public function getPreviousProduct()
    {
        $prodId = Mage::registry('current_product')->getId(); 
        $positions = Mage::getSingleton('core/session')->getPrevNextProductCollection();  
        if (!$positions && Mage::registry('current_category')) {
            $current_category = Mage::registry('current_category');
            if (get_class($current_category->getResource()) != 'Mage_Catalog_Model_Resource_Category_Flat') {
                $positions = array_reverse(array_keys($current_category->getProductsPosition()));
            }
        }  
        if (!$positions) {
            $positions = array();
        } 
        $pps = @array_search($prodId, $positions); 
        $slice = array_reverse(array_slice($positions, 0, $pps)); 
        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId); 
            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        } 
        return false;
    }

    public function getNextProduct()
    {
        $prodId = Mage::registry('current_product')->getId(); 
        $positions = Mage::getSingleton('core/session')->getPrevNextProductCollection(); 
        if (!$positions && Mage::registry('current_category')) {
            $current_category = Mage::registry('current_category');
            if (get_class($current_category->getResource()) != 'Mage_Catalog_Model_Resource_Category_Flat') {
                $positions = array_reverse(array_keys($current_category->getProductsPosition()));
            }
        }
        if (!$positions) {
            $positions = array();
        } 
        $pps = @array_search($prodId, $positions); 
        $slice = array_slice($positions, $pps + 1, count($positions)); 
        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId); 
            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        } 
        return false;
    }
}