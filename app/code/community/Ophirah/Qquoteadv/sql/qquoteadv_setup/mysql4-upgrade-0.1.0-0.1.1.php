<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

/**
 * Adding Attributes
 */

$setup->addAttribute('catalog_product', 'allowed_to_quotemode', array(
    'group'     	=> 'General',
	'input'         => 'select',
    'type'          => 'int',	
    'label'         => Mage::helper('qquoteadv')->__('Allowed to Quote Mode'),
	'source'        => 'qquoteadv/source_alloworder',    
	'backend'       => 'eav/entity_attribute_backend_array',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'       => true,
	/* 'used_for_price_rules'	=>	false */
	'required'		=> false,	
	'default_value' => '0'
));

$installer->endSetup();