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

class Mirasvit_AsyncIndex_Model_Handler
{
    public function processQueue()
    {
        if (!Mage::getStoreConfig('asyncindex/general/change_reindex')) {
            return $this;
        }

        $processes = Mage::getSingleton('index/indexer')->getProcessesCollection();

        foreach ($processes as $process) {
            if ($process->getUnprocessedEventsCollection()->count() > 0) {
                $ts = microtime(true);

                $process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME);
                $process->setStatus('pending');
                $process->reindexAll();
                
                $tf = round(microtime(true) - $ts, 4);
                
                $this->_addTime($tf);

                Mage::log('Updated index: '.$process->getIndexer()->getName().' time: '.$tf, null, 'asyncindex.log');
            }
        }

        return $this;
    }

    public function processReindex()
    {
        if (!Mage::getStoreConfig('asyncindex/general/full_reindex')) {
            return $this;
        }

        $collection = Mage::getModel('index/process')->getCollection()
            ->addFieldToFilter('status', Mirasvit_AsyncIndex_Model_Process::STATUS_WAIT);

        foreach ($collection as $process) {
            $process = $process->load($process->getId());
            if ($process->getStatus() == Mirasvit_AsyncIndex_Model_Process::STATUS_WAIT
                && !$process->isLocked()) {
                $ts = microtime(true);
                Mage::log($process->getIndexer()->getName().' index was started rebuilt.', null, 'asyncindex.log');

                $process->reindexEverything();

                Mage::log($process->getIndexer()->getName().' index was rebuilt.', null, 'asyncindex.log');
                $tf = round(microtime(true) - $ts, 4);
                $this->_addTime($tf);
            }
        }
    }

    public function checkProductChanges()
    {
        if (!Mage::getStoreConfig('asyncindex/general/validate_index')) {
            return $this;
        }
        
        $resource = Mage::getSingleton('core/resource');
        $adapter  = $resource->getConnection('core_write');

        $status = $this->getAttribute('status');

        $storeId   = 1;
        $websiteId = (int)Mage::app()->getStore($storeId)->getWebsite()->getId();
        $flatTable = sprintf('%s_%s', $resource->getTableName('catalog/product_flat'), $storeId);;
        $bind      = array(
            'website_id'     => $websiteId,
            'store_id'       => $storeId,
            'entity_type_id' => (int)$status->getEntityTypeId(),
            'attribute_id'   => (int)$status->getId()
        );

        $fieldExpr = $adapter->getCheckSql('t2.value_id > 0', 't2.value', 't1.value');
        $select = $adapter->select()
            ->from(array('e' => $resource->getTableName('catalog/product')), array('entity_id'))
            ->join(
                array('wp' => $resource->getTableName('catalog/product_website')),
                'e.entity_id = wp.product_id AND wp.website_id = :website_id',
                array())
            ->joinLeft(
                array('t1' => $status->getBackend()->getTable()),
                'e.entity_id = t1.entity_id',
                array())
            ->joinLeft(
                array('t2' => $status->getBackend()->getTable()),
                't2.entity_id = t1.entity_id'
                    .' AND t1.entity_type_id = t2.entity_type_id'
                    .' AND t1.attribute_id = t2.attribute_id'
                    .' AND t2.store_id = :store_id',
                array())
            ->joinLeft(
                array('flat' => $flatTable), 
                'e.entity_id = flat.entity_id',
                array())
            ->where('flat.updated_at <> e.updated_at OR flat.updated_at IS NULL')
            ->where('t1.entity_type_id = :entity_type_id')
            ->where('t1.attribute_id = :attribute_id')
            ->where('t1.store_id = ?', Mage_Core_Model_App::ADMIN_STORE_ID)
            ->where("{$fieldExpr} = ?", Mage_Catalog_Model_Product_Status::STATUS_ENABLED);

        $result = $adapter->fetchAll($select, $bind);

        foreach ($result as $row) {
            $entityId = $row['entity_id'];
            // Mage::log('Updated product: '.$entityId, null, 'asyncindex.log');
            $product = Mage::getModel('catalog/product')->load($entityId);
            Mage::getSingleton('index/indexer')->logEvent(
                $product, Mage_Catalog_Model_Product::ENTITY, Mage_Index_Model_Event::TYPE_SAVE
            );
        }
    }

    protected function getAttribute($attributeCode)
    {
        $attribute = Mage::getModel('catalog/resource_eav_attribute')
            ->loadByCode(Mage::getResourceModel('catalog/config')->getEntityTypeId(), $attributeCode);
        if (!$attribute->getId()) {
            Mage::throwException(Mage::helper('catalog')->__('Invalid attribute %s', $attributeCode));
        }
        $entity = Mage::getSingleton('eav/config')
            ->getEntityType(Mage_Catalog_Model_Product::ENTITY)
            ->getEntity();
        $attribute->setEntity($entity);

        return $attribute;
    }

    private function _addTime($seconds)
    {
        $variable = Mage::getModel('core/variable');
        $variable = $variable->loadByCode('asyncindex_time');
        if (!$variable->getId()) {
            $variable->setCode('asyncindex_time')
                ->setName('Fast Asynchronous Re-indexing saved time');
        }
        $variable->setPlainValue(floatval($variable->getPlainValue()) + floatval($seconds))
            ->save();

        return $this;
    }
}