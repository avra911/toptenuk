<?php
class Ophirah_Qquoteadv_Model_Api extends Mage_Api_Model_Resource_Abstract
{
   /**
   * Retrieve list of quotations using filters
   *
   * @param array $filters
   * @return array
   */
   function items($filters) {
     $_collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
     $_collection->addFieldToFilter('is_quote', 1);

     if (count($filters)) {
      
       foreach($filters as $filter=>$value) { 
         $_collection->addFieldToFilter("$filter", $value);
       }       
     }
     return $_collection->toArray();
   }
   /**
   * Set quotation as exported
   *
   * @param array $params
      int     $params['quote_id']
      string  $params['value']
   * @return array|bool
   */
   function setimported($params) {
     $exceptions = array();
     if (isset($params['quote_id']) && isset($params['value'])) {
        $quote_id  = $params['quote_id'];
        $value     = $params['value'];
          
        $_quoteCollection = Mage::getModel('qquoteadv/qqadvcustomer')->load($quote_id);
        $_quoteCollection->setImported($value);
        try {
          $_quoteCollection->save();
        } catch(Exception $e) {
          $data = array('request_data' => $params, 'exception' => $e->getMessage());
          $exceptions[] = $data;            
        }
      
        if (count($exceptions)>0) {
          return array(
              'error' => var_export($exceptions,1), 
               'method' => __METHOD__
              );
        }
      
      return true; //'setimported: update is ok';
     }
     
     return array(
         'error' => 'request data format is not correct',
         'method' => __METHOD__
         );
   }

   /**
   * Retrieve an quotation's information
   *
   * @param int $quote_id
   * @return array
   */
   function info($quote_id) {
	  $_quoteCollection = Mage::getModel('qquoteadv/qqadvproduct')->getCollection()
                            ->addFieldToFilter('quote_id', $quote_id);
	  
	  if ($_quoteCollection->getSize()>0) { 
        $response = $_quoteCollection->toArray();
		
		foreach( $response['items'] as $index => $row) {
          $key = $row['id'];
		  $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
				  ->addFieldToFilter('quote_id', $quote_id)
				  ->addFieldToFilter('quoteadv_product_id', $key);
				 
          if ($_collection->getSize()>0) { 
             $requested = $_collection->toArray();
          
             $row['primary_key'] =  $row['id'];
             $storeId   = $row['store_id'];
             $productId = $row['product_id'];
             try {
              $sku = Mage::getModel('catalog/product')->setStoreId($storeId)->load($productId)->getSku();
             } catch(Exception $e) { }            
             
             $row['sku'] = $sku? $sku : "not exists";
             
            //#add attributes/options
            foreach ($requested['items'] as $key => $request) {
              //$request['foreign_key'] = $request['quoteadv_product_id'];
              //unset($request['quoteadv_product_id']);
              
              $request['attribute']     = $row['attribute'];	
              $request['has_options']   = $row['has_options'];	
              $request['options']       = $row['options'];		
              $requested['items'][$key]  = $request;
            }
            $row['data'] = $requested;

            
            //#
            unset($row['id']);
            //unset($row['attribute']);
            //unset($row['has_options']);
            //unset($row['options']);
            unset($row['qty']);	
            //unset($row['product_id']);


            $response['items'][$index] = $row;
          }
		}
        return $response;
	  } else {
		return array(
         'error' => 'Quote is not found',
         'method' => __METHOD__
         );
	  }
   }
   
   /**
   * Retrieve list of quotation's states
   *
   * @return array
   */   
   function status_list() {
	 return Mage::getSingleton('qquoteadv/status')->getOptionArray(); 
   }
   
