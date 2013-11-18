<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();
$update = "ALTER TABLE {$this->getTable('quoteadv_customer')} CHANGE `path` `path` VARCHAR( 255 )";
$installer->run($update);
$installer->endSetup();