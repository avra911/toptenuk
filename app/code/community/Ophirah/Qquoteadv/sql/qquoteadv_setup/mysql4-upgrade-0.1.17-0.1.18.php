<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'file_title',
'varchar(150) NULL');

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
'path',
'varchar(100) NULL');


$installer->endSetup();