<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
'proposal_quote_id',
'int(10) unsigned NOT NULL default 0');

$installer->endSetup();