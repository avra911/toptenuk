<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer->startSetup();

$entityTypeId = $this->getEntityTypeId('catalog_product');
$id = $this->getAttribute($entityTypeId, 'allowed_to_quotemode', 'attribute_id');
$data = array('frontend_input'=>'boolean', 'source_model'=>'');
$this->updateAttribute($entityTypeId, $id, $data);

$installer->endSetup();