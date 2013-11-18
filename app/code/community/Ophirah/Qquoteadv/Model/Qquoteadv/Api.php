<?php

class Ophirah_Qquoteadv_Model_Qquoteadv_Api extends Mage_Api_Model_Resource_Abstract
{

//   protected $_mapAttributes = array(
//        
//   );
    //NOTE: for PDF quote proposal fields we have text limitation
    public $_limitComment = 400;

    /**
     * Retrieve list of quotations using filters
     *
     * @param array $filters
     * @return array
     */
    function items($filters)
    {
        $_collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
        $_collection->addFieldToFilter('is_quote', 1);

        if (is_array($filters)) {
            try {
                foreach ($filters as $filter => $value) {
                    $_collection->addFieldToFilter("$filter", $value);
                }
            } catch (Mage_Core_Exception $e) {
                $this->_fault('filters_invalid', $e->getMessage());
            }
        }

        $data = $_collection->toArray();
        return $data['items'];
    }

    /**
     * Set quotation as exported
     *
     * @param array $params
    int     $params['quote_id']
    string  $params['value']
     * @return array|bool
     */
    function setimported($params)
    {

        if (isset($params['quote_id']) && isset($params['value'])) {
            $quote_id = $params['quote_id'];
            $value = $params['value'];

            $_quote = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quote_id);

            if (!$_quote->getId()) {
                $this->_fault('quote_not_exists');
            }

            try {
                $_quote->setImported((bool)$value);
                $_quote->save();
            } catch (Exception $e) {
                $this->_fault('data_invalid', $e->getMessage());
            }

            return true;
        } else {
            $this->_fault('data_invalid', "QuoteId or Value didn't not received");
        }
    }

    /**
     * Retrieve an quotation's information
     *
     * @param int $quote_id
     * @return array
     */
    function info($quote_id)
    {

        $_quoteCollection = Mage::getModel('qquoteadv/qqadvproduct')->getCollection()
            ->addFieldToFilter('quote_id', (int)$quote_id);

        if ($_quoteCollection->getSize() > 0) {
            $response = $_quoteCollection->toArray();

            foreach ($response['items'] as $index => $row) {
                $key = $row['id'];
                $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                    ->addFieldToFilter('quote_id', (int)$quote_id)
                    ->addFieldToFilter('quoteadv_product_id', $key);

                if ($_collection->getSize() > 0) {
                    $requested = $_collection->toArray();

                    $row['primary_key'] = $row['id'];
                    $storeId = $row['store_id'];
                    $productId = $row['product_id'];

                    try {
                        $row['sku'] = Mage::getModel('catalog/product')->setStoreId($storeId)->load($productId)->getSku();
                    } catch (Exception $e) {
                        $this->_fault('data_invalid', $e->getMessage());
                    }

                    //#add attributes/options
                    foreach ($requested['items'] as $key => $request) {
                        //$request['foreign_key'] = $request['quoteadv_product_id'];
                        //unset($request['quoteadv_product_id']);

                        $request['attribute'] = $row['attribute'];
                        $request['has_options'] = $row['has_options'];
                        $request['options'] = $row['options'];
                        $requested['items'][$key] = $request;
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
            $this->_fault('quote_not_exists', 'Quotation is not found');
        }
    }

    /**
     * Retrieve list of quotation's states
     *
     * @return array
     */
    function status_list()
    {
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

    function add_qtybyitem($params)
    {
        $response = array(
            'success' => false
        );

        if (isset($params['quote_id']) && isset($params['product_id'])
            && isset($params['request_qty']) && isset($params['owner_base_price'])
            && isset($params['original_price']) && isset($params['quoteadv_product_id'])
        ) {

            $quote_id = $params['quote_id'];
            $key = $params['quoteadv_product_id'];
            $request_qty = $params ['request_qty'];

            $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                ->addFieldToFilter('quote_id', (int)$quote_id)
                ->addFieldToFilter('product_id', (int)$params['product_id'])
                ->addFieldToFilter('quoteadv_product_id', (int)$key);

            if ($_collection->getSize() > 0) {
                $requested = $_collection->toArray();

                $_collection->clear();
                $_collection->addFieldToFilter('request_qty', $request_qty);
                $data = $_collection->getData();

                if (count($data) > 0) {
                    $this->_fault('dublicate_data', 'Duplicate qty value entered');
                }

                try {
                    Mage::getModel('qquoteadv/requestitem')->setData($params)->save();
                } catch (Exception $e) {
                    $this->_fault('save_error', $e->getMessage());
                }
                $response = array(
                    'success' => true
                );
            } else {
                $this->_fault('not_exists', "Data by QuoteId / QuoteadvProductId / ProductId not found");
            }
        } else {
            $this->_fault('data_invalid', "Initial parameters didn't not received");
        }

        return $response;
    }

    /**
     * Send email proposal to client
     *
     * @param int $quoteId
     * @return array
     */
    function send_proposal($quoteId)
    {

        if ($quoteId) {
            $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);
            if (!$_quoteadv->getId()) {
                $this->_fault('quote_not_exists');
            }

            //#send Proposal email
            if ($customerId = $_quoteadv->getCustomerId()) {

                $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                    ->addFieldToFilter('quote_id', (int)$quoteId);

                if ($_collection->getSize() > 0) {

                    $res = $this->_sendProposalEmail($quoteId);
                    if (empty($res)) {
                        $message = sprintf("Qquote proposal email was't sent to the client for quote #%s", $_quoteadv->getId());
                        $this->_fault('data_invalid', $message);
                    } else {

                        try {
                            $_quoteadv->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_PROPOSAL);
                            $_quoteadv->save();
                        } catch (Exception $e) {
                            $this->_fault('save_error', $e->getMessage());
                        }
                        return true;
                    }
                } else {
                    $this->_fault('not_exists');
                }
            } else {
                $this->_fault('quote_not_exists');
            }
        } else {
            $this->_fault('data_invalid', "QuoteId parameter didn't received");
        }
        return false;
    }

    /**
     * Send email proposal to client
     *
     * @param int $quoteId
     * @return array
     */
    private function _sendProposalEmail($quoteId)
    {
        $admin = Mage::getModel("admin/user")->getCollection()->getData();

        //Create an array of variables to assign to template
        $vars = array();

        /* @var $_quoteadv Ophirah_Qquoteadv_Model_Qqadvcustomer */
        $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);

        $vars['quote'] = $_quoteadv;

        $customer = Mage::getModel('customer/customer')->load($_quoteadv->getCustomerId());
        $vars['customer'] = $customer;
        $params['email'] = $customer->getEmail();
        $params['name'] = $customer->getName();

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
            try {
                $file = $pdf->render();
                $name = Mage::helper('qquoteadv')->__('Price_proposal_%s', $realQuoteadvId);
                $template->getMail()->createAttachment($file, 'application/pdf', Zend_Mime::DISPOSITION_ATTACHMENT, Zend_Mime::ENCODING_BASE64, $name . '.pdf');
                $vars['attach_pdf'] = true;
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }

        if ($doc = Mage::getStoreConfig('qquoteadv/attach/doc', $_quoteadv->getStoreId())) {
            $pathDoc = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'quoteadv' . DS . $doc;
            try {
                $file = file_get_contents($pathDoc);

                $info = pathinfo($pathDoc);
                //$extension = $info['extension'];
                $basename = $info['basename'];
                $template->getMail()->createAttachment($file, '', Zend_Mime::DISPOSITION_ATTACHMENT, Zend_Mime::ENCODING_BASE64, $basename);
                $vars['attach_doc'] = true;
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
        $remark = Mage::getStoreConfig('qquoteadv/general/qquoteadv_remark', $_quoteadv->getStoreId());
        if ($remark) {
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
    function set_shipping($params)
    {
        $response = array(
            'success' => false
        );
        if (!isset($params['quote_id']) or !isset($params['shipping_type']) or !isset($params['shipping_price'])) {
            $this->_fault('data_invalid', "QuoteId or ShippingType or ShippingPrice parameters didn't not received");
        }
        $quoteId = (int)$params['quote_id'];
        $type = (string)$params['shipping_type'];
        $price = (float)$params['shipping_price'];

        if (empty($type)) {
            $price = -1;
        } elseif (($type == "I" or $type == "O") && $price > 0) {
            //ok
        } else {
            $this->_fault('data_invalid');
        }

        $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);
        if (!$_quoteadv->getId()) {
            $this->_fault('quote_not_exists');
        }

        try {
            $_quoteadv->setShippingType($type);
            $_quoteadv->setShippingPrice($price);
            $_quoteadv->save();
        } catch (Exception $e) {
            $this->_fault('save_error', $e->getMessage());
        }
        $response = array(
            'success' => true
        );


        return $response;
    }

    /**
     * Send owner comment for proposal
     *
     * @param array $params
    int    $params['quote_id']
    string $params['comment']
     * @return array
     */
    function set_proposal_comment($params)
    {
        $response = array(
            'success' => false
        );

        if (!isset($params['quote_id']) or !isset($params['comment'])) {
            $this->_fault('data_invalid', "QuoteId or Comment parameters didn't not received");
        }

        $quoteId = $params['quote_id'];
        $comment = trim($params['comment']);
        $len = strlen($comment);
        if ($len > $this->_limitComment) {
            $msg = sprintf("Comment length overlimit %s characters", $len - $this->_limitComment);
            $this->_fault('data_invalid', $msg);
        }

        $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int)$quoteId);
        if (!$_quoteadv->getId()) {
            $this->_fault('quote_not_exists');
        }

        try {
            $_quoteadv->setClientRequest($comment);
            $_quoteadv->save();
        } catch (Exception $e) {
            $this->_fault('save_error', $e->getMessage());
        }
        $response = array(
            'success' => true
        );

        return $response;
    }

    /**
     * Send comment for item
     *
     * @param array $params
    int    $params['quoteadv_product_id']
    string $params['comment']
     * @return array
     */
    function set_item_comment($params)
    {
        $response = array(
            'success' => false
        );

        if (!isset($params['quoteadv_product_id']) or !isset($params['comment'])) {
            $this->_fault('data_invalid', "QuoteadvProductId  or Comment parameters didn't not received");
        }

        $id = (int)$params['quoteadv_product_id'];
        $comment = trim($params['comment']);

        $len = strlen($comment);
        if ($len > $this->_limitComment) {
            $msg = sprintf("Comment length overlimit %s characters", $len - $this->_limitComment);
            $this->_fault('data_invalid', $msg);
        }

        $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load($id);
        if (!$_quoteadv->getId()) {
            $this->_fault('quote_not_exists');
        }

        try {
            $_quoteadv->setClientRequest($comment);
            $_quoteadv->save();
        } catch (Exception $e) {
            $this->_fault('save_error', $e->getMessage());
        }

        $response = array(
            'success' => true
        );


        return $response;
    }

    /**
     * Delete requested qty
     *
     * @param array $params
    int $params['request_id']
    int $params['quote_id']
     * @return array
     */
    function delete_requested_qty($params)
    {
        $response = array(
            'success' => false
        );

        if (!isset($params['request_id']) or !isset($params['quote_id'])) {
            $this->_fault('data_invalid', "RequestId or QuoteId parameters didn't not received");
        }

        $requestId = (int)$params['request_id'];
        $quoteId = (int)$params['quote_id'];

        $_quoteadv = Mage::getModel('qquoteadv/requestitem')->load($requestId);
        if (!$_quoteadv->getId()) {
            $this->_fault('data_invalid', "RequestId not exists");
        } elseif ($_quoteadv->getId() && $_quoteadv->getQuoteId() != $quoteId) {
            $this->_fault('data_invalid', "RequestId is wrong by QuoteId");
        }

        $itemData = $_quoteadv->getData();

        $id = $itemData['quoteadv_product_id'];
        $_itemsCollection = Mage::getModel('qquoteadv/requestitem')->getCollection()
            ->addFieldToFilter('quoteadv_product_id', $id)
            ->addFieldToFilter('quote_id', $quoteId);

        if ($_itemsCollection->getSize() > 1) {

            try {
                $_quoteadv->delete();

                $response = array(
                    'success' => true
                );
            } catch (Exception $e) {
                $this->_fault('delete_error', $e->getMessage());
            }

            $this->_updateQuoteStatus($quoteId);
        } else {
            $this->_fault('data_invalid', 'Minimum of one Qty is required');
        }

        return $response;
    }

    /**
     * Delete requested item
     *
     * @param array $params
    int $params['quote_id']
    int $params['primary_key']
     * @return array
     */
    function delete_requested_item($params)
    {
        $response = array(
            'success' => false
        );

        if (!isset($params['primary_key']) or !isset($params['quote_id'])) {
            $this->_fault('data_invalid', "PrimaryKey or QuoteId didn't not received");
        }

        $id = (int)$params['primary_key'];
        $quoteId = (int)$params['quote_id'];

        $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load($id);
        if (!$_quoteadv->getId()) {
            $this->_fault('data_invalid', "Data by PrimaryKey not exists");
        } else if ($_quoteadv->getData('quote_id') != $quoteId) {
            $this->_fault('data_invalid', 'PrimaryKey is wrong by QuoteId');
        }

        $itemData = $_quoteadv->getData();

        if (count($itemData) > 0) {

            $_itemsCollection = Mage::getModel('qquoteadv/qqadvproduct')->getCollection();
            $_itemsCollection->addFieldToFilter('quote_id', $quoteId);

            if ($_itemsCollection->getSize() > 1) {
                try {
                    $_quoteadv->delete();

                    $response = array(
                        'success' => true
                    );
                } catch (Exception $e) {
                    $this->_fault('data_invalid', $e->getMessage());
                }
            } else {
                $this->_fault('data_invalid', 'Minimum of one Item is required');
            }
        }

        return $response;
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
    function modify_requested_qty($params)
    {
        $response = array(
            'success' => false
        );

        if (isset($params['request_id']) &&
            isset($params['quote_id']) &&
            isset($params['product_id']) &&
            isset($params['request_qty']) &&
            isset($params['owner_base_price']) &&
            isset($params['original_price']) &&
            isset($params['quoteadv_product_id'])
        ) {

            $quote_id = (int)$params['quote_id'];
            $key = (int)$params['quoteadv_product_id'];
            $request_qty = $params ['request_qty'];

            $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
                ->addFieldToFilter('quote_id', $quote_id)
                ->addFieldToFilter('quoteadv_product_id', $key);

            if ($_collection->getSize() > 0) {
                $requested = $_collection->toArray();

                $_collection->clear();
                $_collection->addFieldToFilter('request_qty', $request_qty);
                $data = $_collection->getData();
                if (count($data) > 0) {
                    $this->_fault('dublicate_data', 'Duplicate qty value entered');
                }

                $item = Mage::getModel('qquoteadv/requestitem')->load((int)$params['request_id']);
                if (!$item->getRequestId()) {
                    $this->_fault('data_invalid', 'Item not exists by RequestId');
                }

                // Update quote
                try {
                    $item->setData($params);
                    $item->save();
                } catch (Exception $e) {
                    $this->_fault('save_error', $e->getMessage());
                }
                $response = array(
                    'success' => true
                );
            } else {
                $this->_fault('not_exists', 'Data by QuoteId and RequestId not exists');
            }
        } else {
            $this->_fault('data_invalid', "Initial parameters didn't not received");
        }

        return $response;
    }

    protected function _updateQuoteStatus($quoteId)
    {
        $quote = Mage::getSinglton('qquoteadv/qqadvcustomer')->load((int)$quoteId);
        if ($quote->getId()) {
            try {
                $quote->setStatus(Ophirah_Qquoteadv_Model_Status::STATUS_PROPOSAL_SAVED)->save();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }

    function add_products_to_quote($params)
    {
        $errors = array();
        if (!isset($params['quote_id'])) {
            $this->_fault('data_invalid', 'Quotation ID missing');
        } else {
            $quoteId = $params['quote_id'];
            $_qquoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load($quoteId);
            if (!count($_qquoteadv->getData())) {
                $this->_fault('not_exists', 'Quotation ID (' . $quoteId . ') does not exist');
            }
        }

        if (!isset($params['products']) || !is_array($params['products']) || !count($params['products'])) {
            $this->_fault('data_invalid', 'Products missing');
        } else {
            //check that the proucts exist
            $productIds = $params['products'];
            foreach ($productIds as $productId) {
                $product = Mage::getModel('catalog/product')->load($productId);
                if (!$product->getData('entity_id')) $this->_fault('not_exists', 'Product ID (' . $productId . ') does not exist');
            }
        }

        if (!count($errors)) {

            $hasOptions = FALSE;
            $options = FALSE;
            $storeId = $_qquoteadv->getStoreId();
            $modelProduct = Mage::getModel('qquoteadv/qqadvproduct');
            $qty = 1;
            foreach ($productIds as $productId) {

                $productsCollection = $modelProduct->getCollection()
                    ->addFieldToFilter('quote_id', $quoteId)
                    ->addFieldToFilter('product_id', $productId);

                $attribute = serialize(array('product' => $productId, 'qty' => $qty));

                // don't add if it has already been added
                if (!count($productsCollection)) {
                    $qproduct = array(
                        'quote_id' => $quoteId,
                        'product_id' => $productId,
                        'qty' => $qty,
                        'attribute' => $attribute,
                        'has_options' => $hasOptions,
                        'options' => $options,
                        'store_id' => $storeId
                    );
                    $checkQty = $modelProduct->addProduct($qproduct);

                    if (is_null($checkQty)) { // product has not been added redirect with error
                        $checkQty = new Varien_Object();
                        $checkQty->setHasError(true);
                        $checkQty->setMessage(Mage::helper('qquoteadv')->__('product can not be added to quote list'));
                    }

                    if ($checkQty->getHasError()) {
                        $this->_fault('save_error', $checkQty->getMessage());
                    } else {

                        $quoteadvProductId = $checkQty->getData('id');

                        $ownerPrice = Mage::helper('qquoteadv')->_applyPrice($quoteadvProductId, $qty);
                        $originalPrice = Mage::helper('qquoteadv')->_applyPrice($quoteadvProductId, $qty);
                        //#current currency price
                        $currencyCode = $_qquoteadv->getCurrency();
                        $ownerCurPrice = Mage::helper('qquoteadv')->_applyPrice($quoteadvProductId, $qty, $currencyCode);
                        $originalCurPrice = Mage::helper('qquoteadv')->_applyPrice($quoteadvProductId, $qty, $currencyCode);

                        $item = array(
                            'quote_id' => $quoteId,
                            'product_id' => $productId,
                            'request_qty' => $qty,
                            'owner_base_price' => $ownerPrice,
                            'original_price' => $originalPrice,
                            'owner_cur_price' => $ownerCurPrice,
                            'original_cur_price' => $originalCurPrice,
                            'quoteadv_product_id' => $quoteadvProductId
                        );

                        $requestitem = Mage::getModel('qquoteadv/requestitem')->setData($item);
                        $requestitem->save();


                    }
                }
            }
        }
        return array(
            'success' => true
        );
    }

    function update_quote_status($params)
    {
        // see Ophirah_Qquoteadv_Model_Status for status codes
        $errors = array();
        if (!isset($params['quote_id'])) {
            $this->_fault('data_invalid', 'Quotation ID missing');
        } else {
            $quoteId = $params['quote_id'];
            $_qquoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load($quoteId);
            if (!count($_qquoteadv->getData())) {
                $this->_fault('not_exists', 'Quotation ID (' . $quoteId . ') does not exist');
            }
        }

        if (!isset($params['status'])) {
            $this->_fault('data_invalid', 'Status missing');
        }

        if (!count($errors)) {

            $_qquoteadv->setStatus($params['status']);
            try {
                $_qquoteadv->save();
                $response = array(
                    'success' => true
                );
            } catch (Exception $e) {
                $this->_fault($e->getMessage());
            }
        }

        return $response;
    }
}