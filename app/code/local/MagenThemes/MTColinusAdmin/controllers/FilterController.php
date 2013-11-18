<?php

class MagenThemes_MTColinusAdmin_FilterController extends Mage_Core_Controller_Front_Action
{ 
	public function viewAction()
	{
		$categoryId=(int) $this->getRequest()->getParam('id', false);
		$category = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);
		Mage::register('current_category', $category);
		$this->loadLayout();
		$this->renderLayout();  
	} 
} 
?>
