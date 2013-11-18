<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'shipping_price',
'DECIMAL(12,4) NOT NULL default -1.0000');

$installer->endSetup();