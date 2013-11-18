<?php

class Ophirah_Qquoteadv_Block_Adminhtml_Qquoteadv_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Set quote template to display quote information in admin tab
	 * 
	 */
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('qquoteadv/quote.phtml');
    }

	/**
	 * Get Quote information from qquote_customer table
	 * @return object
	 */
	public function getQuoteData()
	{
		$quoteId = $this->getRequest()->getParam('id');
		$quote = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection()
					->addFieldToFilter('quote_id',$quoteId);
		return $quote; 
	}	

	public function getStatusArray()
	{
		return Mage::helper('qquoteadv')->getStatusArray();
	}
}