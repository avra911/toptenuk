<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_ShowType
{ 
    public function toOptionArray()
    {        
        return array(
            array('value' => '', 'label'=>Mage::helper('adminhtml')->__('-- None --')),
            array('value' => 'category', 'label'=>Mage::helper('adminhtml')->__('Description Category')),
            array('value' => 'static', 'label'=>Mage::helper('adminhtml')->__('Static Blocks')) 
        );
    }
}