   /* Add qty by requested item with owner proposal price
   * @param array $params
       $params = array(        
          'quote_id'        =>int,
          'product_id'      =>int,
          'request_qty'     =>int,
          'owner_base_price'=>float,
          'original_price'  =>float,
          'quoteadv_product_id'=>int
        );
   * @return array
   */   
   function addqtybyitem($params) {

       if (isset($params['quote_id']) && isset($params['product_id']) 
               && isset($params['request_qty']) && isset($params['owner_base_price'])
               && isset($params['original_price']) && isset($params['quoteadv_product_id'])               
       ) {
       
        $quote_id     = $params['quote_id'];
        $key          = $params['quoteadv_product_id'];
        $request_qty  = $params ['request_qty'];

        $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                            ->addFieldToFilter('quote_id', $quote_id)
                            ->addFieldToFilter('quoteadv_product_id', $key);

        if ($_collection->getSize()>0) { 
              $requested = $_collection->toArray(); 

              $_collection->clear();
              $_collection->addFieldToFilter('request_qty', $request_qty);
              $data = $_collection->getData();
              if(count($data) > 0){ 
                $message =  'Duplicate qty value entered:';
                $message.=  "\nrequest data:" . var_export($params,1);
                
                Mage::log($message);
                return array( 'error' => $message, 'method' => __METHOD__ );
              }

              try {                    
                  Mage::getModel('qquoteadv/requestitem')->setData($params)->save();   
              } catch (Exception $e) { 
                 
                $message = 'Can not add item to quote request. ';
                $message.= $e->getMessage();
                Mage::log($message);

                return array('error' => $message, 'method' => __METHOD__ );
              }
              
              return array( 'result' => 'success', 'method' => __METHOD__ );
              
          }else{
            return array( 'error' => 'Quote data is not ok', 'method' => __METHOD__ );
          } 
          
      }else{
          return array( 'error' => 'Quote is not found', 'method' => __METHOD__ );
      }
      
      return array('error' => 'Quote is not found', 'method' => __METHOD__ );
   }
  
