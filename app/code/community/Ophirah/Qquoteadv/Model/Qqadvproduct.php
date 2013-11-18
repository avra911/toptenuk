<?php

class Ophirah_Qquoteadv_Model_Qqadvproduct extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/qqadvproduct');
    }

	/**
	 * Delete product from quote
	 * @param integer $id id
	 */
	public function deleteQuote($id)
	{
		$this->setId($id)
		      ->delete()
		      ;
		return $this;
	}

	/**
	 * Get product for the particular quote
	 * @param integer $quoteId
	 * @return object product information
	 */
	public function getQuoteProduct($quoteId)
	{
		return $this->getCollection()
		            ->addFieldToFilter('quote_id',$quoteId)
		            ;
	}
        
        /**
         *  For configurable products,
         *  get configured simple product
         *  @param integer $productQuoteId
         *  @return childproductId
         */ 
        public function getConfChildProduct($productQuoteId){
            $quote_prod = unserialize(Mage::getModel('qquoteadv/qqadvproduct')
                                        ->load($productQuoteId)
                                        ->getData('attribute')
                                     );           
            
            $product = Mage::getModel('catalog/product')->load($quote_prod['product']);
            $childProduct = Mage::getModel('catalog/product_type_configurable')
                            ->getProductByAttributes($quote_prod['super_attribute'], $product);
            
            return Mage::getModel('catalog/product')->load($childProduct->getId());
        }

	/**
	 * Add product for the particular quote to qquote_product table
	 * @param array $params product information to be added
	 *
	 */
	public function addProduct($params)
	{
	
		$checkQty =  $this->checkQuantities($params['product_id'], $params['qty']);
		if($checkQty->getHasError()){
                    return $checkQty;
		}
	
		$this->setData($params)
		      ->save()
		      ;
              
		return $this;
	}

	/**
	 * Update product if the product is already added to the table by the customer for the particular session
	 * @param integer $id row id to be updated
	 * @param array $params array of field(s) to be updated
	 */
	public function updateProduct($id,$params)
	{
		$pid = $this->load($id)->getData('product_id');
		
		$checkQty =  $this->checkQuantities($pid, $params['qty']);
		if($checkQty->getHasError()){
				return $checkQty;
		}
	
		
		$this->addData($params)
		->setId($id)
		->save()
		;

		return $this;
	}


	public function addNotes($params){
	    foreach($params as $key=>$arr){
	        $item =  Mage::getModel('qquoteadv/qqadvproduct')->load($arr['id']);
            try{
                $item->setClientRequest($arr['client_request'])->save();   
            }catch(Exception $e){
                
            }
	   }
	    return $this;
	}

	public function getIdsByQuoteId($quoteId){
	   $ids = array();
	   $collection =  Mage::getModel('qquoteadv/qqadvproduct')->getCollection()
	                               ->addFieldToFilter('quote_id',$quoteId);

	   foreach($collection as $item){
	       $ids[] = $item->getId();
	   }

	    return $ids;
	}

	public function checkQuantities($id, $qty){
            return Mage::helper('qquoteadv')->checkQuantities($id, $qty);
	}


	public function checkQtyIncrements($id, $qty){
            return Mage::helper('qquoteadv')->checkQtyIncrements($id, $qty);
	}
        
}
