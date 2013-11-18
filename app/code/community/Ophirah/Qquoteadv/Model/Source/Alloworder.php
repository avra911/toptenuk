<?php
class Ophirah_Qquoteadv_Model_Source_Alloworder extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        $options = array(
                array(
                        'value' => '1',
                        'label' => 'Yes'
                ),
                array(
                        'value' => '0',
                        'label' => 'No'
                )						
        );
      	return $options;
    }
    
    public function getOptionText($value)
    {
		$options = $this->getAllOptions();
        foreach ($options as $option) {
        	if(is_array($value)){
        	if (in_array($option['value'],$value)) {
                return $option['label'];
            }
           }
            else{
	            if ($option['value']==$value) {
	                return $option['label'];
	            }
            }	
            
        }
        return false;
    }
}

?>