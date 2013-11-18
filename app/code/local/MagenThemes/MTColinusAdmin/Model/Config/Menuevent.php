<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Menuevent
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'mouseover', 'label'=>Mage::helper('adminhtml')->__('Mouse Over')),
            array('value'=>'click', 'label'=>Mage::helper('adminhtml')->__('Click'))
        );
    }

}
