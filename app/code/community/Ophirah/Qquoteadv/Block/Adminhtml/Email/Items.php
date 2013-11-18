<?php
class Ophirah_Qquoteadv_Block_Adminhtml_Email_Items extends Mage_Sales_Block_Items_Abstract//Mage_Core_Block_Template
{

    public function getQuote() {
        $quoteId = $this->getRequest()->getParam('id');
        if(!$quoteId){
            $quoteObj   = $this->getData('quote');
            if(is_object($quoteObj)) {
                $quoteId    = $quoteObj->getQuoteId();
            }
        }
        
        if ($quoteId) {
            $quoteData = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection()
                            ->addFieldToFilter('quote_id', $quoteId);

            foreach ($quoteData as $key => $quote) {
                $this->setQuoteId($quoteId);
                return $quote;
            }
        }
        return;
    }

     /**
     * Get Product information from qquote_product table
     * @return quote object
     */
    public function getAllItems() {
        $collection = Mage::getModel('qquoteadv/qqadvproduct')->getQuoteProduct($this->getQuoteId());

        return  $collection;
    }
}