<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$select = $installer->getConnection()->select();
$select
    ->from(array('result' => $installer->getTable('core_config_data')), array('value'))
    ->where('path LIKE "%carriers/qquoteshiprate/active%"');
   
;

$found = 0;

foreach ($installer->getConnection()->fetchAll($select) as $key =>$result) {
  $found++;
} 

if(!$found){
	$installer->run("
	INSERT INTO `{$this->getTable('core_config_data')}` (`config_id`,`path`,`value`) VALUES (NULL,'carriers/qquoteshiprate/active','1');
	INSERT INTO `{$this->getTable('core_config_data')}` (`config_id`,`path`,`value`) VALUES (NULL,'carriers/qquoteshiprate/name','Qquote Shipping Proposal Method');
	INSERT INTO `{$this->getTable('core_config_data')}` (`config_id`,`path`,`value`) VALUES (NULL,'carriers/qquoteshiprate/title','Qquote Shipping Proposal Name');
	");
}

$installer->endSetup();