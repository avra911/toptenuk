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

class Mirasvit_AsyncIndex_Adminhtml_AsyncIndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Process the queue
     * @return void
     */
    public function processAction()
    {

        $handler = Mage::getModel('asyncindex/handler');
        $handler->processQueue();
        $handler->checkProductChanges();

        $this->_redirect('*/process/list');
    }

}