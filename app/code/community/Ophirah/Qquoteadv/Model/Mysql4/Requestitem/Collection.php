<?php

class Ophirah_Qquoteadv_Model_Mysql4_Requestitem_Collection extends Mage_Sales_Model_Resource_Quote_Item_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/requestitem');
    }
    
   protected function _assignOptions()
    {
        foreach ($this as $item) {
            $item->setOptions(array());
        }
         return $this;
        
    }
    
    protected function _afterLoad(){
        
    }
}