<?php

class Ophirah_Qquoteadv_Model_Customer_Customer extends Mage_Customer_Model_Customer {

    /**
     * Send email with new account specific information
     *
     * @return Mage_Customer_Model_Customer
     */
    public function sendNewAccountEmail($type = 'registered', $backUrl = '', $storeId = '0')
    {
        $quoteadv_new_account = Mage::getStoreConfig('qquoteadv/emails/new_account');
		$types = array(
            'registered'   => self::XML_PATH_REGISTER_EMAIL_TEMPLATE,  // welcome email, when confirmation is disabled
            'confirmed'    => self::XML_PATH_CONFIRMED_EMAIL_TEMPLATE, // welcome email, when confirmation is enabled
            'confirmation' => self::XML_PATH_CONFIRM_EMAIL_TEMPLATE,   // email with confirmation link
			'registered_qquoteadv' => $quoteadv_new_account, // welcome email, when confirmation is disabled and account was created from qquoteadv
        );
        if (!isset($types[$type])) {
            throw new Exception(Mage::helper('customer')->__('Wrong transactional account email type.'));
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId($this->getSendemailStoreId());
        }

        /* @var $quote Ophirah_Qquoteadv_Model_Qqadvcustomer */
        $session = $this->getCustomerSession();
        if($session && ($quote = Mage::getModel('qquoteadv/qqadvcustomer')->load($session->getQuoteadvId())) && $quote->getId())
        {
            $sender = $quote->getEmailSenderInfo();
        }
        else
        {
            $sender = Mage::getStoreConfig(self::XML_PATH_REGISTER_EMAIL_IDENTITY);
        }

        if($type == 'registered_qquoteadv')
          $templateEmail = $types[$type];
        else
          $templateEmail = Mage::getStoreConfig($types[$type], $storeId);


        /* @var $template Mage_Core_Model_Email_Template */
        $template = Mage::getModel('core/email_template');

        $template->setDesignConfig(array('area' => 'frontend', 'store' => $storeId));
        $template->sendTransactional(
                        $templateEmail,                       
                        $sender,
                        $this->getEmail(),
                        $this->getName(),
                        array('customer' => $this, 'back_url' => $backUrl));

        $translate->setTranslateInline(true);

        return $this;
    }
}
