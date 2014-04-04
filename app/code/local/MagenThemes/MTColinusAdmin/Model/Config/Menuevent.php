<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
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
