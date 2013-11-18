<?php

class Ophirah_Qquoteadv_Model_Observer
{
      /**
     * Change status to Request expired 
     */
	public function updateStatusRequest()
    {   
        $now = Mage::getSingleton('core/date')->gmtDate(); 
        $items = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
        $items->addFieldToFilter('status', Ophirah_Qquoteadv_Model_Status::STATUS_REQUEST);
        $items->getSelect()->group('store_id');
        if($items->getSize() >0 ){
          $data = $items->getData();

          foreach($data as $unit) { 
            $storeId  = $unit['store_id'];
            $day = Mage::getStoreConfig('qquoteadv/general/expirtime_proposal', (int)$storeId);            
        
            $now = Mage::getSingleton('core/date')->gmtDate(); 
            $collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
            $collection->addFieldToFilter('status', Ophirah_Qquoteadv_Model_Status::STATUS_REQUEST);
            $collection->getSelect()
            ->where('created_at<INTERVAL -' . $day . ' DAY + \'' . $now . '\'');
            $collection->load();       

            foreach ($collection as $item) {               
              $item->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_REQUEST_EXPIRED);
              $item->save();  
            }
          }
        }
    }
    
    /**
    * Change status to Proposal expired 
    */
    public function updateStatusProposal()
    {        
        $now = Mage::getSingleton('core/date')->gmtDate("Y-m-d"); 
        $collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
        $collection->addFieldToFilter('status', Ophirah_Qquoteadv_Model_Status::STATUS_PROPOSAL);
        $collection->getSelect()->where('expiry < \''.$now.'\' AND no_expiry = \'0\'');
        $collection->load();       

        foreach ($collection as $item) {         
                $item->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_PROPOSAL_EXPIRED);
                $item->save();  
        }
    }

     /**
     * Switch between default layout and c2q module layout
     */
	public function switchQuoteLayout( $observer ){
      $updatesRoot =  $observer->getUpdates();
      $moduleName = 'qquoteadv';
      $enabled = Mage::getStoreConfig('qquoteadv/general/enabled', Mage::app()->getStore()->getStoreId());
      if($enabled && !Mage::getStoreConfig('qquoteadv/layout/active_c2q_tmpl') && !Mage::app()->getStore()->isAdmin() ){
        foreach ($updatesRoot->children() as $updateNode) {
          if( $moduleName == $updateNode->getName()){
            $dom=dom_import_simplexml($updateNode);
            $dom->parentNode->removeChild($dom);
          }
        }
      }
      return $this;
    }

    public function setCustomPrice( $observer ){ 
        $customPrice = Mage::registry('customPrice');
        if( isset($customPrice) ){
            if(Mage::helper('customer/data')->isLoggedIn() || Mage::getSingleton('admin/session')->isLoggedIn() ){
                $quote_item = $observer->getQuoteItem()->getParentItem();
                if (!$quote_item) {                    
                    $quote_item = $observer->getQuoteItem(); 
                }
                $quote_item->setCustomPrice($customPrice)->setOriginalCustomPrice($customPrice); 
            }
            
            //#
            Mage::unregister('customPrice');
        }
		return $this;
	}
    
    public function setAdminCustomPrice( $observer ){ 
        if(Mage::getSingleton('admin/session')->isLoggedIn() ){ 
          $customPrice = Mage::registry('customPrice');
          if( isset($customPrice) ){

                  $event = $observer->getEvent();
                  $quote_item = $event->getQuoteItem();

                  $quote_item->setCustomPrice($customPrice)->setOriginalCustomPrice($customPrice); 

                  try{
                      $quote_item->save();
                  } catch (Exception $e) { 
                    Mage::log($e->getMessage());
                  }

              Mage::unregister('customPrice');
          }
        }
		return $this;
	}    
    
    public function disableRemoveQuoteItem(Varien_Event_Observer $observer ){
		if (Mage::helper('qquoteadv')->isActiveConfirmMode()) {
			$product = $observer->getQuoteItem();
			$product->isDeleted(false);
			
			$message =  Mage::helper('qquoteadv')->__('Action is blocked in quote confirmation mode');
            Mage::getSingleton('checkout/session')->addError($message);
		}
		return $this;
	}
    //#log out from quote confirmation mode
    public function logoutFromQuoteConfirmationMode(Varien_Event_Observer $observer ) {        
        if ( Mage::helper('qquoteadv')->isActiveConfirmMode()) {            
            Mage::helper('qquoteadv')->setActiveConfirmMode(false); 
        }
     }
  
    public function disableQtyUpdate(Varien_Event_Observer $observer ) {
        if ( Mage::helper('qquoteadv')->isActiveConfirmMode()) {
			$cartData = Mage::app()->getRequest()->getParam('cart');
			foreach ($cartData as $index => $data) {
				if (isset($data['qty'])) {
					$cartData[$index]['qty'] = null;
				}
			}
			Mage::app()->getRequest()->setParam('cart', $cartData);

			$link = Mage::getUrl('qquoteadv/view/outqqconfirmmode');
			$message = Mage::helper('qquoteadv')->__("To update item in the Shopping cart <a href='%s'>log out</a> from Quote confirmation mode.",$link);
            Mage::getSingleton('checkout/session')->addNotice($message);
        }

    }

    public function disableUpdateItemOptions(Varien_Event_Observer $observer ) {   
        if ( Mage::helper('qquoteadv')->isActiveConfirmMode()) {		   

			Mage::app()->getRequest()->setParam('id', null);

            $message =  Mage::helper('qquoteadv')->__('Action is blocked in quote confirmation mode');
            Mage::getSingleton('checkout/session')->addError($message);

			$link = Mage::getUrl('qquoteadv/view/outqqconfirmmode');
			$message = Mage::helper('qquoteadv')->__("To update item in the Shopping cart <a href='%s'>log out</a> from Quote confirmation mode.",$link);
            Mage::getSingleton('checkout/session')->addNotice($message);

        }
     }

     public function disableAddProduct(Varien_Event_Observer $observer ) {
        if ( Mage::helper('qquoteadv')->isActiveConfirmMode()) {
			
			Mage::app()->getRequest()->setParam('product', '');

            $message =  Mage::helper('qquoteadv')->__('Action is blocked in quote confirmation mode');
            Mage::getSingleton('checkout/session')->addError($message);

			$link = Mage::getUrl('qquoteadv/view/outqqconfirmmode');
			$message = Mage::helper('qquoteadv')->__("To update item in the Shopping cart <a href='%s'>log out</a> from Quote confirmation mode.",$link);
            Mage::getSingleton('checkout/session')->addNotice($message);
        }
     }     
     
    public function addC2qRefNumber(Varien_Event_Observer $observer ) {      
       $order = $observer->getOrder(); 
       if ($quoteId = Mage::getSingleton('core/session')->proposal_quote_id) {
        $order->setData('c2q_internal_quote_id', $quoteId);
       }
       
       if ($quoteId = Mage::getSingleton('adminhtml/session')->getUpdateQuoteId()) {
        $order->setData('c2q_internal_quote_id', $quoteId);
       }
    }
    
    public function setQuoteStatus($event){  
      $quoteId = Mage::getSingleton('core/session')->proposal_quote_id;
      if (empty($quoteId)) {
        $quoteId = Mage::getSingleton('adminhtml/session')->getUpdateQuoteId(); 
      }
      
      if ($_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load($quoteId) ) {
        $_quoteadv->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_ORDERED);

        try{
            $_quoteadv->save();
            
            if (Mage::getSingleton('core/session')->proposal_quote_id) { 
              Mage::getSingleton('core/session')->proposal_quote_id = null; 
            }
            if (Mage::getSingleton('adminhtml/session')->getUpdateQuoteId()) { 
              Mage::getSingleton('adminhtml/session')->setUpdateQuoteId(null); 
            }
        }catch(Exception $e){ 
            Mage::log($e->getMessage()); 
        }     
      }
    }
    
    function quoteCancelation($observer) {

      $event = $observer->getEvent();
      $product = $event->getProduct();

      if ($product && $product->getId()) {
        
        $table = Mage::getSingleton('core/resource')->getTableName('qquoteadv/qqadvcustomer');

        $_collection = Mage::getModel("qquoteadv/qqadvproduct")->getCollection();
        $_collection->getSelect()->join(array('p'=>$table), 'main_table.quote_id=p.quote_id', array());
        $_collection->addFieldToFilter("status", array("neq" => Ophirah_Qquoteadv_Model_Status::STATUS_CANCELED));

        $productId = $product->getId();
        $quoteIds = array();
        foreach( $_collection as $item) { 
          if($productId  == $item->getData('product_id')){
            $quoteIds[] = $item->getData('quote_id');
          }
        }

        foreach($quoteIds as $quoteId) {
          $quote = Mage::getModel("qquoteadv/qqadvcustomer")->load($quoteId);
          $quote->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_CANCELED);
          try {
            $quote->save();
          } catch(Exception $e) {
            Mage::log($e->getMessage());
          }
        }        
      }
      
    } 
    
    function blockClassListener($observer) {
      $block = $observer->getEvent()->getBlock();
      
      if("Mage_Adminhtml_Block_Sales_Order_Create_Totals" === get_class($block)) {
      //if ($block instanceof Mage_Adminhtml_Block_Sales_Order_Create_Totals) {  //Mage_Adminhtml_Block_Sales_Order_Create_Totals_Subtotal 
        $block->setTemplate("qquoteadv/sales/order/create/totals.phtml");
      }
      return $this;
    }    
    
    function setAllowedToQuoteMode($observer){
        if(!Mage::app()->getStore()->isAdmin() && Mage::getDesign()->getArea() != 'adminhtml') {
           $product = $observer->getEvent()->getProduct();
           $allowed = Mage::helper('qquoteadv')->getAllowedToQuoteMode($product);
           $product->setAllowedToQuotemode($allowed);
        }
        return $this;
    }
    
    function addAdminGroupAllow($observer){
        $form = $observer->getEvent()->getForm();
        $groupAllow = $form->getElement('group_allow_quotemode');
        if ($groupAllow) {
            $groupAllow->setRenderer(
                Mage::getSingleton('core/layout')->createBlock('qquoteadv/adminhtml_catalog_product_edit_tab_qquoteadv_group_allow')
            );
        }
    }
}