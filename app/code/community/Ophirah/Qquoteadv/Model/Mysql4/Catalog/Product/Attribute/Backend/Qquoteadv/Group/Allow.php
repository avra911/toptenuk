<?php

class Ophirah_Qquoteadv_Model_Mysql4_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Allow
    extends Ophirah_Qquoteadv_Model_Mysql4_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Abstract //Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('qquoteadv/product_attribute_group_allow', 'value_id');
    }

}
