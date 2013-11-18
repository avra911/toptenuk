<?php
class Ophirah_Qquoteadv_Block_Item_Renderer_Bundle extends Mage_Bundle_Block_Checkout_Cart_Item_Renderer
{
    protected $_item;

    /**
     * Set item for render
     *
     * @param   Mage_Sales_Model_Quote_Item $item
     * @return  Mage_Checkout_Block_Cart_Item_Renderer
     */
    public function setItem(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $this->_item = $item;
        return $this;
    }

    /**
     * Get quote item
     *
     * @return Mage_Sales_Model_Quote_Item
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     * Get item product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->getItem()->getProduct();
    }
}
?>