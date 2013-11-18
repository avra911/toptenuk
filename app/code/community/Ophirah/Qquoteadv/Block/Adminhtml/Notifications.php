<?php
class Ophirah_Qquoteadv_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template{

   protected function _toHtml(){
     $controllerName  = Mage::app()->getRequest()->getControllerName();
     $params          = Mage::app()->getRequest()->getParams();
     
     if( !(isset($params['section']) &&  $params['section'] == 'qquoteadv' && 'system_config' == $controllerName) )
       return '';

     if(Mage::helper('qquoteadv')->isEnabled() && !Mage::getStoreConfig('qquoteadv/layout/active_c2q_tmpl') )
        return parent::_toHtml();
     else
        return '';
   }
}