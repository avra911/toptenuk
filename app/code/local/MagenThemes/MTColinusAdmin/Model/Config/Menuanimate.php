<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Menuanimate
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'Accordion', 'label'=>Mage::helper('adminhtml')->__('Accordion')),
            array('value'=>'Dropdown', 'label'=>Mage::helper('adminhtml')->__('Dropdown')),
            array('value'=>'Tree', 'label'=>Mage::helper('adminhtml')->__('Tree')),
        );
    }

}
