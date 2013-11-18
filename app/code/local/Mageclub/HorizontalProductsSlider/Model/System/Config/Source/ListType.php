<?php
/*------------------------------------------------------------------------
# Copyright (C) 2011 - 2012 Qubesys Technologies Pvt.Ltd. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: Qubesys Technologies Pvt.Ltd
# Websites: http://www.qubesys.com 
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 


class Mageclub_HorizontalProductsSlider_Model_System_Config_Source_ListType
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('-- Please select --')),
            array('value'=>'latest', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Latest')),
            array('value'=>'best_buy', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Best Buy')),
            array('value'=>'most_viewed', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Most Viewed')),
            array('value'=>'most_reviewed', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Most Reviewed')),
            array('value'=>'top_rated', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Top Rated')),
            array('value'=>'attribute', 'label'=>Mage::helper('mageclub_horizontalproductsslider')->__('Featured Product')),
        );
    }    
}
