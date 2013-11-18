<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'store_id',
'smallint(5) unsigned NOT NULL');   
$installer->endSetup();