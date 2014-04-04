<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Confighover
{

    public function toOptionArray()
    {        
        return array(
            array('value'=>'show_text', 'label'=>Mage::helper('adminhtml')->__('Show text on hover')),
            array('value'=>'show_image', 'label'=>Mage::helper('adminhtml')->__('Change image on hover'))
        );
    }

}
