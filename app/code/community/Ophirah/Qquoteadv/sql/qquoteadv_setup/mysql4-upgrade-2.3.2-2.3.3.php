<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
'c2q_internal_quote_id',
'int(10)  default NULL');

$installer->addAttribute('order', 'c2q_internal_quote_id', array(
'type'              => 'static',
'group'             => '',
'backend'           => '',
'frontend'          => '',
'label'             => 'Internal C2Q Reference',
'input'             => 'text',
'class'             => '',
'source'            => '',
'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
'visible'           => false,
'required'          => false,
'user_defined'      => false,
'default'           => '0',
'searchable'        => false,
'filterable'        => false,
'comparable'        => false,
'visible_on_front'  => false,
'unique'            => false
));

$installer->endSetup();