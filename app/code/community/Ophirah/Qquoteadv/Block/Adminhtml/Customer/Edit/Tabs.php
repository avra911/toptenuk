<?php

/**
 * Customer edit block Extending core class Mage_Adminhtml_Block_Customer_Edit_Tabs
 * 
 * Create Quote Tab in menu left
 *
 * @category   C2Quote
 * @package    Ophirah_Qquoteadv
 * @author     Cart2Quote
 */

class Ophirah_Qquoteadv_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs
{

    protected function _beforeToHtml()
    {

        if (Mage::registry('current_customer')->getId()) {
            if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
                $this->addTab('Qquoteadv', array(
                    'label'     => Mage::helper('customer')->__('Quotations'),
                    'class'     => 'ajax',
                    'url'       => $this->getUrl('quoteadv/adminhtml_qquoteadv/quotes', array('_current' => true)),
                    ));              
            }
        }

        $this->_updateActiveTab();
        Varien_Profiler::stop('customer/tabs');
        return parent::_beforeToHtml();
    }

}
