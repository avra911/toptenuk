<?php

class Ophirah_Qquoteadv_Model_Configurable extends Mage_Catalog_Model_Product_Type_Configurable
{
    /**
     * Retrieve Selected Attributes info
     *
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getSelectedAttributesInfoId($product = null)
    {
        $attributes = array();
        Varien_Profiler::start('CONFIGURABLE:'.__METHOD__);
        if ($attributesOption = $this->getProduct($product)->getCustomOption('attributes')) {
            $data = unserialize($attributesOption->getValue());
            $this->getUsedProductAttributeIds($product);

            $usedAttributes = $this->getProduct($product)->getData($this->_usedAttributes);

            foreach ($data as $attributeId => $attributeValue) {
                if (isset($usedAttributes[$attributeId])) {
                    $attribute = $usedAttributes[$attributeId];
                    //$label = $attribute->getLabel();
					$label = $attribute->getAttributeId();
                    $value = $attribute->getProductAttribute();
                    if ($value->getSourceModel()) {
                        //$value = $value->getSource()->getOptionText($attributeValue);
						$value = $value->getSource()->getOptionId($attributeValue);
                    }
                    else {
                        $value = '';
                    }

                    //$attributes[] = array('label'=>$label, 'value'=>$value);
					$attributes[$label] = $value;
                }
            }
        }
        Varien_Profiler::stop('CONFIGURABLE:'.__METHOD__);
        return $attributes;
    }

	/**
     * Retrieve Selected Attributes info
     *
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getSelectedAttributesInfoText($product,$attribute)
    {
        $attributeText = array();
		if(!is_array($attribute)){
			// changing string to array
			$attribute = unserialize($attribute);
		}
        $attributeArray = $this->getConfigurableAttributesAsArray($product);
		foreach($attributeArray as $key=>$value) {
			if(isset($attribute['super_attribute']))
		    foreach($attribute['super_attribute'] as $k=>$v) {
				if($k == $value['attribute_id']) {
					$attributeText[$key]['label'] = $value['label'];
				}
				foreach($value['values'] as $kv=>$vv) {
					if($v == $vv['value_index']) {
						$attributeText[$key]['value'] = $vv['label'];
					}
				}
			}
		}
		return $attributeText;
    }

}