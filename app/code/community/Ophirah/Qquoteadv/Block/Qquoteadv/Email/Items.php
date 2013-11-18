<?php
class Ophirah_Qquoteadv_Block_Qquoteadv_Email_Items extends Mage_Sales_Block_Items_Abstract//Mage_Core_Block_Template
{
   public $autoproposal = 0;

   public function getQuote() {
        $quoteId = $this->getRequest()->getParam('id');
        if (!$quoteId){
            if($quoteObj = $this->getData('quote')) {
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
    //#set value from template
    public function setAutoproposal($val){
      $this->autoproposal = $val;
      return $this;
    }
    
    public function isSetAutoProposal(){
      return $this->autoproposal;
    }   
}
