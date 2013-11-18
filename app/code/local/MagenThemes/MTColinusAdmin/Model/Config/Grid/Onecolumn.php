<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
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
