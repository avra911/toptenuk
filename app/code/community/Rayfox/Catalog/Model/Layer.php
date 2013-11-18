<?php
class Rayfox_Catalog_Model_Layer extends Mage_Catalog_Model_Layer
{
	public function prepareProductCollection($collection)
	{
		//call parent prepareProductCollection
		parent::prepareProductCollection($collection);
		
		//check enabled
		if(!Mage::helper('rayfox_catalog')->isSortOutOfStockProductsAtBottomEnabled()){
			return $this;
		}

		//sort by stock status
		if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            Mage::getModel('cataloginventory/stock_item')->addCatalogInventoryToProductCollection($collection);
        }
        
        $collection->getSelect()->order('is_in_stock desc');
       
		return $this;
	}
}