   /**
   * Send email proposal to client
   *
   * @param int $quoteId
   * @return array
   */
   function send_proposal($quoteId) {
     $exceptions = array();
     
     if ($quoteId) {
       $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);

       //#send Proposal email
       if ($customerId = $_quoteadv->getCustomerId()) {
         
          $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
				  ->addFieldToFilter('quote_id', $quoteId);
				 
          if ($_collection->getSize()>0) { 
         
            $res = $this->_sendProposalEmail($quoteId);    
            if (empty($res)) {
                $message = sprintf("Qquote proposal email was't sent to the client for quote #%s", $_quoteadv->getId());
                $exceptions[] = $message;
            } else {

              $_quoteadv->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_PROPOSAL);
              try {
                  $_quoteadv->save();
              } catch(Exception $e) {
                  $exceptions[] = $e->getMessage();          
              }            
            }
          } else {
            $exceptions[] = 'Quote data is ok for proposal sent';
          }
       } else {
         $exceptions[] = 'Quote customer is not found';
       }       
      
     } else {
       $exceptions[] = 'Quote is not found';
     }
     
     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   } 

    
   /**
   * Send email proposal to client
   *
   * @param int $quoteId
   * @return array
   */
    private function _sendProposalEmail($quoteId) {
        $admin = Mage::getModel("admin/user")->getCollection()->getData();

        //Create an array of variables to assign to template
        $vars = array();

        /* @var $_quoteadv Ophirah_Qquoteadv_Model_Qqadvcustomer */
        $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);

        $vars['quote'] = $_quoteadv;
        
        $customer = Mage::getModel('customer/customer')->load($_quoteadv->getCustomerId());
        $vars['customer'] = $customer;
        $params['email']  = $customer->getEmail();
        $params['name']   = $customer->getName();

        $template = Mage::getModel('core/email_template');

		$quoteadv_param = Mage::getStoreConfig('qquoteadv/emails/proposal', $_quoteadv->getStoreId());
        if ($quoteadv_param) {
            $templateId = $quoteadv_param;
        } else {
            $templateId = self::XML_PATH_QQUOTEADV_REQUEST_PROPOSAL_EMAIL_TEMPLATE;
        }

        if (is_numeric($templateId)) {
            $template->load($templateId);
        } else {
            $template->loadDefault($templateId);
        }

        $vars['attach_pdf'] = $vars['attach_doc'] = false;

        //Create pdf to attach to email

        if (Mage::getStoreConfig('qquoteadv/attach/pdf', $_quoteadv->getStoreId())) {
            $pdf = Mage::getModel('qquoteadv/pdf_qquote')->getPdf($_quoteadv);
            $realQuoteadvId = $_quoteadv->getIncrementId() ? $_quoteadv->getIncrementId() : $_quoteadv->getId();
			try{
				$file = $pdf->render();
				$name = Mage::helper('qquoteadv')->__('Price_proposal_%s', $realQuoteadvId);
				$template->getMail()->createAttachment($file,'application/pdf',Zend_Mime::DISPOSITION_ATTACHMENT, Zend_Mime::ENCODING_BASE64, $name.'.pdf');
				$vars['attach_pdf'] = true;

			}catch(Exception $e){ Mage::log($e->getMessage()); }
			
        }

        if ($doc = Mage::getStoreConfig('qquoteadv/attach/doc', $_quoteadv->getStoreId())) { 
        	$pathDoc =  Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS .'quoteadv'. DS .$doc;         	 
        	try{
                $file = file_get_contents($pathDoc);

                $info = pathinfo($pathDoc);
                //$extension = $info['extension']; 
                $basename = $info['basename'];
                $template->getMail()->createAttachment($file, '' ,Zend_Mime::DISPOSITION_ATTACHMENT,Zend_Mime::ENCODING_BASE64,$basename); 
                $vars['attach_doc'] = true;  
            }catch(Exception $e){ Mage::log($e->getMessage()); }
        }
        $remark = Mage::getStoreConfig('qquoteadv/general/qquoteadv_remark', $_quoteadv->getStoreId());
        if ( $remark ) {
            $vars['remark'] = $remark;
        }
        /*
        $adm_name = $this->getAdminName($_quoteadv->getUserId()); 
        $adm_name = trim($adm_name);        
        //if ( empty($adm_name)) { $adm_name = $this->getAdminName(Mage::getSingleton('admin/session')->getUser()->getId()); } 
        if ( !empty($adm_name)) {
           $vars['adminname'] = $adm_name;
        }        
        */
        $subject = $template['template_subject'];

        $vars['link'] = Mage::getUrl("qquoteadv/view/view/", array('id' => $quoteId));

		$sender = $_quoteadv->getEmailSenderInfo();
        $template->setSenderName($sender['name']);
        $template->setSenderEmail($sender['email']);

        $template->setTemplateSubject($subject);
		$bcc = Mage::getStoreConfig('qquoteadv/emails/bcc', $_quoteadv->getStoreId());
        if ($bcc) {
			$bccData = explode(";", $bcc);
            $template->addBcc($bccData);
        }

        if((bool) Mage::getStoreConfig('qquoteadv/emails/send_linked_sale_bcc', $_quoteadv->getStoreId())) {
            $template->addBcc(Mage::getModel('admin/user')->load($_quoteadv->getUserId())->getEmail());
        }

        $template->setDesignConfig(array('store' => $_quoteadv->getStoreId()));
        
        /**
         * Opens the qquote_request.html, throws in the variable array
         * and returns the 'parsed' content that you can use as body of email
         */
        $processedTemplate = $template->getProcessedTemplate($vars);

        /*
         * getProcessedTemplate is called inside send()
         */
        $res = $template->send($params['email'], $params['name'], $vars);

        return $res;
    }
    
   /**
   * Set shipping type
   *
   * @param array $params   
      float  $params['shipping_price']
      string $params['shipping_type']    
   * @return array
   */
   function set_shipping($params){
     
     $exceptions = array();
     
     if (isset($params['quote_id']) && isset($params['shipping_type']) && isset($params['shipping_price']) ) {
        $quoteId  = (int)$params['quote_id'];
        
        $type     = (string)$params['shipping_type'];
        $price    = (float)$params['shipping_price'];
        
        if (empty($type) ) { 
          $price = -1;         
        }elseif( ($type == "I" or $type == "O") && $price>0) {
          
        }else{
          $exceptions[] = 'Request data is not ok';
        }       
        
        if(count($exceptions) >0 ) {
          //errors
        }else{
          
          if ($quoteId) {
            $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);
            $_quoteadv->setShippingType($type);
            $_quoteadv->setShippingPrice($price);
            try{
                $_quoteadv->save();
            }catch(Exception $e){
                $message = $e->getMessage();
                $exceptions[] = $message;            
            }     

          }else{
            $exceptions[] = 'Quote is not found';
          }
        }
     }else{
       $exceptions[] = 'Request data is not ok';
     }     
     
     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   }
   
   /**
   * Send owner comment for proposal
   *
   * @param array $params   
      int    $params['quote_id']
      string $params['comment']    
   * @return array
   */
   function set_proposal_comment($params){
     
     $exceptions = array();
     $limit = 400;
     
     if (isset($params['quote_id']) && isset($params['comment']) ) {
        $quoteId  = (int)$params['quote_id'];
        $comment  = trim($params['comment']);
        if ( strlen($comment) > $limit) {        
          $exceptions[] = sprintf("Quote comment length has limit %s characters", $limit);
        }
        
        if (count($exceptions)>0) {
            //#errors
        }else{
           if ($quoteId) {
              $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);
              $_quoteadv->setClientRequest($comment);

              try{
                  $_quoteadv->save();
              }catch(Exception $e){
                  $message = $e->getMessage();
                  $exceptions[] = $message;            
              }     
            }else{
              $exceptions[] = 'Quote is not found';
            }
        }
        
        
     }else{
       $exceptions[] = 'Request data is not ok';
     }     
     
     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   }   
   
   /**
   * Send comment for item
   *
   * @param array $params   
      int    $params['quoteadv_product_id']
      string $params['comment']    
   * @return array
   */
   function set_item_comment($params){
     $exceptions = array();
     $limit = 400;
     
     if (isset($params['quoteadv_product_id']) && isset($params['comment']) ) {
      
        $id = (int)$params['quoteadv_product_id'];
        $comment  = trim($params['comment']);
        
        if ( strlen($comment) > $limit) {        
          $exceptions[] = sprintf("Quote comment length has limit %s characters", $limit);
        }
        
        if (count($exceptions)>0) {
            //#errors
        }else{
            $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load($id) ;         
            $_quoteadv->setClientRequest($comment);

            try{
              $_quoteadv->save();
            }catch(Exception $e){
              $message = $e->getMessage();
              $exceptions[] = $message;            
            }   
        }
        
     }else{
       $exceptions[] = 'Request data is not ok';
     }   

     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   }
  
   /**
   * Delete requested qty
   *
   * @param array $params   
      int $params['request_id']
      int $params['quote_id']    
   * @return array
   */
   function delete_requested_qty($params){
     $exceptions = array();
     
     if(isset($params['request_id']) && isset($params['quote_id']) ){
       $requestId = (int)$params['request_id'];
       $quoteId   = (int)$params['quote_id'];
       
       $_quoteadv = Mage::getModel('qquoteadv/requestitem')->load($requestId);
       $itemData = $_quoteadv->getData();
       if (count($itemData) > 0 ){
         if( $itemData['quote_id']  == $quoteId) {
           $id = $itemData['quoteadv_product_id'];
           $_itemsCollection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                   ->addFieldToFilter('quoteadv_product_id', $id)
                   ->addFieldToFilter('quote_id', $quoteId)
                   ;
           if($_itemsCollection->getSize() >1 ){
           
            try{
                $_quoteadv->delete();
              }catch(Exception $e){
                $message = $e->getMessage();
                $exceptions[] = $message;            
              }   
           }else{
             $exceptions[] = 'You cannot delete this last item Qty';
           }
            
         }else{
           $exceptions[] = 'Request data is not ok';
         }
       }else{
         $exceptions[] = 'Quote item qty is not found';
       }
       
       
     }else{
       $exceptions[] = 'Request data is not ok';
     }

     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   }

   /**
   * Delete requested item
   *
   * @param array $params   
      int $params['primary_key']
      int $params['quote_id']    
   * @return array
   */
   function delete_requested_item($params){
     $exceptions = array();
     
     if(isset($params['primary_key']) && isset($params['quote_id']) ){
       $id = (int)$params['primary_key'];
       $quoteId   = (int)$params['quote_id'];
       
       $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load($id);
       $itemData = $_quoteadv->getData();
       if (count($itemData) > 0 ){
         if( $itemData['quote_id']  == $quoteId) {
           
           $_itemsCollection = Mage::getModel('qquoteadv/qqadvproduct')->getCollection()
                   ->addFieldToFilter('quote_id', $quoteId)
                   ;
           if($_itemsCollection->getSize() >1 ){
           
            try{
                $_quoteadv->delete();
              }catch(Exception $e){
                $message = $e->getMessage();
                $exceptions[] = $message;            
              }   
           }else{
             $exceptions[] = 'You cannot delete this last item';
           }
            
         }else{
           $exceptions[] = 'Request data is not ok';
         }
       }else{
         $exceptions[] = 'Quote item is not found';
       }
       
       
     }else{
       $exceptions[] = 'Request data is not ok';
     }

     if (count($exceptions)>0) {
      return array( 'error' => var_export($exceptions,1), 'method' => __METHOD__ );
     }
     return array( 'result' => 'success', 'method' => __METHOD__ );
   }
   
   /**
   * Modify requested item's qty
   *
   * @param array $params   
      int $params['request_id']
      int $params['quote_id']
      int $params['product_id']  
      int $params['request_qty']  
      float $params['owner_base_price']  
      float $params['original_price']
      int $params['quoteadv_product_id']        
   * @return array
   */
   function modify_requested_qty($params){ //Mage::log(var_export($params, 1)); 

       if ( isset($params['request_id']) && isset($params['quote_id']) && isset($params['product_id']) 
               && isset($params['request_qty']) && isset($params['owner_base_price'])
               && isset($params['original_price']) && isset($params['quoteadv_product_id'])               
       ) {
       
        $quote_id     = $params['quote_id'];
        $key          = $params['quoteadv_product_id'];
        $request_qty  = $params ['request_qty'];

        $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                            ->addFieldToFilter('quote_id', $quote_id)
                            ->addFieldToFilter('quoteadv_product_id', $key);

        if ($_collection->getSize()>0) { 
              $requested = $_collection->toArray(); 

              $_collection->clear();
              $_collection->addFieldToFilter('request_qty', $request_qty);
              $data = $_collection->getData();
              if(count($data) > 0){ 
                $message =  'Duplicate qty value entered:';
                $message.=  "\nrequest data:" . var_export($params,1);
                
                Mage::log($message);
                return array( 'error' => $message, 'method' => __METHOD__ );
              }

              try {                    
                  Mage::getModel('qquoteadv/requestitem')->load($params['request_id'])->setData($params)->save();   
              } catch (Exception $e) { 
                 
                $message = 'Can not update item\'s qty. ';
                $message.= $e->getMessage();
                Mage::log($message);

                return array('error' => $message, 'method' => __METHOD__ );
              }
              
              return array( 'result' => 'success', 'method' => __METHOD__ );
              
          }else{
            return array( 'error' => 'Quote data is not ok', 'method' => __METHOD__ );
          } 
          
      }else{
          return array( 'error' => 'Quote is not found', 'method' => __METHOD__ );
      }
      
      return array('error' => 'Quote is not found', 'method' => __METHOD__ );
   }
}