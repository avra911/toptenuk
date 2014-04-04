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
class MagenThemes_MTColinusAdmin_Model_Config_ThumbDirection
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'horizontal', 'label'=>Mage::helper('adminhtml')->__('Horizontal')),
            array('value'=>'vertical', 'label'=>Mage::helper('adminhtml')->__('Vertical'))
        );
    }

}
