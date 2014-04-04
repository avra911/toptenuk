<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_ThemeStyles
{ 
    public function toOptionArray()
    {        
        return array(
            array('value' => 'blue', 'label'=>Mage::helper('adminhtml')->__('Sea Blue')),
            array('value' => 'red', 'label'=>Mage::helper('adminhtml')->__('Red')),
			 array('value' => 'green', 'label'=>Mage::helper('adminhtml')->__('Green')),
        	array('value' => 'custom', 'label'=>Mage::helper('adminhtml')->__('Custom'))
        );
    }
}
