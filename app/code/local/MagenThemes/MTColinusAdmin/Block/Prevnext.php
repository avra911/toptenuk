<?php
/*------------------------------------------------------------------------
# APL Solutions and Vision Co., LTD
# ------------------------------------------------------------------------
# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: APL Solutions and Vision Co., LTD
# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/
-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_Block_Prevnext extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('magenthemes/prevnext/prevnext.phtml');
    }
    public function getPreviousProduct()
    {
        return $this->helper('mtcolinusadmin')->getPreviousProduct();
    }
    public function getNextProduct()
    {
        return $this->helper('mtcolinusadmin')->getNextProduct();
    }
}