<?php
/*------------------------------------------------------------------------
# Copyright (C) 2011 - 2012 Qubesys Technologies Pvt.Ltd. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: Qubesys Technologies Pvt.Ltd
# Websites: http://www.qubesys.com 
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 
class Mageclub_HorizontalProductsSlider_Model_System_Config_Backend_HorizontalProductsSlider_checkMax extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave(){
        $value     = $this->getValue();
        	if ((!is_numeric($value) && !empty($value)) || $value < 0) {
        	    throw new Exception(Mage::helper('mageclub_horizontalproductsslider')->__('Description Max Length.'));
        	}
        return $this;
    }
}
