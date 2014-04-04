<?php
/*------------------------------------------------------------------------
# ArexMage
# ------------------------------------------------------------------------
# Copyright (C) 2013 ArexMage. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: ArexMage
# Websites: http://www.arexmage.com
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