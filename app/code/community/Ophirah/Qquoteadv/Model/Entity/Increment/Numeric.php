<?php

class Ophirah_Qquoteadv_Model_Entity_Increment_Numeric extends Mage_Eav_Model_Entity_Increment_Numeric {
    
    CONST PARAM_START_NUMBER    = 'qquoteadv/number_format/startnumber';
    CONST PARAM_PREFIX          = 'qquoteadv/number_format/prefix';
    CONST PARAM_INCREMENT       = 'qquoteadv/number_format/increment';
    CONST PARAM_PAD_LENGTH      = 'qquoteadv/number_format/pad_length';

    CONST QUOTE_TYPE_ID = 888;

    public function __construct() {
        parent::__construct();

        $aEntityTypes = array( self::QUOTE_TYPE_ID => 'qquoteadv');
        $this->setData('entity_types', $aEntityTypes);
    }

    protected function _generateNextId() {
        $aEntityTypes = $this->getData('entity_types');
        $entTypeId = self::QUOTE_TYPE_ID;
        
        if (isset($aEntityTypes[$entTypeId])) {
            $entityType = $aEntityTypes[$entTypeId];
                       
            $rowStartNumber     = $this->getConfigId(self::PARAM_START_NUMBER);
            $rowPrefix          = $this->getConfigId(self::PARAM_PREFIX);
            $rowIncrement       = $this->getConfigId(self::PARAM_INCREMENT);
            $rowPadLenght       = $this->getConfigId(self::PARAM_PAD_LENGTH);

            $this->setData(
                    array(
                        'pad_length'    => $rowPadLenght['value'],
                        'increment'     => $rowIncrement['value'],
                        'startnumber'   => $rowStartNumber['value'],
                        'prefix'        => $rowPrefix['value']
                ));

            $configId   =  $rowStartNumber['config_id'];
            $nextNum    =  $rowStartNumber['value'] + $rowIncrement['value'];

            //#update core_config_data table with new quote numeration value
            if($nextNum && $configId){
                $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                $table = Mage::getSingleton('core/resource')->getTableName('core/config_data');
                $sql = "UPDATE $table SET value=$nextNum WHERE config_id=$configId";
                $write->query($sql);
            }
            return $this->format($nextNum);

        } else {
            return parent::getNextId();
        }
    }

    protected function getConfigId($configParam){
        $configCollection = Mage::getModel('core/config_data')->getCollection();
        $configCollection->getSelect()->where('path LIKE ?', $configParam);
        $configCollection->load();

        foreach($configCollection as $item)
             return   $data = $item->getData();        
    }

    public function getNextId() {
        if(Mage::helper('qquoteadv')->getTotalQty() > 0){
            return $this->_generateNextId();
        }else{
            $last = $this->getLastId();

            if (strpos($last, $this->getPrefix()) === 0) {
                $last = (int)substr($last, strlen($this->getPrefix()));
            } else {
                $last = (int)$last;
            }

            $next = $last + 1;

            return $this->format($next);
        }
    }

    public function getPadLength() {
        $padLength = $this->getData('pad_length');
        if (empty($padLength)) {
            $padLength = 0;
        }
        return $padLength;
    }

    public function format($id) {
        $result = $this->getPrefix();
        $result.= str_pad((string) $id, $this->getPadLength(), $this->getPadChar(), STR_PAD_LEFT);
        return $result;
    }

}