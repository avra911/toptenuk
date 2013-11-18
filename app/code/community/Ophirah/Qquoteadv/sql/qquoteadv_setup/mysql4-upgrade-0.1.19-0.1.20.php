<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();
 
$installer->getConnection()->addColumn($installer->getTable('quoteadv_request_item'),
'quoteadv_product_id',
'int(10) unsigned NOT NULL');

$installer->run("
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
ALTER TABLE `{$installer->getTable('quoteadv_request_item')}`
    ADD CONSTRAINT `FK_quoteadv_product_id` FOREIGN KEY (`quoteadv_product_id`) REFERENCES `{$installer->getTable('quoteadv_product')}` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
");
     
$installer->endSetup();