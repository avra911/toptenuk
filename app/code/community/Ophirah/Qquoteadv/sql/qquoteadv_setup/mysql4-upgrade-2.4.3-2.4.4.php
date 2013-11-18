<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'), "shipping_base_price", "DECIMAL(12,4) NOT NULL default '0.0000'");
$installer->endSetup();