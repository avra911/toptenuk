<?php
/*------------------------------------------------------------------------
# Copyright (C) 2011 - 2012 Qubesys Technologies Pvt.Ltd. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: Qubesys Technologies Pvt.Ltd
# Websites: http://www.qubesys.com 
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 

class Mageclub_HorizontalProductsSlider_Model_System_Config_Source_ListDirection{
    public function toOptionArray()
    {
        return array(        	
            array('value'=>'left', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Left')),
            array('value'=>'right', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Right')),
        );
    }    
}