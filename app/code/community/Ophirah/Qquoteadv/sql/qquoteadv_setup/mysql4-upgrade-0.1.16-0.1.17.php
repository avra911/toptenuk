<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$sql = "
SELECT country_id, customer_id  
FROM `{$this->getTable('qquoteadv/qqadvcustomer')}`
WHERE  is_quote=1 and  customer_id IN(
	SELECT customer_id  
	FROM `{$this->getTable('qquoteadv/qqadvcustomer')}` 
	WHERE is_quote=1 group by customer_id having count(customer_id)>1
) 
ORDER BY quote_id asc";

$result = $installer->getConnection()->fetchAll($sql);
$cacheSql = array();
foreach($result as $item)
{
	$countryId 	= $item['country_id'];
	$customerId = $item['customer_id'];
	
    $update = "UPDATE `{$this->getTable('qquoteadv/qqadvcustomer')}` SET country_id='".$countryId."' 
    			WHERE customer_id=".$customerId." and country_id=''";
	$installer->run($update);
}
$installer->endSetup();