<?php

class Ophirah_Qquoteadv_Model_Bundle extends Mage_Bundle_Model_Product_Type
{	
	/**
	 * Get bundled selections (slections-products collection)
	 *
	 * Returns array of options objects.
	 * Each option object will contain array of selections objects
	 *
	 * @return array
	 */
    public function getBundleOptions2($selections, $product)
    {
        $options = $this->getOptions($product);
		$selects = $this->getSelectionsByIds($selections,$product)->getItems();
		foreach($options as $key => $item) {
                    
			$arr[$key]['label'] = $item->getDefaultTitle();
			$arr[$key]['value'] = $this->getSelectionsCollection($item->getOptionId(),$product)->getItems();
		}		
		return $selects;       
		return $arr;
    }
	
	/**
	 * Get bundled selections (slections-products collection)
	 *
	 * Returns array of options objects.
	 * Each option object will contain array of selections objects
	 *
	 * @return array
	 */
	public function getBundleOptionsText($option, $selection, $product)
    {
        $optionText = $this->getOptionsByIds(array($option), $product)->getItems();		
		
		if(!is_array($selection)) {
			$selection = array($selection);
		}
		$selectText = $this->getSelectionsByIds($selection,$product)->getItems();
		
		$optionSelection = array(								
                        'selection' => $selectText,
                        'option' => $optionText
                        );
		
		return $optionSelection;
    } 
	
	/**
	 * Get bundled selections (slections-products collection)
	 *
	 * Returns array of options objects.
	 * Each option object will contain array of selections objects
	 *
	 * @return array
	 */
	public function getBundleOptionsSelection($product,$attribute)
    {

        if(!is_array($attribute)){
            // changing string to array
            $attribute = unserialize($attribute);
        }
		
        $optionsQtyKey = $optionsQty = null;
        
        // getting the values for bundle_options
		// bundle_options key on $params contain key => value pairs of options and values
		// getting only the values using array_values function
		$options = $attribute['bundle_option'];            
		
		
        if(isset($attribute['bundle_option_qty'])) {
            // bundle options quantity
            $optionsQty = $attribute['bundle_option_qty'];
            // fetching keys from the array
            $optionsQtyKey = array_keys($optionsQty);
        }
		
		// making bundle options values array
		$data = array();
		$selectionData = array();

                
		foreach($options as $key => $value) {                    
                    //$bundleOptions = Mage::getModel('qquoteadv/bundle')->getBundleOptions($key, $value, $product);
                    $bundleOptions = $this->getBundleOptionsText($key, $value, $product);                      
                    
                    foreach($bundleOptions as $key => $value) {
                        if($key == 'selection' && $value !== NULL ) {

                            if($value != NULL) { // If NONE is an option
                                foreach($value as $itemKey => $item) {

                                    $selectionData = array(
                                                        'id' => $item->getId(),
                                                        'title' => $item->getName(),
                                                        'price' => $item->getPrice(), //Mage::helper('checkout')->formatPrice((int)$item->getPrice()),
                                                        'qty' => ($item->getSelection_qty() > 1)? $item->getSelection_qty() : 1,
                                                );
                                }
                                
                            }else{
                                    $selectionData = array(
                                                        'id' => "",
                                                        'title' => "",
                                                        'price' => "",
                                                        'qty' => 0,
                                                );                                
                            }
                        }

                        if($key == 'option') {						
                            foreach($value as $itemKey => $item) {
                                // updating quantity in the selectionData array
                                if(is_array($optionsQtyKey) && in_array($item->getOptionId(),$optionsQtyKey)) {
                                        $selectionData['qty'] = $optionsQty[$item->getOptionId()];
                                }

                                $data[$item->getOptionId()] = array(
                                            'option_id' => $item->getOptionId(),
                                            'label' => $item->getTitle(),
                                            'value' => array($selectionData)																
                                            );

                            }
                        }
                    }
		}

		return $data;
    }

    
}
