<?php
class Ophirah_Qquoteadv_Block_Item_Configure extends Mage_Core_Block_Template
{

    /**
     * Configure product view blocks
     *
     * @return Mage_Checkout_Block_Cart_Item_Configure
     */
    protected function _prepareLayout()
    {
        // Set custom submit url route for form - to submit updated options to cart
        $block = $this->getLayout()->getBlock('product.info');
        if ($block) {
             $block->setSubmitRouteData(array(
                'route' => 'qquoteadv/index/updateItemOptions',
                'params' => array('id' => $this->getRequest()->getParam('id'))
             ));
        }

        // Set custom template with 'Update Cart' button
        $block = $this->getLayout()->getBlock('product.info.addtocart');
        if ($block) {
            $block->setTemplate('qquoteadv/item/configure/updatequote.phtml');
        }

        return parent::_prepareLayout();
    }
}
