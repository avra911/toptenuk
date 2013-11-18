<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"hash",
"varchar(40)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_subtotal",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_grand_total",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_shipping_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_tax_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");


$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"grand_total",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"tax_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"subtotal",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"subtotal_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_shipping_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_subtotal_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");


$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"items_qty",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"items_count",
"int(10) unsigned NOT NULL default '0'");


$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"applied_taxes",
"text default NULL");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"applied_taxes",
"text default NULL");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_method",
"varchar(255)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_method_title",
"varchar(255)");


$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_carrier",
"varchar(255)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_carrier_title",
"varchar(255)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_method_title",
"varchar(255)");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_code",
"varchar(255)");
        
$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_description",
"varchar(255)")   ;    

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"address_shipping_description",
"varchar(255)")   ;   

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"address_shipping_method",
"varchar(255)")   ;   

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_amount_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_shipping_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");


$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_shipping_tax_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"shipping_tax_amount",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"base_shipping_amount_incl_tax",
"DECIMAL(12,4) NOT NULL default '0.0000'");

$installer->getConnection()->addColumn($installer->getTable('quoteadv_customer'),
"free_shipping",
"tinyint(1) default '0'");




$installer->endSetup();