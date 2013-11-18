<?php

class Ophirah_Qquoteadv_Model_Mysql4_Qqadvcustomer extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the quote_id refers to the key field in your database table.
        $this->_init('qquoteadv/qqadvcustomer', 'quote_id');
    }
}