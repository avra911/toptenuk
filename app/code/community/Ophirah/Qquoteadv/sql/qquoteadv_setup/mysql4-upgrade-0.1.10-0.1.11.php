<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'shipping_type',
'CHAR( 1 ) NOT NULL default "" after client_request');

$installer->endSetup();
