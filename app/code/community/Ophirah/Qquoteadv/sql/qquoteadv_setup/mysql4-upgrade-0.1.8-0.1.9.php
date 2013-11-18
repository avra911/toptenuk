<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('quoteadv_customer')} ADD `increment_id` varchar(50) NOT NULL DEFAULT '' AFTER `store_id`;");
$installer->endSetup(); 
