<?php

class Ophirah_Qquoteadv_Model_Status extends Varien_Object
{
    const STATUS_BEGIN              = 1;
    const STATUS_REQUEST            = 20;
    const STATUS_REQUEST_EXPIRED    = 21;
    const STATUS_REJECTED           = 30;
    const STATUS_CANCELED           = 40;

    const STATUS_PROPOSAL           = 50;
    const STATUS_PROPOSAL_EXPIRED   = 51;
    const STATUS_PROPOSAL_SAVED     = 52;
    const STATUS_AUTO_PROPOSAL      = 53;

    const STATUS_DENIED             = 60;
    const STATUS_CONFIRMED          = 70;
    const STATUS_ORDERED            = 71;

    static public function getOptionArray()
    {
        return array(

            self::STATUS_BEGIN      => Mage::helper('qquoteadv')->__('STATUS_BEGIN'),
            self::STATUS_REQUEST    => Mage::helper('qquoteadv')->__('STATUS_REQUEST'),
            self::STATUS_REQUEST_EXPIRED   => Mage::helper('qquoteadv')->__('STATUS_REQUEST_EXPIRED'),

            self::STATUS_PROPOSAL   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL'),
            self::STATUS_PROPOSAL_EXPIRED   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_EXPIRED'),
            self::STATUS_PROPOSAL_SAVED   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_SAVED'),
            self::STATUS_AUTO_PROPOSAL   => Mage::helper('qquoteadv')->__('STATUS_AUTO_PROPOSAL'),
           /* self::STATUS_REJECTED    => Mage::helper('qquoteadv')->__('STATUS_REJECTED'),*/
            self::STATUS_CANCELED   => Mage::helper('qquoteadv')->__('STATUS_CANCELED'),
            self::STATUS_DENIED     => Mage::helper('qquoteadv')->__('STATUS_DENIED'),
            self::STATUS_CONFIRMED  => Mage::helper('qquoteadv')->__('STATUS_CONFIRMED'),
            self::STATUS_ORDERED    => Mage::helper('qquoteadv')->__('STATUS_ORDERED'),
        );
    }

    static public function getGridOptionArray()
    {
        return array(
            self::STATUS_REQUEST    => Mage::helper('qquoteadv')->__('STATUS_REQUEST'),
            self::STATUS_REQUEST_EXPIRED   => Mage::helper('qquoteadv')->__('STATUS_REQUEST_EXPIRED'),
            self::STATUS_PROPOSAL   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL'),
            self::STATUS_PROPOSAL_EXPIRED   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_EXPIRED'),
            self::STATUS_PROPOSAL_SAVED   => Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_SAVED'),
            self::STATUS_AUTO_PROPOSAL   => Mage::helper('qquoteadv')->__('STATUS_AUTO_PROPOSAL'),
            self::STATUS_CANCELED   => Mage::helper('qquoteadv')->__('STATUS_CANCELED'),
            self::STATUS_DENIED     => Mage::helper('qquoteadv')->__('STATUS_DENIED'),
            self::STATUS_CONFIRMED  => Mage::helper('qquoteadv')->__('STATUS_CONFIRMED'),
            self::STATUS_ORDERED    => Mage::helper('qquoteadv')->__('STATUS_ORDERED'),
        );
    }

   static public function getChangeOptionArray() {
        return array(
            array('value' => self::STATUS_REQUEST,          'label'=> Mage::helper('qquoteadv')->__('STATUS_REQUEST')),
            array('value' => self::STATUS_REQUEST_EXPIRED,  'label'=>Mage::helper('qquoteadv')->__('STATUS_REQUEST_EXPIRED')),
            array('value' => self::STATUS_PROPOSAL,         'label'=>Mage::helper('qquoteadv')->__('STATUS_PROPOSAL')),
            array('value' => self::STATUS_PROPOSAL_EXPIRED, 'label'=>Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_EXPIRED')),
            array('value' => self::STATUS_PROPOSAL_SAVED,   'label'=>Mage::helper('qquoteadv')->__('STATUS_PROPOSAL_SAVED')),
//            array('value' => self::STATUS_AUTO_PROPOSAL,    'label'=>Mage::helper('qquoteadv')->__('STATUS_AUTO_PROPOSAL')),
            array('value' => self::STATUS_CANCELED,         'label'=>Mage::helper('qquoteadv')->__('STATUS_CANCELED')),
            array('value' => self::STATUS_DENIED,           'label'=>Mage::helper('qquoteadv')->__('STATUS_DENIED')),
            array('value' => self::STATUS_CONFIRMED,        'label'=>Mage::helper('qquoteadv')->__('STATUS_CONFIRMED')),
            array('value' => self::STATUS_ORDERED,          'label'=>Mage::helper('qquoteadv')->__('STATUS_ORDERED')),            
        );
    }
}