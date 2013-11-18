<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
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
