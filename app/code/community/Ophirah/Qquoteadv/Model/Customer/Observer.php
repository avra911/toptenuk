<?php
class Ophirah_Qquoteadv_Model_Customer_Observer
{

    public function before($observer)
    {
        Mage::log('before:'.Mage::getSingleton('customer/session')->getQuoteadvId());

        $lastQuote = Mage::getSingleton('customer/session')->getQuoteadvId();
        Mage::getSingleton('customer/session')->getLastQuoteadvId($lastQuote);
        return $this;
    }


    public function updateCustomerQuoteadv( $observer ){

        if(Mage::helper('customer/data')->isLoggedIn() ){
            Mage::getSingleton('customer/session')->setQuoteadvId(null); 
        }
		return $this;
	}
}