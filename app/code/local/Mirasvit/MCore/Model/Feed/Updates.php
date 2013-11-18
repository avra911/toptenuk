<?php
/*******************************************
Mirasvit
This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
If you wish to customize this module for your needs
Please refer to http://mirasvit.com for more information.
@category Mirasvit
@copyright Copyright (C) 2012 Mirasvit (http://mirasvit.com), Vladimir Drok <dva@mirasvit.com.ua>, Alexander Drok<alexander@mirasvit.com.ua>
*******************************************/

class Mirasvit_MCore_Model_Feed_Updates extends Mirasvit_MCore_Model_Feed_Abstract
{
    public function check()
    {
        if (time() - Mage::app()->loadCache(Mirasvit_MCore_Helper_Config::UPDATES_FEED_URL) > 3 * 60 * 60) {
            $this->refresh();
        }
    }

    public function refresh()
    {
        $params = array();
        $params['domain'] = Mage::getBaseUrl();
        foreach (Mage::getConfig()->getNode('modules')->children() as $name => $module) {
            $params['modules'][$name] = (string) $module->version;
        }

        try {
            Mage::app()->saveCache(time(), Mirasvit_MCore_Helper_Config::UPDATES_FEED_URL);
            
            $xml = $this->getFeed(Mirasvit_MCore_Helper_Config::UPDATES_FEED_URL, $params);

            $items = array();
            if ($xml) {
                foreach ($xml->xpath('channel/item') as $item) {
                    $items[] = array(
                        'title'       => (string) $item->title,
                        'description' => (string) Mage::helper('core/string')->truncate(strip_tags($item->description), 255),
                        'url'         => (string) $item->link,
                        'date_added'  => (string) $this->getDate($item->pubDate),
                        'severity'    => 3,
                    );
                }
            }

            Mage::getModel('adminnotification/inbox')->parse($items);
        } catch (Exception $ex) { 
            Mage::logException($ex);
        }

        return $this;
    }
}