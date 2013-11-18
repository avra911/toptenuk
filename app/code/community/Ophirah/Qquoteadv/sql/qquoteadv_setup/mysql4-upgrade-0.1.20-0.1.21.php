<?php

$installer = $this;
$level = Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE;

$attrQuote = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'allowed_to_quotemode');
$attrQuote->setIsGlobal($level)->save();     
$installer->endSetup();