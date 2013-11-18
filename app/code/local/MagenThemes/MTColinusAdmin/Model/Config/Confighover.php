<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Config_Confighover
{

    public function toOptionArray()
    {        
        return array(
            array('value'=>'show_text', 'label'=>Mage::helper('adminhtml')->__('Hover Show Text')),
            array('value'=>'show_image', 'label'=>Mage::helper('adminhtml')->__('Hover Show Change Images'))
        );
    }

}
