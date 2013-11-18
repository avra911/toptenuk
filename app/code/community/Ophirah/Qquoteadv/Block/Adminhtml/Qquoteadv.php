<?php
class Ophirah_Qquoteadv_Block_Adminhtml_Qquoteadv extends Mage_Adminhtml_Block_Widget_Grid_Container
{
 
    public function __construct()
    {
        $this->_controller = 'adminhtml_qquoteadv';
        $this->_blockGroup = 'qquoteadv';
        $this->_headerText = Mage::helper('qquoteadv')->__('Quotations');
        $this->_addButtonLabel = Mage::helper('sales')->__('Create New Quote');
        parent::__construct();
        
        // Removing top button
        // Button is added to the grid view.
        $this->_removeButton('add');
        
    }
    
    public function getCreateUrl()
    { 
        return $this->getUrl('adminhtml/sales_order_create/start');
    }
}
