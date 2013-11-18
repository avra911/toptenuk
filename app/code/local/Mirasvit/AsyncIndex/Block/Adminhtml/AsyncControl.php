<?php
/*******************************************
Mirasvit
This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
If you wish to customize this module for your needs
Please refer to http://www.magentocommerce.com for more information.
@category Mirasvit
@copyright Copyright (C) 2012 Mirasvit (http://mirasvit.com.ua), Vladimir Drok <dva@mirasvit.com.ua>, Alexander Drok<alexander@mirasvit.com.ua>
*******************************************/

class Mirasvit_AsyncIndex_Block_Adminhtml_AsyncControl extends Mage_Adminhtml_Block_Template
{

    /**
     * Get collection of async objects
     *
     * @return
     */
    public function getAsyncCollection()
    {
        $this->getSavedTime();
        $result = array();
        $processes = Mage::getSingleton('index/indexer')->getProcessesCollection();

        foreach ($processes as $process) {
            if ($process->getUnprocessedEventsCollection()->count() > 0) {
                foreach ($process->getUnprocessedEventsCollection() as $event) {
                    $item = new Varien_Object();
                    $item->setName($process->getIndexer()->getName());
                    $item->setCode($process->getIndexerCode());
                    $item->setType($event->getType());
                    $item->setEntity($event->getEntity());
                    $item->setEntityPk($event->getEntityPk());

                    $result[] = $item;
                }
            }
                
        }

        return $result;
    }

    public function getSavedTime()
    {
        $variable = Mage::getModel('core/variable');
        $variable = $variable->loadByCode('asyncindex_time');
        $seconds = intval($variable->getPlainValue());

        $time = new Zend_Date();
        $time->setTime('00:00:00');
        $time->addSecond($seconds);
        return $time->toString('HH').' hours '.$time->toString('mm').' minutes';
    }

    function timeSince($time, $from = null)
    {
        $time = $$time;
 
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
            array(1 , 'second')
        );
 
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($time / $seconds)) != 0) {
                break;
            }
        }
 
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }
}