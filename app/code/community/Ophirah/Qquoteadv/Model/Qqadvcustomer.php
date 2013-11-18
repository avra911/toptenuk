<?php

class Ophirah_Qquoteadv_Model_Qqadvcustomer extends Mage_Sales_Model_Quote
{
     
    const MAXIMUM_AVAILABLE_NUMBER = 99999999;
    protected $_quoteCurrency   = null;
    protected $_baseCurrency    = null;
    protected $_customer = null;
    protected $_address = null;
    protected $_requestItems = null;
    protected $_weight = null;
    protected $_itemsQty = null;
    protected $_items = null;
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/qqadvcustomer');
    }
      
    protected function _afterSave()
    {
        
            
        return $this;
    }
              
    /**
     * Add quote to qquote_customer table
     * @param array $params quote created information
     * @return mixed
     */
    public function addQuote($params)
    {
            $params['hash'] = $this->getRandomHash(40);
            $this->setData($params)
                  ->save()
                  ;		
            return $this;
    }

    /**
     * Add customer address for the particular quote
     * @param integer $id quote id to be updated
     * @param array $params array of field(s) to be updated
     * @return mixed
     */
    public function addCustomer($id,$params)
    { 
            $this->load($id)
                  ->addData($params)
                  ->setId($id)
                  ->save()
                  ;

            return $this;		
    }

    public function updateQuote($id, $params)
    {
            $this->load($id)
                  ->setData($params)
                  ->setId($id)
                  ->save()
                  ;		
            return $this;
    }
	
	public function getStoreGroupName()
    {
        $storeId = $this->getStoreId(); 
        if (is_null($storeId)) {
            return $this->getStoreName(1); // 0 - website name, 1 - store group name, 2 - store name
        }
        return $this->getStore()->getGroup()->getName();
    }
    
     /**
     * Retrieve store model instance
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        if ($storeId = $this->getStoreId()) {
            return Mage::app()->getStore($storeId);
        }
        return Mage::app()->getStore();
    }


     /**
     * Get formated quote created date in store timezone
     *
     * @param   string $format date format type (short|medium|long|full)
     * @return  string
     */
    public function getCreatedAtFormated($format)
    {
        return Mage::helper('core')->formatDate($this->getCreatedAt(), $format);
    }

    
    public function getBillingAddressFormatted(){
        $regionName = null;
        //$name = $this->getCustomerName($this->getCustomerId());
        $address = $this->getData('address');
        
        $cityPostCode = $this->getCity();
        if(trim($this->getPostcode()))
           $cityPostCode.= ", ".$this->getPostcode();

        $country = Mage::app()->getHelper('qquoteadv')->getCountryName($this->getCountryId());
        $phone = $this->getTelephone();
        
        if($this->getRegion()) {
            $regionName = $this->getRegion();
        } elseif($regionId = $this->getRegionId()) {
            $region = Mage::getModel('directory/region')->load($regionId);
            $regionName = $region->getName();
        }
        

        $str = ""; 
	    if($address != "")          $str .= $address."<br />";
	    if($cityPostCode != "")     $str .= $cityPostCode."<br /> ";
            if($regionName !="")        $str .= $regionName."<br>";
            if($country != "") 		$str .= $country."<br /> ";
            if($phone != "")   		$str .= $phone."<br /> ";
		
       	return $str; //$this->_formatAddress($str);
    }
    
	public function getShippingAddressFormatted(){
		$address = $this->getData('shipping_address'); 
		$cityPostCode = $this->getShippingCity(); 
		if(trim($this->getShippingPostcode()) != "") 
		$cityPostCode.= ", ".$this->getShippingPostcode();
		
		$country = Mage::app()->getHelper('qquoteadv')->getCountryName($this->getShippingCountryId()); 
		$phone = $this->getShippingTelephone();
		
		
		if($this->getShippingRegion()) {
            $regionName = $this->getShippingRegion();
        } elseif($regionId = $this->getShippingRegionId()) {
            $region = Mage::getModel('directory/region')->load($regionId);
            $regionName = $region->getName();
        } else {
            $regionName = "";	
        }

            $str = ""; 
            if($address != "") 		$str .= $address."<br />";
            if($cityPostCode != "")     $str .= $cityPostCode."<br /> ";
            if($regionName != "")  	$str .= $regionName."<br />";
            if($country != "") 		$str .= $country."<br /> ";
            if($phone != "")   		$str .= $phone."<br /> ";

            return $str; //$this->_formatAddress($str); 
	}

        // function to get variables in email templates
        // if $var is allowed, it's value will be returned
        public function getVariable($var) {
            $allowed_var=array(
                                    "created_at",
                                    "updated_at",
                                    "is_quote",
                                    "prefix",
                                    "firstname",
                                    "middlename",
                                    "lastname",
                                    "suffix",
                                    "company",
                                    "email",
                                    "country_id",
                                    "region",
                                    "region_id",
                                    "city",
                                    "address",
                                    "postcode",
                                    "telephone",
                                    "fax",
                                    "client_request",
                                    "shipping_type",
                                    "increment_id",
                                    "shipping_prefix",
                                    "shipping_firstname",
                                    "shipping_middlename",
                                    "shipping_lastname",
                                    "shipping_suffix",
                                    "shipping_company",
                                    "shipping_country_id",
                                    "shipping_region",
                                    "shipping_region_id",
                                    "shipping_city",
                                    "shipping_address",
                                    "shipping_postcode",
                                    "shipping_telephone",
                                    "shipping_fax",
                                    "imported",
                                    "currency",
                                    "expiry",
                                    "shipping_description",
                                    "address_shipping_description",
                                    "address_shipping_method"                
                                );
            
            if(in_array($var, $allowed_var)){        
                return $this->getData($var);
            }
            
            return;
        }
        
        
     public function getFullPath(){
	
            $valid = Mage::helper('qquoteadv')->isValidHttp($this->getPath()); 
            $path = $this->getPath(); //urlencode($this->getPath());
            if($valid)
                    return $path;
            else
                    return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $path;  
     }
     
     
     public function sendExpireEmail(){
        $expireTemplateId = Mage::getStoreConfig('qquoteadv/emails/proposal_expire', $this->getStoreId());

        $expiredQuotes = $this->getCollection()
                                ->addFieldToFilter('status',array('in'=> array(50,53) ))
                                ->addFieldToFilter('no_expiry',array('eq'=> 0 ))
                                ->addFieldToFilter('expiry',array('eq'=>date('Y-m-d')));     
        
        
        foreach($expiredQuotes as $expiredQuote){
            $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load($expiredQuote->getData('quote_id'));

            $vars['quote'] = $_quoteadv;
            $vars['customer'] = Mage::getModel('customer/customer')->load($_quoteadv->getCustomerId());


            $template = Mage::getModel('qquoteadv/core_email_template');

            if (is_numeric($expireTemplateId)) {
                $template->load($expireTemplateId);
            } else {
                $template->loadDefault($expireTemplateId);
            }

            $sender = $this->getEmailSenderInfo();
            $template->setSenderName($sender['name']);
            $template->setSenderEmail($sender['email']);


            $subject = sprintf("Your Quote # %s will expire today", $_quoteadv->getIncrementId());
            $template->setTemplateSubject($subject);
            
            $template2 = clone $template;
            
            $template2->setSenderName($_quoteadv->getFirstname()." ".$_quoteadv->getLastname());
            $template2->setSenderEmail($_quoteadv->getEmail());
                   
            /**
             * Opens the qquote_request.html, throws in the variable array
             * and returns the 'parsed' content that you can use as body of email
             */
            $processedTemplate = $template->getProcessedTemplate($vars);
            $processedTemplate2 = $template2->getProcessedTemplate($vars);

            /*
             * getProcessedTemplate is called inside send()
             */
            $res = $template->send($_quoteadv->getEmail(), $_quoteadv->getFirstname(), $vars);
            
            $res2 = $template2->send($adminEmail, $adminName, $vars);
            
        }

     }
     
     
    public function exportQuotes($qquoteIds, $filePath){

        $csv_titles = array(
              "id",
              "timestamp",
              "name",
              "address",
              "zipcode",
              "city",
              "country",
              "phone",
              "email",
              "remarks",
              "product id",
              "product name",
              "product attributes",
              "quantity",
              "product sku"
        );

        $file = fopen($filePath, 'w'); //open, truncate to 0 and create if doesnt exist

        if(!$this->writeCsvRow($csv_titles, $file)) return false;

        foreach ($qquoteIds as $qquoteId) {
                $qquote = $this->load($qquoteId);


                $quoteId = $qquote->getQuoteId();
                $timestamp = $qquote->getCreatedAt();

                // build name
                $nameArr = array();
                if($qquote->getPrefix()) array_push($nameArr, $qquote->getPrefix());
                if($qquote->getFirstname()) array_push($nameArr, $qquote->getFirstname());
                if($qquote->getMiddlename()) array_push($nameArr, $qquote->getMiddlename());
                if($qquote->getLastname()) array_push($nameArr, $qquote->getLastname());
                if($qquote->getSuffix()) array_push($nameArr, $qquote->getSuffix());
                $name = join($nameArr, " ");
                $email = $qquote->getEmail();
                $city = $qquote->getCity();
                $address = $qquote->getData('address');
                $postcode = $qquote->getPostcode();
                $tel = $qquote->getTelephone();
                $country = $qquote->getCountryId();
                $remarks = $qquote->getClientRequest();


                $collection = Mage::getModel('qquoteadv/qqadvproduct')->getQuoteProduct($quoteId);

                $basicFields = array(
                        $quoteId, $timestamp, $name, $address, $postcode,
                        $city, $country, $tel, $email,  $remarks
                );

                foreach($collection as $item){
                        $baseProductId = $item->getProductId();
                        $productObj = Mage::getModel('catalog/product')->load($baseProductId);

                        $productName = $productObj->getName();
                        $productAttributes = "";

                        $productObj->setStoreId($item->getStoreId()?$item->getStoreId():1);
                        $quoteByProduct = Mage::helper('qquoteadv')->getQuoteItem($productObj, $item->getAttribute());

                        foreach($quoteByProduct->getAllItems() as $_unit) {

                                if( $_unit->getProductId() == $productObj->getId() ) {
                                     if($_unit->getProductType() == "bundle"){
                                        $_helper = Mage::helper('bundle/catalog_product_configuration');
                                        $_options = $_helper->getOptions($_unit);   
                                     }else{
                                          $_helper = Mage::helper('catalog/product_configuration');
                                          $_options = $_helper->getCustomOptions($_unit);
                                     }

                                     foreach($_options as $option){
                                         if(is_array($option['value']))$option['value'] = implode(",", $option['value']);
                                         $productAttributes .= $option['label'].":".strip_tags($option['value']);
                                         $productAttributes .= "|";
                                     }		
                                }
                        }
                        $quote = Mage::getModel('qquoteadv/qqadvcustomer')->load($quoteId);    
                        $requestItem = Mage::getModel('qquoteadv/requestitem')->getCollection()->setQuote($quote)
                        ->addFieldToFilter('quote_id',$quoteId)
                        ->addFieldToFilter('product_id',$baseProductId)
                        ->getFirstItem();


                        $qty =$requestItem->getRequestQty();
                        $SKU = $productObj->getSku();

                        $productFields = array(	$baseProductId, $productName, $productAttributes, $qty, $SKU);

                        $fields = array_merge($basicFields, $productFields);

                        if(!$this->writeCsvRow($fields, $file)){
                                Mage::Log("could not write:".print_r($fields, 1));
                                return false;
                        }
                }
        }
        return true;
    }
		 
    public function writeCsvRow($row, $filePointer) {
        if(is_array($row)) $row = '"'.implode('","',$row).'"';
        $row = $row."\n";
        try {
               fwrite($filePointer, $row);
        } catch(Exception $e) {
               Mage::Log($e->getMessage());
               return false;
        }
        return true;
    }
    
    public function getRandomHash($length=40) {
        $max = ceil($length / 40);
        $random = '';
        for ($i = 0; $i < $max; $i ++) {
          $random .= sha1(microtime(true).mt_rand(10000,90000));
        }
        return substr($random, 0, $length);
    }
    
    public function getUrlHash(){
        
        if($this->getHash() == ""){
            $hash = $this->getRandomHash();
            $this->setHash($hash);
            $this->save();
        }
        
        $customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        $hash = sha1($customer->getEmail().$this->getHash().$customer->getPasswordHash());
        return $hash;
    }
    
    
    public function getQuoteCurrency()
    {
        if (is_null($this->_quoteCurrency)) {
            $this->_quoteCurrency = Mage::getModel('directory/currency')->load($this->getCurrency());
        }
        return $this->_quoteCurrency;
    }    
    
    public function isCurrencyDifferent()
    {
        return $this->getQuoteCurrency() != $this->getBaseCurrencyCode();
    }
    
    public function getBaseCurrencyCode(){
        
       return Mage::app()->getBaseCurrencyCode(); 
    }
    
    public function getBaseCurrency()
    {
        if (is_null($this->_baseCurrency)) {
            $this->_baseCurrency = Mage::getModel('directory/currency')->load($this->getBaseCurrencyCode());
        }
        return $this->_baseCurrency;
    }
    
    
    public function formatBasePrice($price)
    {
        return $this->formatBasePricePrecision($price, 2);
    }
    
    public function formatBasePricePrecision($price, $precision)
    {
        return $this->getBaseCurrency()->formatPrecision($price, $precision);
    }
      
    public function formatPrice($price, $addBrackets = false)
    {
        return $this->formatPricePrecision($price, 2, $addBrackets);
    }
    
    public function formatPricePrecision($price, $precision, $addBrackets = false)
    {
        return $this->getQuoteCurrency()->formatPrecision($price, $precision, array(), true, $addBrackets);
    }
    
    // we do not quote for virtual items
    public function getVirtualItemsQty(){
        return 0;
    }
    
    public function getAddress(){
       
       if($this->_address == null){
          $this->_address = Mage::getSingleton('qquoteadv/address');
          
          
          $this->_address->setQuote($this);
       }
       
       return $this->_address;
    }
    
    public function getShippingStreets() {
       return $this->getData('shipping_address');
    }
        
    public function getShippingAddress(){
        return $this->getAddress();
    }
    
    public function getBillingAddress(){
       return $this->getAddress();
    }
    
    public function collectTotals(){
        
        
        if ($this->getTotalsCollectedFlag()) {
            return $this;
        }
        $address = $this->getAddress();
        $this->setSubtotal(0);
        $this->setBaseSubtotal(0);
        $this->setGrandTotal(0);
        $this->setBaseGrandTotal(0);
        
        $this->setTaxAmount(0);
        $this->setBaseTaxAmount(0);
        $this->setSubtotalInclTax(0);
        $this->setBaseSubtotalInclTax(0);
        $this->setBaseShippingAmountInclTax(0);
        $this->setShippingAmountInclTax(0);
        $this->setBaseShippingInclTax(0);
        $this->setShippingInclTax(0);
        $this->setShippingAmount(0);
        $this->setBaseShippingAmount(0);
        $this->setShipping(0);
        $this->setBaseShipping(0);
        
        $address->setTotalAmount('subtotal',0);
        $address->setBaseTotalAmount('subtotal',0);
        $address->setGrandTotal(0);
        $address->setBaseGrandTotal(0);
        $address->setTotalAmount('tax',0);
        $address->setBaseTotalAmount('tax',0);
        $address->setSubtotalInclTax(0);
        $address->setBaseSubtotalInclTax(0);
        $address->setBaseShippingInclTax(0);
        $address->setShippingInclTax(0);
        $address->setBaseShippingInclTax(0);
        $address->setShippingInclTax(0);
        $address->setShippingAmount(0);
        $address->setShippingAmount(0);
        $address->setShippingAmount(0);
        $address->setBaseShippingAmount(0);
         $this->setItemsCount(0);
        $this->setItemsQty(0);
        $this->save();
        
        $address->collectTotals();
        
        $this->setSubtotal($address->getTotalAmount('subtotal'));
        $this->setBaseSubtotal($address->getBaseTotalAmount('subtotal'));
        $this->setGrandTotal($address->getGrandTotal());
        $this->setBaseGrandTotal($address->getBaseGrandTotal());
        $this->setTaxAmount($address->getTotalAmount('tax'));
        $this->setBaseTaxAmount($address->getBaseTotalAmount('tax'));
        $this->setSubtotalInclTax($address->getSubtotalInclTax());
        $this->setBaseSubtotalInclTax($address->getBaseSubtotalInclTax());
        $this->setBaseShippingAmountInclTax($address->getBaseShippingInclTax());
        $this->setShippingAmountInclTax($address->getShippingInclTax());
        $this->setBaseShippingInclTax($address->getBaseShippingInclTax());
        $this->setShippingInclTax($address->getShippingInclTax());
        $this->setShippingAmount($address->getShippingAmount());
        $this->setBaseShippingAmount($address->getShippingAmount());
        $this->setShipping($address->getShippingAmount());
        $this->setBaseShipping($address->getBaseShippingAmount());
        $this->checkQuoteAmount($this->getGrandTotal());
        $this->checkQuoteAmount($this->getBaseGrandTotal());
        $this->setTotalsCollectedFlag(true);
        
        
        return $this;
    }
	
	/**
	* @return boolean|Array
	*
	*/
	
	public function getAllRequestItemsForCart()
	{
            $returnValue = array();

            if($this->_requestItems == null){
                $requestItems = Mage::getSingleton('qquoteadv/requestitem')->getCollection()->setQuote($this);
                $foundProductIds = array();

                $newItems = array();
                foreach($requestItems as $item)
                {
                        //AutoConfirm not possible if one product has more request options.
                        if(in_array($item->getProductId(), $foundProductIds))
                        {
                            return false;
                        }
                        else
                        {
                            $foundProductIds[$item->getProductId()] = $item->getProductId();
                        }

                        $qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($item->getQuoteadvProductId());
                        $returnValue[$item->getQuoteadvProductId()] = $item->getId();
                }
            }

            return $returnValue;
            
        }
    
    
        public function getAllRequestItems(){
        
        if($this->_requestItems == null){
            $requestItems = Mage::getSingleton('qquoteadv/requestitem')->getCollection()->setQuote($this);
            $newItems = array();
            foreach($requestItems as $item){
                $qqadvproduct = Mage::getModel('qquoteadv/qqadvproduct')->load($item->getQuoteadvProductId());
                $product =  Mage::getModel('catalog/product')->load($item->getProductId());
                $product->setSkipCheckRequiredOption(true);    
                $product->setStoreId( $qqadvproduct->getStoreId()? $qqadvproduct->getStoreId():1);
                $productParams = new Varien_Object(unserialize($qqadvproduct->getAttribute()));
                $newItem = $this->addProductAdvanced($product,$productParams);
                
                if($newItem->getParentItem()){
                    $newItem->getParentItem()->setQty($item->getQty());
                }else{
                    $newItem->setQty($item->getQty());
                }
                
                if($newItem->getParentItem()) $newItem = $newItem->getParentItem();
                $newItem->setCustomPrice($item->getOwnerCurPrice());
                $newItems[] = $newItem; 
            }
            
           
         
            $items = array();
            foreach($this->getAllItems() as $item){
             
               if(!$item->getId()){
                       foreach($newItems as $newItem) {
                        if(  $newItem->getData('sku') == $item->getData('sku') 
                           && $newItem->getData('product_id') == $item->getData('product_id') 
                           && $newItem->getData('qty_to_add') == $item->getData('qty_to_add')  
                           && $newItem->getData('weight') == $item->getData('weight')                              
                           ) {
                            
                           
                           $item->setCustomPrice($newItem->getCustomPrice());
                       }
                   }
                   $items[] = $item;
               } 
            }
            
          
            
            $this->_requestItems = $items;
           
        }
        return $this->_requestItems;
    }
    
    public function checkQuoteAmount($amount) {
        if (!$this->getHasError() && ($amount>=self::MAXIMUM_AVAILABLE_NUMBER)) {
            $this->setHasError(true);
            $this->addMessage(
                $this->__('Items maximum quantity or price do not allow checkout.')
            );
        }
    }
    
    public function getCustomer() {
        return Mage::getModel('customer/customer')->load($this->getCustomerId());
    }
    
    public function getCustomerGroupId() {
        return $this->getCustomer()->getGroupId();
    }
    
    public function getItemById($id) {
        return Mage::getModel('qquoteadv/requestitem')->load($id);
    }
    
    public function getCouponCode() {
        return "";
    }
    
    
    public function getFullTaxInfo() {
        return false;
    }
    
    public function getGrandTotalExclTax(){
        return $this->getGrandTotal() - $this->getTaxAmount();
    }
    
    
    public function getWeight(){
        if($this->_weight == null){
            $this->_weight = 0;
            $items = $this->getAllRequestItems();
            foreach($items as $item){
                $this->_weight +=  $item->getWeight();
            }
        }
        return $this->_weight;
    }
    
    public function getItemsQty(){
        if($this->_itemsQty == null){
            $this->_itemsQty = 0;
            $items = $this->getAllRequestItems();
            foreach($items as $item){
                if($item->getParentItem()){
                    continue;
                }
                $this->_itemsQty +=  $item->getQty();
            }
        }
        return $this->_itemsQty;
    }
    
    public function getIsCustomShipping(){
        if($this->getShippingType() == "I" || $this->getShippingType() == "O"){
            return true;
        }
        return false;
        
    }

    /**
     * @return Mage_Admin_Model_User
     */
    public function getSalesRepresentative()
    {
        if(!$this->hasData('user'))
        {
            $user = Mage::getModel('admin/user')->load($this->getUserId());
            $this->setData('user', $user);
        }
        return $this->getData('user');
    }

    /**
     * Get sender info for quote
     *
     * @return array
     */
    public function getEmailSenderInfo()
    {
        $senderValue = Mage::getStoreConfig('qquoteadv/emails/sender', $this->getStoreId());
        if(empty($senderValue)) {
            $admin = Mage::getModel("admin/user")->getCollection()->getData();
            return array(
                'name' => $admin[0]['firstname'] . " " . $admin[0]['lastname'],
                'email' => $admin[0]['email'],
            );
        }

        if($senderValue == 'qquoteadv_sales_representive')
        {
            return array(
                'name' => $this->getSalesRepresentative()->getName(),
                'email' => $this->getSalesRepresentative()->getEmail()
            );
        }

        $email = Mage::getStoreConfig('trans_email/ident_'.$senderValue.'/email');
        if(!empty($email)) {
            return array(
                'name' => Mage::getStoreConfig('trans_email/ident_'.$senderValue.'/name'),
                'email' => $email
            );
        }

        return array(
            'name' => $senderValue,
            'email' => $senderValue
        );
    }
}
