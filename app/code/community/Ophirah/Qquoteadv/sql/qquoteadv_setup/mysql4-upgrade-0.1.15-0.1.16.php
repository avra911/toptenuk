<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$sql = "SELECT request_id, product_id FROM {$this->getTable('quoteadv_request_item')}  where original_price = 0";
$result = $installer->getConnection()->fetchAll($sql);
$cacheSql = array();
foreach($result as $item)
{
	$requestId = $item['request_id'];
	$productId = $item['product_id'];
	$price = 0;  
	 
    $sqlSearch = " 
				SELECT distinct final_price
				FROM `{$this->getTable('catalog_product_entity')}`  AS `e` 
				INNER JOIN  `{$this->getTable('catalog_product_index_price')}` AS `indprice` 
				ON indprice.entity_id = e.entity_id 
				where indprice.entity_id=$productId";
	
	$cacheSql[$productId] = $sqlSearch; 
	$searchResult = $installer->getConnection()->fetchAll($sqlSearch);
	
	foreach( $searchResult as $res){
		$price = $res['final_price'];
		if($price>0){
		  $update = "UPDATE {$this->getTable('quoteadv_request_item')} SET `original_price`='".$price."' WHERE (`request_id`='".$requestId."')";
		  $installer->run($update);
		}
	}
}
$installer->endSetup();