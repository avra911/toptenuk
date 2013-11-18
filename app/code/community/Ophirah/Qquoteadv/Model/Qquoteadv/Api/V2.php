<?php

class Ophirah_Qquoteadv_Model_Qquoteadv_Api_V2 extends Ophirah_Qquoteadv_Model_Qquoteadv_Api {

  /**
   * Retrieve list of quotations using filters
   *
   * @param array $filters
   * @return array
   */
  function items($filters) {
    $_collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection();
    $_collection->addFieldToFilter('is_quote', 1);

    $preparedFilters = array();
    if (isset($filters->filter)) {
      foreach ($filters->filter as $_filter) {
        $preparedFilters[$_filter->key] = $_filter->value;
      }
    }
    if (isset($filters->complex_filter)) {
      foreach ($filters->complex_filter as $_filter) {
        $_value = $_filter->value;
        $preparedFilters[$_filter->key] = array(
            $_value->key => $_value->value
        );
      }
    }

    if (!empty($preparedFilters)) {
      try {
        foreach ($preparedFilters as $field => $value) {
//                    if (isset($this->_mapAttributes[$field])) {
//                        $field = $this->_mapAttributes[$field];
//                    }
          $_collection->addFieldToFilter($field, $value);
        }
      } catch (Mage_Core_Exception $e) {
        $this->_fault('filters_invalid', $e->getMessage());
      }
    }
    $data = $_collection->toArray();
    return $data['items'];
  }

  function setimported($quote_id, $value) {
    $_quote = Mage::getModel('qquoteadv/qqadvcustomer')->load((int) $quote_id);

    if (!$_quote->getId()) {
      $this->_fault('quote_not_exists');
    }

    try {
      $_quote->setImported((bool) $value);
      $_quote->save();
    } catch (Exception $e) {
      $this->_fault('data_invalid', $e->getMessage());
    }

    return true;
  }

  /**
   * Delete requested qty
   *
   * @param array $params   
    int quote_id
    int request_id
   * @return array
   */
  function delete_requested_qty($quoteId, $requestId) {
    $response = array(
        'success' => false
    );

    if (!isset($requestId) or !isset($quoteId)) {
      $this->_fault('data_invalid', "RequestId or QuoteId parameters didn't not received");
    }

    $requestId = (int) $requestId;
    $quoteId = (int) $quoteId;

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
  function delete_requested_item($quoteId, $id) {
    $response = array(
        'success' => false
    );

    if (!isset($id) or !isset($quoteId)) {
      $this->_fault('data_invalid', "PrimaryKey or QuoteId didn't not received");
    }

    $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load((int) $id);

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

  function modify_requested_qty($request_id, $quote_id, $product_id, $request_qty, $owner_base_price, $original_price, $quoteadv_product_id) {
    $response = array(
        'success' => false
    );

    if (isset($request_id) &&
            isset($quote_id) &&
            isset($product_id) &&
            isset($request_qty) &&
            isset($owner_base_price) &&
            isset($original_price) &&
            isset($quoteadv_product_id)
    ) {

      $quote_id = (int) $quote_id;
      $key = (int) $quoteadv_product_id;

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

        $item = Mage::getModel('qquoteadv/requestitem')->load((int) $request_id);
        if (!$item->getRequestId()) {
          $this->_fault('data_invalid', 'Item not exists by RequestId');
        }

        // Update quote
        try {

          $item->setRequestQty($request_qty);
          $item->setOwnerBasePrice($owner_base_price);
          $item->setOriginalPrice($original_price);
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

  function set_item_comment($quoteadv_product_id, $comment) {
    $response = array(
        'success' => false
    );
    $exceptions = array();
    $limit = 400;

    if (!isset($quoteadv_product_id) && !isset($comment)) {
      $this->_fault('data_invalid', "Initial parameters didn't not received");
    }

    if (strlen($comment) > $limit) {
      $msg = sprintf("Quote comment length has limit %s characters", $limit);
      $this->_fault('data_invalid', $msg);
    }

    $_quoteadv = Mage::getModel('qquoteadv/qqadvproduct')->load((int) $quoteadv_product_id);
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
  
  function set_proposal_comment($quote_id, $comment) {
    $response = array(
        'success' => false
    );

    if (!isset($quote_id) or !isset($comment)) {
      $this->_fault('data_invalid', "QuoteId or Comment parameters didn't not received");
    }

    $quoteId = $quote_id;
    $comment = trim($comment);
    $len = strlen($comment);
    if ($len > $this->_limitComment) {
      $msg = sprintf("Comment length overlimit %s characters", $len - $this->_limitComment);
      $this->_fault('data_invalid', $msg);
    }

    $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load((int) $quoteId);
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
  
  function set_shipping($quote_id, $shipping_price, $shipping_type) {
    $response = array(
        'success' => false
    );
    if (!isset($quote_id) or !isset($shipping_type) or !isset($shipping_price)) {
      $this->_fault('data_invalid', "QuoteId or ShippingType or ShippingPrice parameters didn't not received");
    }
      $quoteId = (int) $quote_id;
      $type = (string) $shipping_type;
      $price = (float) $shipping_price;

      if (empty($type)) {
        $price = -1;
      } elseif (($type == "I" or $type == "O") && $price > 0) {
        //ok
      } else {
        $this->_fault('data_invalid');
      }

      $_quoteadv = Mage::getModel('qquoteadv/qqadvcustomer')->load($quoteId);
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
  
  function add_qtybyitem($quote_id, $product_id, $quoteadv_product_id, $request_qty, $owner_base_price, $original_price) {
    $response = array(
        'success' => false
    );
    
    if (isset($quote_id) && isset($product_id) && isset($quoteadv_product_id)
            && isset($request_qty) && isset($owner_base_price)
            && isset($original_price)
    ) {
      
      $key = $quoteadv_product_id;
      
      $_collection = Mage::getModel('qquoteadv/requestitem')->getCollection()
              ->addFieldToFilter('quote_id', (int)$quote_id)
              ->addFieldToFilter('product_id', (int)$product_id)
              ->addFieldToFilter('quoteadv_product_id', (int)$key);

      if ($_collection->getSize() > 0) {
        $requested = $_collection->toArray();

        $_collection->clear();
        $_collection->addFieldToFilter('request_qty', $request_qty);
        $data = $_collection->getData();

        if (count($data) > 0) {
          $this->_fault('dublicate_data', 'Duplicate qty value entered');
        }

        $params = array(
          'quote_id'            => $quote_id, 
          'product_id'          => $product_id,
          'quoteadv_product_id' => $quoteadv_product_id,  
          'request_qty'       => $request_qty,
          'owner_base_price'  => $owner_base_price,
          'original_price'    => $original_price,
        );
        
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
}