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
require_once 'Mage/Index/controllers/Adminhtml/ProcessController.php';
class Mirasvit_AsyncIndex_Adminhtml_ProcessController extends Mage_Index_Adminhtml_ProcessController
{
    public function reindexProcessAction()
    {
        if (!Mage::getStoreConfig('asyncindex/general/full_reindex')) {
            return parent::reindexProcessAction();
        }

        $process = $this->_initProcess();
        $process->changeStatus(Mirasvit_AsyncIndex_Model_Process::STATUS_WAIT);
        $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__('Index %s added to queue', $process->getIndexer()->getName()));

        $this->_redirect('*/*/list');
    }

    public function massReindexAction()
    {
        if (!Mage::getStoreConfig('asyncindex/general/full_reindex')) {
            return parent::reindexProcessAction();
        }

        $indexer    = Mage::getSingleton('index/indexer');
        $processIds = $this->getRequest()->getParam('process');
        if (empty($processIds) || !is_array($processIds)) {
            $this->_getSession()->addError(Mage::helper('index')->__('Please select Indexes'));
        } else {
            try {
                foreach ($processIds as $processId) {
                    /* @var $process Mage_Index_Model_Process */
                    $process = $indexer->getProcessById($processId);
                    if ($process) {
                        $process->changeStatus(Mirasvit_AsyncIndex_Model_Process::STATUS_WAIT);
                    }
                }
                $count = count($processIds);
                $this->_getSession()->addSuccess(
                    Mage::helper('index')->__('Total of %d index(es) have added to queue.', $count)
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('index')->__('Cannot initialize the indexer process.'));
            }
        }

        $this->_redirect('*/*/list');
    }
}