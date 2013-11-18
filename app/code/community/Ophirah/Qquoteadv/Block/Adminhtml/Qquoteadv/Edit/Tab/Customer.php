<?php

class Ophirah_Qquoteadv_Block_Adminhtml_Qquoteadv_Edit_Tab_Customer extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Set customer template to display customer information in admin tab
	 * 
	 */
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('qquoteadv/customer.phtml');
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
	
	/**
	 * Get country name by country code
	 * @param string $countryCode
	 * @return string country name
	 */
	 public function getCountryName($countryCode)
	 {
		return Mage::getModel('directory/country')->load($countryCode)->getName();
	 }
}