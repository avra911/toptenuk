<?php

class WP_BackToTopButton_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_store = null;

    private static $_regexMatchCache        = array();
    private static $_disabledByRegexpCache  = array();

    public function isDisabled()
    {
        if (!Mage::getStoreConfigFlag('backtotopbutton/general/enabled')) return true;
        // --- to disable by regexp expression ---
        if ($this->isDisabledByUserAgentAgainstRegexps()) return true;
        return false;
    }

    public function isDisabledByUserAgentAgainstRegexps()
    {
        $regexpsConfigPath = 'backtotopbutton/general/disabled_by_regexp';

        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }

        if (!empty(self::$_disabledByRegexpCache[$regexpsConfigPath])) {
            return self::$_disabledByRegexpCache[$regexpsConfigPath];
        }

        $configValueSerialized = Mage::getStoreConfig($regexpsConfigPath, $this->getStore());

        if (!$configValueSerialized) {
            return false;
        }

        $regexps = @unserialize($configValueSerialized);

        if (empty($regexps)) {
            return false;
        }

        foreach ($regexps as $rule) {
            if (!empty(self::$_regexMatchCache[$rule['regexp']][$_SERVER['HTTP_USER_AGENT']])) {
                self::$_disabledByRegexpCache[$regexpsConfigPath] = true;
                return true;
            }

            $regexp = '/' . trim($rule['regexp'], '/') . '/';

            if (@preg_match($regexp, $_SERVER['HTTP_USER_AGENT'])) {
                self::$_regexMatchCache[$rule['regexp']][$_SERVER['HTTP_USER_AGENT']] = true;
                self::$_disabledByRegexpCache[$regexpsConfigPath] = true;
                return true;
            }
        }

        return false;
    }

    public function getStore()
    {
        if ($this->_store === null) {
            return Mage::app()->getStore();
        }
        return $this->_store;
    }
}
