<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights

Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_ProductsList_Config_Layout
{ 
    public function toOptionArray()
    {     
    	return array(
            array('value'=>'isotope', 'label'=>Mage::helper('adminhtml')->__('Isotope')),
            array('value'=>'tab', 'label'=>Mage::helper('adminhtml')->__('Tab')) 
        ); 
    } 
}
