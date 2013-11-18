<?php

class Ophirah_Qquoteadv_Model_Requestitem extends Mage_Sales_Model_Quote_Address_Item
{
        
        
        protected $_quote = null;
        
        protected $_weight = null;
        
        protected $_children = null;
        
        protected $_hasChildren = null;
        
        protected $_taxableAmount = null;
        
        public function _construct()
        {
            parent::_construct();
            $this->_init('qquoteadv/requestitem');
           
        }
        
        /*public function setTaxableAmount($amount){
            $this->_taxableAmount = $amount;
            
            foreach($this->getQuote()->getRequesttems() as $item){
                if($item->getId() == $this->getId()){
                    
                    $item->setTaxableAmount($amount);
                }
            }
            
            
        }
        
        public function getTaxableAmount() { 
            return $this->_taxableAmount;
        }
        */
        /*public function afterLoad($id){
             
          $this->getQuote();
       }*/

        
      /*  public function getChildren()
        {
            //if($this->_children == null) {
               ($qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($this->getQuoteadvProductId());
               
                $quote = Mage::helper('qquoteadv')->getQuoteItem($this->getProduct(), $qqadvproduct->getAttribute());
                
                 foreach($quote->getAllItems() as $item){
                     $this->_children = $item->getChildren();
                }
                
               
                
           // }
            return $this->_children;
        }
        
       
       
        public function isChildrenCalculated()
        {
           
                $qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($this->getQuoteadvProductId());
                
                $quote = Mage::helper('qquoteadv')->getQuoteItem($this->getProduct(), $qqadvproduct->getAttribute());
              
                foreach($quote->getAllItems() as $item){
                     
                    return  $item->isChildrenCalculated();
                    break;
                }
                
                
          
                
            return false;
        }
        
        */
      
      
       /* public function getChildren(){
            if($this->_children == null){
                $children = array();    
                $qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($this->getQuoteadvProductId());

                $product =  Mage::getModel('catalog/product')->load($this->getProductId());
                $product->setStoreId( $qqadvproduct->getStoreId()? $qqadvproduct->getStoreId():1);
                $quote = Mage::helper('qquoteadv')->getQuoteItem2($product, $qqadvproduct->getAttribute(), $this->getQuote());
                foreach($quote->getAllItems() as $item){
                   foreach($item->getChildren() as $child){
                       $this->addChild($child);
                   }
                }        
            }
            
            return $this->_children;      
        }
        
        public function getHasChildren()
        {
            return (boolean) count($this->getChildren());
        }
        */
         
        
	
	/**
	 * Add item to request for the particular quote
	 * @param array $params array of field(s) to be inserted
	 * @return mixed
	 */
	public function addItem($params)
	{ 		
		$this->setData($params)
		      ->save()
		      ;	
		return $this;		
	}
	
	/**
	 * Add items to request for the particular quote
	 * @param array $params array of field(s) to be inserted
	 * @return mixed
	 */
	public function addItems($params){
	    
	    foreach($params as $key=>$values)
	       if(!$this->_isDublicatedData($values))
	           $this->addItem($values);
	    
	    return $this;
	}
	
	/**
	 * Checking item / qty for blocking dublication request
	 * @param array $params array of field(s) should to be inserted
	 * @return mixed
	 */
	protected function _isDublicatedData($params){
	      $quoteId       = $params['quote_id'];
	      $productId     = $params['product_id'];
          $qtyRequest    = $params['request_qty'];
          
              $_quote = Mage::getSingleton('qquoteadv/qqadvcustomer')->load($quoteId );  
          
	      $collection =  Mage::getModel('qquoteadv/requestitem')->getCollection()->setQuote($quote)
                	               ->addFieldToFilter('quote_id', $quoteId)
                	               ->addFieldToFilter('product_id', $productId)
                	               ->addFieldToFilter('request_qty', $qtyRequest)
                	               //->load(true)
                	               ;
                	               
        return (count($collection)  > 0)?true:false; 
	}
        
        public function getProduct(){
            $product =  Mage::getSingleton('catalog/product')->load($this->getProductId());
            
            $qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($this->getQuoteadvProductId());
            
            $product->setStoreId( $qqadvproduct->getStoreId()? $qqadvproduct->getStoreId():1);
            //$productOptions = unserialize($qqadvproduct->getAttribute());
            $buyRequest = new Varien_Object();
            $product->getTypeInstance($product)->processConfiguration($buyRequest, $product);
            return $product;
            
        }
        
        public function setQuote($quote){
            $this->_quote = $quote;
        }
        
        public function getQuote(){
            
            if($this->_quote==null){
                $quote =Mage::getSingleton('qquoteadv/qqadvcustomer')->load((int)$this->getQuoteId());
                $this->_quote = $quote;
            }
            return $this->_quote;
        }
        
        public function getStore(){
            return $this->getQuote()->getStore(); 
        }
       
        public function getAddress(){
            return $this->getQuote()->getAddress();
        }
    
       
        
        /**
        * Calculate item row total price
        *
        * @return Ophirah_Qquoteadv_Model_Requestitem
        */
       public function calcRowTotal()
       {
           $qty        = $this->getRequestQty();
           // Round unit price before multiplying to prevent losing 1 cent on subtotal
           $total      = $this->getStore()->roundPrice($this->getOwnerCurPrice()) * $qty;
           $baseTotal  = $this->getOwnerBasePrice() * $qty;

           $this->setRowTotal($this->getStore()->roundPrice($total));
           $this->setBaseRowTotal($this->getStore()->roundPrice($baseTotal));
           return $this;
       }
       
       function getQuoteItemId(){
           return $this->getId();
       }
       
       function getOriginalPrice(){
            return  $this->getOwnerCurPrice();
       }
       
       function getBaseOriginalPrice(){
            return  $this->getOwnerBasePrice();
       }
       
       
       function getTotalQty(){
           return $this->getRequestQty();
       }
       
       function getQty(){
            return $this->getRequestQty();
       }
       
       public function getCalculationPrice(){
          return $this->getOwnerCurPrice();
       }
       
       public function getBaseCalculationPrice(){
          return  $this->getOwnerBasePrice();
       }
       
       public function getCalculationPriceOriginal(){
          return  $this->getOwnerCurPrice();
       }
       
       public function getBaseCalculationPriceOriginal(){
           return $this->getOwnerBasePrice();
       }
       
        
       
        public function getRowTotal() {
            $qty        = $this->getRequestQty();
            $total      = $this->getStore()->roundPrice($this->getOwnerCurPrice()) * $qty;
            return $total;
        }

         public function getBaseRowTotal() {
            $qty        = $this->getRequestQty();
            $baseTotal  = $this->getOwnerBasePrice() * $qty;
            return $baseTotal;
        }

        public function getWeight() {
            
            if($this->_weight == null) {
                $this->_weight = $this->getProduct()->getWeight();
            }
            return $this->_weight;
        }
}