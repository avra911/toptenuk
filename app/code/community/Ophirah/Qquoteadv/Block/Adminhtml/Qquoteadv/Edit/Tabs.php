<?php

class Ophirah_Qquoteadv_Block_Adminhtml_Qquoteadv_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('qquote_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('qquoteadv')->__('Quote view'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('product', array(
          'label'     => Mage::helper('qquoteadv')->__('Quote request'),
          'title'     => Mage::helper('qquoteadv')->__('Quote request'),
          'content'   => $this->getLayout()->createBlock('qquoteadv/adminhtml_qquoteadv_edit_tab_product')->toHtml(),
      ));
      
/*      $this->addTab('customer', array(
          'label'     => Mage::helper('qquoteadv')->__('Quote request information'),
          'title'     => Mage::helper('qquoteadv')->__('Quote request information'),
          'content'   => $this->getLayout()->createBlock('qquoteadv/adminhtml_qquoteadv_edit_tab_customer')->toHtml(),
      ));
      
      $this->addTab('form_section', array(
          'label'     => Mage::helper('qquoteadv')->__('Optional Information'),
          'title'     => Mage::helper('qquoteadv')->__('Optional Information'),
          'content'   => $this->getLayout()->createBlock('qquoteadv/adminhtml_qquoteadv_edit_tab_form')->toHtml(),
      ));*/
	  
	 
	  
	  
     
      return parent::_beforeToHtml();
  }
}