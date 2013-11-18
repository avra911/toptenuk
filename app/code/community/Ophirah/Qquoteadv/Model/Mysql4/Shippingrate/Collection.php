<?php

class Ophirah_Qquoteadv_Model_Mysql4_Shippingrate_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
        /**
     * Whether to load fixed items only
     *
     * @var bool
     */
    protected $_allowFixedOnly   = false;
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/shippingrate');
    }
    
    /**
     * Set filter by address id
     *
     * @param int $addressId
     * @return Mage_Sales_Model_Resource_Quote_Address_Rate_Collection
     */
    public function setAddressFilter($addressId)
    {
        if ($addressId) {
            $this->addFieldToFilter('address_id', $addressId);
        } else {
            $this->_totalRecords = 0;
            $this->_setIsLoaded(true);
        }
        return $this;
    }

    /**
     * Setter for loading fixed items only
     *
     * @param bool $value
     * @return Mage_Sales_Model_Resource_Quote_Address_Rate_Collection
     */
    public function setFixedOnlyFilter($value)
    {
        $this->_allowFixedOnly = (bool)$value;
        return $this;
    }

    /**
     * Don't add item to the collection if only fixed are allowed and its carrier is not fixed
     *
     * @param Mage_Sales_Model_Quote_Address_Rate $rate
     * @return Mage_Sales_Model_Resource_Quote_Address_Rate_Collection
     */
    public function addItem(Varien_Object $rate)
    {
        if ($this->_allowFixedOnly && (!$rate->getCarrierInstance() || !$rate->getCarrierInstance()->isFixed())) {
            return $this;
        }
        return parent::addItem($rate);
    }

}