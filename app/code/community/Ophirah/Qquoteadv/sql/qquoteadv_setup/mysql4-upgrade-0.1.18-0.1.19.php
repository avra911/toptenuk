<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();
  
$installer->getConnection()->addColumn($installer->getTable('quoteadv_product'),
'has_options',
'CHAR(1) NOT NULL default "0" after client_request');

$installer->getConnection()->addColumn($installer->getTable('quoteadv_product'),
'options',
'text NOT NULL');
     
$installer->endSetup();