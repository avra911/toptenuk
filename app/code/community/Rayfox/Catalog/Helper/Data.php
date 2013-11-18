<?php
class Rayfox_Catalog_Helper_Data extends Mage_CatalogInventory_Helper_Data
{
	const XML_PATH_SORT_OUT_OF_STOCK    = 'cataloginventory/options/sort_out_of_stock_at_bottom';
	
	public function isSortOutOfStockProductsAtBottomEnabled()
	{
		return $this->isShowOutOfStock() && Mage::getStoreConfigFlag(self::XML_PATH_SORT_OUT_OF_STOCK);
	}
}