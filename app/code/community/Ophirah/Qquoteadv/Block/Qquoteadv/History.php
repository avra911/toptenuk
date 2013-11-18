<?php

class Ophirah_Qquoteadv_Block_Qquoteadv_History extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('qquoteadv/qquoteadv/history.phtml');

        $quotes = $quote =Mage::getResourceModel('qquoteadv/qqadvcustomer_collection')
        	->addFieldToFilter('customer_id',Mage::getSingleton('customer/session')->getId())
    		->addFieldToFilter('is_quote',1)
    		->addFieldToFilter('status',array('gt' =>Ophirah_Qquoteadv_Model_Status::STATUS_BEGIN))
        	->setOrder('created_at', 'desc') //('quote_id','desc')
        ;

        $this->setQquotesadv($quotes);

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('qquoteadv')->__('My Quotes'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'qquoteadv.history.pager')
            ->setCollection($this->getQquotesadv());
        $this->setChild('pager', $pager);
        $this->getQquotesadv()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getViewUrl($qquote)
    {
    	return $this->getUrl('*/view/view', array('id' => $qquote->getId()));
        //return $this->getUrl('*/proposal/view', array('id' => $qquote->getId()));
    }

    public function getTrackUrl($qquote)
    {
        return $this->getUrl('*/*/track', array('order_id' => $qquote->getId()));
    }

    public function getReorderUrl($qquote)
    {
        return $this->getUrl('*/*/reorder', array('order_id' => $qquote->getId()));
    }

    public function getBackUrl()
    {
        return $this->getUrl('customer/account/');
    }

    public function getStatusLabel($id){
    	return Mage::helper("qquoteadv")->getStatus($id);
    }
}