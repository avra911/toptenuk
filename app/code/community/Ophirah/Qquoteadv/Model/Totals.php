<?php
class Ophirah_Qquoteadv_Model_Totals extends Varien_Object{

    protected $_quote = null;
    
    protected $_subTotal;
    
    protected $_grandTotal;
    
    protected $_shipping;
    
    protected $_taxAmount;
    
    protected $_baseSubTotal;
    
    protected $_baseGrandTotal;
    
    protected $_baseShipping;
    
    protected $_baseTaxAmount;
    
    
    public function getQuote(){
        if($this->_quote == null){
           $_quote = Mage::registry('current_quote');
        }
        
        return $this->_quote;
    }
    
    public function setQuote($_quote){
       $this->_quote = $_quote;
    }
    
    public function getSubTotal(){
        return $this->_subTotal;
    }
    
    public function getShipping(){
        return $this->_shipping;
    }
    
    public function getGrandTotal(){
        return $this->_grandTotal;
    }
    
    public function getGrandTotalExclTax(){
        return $this->_grandTotalExlTax;        
    }
    
    public function getBaseSubTotal(){
        return $this->_baseSubTotal;         
    }
    
    public function getBaseShipping(){
        return $this->_baseShipping;         
    }
    
    public function getBaseGrandTotal(){
        return $this->_baseGrandTotal;         
    }
    
    public function getBaseGrandTotalExclTax(){
        return $this->_baseGrandTotalExclTax;         
    }
    
    public function getTaxAmount(){
        return $this->_taxAmount;         
    }
    
    public function getBaseTaxAmount(){
        return $this->_baseTaxAmount;         
    }
    
    public function setSubTotal($total){
         $this->_subTotal = $total;
         return $this;
    }
    
    public function setShipping($shipping){
        $this->_shipping = $shipping;
        return $this;
    }
    
    public function setGrandTotal($total){
        $this->_grandTotal = $total;
        return $this;
    }
    
    public function setGrandTotalExclTax($total){
       $this->_grandTotalExlTax = $total;   
       return $this;
    }
    
    public function setBaseSubTotal($total){
        $this->_baseSubTotal = $total;   
        return $this;
    }
    
    public function setBaseShipping($shipping){
         $this->_baseShipping = $shipping;  
         return $this;
    }
    
    public function setBaseGrandTotal($total){
        $this->_baseGrandTotal = $total;    
        return $this;
    }
    
    public function setBaseGrandTotalExclTax($total){
        $this->_baseGrandTotalExclTax = $total;
        return $this;
    }
    
    public function setTaxAmount($tax){
        $this->_taxAmount = $tax;    
        return $this;
    }
    
    public function setBaseTaxAmount($tax){
        $this->_baseTaxAmount = $tax;    
        return $this;
    }
    
    
    public function _initTotals(){
        if($this->getQuote() == null) throw new Exception('Quote not set in '.get_class($this));

        
       
    }
    
    
    /**
    * Get Totals of a quote
    * @return float/int if a total
    * 
    * or 
    *
    * @return false if tier pricing is used
    */
    public function _calculateSubtotal(){
    	 $total = 0;
    	 
         
    	 $requestedProducts = Mage::getModel('qquoteadv/requestitem')->getCollection()->setQuote($this->getQuote());
	 $requestedProducts->getSelect()->order(array('product_id ASC', 'request_qty ASC'));
    	 
    	 foreach($requestedProducts as $line) {
             $productQty     = $line->getRequestQty()*1;
             $priceProposal  = $line->getOwnerBasePrice(); 
             $lineTotal =  $productQty *  $priceProposal;
             $total += $lineTotal;	
    	 }
    	 
    	 return $total;
    }
    
    /**
    * Get Shipping total of a quote
    * @return float/int if a total
    * 
    * or 
    *
    * @return false if varuable pricing is used
    */
    public function _calculateShippingtotal(){
        $sPrice        =  $this->getQuote()->getShippingPrice();
        $shippingType =  $this->getQuote()->getShippingType();

        if($shippingType=='I'){
                        $qty = 0;
                        $requestedProducts = Mage::getModel('qquoteadv/requestitem')
                                                                                                                                                                                ->getCollection()
                                                                                                                                                                                ->addFieldToFilter('quote_id', $this->getQuoteId());

                        $requestedProducts->getSelect()->order(array('product_id ASC', 'request_qty ASC'));
                        foreach($requestedProducts as $line) $qty += $line->getRequestQty()*1;

                        $sTotal = $sPrice * $qty;
        }elseif($shippingType=='O'){
                        $sTotal = $sPrice;
        }else{
                        $sTotal = false;
        }   

        return $sTotal;

    }
    
    /**
    * Get Totals of a quote
    * @return float
    */
    public function _calculateGrandtotalExclTax(){
        $subtotal = $this->getSubTotal();
        $shipping = $this->getShipping();
        return $subtotal + $shipping;
    }

   
    
    
    
    
}
