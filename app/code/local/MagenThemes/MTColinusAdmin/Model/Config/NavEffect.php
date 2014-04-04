<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_NavEffect
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'show', 'label'=>Mage::helper('adminhtml')->__('Show/Hide')),
            array('value'=>'slide', 'label'=>Mage::helper('adminhtml')->__('Slide')),
            array('value'=>'fade', 'label'=>Mage::helper('adminhtml')->__('Fade')),
        );
    }

}
