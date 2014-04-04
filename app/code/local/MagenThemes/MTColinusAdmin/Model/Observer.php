<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Model_Observer
{
    public function beforeLayoutRender($observer)
		{
			$layout = Mage::getSingleton('core/layout');
			if (($head = $layout->getBlock('head'))
				&& ($head instanceof Mage_Page_Block_Html_Head)) { 
				$configtheme = Mage::getStoreConfig('mtcolinusadmin/mtcolinusadmin_appearance/theme_styles');
				$enabledpanel = Mage::getStoreConfig('mtcolinusadmin/mtcolinusadmin_appearance/color_panel'); 
				$themeData = Mage::helper('core')->jsonDecode($_COOKIE['themeData']);
				$themestyles = isset($themeData['theme_styles']) ? $themeData['theme_styles'] : '';
				if($themestyles && $enabledpanel > 0){ 
					$head->removeItem('skin_css', 'css/styles-'.$configtheme.'.less');
					$head->addItem('skin_css', 'css/styles-'.$themestyles.'.less');
				} 
			}
		}
}
