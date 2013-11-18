<?php
class Ophirah_Qquoteadv_Model_System_Config_Source_Email_Identity extends Mage_Adminhtml_Model_System_Config_Source_Email_Identity
{
    public function toOptionArray()
    {
        $result = parent::toOptionArray();
        $result[] = array(
            'value' => 'qquoteadv_sales_representive',
            'label' => 'Assigned sales representative'
        );
        return $result;
    }
}