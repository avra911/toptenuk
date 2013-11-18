<?php

class Ophirah_Qquoteadv_Model_Qqadvhistory extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/history');
    }


	/**
	 * Add comment to the quote
	 * @param array $params array of field(s) to be inserted
	 * @return mixed
	 */
	public function addItem($params)
	{
		$this->setData($params)
		      ->save()
		      ;
		return $this;
	}

	/**
	 * Add comments to the quote
	 * @param array $params array of field(s) to be inserted
	 * @return mixed
	 */
	public function addItems($params){

	    foreach($params as $key=>$values)
	       if(!$this->_isDublicatedData($values))
	           $this->addItem($values);

	    return $this;
	}
}