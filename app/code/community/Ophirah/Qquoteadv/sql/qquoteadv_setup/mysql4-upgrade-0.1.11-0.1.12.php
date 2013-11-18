<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'allowed_to_quotemode', array(
    'default_value' => '0',
));

$installer->endSetup(); 

