<?php

class Ophirah_Qquoteadv_Model_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Allow
    extends Ophirah_Qquoteadv_Model_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Abstract //Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Retrieve resource instance
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Attribute_Backend_Tierprice
     */
    protected function _getResource()
    {
        return Mage::getResourceSingleton('qquoteadv/catalog_product_attribute_backend_qquoteadv_group_allow');
    }
}
