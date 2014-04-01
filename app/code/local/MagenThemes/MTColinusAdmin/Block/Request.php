<?php
/******************************************************
 * @package MtTabs module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.7.x.x
 * @author http://www.9magentothemes.com
 * @copyright (C) 2013- 9MagentoThemes.Com
 * @license PHP files are GNU/GPL
*******************************************************/
?>
<?php 
class MagenThemes_MTColinusAdmin_Block_Request extends Mage_Catalog_Block_Product_List
{
    const TEMPLATE = 'magenthemes/productslist/products.phtml';

    protected $_collection;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(self::TEMPLATE);
    }

    protected function _prepareCollection()
    {
        $storeId    = Mage::app()->getStore()->getId();
        if($this->getConfig('mode') == 'mostviewed'){
            $collection = Mage::getResourceModel('reports/product_collection');
        }else{
            $collection = Mage::getModel('catalog/product')->getCollection();
        }
        $collection->addAttributeToSelect('*');
		$collection->addMinimalPrice();
        $collection->setStoreId($storeId)
                   ->addStoreFilter($storeId); 
        return $collection;
    }

    public function getCollection()
    {
        if (!$this->_collection){
            $this->_collection = $this->_prepareCollection();
        }
        return $this->_collection;
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