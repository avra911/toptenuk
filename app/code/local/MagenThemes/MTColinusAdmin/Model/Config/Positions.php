<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Positions
{ 
    public function toOptionArray()
    {        
        return array(
            array('value' => 'top-left', 'label'=>Mage::helper('adminhtml')->__('Top Left')),
            array('value' => 'top-right', 'label'=>Mage::helper('adminhtml')->__('Top Right'))
        );
    }
}
