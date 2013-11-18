<?php

class Ophirah_Qquoteadv_Model_System_Config_Source_Adminrole
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        /** @var $roleCollection Mage_Admin_Model_Resource_Role_Collection */
        $roleCollection = Mage::getModel('admin/role')->getCollection();
        $roleCollection->addFilter('role_type', 'G')
            ->setOrder('role_name', Varien_Data_Collection::SORT_ORDER_ASC);

        $options = array();
        /** @var $role Mage_Admin_Model_Role */
        foreach($roleCollection as $role)
        {
            $options[] = array('value' => $role->getId(), 'label' => $role->getRoleName());
        }
        return $options;
    }
}
