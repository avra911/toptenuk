<?php

/**
 * Block Wrapper for hole punching
 *
 * @category   Ezapps
 * @package    Ezapps_Zoom
 * @author     Ezra Morse (http://www.ezapps.ca)
 * @license:   EPL 1.0
 */

class Ezapps_Zoom_Block_Wrapper_Currency extends Mage_Directory_Block_Currency
{
    /**
     * Initialize object
     *
     * @return void
     */

    private $_key = 'currency';
    private $_cache_tag = true;

    public function __construct()
    {
        $this->setHtmlId($this->_key);
       	parent::__construct();
    }

    public function _afterToHtml($html)
    {
	if ($this->getCacheTag() && ((trim($html) != "" && Mage::helper('ezzoom')->punchStatus($this->_key) == 1) || Mage::helper('ezzoom')->punchStatus($this->_key) == 2)) {
                $name = (Mage::helper('ezzoom')->getConfigData('zoom_lite') ? $this->getTemplate() : $this->getNameInLayout());
                return Mage::helper('ezzoom')->renderHoleStart($this->_key, $name) . parent::_afterToHtml($html) . Mage::helper('ezzoom')->renderHoleEnd($this->_key, $name);
        }
	else
		return parent::_afterToHtml($html);
    }

    public function setCacheTag($status) {
	
	$this->_cache_tag = $status;	
	return $this;

    }

    public function getCacheTag() {
	
	return $this->_cache_tag;	

    }

    public function getCurrentCurrencyCode()
    {
	if (Mage::helper('ezzoom')->punchStatus($this->_key) > 0) {
        	if (!is_null(Mage::getSingleton('customer/session')->getMaskedCurrency())) {
            		$this->setData('current_currency_code', Mage::getSingleton('customer/session')->getMaskedCurrency());
        	}
	}

        return parent::getCurrentCurrencyCode();
    }

}
