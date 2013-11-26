<?php
class GoIvvy_DeferJS_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function regexMatchSimple($regex, $matchTerm) {
		
		if (!$regex)
			return false;

        	$rules = @unserialize($regex);

        	if (empty($rules))
        	    return false;

	        foreach ($rules as $rule) {

	            $regexp = '#' . trim($rule['regexp'], '#') . '#';
	            if (@preg_match($regexp, $matchTerm))
	                return true;

	        }

		return false;

	}

        public function isEnabled()
        {
             $module = Mage::app()->getFrontController()->getRequest()->getModuleName();
             $controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
             $action = Mage::app()->getFrontController()->getRequest()->getActionName();

            if(Mage::app()->getStore()->isAdmin() || 
               !Mage::getStoreConfig('deferjs/general/active') || 
               Mage::helper('goivvy_deferjs')->regexMatchSimple(Mage::getStoreConfig('deferjs/general/deferjs_exclude_controllers'),"{$module}_{$controller}_{$action}") ||
               Mage::helper('goivvy_deferjs')->regexMatchSimple(Mage::getStoreConfig('deferjs/general/deferjs_exclude_path'),Mage::app()->getRequest()->getRequestUri()))
               return false;
            return true;
        }

}
