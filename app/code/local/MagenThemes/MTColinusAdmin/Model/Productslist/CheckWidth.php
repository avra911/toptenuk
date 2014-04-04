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
class MagenThemes_MTColinusAdmin_Model_ProductsList_checkWidth extends Mage_Core_Model_Config_Data
{

    protected function _beforeSave(){
        $value     = $this->getValue();
        	if ((!is_numeric($value) && !empty($value)) || $value < 0) {
        	   throw new Exception('Width of thumbnail must be numeric.');
        	}
        return $this;
    }

}