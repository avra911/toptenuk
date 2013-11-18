<?php

class Ophirah_Qquoteadv_Model_System_Config_Source_Autoassigntype
{
    const TYPE_NONE = 'none';
    const TYPE_ROTATION = 'rotation';
    const TYPE_ADMIN_LOGIN = 'admin_login';
    const TYPE_BOTH = 'both';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::TYPE_NONE, 'label'=>Mage::helper('adminhtml')->__('None')),
            array('value' => self::TYPE_ROTATION, 'label'=>Mage::helper('adminhtml')->__('Rotate admin role')),
            array('value' => self::TYPE_ADMIN_LOGIN, 'label'=>Mage::helper('adminhtml')->__('Logged in admin user')),
            array('value' => self::TYPE_BOTH, 'label'=>Mage::helper('adminhtml')->__('Logged in admin user with rotate fallback')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            self::TYPE_NONE => Mage::helper('adminhtml')->__('None'),
            self::TYPE_ROTATION => Mage::helper('adminhtml')->__('Rotation'),
            self::TYPE_ADMIN_LOGIN => Mage::helper('adminhtml')->__('Logged in admin user'),
            self::TYPE_BOTH => Mage::helper('adminhtml')->__('Logged in admin user with rotation fallback'),
        );
    }
}
