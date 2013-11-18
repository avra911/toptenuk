<?php

class Ophirah_Qquoteadv_Model_Mysql4_Qqadvcustomer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/qqadvcustomer');
    }
	
	public function order($id,$dir){
		$this->_select->order($id,$dir);
		return $this;	
	}
	
	public function joinTable()
	{
		// _join($type, $name, $cond, $cols, $schema = null)
		//$this->_select->where("main_table.handling_id = ?", $handlingID);
		$this->_select->joinLeft('qquote_product','main_table.quote_id = qquote_product.quote_id');
		return $this;	
	}
}