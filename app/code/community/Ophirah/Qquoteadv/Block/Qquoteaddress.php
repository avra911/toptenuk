<?php

class Ophirah_Qquoteadv_Block_Qquoteaddress extends Mage_Core_Block_Template {

  public function _prepareLayout() {
	return parent::_prepareLayout();
  }

  /**
   * Get customer session data
   * @return session data
   */
  public function getCustomerSession() {
	return Mage::getSingleton('customer/session');
  }

  public function getCustomerEmail() {
	return $this->getCustomerSession()->getCustomer()->getEmail();
  }

  public function isCustomerLoggedIn() {
	return $this->getCustomerSession()->isLoggedIn();
  }
  
  public function getValue($fieldname, $type) {
	if ($value = $this->_getRegisteredValue($type)) {
	  if ($fieldname == "street1") {
		$street = $value->getData('street');
		if (is_array($street)) {
		  $street = explode("\n", $street);
		  return $street[0];
		} else {
		  return "";
		}
	  }

	  if ($fieldname == "street2") {
		$street = $value->getData('street');

		if (is_array($street)) {
		  $street = explode("\n", $street);
		  return $street[1];
		} else {
		  return "";
		}
	  }

	  if ($fieldname == "email") {
		return $this->getCustomerSession()->getCustomer()->getEmail();
	  }

	  if ($fieldname == "country") {
		$countryCode = $value->getData("country_id");
		return $countryCode;
	  }
	  return $value->getData($fieldname);
	}
  }

  protected function _getRegisteredValue($type = 'billing') {

	if ($type == 'billing') {
	  return $this->getCustomerSession()->getCustomer()->getPrimaryBillingAddress();
	}

	if ($type == 'shipping') {
	  return $this->getCustomerSession()->getCustomer()->getPrimaryShippingAddress();
	}
  }

  public function getLoginUrl() {

	if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) {
	  return $this->getUrl('customer/account/login/', array('referer' => $this->getUrlEncoded('*/*/*', array('_current' => true))));
	}

	return $this->getUrl('customer/account/login/');
  }
}