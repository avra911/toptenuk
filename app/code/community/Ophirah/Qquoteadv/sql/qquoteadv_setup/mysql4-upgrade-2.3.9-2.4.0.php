<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"currency",
"varchar(4)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"no_expiry",
"tinyint(1) default '0'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_to_quote_rate",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'expiry',
'date');

$installer->getConnection()->addColumn($installer->getTable('quoteadv_request_item'),
"owner_cur_price",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_request_item'),
"original_cur_price",
"DECIMAL(12,4) NOT NULL default '0.0000'");


//ALTER TABLE quoteadv_request_item DROP FOREIGN KEY `FK_quoteadv_product_id`

$installer->endSetup();