<?php
class Mirasvit_AsyncIndex_Model_Process extends Mage_Index_Model_Process {
    
    const STATUS_WAIT = 'wait';

    public function getStatusesOptions()
    {
        return array(
            self::STATUS_PENDING         => Mage::helper('index')->__('Ready'),
            self::STATUS_RUNNING         => Mage::helper('index')->__('Processing'),
            self::STATUS_REQUIRE_REINDEX => Mage::helper('index')->__('Reindex Required'),
            self::STATUS_WAIT            => Mage::helper('index')->__('Wait (in queue)'),
        );
    }
}