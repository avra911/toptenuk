<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)getShippingRatesCollection(
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Ophirah_Qquoteadv_Model_Address extends Mage_Sales_Model_Quote_Address
{

    protected $_countryId = null;
    protected $_rates = null;
    
    public $_shippingRates = null;
    /**
     * Prefix of model events
     *
     * @var string
     */
    protected $_eventPrefix = 'ophirah_qquoteadv_address';

    /**
     * Name of event object
     *
     * @var string
     */
    protected $_eventObject = 'quoteadv_address';

    /**
     * Override resource as we are defining the field ourselves
     */
    protected function _construct()
    {
    }

    /**
     * Init mapping array of short fields to its full names
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    protected function _initOldFieldsMap()
    {
        return $this;
    }

    /**
     * Initialize quote identifier before save
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        return $this;
    }

    /**
     * Declare adress quote model object
     *
     * @param   Mage_Sales_Model_Quote $quote
     * @return  Mage_Sales_Model_Quote_Address
     */
    public function setQuote(Mage_Sales_Model_Quote $quote)
    {
       
        $this->_quote = $quote;
        $this->setQuoteId($quote->getId());
        return $this;
    }

    /**
     * Retrieve quote object
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->_quote;
    }

  

  

    /**
     * Retrieve address items collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getItemsCollection()
    {
        if (is_null($this->_items)) {
          $items = $this->getAllItems();
          foreach($items as $item){
              $item->setAddress($this);
              $item->setQuote($this->getQuote());
          }
        }
        return $items;
    }

    /**
     * Get all available address items
     *
     * @return array
     */
    public function getAllItems()
    {      
        return $this->getQuote()->getAllRequestItems();
    }

  

    /**
     * Add item to address
     *
     * @param   Ophirah_Qquoteadv_Model_Requestitemt $item
     * @param   int $qty
     * @return  Mage_Sales_Model_Quote_Address
     */
    public function addItem(Mage_Sales_Model_Quote_Item_Abstract $item, $qty=null)
    {
     
        return $this;
    }
    
    function getId(){
      return $this->getQuote()->getId();
    }
    
    
    public function getCollectShippingRates(){
        return true;
    }

    /**
     * Retrieve collection of quote shipping rates
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getShippingRatesCollection()
    {
        if( $this->_rates == null) {
            if($this->getQuote()->getIsCustomShipping()) {
               
               $price =  $this->getQuote()->getShippingBasePrice();
               
               if($this->getQuote()->getShippingType() == "I") {
                 $price = ($price * $this->getQuote()->getItemsQty());  
               } 
                
               $rate = Mage::getModel('qquoteadv/shippingrate');
               $rate->setData('carrier', 'flatrate');
               $rate->setData('carrier_title', 'Flat Rate');
               $rate->setData('price', $price);
               $rate->setData('cost', $price);
               $rate->setData('method', 'flatrate');
               $rate->setData('method_title', 'Fixed');   
               $quoteRate = Mage::getModel('sales/quote_address_rate')->importShippingRate($rate); 
               $this->_rates = array($quoteRate);
               
               
            } else {
            
                
                
                /*$item = null;
                //$this->requestShippingRates();
                $request = Mage::getModel('shipping/rate_request');
                $request->setAllItems($item ? array($item) : $this->getAllItems());
                $request->setDestCountryId($this->getCountryId());
                $request->setDestRegionId($this->getRegionId());
                $request->setDestRegionCode($this->getRegionCode());
                /**
                 * need to call getStreet with -1
                 * to get data in string instead of array
                 */


                /*$request->setDestStreet($this->getStreet(-1));
                $request->setDestCity($this->getCity());
                $request->setDestPostcode($this->getPostcode());
                $request->setPackageValue($item ? $item->getBaseRowTotal() : $this->getBaseSubtotal());
                $packageValueWithDiscount = $item
                    ? $item->getBaseRowTotal() - $item->getBaseDiscountAmount()
                    : $this->getBaseSubtotalWithDiscount();
                $request->setPackageValueWithDiscount($packageValueWithDiscount);
                $request->setPackageWeight($item ? $item->getRowWeight() : $this->getWeight());
                $request->setPackageQty($item ? $item->getQty() : $this->getItemQty());



                /**
                 * Need for shipping methods that use insurance based on price of physical products
                 */
                /*$packagePhysicalValue = $item
                    ? $item->getBaseRowTotal()
                    : $this->getBaseSubtotal() - $this->getBaseVirtualAmount();
                $request->setPackagePhysicalValue($packagePhysicalValue);

                $request->setFreeMethodWeight($item ? 0 : $this->getFreeMethodWeight());

                /**
                 * Store and website identifiers need specify from quote
                 */
                /*$request->setStoreId(Mage::app()->getStore()->getId());
                $request->setWebsiteId(Mage::app()->getStore()->getWebsiteId());*/

                /*$request->setStoreId($this->getQuote()->getStore()->getId());
                $request->setWebsiteId($this->getQuote()->getStore()->getWebsiteId());
                $request->setFreeShipping($this->getFreeShipping());
                /**
                 * Currencies need to convert in free shipping
                 */

               /* $request->setBaseCurrency($this->getQuote()->getStore()->getBaseCurrency());
                $request->setPackageCurrency($this->getQuote()->getStore()->getCurrentCurrency());
                $request->setLimitCarrier($this->getLimitCarrier());

                $request->setBaseSubtotalInclTax($this->getBaseSubtotalInclTax());

                $result = Mage::getModel('shipping/shipping')->collectRates($request)->getResult();
                $found = false;
                if ($result) {
                    $shippingRates = $result->getAllRates();
                    foreach( $shippingRates as $rate){

                        $rateCode = $rate->getCarrier()."_".$rate->getMethod();
                        if( $rateCode == $this->getShippingMethod()){
                            $quoteRate = Mage::getModel('sales/quote_address_rate')->importShippingRate($rate); 
                            $this->_rates = array($quoteRate);
                            break;
                        }
                     }


                  }*/
                
                $this->_rates = array();
           }
        
        
        }
       
        
        
        return $this->_rates;
    }

    
      public function collectShippingRates()
    {
        if (!$this->getCollectShippingRates()) {
            return $this;
        }
       
        $this->removeAllShippingRates();

        if (!$this->getCountryId()) {
            return $this;
        }
        $found = $this->requestShippingRates();
        if (!$found) {
            $this->setShippingAmount(0)
                ->setBaseShippingAmount(0)
                ->setShippingMethod('')
                ->setShippingDescription('');
        }
        return $this;
    }
    
        /**
     * Request shipping rates for entire address or specified address item
     * Returns true if current selected shipping method code corresponds to one of the found rates
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return bool
     */
    public function requestShippingRates(Mage_Sales_Model_Quote_Item_Abstract $item = null)
    {
        
        
        /** @var $request Mage_Shipping_Model_Rate_Request */
        $request = Mage::getModel('shipping/rate_request');
        $request->setAllItems($item ? array($item) : $this->getAllItems());
        $request->setDestCountryId($this->getCountryId());
        $request->setDestRegionId($this->getRegionId());
        $request->setDestRegionCode($this->getRegionCode());
        /**
         * need to call getStreet with -1
         * to get data in string instead of array
         */
        
        
        $request->setDestStreet($this->getStreet(-1));
        $request->setDestCity($this->getCity());
        $request->setDestPostcode($this->getPostcode());
        $request->setPackageValue($item ? $item->getBaseRowTotal() : $this->getBaseSubtotal());
        $packageValueWithDiscount = $item
            ? $item->getBaseRowTotal() - $item->getBaseDiscountAmount()
            : $this->getBaseSubtotalWithDiscount();
        $request->setPackageValueWithDiscount($packageValueWithDiscount);
        $request->setPackageWeight($item ? $item->getRowWeight() : $this->getWeight());
        $request->setPackageQty($item ? $item->getQty() : $this->getItemQty());

        
        
        /**
         * Need for shipping methods that use insurance based on price of physical products
         */
        $packagePhysicalValue = $item
            ? $item->getBaseRowTotal()
            : $this->getBaseSubtotal() - $this->getBaseVirtualAmount();
        $request->setPackagePhysicalValue($packagePhysicalValue);

        $request->setFreeMethodWeight($item ? 0 : $this->getFreeMethodWeight());

        /**
         * Store and website identifiers need specify from quote
         */
        /*$request->setStoreId(Mage::app()->getStore()->getId());
        $request->setWebsiteId(Mage::app()->getStore()->getWebsiteId());*/

        $request->setStoreId($this->getQuote()->getStore()->getId());
        $request->setWebsiteId($this->getQuote()->getStore()->getWebsiteId());
        $request->setFreeShipping($this->getFreeShipping());
        /**
         * Currencies need to convert in free shipping
         */
        
        $request->setBaseCurrency($this->getQuote()->getStore()->getBaseCurrency());
        $request->setPackageCurrency($this->getQuote()->getStore()->getCurrentCurrency());
        $request->setLimitCarrier($this->getLimitCarrier());

        $request->setBaseSubtotalInclTax($this->getBaseSubtotalInclTax());

        $result = Mage::getModel('shipping/shipping')->collectRates($request)->getResult();

        $found = true;
       
        return $found;
    }

 

    public function getStreet($line = 0){
        return $this->getQuote()->getStreet($line);
    }
    
    public function getRegionId(){
        return $this->getQuote()->getRegionId();
    }
    
    public function getCountryId(){
        
        if($this->_countryId == null) {
            $this->_countryId = $this->getQuote()->getShippingCountryId();    
        }
        return $this->_countryId;
    }
    
    public function getCity(){
        return $this->getQuote()->getCity();    
        
    }
    
    public function getPostcode(){
         return $this->getQuote()->getPostcode();    
    }
    
   
     /**
     * Retrieve all address shipping rates
     *
     * @return array
     */
    public function getAllShippingRates()
    {
        $rates = array();
        foreach ($this->getShippingRatesCollection() as $rate) {
          
             $rates[] = $rate;
        }
        return $rates;
    }

    /**
     * Get totals collector model
     *
     * @return Mage_Sales_Model_Quote_Address_Total_Collector
     */
    public function getTotalCollector()
    {
        if ($this->_totalCollector === null) {
            
            
            
            $this->_totalCollector = Mage::getSingleton(
                'sales/quote_address_total_collector',
                array('store'=>$this->getQuote()->getStore())
            );
        }
        return $this->_totalCollector;
    }

    /**
     * Retrieve total models
     *
     * @deprecated
     * @return array
     */
    public function getTotalModels()
    {
        return $this->getTotalCollector()->getRetrievers();
    }

    /**
     * Collect address totals
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function collectTotals()
    {
        Mage::dispatchEvent($this->_eventPrefix . '_collect_totals_before', array($this->_eventObject => $this));
        foreach ($this->getTotalCollector()->getCollectors() as $model) {
            $model->collect($this);
        }
        return $this;
    }

    
    public function validateMinimumAmount()
    {
        $storeId = $this->getQuote()->getStoreId();
        if (!Mage::getStoreConfigFlag('sales/minimum_order/active', $storeId)) {
            return true;
        }

        if ($this->getQuote()->getIsVirtual() && $this->getAddressType() == self::TYPE_SHIPPING) {
            return true;
        }
        elseif (!$this->getQuote()->getIsVirtual() && $this->getAddressType() != self::TYPE_SHIPPING) {
            return true;
        }

        $amount = Mage::getStoreConfig('sales/minimum_order/amount', $storeId);
        if ($this->getBaseSubtotalWithDiscount() < $amount) {
            return false;
        }
        return true;
    }

   
    public function setShippingAmount($value, $alreadyExclTax = false)
    {
        return $this->getQuote()->setData('shipping_amount', $value);
    }

    /**
     * Set base shipping amount
     *
     * @param float $value
     * @param bool $alreadyExclTax
     * @return Mage_Sales_Model_Quote_Address
     */
    public function setBaseShippingAmount($value, $alreadyExclTax = false)
    {
        return $this->getQuote()->setData('base_shipping_amount', $value);
    }

    

    
    public function getFreeShipping(){
        return $this->getQuote()->getFreeShipping();
    }
    
    public function getShippingMethod(){
        return $this->getQuote()->getAddressShippingMethod();
    }
    
    public function getShippingDescription(){
       return $this->getQuote()->getAddressShippingDescription();
    }
    
    public function setShippingDescription($desc){
       return $this->getQuote()->setAddressShippingDescription($desc);
    }
    
    public function removeAllShippingRates()
    {
        /*foreach ($this->getShippingRatesCollection() as $rate) {
            $rate->isDeleted(true);
        }*/
        return $this;
    }
    

}
