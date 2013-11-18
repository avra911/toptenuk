<?php
class Ophirah_Qquoteadv_Block_Toolbar extends Mage_Core_Block_Template
{
	public function _prepareLayout(){
       return parent::_prepareLayout();
    }
    
    public function isActiveQuote(){        
       $controllerName 	= Mage::app()->getRequest()->getControllerName();
       $actionName     	= Mage::app()->getRequest()->getActionName(); 
       $routeName = Mage::app()->getRequest()->getRouteName();
       if($routeName == 'qquoteadv' && $actionName == 'index' && $controllerName=='index'){
           return true;
       }      
       return false;
    }

    /**
     * Retrieve disable order references config.
     */
    public function getShowOrderReferences()
    {
        return (bool) (!Mage::getStoreConfig('qquoteadv/layout/layout_disable_all_order_references', $this->getStoreId()));
    }
	
	/**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }
		if (!Mage::getStoreConfig('qquoteadv/general/enabled')){
			return '';
		}
        $html = $this->renderView();
        return $html;
    }


}