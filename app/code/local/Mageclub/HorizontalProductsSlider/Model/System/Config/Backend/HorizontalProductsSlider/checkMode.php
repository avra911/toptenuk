<?php
/*------------------------------------------------------------------------
# Copyright (C) 2011 - 2012 Qubesys Technologies Pvt.Ltd. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: Qubesys Technologies Pvt.Ltd
# Websites: http://www.qubesys.com 
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 


class Mageclub_HorizontalProductsSlider_Model_System_Config_Backend_HorizontalProductsSlider_checkMode extends Mage_Core_Model_Config_Data
{

    protected function _beforeSave(){
    	$groups = $this->getData('groups');
    	$datas = $groups['mageclub_horizontalproductsslider'];
    	if($datas['fields']['mode']['value']=='category' && $datas['fields']['catsid']['value']==''){
    		throw new Exception(Mage::helper('mageclub_horizontalproductsslider')->__('Please enter list of Categories ID.'));
    	}
       	elseif($datas['fields']['mode']['value']=='category' && $datas['fields']['leading_product']['value']=='' && $datas['fields']['intro_product']['value']=='' ){
    		throw new Exception(Mage::helper('mageclub_horizontalproductsslider')->__('Please enter Leading or Intro number.'));
    	}
        return $this;
    }

}
