<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Grid_Onecolumn
{ 
	public function toOptionArray()
    {
        return array(
            array('value'=>'1', 'label'=>Mage::helper('adminhtml')->__('1 Columns')),
            array('value'=>'2', 'label'=>Mage::helper('adminhtml')->__('2 Columns')),
            array('value'=>'3', 'label'=>Mage::helper('adminhtml')->__('3 Columns')),
        	array('value'=>'4', 'label'=>Mage::helper('adminhtml')->__('4 Columns')),
        	array('value'=>'6', 'label'=>Mage::helper('adminhtml')->__('6 Columns'))
        );
    }  
}
